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

<div class="container-fluid">

    <!-- Content Display Area -->
    <div class="homeMain">
        <div class="container">
            <div  class="title">
                <h1>
                Website for Comparing Academic Influence
                </h1>
                <h3>
                An interactive web-based system for examining and comparing academic influence for Computing and Information School
                </h3>
            </div>
            <div>
                <a role="button" class="homeButton" href="school_cit.php">Go Compare</a>
            </div>
        </div>  
    </div>

    <!-- Shortcuts -->
    <div class="container-lg">
        <div class="row shortcut">
            <div class="col">
                <!-- icon -->
                <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-graph-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h1v16H0V0zm1 15h15v1H1v-1z"/>
                <path fill-rule="evenodd" d="M14.39 4.312L10.041 9.75 7 6.707l-3.646 3.647-.708-.708L7 5.293 9.959 8.25l3.65-4.563.781.624z"/>
                <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4h-3.5a.5.5 0 0 1-.5-.5z"/>
                <!-- intro -->
                <br>
                <br>
                <h2>
                    Compare
                </h2>
                <div>
                    Choose multiple attibutes to compare!
                </div>
                <br>
                <br>
                <div>
                    <a role="button" class="homeButton" href="school_cit.php">Go Compare</a>
                </div>

            </div>
            <div class="col">
                <!-- images -->
                <img src="./images/compare.jpg" class="d-block w-100" alt="Compare shortcut" />
            </div>
        </div>
        <div class="row shortcut">
            <div class="col">
                <!-- icon -->
                <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-people" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zm7.973.056v-.002.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                </svg>                
                <!-- intro -->
                <br>
                <br>
                <h2>
                    Faculty
                </h2>
                <div>
                    Choose multiple attibutes to compare!
                </div>
                <br>
                <br>
                <div>
                    <a role="button" class="homeButton" href="g_distribution.php">Go Compare</a>
                </div>

            </div>
            <div class="col">
                <!-- images -->
                <img src="./images/faculty.jpg" class="d-block w-100" alt="Faculty shortcut" />
            </div>
        </div>
        <div class="row shortcut">
            <div class="col">
                <!-- icon -->
                <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-building" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694L1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                </svg>
                <!-- intro -->
                <br>
                <br>
                <h2>
                    School
                </h2>
                <div>
                    Choose multiple attibutes to compare!
                </div>
                <br>
                <br>
                <div>
                    <a role="button" class="homeButton" href="school_cit.php">Go Compare</a>
                </div>

            </div>
            <div class="col">
                <!-- images -->
                <img src="./images/school.jpg" class="d-block w-100" alt="School shortcut" />
            </div>
        </div>
        <div class="row shortcut">
            <div class="col">
                <!-- icon -->
                <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-book" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M3.214 1.072C4.813.752 6.916.71 8.354 2.146A.5.5 0 0 1 8.5 2.5v11a.5.5 0 0 1-.854.354c-.843-.844-2.115-1.059-3.47-.92-1.344.14-2.66.617-3.452 1.013A.5.5 0 0 1 0 13.5v-11a.5.5 0 0 1 .276-.447L.5 2.5l-.224-.447.002-.001.004-.002.013-.006a5.017 5.017 0 0 1 .22-.103 12.958 12.958 0 0 1 2.7-.869zM1 2.82v9.908c.846-.343 1.944-.672 3.074-.788 1.143-.118 2.387-.023 3.426.56V2.718c-1.063-.929-2.631-.956-4.09-.664A11.958 11.958 0 0 0 1 2.82z"/>
                <path fill-rule="evenodd" d="M12.786 1.072C11.188.752 9.084.71 7.646 2.146A.5.5 0 0 0 7.5 2.5v11a.5.5 0 0 0 .854.354c.843-.844 2.115-1.059 3.47-.92 1.344.14 2.66.617 3.452 1.013A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.276-.447L15.5 2.5l.224-.447-.002-.001-.004-.002-.013-.006-.047-.023a12.582 12.582 0 0 0-.799-.34 12.96 12.96 0 0 0-2.073-.609zM15 2.82v9.908c-.846-.343-1.944-.672-3.074-.788-1.143-.118-2.387-.023-3.426.56V2.718c1.063-.929 2.631-.956 4.09-.664A11.956 11.956 0 0 1 15 2.82z"/>
                </svg>
                <!-- intro -->
                <br>
                <br>
                <h2>
                    Department
                </h2>
                <div>
                    Choose multiple attibutes to compare!
                </div>
                <br>
                <br>
                <div>
                    <a role="button" class="homeButton" href="department_cit.php">Go Compare</a>
                </div>

            </div>
            <div class="col">
                <!-- images -->
                <img src="./images/department.jpg" class="d-block w-100" alt="Department shortcut" />
            </div>
        </div>
    </div>
</div>