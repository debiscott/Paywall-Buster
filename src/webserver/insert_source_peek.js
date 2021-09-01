//A call to the function insert_source_peek (<script>insert_source_peek();</script>) is placed in the footer of the webpage; without a call to this function the user will not be offered the chance to see an image of the remote webpage.
//Create a div called "place_holder" in the dynamic pages where the button will be displayed.
  
  function insert_source_peek () {
    var container = document.getElementById ("place_holder");
    var id = container.innerHTML;    
    var deep_look = window.location.href ;
    var sendthis =  "'" + deep_look + "'" + "," + "'" + id + "'";
    container.innerHTML = "<div id=\"spinner\" name=\"spinner\"></div><FORM id='breakpaywall' name='breakpaywall' onsubmit='return false'><INPUT TYPE=hidden VALUE='" + deep_look + "'><INPUT TYPE=SUBMIT id=\"button\" name=\"button\" value=\"PAYWALL BUSTER.v.01\" onclick=\"pk_function(\'" + deep_look + "," + id + "\');\"></FORM>";
    container.style.display = 'block';
    container.style.visibility = 'visible';
  }
  
 