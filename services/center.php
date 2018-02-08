<?php
/**
Dans ce fichier il faut ajouter la liste des fichiers du composant/com_
et lancer leurs methode
*/
include_once '../composant/com_customer/customer.php';

if (isset($_GET["task"])) {
    $task = $_GET["task"];
}


switch ($task) {
    case 'showLoginForm':
        if (isset($_SESSION['str_USER_ID'])) {
            header("location:index.php");
        } else {
            header('location:login.php');
        }
        break;
    case 'showAllCustomer':
        echo showAllCustomer();
        break;
        
    default:
        showHomeAdminPage();
        break;
}

function showAllCustomer() {
    Customer::showAllCustomer();
}

function showHomeAdminPage(){
    Dashbord::showHomeAdminPage();
}