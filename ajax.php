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
			$listpic =array();
			$i=0;
			$data_pic = array("ql" => "select * where role ='staff'");
			$pics = $client->get_collection('users', $data_pic);
			//do something with the data
			while($pics->has_next_entity()){
				$pic = $pics->get_next_entity();
				$listpic[$i]["name"] = $pic->get('name');
				$listpic[$i]["phone"] = $pic->get('phone');
				$listpic[$i]["room"] = $pic->get('pic');
				$i++;
			}
			while ($ruangans->has_next_entity()) {
				$roompic = "<ul>";
				$ruangan = $ruangans->get_next_entity();
				$name = $ruangan->get('name');
				$uuid = $ruangan->get('uuid');
				$capacity = $ruangan->get('capacity');
				$facility = $ruangan->get('facility');
				$location = $ruangan->get('address');
				$foto = $ruangan->get('foto');
				for($j=0;$j<$i;$j++){
					if(in_array($name,$listpic[$j]["room"])){
						$roompic .="<li>".$listpic[$j]["name"]."</li>";
					}
				}
				$roompic .="</ul>";
			?>
				  <!-- box find room -->
				  <div class="col-sm-3">
					<div class="border-box panel panel-info">
					  <div class="panel-body text-center" style="background: rgba(255, 255, 255, 0.5);">
						<img src="parse_image.php?image=<?php echo $name;?>" class="img-responsive pull-center" style="width: 100%;height:150px;" alt="Image">
						<br><?php echo $name;?><br>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star-empty"></span>
						<br><span class="glyphicons glyphicons-group" style="color: black;"><?php echo $capacity;?> person</span>
						<br><span class="glyphicons glyphicons" style="color: black;"><?php echo strlen($facility)>30?mb_substr($facility,0,27)."...":$facility ;?></span>
						<br><br>
						<a class="btn btn-primary pull-center modal-detail" pic="<?php echo $roompic;?>" room="<?php echo $name."|".$capacity."|".$facility."|".$location."|"."parse_image.php?image=".urlencode($name); ?>" data-toggle="modal" data-target="#detail-room">Detail</a>
						<?php if ($_SESSION['role'] == "admin") { ?>
							<a href="create-room-admin.php?delete=<?php echo $name;?>"" class="btn btn-primary pull-center">Delete</a>
						<?php }  ?>
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
			$listpic =array();
			$i=0;
			$data_pic = array("ql" => "select * where role ='staff'");
			$pics = $client->get_collection('users', $data_pic);
			//do something with the data
			while($pics->has_next_entity()){
				$pic = $pics->get_next_entity();
				$listpic[$i]["name"] = $pic->get('name');
				$listpic[$i]["phone"] = $pic->get('phone');
				$listpic[$i]["room"] = $pic->get('pic');
				$i++;
			}
			while ($ruangans->has_next_entity()) {
				$roompic = "<ul>";
				$ruangan = $ruangans->get_next_entity();
				$name = $ruangan->get('name');
				$uuid = $ruangan->get('uuid');
				$capacity = $ruangan->get('capacity');
				$facility = $ruangan->get('facility');
				$location = $ruangan->get('address');
				$foto = $ruangan->get('foto');
				for($j=0;$j<$i;$j++){
					if(in_array($name,$listpic[$j]["room"])){
						$roompic .="<li>".$listpic[$j]["name"]."</li>";
					}
				}
				$roompic .="</ul>";
			?>
				  <!-- box find room -->
				  <div class="col-sm-3">
					<div class="border-box panel panel-info">
					  <div class="panel-body text-center" style="background: rgba(255, 255, 255, 0.5);">
						<img src="parse_image.php?image=<?php echo $name;?>" class="img-responsive pull-center" style="width: 100%;height:150px;" alt="Image">
						<br><?php echo $name;?><br>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star-empty"></span>
						<br><span class="glyphicons glyphicons-group" style="color: black;"><?php echo $capacity;?> person</span>
						<br><span class="glyphicons glyphicons" style="color: black;"><?php echo strlen($facility)>30?mb_substr($facility,0,27)."...":$facility ;?></span>
						<br><br>
						<a class="btn btn-primary pull-center modal-detail" pic="<?php echo $roompic;?>" room="<?php echo $name."|".$capacity."|".$facility."|".$location."|"."parse_image.php?image=".urlencode($name); ?>" data-toggle="modal" data-target="#detail-room">Detail</a>
						<?php if ($_SESSION['role'] == "admin") { ?>
							<a href="create-room-admin.php?delete=<?php echo $name;?>"" class="btn btn-primary pull-center">Delete</a>
						<?php }  ?>
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
			$listpic =array();
			$i=0;
			$data_pic = array("ql" => "select * where role ='staff'");
			$pics = $client->get_collection('users', $data_pic);
			//do something with the data
			while($pics->has_next_entity()){
				$pic = $pics->get_next_entity();
				$listpic[$i]["name"] = $pic->get('name');
				$listpic[$i]["phone"] = $pic->get('phone');
				$listpic[$i]["room"] = $pic->get('pic');
				$i++;
			}
			while ($ruangans->has_next_entity()) {
				$roompic = "<ul>";
				$ruangan = $ruangans->get_next_entity();
				$name = $ruangan->get('name');
				$uuid = $ruangan->get('uuid');
				$capacity = $ruangan->get('capacity');
				$facility = $ruangan->get('facility');
				$location = $ruangan->get('address');
				$foto = $ruangan->get('foto');
				for($j=0;$j<$i;$j++){
					if(in_array($name,$listpic[$j]["room"])){
						$roompic .="<li>".$listpic[$j]["name"]."</li>";
					}
				}
				$roompic .="</ul>";
			?>
				   <!-- box find room -->
				  <div class="col-sm-3">
					<div class="border-box panel panel-info">
					  <div class="panel-body text-center" style="background: rgba(255, 255, 255, 0.5);">
						<img src="parse_image.php?image=<?php echo $name;?>" class="img-responsive pull-center" style="width: 100%;height:150px;" alt="Image">
						<br><?php echo $name;?><br>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star-empty"></span>
						<br><span class="glyphicons glyphicons-group" style="color: black;"><?php echo $capacity;?> person</span>
						<br><span class="glyphicons glyphicons" style="color: black;"><?php echo strlen($facility)>30?mb_substr($facility,0,27)."...":$facility ;?></span>
						<br><br>
						<a class="btn btn-primary pull-center modal-detail" pic="<?php echo $roompic;?>" room="<?php echo $name."|".$capacity."|".$facility."|".$location."|"."parse_image.php?image=".urlencode($name); ?>" data-toggle="modal" data-target="#detail-room">Detail</a>
						<?php if ($_SESSION['role'] == "admin") { ?>
							<a href="create-room-admin.php?delete=<?php echo $name;?>"" class="btn btn-primary pull-center">Delete</a>
						<?php }  ?>
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