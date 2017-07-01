<div class="col-md-12">
	<div class="col-md-12">
		<h3>Edit Staff Information</h3>
	</div>
	<div class="col-md-12" style="border-top: 2px solid grey; padding-top: 2%;">
		<form class="form-horizontal col-md-12" action="" method="post" style="margin-left: -8%;width: 110%;">
			<div class="col-md-8">
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">ID <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<input type="text" name="id" class="form-control" value="172832718829" disabled="disable">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Password <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<input type="password" name="password" class="form-control" value="aaaaa" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Confirmation <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<input type="text" name="confirmation" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Name <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<input type="text" name="name" value="Adi Mulyanto" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Phone <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<input type="text" name="phone" value="089875192293" class="form-control">
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">Email <span class="pull-right">:</span></label>
					<div class="col-sm-9">
						<input type="email" name="email" value="adi.mulyanto@telkom.co.id" class="form-control">
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-2 col-md-offset-1 frm-label">PIC of <span class="pull-right">:</span></label>
					<div class="col-sm-8">
						<?php for ($i=0; $i < 10 ; $i++) { ?>
						<div class='checkbox col-md-6'>
							<label>
							<input type='checkbox' checked> Name of Room <?php echo $i; ?>
							</label>
						</div>
						<?php } ?>
					</div>
				</div>  
				<div class="form-group">
					<div class="col-sm-8 col-md-offset-1" style="margin-top:2%;">
						<button type="submit" name="register" class="btn btn-primary">Change</button>
					</div>
				</div>
			</div>
			<div class="col-md-4">

			</div>
		</form>		
	</div>
</div>