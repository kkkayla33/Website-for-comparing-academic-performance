<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- import CSS -->
    <link rel="stylesheet" type="text/css" href="style.css" />
    <!-- import Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
    <!-- import Chart js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"> -->
    <title>faculty</title>
</head>
<body>
    <!-- navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="mainMenu"> 

        <!-- Navigation List -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="nav navbar-nav" >
                <li class="nav-item dropdown mx-3">
                    <a class="nav-link " href="index.php" role="button" aria-expanded="false" style="color:white;font-weight:bold;font-size:20px;">
                        Home
                    </a>
                </li>
                <li class="nav-item dropdown mx-3">
                    <a class="nav-link dropdown-toggle" href="school_cit.php" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white;font-weight:bold;font-size:20px;">
                        Compare
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="school_cit.php">By School</a>
                        <a class="dropdown-item" href="department_cit.php">By Department</a>
                    </div>
                </li>
              <li class="nav-item dropdown mx-3">
                    <a class="nav-link" href="faculty.php" role="button" aria-haspopup="true" aria-expanded="false" style="color:white;font-weight:bold;font-size:20px;">
                        Faculty
                    </a>
                </li>
                <li class="nav-item dropdown mx-3">
                    <a class="nav-link" href="school_cit.php" role="button" aria-haspopup="true" aria-expanded="false" style="color:white;font-weight:bold;font-size:20px;">
                        School
                    </a>
                </li>
                <li class="nav-item dropdown mx-3">
                    <a class="nav-link" href="department_cit.php" role="button" aria-haspopup="true" aria-expanded="false" style="color:white;font-weight:bold;font-size:20px;">
                        Department
                    </a>
                </li>
            </ul>
        </div>
    </nav>