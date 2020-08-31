<?Php
    $dbhost = '192.168.64.2';
    $dbname = 'Faculties';
    $dbuser = 'root';
    $dbpass = '';

    try{
        $dbcon = new PDO("mysql:host = {$dbhost};dbname={$dbname}",$dbuser,$dbpass);
        $dbcon->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $ex){
        die($ex ->getMessage());
    }

    // define('DB_SERVER', '192.168.64.2');
    // define('DB_USERNAME', 'root');
    // define('DB_PASSWORD', '');
    // define('DB_NAME', 'Faculties');
    
    /* Attempt to connect to MySQL database */
    // $linkmysql = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    // // Check connection
    // if($linkmysql === false){
    //     die("ERROR: Could not connect. " . mysqli_connect_error());
    // }

?>