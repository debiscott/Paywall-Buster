<?php
  //This should run as a background process in a restricted directory that the web user can't access. 
  //Checks for the batch file created by the backend server for one minute on a loop.
  //The batch file, if found, is executed and a web page displaying the image is created.
 
  top:
    $directory = "X:\file\path\peeker_snapshots\";
    $files = scan_dir($directory);
    $count = 0;
    foreach ($files as $file) {
      if (preg_match('/\.bat/i',$file)) {
        $start_time   = date("Y-m-d h:i:sa");
        //print "start time:$start_time\n";
        $dothis = $directory . $file;
        doitagain:
        $grabber = array();
        $er = exec( $dothis, $grabber, $errno  );
        
        if ($er == "The system cannot find the file specified.") {
          sleep(1);
          $count++;
          if ($count > 60) { //letting it wait for the batch file for one minute; if it doesn't show then need to delete it and move on
            goto breakout;
          }
          goto doitagain;
        }
        var_dump($grabber);

        breakout:
        $dothis_next = "del " . $directory . $file;
        system($dothis_next);
        $end_time   = date("Y-m-d h:i:sa");
        //print "end time:$end_time\n";
      }
    }
    sleep(1);

  goto top;

function scan_dir($dir) {
    $ignored = array('.', '..', '.svn', '.htaccess');

    $files = array();    
    foreach (scandir($dir) as $file) {
        if (in_array($file, $ignored)) continue;
        $files[$file] = filemtime($dir . '/' . $file);
    }

    arsort($files);
    $files = array_keys($files);

    return ($files) ? $files : false;
}
?>
