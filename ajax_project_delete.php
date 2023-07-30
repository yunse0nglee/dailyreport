<?php 

	$conn = mysqli_connect('localhost', 'root', '!Wpghqk@', 'jehovah_dailyreport');
	mysqli_set_charset($conn,"utf8");	

	$code = $_POST['code'];

	$sql= "DELETE FROM project_list WHERE code='".$code."'";			
	mysqli_query($conn, $sql);	


	echo '프로젝트가 삭제 되었습니다';
?>