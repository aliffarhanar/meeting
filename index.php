<?php
	session_start();
	if(!isset($_SESSION['login_user'])){
		header("location:login.php");
	}
	include_once "inc/config.php";
?>
<html>
<head>
	<title>Meeting Room</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/bootstrap-min.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/bootstrap-timepicker.css">
	<link rel="stylesheet" href="css/style.css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.css"/>

	<!-- jQuery -->
	<script src="js/jquery.js"></script>

	<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"   integrity="sha256-xI/qyl9vpwWFOXz7+x/9WkG5j/SVnSw21viy8fWwbeE="   crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-select.js"></script>
	<script src="js/bootstrap-timepicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(function () {
				var dateNow = new Date();
				$('#datepicker').datetimepicker({
					defaultDate:dateNow,
					format: 'DD-MM-YYYY'
				});
				$('#timepicker_start').timepicker();
				$('#timepicker_end').timepicker();
			});
		});
	</script>
</head>
<body>
	<link rel='stylesheet' href="vendor/nprogress/nprogress.css"/>
	<script src="vendor/nprogress/nprogress.js"></script>
	<script>
		$('body').show();
		NProgress.start();
		NProgress.set(0.4);
		NProgress.inc();
		jQuery(window).load(function () {
			NProgress.done();
		});
	  </script>
	<style type="text/css">
		.list-sidebar-menu li {
			border-bottom: 1px solid rgba(224, 230, 235, 1);
		}
		.list-sidebar-menu li a {
			color: #848484;
			font-family: -webkit-body;
			font-weight: bolder;
		}
		.list-sidebar-menu li.active {
			background-color: #dce3e8;
		}
	</style>
	<nav class="navbar navbar-default" style="margin-right: -1.15% !important;">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#"><img src="images/logo-title.png" width="200px"></a>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
						<?php
						$jum = 0;
						$notif_booking = "";
						if ($_SESSION['role'] == "admin") {
							$notif_user = "";
							$data = array("ql" => "select * where approved = 'pending'");
								//reading data ruangan
							$pics = $client->get_collection('picruangans',$data);
							while ($pics->has_next_entity()) {
								$pic = $pics->get_next_entity();
								$notif_user .= '
									<li>
										<a href="?page=user-management">
											<span class="glyphicon glyphicon-user" style="color: grey;"></span>
											&nbsp;'.$pic->get('name').' meminta permintaan PIC ruangan
										</a>
									</li>
									<li role="separator" class="divider"></li>
								';
								$jum++;
							}
						}

						$data = array("ql" => "select * where approved = 'pending'");
							//reading data ruangan
						$books = $client->get_collection('bookings',$data);
						while ($books->has_next_entity()) {
							$book = $books->get_next_entity();
							$data_r = array("ql" => "select * where uuid = '".$book->get('ruangan')."'");
								//reading data ruangan
							$ruangans = $client->get_collection('ruangans',$data_r);
							$ruangan = $ruangans->get_next_entity();
							if (@$_SESSION['pic']) if(in_array(@$ruangan->get('name'), @$_SESSION['pic'])){
								$notif_booking .= '
									<li>
										<a href="?page=room-request-staff">
											<span class="glyphicon glyphicon-calendar" style="color: grey;"></span>
											&nbsp;'.$book->get('name').' meminta booking ruangan.
										</a>
									</li>
									<li role="separator" class="divider"></li>
								';
								$jum++;
							}
						}
						?>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
						<span class="glyphicon glyphicon-bell" style="color: white;"></span>
						<span class="badge" style="top: 5px; padding: 2px 4px; right: 10px; position: absolute; background-color: #C91F2C;"><?php echo $jum;?></span>
					</a>
					<ul class="dropdown-menu">
						<?php
							echo $notif_booking;
							echo $_SESSION['role'] == "admin"?$notif_user:'';
						?>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: white;"><?php echo $_SESSION['name'];?> <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="?page=profile"><i class="fa fa-user"></i> Edit Profile</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
	<div class="row" style="background-image:url('images/bg-putih.png');height: 135%;margin-bottom:100px;">
		<div class="col-sm-2 col-md-2 sidebar-offcanvas" style=" background-color: rgba(255, 255, 255, 0.5); height: 100%;padding-right: 0;" id="sidebar-wrapper" role="navigation">
			<ul class="nav nav-sidebar list-sidebar-menu">
				<?php
					if($_SESSION['role'] == "admin"){
						$page = "room-request-staff";
				?>
						<li class="<?=!isset($_GET['page'])||$_GET['page']=='find-room'?'active':''?>"><a style="text-align: right; font-family: inherit;" href="?page=find-room">Manage Building & Room </a></li>
						<li class="<?=isset($_GET['page'])&&$_GET['page']=='history-admin'?'active':''?>"><a style="text-align: right; font-family: inherit;" href="?page=history-admin">History</a></li>
						<li class="<?=isset($_GET['page'])&&$_GET['page']=='room-request-staff'?'active':''?>"><a style="text-align: right; font-family: inherit;" href="?page=room-request-staff">Room Request </a></li>
						<li class="<?=isset($_GET['page'])&&$_GET['page']=='user-management'?'active':''?>"><a style="text-align: right; font-family: inherit;" href="?page=user-management">User Management </a></li>
						<li class=""><a style="text-align: right; font-family: inherit;" href="#">Settings </a></li>
				<?php
					}else if($_SESSION['role'] == "staff"){
						$page = "dashboard";
				?>
						<li class="<?=!isset($_GET['page'])||$_GET['page']=='find-room'?'active':''?>"><a style="text-align: right; font-family: inherit;" href="?page=find-room">Find Room </a></li>
						<li class="<?=isset($_GET['page'])&&$_GET['page']=='history'?'active':''?>"><a style="text-align: right; font-family: inherit;" href="?page=history">History</a></li>
						<li class="<?=isset($_GET['page'])&&$_GET['page']=='room-request-staff'?'active':''?>"><a style="text-align: right; font-family: inherit;" href="?page=room-request-staff">Room Request </a></li>
						<li class="<?=isset($_GET['page'])&&$_GET['page']=='settings'?'active':''?>"><a style="text-align: right; font-family: inherit;" href="#">Settings </a></li>
				<?php
					} else {
						$page = "dashboard";
				?>
						<li class="<?=!isset($_GET['page'])||$_GET['page']=='find-room'?'active':''?>"><a style="text-align: right; font-family: inherit;" href="?page=find-room">Find Room </a></li>
						<li class="<?=isset($_GET['page'])&&$_GET['page']=='history'?'active':''?>"><a style="text-align: right; font-family: inherit;" href="?page=history">History</a></li>
				<?php
					}
				?>
			</ul>
		</div>

		<div class="col-md-10">
			<?php

			if(isset($_GET['page'])) $page = $_GET['page'];

			switch($page) {
				case "dashboard":$include = "find-room.php";break;
				case "profile":$include = "edit-profile.php";break;
				case "history":$include = "history.php";break;
				case "history-admin":$include = "history_admin.php";break;
				case "edit-request":$include = "edit_request.php";break;
				case "find-room":$include = "find-room.php";break;
				case "edit-request-staff":$include = "edit-request-staff.php";break;
				case "room-request-staff":$include = "room-request-staff.php";break;
				case "user-management":$include = "user-management.php";break;
				case "edit-role":$include = "edit-role.php";break;
				case "user-booking":$include = "user-booking.php";break;
				case "detail-request":$include = "detail-request.php";break;
				default : $include = "find-room.php";
			}
			include_once $include;
			?>
		</div>
	</div>
</body>

</html>
