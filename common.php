<?php
// ini_set('display_errors','Off');
// ini_set('error_reporting',0);

$settings = array(
					'db_host' 		=> 'localhost',
					'db_name' 		=> 'prmhal',
					'db_user' 		=> 'root',
					'db_password' 	=> '',
				);

require('partials/PDOext.class.php');

// Database Connection
$pass = 'mysql:host=' . $settings['db_host'] . ';dbname=' . $settings['db_name'];
$dbh = new PDOext($pass, $settings['db_user'], $settings['db_password'],[PDO::MYSQL_ATTR_LOCAL_INFILE => true]);
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
