<?php 

	$conn = mysqli_connect('localhost', 'root', '!Wpghqk@', 'jehovah_dailyreport');
	mysqli_set_charset($conn,"utf8");	

	$op_active = $_POST['op_active'];
	$id = $_POST['name'];

	// $sql= "UPDATE project_list SET active=NULL";			
	// mysqli_query($conn, $sql);	

	$sql= "UPDATE users SET active_pj='".$op_active."' where username='".$id."'";			
	mysqli_query($conn, $sql);	

	echo '프로젝트가 적용 되었습니다';
	
?>