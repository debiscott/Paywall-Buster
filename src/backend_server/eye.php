<?php
  //Running this on backend server and looping it on interval.
  include 'C:\file\path\mysql_pconnect.php';
  //get the id of the next record to process
  $query = "select id, record_id, remote_url from peeker_front order by id asc limit 1";
  $result = mysql_query($query);
  $got_record = false;
  while ($row = mysql_fetch_array($result)) {
    $db_id = $row[0];
    $record_id = $row[1];
    $url = $row[2];
    $got_record = true;
  }     
  
  //take snapshot; delete from database because the id has been processed
  if ($got_record) {
    $output_file = "Y:\filepath\" . $record_id . "_smaller.png";
    take_snapshot_and_save($record_id,$url);
    $query = "delete from peeker_front where id = $db_id";
    $result = mysql_query($query));
  }
  
   
  function take_snapshot_and_save($this_record_id,$thisurl) {
    $quality = 50;
    $image_output_filename = "Y:\filepath\" . $this_record_id . ".png";
    $image_output_filename_smaller = "Y:\filepath\" . $this_record_id . "_smaller.png";

    $agent = "Mozilla/5.0+(Windows+NT+6.3;+Win64;+x64)+AppleWebKit/537.36+(KHTML,+like+Gecko)+Chrome/76.0.3809.100+Safari/537.36";
    $command = '"chrome" --headless --incognito --aggressive-cache-discard --user-agent="' . $agent . '" --window-size=1242,2646 --screenshot="' . $image_output_filename_smaller . '" ' . $thisurl;

    $grabber = array();
    $er = exec( $command, $grabber, $errno  );
      
    var_dump($grabber);   
  }

  function compress_image($source_url, $destination_url, $quality) {
    //call this to compress the image, but not currently using it
    $info = getimagesize($source_url);

    if ($info['mime'] == 'image/jpeg') {
      $image = imagecreatefromjpeg($source_url);
    }

    imagejpeg($image, $destination_url, $quality);
    return $destination_url;
  }





?>
