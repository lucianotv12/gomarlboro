<?php
session_start();
session_destroy();
session_start();

include_once("funciones.php");


if (isset($_POST["user"]) && isset($_POST["password"]))
  {
    if(strlen($_POST["user"]) == 8) :     
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
          $_id = User_gt::login_admin($_POST["user"],$_POST["password"]);
          if($_id)
          {
            $_usuario = new User_gt($_id);
            $_SESSION["user_gt"] = serialize($_usuario);

            echo '<script type="text/javascript">

            window.location.assign("home.html");
            </script>';               
            header('Location:' . HOME . 'home.html');

          }else{
  
            $mensaje_error = true;
            include("view/login.php");
          }


        }
    else:
      
          $_id = User_gt::login_admin($_POST["user"],$_POST["password"]);
          if($_id)
          {
            $_usuario = new User_gt($_id);
            $_SESSION["user_gt"] = serialize($_usuario);

            echo '<script type="text/javascript">

            window.location.assign("home.html");
            </script>';               
            header('Location:' . HOME . 'home.html');

          }else{
            $ERROR = "Login Error " . $_POST["user"] . " : " . $_POST["password"];
            User::new_user_log(0,$ERROR);    
            $mensaje_error = true;
            include("view/login.php");
          }    


    endif;    
  }


if(!@$_SESSION["user"] and !@$_SESSION["user_gt"]):
  include("view/login.php");


endif;


?>
