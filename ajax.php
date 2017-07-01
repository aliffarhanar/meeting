<?php
	session_start();
	include_once 'inc/config.php';
	function getDataQuery(){
		if($_SESSION['filter_building'] == "all"){
			$filter_building = ""; 
		}else{
			$filter_building = "gedung ='".$_SESSION['filter_building']."'"; 
		}
		if($_SESSION['filter_capacity'] == "0"){
			$filter_capacity = "capacity > 0"; 
		}else{
			$capacity = explode("-",$_SESSION['filter_capacity']);
			$filter_capacity = "capacity > ".$capacity[0]." AND capacity < ".$capacity[1]; 
		}
		if($filter_building != ""){
			$data = array("ql" => "select * where ".$filter_building." AND ".$filter_capacity." order by ".$_SESSION['filter_sort']);
		}else{
			$data = array("ql" => "select * where ".$filter_capacity." order by ".$_SESSION['filter_sort']);
		}
		return $data;
	}
	if(isset($_POST['filter_building'])){
		$_SESSION['filter_building'] = $_POST['filter_building']; 
		$data = getDataQuery();
		$ruangans = $client->get_collection('ruangans',$data);
		//do something with the data
		if($ruangans->has_next_entity()){
			while ($ruangans->has_next_entity()) {
				$ruangan = $ruangans->get_next_entity();
				$name = $ruangan->get('name');
				$capacity = $ruangan->get('capacity');
				$facility = $ruangan->get('facility');
			?>
				  <!-- box find room -->
				  <div class="col-sm-3">
					<div class="border-box panel panel-info">
					  <div class="panel-body text-center" style="background: rgba(255, 255, 255, 0.5);">
						<img src="images/meeting.jpg" class="img-responsive pull-center" style="width:150px;height:150px;" alt="Image">
						<?php echo $name;?><br>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star-empty"></span>
						<br><span class="glyphicons glyphicons-group" style="color: black;"><?php echo $capacity;?> person</span>
						<br><span class="glyphicons glyphicons" style="color: black;"><?php echo $facility;?></span>
						<br><a class="btn btn-primary pull-center" data-toggle="modal" data-target="#detail-room">Detail</a>
					  </div>
					</div>
				  </div>
				  <!-- box find room -->
			<?php	
			}
		}else{
			echo "Tidak ada ruangan yang ditemukan";
		}
	}
	if(isset($_POST['filter_capacity'])){
		$_SESSION['filter_capacity'] = $_POST['filter_capacity']; 		
		$data = getDataQuery();
		$ruangans = $client->get_collection('ruangans',$data);
		//do something with the data
		if($ruangans->has_next_entity()){
			while ($ruangans->has_next_entity()) {
				$ruangan = $ruangans->get_next_entity();
				$name = $ruangan->get('name');
				$capacity = $ruangan->get('capacity');
				$facility = $ruangan->get('facility');
			?>
				  <!-- box find room -->
				  <div class="col-sm-3">
					<div class="border-box panel panel-info">
					  <div class="panel-body text-center" style="background: rgba(255, 255, 255, 0.5);">
						<img src="images/meeting.jpg" class="img-responsive pull-center" style="width:150px;height:150px;" alt="Image">
						<?php echo $name;?><br>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star-empty"></span>
						<br><span class="glyphicons glyphicons-group" style="color: black;"><?php echo $capacity;?> person</span>
						<br><span class="glyphicons glyphicons" style="color: black;"><?php echo $facility;?></span>
						<br><a class="btn btn-primary pull-center" data-toggle="modal" data-target="#detail-room">Detail</a>
					  </div>
					</div>
				  </div>
				  <!-- box find room -->
			<?php	
			}
		}else{
			echo "Tidak ada ruangan yang ditemukan";
		}
	}
	if(isset($_POST['filter_sort'])){
		$_SESSION['filter_sort'] = $_POST['filter_sort']; 		
		$data = getDataQuery();
		$ruangans = $client->get_collection('ruangans',$data);
		//do something with the data
		if($ruangans->has_next_entity()){
			while ($ruangans->has_next_entity()) {
				$ruangan = $ruangans->get_next_entity();
				$name = $ruangan->get('name');
				$capacity = $ruangan->get('capacity');
				$facility = $ruangan->get('facility');
			?>
				  <!-- box find room -->
				  <div class="col-sm-3">
					<div class="border-box panel panel-info">
					  <div class="panel-body text-center" style="background: rgba(255, 255, 255, 0.5);">
						<img src="images/meeting.jpg" class="img-responsive pull-center" style="width:150px;height:150px;" alt="Image">
						<?php echo $name;?><br>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star-empty"></span>
						<br><span class="glyphicons glyphicons-group" style="color: black;"><?php echo $capacity;?> person</span>
						<br><span class="glyphicons glyphicons" style="color: black;"><?php echo $facility;?></span>
						<br><a class="btn btn-primary pull-center" data-toggle="modal" data-target="#detail-room">Detail</a>
					  </div>
					</div>
				  </div>
				  <!-- box find room -->
			<?php	
			}
		}else{
			echo "Tidak ada ruangan yang ditemukan";
		}
	}

?>