<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; 
    charset=UTF-8" />
<title>jehovah Admin</title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

 <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
</head>

<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="./index.php"><img src='assets/images/logo.jpg' style="height: 20px"></a>
			<ul class="nav navbar-nav">
            <li class="active"><a href="./admin.php">관리자 메인</a></li>
            <?php if (isset($_SESSION['user_id'])) { ?>
                <li><a href="./regist.php">사용자 추가</a></li>                
                <li><a href="logout.php">Log Out</a></li>
                <li><a href="#"><?php echo $_SESSION['user_id']; ?>님 반갑습니다.</a></li>
            <?php } else { ?>
                <li><a href="index.php">Login</a></li>
             <?php } ?>
			</ul>
        </div>
    </div>
</nav>