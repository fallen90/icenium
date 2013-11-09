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
		var batch_done = false;
		var chaptersJSON = "";
		var accesscode = "jasper";
		var wattcode ="";
		var errors = 0;
	$(document).ready(function(){
		
		$('.run').click(function(){
		
		try {
			$('.chapters').html("");
			wattcode = ( $('input.wattcode').val());
			if(wattcode ==""){
				return false;
			}
			write("Download Started");
			$('.debug').fadeOut();
			write("<i></i>Getting Chapter List...");
			$.get( "./wat/getchapters.php", { wattcode: wattcode } )
			  .done(function( data ) {
				chaptersJSON = data;
				
				if(data =="The wattcode is not valid or the page is no longer available.") {
					write("The wattcode is not valid or the page is no longer available.");
						$('.debug').fadeIn();
					return false;
				}
				write( "Response:" + data + "");
				var chapters = $.parseJSON(data);
				var indv_incr = ((1/Object.size(chapters))*100)
				$.each(chapters, function( index, value ) {
					
					 downloadChapter(index,value);
					
				});
			  });
			} catch(Ex){
				write("<b>" +Ex +"</b>");
			}
		});
		function downloadChapter(index,value){
			addDownload('<div class="chapter" id="chap'+value+'"><i class="load"></i>'+index+'</div>');
			$.get( "./wat/getcontent.php", { wattcode: value, accesscode: accesscode} )
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
						write("Download Done!");
						if(error_downloads.length !==0){
							
							for(var i = 0; i<=error_downloads.length;i++){
								write("reDownloading Chapter with errors...!");
								$('.status').append("<br>" + error_downloads[i]	);
								alert(error_downloads[i]);
								downloadChapter(i,error_downloads[i]);
								error_downloads.splice(i,i);
								
							}
						} else {
							write("<i></i> Packing file for download...");
						
									$.post( "./wat/getpackage.php", { wattcode: wattcode,chapters: chaptersJSON,accesscode: accesscode } )
										 .done(function( data ) {
											 $('iframe').attr("src",data);
											 write("<i class='check'></i> Done Download!!...");
											 $('.debug').fadeIn();
										 });
										 
										
								
						}
						updateDownloadCounter(cur_downloads,error_downloads.length);
					} else if(cur_downloads==1){
						write("<c>" + cur_downloads + " Download Left, "+errors+" errors so far.</c>");
						updateDownloadCounter(cur_downloads,error_downloads.length);
					} else {
						write("<c>" + cur_downloads + " Downloads Remaining, "+errors+" errors so far.</c>");
						updateDownloadCounter(cur_downloads,error_downloads.length);
					}
			});
			cur_downloads++;
			write("<e>" + cur_downloads + " Downloads Started</e>");
		}
		function updateDownloadCounter(count,errors){
			//$('.count').text(count);
			//$('.errors').text(errors);
		}
		function write(msg){
			$(".status").html(msg);
		}
		function addDownload(file){
			$(".chapters").append(file);
		}
		function doneDownload(wattcode){
			$("#chap" + wattcode).children("i").attr("class","check");
		}
	});