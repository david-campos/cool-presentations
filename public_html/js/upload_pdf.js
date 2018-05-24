
 
 
 $('#btnApiStart').on('click', function(evt){
    evt.preventDefault();
    $('#drag-and-drop-zone').dmUploader('start');
	document.getElementById('submitt').click();
  });

  $('#btnApiCancel').on('click', function(evt){
    evt.preventDefault();

    $('#drag-and-drop-zone').dmUploader('cancel');
  });
  
  $('#btnApiReset').on('click', function(evt){
    evt.preventDefault();
	
	$('#drag-and-drop-zone').dmUploader('reset');
	document.getElementById('files').innerHTML = "";
   
  });
