<?php

if(isset($_POST['action'] && !empty($_POST['action'])){
    $action = $_POST['action'];
    
    switch($action){
        case 'add':
            add($_POST['title'], $_POST['price'], $_POST['img']);
            break;
    }
}

function add($title, $price, $img){
    
    
        
}