<?php
require dirname(__FILE__).'/../include/database_connection.php';
?>
<main role="main" class="container-fluid">
<div class="row justify-content-center">
  <div class="col-sm-10 bg-light">
<?php
if(($result=$mysqli->query(
    'SELECT id_code, name, start_timestamp, end_timestamp '.
    'FROM presentations WHERE access_code IS NULL')) &&
    $result->num_rows > 0):
  while($row=$result->fetch_array()):
?>
    <h1>Ongoing public presentations</h1>
    <div class="row">
        <a href="?p=view&i=<?php echo $row[0]; ?>">
        <?php echo $row[1] ?> (<?php echo $row[2] ?> - <?php echo $row[3] ?>)
        </a>
    </div>
<?php
  endwhile;
else:
?>
    <div class="text-center">
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