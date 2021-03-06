<?Php
    session_start();
    include_once('dbcon.php');
    include_once('header.php');
    
    $stmt=$dbcon->prepare("SELECT `Faculty`.`gender`,COUNT(*) as num
    FROM Faculty
    GROUP BY `Faculty`.`gender`");
    $stmt->execute();
    $jsonName=[];
    $jsonNum=[];
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $jsonName[]=$gender;
        $jsonNum[]=(int)$num;
    }
    // echo json_encode($jsonName);
    // echo json_encode($jsonCitation);

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
                                aria-controls="b" aria-selected="false">h index</a>
                            <a class="nav-link ml-3 my-1" id="school_pub" href="faculty_i10.php" role="tab"
                                aria-controls="b" aria-selected="false">i10 index</a>
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
                <h3>Gender Distribution</h1>
                
                <dr>
                <dr>
                <dr>
                <div class="container">
                    <div class="row">
                        <div class="col-md-10">
                            <br>
                            <canvas id="myChart"></canvas>
                            <br> 
                            <?php
                            $sql = "SELECT `Faculty`.`gender`,COUNT(*) as num
                            FROM Faculty
                            GROUP BY `Faculty`.`gender`";
                            $result = $dbcon->query($sql);
                            echo "<table>
                                  <tr><th>Gender</th><th>Data Volumn</th>
                                  </tr>";
                            // output data of each row
                            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr><td>" . $row["gender"]. "</td>". 
                                        "<td>" . $row["num"]. "</td></tr>"
                                ;
                            }
                            echo "</table>";
                            ?>
                        
                        </div>
                        <div class="col-6 col-md-2">
                            
                        </div>
                    </div>
                    
                </div>

            </div>
            
            
        </div>
    </div>
    </div>

    <script type="text/javascript">
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'pie',

            // The data for our dataset
            data: {
                labels: <?php echo json_encode($jsonName); ?>,
                datasets: [{
                    label: ['female','male'],
                    backgroundColor:['rgb(255, 99, 132)','#99ccff'],
                    borderColor: 'white',
                    data: <?php echo json_encode($jsonNum); ?>
                }]
            },
            // Configuration options go here
            options: {}
        });
    </script> 



