<?php 
session_start();
if(isset($_SESSION["value"])){
    unset($_SESSION["value"]);
    session_destroy();
}else{
    unset($_SESSION["addmin"]);
session_destroy();
}
header("location: ../index.php");
?>