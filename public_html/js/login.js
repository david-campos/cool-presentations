$(document).ready(()=>{
    let form = $('#login');
    let reg = $('#reg');
    let log = $('#log');
    let errorsAlert = $('#form-errors');
    let loader = $(".loader");
    
    form.submit((event) => {event.preventDefault();});
    log.click((event)=>{onClickPre("login.php")});
    reg.click((event)=>{onClickPre("register.php");});
    
    function onClickPre(url) {
        errorsAlert.hide();
        let nick = form.find("#nick").val().trim();
        let pass = form.find("#pwd").val().trim();
        let remember = (form.find("#remember").prop( "checked")?true:false);
        if(checkValues(nick, pass)) {
            // hash pass even before sending (sha.js)
            var shaObj = new jsSHA("SHA-512", "TEXT");
            shaObj.update(pass);
            pass = shaObj.getHash("HEX");
            connection(url, nick, pass);
        }
    }
    
    function connection(url, nick, pass) {
        // hide form and show loading
        form.hide();
        loader.show();
        console.log(url);
        // AJAX connection
        $.ajax({url: url,
                data: {nick: nick, pass: pass},
                method: "POST",
                dataType: "text"})
            .done((data, textStatus, jqXHR) => {
                loader.hide();
                // Logged/registered! :)
                errorsAlert
                    .removeClass("alert-danger")
                    .addClass("alert-success")
                    .text(jqXHR.responseText)
                    .show();
                // For register
                if(url === "register.php") {
                    onClickPre("login.php"); // Let's log-in
                }
            })
            .fail((jqXHR) => {
                form.show();
                loader.hide();
                console.log(jqXHR);
                errorsAlert.text(jqXHR.responseText).show();
            });
    }
    
    function checkValues(nick, pass) {
        let html = "";
        if(nick === "" || pass === "") {
            html = "Please, introduce name and password.";
            errorsAlert.html(html).show().fadeOut(5000);
            return false;
        }
        
        let nickValid = nick.match(/^[A-Za-z0-9_\-.]+$/);
        let passValid = (pass.length >= 8);
        
        if(!nickValid)
            html += "<strong>Nickname:</strong> the nickname can only contain alphanumeric characters, '_', '-' or dots ('.').";
        if(!passValid)
            html += "<strong>Password:</strong> the password should be, at least, 8 characters long.";
        
        if(!nickValid || !passValid)
            errorsAlert.html(html).show();
        
        return nickValid && passValid;
    }
});