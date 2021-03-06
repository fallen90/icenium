		Object.size = function(obj) {
			var size = 0, key;
			for (key in obj) {
				if (obj.hasOwnProperty(key)) size++;
			}
			return size;
			};
		
		var con = $(".status");
		var error_downloads = [];
		var cur_downloads = 0;
		var download_total = 0;
		var batch_done = false;
		var chaptersJSON = "";
		var accesscode = "jasper";
		var wattcode ="";
		var errors = 0;
		
	$(document).ready(function(){
		
		//feedbacks
		$('#submit').click(function(){
			var name = $('#name').val();
			var email = $('#email').val();
			var content = $('#content').val();
			
			if(name =="" || email =="" || content ==""){
				alert("Please complete all required fields");
			} else {
				$('.feedbackmessage').slideDown();
				$('#feedbackform').slideUp();
				$.post("./feedback.php",{
						name: name,
						email:email,
						content:content
					}).done(function(data){
					if(data == "success"){
						$('.feedbackmessage').find("h1").html("Feedback Submitted!!");
						$('.feedbackmessage').append("<p>Thank you for submitting your feedback to us, this would be a very valuable in the improvement of this downloader. Thank you again ^_^</p>");
						
					}
					});
			}
		});		
		$('[data-dismiss=modal]').click(function(){
			$('.feedbackmessage').slideUp();
			$('#feedbackform').slideDown();
			$('#name').val("");
			$('#email').val("");
			$('#content').val("");
			
		});
		$('#clse').click(function(){
			$('.feedbackmessage').slideUp();
			$('#feedbackform').slideDown();
			$('#name').val("");
			$('#email').val("");
			$('#content').val("");
			
		});
		//end of feedbacks
		
		
		
		$('#download').click(function(){
		
		try {
			
			wattcode = ( $('input.wattcode').val());
			if(wattcode ==""){
				return false;
			}
			$('.form').fadeOut();
			$('.progress').fadeIn();
			write("Getting Chapter List...");
			$.get( "./cyborg/wat/getchapters.php", { wattcode: wattcode } )
			  .done(function( data ) {
				chaptersJSON = data;
				
				
				if(data =="The wattcode is not valid or the page is no longer available.") {
					write("The wattcode is not valid or the page is no longer available.");
						$('.form').fadeIn();
						$('.progress').fadeOut();
					return false;
				} else if(data == "The title you requested is no longer available.") {
					write("The title you requested is no longer available.");
						$('.form').fadeIn();
						$('.progress').fadeOut();
						return false;
				} else if(data == "error in fetching chapters"){
					write("error in fetching chapters ");
						$('.form').fadeIn();
						$('.progress').fadeOut();
						return false;
				}
				$('#step1').fadeOut();
				$('#step2').fadeIn();
				console.log( "Response:" + data + "");
				var chapters = $.parseJSON(data);
				var indv_incr = ((1/Object.size(chapters))*100)
				$.each(chapters, function( index, value ) {
					
					 downloadChapter(index,value);
					download_total++;
				});
			  });
			} catch(Ex){
				write("<b>" +Ex +"</b>");
			}
		});
		function downloadChapter(index,value){
			var str = '<span href="#" class="list-group-item dl-active" id="chap'+value+'">'+
						index+
						'<span class="badge"><span class="glyphicon glyphicon-cloud-download"></span></span>'+
						'</span>';
			addDownload(str);
			$.get( "./cyborg/wat/getcontent.php", { wattcode: value, accesscode: accesscode} )
				 .done(function( data ) {
					if(data == "ERROR_DOWNLOAD"){
						$('#chap' + value).remove();
						downloadChapter(index,value);
						errors ++;
					} else {
						doneDownload(value);
					}
					cur_downloads--;
					
					
					if(cur_downloads==0){		
					//PACKAGING
					$('#step2').fadeOut();
					$('#step3').fadeIn();
					
							write("Packing file for download...");
							$('.progress').fadeIn();
									$.post( "./cyborg/wat/getpackage.php", { wattcode: wattcode,chapters: chaptersJSON,accesscode: accesscode } )
										 .done(function( data ) {
											try{
												write("Download Done!...");
												var packs = $.parseJSON(data);
												$('#txt').attr('rel',packs['txt']).removeClass("notyet");
												$('#zip').attr('rel',packs['zip']).removeClass("notyet");
												$('.progress').fadeOut();
											} catch(ex){
												write("Error Fetching Packages");
												console.log(data);
											}
										 });
										 
										
								
						
						updateDownloadCounter(cur_downloads,error_downloads.length);
					} else if(cur_downloads==1){
						write("<c>" + cur_downloads + " Chapters Left, "+errors+" errors so far.</c>");
						updateDownloadCounter(cur_downloads,error_downloads.length);
					} else {
						write("<c>" + cur_downloads + " Chapters Remaining, "+errors+" errors so far.</c>");
						updateDownloadCounter(cur_downloads,error_downloads.length);
					}
			});
			cur_downloads++;
			write("<e>" + cur_downloads + " Chapter Downloads Started</e>");
		}
		function updateDownloadCounter(count,errors){
			//$('.count').text(count);
			//$('.errors').text(errors);
			var percent = 100 - ((count/download_total) * 100);
			$('.progress-bar').width(percent + "%");
		}
		function write(msg){
			$(".status").html(msg);
		}
		function addDownload(file){
			$("#downloads").append(file);
		}
		function doneDownload(wattcode){
			$("#chap" + wattcode).removeClass("dl-active");
			$("#chap" + wattcode).addClass("dl-done");
			$("#chap" + wattcode).children(".badge").children("span").attr("class","glyphicon glyphicon-ok");
		}
		$('#txt').click(function(){
			var rel_data = $(this).attr('rel');
			$('iframe').attr("src",rel_data);
		});
		$('#zip').click(function(){
			var rel_data = $(this).attr('rel');
			 $('iframe').attr("src",rel_data);	
		});
		$('.list-group-item').click(function(){
			var rel_data = $(this).attr('rel');
			 $('iframe').attr("src",rel_data);	
		});
		$('#ice').click(function(){
			$('#not').modal('toggle');
		});
		$('#pdf').click(function(){
			$('#not').modal('toggle');
		});
		
		//mobile taps
		$('#txt').on("touchstart",function(){
			var rel_data = $(this).attr('rel');
			var url = rel_data;
            var windowName = "popUp";//$(this).attr("name");
			var windowSize = "width=10,height=10";
			window.open(url, windowName, windowSize);

		});
		$('#zip').on("touchstart",function(){
			var rel_data = $(this).attr('rel');
			var url = rel_data;
            var windowName = "popUp";//$(this).attr("name");
			var windowSize = "width=10,height=10";
			window.open(url, windowName, windowSize);	
		});
		$('#ice').on("touchstart",function(){
			$('#not').modal('toggle');
		});
		$('#pdf').on("touchstart",function(){
			$('#not').modal('toggle');
		});
	});