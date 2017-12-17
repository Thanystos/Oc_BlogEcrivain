<?php
    session_start();
    include 'Controller/Router.php';
    
    $router = new Router();
    $router->routerRequest();