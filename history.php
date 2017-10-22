<div class="col-md-12 row">
	<div class="col-md-12" style="padding-top:2%;">
		<div class="col-md-3">
			<div class="input-group input-group-sm">
			  <span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-search" style="color: black;"></span></span>
			  <input type="text" class="form-control" placeholder="search" aria-describedby="sizing-addon3">
			</div>
		</div>
		<div class="col-md-2">
			<div class="input-group input-group-sm">
			  <span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-sort" style="color: black;"></span></span>
			  <select class="form-control" aria-describedby="sizing-addon3">
				<option>Sory By</option>
			  </select>
			</div>
		</div>
	</div>
	<div class="col-md-12" style="padding-top:2%;">
		<?php
			//MENGHAPUS DATA BOOKING YANG DIPILIH
			if(isset($_GET['delete-book'])){
				$endpoint = 'bookings/'.$_GET['delete-book'];
				$query_string = array();
							
				$result = $client->delete($endpoint, $query_string);
				
				if ($result->get_error()){
					echo "
					<div class='row'>
						<div class='col-md-8 col-md-offset-2'>
							<div class='alert alert-danger' style='text-align:center;'>
								<h4>Gagal Melakukan Penghapusan Request,".$_GET['delete-book']." belum di hapus.</h4>
							</div>
						</div>
					</div>
					";
				} else {
					echo "
					<div class='row'>
						<div class='col-md-8 col-md-offset-2'>
							<div class='alert alert-success' style='text-align:center;'>
								<h4>".$_GET['delete-book']." sudah berhasil di hapus dari daftar booking anda.</h4>
							</div>
						</div>
					</div>
					";
					echo '<meta http-equiv="refresh" content="2; url=?page=history">';
				}				
			}
		?>
		<div class="table-responsive col-md-12">
			<table class="table table-bordered">
				<thead style="background-color: #e1e1e1;">
					<tr>
						<th>NO</th>
						<th>DATE</th>
						<th style="width: 20%;">NAME</th>
						<th style="width: 10%;">ID</th>
						<th style="width: 10%;">ROOM</th>
						<th>TIME</th>
						<th>STATUS</th>
						<th style="width: 5%;">PIC</th>
						<th style="width: 5%;"></th>
					</tr>
				</thead>
				<tbody>
					<?php
					//menamgil history booking ruangan
						$no=1;
						$data = array('ql' => "select * where user='".$_SESSION['name']."'");		
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
								<td><?=$booking->get('tanggal')?></td>
								<td style="text-align: left;"><?=$booking->get('name')?></td>
								<td><?=$booking->get('created')?></td>
								<td><?=$ruangan->get('name')?></td>
								<td><?=$booking->get('start').' - '.$booking->get('end')?></td>
								<td><?=$booking->get('approved')?></td>
								<td><a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#view-pic">view</a></td>
								<td><a href="?page=history&delete-book=<?=$booking->get('name')?>" class="btn btn-sm btn-danger">delete</a></td>
							</tr>
							<?php 
								$no++; 
							} 
						}else{							
							echo "<td colspan='9'>Data Not Found</td>";
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
	<!-- Modal -->
<div id="view-pic" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 30%;margin-top: 10%;font-size: 130%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title">PIC of Auditorium</h4>
      </div>
      <div class="modal-body">
		<ul style="list-style-image: url('images/list.png');">
			<li> Admin 1
				<ul style="list-style: none;">
					<li>089655440395</li>
					<li>admin@nobackend.id</li>
				</ul>
			</li>
			<li> Admin 2
				<ul style="list-style: none;">
					<li>089655440395</li>
					<li>admin@nobackend.id</li>
				</ul>
			</li>
		</ul>
      </div>
    </div>
  </div>
</div>
