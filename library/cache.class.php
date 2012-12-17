<?php

/**
 *Cache file in tmp folder and refresh on timeout.
 */

class cache {

  /**
   *Cache the url result and recache on timout
   */
  function file_cache($url, $tmp_file, $timeout) {
    if(!file_exists($tmp_file) || filemtime($tmp_file) < (time()-$timeout)) {
      //use curl to get content
      $session = curl_init($url);
      curl_setopt($session, CURLOPT_HEADER, false);
      curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
      //grab data
      $data = curl_exec($session);
      curl_close($session); 

      //if no data quit
      if ($data === false) return false;
      //set file in tmp directory
      $tmpf = tempnam('/tmp', $file);
      //open file and save data from curl
      $fp = fopen($tmpf,"w");
      fwrite($fp, $data);
      fclose($fp);
      //rename to file name provided
      rename($tmpf, $tmp_file);
      }
    //return URI of file
    return ($tmp_file);
  }
}//end cache class
