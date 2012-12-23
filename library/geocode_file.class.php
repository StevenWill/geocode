<?php

/**
 * Geocode File: Read addresses from file and obtain geocode
 * before saving to a new file.
 *
 * Note: Includes call to geocode.class.php with location function.
 */

class geocode_file {

  /**
  * Read address and obtain geocodes before saving to a tmp file.
  */
  function readcsv($directory, $filename){

    //clean ends of destination for consistency
    $directory = trim($directory, "/");
    //check for directory and create it needed
    if(!file_exists("/tmp/" . $directory)){
      mkdir("/tmp/" . $directory, 0755);
    }
    //define destination file
    $dest_file = "/tmp/" . $directory . "/" . $filename;

    $row = 1;
    //check that address file is avaiable and open
    if (($fp = fopen("testAddresses.txt", "r")) !== FALSE) {
      //open destination file with write permissions
      $fp2 = fopen($dest_file, 'w');
      //loop through csv content with delimiter as ","
      while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
        $num = count($data);
        $row++;

        $address = urlencode(implode(" ", $data));
        
        //Google maps api request
        $geocode_new = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";

        //Call to geocode class to read Yahoo Maps api return and grab values
        $rd_geocode = new geocode();
        list ($latitude, $longitude, $address, $city, $state, $zip) = $rd_geocode->location($geocode_new);
        
        //format values and write to file
        $cvslist = $latitude . ", " . $longitude . ", " . $address . ", " . $city . ", " . $state . " " . $zip . "\n";
        fwrite($fp2, $cvslist);
        
        //print geocodes abd address to console.
        print urldecode($cvslist . "\n\r");
      }//end while
      fclose($fp2);//close destintation file

      fclose($fp);//close address file
    }
    //notify user running script of success.
    echo $dest_file . " created with geocodes!\n";
  }//end readcvs
}//end geocode_file class
