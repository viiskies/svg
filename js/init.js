updateSVG();
function updateMaxSize() {
    $('#xSlider').attr('max', $('#svg').width());
}

window.onresize = updateMaxSize;


function updateSVG() {
    var url = "svg.php"; // the script where you handle the form input.

    $.ajax({
        type: "POST",
        url: url,
        data: $("#svgForm").serialize(), // serializes the form's elements.
        success: function(data)
        {
            $( "#svg" ).html( data);
        }
    });

    // e.preventDefault(); // avoid to execute the actual submit of the form.
}

(function($){
  $(function(){

    $('.sidenav').sidenav();

  }); // end of document ready
})(jQuery); // end of jQuery name space
