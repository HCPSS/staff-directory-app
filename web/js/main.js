$("button#dir-submit").click(function(e){
  e.preventDefault();
  var $path = "";
  var $query = $("#search-field").val();
  var $render = $('#render-cards');
  $.ajax({
    type: "GET",
    url: $path,
    data: 'given-name=' + $query,
    dataType: "html",
    success: function(response){
      $render.hide().html(response).fadeIn();
    },
    complete: function() {
    var $divAmt = $(".dir-search__entry").length;
    var $resultCount = $("#result-output").hide().fadeIn();
    var $helperText = "<p>Can't find who you're looking for? Try our full department listing or call our main phone line, <strong>410-313-6000</strong> during normal business hours, 8:30 a.m. - 4:30 p.m.</p>";
      if ($query === "") {
          $resultCount.html("<h3>Please enter in a full or partial name</h3>");
      } else if ($divAmt < 1) {
          $resultCount.html("<h3>No results found</h3>" + $helperText);
      } else {
          if ($divAmt === 1){
          $resultCount.html("<h3>" + $divAmt + " result found</h3>");
          } else {
          $resultCount.html("<h3>" + $divAmt + " results found</h3>");
          }
      };  
    }
  });
});