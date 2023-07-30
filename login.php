<?php
    include('dbcon.php'); 
    include('check.php');

    if(is_login()){

        if ($_SESSION['user_id'] == 'admin' && $_SESSION['is_admin']==1)
            //header("Location: admin.php");
            header("Location: index.php");
        else 
            header("Location: index.php");
    }

?>



<html lang="en">
	<!--begin::Head-->
	<head>
		<meta charset="utf-8" />
		<title>Jehovah | 작업일보 시스템 로그인</title>
		<meta name="description" content="Login page example" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="https://keenthemes.com/metronic" />
	


		<style>
            @font-face {
            font-family: 'MinSans-Medium';
            src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_2201-2@1.0/MinSans-Medium.woff') format('woff');
            font-weight: normal;
            font-style: normal; }
            *{ font-family: 'MinSans-Medium';}

            .menu-text{
                font-size:15px !important;
            }
        </style>
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Custom Styles(used by this page)-->
		<link href="assets/css/pages/login/classic/login-4.css" rel="stylesheet" type="text/css" />
		<!--end::Page Custom Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		<link rel="icon" type="image/png" sizes="16x16" href="./assets/images/favicon-16x16.png">
				
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Login-->
			<div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
				<div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url('assets/media/bg/bg-3.jpg');">
					<div class="login-form text-center p-7 position-relative overflow-hidden">
						<!--begin::Login Header-->
						<div class="d-flex flex-center mb-15">
							<a href="#">
								<img src="assets/images/logo.png" class="max-h-75px" alt="" />
							</a>
						</div>
						<!--end::Login Header-->
						<!--begin::Login Sign in form-->
						<div class="login-signin">
							<div class="mb-20">
								<h3>제호바 스마트 작업일보 시스템</h3>
								<div class="text-muted font-weight-bold">SMART WORK DAILY REPORT SYSTEM </div>
							</div>
							<form class="form" method="post">
								<div class="form-group mb-5">
									<input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="id" name="user_name" autocomplete="off" />									
								</div>
								<div class="form-group mb-5">
									<input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Password" name="user_password" />									
								</div>
								<div class="form-group d-flex flex-wrap justify-content-between align-items-center">
									<div class="checkbox-inline">
										<label class="checkbox m-0 text-muted">
										<input type="checkbox" name="remember" />
										<span></span>Remember me</label>
									</div>
									<a href="javascript:;" id="kt_login_forgot" class="text-muted text-hover-primary">Forget Password ?</a>
								</div>
								<!-- <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Sign In</button> -->
								<button type="submit" name="login" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">로그인</button>
							</form>
							
						</div>
						<!--end::Login Sign in form-->
					
					</div>
				</div>
			</div>
			<!--end::Login-->
		</div>
		<!--end::Main-->		
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Scripts(used by this page)-->
		<script src="assets/js/pages/custom/login/login-general.js"></script>
		<!--end::Page Scripts-->
	</body>
	<!--end::Body-->
</html>



<?php

	$login_ok = false;

	if ( ($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['login']) )
	{
			$username=$_POST['user_name'];  
			$userpassowrd=$_POST['user_password'];  

			if(empty($username)){
				$errMSG = "아이디를 입력하세요.";
			}else if(empty($userpassowrd)){
				$errMSG = "패스워드를 입력하세요.";
			}else{
				

				try { 

					$stmt = $con->prepare('select * from users where username=:username');

					$stmt->bindParam(':username', $username);
					$stmt->execute();
				
				} catch(PDOException $e) {
					die("Database error. " . $e->getMessage()); 
				}

				$row = $stmt->fetch();  
				$salt = $row['salt'];
				$password = $row['password'];
				
				$decrypted_password = decrypt(base64_decode($password), $salt);

				if ( $userpassowrd == $decrypted_password) {
					$login_ok = true;
				}
			}

			
			if(isset($errMSG)) 
				echo "<script>alert('$errMSG')</script>";
			

			if ($login_ok){

				if ($row['activate']==0)
					echo "<script>alert('$username 계정 활성이 안되었습니다. 관리자에게 문의하세요.')</script>";
				elseif(strtotime($row['end_date']) < strtotime(date('Y-m-d')))
					echo "<script>alert('이용기간이 만료 되었습니다. 관리자에게 문의하세요.')</script>";
				else{

						@session_regenerate_id();
						$_SESSION['user_id'] = $username;
						$_SESSION['is_admin'] = $row['is_admin'];
						$_SESSION['name'] = $row['userprofile'];

						echo "<script>location.reload();</script>";
						if ($username=='admin' && $row['is_admin']==1 )
							//header('location:admin.php');
							header('location:index.php');
						else
							header('location:index.php');
						session_write_close();
				}
			}
			else{
				echo "<script>alert('ID 또는 비밀번호가 올바르지 않습니다.')</script>";
			}
	}
?>