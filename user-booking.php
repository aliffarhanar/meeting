
<div class="col-md-12">
	<div class="col-md-12">
		<h3>Request</h3>
	</div>
	<div class="col-md-12" style="border-top : 2px solid grey;padding-top:2%">
		<?php
			if(isset($_POST['book'])){
				$data = array('ql' => "select * where name='".$_GET['room']."'");		
				//reading data ruangan
				$ruangans = $client->get_collection('ruangans',$data);
				//do something with the data
				while ($ruangans->has_next_entity()) {
					$ruangan = $ruangans->get_next_entity();
				}
				
				$name = $_POST['event_name'];
				$topic = $_POST['topic'];
				$tanggal = $_POST['tanggal'];
				$start = $_POST['start'];
				$end = $_POST['end'];
				$jam = array($start,$end);
				$participant = $_POST['participant'];
				$food = $_POST['food'];
				$note = $_POST['note'];
				$user = $_SESSION['name'];
				$body = array(
					"name" => $name,
					"topic" => $topic,
					"tanggal" => $tanggal,
					"jam" => $jam,
					"start" => $start,
					"end" => $end,
					"participant" => $participant,
					"food" =>$food,
					"note" => $note,
					"ruangan" => $ruangan->get('uuid'),
					"approved" => "pending",
					"user" => $user,
				);
				$success = false;
				$endpoint = 'booking';
				$query_string = array();
				$result = $client->post($endpoint, $query_string, $body);
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
								<h4>Selamat, pemesanan ruangan telah dilakukan, status pemesanan menunggu konfirmasi Dari PIC/Pengelola ruangan. Terima Kasih</h4>
							</div>
						</div>
					</div>
					";
				}
			}
		?>
		<form class="form-horizontal col-md-12" action="" method="post" style="margin-left: -8%;width: 110%;">
			<div class="col-md-8">
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Event Name* <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<input type="text" name="event_name" class="form-control" placeholder="Event Name">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Topic <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<textarea name="topic" class="form-control" style="resize: none;"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Room <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<input type="text" name="room" class="form-control" value="<?php echo $_GET['room'];?>" readonly>
					</div>
				</div>		  
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Date <span class="pull-right">:</span></label>
					<div class="col-sm-4">
						<div class='input-group date' id='datepicker'>
							<input type='text' class="form-control" id="tanggal" name="tanggal" />
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
							<input id="timepicker_start" name="start" type="text" class="form-control input-small">
							<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">End Time<span class="pull-right">:</span></label>
					<div class="col-sm-3">
						<div class="input-group bootstrap-timepicker timepicker">
							<input id="timepicker_end" name="end" type="text" class="form-control input-small">
							<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Participant <span class="pull-right">:</span></label>
					<div class="col-sm-2">
						<input type="number" name="participant" min="0" class="form-control" value="35">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Food Drink <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<textarea name="food" class="form-control" style="resize: none;" rows="3"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-9 col-md-offset-1" style="margin-top:2%;">
						* Requred<br>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-8 col-md-offset-1" >
						<button type="submit" name="book" class="btn btn-primary pull-right">Save</button>
					</div>
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
