<?php
require dirname(__FILE__).'/../include/database_connection.php';
?>
<main role="main" class="container-fluid">
<div class="row justify-content-center">
  <div class="col-sm-10">
<?php
session_start();
$user_id=$_SESSION['user_id'];
if(($result=$mysqli->query(
    'SELECT id_code, name, start_timestamp, end_timestamp '.
    'FROM presentations '.
    //'WHERE access_code IS NULL '.
	'WHERE user_id ="'.$user_id.'"'. 
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
              <div class="carousel-caption d-none d-md-block">
                <h5><?php echo $pres['name']; ?></h5>
<?php
                $date = new DateTime($pres['start_timestamp']);
                $start = $date->format('Y-m-d H:i');
                $date = new DateTime($pres['end_timestamp']);
                $end = $date->format('Y-m-d H:i');
				$_SESSION['actual_pres']=$pres['id_code'];
?>
                <p>Presentation from <?php echo $start; ?> till <?php echo $end; ?>.</p>
				<!-- BOORRAAAR -->
				<div id='foo'>
					<button type="button"  class="btn btn-danger" value="<?php echo $pres['id_code']; ?>">REMOVE PRESENTATION</button>
				</div>
			
				<!-- FIN    BOORRAAAR -->
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

</main>