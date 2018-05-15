<nav class="navbar navbar-dark bg-dark justify-content-between">
  <a class="navbar-brand" href=".">Presentations</a>
<?php
  if (!isset($_SESSION['user_id'])):
    if($current_page_key != 'log'):
?>
  <ul class="nav navbar-nav navbar-right">
    <li class="nav-item"><a href="?p=log" class="btn btn-outline-success" type="button"><i class="fas fa-sign-in-alt"></i> Login</a></li>
  </ul>
<?php
    endif;
  else:
    //When logged
?>
  <ul class="navbar-nav mr-auto">
    <li class="nav-item active"><a class="nav-link" href="?p=upload"><i class="fas fa-sign-plus"></i>New</a></li>
<?php /*    <li class="nav-item"><a class="nav-link" href="#">Page 1</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Page 2</a></li> */ ?>
  </ul>
  <ul class="nav navbar-nav navbar-right">
    <li class="nav-item text-light">
        <span style="font-size: 1.5em; margin-right: 0.3em;"><i class="fas fa-user"></i></span>
        <?php echo $_SESSION['user']; ?>
    </li>
  </ul>
<?php
  endif;
?>
</nav>