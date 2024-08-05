<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 550px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
        
    /* On small screens, set height to 'auto' for the grid */
    @media screen and (max-width: 767px) {
      .row.content {height: auto;} 
    }
	table, th, td {
  border:1px solid black;
}
.btn-sm,a{
	margin:5px !important;
}
  </style>
</head>
<body>
	<nav class="navbar navbar-inverse visible-xs">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>                        
		  </button>
		  <a class="navbar-brand" href="#">Logo</a>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
		  <ul class="nav navbar-nav">
			<li class="active"><a href="#">Dashboard</a></li>
			<li><a href="#">List of Users</a></li>
			<li><a href="#">List of Files</a></li>
		  </ul>
		</div>
	  </div>
	</nav>
	<div class="container-fluid">
		<div class="row content">
			<div class="col-sm-3 sidenav hidden-xs">
			  <h2></h2>
			  <ul class="nav nav-pills nav-stacked">
				<li class="active"><a href="<?php echo site_url().'courses-list';?>">List of courses</a></li>
				<li><a href="<?php echo site_url().'lessons-list';?>">List of lessons</a></li>
				<li><a href="<?php echo site_url().'welcome/logout'?>">Logout</a></li>
			  </ul><br>
			</div>
			<br>
			
			<div class="col-sm-9">
				<div class="well">
					<h4 class="text-center">Dashboard</h4>
				</div>
				
				<div class="row">
					<div class="col-12">
						<div class="well text-center">
					  <?php
					  
					  if(!empty($bdata))
					  {
						  $objdata = $bdata->data;
// echo "<pre>"; print_r($objdata);exit;
					  ?>
							<form action="<?php echo site_url().'course-update';?>" method="post">
								<input type="text" style="display:none;" name="courseid" value="<?php echo $objdata->id;?>">
								<div class="form-group">
									<label for="uname"><b>Title</b></label>
									<input type="text" placeholder="Enter title" name="title" value="<?php echo $objdata->title; ?>">
								</div><br/>
								<div class="form-group">
									<label for="uname"><b>Description</b></label>
									<input type="text" placeholder="Enter description" name="description" value="<?php echo $objdata->description; ?>">
								</div><br/>
									
								<div class="form-group">
									<label for="uname"><b>Instructor</b></label>
									<input type="text" placeholder="Enter instructor" name="instructor" value="<?php echo $objdata->instructor; ?>">
								</div><br/>
								<div class="form-group">
									<label for="psw"><b>Duration</b></label>
									<input type="number" placeholder="Enter duration" name="duration" value="<?php echo $objdata->duration; ?>">
								</div><br/>
								<button type="submit" class="text-center">Update</button>
							</form>	
<?php
							
						  }
?>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<script>
var data = <?php echo $this->session->flashdata('flash_message')?>;
if(data != '' & data!=undefined)
alert(data);
</script>

