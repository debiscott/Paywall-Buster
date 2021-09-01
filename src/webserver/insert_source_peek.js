//a call to the function insert_source_peek (<script>insert_source_peek();</script>) is in the footer of dynamic pages; without a call to this function the user will not be offered the chance to snapshot the remote site. 

  function insert_source_peek () {
    var container = document.getElementById ("passcanonical");
    var id = container.innerHTML;  
    var deep_look = window.location.href ;

    var sendthis =  "'" + deep_look + "'" + "," + "'" + id + "'";
    container.innerHTML = "<form id='breakpaywall' name='breakpaywall' onsubmit='return false'><input type=hidden value='" + deep_look + "'><input type=submit id=\"mybutton\" name=\"button\" value=\"paywall buster.v.01\" onclick=\"call_pk_function(\'" + deep_look + "," + id + "\');\"></form>";
    container.style.display = 'block';
    container.style.visibility = 'visible';
  }
  
 
