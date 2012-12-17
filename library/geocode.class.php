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
    //cache the restful call becuase it is good practice.
    //set tmp file yahoo url as md5
    $tmp_file = '/tmp/geo_'.md5($geocode);
    $cache = new cache();
    //set timeout to be short, 100, for testing
    $cache->file_cache($geocode, $tmp_file, 100);

    //creat new document to work on
    $rssdoc = new DOMDocument();
    //load tmp_file into document
    $rssdoc->load( $tmp_file );

    //navigate to Latitude node
    $xmllat = $rssdoc->getElementsByTagName( "Latitude" );
    //get value of Latitude node
    $latitude = $xmllat->item(0)->nodeValue;

    $xmllong = $rssdoc->getElementsByTagName( "Longitude" );
    $longitude = $xmllong->item(0)->nodeValue;

    $xmladd = $rssdoc->getElementsByTagName( "Address" );
    $address = $xmladd->item(0)->nodeValue;

    $xmlcity = $rssdoc->getElementsByTagName( "City" );
    $city = $xmlcity->item(0)->nodeValue;

    $xmlstate = $rssdoc->getElementsByTagName( "State" );
    $state = $xmlstate->item(0)->nodeValue;

    $xmlzip = $rssdoc->getElementsByTagName( "Zip" );
    $zip = $xmlzip->item(0)->nodeValue;

    return array($latitude, $longitude, $address, $city, $state, $zip);
  } 
}//end geocode class
