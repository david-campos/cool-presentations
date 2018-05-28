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
		
		var myObject={present_name:present_name, code_access:code_access,downloable:downloable,diaini:diaini,horaini:horaini,
						diafin:diafin,horafin:horafin,lat:lat,lng:lng,question:question,page:page,xcor:xcor,ycor:ycor,
						width:width,height:height,multiplechoice:multiplechoice,
						answer1:answer1,answer2:answer2,answer3:answer3,answer4:answer4,answer5:answer5};
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