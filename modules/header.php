<nav class="navbar navbar-dark bg-dark justify-content-between">
  <a class="navbar-brand" href=".">Presentations</a>
<?php
  /*
  <ul class="navbar-nav mr-auto">
    <li class="nav-item active"><a class="nav-link" href="#">Home</a></li>
    <li class="nav-item"><a class="nav-link" href="#">Page 1</a></li>
    <li class="nav-item"><a class="nav-link" href="#">Page 2</a></li>
  </ul>
  */
?>
<?php
  if (!isset($_SESSION['user_id'])) {
    // Do not show "login" buton on the login page
    if ($current_page_key != 'log') {
?>
  <ul class="nav navbar-nav navbar-right">
    <li class="nav-item"><a href="?p=log" class="btn btn-outline-success" type="button"><i class="fas fa-sign-in-alt"></i> Login</a></li>
  </ul>
<?php
    }
  } else {
      //When logged
?>
  <ul class="nav navbar-nav navbar-right">
    <li class="nav-item text-light">
        <span style="font-size: 1.5em; margin-right: 0.3em;"><i class="fas fa-user"></i></span>
        <?php echo $_SESSION['user']; ?>
    </li>
  </ul>
<?php
  }
?>
</nav>