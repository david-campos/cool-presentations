<!-- File item template -->
<script type="text/html" id="files-template">
  <li class="media">
    <div class="media-body mb-1">
      <p class="mb-2">
        <strong>%%filename%%</strong> - Status: <span class="text-muted">Waiting</span>
      </p>
      <div class="progress mb-2">
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
          role="progressbar"
          style="width: 0%" 
          aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
        </div>
      </div>
      <hr class="mt-1 mb-1" />
    </div>
  </li>
</script>

<!-- Debug item template -->
<script type="text/html" id="debug-template">
  <li class="list-group-item text-%%color%%"><strong>%%date%%</strong>: %%message%%</li>
</script>
<script src="js/sha.js"></script>
<script src="js/upload_pdf.js"></script>
<script src="js/jquery.dm-uploader.js"></script>
<script src="js/demo-config.js"></script>
<script src="js/demo-ui.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAUfEs6oBqM0fonFb1f2g2b_2QNcXr7Smc"></script>
<script type="text/javascript" src="js/map.js"></script>
