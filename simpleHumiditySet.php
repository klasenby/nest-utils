<?php

require_once('nest.class.php');

// Set timezone
date_default_timezone_set('America/New_York');

// Set Nest username and password.
define('USERNAME', 'youremail@somedomain.com');
define('PASSWORD', 'yourpassword');

// Define thermostat serial
define('THERMOSTAT_SERIAL', null);// Set this if you have more than 1 thermostat

// Convert F to C
function tempFtoC($f) {
  $f = (double) $f;
  return round(($f-32.0)/1.8,1);
}

// Convert C to F
function tempCtoF($c) {
  $c = (double) $c;
  return round((1.8*$c)+32.0,1);
}

$nest = new Nest();

try {
  // Retrieve data
  $locations = $nest->getUserLocations();
  $thermostat = $nest->getDeviceInfo(THERMOSTAT_SERIAL);
  $insideTemp = $thermostat->current_state->temperature;
  $outsideTemp = $locations[0]->outside_temperature;
  $insideHumidity = $thermostat->current_state->humidity;
  $targetHumidityCurrent = $thermostat->target->humidity;
  // Determine heat/cool target temperatures
/*   $mode = $thermostat->target->mode;
  $cool = $heat = $thermostat->target->temperature;
  if($mode=='range') {
    $heat = $heat[0];
    $cool = $cool[0];
  } else if($mode=='cool') {
    $heat = null;
  } else if($mode=='head') {
    $cool = null;
  } else {
    $cool = $head = null;
  } */
  
  // Sanity check that we have data
  if(!is_numeric($insideTemp) || !is_numeric($outsideTemp) || !is_numeric($targetHumidityCurrent) || !is_numeric($insideHumidity))
    throw new Exception("temp(inside)={$insideTemp},temp(outside)={$outsideTemp},humidity(inside)={$insideHumidity},target(max_humidity)={$targetHumidityCurrent}");

  // Check the outside temperature and set the humidity accordingly
  if($outsideTemp>=4) {
	  $targetHumidityAdjusted = 45;
  }
  else if($outsideTemp>=0) {
	  $targetHumidityAdjusted = 40;
  }
  else if($outsideTemp>=-7) {
	  $targetHumidityAdjusted = 35;
  }
  else if($outsideTemp>=-12) {
	  $targetHumidityAdjusted = 30;
  }
  else if($outsideTemp>=-18) {
	  $targetHumidityAdjusted = 25;
  }
  else if($outsideTemp>=-23) {
	  $targetHumidityAdjusted = 20;
  }
  else {
	  $targetHumidityAdjusted = 15;
  }

  // Adjust max humidity level if necessary
  echo "temp(inside)={$insideTemp}\n";
  echo "temp(outside)={$outsideTemp}\n";
  echo "humidity(inside)={$insideHumidity}\n";
  // echo "dewpoint(inside)={$currentDewpoint}\n";
  echo "target(max_humidity)={$targetHumidityCurrent}\n";
  echo "new_target(max_humidity)={$targetHumidityAdjusted}\n";

  if($targetHumidityAdjusted!=$targetHumidityCurrent) {
    $nest->setHumidity($targetHumidityAdjusted, THERMOSTAT_SERIAL);
  }

} catch (Exception $e) {
  echo "Exception: ".$e->getMessage()."\n";
}
