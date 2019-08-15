<?php
    require_once 'inc/config.php';
    
    //Checks, which page the user is currently on to highlight in in the menu
    function isCurrentPage($page){
        $basename = basename($_SERVER["SCRIPT_FILENAME"], '.php'); 
        if($basename === $page){
           echo 'active'; 
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Banking App</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/logo-nav.css" rel="stylesheet">
    <?php if($darkMode === "true" || $darkMode === "1"){ ?> <link rel="stylesheet" type="text/css" href="css/dark.css" media="screen" /> <?php } ?>
    <link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
    <link href="https://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="all" href="css/jquery.minicolors.css">
    
    <!-- Chart.JS -->
    <script src="js/Chart.bundle.min.js"></script>

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">
          <?php
            /********************
            Write new entries into the database
            ********************/
            require_once('inc/updateDatabase.php');
          ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item <?php isCurrentPage("index"); ?>">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item <?php isCurrentPage("statement"); ?>">
              <a class="nav-link" href="statement.php">Statements</a>
            </li>
            <li class="nav-item <?php isCurrentPage("contract"); ?>">
              <a class="nav-link" href="contract.php">Contracts</a>
            </li>
            <li class="nav-item <?php isCurrentPage("category"); ?>">
              <a class="nav-link" href="category.php">Categories</a>
            </li>
            <li class="nav-item <?php isCurrentPage("settings"); ?>">
              <a class="nav-link" href="settings.php">Settings</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
