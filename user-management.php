<div class="row col-md-12">
	<div class="col-md-12">
		<h3>Registered User</h3>
	</div>

	<div class="col-md-12" style="border-top: 1px solid grey; padding-top: 2%;">
		<div class="col-md-2">
			<h4>Need approval</h4>
			<hr style="border-color: black;">
		</div>
		<div class="col-md-12" style="padding-top: 2%; overflow-y: hidden; height: 200px;">
			<?php
				if(isset($_GET['approve'])){
					$endpoint = 'users/'.$_GET['approve'];
					$query_string = array();

					$body = array(
						"approved" => "approved"
					);

					$result = $client->put($endpoint, $query_string, $body);

					if ($result->get_error()){
						echo "
						<div class='row'>
							<div class='col-md-8 col-md-offset-2'>
								<div class='alert alert-danger' style='text-align:center;'>
									<h4>Gagal Melakukan Approval,".$_GET['approved']." belum di approve.</h4>
								</div>
							</div>
						</div>
						";
					} else {
						echo "
						<div class='row'>
							<div class='col-md-8 col-md-offset-2'>
								<div class='alert alert-success' style='text-align:center;'>
									<h4>".$_GET['approve']." sudah berhasil di approve.</h4>
								</div>
							</div>
						</div>
						";
						echo '<meta http-equiv="refresh" content="2; url=?page=user-management">';
					}
				}
				if(isset($_GET['reject'])){
					$endpoint = 'users/'.$_GET['reject'];
					$query_string = array();

					$result = $client->delete($endpoint, $query_string);

					if ($result->get_error()){
						echo "
						<div class='row'>
							<div class='col-md-8 col-md-offset-2'>
								<div class='alert alert-danger' style='text-align:center;'>
									<h4>Gagal Melakukan Penghapusan Request,".$_GET['reject']." belum di hapus.</h4>
								</div>
							</div>
						</div>
						";
					} else {
						echo "
						<div class='row'>
							<div class='col-md-8 col-md-offset-2'>
								<div class='alert alert-success' style='text-align:center;'>
									<h4>".$_GET['reject']." sudah berhasil di hapus dan ditolak permintaan PIC nya.</h4>
								</div>
							</div>
						</div>
						";
						echo '<meta http-equiv="refresh" content="2; url=?page=user-management">';
					}
				}
			?>
				<table id="table-approval" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No.</th>
							<th>ID</th>
							<th>Name</th>
							<th>Role</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$no=1;
					if(isset($_GET['cari'])){
						$data = array(
								"ql" => "select * where approved = 'pending'
								AND name contains ='".$_GET['cari']."'");
						//reading data ruangan
						$pics = $client->get_collection('users',$data);
					}else{
						$data = array("ql" => "select * where approved = 'pending'");
						//reading data ruangan
						$pics = $client->get_collection('users',$data);
					}
					if($pics->has_next_entity()){

						while ($pics->has_next_entity()) {
							$pic = $pics->get_next_entity();
							$room = $pic->get('pic');
						?>
						<tr>
							<td><?=$no?></td>
							<td><?=$pic->get('username')?></td>
							<td><?=$pic->get('name')?></td>
							<td><?=$pic->get('role')?>
								<?php
									#foreach($room as $rp){
									#	$data = array('ql' => "select * where uuid=".$rp);
									#	//reading data ruangan
									#	$ruangans = $client->get_collection('ruangans',$data);
									#	//do something with the data
									#	$ruangan = $ruangans->get_next_entity();
									#	echo '<i class="fa fa-check-square-o"></i>'.$ruangan->get('name').'<br>';
									#}
								?>
							</td>
							<td>
								<a href="#!" data-id="<?=$pic->get('created')?>" class="btn btn-sm btn-primary regist"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
								<a href="?page=user-management&reject=<?=$pic->get('name')?>" class="btn btn-sm btn-danger" ><i class="fa fa-close" aria-hidden="true"></i></a>
								<a href="?page=user-management&approve=<?=$pic->get('name')?>"class="btn btn-sm btn-success" ><i class="fa fa-check" aria-hidden="true"></i></a>
							</td>
						</tr>
						<?php
							$no++;
						}
					}
						?>
					</tbody>
				</table>
					<!-- modal accept -->
					<div class="modal fade" id="accept">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										<span class="sr-only">Close</span>
									</button>
									<h4 class="modal-title">Staff Accepted</h4>
								</div>
								<div class="modal-body">
									Adi Mulyanto D.(12637289). now can access MeetingRoom as a Staff of Auditorium and MeetingRoom #2.
								</div>
								<div class="modal-footer" style="text-align: center !important;">
									<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->

					<!-- modal reject -->
					<div class="modal fade" id="reject">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										<span class="sr-only">Close</span>
									</button>
									<h4 class="modal-title">Staff Rejected</h4>
								</div>
								<div class="modal-body">
									Adi Mulyanto D.(12637289)'s request for become a staff has been rejected.
								</div>
								<div class="modal-footer" style="text-align: center !important;">
									<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
					<!-- modal reject -->
					<div class="modal fade" id="regist-info">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
							</div>
						</div>
					</div>
				</div>
			</div>
		<div class="col-md-12">
			<h4>All Account</h4>
			<hr style="border-color: black;">
		</div>
		<div class="col-md-12" style="padding-top: 2%; overflow-y: hidden; height: 200px;">
				<table id="table-account" class="display compact" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>ID</th>
							<th>Name</th>
							<th>Role</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no=1;
						if(isset($_GET['cari1'])){
							$data = array("ql" =>
										  "select * where approved = 'approved'
										  AND name contains ='".$_GET['cari1']."'");
							//reading data ruangan
							$pics = $client->get_collection('users', $data);
						}else{
							$data = array("ql" => "select * where approved = 'approved'");
							//reading data ruangan
							$pics = $client->get_collection('users',$data);
						}
						while ($pics->has_next_entity()) {
							$pic = $pics->get_next_entity();
							$room = $pic->get('pic');
						?>
						<tr>
							<td><?=$no?></td>
							<td><?=$pic->get('username')?></td>
							<td><?=$pic->get('name')?></td>
							<td><?=ucwords($pic->get('role'))?>
								<?php
									if ($room&&$pic->get('role')=='staff') foreach($room as $rp){
									$data = array('ql' => "select * where uuid=".$rp);
									//reading data ruangan
									$ruangans = $client->get_collection('ruangans',$data);
									//do something with the data
									$ruangan = $ruangans->get_next_entity();
									echo '<br>';
									echo '<i align="left" class="fa fa-check-square-o"></i>'.@$ruangan->get('name').'<br>';
								}
								?>
							</td>
							<td>
								<a href="#!" data-id="<?=$pic->get('created')?>" class="btn btn-sm btn-primary regist"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
								<a href="#!" data-id="<?=$pic->get('created')?>&edit=true" class="btn btn-sm btn-primary regist"><i class="fa fa-compose" aria-hidden="true"> Edit</i></a>
							</td>
						</tr>
						<?php $no++;} ?>
						</tbody>
					</table>
				</div>
			</div>
	</div>

	<script type="text/javascript">
	jQuery(function($){
		$('a.regist').click(function(ev){
			ev.preventDefault();
			var uid = $(this).data('id');
			$.get('regist-info.php?id=' + uid, function(html){
				$('#regist-info .modal-content').html(html);
				$('#regist-info').modal('show', {backdrop: 'static'});
			});
		});
	});
	</script>

	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css"/>
	<script src="//code.jquery.com/jquery-1.12.4.js"></script>
	<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
	<script>
	$(document).ready(function(){
		$('#table-approval').DataTable();
		$('#table-account').DataTable();
	});
	</script>
