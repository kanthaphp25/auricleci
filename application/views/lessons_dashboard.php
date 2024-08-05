<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />

  
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
.btn-sm{
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
        <li ><a href="<?php echo site_url().'courses-list';?>">List of courses</a></li>
        <li class="active"><a href="<?php echo site_url().'lessons-list';?>">List of lessons</a></li>
        <li><a href="<?php echo site_url().'welcome/logout'?>">Logout</a></li>
      </ul><br>
    </div>
    <br>
    
    <div class="col-sm-9">
      <div class="well">
        <h4 class="text-center">Dashboard</h4>
		<?php
			if(!empty($_SESSION['user_id']))
			{
		?>
		<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal" class="btn btn-success">
		Create Lesson</button>
		<?php
			}
		?>		
		</div>
		
		<div class="row">
			<div class="col-12">
				<div class="well">
					<table style="width:100%">
					  <tr>
						<th>Id</th>
						<th>Title</th>
						<th>Content</th>
						<th>Course Id</th>
						<th>Created at</th>
						<th>Updated at</th>
						<th>Action</th>
					  </tr>
					  <?php
					  // echo "<pre>";print_r($bdata);exit;
					  if(!empty($ldata) || !empty($cdata))
					  {
						  if(!empty($ldata))
						  {
							$objdata = $ldata->data->data;
						  }
						  else
						  {
							  
							 $objdata = $cdata->data; 
						  }
					  // echo "<pre>";print_r($objdata);exit;
						foreach($objdata as $row)
						  {
							  
							  if(isset($row->id))
							  {
					  ?>
					  <tr>
						<td><?php echo $row->id;?></td>
						<td><?php echo $row->title;?></td>
						<td><?php echo $row->content;?></td>
						<td><?php echo $row->course_id;?></td>
						<td><?php echo date('d-M-Y',strtotime($row->created_at));?></td>
						<td><?php echo date('d-M-Y',strtotime($row->updated_at));?></td>
						<td>
		<button type="button" class="btn btn-primary btn-sm">
		<a style="color:white" href="<?php echo site_url().'lesson-update-view/'.$row->id;?>">Update</a></button>
		<button type="button" class="btn btn-danger btn-sm"> 
		<a style="color:white;" href="<?php  echo site_url().'delete-lesson/'.$row->id; ?>">Delete</a></button>
						</td>
					  </tr>
					  <?php
							}
						  }
					}
					  ?>
					</table>	
					<p><?php //echo $links; ?></p>					
				</div>
			</div>
		</div>
    </div>
  </div>
</div>

<div class="container">
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
		  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Create Lesson</h4>
				</div>
				<div class="modal-body">
					<form action="<?php echo site_url().'create-lesson';?>" method="post">
						<div class="container">
							<label for="uname"><b>Title</b></label>
							<input type="text" placeholder="Enter title" name="title" required>
						</div><br>
						<div class="container">
							<label for="uname"><b>Content</b></label>
							<input type="text" placeholder="Enter description" name="content" required>
						</div><br>
						<div class="container">
							<label for="uname"><b>Course Id</b></label>
							<select class="form-select"  name="course_id">
							<?php
							$objdata1 = $courses->data->data;

							foreach($objdata1 as $res)
							{
							?>
							  <option value="<?php echo $res->id;?>"><?php echo $res->title;?></option>
							  <?php
							}
							  ?>
							</select>
						</div>
						<button type="submit" class="text-center">Create</button>
					</form>		
				</div>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
    </div>
  </div>

</body>
</html>
<script>
$(function() {
  $('.selectpicker').selectpicker();
});


</script>

