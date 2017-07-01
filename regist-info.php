<?php
include_once "inc/config.php";
				
	if(isset($_GET['id'])){
		$data = array("ql" => "select * where created=".$_GET['id']);
		//reading data ruangan
		$pics = $client->get_collection('picruangans',$data);
		$pic = $pics->get_next_entity();
		$room = $pic->get('pic');
		
	if(isset($_GET['process_edit'])){
		$id = $_POST['id'];
		$password = $_POST['password'];
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$pic1 = array();
		for($i=0;$i<count($_POST['room']);$i++){
			if(isset($_POST['room'][$i])){
				array_push($pic1,$_POST['room'][$i]);
			}
		}
		$body = array(
			"password" => $password,
			"id" => $id,
			"phone" => $phone,
			"email" => $email,
			"pic" => $pic1,
			"aproved" => "approved"
		);
		$endpoint = 'picruangans/'.$pic->get('uuid');
		$query_string = array();
		$result = $client->put($endpoint, $query_string, $body);
		if ($result->get_error()){
			echo "
			<div class='row'>
				<div class='col-md-8 col-md-offset-2'>
					<div class='alert alert-danger' style='text-align:center;'>
						<h4>Gagal melakukan perubahan data.</h4>
					</div>
				</div>
			</div>
			";
		} else {
			echo "
			<div class='row'>
				<div class='col-md-8 col-md-offset-2'>
					<div class='alert alert-success' style='text-align:center;'>
						<h4>Data berhasil dirubah</h4>
					</div>
				</div>
			</div>
			";
		}
		exit;
	}
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		<span class="sr-only">Close</span>
	</button>
	<h4 class="modal-title">Register Info</h4>
</div>
<div class="modal-body">
	<form class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">ID <span class="pull-right">:</span></label>
			<div class="col-sm-8">
				<input type="text" name="id" class="form-control" placeholder="ID" value="<?=$pic->get('id')?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">Password <span class="pull-right">:</span></label>
			<div class="col-sm-8">
				<input type="password" name="password" class="form-control" placeholder="Password" value="<?=$pic->get('password')?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">Name <span class="pull-right">:</span></label>
			<div class="col-sm-8">
				<input type="text" name="name" class="form-control" placeholder="Full Name" value="<?=$pic->get('name')?>" readonly>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">Phone <span class="pull-right">:</span></label>
			<div class="col-sm-8">
				<input type="text" name="phone" class="form-control" placeholder="Active Phone Number" value="<?=$pic->get('phone')?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">Email <span class="pull-right">:</span></label>
			<div class="col-sm-8">
				<input type="email" name="email" class="form-control" placeholder="Email Active" value="<?=$pic->get('email')?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 col-md-offset-1 frm-label">PIC of <span class="pull-right">:</span></label>
			<div class="col-sm-8">
				<?php 
					$query = array("ql" => "select * order by name");
					$ruangans = $client->get_collection('ruangans',$query);
					$i = 0;
					while ($ruangans->has_next_entity()) {
						$ruangan = $ruangans->get_next_entity();
						$name = $ruangan->get('name');
						$uuid = $ruangan->get('uuid');
						echo"
						<div class='checkbox col-md-6'>
							<label>
							  <input type='checkbox' name='room[$i]' value='$uuid' ".(in_array($uuid,$room)?'checked':'')." > $name
							</label>
						</div>
						";
						$i++;
					}
				?>
				<?php
					#foreach($room as $key=> $rp){
					#	$data = array('ql' => "select * where uuid=".$rp);		
					#	//reading data ruangan
					#	$ruangans = $client->get_collection('ruangans',$data);
					#	//do something with the data
					#	$ruangan = $ruangans->get_next_entity();
					#	echo "
					#		<div class='checkbox col-md-6'>
					#			<label>
					#				<input type='checkbox' name='room' value='".$rp[$key]."' checked> ".$ruangan->get('name')."
					#			</label>
					#		</div>";
					#}
				?>
			</div>
		</div>
</div>
<?php if (isset($_GET['edit'])) { ?>
	<div class="modal-footer">
		<button type="submit" name="edit" onClick="updatedata(<?=$_GET['id']?>)" class="btn btn-primary text-center">Save</button>
	</div>
	<div id="info-update"></div>
<?php } ?>
</form>

<?php } else { ?>
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		<span class="sr-only">Close</span>
	</button>
		<h4 class="modal-title">Register Info</h4>
	</div>
	<div class="modal-body">
		Data Not Found!
	</div>
<?php } ?>
<script>
	// Edit/Update category
    function updatedata(str){
        var id = str;
		var data = $( "form" ).serialize();
        $.ajax({
           type: "POST",
           url: "regist-info.php?process_edit=true&id="+id,
           data: data
        }).done(function( data ) {
          $('#info-update').html(data);
        });
    }
</script>