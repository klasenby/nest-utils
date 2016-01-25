nest-utils
==========

A collection of PHP scripts for reading and controlling the Nest thermostat forked from https://github.com/rbrenton/nest-utils.
- nest.class.php from https://github.com/rbrenton/nest-api (a fork of gboudreau/nest-api)
- humidityCheckInC.php 
  - For 2nd-generation thermostats with a humidifier.  
  - Reduce humidity as outside temperature drops to prevent window condensation.
  - converted original HumidityCheck.php script to use Celcius instead of Farenheit and added email alert when changes are made
  - logic doesn't quite work the way I want it to yet, its either too aggressive or not enough when the temp drops, it also doesn't seem to work predictibly as the interior temp drops (ie. works ok at 20/21C but as it drops to 16 overnight it doesn't seem to scale properly)
- simpleHumiditySet.php
  - uses fixed values to set humidity based on outside temperature
  - I created this when I couldn't get HumidityCheck.php to work properly, then I realized its expecting the Nest to be in Farenheit
