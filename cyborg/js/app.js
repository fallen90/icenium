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
		
		$('.run').click(function(){
		
		try {
			
			wattcode = ( $('input.wattcode').val());
			if(wattcode ==""){
				return false;
			}
			$('.form').fadeOut();
			$('.progress').fadeIn();
			write("Getting Chapter List...");
			$.get( "http://w2a.us.to/cyborg/wat/getchapters.php", { wattcode: wattcode } )
			  .done(function( data ) {
				chaptersJSON = data;
				
				if(data =="The wattcode is not valid or the page is no longer available.") {
					write("The wattcode is not valid or the page is no longer available.");
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
						'<span class="badge"><span class="glyphicon 	glyphicon-cloud-download"></span></span>'+
						'</span>';
			addDownload(str);
			$.get( "http://w2a.us.to/cyborg/wat/getcontent.php", { wattcode: value, accesscode: accesscode} )
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
									$.post( "http://w2a.us.to/cyborg/wat/getpackage.php", { wattcode: wattcode,chapters: chaptersJSON,accesscode: accesscode } )
										 .done(function( data ) {
											try{
												write("Download Done!...");
												var packs = $.parseJSON(data);
												$('#txt').attr('rel',basename(packs['txt'])).removeClass("notyet");
												$('#zip').attr('rel',basename(packs['zip'])).removeClass("notyet");
												$('.progress').fadeOut();
											} catch(ex){
												write("Error Fetching Packages");
											}
										 });
										 
										
								
						
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
			var percent = 100 - ((count/download_total) * 100);
			$('.progress-bar').width(percent + "%");
		}
		function write(msg){
			$(".status").html(msg);
		}
		function addDownload(file){
			$(".list-group").append(file);
		}
		function doneDownload(wattcode){
			$("#chap" + wattcode).removeClass("dl-active");
			$("#chap" + wattcode).addClass("dl-done");
			$("#chap" + wattcode).children(".badge").children("span").attr("class","glyphicon glyphicon-ok");
		}
		$('#txt').click(function(){
			var rel_data = "http://w2a.us.to/cyborg/wat/jasper/builds/" + $(this).attr('rel');
			var url = rel_data;
          	downloadFile(url);

		});
		$('#zip').click(function(){
			var rel_data = "http://w2a.us.to/cyborg/wat/jasper/builds/packages" + $(this).attr('rel');
			var url = rel_data;
				downloadFile(url);

		});
		$('#ice').click(function(){
			$('#not').modal('toggle');
		});
		$('#pdf').click(function(){
			$('#not').modal('toggle');
		});
		
		//mobile taps
		$('#txt').on("touchstart",function(){
			var rel_data = "http://w2a.us.to/cyborg/wat/jasper/builds/" + $(this).attr('rel');
			var url = rel_data;
          	downloadFile(url);

		});
		$('#zip').on("touchstart",function(){
			var rel_data = "http://w2a.us.to/cyborg/wat/jasper/builds/packages" + $(this).attr('rel');
			var url = rel_data;
          	downloadFile(url);

		});
		$('#ice').on("touchstart",function(){
			$('#not').modal('toggle');
		});
		$('#pdf').on("touchstart",function(){
			$('#not').modal('toggle');
		});
		function loadURL(url){
			navigator.app.loadUrl(url, { openExternal:true });
			return false;
		} 
		function basename(path) {
			return path.replace(/\\/g,'/').replace( /.*\//, '' );
		}
		
		
		
		
	});
	
	
	
	
	
	
	
	
	
	
	
	function downloadFile(url){

	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, 
    function onFileSystemSuccess(fileSystem) {
        fileSystem.root.getFile(
        "dummy.html", {create: true, exclusive: false}, 
        function gotFileEntry(fileEntry) {
            var sPath = fileEntry.fullPath.replace("dummy.html","");
            var fileTransfer = new FileTransfer();
            fileEntry.remove();

            fileTransfer.download(
               url,
                sPath + basename(url),
                function(theFile) {
                    console.log("download complete: " + theFile.toURI());
                    showLink(theFile.toURI());
                },
                function(error) {
                    console.log("download error source " + error.source);
                    console.log("download error target " + error.target);
                    console.log("upload error code: " + error.code);
                }
            );
        }, fail);
    }, fail);
}
function fail(error){
	console.log(error);
}