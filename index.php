<?php
session_start();
session_destroy();
session_start();

include_once("funciones.php");


if (isset($_POST["user"]) && isset($_POST["password"]))
  {
  $id = User::login_admin($_POST["user"],$_POST["password"]);
  if ($id)
    { 
    $_usuario = new User($id);
      $_SESSION["user"] = serialize($_usuario);
      echo '<script type="text/javascript">

      window.location.assign("home.html");
      </script>';               
      header('Location:' . HOME . 'home.html');
    }
  else
    {
        $mensaje_error = true;
      include("view/login.php");

    }
  }


/*if(!@$_SESSION["user"]):
  include("view/login.php");


endif;*/


?>
