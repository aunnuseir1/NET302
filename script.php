<?php

//validation for the user input strips all the numbers and truns the letters all lower case 
$loc = $_POST['location'];
$locstrip = strtolower($loc);
$location = preg_replace("/[^a-zA-Z]/", "", $locstrip);

//executes the python script and fetches the the JSON dump
$execute = exec("/var/www/net302/weatherapi/bin/python /var/www/net302/weatherapi/weatherapi.py $location");

//if the api cant find the location because input is invalid this
$error = "['/var/www/net302/weatherapi/weatherapi.py', '$location']"; 

$message = ''; 

//if the input is empty 
if ($location == None || !isset($location) || $location == Null || $location == '')
{
	$message = "Invalid location, Please enter a valid location";
	header("location:../index.php?message=$message");
	
}
//if the openweathermap is down
if ($execute == '[!] Request Failed')
{
	$message = "API is down please try again later";
}

//the encoding of the header
header('Content-Type: text/html; charset=utf-8');

//sends the message to index.php if the api can not find the location
if ($execute == $error)
{

	$message = "Invalid location, Please enter a valid location";
        header("location:../index.php?message=$message");
}

//generates an array from the JSON dump made my the python script
$array = json_decode($execute,TRUE);


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
  <link href="css/weather.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
	<!-- nav bar  -->
  <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container" ><a id="logo-container" href="index.php" class="brand-logo">Weather API</a>
      <ul class="right hide-on-med-and-down">
      <ul id="nav-mobile" class="sidenav">
        <li><a href="#">Navbar Link</a></li>
      </ul>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
  </nav>


<!-- weather card format  -->
<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center">
            <div class="col-lg-8 grid-margin stretch-card">
                <!--weather card-->
                <div class="card card-weather">
                    <div class="card-body">
                        <div class="weather-date-location">
				
				<!-- shows the weather for the 'today' using the array list created above -->
			<h3>Today</h3>
				<!-- gets the time stamp  -->
			    <p class="text-gray"> <span class="weather-date"> <?php $timestamp= $array['daily'][0]['dt']; echo gmdate("j F, Y", $timestamp);?> </span> <span class="weather-location"><?php echo $array['timezone'];?></span> </p>
                        </div>
                        <div class="weather-data d-flex">
                            <div class="mr-auto">
				    <!-- all the different variables about the weather for the location selected by user  -->
                                <h4 class="display-3"><?php echo round($array['daily'][0]['temp']['day']);?> <span class="symbol">°</span>C</h4>
				<p>Description: <?php echo ucwords($array['daily'][0]['weather'][0]['description']);?></p>
				<p>Feels Like: <?php echo round($array['daily'][0]['feels_like']['day']);?><span class="symbol">°</span>C</p>
				<p>Max Temp: <?php echo round($array['daily'][0]['temp']['max']);?><span class="symbol">°</span>C</p>
				<P>Wind Speed: <?php echo round($array['daily'][0]['wind_speed']);?> MPH</p>
				<p>Humidity: <?php echo $array['daily'][0]['humidity'];?>%</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="d-flex weakly-weather">
                            <div class="weakly-weather-item">
				    <!-- weather for tomorrow with all the relevant data also from the array list -->
                                <h3 class="mb-0"> Tomorrow </h3> <i class="mdi mdi-weather-cloudy"></i>
				    <!-- rounds the number from the array to the nearst whole number -->
				<p class="mb-0"> Temp: <?php echo round($array['daily'][1]['temp']['day']);?><span class="symbol">°</span>C</p>
				    <!-- turns the first letter from the array output into a capital  -->
				<p class="mb-0"> Description: <?php echo ucwords($array['daily'][1]['weather'][0]['description']);?></p>
                                <p class="mb-0"> Feels like: <?php echo round($array['daily'][1]['feels_like']['day']);?><span class="symbol">°</span>C</p>
                                <p class="mb-0"> Max Temp: <?php echo round($array['daily'][1]['temp']['max']);?><span class="symbol">°</span>C</p>
                                <p class="mb-0"> Wind speed: <?php echo round($array['daily'][1]['wind_speed']);?> MPH</p>
                                <p class="mb-0"> Humidity: <?php echo $array['daily'][1]['humidity'];?>%</p>
                            </div>
                            <div class="weakly-weather-item">
				    <!-- use the array list to get a time in unix and calls the built in PHP libary gmdate to covert it in to a date redable by the user -->
				    <!-- also incudes all the relvant data, rounding of numbers and making the first letter capital  -->
                                <h3 class="mb-0"> <?php $timestamp= $array['daily'][2]['dt']; echo gmdate("D, m.d.y", $timestamp);?> </h3> <i class="mdi mdi-weather-cloudy"></i>
				<p class="mb-0"> Temp: <?php echo round($array['daily'][2]['temp']['day']);?><span class="symbol">°</span>C</p>
				<p class="mb-0"> Description: <?php echo ucwords($array['daily'][2]['weather'][0]['description']);?></p>
                                <p class="mb-0"> Feels like: <?php echo round($array['daily'][2]['feels_like']['day']);?><span class="symbol">°</span>C</p>
                                <p class="mb-0"> Max Temp: <?php echo round($array['daily'][2]['temp']['max']);?><span class="symbol">°</span>C</p>
                                <p class="mb-0"> Wind speed: <?php echo round($array['daily'][2]['wind_speed']);?> MPH</p>
                                <p class="mb-0"> Humidity: <?php echo $array['daily'][2]['humidity'];?>%</p>
                            </div>
                            <div class="weakly-weather-item">
				    <!-- use the array list to get a time in unix and calls the built in PHP libary gmdate to covert it in to a date redable by the user -->
				    <!-- also incudes all the relvant data, rounding of numbers and making the first letter capital  -->
                                <h3 class="mb-0"> <?php $timestamp= $array['daily'][3]['dt']; echo gmdate("D, m.d.y", $timestamp);?> </h3> <i class="mdi mdi-weather-cloudy"></i>
				<p class="mb-0"> Temp: <?php echo round($array['daily'][3]['temp']['day']);?><span class="symbol">°</span>C</p>
				<p class="mb-0"> Description: <?php echo ucwords($array['daily'][3]['weather'][0]['description']);?></p>
                                <p class="mb-0"> Feels like: <?php echo round($array['daily'][3]['feels_like']['day']);?><span class="symbol">°</span>C</p>
                                <p class="mb-0"> Max Temp: <?php echo round($array['daily'][3]['temp']['max']);?><span class="symbol">°</span>C</p>
                                <p class="mb-0"> Wind speed: <?php echo round($array['daily'][3]['wind_speed']);?> MPH</p>
                                <p class="mb-0"> Humidity: <?php echo $array['daily'][3]['humidity'];?>%</p>
                            </div>
                            <div class="weakly-weather-item">
				     <!-- use the array list to get a time in unix and calls the built in PHP libary gmdate to covert it in to a date redable by the user -->
				    <!-- also incudes all the relvant data, rounding of numbers and making the first letter capital  -->
                                <h3 class="mb-0"> <?php $timestamp= $array['daily'][4]['dt']; echo gmdate("D, m.d.y", $timestamp);?> </h3> <i class="mdi mdi-weather-cloudy"></i>
				<p class="mb-0"> Temp: <?php echo round($array['daily'][4]['temp']['day']);?><span class="symbol">°</span>C</p>
				<p class="mb-0"> Description: <?php echo ucwords($array['daily'][4]['weather'][0]['description']);?>
                                <p class="mb-0"> Feels like: <?php echo round($array['daily'][4]['feels_like']['day']);?><span class="symbol">°</span>C</p>
                                <p class="mb-0"> Max Temp: <?php echo round($array['daily'][4]['temp']['max']);?><span class="symbol">°</span>C</p>
                                <p class="mb-0"> Wind speed: <?php echo round($array['daily'][4]['wind_speed']);?> MPH</p>
                                <p class="mb-0"> Humidity: <?php echo $array['daily'][4]['humidity'];?>%</p>
			    </div>
                        </div>
                    </div>
		</div>
		<!--weather card ends-->
            </div>
        </div>
    </div>
</div>                            

<!--  google map format-->
<style>
    html, body{
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
    }
    #map-canvas {
      width: 100%;
      height: 70%;
    }
    .gm-style-iw {
      text-align: center;
    }
</style>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js">
</script>

<!-- script to run the Google map and despaly it  -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGOdvckPbP4AmnlWK8QZCBpU02PTlO_EU&callback=initMap" type="text/javascript"></script>
	  
<!-- map variables and libaries  -->
<script>
  var map;
  var geoJSON;
  var request;
  var gettingData = false;
  var openWeatherMapKey = "055997a3efcd913f3ef01ff6b8eecd6a"

  function initialize() {
    var mapOptions = {
      zoom: 12,
      center: new google.maps.LatLng("<?php echo $array['lat'];?>","<?php echo $array['lon'];?>")
    };

    map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);
    // Add interaction listeners to make weather requests
    google.maps.event.addListener(map, 'idle', checkIfDataRequested);

    // Sets up and populates the info window with details
    map.data.addListener('click', function(event) {
      infowindow.setContent(
       "<img src=" + event.feature.getProperty("icon") + ">"
       + "<br /><strong>" + event.feature.getProperty("city") + "</strong>"
       + "<br />" + event.feature.getProperty("temperature") + "&deg;C"
       + "<br />" + event.feature.getProperty("weather")
       );
      infowindow.setOptions({
          position:{
            lat: event.latLng.lat(),
            lng: event.latLng.lng()
          },
          pixelOffset: {
            width: 0,
            height: -15
          }
        });
      infowindow.open(map);
    });
  }

  var checkIfDataRequested = function() {
    // Stop extra requests being sent
    while (gettingData === true) {
      request.abort();
      gettingData = false;
    }
    getCoords();
  };

  // Get the coordinates from the Map bounds
  var getCoords = function() {
    var bounds = map.getBounds();
    var NE = bounds.getNorthEast();
    var SW = bounds.getSouthWest();
    getWeather(NE.lat(), NE.lng(), SW.lat(), SW.lng());
  };

  // Make the weather request
  var getWeather = function(northLat, eastLng, southLat, westLng) {
    gettingData = true;
    var requestString = "http://api.openweathermap.org/data/2.5/box/city?bbox="
                        + westLng + "," + northLat + "," //left top
                        + eastLng + "," + southLat + "," //right bottom
						                        + map.getZoom()
                        + "&cluster=yes&format=json"
                        + "&APPID=" + openWeatherMapKey;
    request = new XMLHttpRequest();
    request.onload = proccessResults;
    request.open("get", requestString, true);
    request.send();
  };

  // Take the JSON results and proccess them
  var proccessResults = function() {
    console.log(this);
    var results = JSON.parse(this.responseText);
    if (results.list.length > 0) {
        resetData();
        for (var i = 0; i < results.list.length; i++) {
          geoJSON.features.push(jsonToGeoJson(results.list[i]));
        }
        drawIcons(geoJSON);
    }
  };

  var infowindow = new google.maps.InfoWindow();

  // For each result that comes back, convert the data to geoJSON
  var jsonToGeoJson = function (weatherItem) {
    var feature = {
      type: "Feature",
      properties: {
        icon: "http://openweathermap.org/img/w/"
              + weatherItem.weather[0].icon  + ".png",
        coordinates: [weatherItem.coord.Lon, weatherItem.coord.Lat]
      },
      geometry: {
        type: "Point",
        coordinates: [weatherItem.coord.Lon, weatherItem.coord.Lat]
      }
    };
    // Set the custom marker icon
    map.data.setStyle(function(feature) {
      return {
        icon: {
          url: feature.getProperty('icon'),
          anchor: new google.maps.Point(10, 10)
        }
      };
    });

    // returns object
    return feature;
  };

  // Add the markers to the map
  var drawIcons = function (weather) {
     map.data.addGeoJson(geoJSON);
     // Set the flag to finished
     gettingData = false;
  };

  // Clear data layer and geoJSON
  var resetData = function () {
    geoJSON = {
      type: "FeatureCollection",
      features: []
    };
    map.data.forEach(function(feature) {
      map.data.remove(feature);
    });
  };

  google.maps.event.addDomListener(window, 'load', initialize);
</script>
<body>
<body>

<div id="map-canvas"></div>

</body>



</br>



<!-- footer  -->
<footer class="page-footer orange"style=" width: 100%;">
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

  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

</body>
</html>

