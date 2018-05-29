<?php
require dirname(__FILE__).'/../include/database_connection.php';
?>
<main role="main" class="container-fluid">
<div class="row justify-content-center">
  <div class="col-sm-10">
    <div class="alert alert-info" id="geolocation">
        <p><i class="fas fa-info-circle"></i>
        If you give us access to your geolocation, we can search the presentation
        you are currently in. (Not working in chrome for demo).
        <p>Don't worry, we <strong>don't</strong> store your data on the server.</p>
        <button type="button" class="btn btn-primary">
            <i class="fas fa-map-marker-alt"></i> Find my presentation
        </button>
    </div>
  </div>
  <div class="col-sm-10">
<?php
if(($result=$mysqli->query(
    'SELECT id_code, name, start_timestamp, end_timestamp '.
    'FROM presentations '.
    //'WHERE access_code IS NULL '.
    'ORDER BY start_timestamp LIMIT 9')) &&
    $result->num_rows > 0):
  $presentations = [];
  while($row=$result->fetch_assoc()) {
      $presentations[] = $row;
  }
?>
        <div id="carousel" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
<?php for($i=0;$i<count($presentations);$i++): ?>
            <li data-target="#carousel"
                data-slide-to="<?php echo $i; ?>"
                <?php echo ($i==0?'class="active"':''); ?>></li>
<?php endfor; ?>
          </ol>
          <div class="carousel-inner">
<?php foreach($presentations as $i=>$pres): ?>
            <div class="carousel-item<?php echo ($i==0?' active':''); ?>">
              <a href=".?p=view&id=<?php echo $pres['id_code']; ?>">
                <img height="500px" class="d-block w-100" src="img/random_background.jpg" alt="<?php echo $pres['name']; ?>">
              </a>
              <div class="carousel-caption d-block">
                <h5><?php echo $pres['name']; ?></h5>
<?php
                $date = new DateTime($pres['start_timestamp']);
                $start = $date->format('Y-m-d H:i');
                $date = new DateTime($pres['end_timestamp']);
                $end = $date->format('Y-m-d H:i');
?>
                <p>Presentation from <?php echo $start; ?> till <?php echo $end; ?>.</p>
              </div>
            </div>
<?php endforeach; ?>
          </div>
          <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
<?php
else:
?>
    <div class="text-center bg-light">
      <h1>Nothing to show</h1>
      <h2>Really, nothing.</h2>
      <img src="img/sad_face.png" alt="Sad face" width="50%" style="image-rendering: pixelated;">
    </div>
<?php
endif;
?>
  </div>
</div>
<script type="text/html" id="item-template">
    <div class="carousel-item">
      <a href=".?p=view&id=%%PRES_ID%%">
        <img height="500px" class="d-block w-100" src="img/random_background.jpg" alt="background">
      </a>
      <div class="carousel-caption d-none d-md-block">
        <h5>%%PRES_NAME%%</h5>
        <p>Presentation from %%PRES_START%% till %%PRES_END%%.</p>
      </div>
    </div>
</script>
<script type="text/html" id="indicator-template">
    <li data-target="#carousel" data-slide-to="%%I%%"></li>
</script>
</main>