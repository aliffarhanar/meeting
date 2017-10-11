<?php
	unset($_SESSION['filter_capacity']);
	unset($_SESSION['filter_building']);
	unset($_SESSION['filter_sort']);
	$_SESSION['filter_capacity'] = 0;
	$_SESSION['filter_building'] = "all";
	$_SESSION['filter_sort'] = "name";
?>
<script>
function filter_building(obj){
	var dataString = 'filter_building='+obj.value;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			document.getElementById("list_ruangan").innerHTML = html;			
		}
	});
}
function filter_capacity(obj){
	var dataString = 'filter_capacity='+obj.value;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			document.getElementById("list_ruangan").innerHTML = html;
		}
	});
}
function filter_sort(obj){
	var dataString = 'filter_sort='+obj.value;
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: dataString,
		cache: false,
		success: function(html) {
			document.getElementById("list_ruangan").innerHTML = html;
		}
	});
}
	$(function() {
        $(document).on("click",".modal-detail",function(){
          var pic = $(this).attr('pic');
          var room = $(this).attr('room');
          var data = room.split("|");
          $(".modal .modal-title").html(data[0]);
          $(".modal .modal-capacity").html(data[1]+" person");
          $(".modal .modal-facility").html(data[2]);
          $(".modal .modal-location").html(data[3]);
          $(".modal .modal-foto").attr('src',data[4]);
          $(".modal .modal-pic").html(pic);
          $(".modal .modal-book").attr('href',"?page=user-booking&room="+data[0]);
          $(".modal .modal-edit").attr('room',room);
          $(".modal .modal-edit").attr('pic',pic);
        });
	});
</script>
<div class="col-md-12 row">
	<div class="col-md-12" style="padding-top:2%;">
		<div class="col-md-3">
		</div>
		<div class="col-md-3">
			<form action="" method="post">
				<div class="input-group input-group-sm">
			   <span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-search" style="color: black;"></span></span>
			   <input type="text" class="form-control" name="cari" placeholder="search" aria-describedby="sizing-addon3">
			 </form>
			 </div>
		</div>
		<div class="col-md-2">
			<div class="input-group input-group-sm">
		   <span class="input-group-addon" id="sizing-addon3"><span class="fa fa-building" style="color: black;"></span></span>
		   <select class="form-control" aria-describedby="sizing-addon3" name="building" id="building" onchange="filter_building(this)">
			<option value="all">All Building</option>
			<?php
			//reading data
			$gedungs = $client->get_collection('gedungs');
			//do something with the data
			while ($gedungs->has_next_entity()) {
				$gedung = $gedungs->get_next_entity();
				$name = $gedung->get('name');
				$uuid = $gedung->get('uuid');
				echo "<option value=".$uuid.">".$name."</option>";
			}
			?>
			</select>
			</div>
		</div>
		<div class="col-md-2">
		   <div class="input-group input-group-sm">
			 <span class="input-group-addon" id="sizing-addon3"> <span class="fa fa-users" style="color: black;"></span></span></span>
			 <select class="form-control" aria-describedby="sizing-addon3" name="capacity" id="capacity" onchange="filter_capacity(this)">
			  <option value="0">All Capacity</option>
			  <option value="1-25"> 1-25 </option>
			  <option value="26-50"> 26-50 </option>
			  <option value="51-500"> >50 </option>
			</select>
		  </div>
		</div>
		<div class="col-md-2">
		 <div class="input-group input-group-sm">
		   <span class="input-group-addon" id="sizing-addon3"><span class="glyphicon glyphicon-sort" style="color: black;"></span></span>
			 <select class="form-control" aria-describedby="sizing-addon3" name="sort" id="sort" onchange="filter_sort(this)">
			<option value="name">Sort By</option>
			<option value="name">Name</option>
			<option value="capacity">Capacity</option>
		  </select>
		</div>
		</div>
	</div>
	<?php 
	if (isset($_SESSION['notif'])) echo $_SESSION['notif'];unset($_SESSION['notif']);?>
	<div class="col-md-12" style="padding-top:2%;" id="list_ruangan">
		<?php	

			if(isset($_POST['cari'])){
				$data = array("ql" => "select * where name ='".$_POST['cari']."'");
				//reading data ruangan
				$ruangans = $client->get_collection('ruangans',$data);
			}else{
				//reading data ruangan
				$ruangans = $client->get_collection('ruangans');
			}
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
					$listpic[$i]["phone"] = $pic->get('tel');
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
						if(in_array($uuid,$listpic[$j]["room"])){
							$roompic .="<li>".$listpic[$j]["name"]."(".$listpic[$j]["phone"].")</li>";
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
		?>
	</div>
	<!-- modal -->
	<div id="detail-room" class="modal fade modal-room" role="dialog">
	  <div class="modal-dialog" style="width: 90%;">
		<div class="modal-content" style="background: rgba(255, 255, 255, 0.89);">
		  <div class="modal-header" style="border-color: black;">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Auditorium</h4>
		  </div>
		  <div class="modal-body col-md-12">
			<div class="col-md-6">
			  <!-- carousel -->
			  <div id="myCarousel" class="carousel slide" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
				  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				</ol>

				<!-- Wrapper for slides -->
				<div class="carousel-inner">
				  <div class="item active">
					<img src="http://www.sunandmoonhotel.com/uploads/images/Gallery/Meeting-Room-Board-Room-Gallery/meeting-room-g1.jpg" style="min-width: 100%; max-height: 311px;" alt="Room" class="img-responsive modal-foto">
				  </div>
				</div>

			  </div><br>
			  <!-- end section carousel -->
			  <div id="calendar-user" style="background-color: white;"></div>
			  <script> 
			  $('#calendar-user').fullCalendar({
					header: {
						left: 'prev month',
						center: 'title',
						right: 'today next',
					},
					navLinks: true, // can click day/week names to navigate views
					eventLimit: true, // allow "more" link when too many events
					events: [
					<?php
							$no=1;
							$data = array('ql' => "select * where approved='approved'");
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
									$start = date('Y-m-d', strtotime($booking->get('tanggal'))).'T'.date('H:i:s', strtotime($booking->get('start')));
									$end = date('Y-m-d', strtotime($booking->get('tanggal'))).'T'.date('H:i:s', strtotime($booking->get('end')));
							?>
								{
									title: '<?=$ruangan->get('name')?> - <?=$booking->get('name') ?>',
									start: '<?=$start?>',
									end: '<?=$end?>',
									url: '?page=room-request-staff&room=<?=@$getRoom?>',

								},
								<?php
									$no++;
								}
							}
						?>
					],
				});
				$('#detail-room').on('shown.bs.modal', function () {
				   $("#calendar-user").fullCalendar('render');
				});
			  </script>
			</div>
			<div class="table-responsive col-md-6" style="overflow-y: scroll;">
			  <table class="table table-bordered table-room">
				<tbody>
				  <tr>
					<th><span class="fa fa-users"></span>&nbsp;Capacity</th>
					<td class="modal-capacity"></td>
				  </tr>
				  <tr>
					<th><img src="images/tools.png" alt="tool">&nbsp;Facility</th>
					<td class="modal-facility">
					</td>
				  </tr>
				  <tr>
					<th><img src="images/person_gear.png" alt="person and gear">&nbsp;Person in Change</th>
					<td class="modal-pic">
					</td>
				  </tr>
				  <tr>
					<th><span class="fa fa-map-marker"></span>&nbsp;Location</th>
					<td class="modal-location">

					</td>
				  </tr>
				</tbody>
			  </table>
			</div>
		  </div>
		  <div class="modal-footer">
			<div class="col-md-6">
				<?php
					if($_SESSION['role'] == "user"){
						echo '
							<a href="#" type="button" class="btn btn-primary modal-book">book</a>
						';
					}else if($_SESSION['role'] == "admin" OR $_SESSION['role'] == "staff"){
						echo '
						  <a href="?page=room-request-staff" type="button" class="btn btn-primary modal-manage" >manage
							<span class="badge" style="top: -10px; position: absolute; background-color: #C91F2C; color: white;"></span>
						  </a>
						</div>
						<div class="col-md-6">
						  <button type="button" class="btn btn-primary modal-edit" data-toggle="modal" onclick="closeFunction()" pic="" room="roomid" data-target="#room-edit">Edit</button>
						';
					}
				?>
			</div>
		  </div>
		</div>
	  </div>
	</div>
</div>

<script>

  function closeFunction(){
    $('#detail-room').modal('hide');
    $('#room-edit').addClass("scroll");
    $('body').addClass("scroll-hidden");
  }
</script>
