/*var answer1=$('[name=answer1]');
var answer2=$('[name=answer2]');
var answer3=$('[name=answer3]');
var answer4=$('[name=answer4]');
var answer5=$('[name=answer5]');

var cont=1;

answer1.id=('answer'+cont);
cont=cont+1;
answer2.id=('answer'+cont);
cont=cont+1;
answer3.id=('answer'+cont);
cont=cont+1;
answer4.id=('answer'+cont);
cont=cont+1;
answer5.id=('answer'+cont);

var primer_answer=$('#primer_answer').attr('id');
*/



 function mySubmitFunction(evt) {
  evt.preventDefault();
}
 
 
 
 $('#btnApiStart').on('click', function(evt){
    evt.preventDefault();

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

 
  
function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}