<?php
  //This script checks to see if the image has already been generated. If so then display it, if not then create it.  Display the remote page, and stop the spinner. Gather and display the time it took the script to complete.

  $staticurl = $_GET['staticurl'];
  $id = $_GET['id'];
  $start_all   = date("Y-m-d h:i:sa");
  $start_date_all = new DateTime($start_all);

  //below checks to see if the image has already been generated, if so then display if not create it
  $php_file = "X:\\file\path\\peeker_snapshots\\" . $id . ".php";
  $php_url = "https://oddcrimes.com/peeker_snapshots/" . $id . ".php";

  if (file_exists($php_file)) {
    $image_url = "https://oddcrimes.com/peeker_snapshots/" . $id . "_smaller.png";
    print "<a href=\"". $php_url . "\" rel=\"noopener\"><img src=\"" . $image_url . "\" style=\"width:100%;\" target=\"_blank\"></a>";  
    //$content = "<a href=\"". $php_file . "\" rel=\"noopener\"><img src=\"" . $base64 . "\" style=\"width:100%;\" target=\"_blank\"></a>";  
    //return $content;
    //exit();
  }  
  else {
    if ($id) { //if there is no $id number then we don't show an error on purpose, so as not to give hackers a hint.
      include 'Z:\inetpub\wwwroot\OddCrimes\o\cgi94\bits\mysql_pconnect_stories.php';
      $abcquery = "select HIGH_PRIORITY url,title from stories.crimenews where id = $id";
      $abcresult = mysql_query($abcquery);
      while ($abcrow = mysql_fetch_array($abcresult)) {
        $story_url = $abcrow[0];
        $this_title = $abcrow[1];
        $pulledpage = display_remote_page($id,$story_url,$this_title);
        print "$pulledpage<br>";
        print "<script>var dbSelect = $('#spinner');hideLoadSpinner(dbSelect);</script>";
        $end_all    = date("Y-m-d h:i:sa");
        $end_date_all = new DateTime($end_all);
        $since_start_all = $start_date_all->diff($end_date_all);
        if (($since_start_all->i > 0) or ($since_start_all->s > 0)) {
          print "<font size=2>Runtime: " . $since_start_all->i . "m:" . $since_start_all->s . "s</font>";
        }
      }
    }
  }
   
  ////////////////////////////////////////////////////////////////////////////////
  /////////// FUNCTIONS BELOW ////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////
  
  function display_remote_page($thisid,$remoteurl,$title) {
    //bbprint "just entered display_remote_page function<br>\n";
    $image_url = "https://oddcrimes.com/peeker_snapshots/" . $thisid . "_smaller.png";
    $php_file = "X:\\file\path\\peeker_snapshots\\" . $thisid . ".php";
    $image_file = "X:\\file\path\\peeker_snapshots\\" . $thisid . "_smaller.png";
    $php_url = "https://oddcrimes.com/peeker_snapshots/" . $thisid . ".php";

    include 'X:\\file\path\\mysql_pconnect_peeker_switcher.php';

    $query = "insert peeker (record_id, remote_url) values ($thisid,'$remoteurl')";
    $result = mysql_query($query);
		
   	$filter_pdf_files = preg_replace('/\.pdf$/','', $remoteurl);
    $query = "insert peeker_front (record_id, remote_url) values ($thisid,'$filter_pdf_files')";
    $result = mysql_query($query);
					
    $cp_batchfile = "X:\\file\path\\peeker_snapshots\\" . $thisid . ".bat";
    $createimagefile_handle = fopen($cp_batchfile,'w') or die("2aCan't open $cp_batchfile\n");
    $command = "copy V:\\" . $thisid . "_smaller.png  X:\\file\path\\peeker_snapshots";
    fwrite($createimagefile_handle, $command);
    fclose ($createimagefile_handle); 
    
    $filecontent = "";

    if (file_exists ($image_file)) {
      $filesize = filesize($image_file);
    }
      
    $mecount = 0;
    while (!file_exists($image_file)) {
      usleep(2);
      $mecount++;
    }
    jumpout:
    $htmlstuff = "<!DOCTYPE><html><head><title>$title</title></head><body><img src=\"" . $image_url . "\" style=\"width:100%;\" ></body></html>";
    $createimagefile_handle = fopen($php_file,'w');
    fwrite($createimagefile_handle, $htmlstuff);
    fclose ($createimagefile_handle); 
    $image_file = "X:\\file\path\\peeker_snapshots\\" . $thisid . "_smaller.png";

    $luminance = get_avg_luminance($image_file,10);   
   
    if ($luminance >= 80) {
      $filecontent .=  "<a href=\"". $php_url . "\" rel=\"noopener\"><img src=\"" . $image_url . "\" style=\"width:100%;\" target=\"_blank\"></a><br><div style=\"display: inline;background-color:white;color:red;\">Sorry for the occluded image. The next version of the paywall buster should fix this. $luminance</div>";
    }
    else {
      $filecontent .= "<hr><a href=\"". $php_url . "\" rel=\"noopener\"><img src=\"" . $image_url . "\" style=\"width:100%;\" target=\"_blank\"></a><br>";  
    }
    return $filecontent;
  }

  function get_avg_luminance($filename, $num_samples=10) {
      //This script is from https://gist.github.com/Dare-NZ/5544773
      $img = imagecreatefromjpeg($filename);

      $width = imagesx($img);
      $height = imagesy($img);

      $x_step = intval($width/$num_samples);
      $y_step = intval($height/$num_samples);

      $total_lum = 0;

      $sample_no = 1;

      for ($x=0; $x<$width; $x+=$x_step) {
          for ($y=0; $y<$height; $y+=$y_step) {

              $rgb = imagecolorat($img, $x, $y);
              $r = ($rgb >> 16) & 0xFF;
              $g = ($rgb >> 8) & 0xFF;
              $b = $rgb & 0xFF;

              // Choose a simple luminance formula from here:
              // http://stackoverflow.com/questions/596216/formula-to-determine-brightness-of-rgb-color
              $lum = ($r+$r+$b+$g+$g+$g)/6;

              $total_lum += $lum;

              $sample_no++;
          }
      }

      $avg_lum  = $total_lum/$sample_no . "w:" . $width . " h:" . $height;

      return $avg_lum;
  }
?>