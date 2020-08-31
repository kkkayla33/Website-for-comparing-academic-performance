<?Php
    session_start();
    include_once('dbcon.php');
    include_once('header.php');
    
    $stmt=$dbcon->prepare("SELECT * FROM Faculty");
    $stmt->execute();
    $jsonName=[];
    $jsonCitation=[];
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $jsonName[]=$name;
        $jsonCitation[]=(int)$citation;
    }
    // echo json_encode($jsonName);
    // echo json_encode($jsonCitation);

    $sql_avgCitation_school=$dbcon->prepare("SELECT `School`.`title`,AVG(citation)
    FROM Faculty,`Faculty-School`,School
    WHERE `Faculty`.`f-id` = `Faculty-School`.`f-id`
          AND `School`.`s-id` = `Faculty-School`.`s-id`
    GROUP BY `Faculty-School`.`s-id`");
    $stmt->execute();
    $school_name=[];
    $avgCitation=[];
    while($row=$sql_avgCitation_school->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $school_name[]=$title;
        $avgCitation[]=(int)$citation;
    }

?>

<div class="container-fluid my-2">
    <div class="row justify-content-around">

        <!-- Secondary Navbar -->
        <div class="col-md-3">
            <nav class="navbar navbar-light bg-light sticky-top">
                <nav class="nav nav-pills flex-column">
                    <a class="nav-link" href="#" role="tab" >
                        <b>Data Distribution</b>
                    </a>
                        <nav class="nav nav-pills flex-column"> 
                            <a class="nav-link ml-3 my-1 active" id="school_cit" data-toggle="pill" href="g_distribution.php" role="tab"
                                aria-controls="b" aria-selected="false">Gender</a>
                            <a class="nav-link ml-3 my-1" id="school_index" href="s_distribution.php" role="tab"
                                aria-controls="b" aria-selected="false">School</a>
                            <a class="nav-link ml-3 my-1" id="school_pub" href="d_distribution.php" role="tab"
                                aria-controls="b" aria-selected="false">Department</a>
                                <a class="nav-link ml-3 my-1" id="school_cit" data-toggle="pill" href="faculty_cit.php" role="tab"
                                aria-controls="b" aria-selected="false">Citation</a>
                            <a class="nav-link ml-3 my-1" id="school_index" href="faculty_h.php" role="tab"
                                aria-controls="b" aria-selected="false">h-index</a>
                            <a class="nav-link ml-3 my-1" id="school_pub" href="faculty_i10.php" role="tab"
                                aria-controls="b" aria-selected="false">i10_index</a>
                        </nav>
                    <a class="nav-link" href="#" role="tab" >
                        <b>Faculty Information</b>
                    </a>
                        <nav class="nav nav-pills flex-column"> 
                            <a class="nav-link ml-3 my-1 active" id="school_cit" data-toggle="pill" href="faculty.php" role="tab"
                                aria-controls="b" aria-selected="false">Faculty Information</a>
                        </nav>
                </nav>
            </nav>
        </div>

        <!-- Content Display Area -->
        <div class="col-md-9">
            <div class="jumbotron">
                <div class="page-header">
                    <h1>Read Records</h1>
                </div>
                <!-- PHP read one record will be here -->
                <?php
                // get passed parameter value, in this case, the record ID
                // isset() is a PHP function used to verify if a value is there or not
                $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
                
                //include database connection
                include 'dbcon.php';
                
                // read current record's data
                try {
                    // prepare select query
                    $query = "SELECT name, link, gender, citation, h_index, i10_index, first_pub,  Department.title as department, School.title as school,Job.title as job
                    FROM Faculty, School, Department, `Faculty-School`,`Faculty-Department`,`Faculty-Job`,Job
                    WHERE Faculty.f_id = ? AND `Faculty-School`.`f-id` = ? AND `Faculty-Department`.`f-id` = ? AND `Faculty-Job`.`f-id`= ? AND `Faculty-School`.`s-id` = School.`s-id` AND `Faculty-Department`.`d-id` = Department.`d-id` AND `Faculty-Job`.`j-id` = Job.`j-id` LIMIT 0,1";
                    $stmt = $dbcon->prepare( $query );
                
                    // this is the first question mark
                    $stmt->bindParam(1, $id);
                    $stmt->bindParam(2, $id);
                    $stmt->bindParam(3, $id);
                    $stmt->bindParam(4, $id);
                
                    // execute our query
                    $stmt->execute();
                
                    // store retrieved row to a variable
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // values to fill up our form
                    $name = $row['name'];
                    $gender = $row['gender'];
                    $link = $row['link'];
                    $school = $row['school'];
                    $department = $row['department'];
                    $job = $row['job'];
                    $citation = $row['citation'];
                    $h_index = $row['h_index'];
                    $i10_index = $row['i10_index'];
                    $first_pub = $row['first_pub'];
                }
                
                // show error
                catch(PDOException $exception){
                    die('ERROR: ' . $exception->getMessage());
                }
                ?>
                <!-- HTML read one record table will be here -->
                <!--we have our html table here where the record will be displayed-->
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Name</td>
                        <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>gender</td>
                        <td><?php echo htmlspecialchars($gender, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>link</td>
                        <td><?php echo htmlspecialchars($link, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>school</td>
                        <td><?php echo htmlspecialchars($school, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>department</td>
                        <td><?php echo htmlspecialchars($department, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>job</td>
                        <td><?php echo htmlspecialchars($job, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>citation</td>
                        <td><?php echo htmlspecialchars($citation, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>h_index</td>
                        <td><?php echo htmlspecialchars($h_index, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>i10_index</td>
                        <td><?php echo htmlspecialchars($i10_index, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>first_pub</td>
                        <td><?php echo htmlspecialchars($first_pub, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <a href='faculty.php' class='btn btn-danger'>Back to records</a>
                        </td>
                    </tr>
                </table>
            </div>          
        </div>
    </div>
    </div>
    



