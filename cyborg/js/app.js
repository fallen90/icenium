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
									//		try{
												write("Download Done!...");
												var packs = $.parseJSON(data);
												$('#txt').attr('rel',basename(packs['txt'])).removeClass("notyet");
												$('#zip').attr('rel',basename(packs['zip'])).removeClass("notyet");
												$('.bookid').attr('rel',packs['bookid']);
												
												var jsonArray = {
														bookid:  packcs['bookid'],
														zip:    packs['zip'],
														txt:  packs['txt'],
														
													  };
												
											var json_contents  = $.parseJSON(jsonArray);
											console.log(json_contents);
												saveJSON(json_contents);
												$('.progress').fadeOut();
									//		} catch(ex){
											//console.log(ex );
											//	write( "Error Fetching Packages");
									//		}
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
			write("Downloading TXT Package...");	
			var rel_data = "http://w2a.us.to/cyborg/wat/jasper/builds/" + $(this).attr('rel');
			var url = rel_data;
          	downloadFile(url);
			write("Download Done!");	
		});
		$('#zip').click(function(){
			write("Downloading ZIP Package...");	
			var rel_data = "http://w2a.us.to/cyborg/wat/jasper/builds/packages/" + $(this).attr('rel');
			var url = rel_data;
				downloadFile(url);
			write("Download Done!");	
		});
		$('#ice').click(function(){
			$('#not').modal('toggle');
		});
		$('#pdf').click(function(){
			$('#not').modal('toggle');
		});
		
		//mobile taps
		$('#txt').on("touchstart",function(){
			write("Downloading TXT Package...");	
			var rel_data = "http://w2a.us.to/cyborg/wat/jasper/builds/" + $(this).attr('rel');
			var url = rel_data;
			
          	downloadFile(url);

		});
		$('#zip').on("touchstart",function(){
			write("Downloading ZIP Package...");
			var rel_data = "http://w2a.us.to/cyborg/wat/jasper/builds/packages/" + $(this).attr('rel');
			var url = rel_data;
			
          	downloadFile(url);
			
		});
		$('#ice').on("touchstart",function(){
			$('#not').modal('toggle');
		});
		$('#pdf').on("touchstart",function(){
			$('#not').modal('toggle');
		});
		$('#start').on("touchstart",function(){
			window.location.reload(true);
		});
		function loadURL(url){
			navigator.app.loadUrl(url, { openExternal:true });
			return false;
		} 
		
		$('#showfiles').on("touchstart",function(){
			var json_contents = readJSON();
			var books = $.parseJSON(json_contents);
			$.each(books,function(index,value){
				$('#books').append(index + " - " + value);
			});
		});
		
		
		
		
	});
	
	
	var url = "";
	function basename(path) {
			return path.replace(/\\/g,'/').replace( /.*\//, '' );
		}
	
	
	function downloadFile(urlx){
			url = urlx;
			
			 window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fs) {
				console.log("Root = " + fs.root.fullPath);
				fs.root.getDirectory("icenium", {create: true, exclusive: false},
					gotDir, function (error) {
					   alert(error.code);
					}
				);
		   }, function (error) {
				   alert(error.code);
		   });
	}
	
	function gotDir(dirEntry){		
			dirEntry.getDirectory($('.bookid').attr("rel"), {create: true, exclusive: false},
			gotDirEntry, function (error) {
					   alert(error.code);
					}
				);
	}
	function gotDirEntry(dirEntry){		
			dirEntry.getFile("newFile.txt", {create: true,
	exclusive: false}, function (fileEntry) {
							 var sPath = fileEntry.fullPath.replace("newFile.txt","");
							var fileTransfer = new FileTransfer();
							fileEntry.remove();
							fileTransfer.download(
									url,
									sPath + basename(url),
									function(theFile) {
										$('.path').html(sPath + basename(url));
										$('#path').attr("href",sPath + basename(url));
										$('#done').modal('show');
										console.log("download complete: " + theFile.toURI());
										
									},
									function(error) {
										console.log("download error source " + error.source);
										console.log("download error target " + error.target);
										console.log("upload error code: " + error.code);
									}
								);
							console.log("File = " + fileEntry.fullPath);
						}, function (error) {
							alert(error.code);
						});
	}
	
	//save JSON File
	function saveJSON(json){
		 window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, function(fs) {
				console.log("Root = " + fs.root.fullPath);
				fs.root.getDirectory("icenium", {create: true, exclusive: false},
					function (dirEntry){
						dirEntry.getFile("books.json", {create: true,	exclusive: false}, 
							function(fileEntry){
								 fileEntry.createWriter(
								 function(writer){
									
										
									
										console.log("Writing: " + json);
										writer.write(json);
										writer.onwriteend = function(evt){
												console.log(evt.target.result);
											}
									
										
								 }, fail);
							},fail);
					}, fail	);
		   }, fail);
	}
	

	var json_contents = "";
	
	//READ JSON FILE
	function readJSON(){
		 window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, 
		 function(fileSystem){
			fileSystem.root.getFile("./icenium/books.json", null, 
				function(fileEntry){
					fileEntry.file(
						function(file){
							var reader = new FileReader();
							reader.onloadend = function(evt) {
								console.log("Read as text");
								console.log(evt.target.result);
								json_contents = evt.target.result;
								return json_contents;
							};
							reader.readAsText(file);
						}, fail);
				}, fail);
		 }, fail);
	}
	
		
    function fail(evt) {
        console.log(evt.target.error.code);
    }

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	