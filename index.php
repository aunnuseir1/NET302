<?php
// Config
$dbhost = "net302_admin:net302@52.23.213.239:27017";
$dbname = "net302";
$city = "plymouth";
// Connect to test database
$m = new MongoDB\Driver\Manager("mongodb://$dbhost");
$dbconnection = $m->$dbname;

// select the collection
$collection = $dbconnection->$city;

// pull a cursor query
$collections = $collection->find("plymouth");

foreach ($collections as $collection) {
    echo "amount of documents in $collection: ";
    echo $collection->count(), "\n";
  };
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
  <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container" ><a id="logo-container" href="index.php" class="brand-logo">Weather API</a>
      <ul class="right hide-on-med-and-down">
      <ul id="nav-mobile" class="sidenav">
        <li><a href="#">Navbar Link</a></li>
      </ul>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
  </nav>


  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <br><br>
      <h1 class="header center orange-text">Enter location</h1>
      <div class="row center">
        <h5 class="header col s12 light">Search for the weather below</h5>
      </div>

      <div class="row center">
        <a  id="download-button" class="btn-large waves-effect waves-light red">Search</a>
      </div>
      <br><br>

    </div>
  </div>

  <footer class="page-footer orange"style="position:fixed ; bottom: 0; left: 0; width: 100%;">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">NET302</h5>
          <p class="grey-text text-lighten-4">Open weather API</p>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      Made by <a class="orange-text text-lighten-3">Aun Nuseir</a>
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>
</html>
