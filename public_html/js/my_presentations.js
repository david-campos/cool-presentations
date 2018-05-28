$(function() {
    $("#foo button").click(function(){
		var data = $(this).attr('data-id-presentation');
		var data = {data:data};
        $.post( "my_presentations.php",data, function( data ) {
			
            console.log("success");
			alert("Presentation has been removed");
            window.location.reload(true);
        })
    })
});
