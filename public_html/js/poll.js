$(document).ready(()=>{
    $('#vote-button').click(
        ()=>{
            console.log($('input[name=answer]:checked','#vote-form').val());
            $.post("poll_vote.php", 
                   {id : $('input[name=answer]:checked','#vote-form').val()},
                   (data)=>{alert(JSON.stringify(data));}, 'text'                   
                )
    });
});
    