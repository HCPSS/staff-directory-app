$("button#submit").click(function(e){
  e.preventDefault();
  var $path = "";
  var $mod = "";
  var $q_string = "";
    
  var $query = $("#search-field").val();
  var $render = $('#render-cards');

  var $selected = $("#search-toggle option:selected").val();

  if ($selected === "dept") {
    $q_string = "given-dept=";
  } else {
    $q_string = "given-name=";
  }

  $.ajax({
    type: "GET",
    url: $path,
    data: $q_string + $query,
    dataType: "html",
    success: function(response){
      $render.hide().html(response).fadeIn();
    },
    complete: function() {
    var $divAmt = $(".dir-search__entry").length;
    var $resultCount = $("#result-output").hide().fadeIn();

      if ($query === "") {
        if ($q_string === "given-dept=") {
          $resultCount.html("<h3>Please enter in a full or partial department name</h3>");
        } else {
          $resultCount.html("<h3>Please enter in a full or partial staff name</h3>"); 
        }
      } else if ($divAmt < 1) {
        if ($q_string === "given-dept=") {
          $mod = "what";
        } else {
          $mod = "who";
        }
        $resultCount.html("<h3>No results found</h3>" + "<p>Can't find " + $mod + " you're looking for? Try our <a href='/directory/departments'>full department listing</a> or call our main phone line, <strong>410-313-6000</strong> during normal business hours, 8:30 a.m. - 4:30 p.m.</p>");
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
