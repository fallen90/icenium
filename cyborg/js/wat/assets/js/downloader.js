$('#question').click(function(){
		$('#how').modal('show');
	});
	bookname = "<i>Fetching name...</i>";
	dl_id = "";
	  $("#download").click(function(){
	  if (~document.getElementById('coverurl').value.indexOf('') !== -1){
	    	alert("EMPTY");  
	  }
	  
	  
		  var lol = document.getElementById('coverurl').value;
		  html = "";
		 	$.get("checkinput.php",
				{
				  bookcover: lol
				},
			function(html,status){
			
				if (html !== "invalid url format"){
					if(status=='success'){
					document.getElementById('coverurl').value = "";
					$('#download').hide().slideUp();
					dl_id = "";
					dl_id = html;
					
					if($('#' + dl_id).doesExist()){
							//true
						alert("Book is already on your download list");
						$('#well_' + dl_id).effect("highlight", {  color: "red" }, 1500);
						throw "stop execution";
						}
					$.get("download.php",
						{
						  bookidx: dl_id,
						 
						},function (html,status){
						bn = html.split("|");
						$('#bookname_'+bn[0]).html(bn[1]);
						});
					 $('.downloads').prepend("<br><div id='"+dl_id+"'></div>");
					 datay = '<div id="well_'+dl_id+'"class="well well-small download"><img src="http://a.wattpad.net/cover/' + dl_id + '-64.jpg" class="img-polaroid pull-left"><div class="alert alert-info"><strong id="bookname_'+dl_id+'">' + bookname + '</strong><label class="label label-inverse indicator" id="completed_' + dl_id + '" ><img src="assets/img/ajaxloader.gif"> inprogress</label><div id="downloadlink_' + dl_id + '"></div>';
					
					 $('#'+ dl_id).html(datay).hide().slideDown();
					 
						 //if success
						 
						 indicator = '<img src="assets/img/ajaxloader.gif">  in progress';
						 $('#completed_' + dl_id).html(indicator);
						 lolz = html;
							 $.post("download.php",
								{
								  bookid: lolz
								},
								function(html,status){
								 if(status=='success'){
										if(!(new RegExp('wattpad not available')).test(html)){
											 //if success
											 part = html.split("|");
											 bookid = part[0];
											 bookurl = part[1];
											 datax = '<a class="btn btn-success pull-right" type="button" href="'+ bookurl + '" target="_blank"><i class=" icon-download-alt icon-white"></i> Download Book Now</a>';
											 
											 
												if(!(new RegExp('error')).test(html)){
													$('#completed_' + bookid).html('<i class="icon-ok-circle icon-white"></i> completed');
													$('#completed_' + bookid).attr('class','label label-success indicator');
													$('#well_' + bookid).effect("highlight", {  color: "green" }, 1500);
													$('#downloadlink_'+ bookid).html(datax);
												}else{
												
													$('#completed_' + bookid).html("<h3>Something Went Wrong, Please Refresh page.</h3>" + html);
												}
										
											}else {
												datax = '';
												
													$('#completed_' + bookid).html('<h4>Wattpad Not Available</h4><i class="icon-remove-circle icon-white"></i> error occured');
													$('#completed_' + bookid).attr('class','label label-important indicator');
													$('#well_' + bookid).effect("highlight", {  color: "red" }, 1500);
													$('#downloadlink_'+ bookid).html(datax);
											}
										}
									}
								);
						} else {
							//if failed
							 $('#mpl').html("FAILED");
							  $('#alert').modal('show');	
						}
				}else {
					$('#status').html(html);
				}
			});
		});
		
			
	
	$(document).ready(function(){
	//	$('#alert').modal('show');
	});
	
	function checkInput(str)
				{
			if (str.length==0)
					  { 
						  document.getElementById("check").innerHTML='<img src="assets/img/ajaxloader.gif">';
						  return;
						  }
							if (window.XMLHttpRequest)
							  {// code for IE7+, Firefox, Chrome, Opera, Safari
								xmlhttp=new XMLHttpRequest();
							  }
								else
							  {// code for IE6, IE5
								xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
							  }
							xmlhttp.onreadystatechange=function()
								{
									if (xmlhttp.readyState==4 && xmlhttp.status==200)
								{
									document.getElementById("check").innerHTML=xmlhttp.responseText;
									if(!(new RegExp('invalid')).test(xmlhttp.responseText)){
										//doesnt contain invalid
										$('#check').hide().slideUp();
										$('#download').hide().slideDown();
										
									}else {
										$('#download').hide().slideUp();
									}
								}
					  }
					xmlhttp.open("GET","checkinput.php?bookcover="+str,true);
					xmlhttp.send();
					
					
			}
			
		$('#download').click(function(){
		$(".alert").alert();
	});
	
	
	$.fn.doesExist = function(){
	return jQuery(this).length > 0;
};