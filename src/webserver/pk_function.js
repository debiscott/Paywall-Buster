  function addLoadSpinner(el) {
   if (el.length > 0) {
        if ($("#img_" + el[0].id).length > 0) {
            $("#img_" + el[0].id).css('display', 'block');
            $("#img_" + el[0].id).css('visibility', 'visible');
        }               
        else {
            var img = $('<img class="ddloading">');
            img.attr('id', "img_" + el[0].id);
            img.attr('src', '/o/images/spinner.gif');
            img.css({ 'display': 'block', 'width': '25px', 'height': '25px' });
            img.prependTo(el[0].nextElementSibling);
        }
        el.prop("disabled", true);               
    }
  }
    
  function hideLoadSpinner(el) {
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

  function call_pk_function (value) {
    var input = value.split(",");
    var staticurl = input[0];
    var id = input[1];
    var dbSelect = $('#spinner');
    addLoadSpinner(dbSelect);  
    $.get({
        url: '/peek.php?staticurl=' + staticurl + '&id=' + id, 
        success: function(result){
          $('#here').html(result);
        }
      }
    );
    return false;
  }
