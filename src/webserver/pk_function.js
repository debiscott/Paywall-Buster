  function addLoadSpinner(el) {
    //display the spinner
    if (el.length > 0) {
        if ($("#img_" + el[0].id).length > 0) {
            $("#img_" + el[0].id).css('display', 'block');
            $("#img_" + el[0].id).css('visibility', 'visible');
        }               
        else {
            var img = $('<img class="ddloading">');
            img.attr('id', "img_" + el[0].id);
            img.attr('src', '/snapshots/spinner.gif');
            //img.css({ 'display': 'block', 'width': '25px', 'height': '25px', 'z-index': '100', 'float': 'right' });
            img.css({ 'display': 'block', 'width': '25px', 'height': '25px' });
            img.prependTo(el[0].nextElementSibling);
        }
        el.prop("disabled", true);               
    }
  }
    
  function hideLoadSpinner(el) {
    //hide the spinner and let the user know the image is now available
    if (el.length > 0) {
      if ($("#img_" + el[0].id).length > 0) {
        setTimeout(function () {
        $("#img_" + el[0].id).css('display', 'none');
        $("#img_" + el[0].id).css('visibility', 'hidden');
        el.prop("disabled", false);
        alert('All Done! Click on the image below to see the webpage.');
        }, 500);                    
      }
    }
  } 

    
  function pk_function (value) {
    //start the process to check and/or create the snapshot image
    var input = value.split(",");
    var staticurl = input[0];
    var id = input[1];
    var dbSelect = $('#spinner');
    addLoadSpinner(dbSelect);  
    //OddCrimes does not force the user to use SSL because of older phones. The code below is necessary to avoid problems.
    if (location.protocol == "http:") {
      $.get({
          url: 'http://oddcrimes.com/p/peeker.php?staticurl=' + staticurl + '&id=' + id, 
          success: function(result){
            $('#here').html(result);
          }
        }
      );
    }
    else {
      $.get({
          url: 'https://oddcrimes.com/p/peeker.php?staticurl=' + staticurl + '&id=' + id, 
          success: function(result){
            $('#here').html(result);
          }
        }
      );
    }
    return false;
  }
