<?php
	session_start();
	include_once "inc/config.php";
	if(isset($_SESSION['login_user'])){
		header("location:index.php");
	}
	if(isset($_POST['login'])){
		if($_POST['username'] == "admin" AND $_POST['password'] == "admin"){
			$_SESSION['login_user'] = "login";
			$_SESSION['name'] = "Admin";
			$_SESSION['role'] = "admin";
			$_SESSION['id'] = "admin";
			$_SESSION['password'] = "admin";
			$_SESSION['phone'] = "admin";
			$_SESSION['email'] = "admin";
			header("location:index.php");			
		}else{
			$query = array("ql" => "select * where id='".$_POST['username']."' AND password ='".$_POST['password']."'");
			$users = $client->get_collection('picruangans',$query);
			if($users->has_next_entity()){
				$user = $users->get_next_entity();
				$_SESSION['login_user'] = "login";
				$_SESSION['name'] = $user->get('name');
				$_SESSION['role'] = $user->get('role');	
				$_SESSION['id'] =$user->get('id');	
				$_SESSION['password'] = $user->get('password');	
				$_SESSION['phone'] = $user->get('phone');	
				$_SESSION['email'] = $user->get('email');	
				header("location:index.php");			
			}else{
				echo "<script>alert('Username atau password salah')</script>";
			}
		}
	}
?>
<html>
<head>
	<title>Meeting Room</title>		
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/bootstrap-min.css">
	<link rel="stylesheet" href="css/style.css">	
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
</head>
<body>
<div class="col-md-7 col-md-offset-2" style="margin-top:10%;opacity:1">	
	<div class="frm-login col-md-offset-2">
		<div class="frm-title">
			<img src="images/logo-title.png" width="200px">
		</div>
		<?php
			if(isset($_POST['register'])){
				$id = $_POST['id'];
				$password = $_POST['password'];
				$name = $_POST['name'];
				$phone = $_POST['phone'];
				$email = $_POST['email'];
				$pic=array();
				for($i=0;$i<count($_POST['room']);$i++){
					if(isset($_POST['room'][$i])){
						array_push($pic,$_POST['room'][$i]);
					}
				}
				$body = array(
					"id" => $id,
					"password" => $password,
					"name" => $name,
					"phone" => $phone,
					"email" => $email,
					"role" => "staff",
					"pic" => $pic,
					"aproved" => "pending"
				);
				$endpoint = 'picruangan';
				$query_string = array();
				$result = $client->post($endpoint, $query_string, $body);
				if ($result->get_error()){
					echo "
					<div class='row'>
						<div class='col-md-8 col-md-offset-2'>
							<div class='alert alert-danger' style='text-align:center;'>
								<h4>Gagal Melakukan Pendaftaran, silahkan lakukan proses Pendaftaran ulang.</h4>
							</div>
						</div>
					</div>
					";
				} else {
					echo "
					<div class='row'>
						<div class='col-md-8 col-md-offset-2'>
							<div class='alert alert-success' style='text-align:center;'>
								<h4>Selamat, pendaftaran anda berhasil, status pendaftaran menunggu konfirmasi admin.</h4>
							</div>
						</div>
					</div>
					";
				}
			}
		?>
		<form class="form-horizontal frm-body" action="" method="post">
		  <div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">ID</label>
			<div class="col-sm-8">
			  <input type="text" name="username" class="form-control" placeholder="ID">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">Password</label>
			<div class="col-sm-8">
			  <input type="password" name="password" class="form-control" placeholder="Password">
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-9">
			  <button type="submit" name="login" class="btn btn-primary pull-right">Login</button>
			  <a class="btn btn-default pull-right" style="margin-right:2%" data-toggle="modal" data-target="#staff-signup">Sign up as staff</a>
			</div>
		  </div>
		</form>
	</div>
	<div class="col-md-6 col-md-offset-2" style="color:#f7f7f7;opacity:0.7">
		<div class="col-md-6">
			<h4>Powered By :</h4>
			<h2 style="margin-left:50%;">nobackend.id</h2>
		</div>
	</div>
</div>
</body>
<!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	<!-- Modal -->
<div id="staff-signup" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title">Staff Signup</h4>
      </div>
      <div class="modal-body">
		<form class="form-horizontal" action="" method="post">
		  <div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">ID <span class="pull-right">:</span></label>
			<div class="col-sm-8">
			  <input type="text" name="id" class="form-control" placeholder="ID">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">Password <span class="pull-right">:</span></label>
			<div class="col-sm-8">
			  <input type="password" name="password" class="form-control" placeholder="Password">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">Name <span class="pull-right">:</span></label>
			<div class="col-sm-8">
			  <input type="text" name="name" class="form-control" placeholder="Full Name">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">Phone <span class="pull-right">:</span></label>
			<div class="col-sm-8">
			  <input type="text" name="phone" class="form-control" placeholder="Active Phone Number">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">Email <span class="pull-right">:</span></label>
			<div class="col-sm-8">
			  <input type="email" name="email" class="form-control" placeholder="Email Active">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">PIC of <span class="pull-right">:</span></label>
			<div class="col-sm-8">
				<?php 
				$query = array("ql" => "select * order by name");
				$ruangans = $client->get_collection('ruangans',$query);
				$i = 0;
				while ($ruangans->has_next_entity()) {
					$ruangan = $ruangans->get_next_entity();
					$name = $ruangan->get('name');
					$uuid = $ruangan->get('uuid');
					echo"
					<div class='checkbox col-md-6'>
						<label>
						  <input type='checkbox' name='room[$i]' value='$uuid'> $name
						</label>
					</div>
					";
					$i++;
				}
				?>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-12" style="margin-top:5%;text-align:center">
			  <button type="submit" name="register" class="btn btn-primary">Submit</button>
			</div>
		  </div>
		</form>
      </div>
    </div>
  </div>
</div>
</html>