
 
 
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

  document.getElementById("lastr").style.display = "none";
  
  function myFunction1() {
  var checkBox = document.getElementById("addlocation");

  if (checkBox.checked == true){
    document.getElementById("lastr").style.display = "block";
  } else {
	document.getElementById("lastr").style.display = "none";
  }
}