<?php

function getRoutes()
{
    return require 'configs/routes.php';
}

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function flash($name = '', $message = '', $class = 'info'){
    if(!empty($name)){
        if(!empty($message) && empty($_SESSION[$name])){
            $_SESSION[$name] = $message;
            $_SESSION[$name.'_class'] = 'alert  alert-' . $class;
        }else if(empty($message) && !empty($_SESSION[$name])){
            $class = !empty($_SESSION[$name.'_class']) ? $_SESSION[$name.'_class'] : 'alert  alert-' . $class;
            echo '<div class="'.$class.'" >'.$_SESSION[$name].'</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name.'_class']);
        }
    }
}

function redirect($location)
{
    header("location: " . $location);
    exit();
}