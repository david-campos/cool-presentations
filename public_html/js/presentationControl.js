
$(document).ready(()=>{
    var pageRendering = false,
    pageNumPending = null,
    scale = 10,
    canvas = document.getElementById('the-canvas'),
    ctx = canvas.getContext('2d'),
    overSlides = $('#over-slides');
    
    var pwd_ok = false;
    var pass_pdf_user_input = ""
    var pdfDoc = null, pageNum = 1;
    var url = "";
    /**
     * Asynchronously downloads PDF.
     */  
    function loadPdf(access_code) {
        if(!PRES_CODE) {
            alert('Error: no pres_code!');
        }
        url = "presentation_access.php?presentation_code="+encodeURI(PRES_CODE);
        if (PRES.access_code && !access_code) {
            $('#passwordModal').modal('show');
            setTimeout(()=>{$('input[name="pwd_field"]').focus()},500);
            return;
        }
        if(access_code) {
            url += "&access_code="+encodeURI(access_code);
        }
        // If absolute URL from the remote server is provided, configure the CORS
        // header on that server.    
        pdfjsLib.getDocument(url).then(
        (pdfDoc_) => {
          pdfDoc = pdfDoc_;
          pwd_ok = true;
          //let link = $("#download_btn");
          //if (link.size() === 1) {
            $('#download_btn').attr('href','presentation_access.php?presentation_code=' + PRES.id_code + '&access_code=' + pass_pdf_user_input)
          //}
          $('#passwordModal').modal('hide');
          let pageCount = document.getElementById('page_count');
          if(pageCount) pageCount.textContent = pdfDoc.numPages;
          // Initial/first page rendering
          renderPage(pageNum);
        },
        (data, moreData) => {
            $('#passwordModal .loader').hide();
            $('#pass_dialog_fail').show();
            $('#pwd_form').show();
            console.log(data, moreData);
        });
    }

    var startX,
    startY,
    dist,
    threshold = $( canvas ).width() / 3.0, //required min distance traveled to be considered swipe
    allowedTime = 500, // maximum time allowed to travel that distance
    elapsedTime,
    startTime;
    
    // Object to do the swap on
    var doSwapOn = overSlides[0];
    
    doSwapOn.addEventListener('touchstart', function(e){
        var touchobj = e.changedTouches[0]
        dist = 0
        startX = touchobj.pageX
        startY = touchobj.pageY
        startTime = new Date().getTime() // record time when finger first makes contact with surface
        e.preventDefault()
    }, false)
        
    doSwapOn.addEventListener('touchmove', function(e){
        e.preventDefault() // prevent scrolling when inside DIV
    }, false)
    
    doSwapOn.addEventListener('touchend', function(e){
        var touchobj = e.changedTouches[0]
        dist = touchobj.pageX - startX // get total dist traveled by finger while in contact with surface
        elapsedTime = new Date().getTime() - startTime // get time elapsed
        // check that elapsed time is within specified, horizontal dist traveled >= threshold, and vertical dist traveled <= 100
        var swiperightBol = (elapsedTime <= allowedTime && Math.abs(dist) >= threshold && Math.abs(touchobj.pageY - startY) <= 100)
        //console.log("swiperightBol ", swiperightBol, "dist", dist, "elapsedTime", elapsedTime)
        var dir_str = "none";
        var dir_int = 0;
        if(swiperightBol){
            if(dist > 0){
                dir_str = "RIGHT";
                dir_int = 1;
            }else{
                dir_str = "LEFT";
                dir_int = 2;
            }
            var _e = new CustomEvent("swap", {
                target : event.target,
                detail: {		
                    direction : dir_str,
                    direction_int : dir_int
                },
                bubbles: true,
                cancelable: true
            });
            trigger(event.target,"Swap",_e);			
        }
        
        //handleswipe(swiperightBol, event.target);
        e.preventDefault()
    }, false)

    function trigger(elem, name, event) {
        elem.dispatchEvent(event);
        eval(elem.getAttribute('on' + name));
    }
    
	// Loaded via <script> tag, create shortcut to access PDF.js exports.
	var pdfjsLib = window['pdfjs-dist/build/pdf'];

	// The workerSrc property shall be specified.
    pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

	/**
	 * Get page info from document, resize canvas accordingly, and render page.
	 * @param num Page number.
	 */
	function renderPage(num) {
	  pageRendering = true;
	  // Using promise to fetch the page
	  pdfDoc.getPage(num).then(function(page) {
		var viewport = page.getViewport(scale);
		canvas.height = viewport.height;
		canvas.width = viewport.width;

		// Render PDF page into canvas context
		var renderContext = {
		  canvasContext: ctx,
		  viewport: viewport
		};
		var renderTask = page.render(renderContext);
        
        overSlides.width($(canvas).width());
        overSlides.height($(canvas).height());  
        if(SURVEYS[num]) {
            renderSurvey(SURVEYS[num]);
        } else {
            deleteSurvey();
        }

		// Wait for rendering to finish
		renderTask.promise.then(function() {
		  pageRendering = false;
		  if (pageNumPending !== null) {
			// New page rendering is pending
			renderPage(pageNumPending);
			pageNumPending = null;
		  }
		});
	  });

	  // Update page counters
	  document.getElementById('page_num').textContent = num;
	}
    
    // Keep the measures of overSlides always right
    $( window ).resize(function() {
        overSlides.width($(canvas).width());
        overSlides.height($(canvas).height());
    });
    
    var surveyTemplate = $('#survey-template').text();
    var surveyAnswerTemplate = $('#survey-answer-template').text();
    function renderSurvey(survey) {
        let answersHtmlStr = "";
        for(let ans of survey.answers) {
            answersHtmlStr += surveyAnswerTemplate
                .replace("%%VALUE%%", ans.id)
                .replace("%%TEXT%%", ans.text);
        }
        let htmlStr = surveyTemplate
            .replace("%%QUESTION%%", survey.question)
            .replace("%%ANSWERS%%", answersHtmlStr);
        let newElement = $(htmlStr);
        // survey.open survey.multipleChoice
        newElement.css("left", survey.pos.x + "%");
        newElement.css("top", survey.pos.y + "%");
        // survey answers interaction
        let answerLis = newElement.find("li");
        answerLis.click((event)=>{
            answerLis.removeClass("active");
            $(event.target).addClass("active");
        });
        // survey vote button
        newElement.find('button').click(()=>{
            $.post("poll_vote.php", 
                   {
                       "presentation_code": PRES.id_code,
                       "survey_page": survey.page,
                       "answer_id": newElement.find('li.active').attr("data-value")
                   },
                   (data)=>{newElement.text(data)},
                   'text')
                .fail((data)=>{alert("Error: " + data.responseText);});
        });
        // Put to overslides
        overSlides.empty();
        overSlides.append(newElement);
    }
    
    function deleteSurvey() {
        overSlides.html("");
    }

	/**
	 * If another page rendering in progress, waits until the rendering is
	 * finised. Otherwise, executes rendering immediately.
	 */
	function queueRenderPage(num) {
	  if (pageRendering) {
		pageNumPending = num;
	  } else {
		renderPage(num);
	  }
	}

	/**
	 * Displays previous page.
	 */
	function onPrevPage() {
	  if (pageNum <= 1) {
		return;
	  }
	  pageNum--;
	  queueRenderPage(pageNum);
	}
	document.getElementById('prev').addEventListener('click', onPrevPage);

	/**
	 * Displays next page.
	 */
	function onNextPage() {
	  if (pageNum >= pdfDoc.numPages) {
		return;
	  }
	  pageNum++;
	  queueRenderPage(pageNum);
    }
    
    $('#pwd_form').submit((event)=>{event.preventDefault();$('button[name="send_pwd"]').click();});
    
    $('button[name="send_pwd"]').click(function() {
        pwd = $('input[name="pwd_field"]').val();
        $('input[name="pwd_field"]').val(''); // delete pass from dom!
        $('#pwd_form').hide();
        $('#passwordModal .loader').show();
        $('#pass_dialog_fail').hide();
        // hash pass even before sending (sha.js)
        var shaObj = new jsSHA("SHA-512", "TEXT");        
        shaObj.update(pwd);
        pwd = shaObj.getHash("HEX");        
        pass_pdf_user_input = pwd
        $.post("header.php", {"pass": pwd});
        loadPdf(pwd);
    });
    

    document.getElementById('next').addEventListener('click', onNextPage);
    
    window.addEventListener("swap", function(event) {
        //console.log("swap");
        if (event.defaultPrevented) {
            return;
        }
        if (event.detail.direction == "RIGHT") {
            onPrevPage()
        }
        else {
            onNextPage();
        }

        event.preventDefault();
    }, true);

    window.addEventListener("wheel", function(event) {
        if (pwd_ok) 
        {
            if (event.defaultPrevented) {
                return;
            }

            if (event.deltaY > 0) {
                onNextPage()
            }
            else {
                onPrevPage()
            }

            event.preventDefault();
        }
    }, true);

    
    window.addEventListener("keydown", function(event) {
        if (event.defaultPrevented){
            return; // Do nothing if the event was already processed
        }

        switch(event.key) {
            case "ArrowLeft":
                onPrevPage()
                event.preventDefault()
                break;
            case "ArrowRight":
                onNextPage()
                event.preventDefault()
                break;
            case "ArrowUp":
                onPrevPage()
                event.preventDefault()
                break;
            case "ArrowDown":
                onNextPage()
                event.preventDefault()
                break;
        }
    },true);
    
    
    loadPdf();
});