<?php
//Connect with database
$link = mysqli_connect('host','user name','','database name');
	if(!$link){
		echo 'Error:'.mysqli_connect_error();
		die();
	}



	
