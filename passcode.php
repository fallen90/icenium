<?php
session_start();

if(isset($_POST['code'])){
	if ($_POST['code'] == "jasper90") {
		$_SESSION['admin'] = true;
		header("Location: passcode_gen.php");
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
            <li class="active"><a href="#">Home</a></li>
          
            
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
              <h3 class="panel-title">Step 1</h3>
            </div>
            <div class="panel-body">
              <div class="alert dl-done col-sm-6 col-sm-offset-3">
				<span class="glyphicon glyphicon-question-sign"></span><strong> Instructions</strong>
				Input the Unlock Code Given to you.
			  </div>
			 
				<div class="form">
				<form action="" method="POST">
					<div class="input-group col-sm-6 col-sm-offset-3" >
						
						<input type="text" value="" name="code" placeholder="Unlock Code Please" class="form-control">
						<span class="input-group-btn">
						  <input  class="run btn btn-primary" type="submit" value="Unlock">
						
						</span>
					</div>
				</form>
			  </div>
			  <div class="progress progress-striped active">
                <div class="progress-bar" style="width: 100%"></div>
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
  </body>
</html>
<iframe src="" name="dl"></iframe>