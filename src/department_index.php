<?Php
    session_start();
    include_once('dbcon.php');
    include_once('header.php');
    
    $stmt=$dbcon->prepare("SELECT `Department`.`title`,AVG(`h_index`) as h_index, AVG(`i10_index`) as i_index
    FROM Faculty,`Faculty-Department`,Department
    WHERE `Faculty`.`f_id` = `Faculty-Department`.`f-id`
          AND `Department`.`d-id` = `Faculty-Department`.`d-id`
    GROUP BY `Faculty-Department`.`d-id`");
    $stmt->execute();
    $jsonName=[];
    $jsonH=[];
    $jsonI=[];
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $jsonName[]=$title;
        $jsonH[]=(int)$h_index;
        $jsonI[]=(int)$i_index;
    }
    // echo json_encode($jsonName);
    // echo json_encode($jsonCitation);
    include_once('footer.php');
?>

    <div class="container-fluid my-2">
    <div class="row justify-content-around">

        <!-- Secondary Navbar -->
        <div class="col-md-3">
            <nav class="navbar navbar-light bg-light sticky-top">
                <nav class="nav nav-pills flex-column">
                    <a class="nav-link" href="#" role="tab">
                        <b>By School</b>
                    </a>
                        <nav class="nav nav-pills flex-column">
                            <a class="nav-link ml-3 my-1 active" id="a-tab" href="school_cit.php" role="tab"
                                aria-controls="b" aria-selected="false">Citations</a>
                            <a class="nav-link ml-3 my-1" id="b-tab" href="school_index.php" role="tab"
                                aria-controls="b" aria-selected="false">h-index & i10-index</a>
                            <a class="nav-link ml-3 my-1" id="b-tab" href="school_pub.php" role="tab"
                                aria-controls="b" aria-selected="false">first publication year</a>
                        </nav>
                        <a class="nav-link" href="#" role="tab">
                        <b>By Department</b>
                    </a>
                        <nav class="nav nav-pills flex-column">
                            <a class="nav-link ml-3 my-1" id="a-tab" href="department_cit.php" role="tab"
                                aria-controls="a" aria-selected="true">Citations</a>
                            <a class="nav-link ml-3 my-1 active" id="b-tab" href="department_index.php" role="tab"
                                aria-controls="b" aria-selected="false">h-index & i10-index</a>
                            <a class="nav-link ml-3 my-1" id="b-tab" href="department_pub.php" role="tab"
                                aria-controls="b" aria-selected="false">first publication year</a>
                        </nav>
                </nav>
            </nav>
        </div>

        <!-- Content Display Area -->
        <div class="col-md-9">
            <div class="jumbotron">
                <h3>h Index & i10 Index Comparison By Department </h1>
                
                <dr>
                <dr>
                <dr>
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <br> 
                            <canvas id="myChart"></canvas>
                            <br> 
                            <?php
                            $sql = "SELECT `Department`.`title`,AVG(`h_index`) as h_index, AVG(`i10_index`) as i_index
                            FROM Faculty,`Faculty-Department`,Department
                            WHERE `Faculty`.`f_id` = `Faculty-Department`.`f-id`
                                  AND `Department`.`d-id` = `Faculty-Department`.`d-id`
                            GROUP BY `Faculty-Department`.`d-id`";
                            $result = $dbcon->query($sql);
                            echo "<table>
                                  <tr><th>School</th><th>Average h_index</th><th>Average i10_index</th>
                                  </tr>";
                            // output data of each row
                            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr><td>" . $row["title"]. "</td>". 
                                        "<td>" . $row["h_index"]. "</td>".
                                        "<td>" . $row["i_index"]. "</td></tr>"
                                ;
                            }
                            echo "</table>";
                            ?>

                        </div>
                        <div class="col-6 col-md-3"></div>
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
            type: 'bar',

            // The data for our dataset
            data: {
                labels: <?php echo json_encode($jsonName); ?>,
                datasets: [{
                    label: 'Average h-index',
                    backgroundColor: '#99ccff',
                    borderColor: 'rgb(255, 99, 132)',
                    stack: 'Stack 0',
                    data:<?php echo json_encode($jsonH); ?>
                    },
                    {
                    label: 'Average i10-index',
                    backgroundColor: '#70dbdb',
                    borderColor: 'rgb(255, 99, 132)',
                    stack: 'Stack 1',
                    data:<?php echo json_encode($jsonI);  ?>
                    }
                ]
            },
            // Configuration options go here
            options: {}
        });
    </script> 



