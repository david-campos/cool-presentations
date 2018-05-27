$(function() {
    $("#foo button").click(function(){
		
        $.post( "my_presentations.php", function( data ) {
            console.log("success");
			alert("Hello! I am an alert box!!");
            window.location.reload(true);
        });
    })
});
