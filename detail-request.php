
<div class="col-md-12">
	<div class="col-md-12">
		<h3>Request</h3>
	</div>
	<div class="col-md-12" style="border-top : 2px solid grey;padding-top:2%">
		<form class="form-horizontal col-md-12" action="" method="post" style="margin-left: -8%;width: 110%;">
			<div class="col-md-8">
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Event Name* <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<input type="text" name="event_name" class="form-control" placeholder="Event Name" value="Rapat koordinasi tahun 2017" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Topic <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<textarea name="topic" class="form-control" style="resize: none;" disabled>Struktur kepengurusan baru</textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Room <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<input type="text" name="room" class="form-control" value="Auditorium" disabled>
					</div>
				</div>		  
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Date <span class="pull-right">:</span></label>
					<div class="col-sm-4">
						<div class='input-group date' id='datepicker'>
							<input type='text' class="form-control" id="tanggal" name="tanggal" disabled />
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
							<input id="timepicker_start" type="text" class="form-control input-small" disabled>
							<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">End Time<span class="pull-right">:</span></label>
					<div class="col-sm-3">
						<div class="input-group bootstrap-timepicker timepicker">
							<input id="timepicker_end" type="text" class="form-control input-small" disabled>
							<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Participant <span class="pull-right">:</span></label>
					<div class="col-sm-2">
						<input type="number" name="participant" min="0" class="form-control" value="36" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Food Drink <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<textarea name="food" class="form-control" style="resize: none;" rows="3" disabled>Tidak</textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-9 col-md-offset-1" style="margin-top:2%;">
						* Requred<br>
					</div>
				</div>
				<div class="form-group pull-right">
					<button type="submit" name="register" class="btn btn-danger "><i class="fa fa-close"></i></button>
					<button type="submit" name="register" class="btn btn-success "><i class="fa fa-check"></i></button>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<div class="col-sm-12">
						<div>
							<label class="col-sm-6 frm-label" style="padding: 0;">Requester ID* <span class="col-sm-2 pull-right">:</span></label> 
						</div>
						<div>
							<input class="col-sm-4 form-control" type="text" name="id" value="12637281923" disabled style="width: 50%;">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<div>
							<label class="col-sm-6 frm-label" style="padding: 0;">Requester Name<span class="col-sm-2 pull-right">:</span></label> 
						</div>
						<div>
							<input class="col-sm-4 form-control" type="text" name="id" value="Adi Mulyanto" disabled style="width: 50%;">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<label>Notes : </label><br>
						<textarea disabled name="food" class="form-control" style="resize: none;" rows="12">Tidak</textarea>
					</div>
				</div>
			</div>
		</form>		
	</div>
</div>
