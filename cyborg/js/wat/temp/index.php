<?php

?>
<style>
	body{
		margin:0;
		padding:0;
	}
	.console {
		width:80%;
		display:block;
		height:60%;
		background:#111;
		color:white;
		font-family:Consolas;
		font-size:18px;
		padding:5px;
		margin:10% auto;
		margin-bottom:0;
		overflow:auto;
	}
	.run {
		display:block;
		padding:5px;
		background:#444;
		text-align:center;
		width:50%;
		margin:0 auto;
		color:white;
		text-decoration:none;
	}
	i {
		background:url('./assets/img/ajaxloader.gif');
		padding:2px 13px;
		background-size:cover;
	}
	b {
		color:#D90000;
	}
	c {
		color:#007FFF
	}
	e {
		color:#00B300
	}
	
	.progress {
		position:fixed;
		top:0;
		left:0;
		width:100%;
		height:20px;
		background:#222;
		transition:all 500ms ease-in-out;
	}
	.bar {
		background:green;
		position:fixed;
		top:0;
		left:0;
		z-index:10000;
		height:20px;
		width:0%;
		transition:all 500ms ease-in-out;
	}
</style>
<script src="./assets/js/jquery.js"></script>


<div class="counter">
Downloads Remaining: <div class="count"></div> <br>

Errors Encountered: <div class="errors"></div>

</div>
<div class="console">
CONSOLE: Idle
</div>
<a href="#" class="run">RUN</a>

<iframe src=""></iframe>

<script src="./assets/js/script.js"></script>