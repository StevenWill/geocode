<?php

/**
 * Geocode: This class caches the yahoo maps request, 
 * navigates the xml and returns the values in an array.
 *
 * Note: a call to cache.class.php is made.
 */

class geocode {	

  /**
  * get values from cached yahoo maps request.
  */
  function location($geocode){
    //cache the restful call.
    //set tmp file yahoo url as md5
    $tmp_file = '/tmp/geo_'.md5($geocode);
    $cache = new cache();
    //set timeout to be short, 100, for testing
    $cache->file_cache($geocode, $tmp_file, 100);

    $number = "";
    $street = "";
    $city = "";
    $state = "";
    $zip = "";
    
    $handle = fopen($tmp_file, 'r');
    $response = fread($handle, filesize($tmp_file));
    $response_json = json_decode($response);
    fclose($handle);
    
    foreach($response_json->results['0']->address_components as $address) {
      if (in_array('street_number', $address->types)) {
        $number = $address->short_name;
      }
      if (in_array('route', $address->types)) {
        $street = $address->short_name;
      }
      if (in_array('locality', $address->types)) {
        $city = $address->short_name;
      }
      if (in_array('administrative_area_level_1', $address->types)) {
        $state = $address->short_name;
      }
      if (in_array('postal_code', $address->types)) {
        $zip = $address->short_name;
      }
    }

    $latitude = $response_json->results['0']->geometry->location->lat;

    $longitude = $response_json->results['0']->geometry->location->lng;
    
    $address = $number . " " . $street;

    return array($latitude, $longitude, $address, $city, $state, $zip);
  } 
}//end geocode class
