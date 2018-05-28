$(function() {
    $("#foo button").click(function(){
		
        $.post( "my_presentations.php", function( data ) {
            console.log("success");
			alert("Presentation has been removed");
            window.location.reload(true);
        });
    })
});
