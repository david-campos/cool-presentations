
 
 
 $('#btnApiStart').on('click', function(evt){
    evt.preventDefault();
	
	document.getElementById('submitt').click();
	sleep(2000);
    $('#drag-and-drop-zone').dmUploader('start');
	sleep(1000);
	
	
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

 
  
function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}