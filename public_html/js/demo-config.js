$(function(){
  /*
   * For the sake keeping the code clean and the examples simple this file
   * contains only the plugin configuration & callbacks.
   * 
   * UI functions ui_* can be located in: demo-ui.js
   */
  $('#drag-and-drop-zone').dmUploader({ //
    url: './pdf_upload.php',
    maxFileSize: 3000000, // 3 Megs 
	auto: false,
	extFilter: ["pdf"],
	extraData: function(){
		var present_name = $("#present_name").val();
		var code_access = $("#code_access").val();
		var downloable = 0;
		if ($('#downloable').is(":checked")){
			downloable=1;
		}
		var diaini = $("#diaini").val();
		var horaini = $("#horaini").val();
		var diafin = $("#diafin").val();
		var horafin = $("#horafin").val();
		
		var lat = $("#lat").val();
		var lng = $("#lng").val();
		
		var question = $("#question").val();
		var page = $("#page").val();
		
		var xcor = $("#xcor").val();
		var ycor = $("#ycor").val();
		var width = $("#width").val();
		var height = $("#height").val();
		
		
		var multiplechoice = 0;
		if ($('#multiplechoice').is(":checked")){
			multiplechoice=1;
		}
		
		var answer1 = $("#answer1").val();
		var answer2 = $("#answer2").val();
		var answer3 = $("#answer3").val();
		var answer4 = $("#answer4").val();
		var answer5 = $("#answer5").val();
		
		
		
		var question2 = $("#question2").val();
		var page2 = $("#page2").val();
		
		var xcor2 = $("#xcor2").val();
		var ycor2 = $("#ycor2").val();
		var width2 = $("#width2").val();
		var height2 = $("#height2").val();
		
		
		var multiplechoice2 = 0;
		if ($('#multiplechoice2').is(":checked")){
			multiplechoice2=1;
		}
		
		var answer6 = $("#answer6").val();
		var answer7 = $("#answer7").val();
		var answer8 = $("#answer8").val();
		var answer9 = $("#answer9").val();
		var answer10 = $("#answer10").val();
		
		var question3 = $("#question3").val();
		var page3 = $("#page3").val();
		
		var xcor3 = $("#xcor3").val();
		var ycor3 = $("#ycor3").val();
		var width3 = $("#width3").val();
		var height3 = $("#height3").val();
		
		
		var multiplechoice3 = 0;
		if ($('#multiplechoice3').is(":checked")){
			multiplechoice3=1;
		}
		
		var answer11 = $("#answer11").val();
		var answer12 = $("#answer12").val();
		var answer13 = $("#answer13").val();
		var answer14 = $("#answer14").val();
		var answer15 = $("#answer15").val();
		
		
		
		
		var myObject={present_name:present_name, code_access:code_access,downloable:downloable,diaini:diaini,horaini:horaini,
						diafin:diafin,horafin:horafin,lat:lat,lng:lng,question:question,page:page,xcor:xcor,ycor:ycor,
						width:width,height:height,multiplechoice:multiplechoice,
						answer1:answer1,answer2:answer2,answer3:answer3,answer4:answer4,answer5:answer5,
						question2:question2,page2:page2,xcor2:xcor2,ycor2:ycor2,
						width2:width2,height2:height2,multiplechoice2:multiplechoice2,
						answer6:answer6,answer7:answer7,answer8:answer8,answer9:answer9,answer10:answer10,
						question3:question3,page3:page3,xcor3:xcor3,ycor3:ycor3,
						width3:width3,height3:height3,multiplechoice3:multiplechoice3,
						answer11:answer11,answer12:answer12,answer13:answer13,answer14:answer14,answer15:answer15};

		return myObject;
		
	},
    onDragEnter: function(){
      // Happens when dragging something over the DnD area
      this.addClass('active');
    },
    onDragLeave: function(){
      // Happens when dragging something OUT of the DnD area
      this.removeClass('active');
    },
    onInit: function(){
      // Plugin is ready to use
      ui_add_log('Penguin initialized :)', 'info');
    },
    onComplete: function(){
      // All files in the queue are processed (success or error)
      ui_add_log('All pending tranfers finished');
    },
    onNewFile: function(id, file){
      // When a new file is added using the file selector or the DnD area
      ui_add_log('New file added #' + id);
      ui_multi_add_file(id, file);
    },
    onBeforeUpload: function(id){
      // about tho start uploading a file
      ui_add_log('Starting the upload of #' + id);
      ui_multi_update_file_status(id, 'uploading', 'Uploading...');
      ui_multi_update_file_progress(id, 0, '', true);
    },
    onUploadCanceled: function(id) {
      // Happens when a file is directly canceled by the user.
      ui_multi_update_file_status(id, 'warning', 'Canceled by User');
      ui_multi_update_file_progress(id, 0, 'warning', false);
    },
    onUploadProgress: function(id, percent){
      // Updating file progress
      ui_multi_update_file_progress(id, percent);
    },
    onUploadSuccess: function(id, data){
      // A file was successfully uploaded
      ui_add_log('Server Response for file #' + id + ': ' + JSON.stringify(data));
      ui_add_log('Upload of file #' + id + ' COMPLETED', 'success');
      ui_multi_update_file_status(id, 'success', 'Upload Complete');
      ui_multi_update_file_progress(id, 100, 'success', false);
    },
    onUploadError: function(id, xhr, status, message){
      ui_multi_update_file_status(id, 'danger', message);
      ui_multi_update_file_progress(id, 0, 'danger', false);  
    },
    onFallbackMode: function(){
      // When the browser doesn't support this plugin :(
      ui_add_log('Plugin cant be used here, running Fallback callback', 'danger');
    },
    onFileSizeError: function(file){
      ui_add_log('File \'' + file.name + '\' cannot be added: size excess limit', 'danger');
    }
  });
});