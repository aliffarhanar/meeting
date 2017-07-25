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
						<th style="width: 5%;">PIC</th>
					</tr>
				</thead>
				<tbody>
					<?php
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
								<td><?=$booking->get('name')?></td>
								<td><?=$booking->get('created')?></td>
								<td><?=$ruangan->get('name')?></td>
								<td><?=$booking->get('start').' - '.$booking->get('end')?></td>
								<td><?=$booking->get('approved')?></td>
								<td><a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#view-pic">view</a></td>
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
