<?Php
    session_start();
    include_once('dbcon.php');
    include_once('header.php');

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
            <form action="search.php" method="GET">
                Faculty Name: <input type="text" name="searchName" onkeydown="Search(this.value)" />
                <a href='faculty.php' class='btn btn-primary m-r-1em'>Clear Search</a>
            </form>

            <?php
            // include database connection
            include 'dbcon.php';
            
            $searchName =$_POST['searchName'];
            // page is the current page, if there's nothing set, default is page 1
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            
            // set records or rows of data per page
            $records_per_page = 8;
            
            // calculate for the query LIMIT clause
            $from_record_num = ($records_per_page * $page) - $records_per_page;
            
            // delete message prompt will be here
            $action = isset($_GET['action']) ? $_GET['action'] : "";
 
            // if it was redirected from delete.php
            if($action=='deleted'){
                echo "<div class='alert alert-success'>Record was deleted.</div>";
            }
            
            // select all data
            $query = "SELECT f_id, name, Department.title as department, citation, h_index, i10_index, first_pub,  Department.title as department FROM Faculty, Department, `Faculty-Department` 
                    WHERE Faculty.f_id = `Faculty-Department`.`f-id` AND `Faculty-Department`.`d-id` = Department.`d-id` AND Faculty.name LIKE '%".$searchName."%'
                    ORDER BY f_id ASC 
                        LIMIT :from_record_num, :records_per_page";
            $stmt = $dbcon->prepare($query);
            $stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
            $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
            $stmt->execute();   
            // this is how to get number of rows returned
            $num = $stmt->rowCount();
              
            //check if more than 0 record found
            if($num>0){
                echo "<table class='table table-hover table-responsive table-bordered'>";//start table
            
                //creating our table heading
                echo "<tr>";
                    echo "<th>Name</th>";
                    echo "<th>Department</th>";
                    echo "<th>Citation</th>";
                    echo "<th>h index</th>";
                    echo "<th>i10 index</th>";
                    echo "<th>first publish year</th>";
                    echo "<th>Action</th>";
                echo "</tr>";
                
                // table body will be here
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    // extract row
                    // this will make $row['firstname'] to
                    // just $firstname only
                    extract($row);
                    
                    // creating new table row per record
                    echo "<tr>";
                        echo "<td>{$name}</td>";
                        echo "<td>{$department}</td>";
                        echo "<td>{$citation}</td>";
                        echo "<td>{$h_index}</td>";
                        echo "<td>{$i10_index}</td>";
                        echo "<td>{$first_pub}</td>";
                        echo "<td>";
                            // read one record 
                            echo "<a href='read_one.php?id={$f_id}' class='btn btn-info m-r-1em'>Detail</a>";
                            
                            // we will use this links on next part of this post
                            echo "<a href='update.php?id={$f_id}' class='btn btn-primary m-r-1em'>Edit</a>";
                
                            // we will use this links on next part of this post
                            echo "<a href='#' onclick='delete_user({$f_id});' class='btn btn-danger'>Delete</a>";
                        echo "</td>";
                    echo "</tr>";
                }
                
            // end table
            echo "</table>";
            // PAGINATION
            // count total number of rows
            $query = "SELECT COUNT(*) as total_rows FROM Faculty";
            $stmt = $dbcon->prepare($query);
            
            // execute query
            $stmt->execute();
            
            // get total rows
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_rows = $row['total_rows'];
            }

            // paginate records
            $page_url="faculty.php?";
            include_once "faculty/paging.php";
            
            // // if no records found
            // else{
            //     echo "<div class='alert alert-danger'>No records found.</div>";
            // }

            ?>
            <style>
            .m-r-1em{ margin-right:1em; }
            .m-b-1em{ margin-bottom:1em; }
            .m-l-1em{ margin-left:1em; }
            .mt0{ margin-top:0; }
            </style>
            </div>          
        </div>
    </div>
    </div>
    <script type='text/javascript'>
        // confirm record deletion
        function delete_user( id ){
                    
                    var answer = confirm('Are you sure you want to delete?');
                    if (answer){
                        // if user clicked ok, 
                        // pass the id to delete.php and execute the delete query
                        window.location = 'delete.php?id=' + id;
                    } 
        }

        function Search(value){
        $.ajax({
            url: 'search.php',
            data:{searchName:value},
            success: function(data) {
                console.log(data)
            },
            type: 'POST'
        });
        }
    </script>
    <script type="text/javascript">
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'bar',

            // The data for our dataset
            data: {
                labels: ['citation', 'h-index', 'i10-index', 'first publish year'],
                datasets: [{
                    label: '123',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: <?php echo json_encode($jsonCitation); ?>
                }]
            },
            // Configuration options go here
            options: {}
        });
    </script> 



