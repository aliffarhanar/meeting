<div class="col-md-12 row">
	<div class="col-md-12" style="padding-top:2%;">
		<div class="col-md-3">
		<form method="GET">
			<div class="input-group input-group-sm">
			  <span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-search" style="color: black;"></span></span>
			  <input type="hidden" name="page" value="history-admin">
			  <input type="text" name="cari" class="form-control" value="<?=isset($_GET['cari'])?$_GET['cari']:''?>" placeholder="search" aria-describedby="sizing-addon3">
			</div>
		</form>
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
		<div class="table-responsive col-md-12">
			<table class="table table-bordered">
				<thead style="background-color: #e1e1e1;">
					<tr>
						<th>NO</th>
						<th>DATE</th>
						<th>NAME</th>
						<th>ID</th>
						<th>ROOM</th>
						<th>TIME</th>
						<th>STATUS</th>
						<th style="width: 5%;"></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						if(isset($_GET['cari'])){
							$data = array("ql" => "select * where name ='".$_GET['cari']."'");
							//reading data ruangan
							$bookings = $client->get_collection('bookings',$data);
						}else{
							//reading data ruangan
							$bookings = $client->get_collection('bookings');
						}
						//do something with the data
						while ($bookings->has_next_entity()) {
							$booking = $bookings->get_next_entity();
							$data = array('ql' => "select * where uuid=".$booking->get('ruangan'));		
							//reading data ruangan
							$ruangans = $client->get_collection('ruangans',$data);
							//do something with the data
							while ($ruangans->has_next_entity()) {
								$ruangan = $ruangans->get_next_entity();
							}
						?>
					<tr>
						<td><?=$no?></td>
						<td><?=$booking->get('tanggal')?></td>
						<td><?=$booking->get('name')?></td>
						<td><?=$booking->get('created')?></td>
						<td><?=$ruangan->get('name')?></td>
						<td><?=$booking->get('start').' - '.$booking->get('end')?></td>
						<td><?=$booking->get('approved')?></td>
						<td><a href="?page=edit-request&id=<?=$booking->get('created')?>" class="btn btn-sm btn-primary">edit</a></td>
					<?php $no++; }	?>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
