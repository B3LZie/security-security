$(document).ready(function () {
  $("#prefix").change(function () {
    if ($(this).find("option:selected").val() == "Other") {
      $("#other").removeAttr("disabled")
    } else {
      $("#other").attr("disabled","disabled")
    }
  });
});
