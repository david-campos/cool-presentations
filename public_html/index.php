<?php
    // Php session start
    session_start();
	
    // $pages maps the page key to the page files names, this are the only
	// allowed pages to load into the body (preventing attacks)
	$pages = ['ini'=>'inicio', 'view'=>'viewer', 'log'=>'login', 'upload'=>'upload_pdf', 'download'=>'download_pdf', 'mypres'=>'my_presentations'];
	// Some variables to configure the pages directory, styles and scripts file
	$pages_dir = '../pages/';
	$pages_scripts_file_sufix = "_scripts";
    $pages_styles_file_sufix = "_styles";
	// We get the current page from the GET variables, or set a default one
	$current_page_key = (isset($_GET['p'])?$_GET['p']:'ini');
    // Look for the page and save $current_page_file if it is right
	$current_page_file = "";
	if(array_key_exists($current_page_key, $pages)) {
		$current_page_file = $pages[$current_page_key];
	}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="icon" type="image/png" href="favicon_16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="favicon_48.png" sizes="48x48">
    <link rel="icon" type="image/png" href="favicon_96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="favicon_192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="favicon_32.png" sizes="32x32">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<!-- Font-awesome icons-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
	
	<!-- Our CSS -->
	<link rel="stylesheet" href="css/main-style.css">
<?php
    if($current_page_file !== "") {
        $styles_file = $pages_dir.$current_page_file.$pages_styles_file_sufix.'.php';
		if(file_exists($styles_file)) {
			include $styles_file;
		}
    }
?>
	<!-- For Bootstrap on IE 9 -->
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
    <title>Cool presentations</title>
  </head>
  <body>
 <?php
	// Header
	include '../modules/header.php';
	echo "\n";
?>
<?php
    if ($current_page_file !== "") {
		include $pages_dir.$current_page_file.'.php';
	} else {
?>
		<main role="main" class="container-fluid">
			<div class="row">
				<div class="col-md-8 offset-md-2">
					<div class="alert alert-danger">
						<strong>404!</strong> The page you are trying to
						access couldn't be found.
					</div>
				</div>
			</div>
		</main>
<?php
	}
?>
<?php
	echo "\n";
	
	// Footer
	include '../modules/footer.php';
	echo "\n";
?>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
	<!-- pdf.js -->
	<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
<?php
	if($current_page_file !== "") {
		$scripts_file = $pages_dir.$current_page_file.$pages_scripts_file_sufix.'.php';
		if(file_exists($scripts_file)) {
			include $scripts_file;
		}
	}
	echo "\n";
?>
  </body>
</html>