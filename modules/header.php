<nav class="navbar navbar-dark navbar-expand-lg bg-dark justify-content-between">
  <a class="navbar-brand" href=".">Presentations</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
<?php if(isset($_SESSION['user_id'])): ?>
        <li class="nav-item"><a class="nav-link" href="?p=upload"><i class="fas fa-plus-square"></i> New presentation</a></li>
        <li class="nav-item"><a class="nav-link" href="?p=mypres">My presentations</a></li>
<?php endif; ?>
<?php if($current_page_key==='view' && $presentation!==null && $presentation['downloadable']): ?>
        <li class="nav-item"><a role="button" class="btn btn-primary" id="download_btn">Download</a></li>
<?php endif; ?>
    </ul>

    <ul class="nav navbar-nav navbar-right text-light">
<?php
  if(!isset($_SESSION['user_id'])):
    if($current_page_key != 'log'):
?>
        <li class="nav-item">
            <a href="?p=log" class="btn btn-outline-success" type="button"><i class="fas fa-sign-in-alt"></i> Login</a>
        </li>
<?php
    endif;
  else:
    //When logged
?>
        <li class="nav-item" >
            <span style="font-size: 1.5em; margin-right: 0.3em;"><i class="fas fa-user"></i></span>
            <?php echo $_SESSION['user']; ?>
            &nbsp;
            <a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
<?php
  endif;
?>
    </ul>
  </div>
</nav>