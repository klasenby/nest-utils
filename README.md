nest-utils (forked from https://github.com/rbrenton/nest-utils)
==========

A collection of PHP scripts for reading and controlling the Nest thermostat.
- nest.class.php from https://github.com/rbrenton/nest-api (a fork of gboudreau/nest-api)
- humidityCheckInC.php 
  - For 2nd-generation thermostats with a humidifier.  
  - Reduce humidity as outside temperature drops to prevent window condensation.
  - converted original HumidityCheck.php script to use Celcius instead of Farenheit and added email alert when changes are made
- simpleHumiditySet.php
  - uses fixed values to set humidity based on outside temperature
  - I created this when I couldn't get HumidityCheck.php to work properly, then I realized its expecting the Nest to be in Farenheit
