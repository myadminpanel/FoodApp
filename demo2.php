  <script type="text/javascript">
  $("#btn").on("click", function () {
    $.cookie('myCookie', $("#txtin").val(), { expires: 365 });
  });
  var cookVal; // declared local to the whole onready function
  $("#btntwo").on("click", function () {
    cookVal = $.cookie('myCookie');
  });
  $("#btnthree").on("click", function () {
    $("#txtout").val(cookVal);
  });
  </script>
