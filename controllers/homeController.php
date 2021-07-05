<?php

class homeController {

    public function index() {
        utils::isIdentity();
        
        require_once 'views/home/home.php';
    }

}
