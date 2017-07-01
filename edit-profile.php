<div class="col-md-12">
	<div class="col-md-12">
		<h3>Profile</h3>
	</div>
	<div class="col-md-12" style="border-top : 2px solid grey;padding-top:2%">
		<?php
			if(isset($_POST['edit'])){
				$id = $_POST['id'];
				$password = $_POST['password'];
				$name = $_POST['name'];
				$phone = $_POST['phone'];
				$email = $_POST['email'];
				$body = array(
					"id" => $id,
					"password" => $password,
					"phone" => $phone,
					"email" => $email
				);
				$endpoint = 'picruangan/'.$name;
				$query_string = array();
				$result = $client->put($endpoint, $query_string, $body);
				if ($result->get_error()){
					echo "
					<div class='row'>
						<div class='col-md-8 col-md-offset-2'>
							<div class='alert alert-danger' style='text-align:center;'>
								<h4>Gagal Melakukan Perubahan dan menyimpan data, silahkan lakukan proses perubahan ulang.</h4>
							</div>
						</div>
					</div>
					";
				} else {
					
					$_SESSION['id'] =$id;
					$_SESSION['password'] = $password;	
					$_SESSION['phone'] = $phone;	
					$_SESSION['email'] = $email;	
					
					echo "
					<div class='row'>
						<div class='col-md-8 col-md-offset-2'>
							<div class='alert alert-success' style='text-align:center;'>
								<h4>Selamat, data anda berhasil diubah.</h4>
							</div>
						</div>
					</div>
					";
				}
			}
		?>
		<form class="form-horizontal col-md-8" style="margin-left:-6%" action="" method="post">
		  <div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">ID <span class="pull-right">:</span></label>
			<div class="col-sm-8">
			  <input type="text" name="id" class="form-control" placeholder="ID" value="<?php echo $_SESSION['id']; ?>">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">Password <span class="pull-right">:</span></label>
			<div class="col-sm-8">
			  <input type="text" name="password" class="form-control" placeholder="Password" value="<?php echo $_SESSION['password']; ?>">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">Name <span class="pull-right">:</span></label>
			<div class="col-sm-8">
			  <input type="text" name="name" class="form-control" placeholder="Full Name" value="<?php echo $_SESSION['name']; ?>" readonly>
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">Phone <span class="pull-right">:</span></label>
			<div class="col-sm-8">
			  <input type="text" name="phone" class="form-control" placeholder="Active Phone Number" value="<?php echo $_SESSION['phone']; ?>">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">Email <span class="pull-right">:</span></label>
			<div class="col-sm-8">
			  <input type="email" name="email" class="form-control" placeholder="Email Active" value="<?php echo $_SESSION['email']; ?>">
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-8 col-md-offset-1" style="margin-top:2%;">
			  <button type="submit" name="edit" class="btn btn-primary">Edit and Save</button>
			</div>
		  </div>
		</form>		
	</div>
</div>
