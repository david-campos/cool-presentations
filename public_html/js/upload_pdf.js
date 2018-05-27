
 
 
 $('#btnApiStart').on('click', function(evt){
    evt.preventDefault();
	
	document.getElementById('submitt').click();
	sleep(1000);
    $('#drag-and-drop-zone').dmUploader('start');
	
	
	
	
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

  document.getElementById("lastr").style.display = "none";
  
  function myFunction1() {
  var checkBox = document.getElementById("addlocation");

  if (checkBox.checked == true){
    document.getElementById("lastr").style.display = "block";
  } else {
	document.getElementById("lastr").style.display = "none";
  }
}
function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}