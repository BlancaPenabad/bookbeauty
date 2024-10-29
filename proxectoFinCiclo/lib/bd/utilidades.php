<?php

function test_input($datos){
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

function get_mensajes_html_format($mensajes){
    
    $resultado = "";

    if(count($mensajes) > 0) {
        foreach ($mensajes as $mensaje){
            if($mensaje[0] == "error"){
                $resultado .= '<div class="alert alert-danger" role="alert">' . $mensaje[1] . '</div>';   
            }elseif($mensaje[0] == "success"){
                $resultado .= '<div class="alert alert-success" role="alert">' . $mensaje[1] . '</div>';
            }
        }
    }
    return $resultado;
}
  
function is_logged(){
    if(!isset($_SESSION)){
        session_start();
    }
    if(isset($_SESSION['usuario'])){
        return true;
    }else{
        return false;
    }
}

function logout(){


    $_SESSION = array();
    session_destroy();

    if(isset($_COOKIE['usuario'])){
        setcookie('usuario', '', time() - 3600, '/');
    }
    header('Location: login.php');
    exit();

}

?>