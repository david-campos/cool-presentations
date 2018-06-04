((window)=>{
    $("document").ready(()=>{
        var alert = document.getElementById("geolocation");
        
        if (!navigator.geolocation) {
            alert.style.display = "none"; // Not supported
        }
        
        $(alert).find("button").click(()=>{
            getLocation();
        });
        
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(presentationsForLocation, locationError);
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        }
        
        function presentationsForLocation(location) {
            console.log(location);
            $.get('presentations_for_location.php',
                location.coords,
                (answer)=>{
                    if(answer.presentations.length > 0) {
                        alert.style.display = "none";
                        let carousel = $('#carousel');
                        carousel.carousel("pause").removeData();
                        
                        let container = $("#carousel .carousel-inner");
                        container.empty();
                        
                        let ol = $("#carousel .carousel-indicators");
                        ol.empty();
                        
                        let template = $("#item-template").text();
                        let indicatorTemp = $("#indicator-template").text();
                        let i = 0;
                        for(let presentation of answer.presentations) {
                            let newItem = $(template
                                .replace("%%PRES_ID%%", presentation.id_code)
                                .replace("%%PRES_START%%", presentation.start_timestamp)
                                .replace("%%PRES_END%%", presentation.end_timestamp)
                                .replace("%%PRES_NAME%%", presentation.name));
                            container.append(newItem);
                            let newIndicator = $(indicatorTemp
                                .replace("%%I%%", i)
                            );
                            ol.append(newIndicator);
                            i++;
                        }
                        $('.carousel-item').first().addClass('active');
                        $('.carousel-indicators > li').first().addClass('active');
                        carousel.carousel();
                    } else {
                        $(alert).removeClass("alert-info").addClass("alert-danger")
                        .text("No presentations found.");
                    }
                }, 'json').fail(
                    (data)=>{
                        $(alert).removeClass("alert-info").addClass("alert-danger")
                        .text("Unknown error: "+data.responseText);
                        console.log(data);
                    }
                );
        }
        
        function locationError(error) {
            let text = "Unknown error";
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    text = "Location permission denied.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    text = "Location information is unavailable."
                    break;
                case error.TIMEOUT:
                    text = "The request to get user location timed out."
                    break;
            }
            $(alert).removeClass("alert-info").addClass("alert-danger").text(text);
        }
    })
})(window);