/*var answer1=$('[name=answer1]');
var answer2=$('[name=answer2]');
var answer3=$('[name=answer3]');
var answer4=$('[name=answer4]');
var answer5=$('[name=answer5]');

var cont=1;
var object;
answer1.id='answer'+cont;
cont=cont+1;
answer2.id='answer'+cont;
cont=cont+1;
answer3.id='answer'+cont;
cont=cont+1;
answer4.id='answer'+cont;
cont=cont+1;
answer5.id='answer'+cont;

object={};

var regex = /^(.+?)(\d+)$/i;
var cloneIndex = $(".clonedInput").length;

function clone(){
    $(this).parents(".clonedInput").clone()
        .appendTo("body")
        .attr("id", "clonedInput" +  cloneIndex)
        .find("*")
        .each(function() {
            var id = this.id || "";
            var match = id.match(regex) || [];
            if (match.length == 3) {
                this.id = match[1] + (cloneIndex);
            }
        })
        .on('click', 'button.clone', clone)
        .on('click', 'button.remove', remove);
    cloneIndex++;
}
function remove(){
    $(this).parents(".clonedInput").remove();
}
$("button.clone").on("click", clone);

$("button.remove").on("click", remove);




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