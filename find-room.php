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
        $(".detail").click(function(){
          var room = $(this).attr('room');
          var data = room.split("|");
          $(".modal .modal-title").html(data[0]);
          $(".modal .modal-capacity").html(data[1]+" person");
          $(".modal .modal-facility").html(data[2]);
          $(".modal .modal-location").html(data[3]);
          $(".modal .modal-foto").attr('src',data[4]);
          $(".modal .modal-book").attr('href',"?page=user-booking&room="+data[0]);
        });
	});	
</script>
<div class="col-md-12 row">
	<div class="col-md-12" style="padding-top:2%;">
		<div class="col-md-4">
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
			while ($ruangans->has_next_entity()) {
				$ruangan = $ruangans->get_next_entity();
				$name = $ruangan->get('name');
				$uuid = $ruangan->get('uuid');
				$capacity = $ruangan->get('capacity');
				$facility = $ruangan->get('facility');
				$location = $ruangan->get('address');
				$foto = $ruangan->get('foto');
			?>
				  <!-- box find room -->
				  <div class="col-sm-3">
					<div class="border-box panel panel-info">
					  <div class="panel-body text-center" style="background: rgba(255, 255, 255, 0.5);">
						<img src="<?php echo $foto;?>" class="img-responsive pull-center" style="width:150px;height:150px;" alt="Image">
						<?php echo $name;?><br>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star"></span>
						<span class="glyphicon glyphicon-star-empty"></span>
						<br><span class="glyphicons glyphicons-group" style="color: black;"><?php echo $capacity;?> person</span>
						<br><span class="glyphicons glyphicons" style="color: black;"><?php echo $facility;?></span>
						<br><a class="btn btn-primary pull-center detail" room="<?php echo $name."|".$capacity."|".$facility."|".$location."|".$foto; ?>" data-toggle="modal" data-target="#detail-room">Detail</a>
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
          <div id="calendar" style="background-color: white;"></div>
        </div>
        <div class="table-responsive col-md-6" style="overflow-y: scroll;">
          <table class="table table-bordered table-room">
            <tbody>
              <tr>
                <th><span class="fa fa-users"></span>&nbsp;Capacity</th>
                <td class="modal-capacity">50 Person</td>
              </tr>
              <tr>
                <th><img src="images/tools.png" alt="tool">&nbsp;Facility</th>
                <td class="modal-facility">
                </td>
              </tr>
              <tr>
                <th><img src="images/person_gear.png" alt="person and gear">&nbsp;Person in Change</th>
                <td>
                  Admin 1 <br>
                  &nbsp;+62891782993320 <br>
                  &nbsp;admin@telkom.co.id <br> <br>
                  Admin 2 <br>
                  &nbsp;+62891782993320 <br>
                  &nbsp;admin@telkom.co.id 
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
          <a href="#" type="button" class="btn btn-primary modal-book">book</a>
          <a href="?page=room-request-staff" type="button" class="btn btn-primary modal-manage" >manage
            <span class="badge" style="top: -10px; position: absolute; background-color: #C91F2C; color: white;">2</span>
          </a>
        </div>
        <div class="col-md-6">
          <button type="button" class="btn btn-primary" data-toggle="modal" onclick="closeFunction()" data-target="#room-edit">Edit</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- modal edit room  -->
<div id="room-edit" class="modal fade modal-room" role="dialog">
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
              <li data-target="#myCarousel" data-slide-to="1"></li>
              <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
              <div class="item active">
                <img src="http://www.sunandmoonhotel.com/uploads/images/Gallery/Meeting-Room-Board-Room-Gallery/meeting-room-g1.jpg" style="min-width: 100%; max-height: 311px;" alt="Room" class="img-responsive">
              </div>
              <div class="item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0Ow6h51zUzYd_O9bWUJWHlvm2dEwOOrEITcd9nwnfNI5ANEHj" style="min-width: 100%; max-height: 311px;" alt="Room" class="img-responsive">
              </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <span class="sr-only">Next</span>
            </a>
          </div><br>
          <!-- end section carousel -->
          <div id="kalendar" style="background-color: white;"></div>
        </div>
        <div class="table-responsive col-md-6" style="overflow-y: scroll;">
          <style type="text/css" media="screen">

          </style>
          <form action="" method="" accept-charset="utf-8">
            <table class="table table-bordered table-room-edit">
              <tbody>
                <tr>
                  <th><span class="fa fa-users"></span>&nbsp;Capacity</th>
                  <td><input type="text" name="capacity" value="50 Person" style="border-color: transparent;"></td>
                </tr>
                <tr>
                  <th><img src="images/tools.png" alt="tool">&nbsp;Facility</th>
                  <td>
                    <ul>
                      <li>Projector (1)</li>
                      <li>White Board (1)</li>
                      <li>Sofa (1)</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <th><img src="images/person_gear.png" alt="person and gear">&nbsp;Person in Change</th>
                  <td>
                    <textarea name="person_in_change">
                      Admin 1 
                      +628917S82993320 
                      admin@telkom.co.id 
                      Admin 2 
                      +62891782993320
                      admin@telkom.co.id
                    </textarea>
                  </td>
                </tr>
                <tr>
                  <th><span class="fa fa-map-marker"></span>&nbsp;Location</th>
                  <td><input type="text" name="location" value="Jl. Geger Kalong no. 33, Bandung, Jawa Barat Indonesia"></td>
                </tr>
              </tbody>
            </table>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary text-center">Save</button>
      </div>
    </div>
  </div>
</div>


</div>
<script>

  $(document).ready(function() {

    $('#calendar').fullCalendar({
      header: {
        left: 'prev',
        center: 'title',
        right: 'next',
      },
      defaultDate: '2017-05-12',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      
    });
    
  });

  $(document).ready(function() {

    $('#kalendar').fullCalendar({
      header: {
        left: 'prev',
        center: 'title',
        right: 'next',
      },
      defaultDate: '2017-05-12',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      
    });
    
  });

  function closeFunction(){
    $('#detail-room').modal('hide');
    $('#room-edit').addClass("scroll");
    $('body').addClass("scroll-hidden");
  }
</script>