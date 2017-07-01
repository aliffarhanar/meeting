<?php
	if(isset($_GET['id'])){
		ini_set('display_errors',1);
		$data = array('ql' => "select * where created=".$_GET['id']);		
		//reading data ruangan
		$bookings = $client->get_collection('bookings',$data);
		//do something with the data
		$booking = $bookings->get_next_entity();
		
		$data = array('ql' => "select * where uuid=".$booking->get('ruangan'));		
		//reading data ruangan
		$ruangans = $client->get_collection('ruangans',$data);
		//do something with the data	
		$ruangan = $ruangans->get_next_entity();
	}else{
		echo '<meta http-equiv="refresh" content="0; url=?page=dashboard">';
	}
	
	if(isset($_POST['edit'])) {
		$success = false;
		$endpoint = 'bookings/'.$booking->get('uuid');
		$query_string = array();
		
		$name = $_POST['event_name'];
		$topic = $_POST['topic'];
		$tanggal = $_POST['tanggal'];
		$start = $_POST['start'];
		$end = $_POST['end'];
		$jam = array($start,$end);
		$participant = $_POST['participant'];
		$food = $_POST['food'];
		$note = $_POST['note'];
		$body = array(
			"name" => $name,
			"topic" => $topic,
			"tanggal" => $tanggal,
			"start" => $start,
			"end" => $end,
			"participant" => $participant,
			"food" =>$food,
			"note" => $note,
			"ruangan" => $ruangan->get('uuid'),
			"aproved" => "pending",
			"user" => 1
		);
		
		
		$result = $client->put($endpoint, $query_string, $body);
		
		if ($result->get_error()){
			echo "
			<div class='row'>
				<div class='col-md-8 col-md-offset-2'>
					<div class='alert alert-danger' style='text-align:center;'>
						<h4>Gagal Melakukan Pemesanan, silahkan lakukan proses pemesanan ulang.</h4>
					</div>
				</div>
			</div>
			";
		} else {
			echo "
			<div class='row'>
				<div class='col-md-8 col-md-offset-2'>
					<div class='alert alert-success' style='text-align:center;'>
						<h4>Selamat, pemesanan ruangan telah dilakukan, status pemesanan menunggu konfirmasi admin.</h4>
					</div>
				</div>
			</div>
			";
			echo '<meta http-equiv="refresh" content="2; url=">';
		}
	}
	?>
<div class="col-md-12">
	<div class="col-md-12">
		<h3>Profile</h3>
	</div>
	<div class="col-md-12" style="border-top : 2px solid grey;padding-top:2%">
		<form class="form-horizontal col-md-12" action="?page=edit-request&id=<?=$_GET['id']?>" method="post" style="margin-left: -8%;width: 110%;">
			<div class="col-md-8">
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Event Name* <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<input type="text" name="event_name" class="form-control" placeholder="Event Name" value="<?=$booking->get('name')?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Topic <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<textarea name="topic" class="form-control" style="resize: none;"><?=$booking->get('topic')?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Room <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<input type="text" name="room" class="form-control" value="<?=$ruangan->get('name')?>" disabled>
					</div>
				</div>		  
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Date <span class="pull-right">:</span></label>
					<div class="col-sm-4">
						<div class='input-group date' id='datepicker'>
							<input type='text' class="form-control" id="tanggal" name="tanggal" value="<?=$booking->get('tanggal')?>"/>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Start Time<span class="pull-right">:</span></label>
					<div class="col-sm-3">
						<div class="input-group bootstrap-timepicker timepicker">
							<input id="timepicker_start" type="text" name="start" class="form-control input-small" value="<?=$booking->get('start')?>">
							<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">End Time<span class="pull-right">:</span></label>
					<div class="col-sm-3">
						<div class="input-group bootstrap-timepicker timepicker">
							<input id="timepicker_end" type="text" name="end" class="form-control input-small" value="<?=$booking->get('end')?>">
							<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Participant <span class="pull-right">:</span></label>
					<div class="col-sm-2">
						<input type="number" name="participant" min="0" class="form-control" value="<?=$booking->get('participant')?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Food Drink <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<textarea name="food" class="form-control" style="resize: none;" rows="3"><?=$booking->get('food')?></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-9 col-md-offset-1" style="margin-top:2%;">
						* Requred<br>
					</div>
				</div>
				<div class="form-group pull-right">
					<button type="reset" name="reset" class="btn btn-danger "><i class="fa fa-close"></i></button>
					<button type="submit" name="edit" class="btn btn-success "><i class="fa fa-check"></i></button>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<div class="col-sm-12">
						<label STYLE="font-size:26px;">NOTE : </label><br>
						<textarea name="note" class="form-control" style="resize: none;" rows="18"></textarea>
					</div>
				</div>
			</div>
		</form>		
	</div>
</div>
