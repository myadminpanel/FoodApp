<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<span class="timezone"></span>

<script type="text/javascript">
	  $.get('https://ipapi.co/timezone', function(data){
	      $('.timezone').text(data);
	  });
</script>