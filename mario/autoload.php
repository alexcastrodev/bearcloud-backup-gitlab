<?php

/*

@author: Alexandro Castro
@sistema: Bear Software

Autoload Classes 
*/

class Autoload {

    public static function Carregar() {
    $pasta = 'core/';
    $path = array_diff(scandir($pasta), array('..', '.'));

    foreach($path as $classes) {
        require_once $pasta.$classes;
    }
    }
}
