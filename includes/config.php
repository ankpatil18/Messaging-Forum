<?php
ob_start();
session_start();

//set timezone
date_default_timezone_set('America/New_York');

//database credentials
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','project_work');

//application address
define('DIR','http://gmail.com/');
define('localpath','http://localhost/project-master/');
define('SITEEMAIL','ankurpatil23@gmail.com');

try {

	//create PDO connection
	$db = new PDO("mysql:host=".DBHOST.";port=3306;dbname=".DBNAME, DBUSER, DBPASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}

//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');
$user = new User($db);
?>
