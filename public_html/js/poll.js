$(document).ready(()=>{
    document.getElementById('vote').addEventListener('click', function(event) {        
        var radios = document.getElementsByName('answer');
        for( i = 0; i < radios.length; i++ ) {
            if( radios[i].checked ) {
                console.log(radios[i].value)
                console.log(radios[i].id)
                
                function passVal(){
                    var data = {
                        id: radios[i].id,
                    };
            
                    $.post("/../../pages/poll_vote.php", data);
                }
                passVal();
                
            }
        }
        return null;
    })
});
    