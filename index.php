<?php
session_start();

if(!isset($_SESSION['unlocked'])){
	header("Location: lock.php");
}
if(isset($_GET['lock'])){
	session_destroy();
	header("Location: lock.php");
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
	<script src="./cyborg/js/jquery.js"></script>
    <script src="./cyborg/js/bootstrap.min.js"></script>
    <script src="./cyborg/js/holder.js"></script>
    <script src="./cyborg/js/script.js"></script>
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
		#downloads {
			height:400px;
			overflow:auto;
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
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#download">Downloader</a></li>
            <li><a href="#how"  data-toggle="modal" data-target="#how">How to Use</a></li>
            <li><a href="#about"  data-toggle="modal" data-target="#not">About</a></li>
            <li><a href="#contact"  data-toggle="modal" data-target="#not">Contact</a></li>
            <li><a href="#feedback"  data-toggle="modal" data-target="#feedback">Feedback</a></li>
            <li><a href="?lock" ><label style="cursor:pointer;" class="badge badge-danger"><span class="glyphicon glyphicon-lock"></span> Lock</label></a></li>
            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container theme-showcase">

      
      <div class="page-header">
        <h1>Hello there <?php echo $_SESSION['name'];?></h1>
      </div>
     
	 <div class="row" >
	 <div class="col-sm-1"></div>
        <div id="steps"	class="col-sm-10">
          <div class="panel panel-primary " id="step1">
            <div class="panel-heading">
              <h3 class="panel-title">Step 1</h3>
            </div>
            <div class="panel-body">
              <div class="alert dl-done">
				<span class="glyphicon glyphicon-question-sign"></span><strong> Instructions</strong>
				Get the wattcode of the chapter of the book you want to download
			  </div>
			 
				<div class="form">
					<div class="input-group">
						<input type="text" value="4667724" class="wattcode form-control">
						<span class="input-group-btn">
						  <button class="run btn btn-primary" id="download" type="button"><span class="glyphicon glyphicon-save"></span> Download</button>
						</span>
					</div>
				
			  </div>
			  <div class="progress progress-striped active">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
            </div><!--  panel body end -->
			<div class="panel-footer">
				<cite class="status">idle</cite>
			</div>
          </div> <!-- panel end -->
		  
          <div class="panel panel-primary" id="step2">
            <div class="panel-heading">
              <h3 class="panel-title">Step 2</h3>
            </div>
            <div class="panel-body">
				<div class="alert dl-done">
					<span class="glyphicon glyphicon-question-sign"></span><strong> Instructions</strong>
					Wait for the download to finish
				</div>
			<div class="row">
              <div class="col-lg-12">
				<div class="progress progress-striped active">
					<div class="progress-bar" style="width: 0%"></div>
				</div>
				 
					
					<div class="panel-group" id="accordion">
					  <div class="panel panel-primary">
					   
					  <div class="panel panel-primary">
						<div class="panel-heading">
						  <h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
							  Details
							</a>
						  </h4>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse">
						  <div class="panel-body">
						   <div class="list-group" id="downloads">	  </div> <!-- DOWNLOADS GOES HERE -->
						  </div>
						</div>
					  </div>
					 </div>
					</div>
			  </div>
			</div>
            </div>
			<div class="panel-footer">
				<cite class="status">idle</cite>
			</div>
			
          </div> <!-- end of panel -->
		  
		  
		    <div class="panel panel-primary" id="step3">
            <div class="panel-heading">
              <h3 class="panel-title">Step 3</h3>
            </div>
            <div class="panel-body">
              <div class="alert dl-done">
				<span class="glyphicon glyphicon-question-sign"></span><strong> Please wait</strong>
				Packaging the book...
			  </div>
			  <div class="well">
				<h3>Click to download package</h3>
				<div class="row">
					<div class="col-sm-3">
						<button id="txt" class="btn btn-success btn-block notyet" rel="" >TXT Package</button>
					</div>
					<div class="col-sm-3">
						<button id="zip" class="btn btn-info btn-block notyet" rel="">ZIP Package</button>
					</div>
					<div class="col-sm-3">
						<button onClick="document.location.reload(true)" class="btn btn-primary btn-block " rel="">Download Another</button>
					</div>
					
					<div class="col-sm-3">
						<button id="pdf" class="btn btn-warning btn-block notyet" rel="">PDF Package</button>
					</div>
				</div>
				<br>
				<div class="progress progress-striped active">
					<div class="progress-bar" style="width: 100%"></div>
				</div>
			  </div> 
            </div><!--  panel body end -->
			<div class="panel-footer">
				<cite class="status">idle</cite>
			</div>
          </div> <!-- panel end -->
		  
		  
		  
		  
		  <div style="width:100%;height:20px;"></div>
		  <!-- BOOKS -->
		  <div class="panel panel-primary" >
            <div class="panel-heading">
              <h3 class="panel-title">Download History</h3>
            </div>
            <div class="panel-body">
              
			  <div class="well">
				<div class="list-group">
				<?php
					mysql_connect("localhost","root","jasper90") or die(mysql_error());
					mysql_select_db("w2a");
					$sql="SELECT * FROM `downloads`";
					$result = mysql_query($sql) or die(mysql_error());
					
					while($row = mysql_fetch_assoc($result)) {				
				?>
				
						<a href="#" class="list-group-item" rel="<?php echo $row['zip'];?>">
							<h4 class="list-group-item-heading">
								<?php echo $row['bookid'];?>
							</h4>
							<p class="list-group-item-text">
								WATTCODE USED: <?php echo $row['wattcode']; ?>
							</p>
						</a>
						
						
				<?php  } ?>		
						
					</div>
					
				<div class="progress progress-striped active">
					<div class="progress-bar" style="width: 100%"></div>
				</div>
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
    
	<script>
		$(document).ready(function(){
			$("#another").click(function(){
				history.go(0);
			});
		});
	</script>
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
						<li class="active"><a href="#">Home</a></li>
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
		
		<div class="modal fade" id="how" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Notice</h4>
			  </div>
			  <div class="modal-body">
					<img src="ins.jpg" width="100%" />
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
			<div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="clse">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Feedback</h4>
			  </div>
			  <div class="modal-body">
					<div class="well" id='feedbackform'>
					<h1>Send your feedback</h1>
					<p>Did you like this downloader? Send us your comments or suggestions to improve this ^_^</p>
					
						<div class="form-group">
							<input type="text" class="form-control" id="name" placeholder="Your Name">
						</div>
						<div class="form-group">
							<input type="email" class="form-control" id="email" placeholder="Your Email">
						</div>
						<div class="form-group">
							<textarea class="form-control" id="content" placeholder="Your Feedback"></textarea>
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-primary" id="submit">Submit Feedback</button>
						</div>
					</div>
					<div class="feedbackmessage"  style="display:none">
						<h1>Sending Feedback...</h1>
					</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="clse">Close</button>
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		
  </body>
</html>
<iframe src="" name="dl"></iframe>