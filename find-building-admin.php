<div class="col-md-12 row">
	<div class="col-md-12" style="padding-top:2%;">
		<div class="col-md-3">
			<?php if($_SESSION['role'] == "admin"){ ?>
				<a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#create-building"><i class="fa fa-plus"></i> Add Building</a>
			<?php } ?>
		</div>
	</div>
	<?php if (isset($_SESSION['notif'])) echo $_SESSION['notif'];unset($_SESSION['notif']);?>
	<div class="col-md-12" style="padding-top:2%;" id="list_gedung">
		<?php
			if(isset($_GET['edit'])){
				$gedungs = $client->get_collection('gedungs/'.$_GET['edit']);
				$gedung = $gedungs->get_next_entity();
				$name = $gedung->get('name');
				$uuid = $gedung->get('uuid');
				$location = $gedung->get('address');
		?>
				<table class="table" style="background-color:white">
					<thead>
						<tr>
							<th>NAMA GEDUNG</th>
							<th>LOKASI GEDUNG</th>
							<th width="10%"></th>
						</tr>
					</thead>
					<tbody>
						<form action="" method="post">
						<tr>
							<td><input type="text" class="form-control" name="name" value="<?php echo $name?>" readonly></td>
							<td><input type="text" class="form-control" name="address" value="<?php echo $location?>" required></td>
							<td width="10%"><input type="submit" name="editgedung" class="btn btn-success" value="SIMPAN"></td>
						</tr>
						</form>
					</tbody>
				</table>
		<?php
			}
			if(isset($_POST['editgedung'])){
				$body = array(
					"address" => $_POST['address']
				);
				$endpoint = 'gedungs/'.$_POST['name'];
				$query_string = array();
				$result = $client->put($endpoint, $query_string, $body);
				if ($result->get_error()){
					echo "
						<br>
						<div class='row'>
							<div class='col-md-8 col-md-offset-2'>
								<div class='alert alert-danger' style='text-align:center;margin-bottom: 0px;'>
									<h4>Gagal Melakukan Perubahan gedung, silahkan ulangi lagi</h4>
								</div>
							</div>
						</div>
						";
				} else {
					echo "
					<br>
					<div class='row'>
						<div class='col-md-8 col-md-offset-2'>
							<div class='alert alert-success' style='text-align:center;'>
								<h4>Selamat, data gedung sudah diubah.</h4>
							</div>
						</div>
					</div>
					";
				}

			}
			if(isset($_GET['delete'])){
				$endpoint = 'gedungs/'.$_GET['delete'];
				$query_string = array();
				$result = $client->delete($endpoint, $query_string);
				if ($result->get_error()){
					echo "
						<br>
						<div class='row'>
							<div class='col-md-8 col-md-offset-2'>
								<div class='alert alert-danger' style='text-align:center;margin-bottom: 0px;'>
									<h4>Gagal Melakukan Perubahan gedung, silahkan ulangi lagi</h4>
								</div>
							</div>
						</div>
						";
				} else {
					echo "
					<br>
					<div class='row'>
						<div class='col-md-8 col-md-offset-2'>
							<div class='alert alert-success' style='text-align:center;'>
								<h4>Selamat, data gedung sudah diubah.</h4>
							</div>
						</div>
					</div>
					";
				}

			}

			$gedungs = $client->get_collection('gedungs');
			//do something with the data
			if($gedungs->has_next_entity()){
				$no=1;
				?>
				<table class="table" style="background-color:white">
					<thead>
						<tr>
							<th>NO</th>
							<th>NAMA GEDUNG</th>
							<th>LOKASI GEDUNG</th>
							<th width="10%">AKSI</th>
						</tr>
					</thead>
					<tbody>
				<?php
				while ($gedungs->has_next_entity()) {				
					$gedung = $gedungs->get_next_entity();
					$name = $gedung->get('name');
					$uuid = $gedung->get('uuid');
					$location = $gedung->get('address');
				?>
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $name;?></td>
							<td><?php echo $location;?></td>
							<td width="10%">
								<a href="?page=manage-building&edit=<?=$name?>" class="btn btn-sm btn-info" title="Edit gedung"><i class="fa fa-pencil" aria-hidden="true"></i></a>
								<a href="?page=manage-building&delete=<?=$name?>"class="btn btn-sm btn-danger" title="Hapus gedung"><i class="fa fa-trash" aria-hidden="true"></i></a>
							</td>
						</tr>
				<?php
					$no++;
				}
				?>
					</tbody>
				</table>
				<?php
			}else{
				echo "Tidak ada gedung yang ditemukan";
			}
		?>
	</div>
	
</div>

	<?php if($_SESSION['role'] == "admin"){ ?>
	<!-- Modal -->
	<div id="create-building" class="modal fade" role="dialog">
	  <div class="modal-dialog" style="width: 50%;margin-top: 10%;font-size: 130%;">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
			<h4 class="modal-title">Add Building By Admin</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" action="create-building-admin.php" enctype="multipart/form-data" method="post">
			  <div class="form-group">
				<label class="col-sm-2 col-md-offset-1 frm-label">Building <span class="pull-right">:</span></label>
				<div class="col-sm-8">
				  <input type="text" name="name" required class="form-control" placeholder="Name">
				</div>
			  </div>
			  <div class="form-group">
				<label class="col-sm-2 col-md-offset-1 frm-label">Address <span class="pull-right">:</span></label>
				<div class="col-sm-8">
				  <textarea name="address" required class="form-control" placeholder="Address"> </textarea>
				</div>
			  </div>
			  <!--<div class="form-group">
				<label class="col-sm-2 col-md-offset-1 frm-label">Picture <span class="pull-right">:</span></label>
				<div class="col-sm-8">
				  <input type="file" name="foto" required class="form-control">
				  <p class="help-block">Maksimal ukuran file 500kb.</p>
				</div>
			  </div> -->
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

	<?php } ?>
<script>

  $(document).ready(function() {

  function closeFunction(){
    $('#detail-room').modal('hide');
    $('#room-edit').addClass("scroll");
    $('body').addClass("scroll-hidden");
  }
</script>
