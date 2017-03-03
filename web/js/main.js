$("button#dir-submit").click(function(e){
  e.preventDefault();
  var path = "";
  var query = $("#search-field").val();
  $.ajax({
     type: "GET",
     url: path,
     data: 'given-name=' + query,
     dataType: "html",
     success: function(response){
      $('#render-cards').html(response);
     }
  });
});