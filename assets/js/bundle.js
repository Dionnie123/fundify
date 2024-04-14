// bundle.js

import "./components/bootstrap.esm.min";
import "./components/slider";
import "./components/navigation";
jQuery(document).ready(function ($) {
  $("#post-filter-form").submit(function () {
    var filter = $("#post-filter-form");
    $.ajax({
      url: filter_vars.ajax_url,
      data: filter.serialize(), // form data
      type: filter.attr("method"), // POST
      success: function (data) {
        $("#filtered-posts").html(data); // insert filtered posts
      },
    });
    return false;
  });
});

console.log("bundle.js ✔️");
