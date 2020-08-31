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
                    <h1>Update Records</h1>
                </div>
                <?php
                // get passed parameter value, in this case, the record ID
                // isset() is a PHP function used to verify if a value is there or not
                $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
                
                //include database connection
                include 'dbcon.php';
                
                // read current record's data
                try {
                    // prepare select query
                    $query = "SELECT name, gender, citation, h_index, i10_index, first_pub FROM Faculty WHERE f_id = ? LIMIT 0,1";
                    $stmt = $dbcon->prepare( $query );
                    
                    // this is the first question mark
                    $stmt->bindParam(1, $id);
                    
                    // execute our query
                    $stmt->execute();
                    
                    // store retrieved row to a variable
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    // values to fill up our form
                    $name = $row['name'];
                    $gender = $row['gender'];
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
                <!-- PHP post to update record will be here -->
                <?php
                
                // check if form was submitted
                if($_POST){
                    
                    try{
                    
                        // write update query
                        // in this case, it seemed like we have so many fields to pass and 
                        // it is better to label them and not use question marks
                        $query = "UPDATE Faculty 
                                    SET name=:name, gender=:gender, citation=:citation, h_index=:h_index
                                                    , i10_index=:i10_index, first_pub=:first_pub
                                    WHERE f_id = :f_id";
                
                        // prepare query for excecution
                        $stmt = $dbcon->prepare($query);
                
                        // posted values
                        $name=htmlspecialchars(strip_tags($_POST['name']));
                        $gender=htmlspecialchars(strip_tags($_POST['gender']));
                        $citation=htmlspecialchars(strip_tags($_POST['citation']));
                        $h_index=htmlspecialchars(strip_tags($_POST['h_index']));
                        $i10_index=htmlspecialchars(strip_tags($_POST['i10_index']));
                        $first_pub=htmlspecialchars(strip_tags($_POST['first_pub']));
                
                        // bind the parameters
                        $stmt->bindParam(':name', $name);
                        $stmt->bindParam(':gender', $gender);
                        $stmt->bindParam(':citation', $citation);
                        $stmt->bindParam(':h_index', $h_index);
                        $stmt->bindParam(':i10_index', $i10_index);
                        $stmt->bindParam(':first_pub', $first_pub);
                        $stmt->bindParam(':f_id', $id);
                        
                        // Execute the query
                        if($stmt->execute()){
                            echo "<div class='alert alert-success'>Record was updated.</div>";
                        }else{
                            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                        }
                        
                    }
                    
                    // show errors
                    catch(PDOException $exception){
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
                ?>
                <!--we have our html form here where new record information can be updated-->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
                    <table class='table table-hover table-responsive table-bordered'>
                        <tr>
                            <td>Name</td>
                            <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
                        </tr>
                        <tr>
                            <td>gender</td>
                            <td><textarea name='gender' class='form-control'><?php echo htmlspecialchars($gender, ENT_QUOTES);  ?></textarea></td>
                        </tr>
                        <tr>
                            <td>citation</td>
                            <td><input type='text' name='citation' value="<?php echo htmlspecialchars($citation, ENT_QUOTES);  ?>" class='form-control' /></td>
                        </tr>
                        <tr>
                            <td>h_index</td>
                            <td><input type='text' name='h_index' value="<?php echo htmlspecialchars($h_index, ENT_QUOTES);  ?>" class='form-control' /></td>
                        </tr>
                        <tr>
                            <td>i10_index</td>
                            <td><input type='text' name='i10_index' value="<?php echo htmlspecialchars($i10_index, ENT_QUOTES);  ?>" class='form-control' /></td>
                        </tr>
                        <tr>
                            <td>first_pub</td>
                            <td><input type='text' name='first_pub' value="<?php echo htmlspecialchars($first_pub, ENT_QUOTES);  ?>" class='form-control' /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type='submit' value='Save Changes' class='btn btn-primary' />
                                <a href='faculty.php' class='btn btn-danger'>Back to records</a>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>          
        </div>
    </div>
    </div>
    



