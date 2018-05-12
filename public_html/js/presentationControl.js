$(document).ready(()=>{
	// If absolute URL from the remote server is provided, configure the CORS
	// header on that server.
	var url = '/pdfs/beamer-tutorial.pdf';

    var startX,
    startY,
    dist,
    threshold = 50, //required min distance traveled to be considered swipe
    allowedTime = 150, // maximum time allowed to travel that distance
    elapsedTime,
    startTime;
    


    window.addEventListener('touchstart', function(e){
        //touchsurface.innerHTML = ''
        var touchobj = e.changedTouches[0]
        dist = 0
        startX = touchobj.pageX
        startY = touchobj.pageY
        startTime = new Date().getTime() // record time when finger first makes contact with surface
        e.preventDefault()
        
        event.target.addEventListener('touchmove', function(e){
            e.preventDefault() // prevent scrolling when inside DIV
        }, false)
        
        event.target.addEventListener('touchend', function(e){
            var touchobj = e.changedTouches[0]
            dist = touchobj.pageX - startX // get total dist traveled by finger while in contact with surface
            elapsedTime = new Date().getTime() - startTime // get time elapsed
            // check that elapsed time is within specified, horizontal dist traveled >= threshold, and vertical dist traveled <= 100
            var swiperightBol = (elapsedTime <= allowedTime && Math.abs(dist) >= threshold && Math.abs(touchobj.pageY - startY) <= 100)
            
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
        
    }, false)




	// Loaded via <script> tag, create shortcut to access PDF.js exports.
	var pdfjsLib = window['pdfjs-dist/build/pdf'];

	// The workerSrc property shall be specified.
	pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

	var pdfDoc = null,
		pageNum = 1,
		pageRendering = false,
		pageNumPending = null,
		scale = 10,
		canvas = document.getElementById('the-canvas'),
		ctx = canvas.getContext('2d');

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
    
    document.getElementById('next').addEventListener('click', onNextPage);
    
    window.addEventListener("swap", function(event) {
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
    }, true);

    window.addEventListener("keydown", function(event) {
        if (event.defaultPrevented){
            return; // Do nothing if the event was already processed
        }

        switch(event.key) {
            case "ArrowLeft":
                onPrevPage()
                break;
            case "ArrowRight":
                onNextPage()
                break;
            case "ArrowUp":
                onPrevPage()
                break;
            case "ArrowDown":
                onNextPage()
                break;
        }
        event.preventDefault();
    },true);

	/**
	 * Asynchronously downloads PDF.
	 */
	pdfjsLib.getDocument(url).then(function(pdfDoc_) {
	  pdfDoc = pdfDoc_;
	  document.getElementById('page_count').textContent = pdfDoc.numPages;

	  // Initial/first page rendering
	  renderPage(pageNum);
	});
});