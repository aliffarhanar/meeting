<div class="col-md-12 row">
	<div class="col-md-12" style="padding-top:2%;">
		<div class="col-md-3">
			<h4>UNCONFIRMED</h4>
		</div>
		<div class="col-md-2 pull-right">
			<div class="input-group input-group-sm">
				<span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-sort" style="color: black;"></span></span>
				<select class="form-control" aria-describedby="sizing-addon3">
					<option>Sort By</option>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-12" style="padding-top:2%; overflow-y: scroll;">
	<?php
			if(isset($_GET['aprove'])){
				$endpoint = 'bookings/'.$_GET['aprove'];
				$query_string = array();
				
				$body = array(
					"aproved" => "approved"
				);
				
				$result = $client->put($endpoint, $query_string, $body);
				
				if ($result->get_error()){
					echo "
					<div class='row'>
						<div class='col-md-8 col-md-offset-2'>
							<div class='alert alert-danger' style='text-align:center;'>
								<h4>Gagal Melakukan Approval,Meeting ".$_GET['aprove']." belum di approve.</h4>
							</div>
						</div>
					</div>
					";
				} else {
					echo "
					<div class='row'>
						<div class='col-md-8 col-md-offset-2'>
							<div class='alert alert-success' style='text-align:center;'>
								<h4>Meeting ".$_GET['aprove']." sudah berhasil di approve.</h4>
							</div>
						</div>
					</div>
					";
					echo '<meta http-equiv="refresh" content="2; url=?page=room-request-staff">';
				}
			}
			if(isset($_GET['reject'])){
				$endpoint = 'bookings/'.$_GET['reject'];
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
					echo '<meta http-equiv="refresh" content="2; url=?page=room-request-staff">';
				}
			}
		?>
		<div class="table-responsive col-md-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>NO</th>
						<th>RUANGAN</th>
						<th>TANGGAL</th>
						<th>WAKTU MEETING</th>
						<th>NAMA MEETING</th>
						<th>AKSI</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$no=1;
						$data = array('ql' => "select * where aproved='pending'");		
					$bookings = $client->get_collection('bookings',$data);
					if($bookings->has_next_entity()){
						//do something with the data
						while ($bookings->has_next_entity()) {
							$booking = $bookings->get_next_entity();
							$data = array('ql' => "select * where uuid=".$booking->get('ruangan'));		
							//reading data ruangan
							$ruangans = $client->get_collection('ruangans',$data);
							//do something with the data
							$ruangan = $ruangans->get_next_entity();
					?>
						<tr>
							<td><?=$no?></td>
							<td><?=$ruangan->get('name')?></td>
							<td><?=$booking->get('tanggal')?></td>
							<td><?=$booking->get('start').' - '.$booking->get('end')?></td>
							<td><?=$booking->get('name')?></td>
							<td>
								<a href="?page=room-request-staff&reject=<?=$booking->get('name')?>" class="btn btn-sm btn-danger" ><i class="fa fa-close" aria-hidden="true"></i></a>
								<a href="?page=room-request-staff&aprove=<?=$booking->get('name')?>" class="btn btn-sm btn-success" ><i class="fa fa-check" aria-hidden="true"></i></a>
							</td>
						</tr>
						<?php 
							$no++; 
						} 
					}else{
						echo "<td colspan='6'>TIDAK ADA REQEUST MEETING BARU</td>";
					}
				?>	
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-md-12 row">
	<div class="col-md-12" style="padding-top:2%;">
		<div class="col-md-3">
			<h4>CONFIRMED</h4>
		</div>
		<div class="col-md-2 pull-right">
			<div class="input-group input-group-sm">
				<span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-sort" style="color: black;"></span></span>
				<select class="form-control" aria-describedby="sizing-addon3">
					<option>Sort By</option>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-12" style="padding-top:2%; overflow-y: scroll;">
		<div class="table-responsive col-md-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>NO</th>
						<th>RUANGAN</th>
						<th>TANGGAL</th>
						<th>WAKTU MEETING</th>
						<th>NAMA MEETING</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$no=1;
						$data = array('ql' => "select * where aproved='approved'");		
					$bookings = $client->get_collection('bookings',$data);
					if($bookings->has_next_entity()){
						//do something with the data
						while ($bookings->has_next_entity()) {
							$booking = $bookings->get_next_entity();
							$data = array('ql' => "select * where uuid=".$booking->get('ruangan'));		
							//reading data ruangan
							$ruangans = $client->get_collection('ruangans',$data);
							//do something with the data
							$ruangan = $ruangans->get_next_entity();
					?>
						<tr>
							<td><?=$no?></td>
							<td><?=$ruangan->get('name')?></td>
							<td><?=$booking->get('tanggal')?></td>
							<td><?=$booking->get('start').' - '.$booking->get('end')?></td>
							<td><?=$booking->get('name')?></td>
						</tr>
						<?php 
							$no++; 
						} 
					}else{
						echo "<td colspan='6'>TIDAK ADA MEETING</td>";
					}
				?>	
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-md-12 row">
	<div class="col-md-12" style="padding-top:2%; ">
		<div class="col-md-1">
			<h4>Room : </h4>
		</div>
		<div class="col-md-2">
			<div class="input-group input-group-sm">
				<select class="form-control" aria-describedby="sizing-addon3">
					
					<?php 
					$query = array("ql" => "select * order by name");
					$ruangans = $client->get_collection('ruangans',$query);
					while ($ruangans->has_next_entity()) {
						$ruangan = $ruangans->get_next_entity();
						$name = $ruangan->get('name');
						$uuid = $ruangan->get('uuid');
						echo"<option value='$name'>$name</option>";
						$i++;
					}
					?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-12" style="overflow-y: scroll;">
		
		<div class="col-md-5" style="background-color: white; padding: 10px;">
			<div id="calendar"></div>
		</div>
		
		<div class="table-responsive col-md-7">
			<table class="table table-bordered">
				<tbody>
					<tr>
						<td rowspan="3">9:00</td>
					</tr>
					<tr>
						<td>?</td>
						<td>
							Rapat Koordinasi (Adi Mulyanto)  <a href="?page=detail-request"><img src="images/file.png" alt="file"></a>
						</td>
					</tr>
					<tr>
						<td>?</td>
						<td>Rapat Koordinasi (Adi Mulyanto)  <a href="?page=detail-request"><img src="images/file.png" alt="file"></a></td>
					</tr>
					<tr>
						<td rowspan="3">9:00</td>
					</tr>
					<tr>
						<td>?</td>
						<td>Rapat Koordinasi (Adi Mulyanto)  <a href="?page=detail-request"><img src="images/file.png" alt="file"></a></td>
					</tr>
					<tr>
						<td>?</td>
						<td>Rapat Koordinasi (Adi Mulyanto)  <a href="?page=detail-request"><img src="images/file.png" alt="file"></a></td>
					</tr>					
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<!-- Modal -->
<div id="view-pic" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 30%;margin-top: 10%;font-size: 130%;">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Approve Failed</h4>
			</div>
			<div class="modal-body">
				Some exact time with an approved request: Pitching Session (Arif Sasongko) at 11.00
			</div>
			<div class="modal-footer" style="text-align: center !important;">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
			</div>
		</div>
	</div>
</div>
<script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev',
				center: 'title',
				right: 'next',
			},
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			
		});
		
	});

</script>
