<?php
    $userinfo = $user->getuserinfo($uid);
    $countorder=$user->countnotifyorder();
?>
<div id="header" class="header navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="dashboard.php" class="navbar-brand"><span class="navbar-logo"></span> Food Delivery System</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown navbar-user">
                
                <li class="dropdown">

                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <i class="fa fa-bell"></i></a>

                  <ul class="dropdown-menu dropdown-menus" onclick="functionrefesh()"></ul>

                 </li>
            </li>
            <li class="dropdown navbar-user">
                <a href="javascript:;" class="" data-toggle="dropdown">
                    <span class="hidden-xs"><?php echo $userinfo->username;  ?></span> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInLeft">
                    <li class="arrow"></li>
                    <li><a href="changepassword.php">Change Password</a></li>
                    <li class="divider"></li>
                    <li><a href="logout.php">Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    function play_sound() {
        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', 'serious-strike.mp3');
        audioElement.setAttribute('autoplay', 'autoplay');
        audioElement.load();
        audioElement.play();
    }
</script>
<script>
 function functionrefesh(){
    
    window.location.reload();    
}
$(document).ready(function(){

// updating the view with notifications using ajax

function load_unseen_notification(view = '')

{

 $.ajax({

  url:"fetch.php",
  method:"POST",
  data:{view:view},
  dataType:"json",
  success:function(data)

  {

   $('.dropdown-menus').html(data.notification);

   if(data.unseen_notification > 0)
   {
     
    play_sound();
 
    $('.count').html(data.unseen_notification);
  
   }

  }

 });

}

load_unseen_notification();

// load new notifications

$(document).on('click', '.dropdown-menu dropdown-menus', function(){

 $('.count').html('');

 load_unseen_notification('yes');

});

setInterval(function(){

 load_unseen_notification();;

}, 5000);

});

</script>