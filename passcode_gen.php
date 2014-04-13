<?php
session_start();

if(!isset($_SESSION['admin'])){
	header("Location: passcode.php");
}

if(isset($_POST['code'])){
	mysql_connect("localhost","root","") or die(mysql_error());
	mysql_select_db("w2a");
	
	$name    = $_POST['name'];
	$code    = $_POST['code'];
	$active  = $_POST['active'];
	
	
	$sql="SELECT * FROM `passcode` WHERE code='$code'";
	$query = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($query) == 1) {
		//duplicate, update 
		$sql = "UPDATE `passcode` SET name='$name', code='$code' WHERE active='$active'";
		mysql_query($sql) or die(mysql_error());
		$msg = "Updated passcode for <label class='label'>" . $name . "</label> with code <i>" . $code . "</i>";
	} else {
		//no results/duplicates found
		//no duplicates means, we need to insert
		$sql="INSERT INTO `passcode` (`name`,`code`,`active`) VALUES('$name','$code','$active')";
		mysql_query($sql) or die(mysql_error());
		$msg = "Added passcode for <label class='label'>" . $name . "</label> with code <i>" . $code . "</i>";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title>Icenium</title>

    <!-- Bootstrap core CSS -->
    <link href="./cyborg/css/bootstrap.min.css" rel="stylesheet">
	<style>
		iframe {
			width:0;
			height:0;
			border:0px;
			outline:none;
			display:none;
		}
		body {
			padding-top:40px;
		}
		.container {
			min-width:70%;
		}
		
		.dl-active {
			background-color:#77B300 !important;
			color:white !important;

		}
		.dl-done {
			background-color:#2A9FD6 !important;
			color:white !important;
		}
		span.load {
			background-image:url('./cyborg/loader-white.gif');
			background-size:cover;
			padding:1px 9px;
		}
		#steps {
			margin:0 auto;
		}
		#step1,#step2,#step3 {
			margin:20px auto;
		}
		#step2,#step3 {
			display:none;
		}
		.modal-dialog {
			margin:10% auto;
		}
		.nav li > a:hover{
			background:#2A9FD6;
		}	
		.nav li > a:active{
			background:#2A9FD6;
		}
		.notyet {
			display:none;
		}
		.progress {
			display:none;
		}
	</style>
   

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <!-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button> -->
		  <button type="button" class="navbar-toggle" data-toggle="modal" data-target="#menu">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
   
		  </button>
          <a class="navbar-brand" href="#">Icenium</a>
        </div>
        <div class="navbar-collapse collapse" id="navbar">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
          
            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container theme-showcase">

      
      <div class="page-header">
        <h1>Downloader</h1>
      </div>
     
	 <div class="row" >
	<div class="col-sm-3"></div>
        <div id="steps"	class="col-sm-6">
          <div class="panel panel-primary " id="step1">
            <div class="panel-heading">
              <h3 class="panel-title">Passcode Generator</h3>
            </div>
            <div class="panel-body">
             		 
				<div class="form">
				<form action="" method="POST">
				
				<input type="text" value="" name="name" placeholder="Name" class="form-control">
				<input type="text" value="" name="code" placeholder="Passcode" class="form-control">
				<select name="active" class="form-control">
					<option value="1">Active</option>
					<option value="2">InActive</option>
				</select>
						
				<input type="submit" class="btn btn-primary btn-block" value="Generate">
				</form>
			  </div>
			  
            </div><!--  panel body end -->
			<div class="panel-footer">
				<cite class="status"><?php if (isset($msg)) { echo $msg; } ?></cite>
			</div>
          </div> <!-- panel end -->
		  
          <div class="panel panel-primary" >
            <div class="panel-heading">
              <h3 class="panel-title">Passcodes</h3>
            </div>
            <div class="panel-body">
              
			  <div class="well">
				
	
			
						
					<table class="table table-striped table-bordered table-hover">
								<thead>
								  <tr>
									<th>#</th>
									<th>Name</th>
									<th>Passcode</th>
									<th>Status</th>
								  </tr>
								</thead>
								<tbody>
				<?php
					mysql_connect("localhost","root","") or die(mysql_error());
					mysql_select_db("w2a");
					$sql="SELECT * FROM `passcode`";
					$result = mysql_query($sql) or die(mysql_error());
					
					while($row = mysql_fetch_assoc($result)) {				
				?>
							
									<tr class="success" id="<?php echo $row['id'];?>">
										<td><?php echo $row['id'];?></td>
										<td><?php echo $row['name'];?></td>
										<td><?php echo $row['code'];?></td>
										<td>
											<?php 
												if($row['active'] == '1') {
													echo 'Active';
												} else {
													echo 'InActive';
												}
											?>
										</td>
										
									</tr>
				<?php  } ?>						
								</tbody>
							  </table>
					
				
			  </div> 
            </div><!--  panel body end -->
			<div class="panel-footer">
				<cite class="status">idle</cite>
			</div>
          </div> <!-- panel end -->
		  
        </div><!-- /.col-sm-12 -->
        
      </div>




    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./cyborg/js/jquery.js"></script>
    <script src="./cyborg/js/bootstrap.min.js"></script>
    <script src="./cyborg/js/holder.js"></script>
    

		<!-- Modal -->
		<div class="modal fade" id="menu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Menu</h4>
			  </div>
			  <div class="modal-body">
					<ul class="nav nav-pills nav-stacked">
						<li class="active"><a href="index.php">Home</a></li>
						<li><a href="#">Downloader</a></li>
						<li><a href="#">How to Use</a></li>
						<li><a href="#">Abouts</a></li>
						<li><a href="#">Contact</a></li>
					</ul>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		<div class="modal fade" id="not" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Notice</h4>
			  </div>
			  <div class="modal-body">
					<h3>Not yet implemented</h3>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
  </body>
</html>
<iframe src="" name="dl"></iframe>