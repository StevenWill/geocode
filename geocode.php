<?php
/**
 *Read address file and save geocoded results
 *
 *Note: run "php ./geocode.php"
 */

//function to auto load classes when called
function __autoload($class_name) {
  require_once('library/' . $class_name . '.class.php');
}

//create object from geocode_file class
$obj = new geocode_file();

//directory to save geocoded results.
$dir = "addressScriptOutput/";
//file to save geocoded results.
$file = "addressGeocodingOutput.txt";

//read address file and save geocoded results.
$obj->readcsv($dir, $file);
