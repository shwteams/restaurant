<?php
if(!isset($_SESSION))
    session_start();

include '../../services/lib.php';
include_once '../../services/parameters.php';
$db = DoConnexion(HOST, USER, PWD, DBNAME);
if (isset($_GET["task"])) {
    $task = $_GET["task"];
    if ($task == "") {
        echo 'Error';
    } 
    else if ($task == "getAllTable"){
        $lg_TABLE_ID = "";
        if(isset($_GET['lg_TABLE_ID']))
        {
            $lg_TABLE_ID = htmlentities($_GET['lg_TABLE_ID']);
        }
        getAllTable($lg_TABLE_ID, $db);
    } 
    else if ($task == "deteleTable"){
        $lg_TABLE_ID = $_GET["lg_TABLE_ID"];
        deteleTable($lg_TABLE_ID, $db);
    }
} 
else if (isset($_POST['addTable'])){    
    $lg_TABLE_ID = "";
    $str_WORDING = htmlspecialchars($_POST['str_WORDING']);
    $int_NUMBER_PLACE = htmlspecialchars($_POST['int_NUMBER_PLACE']);
    addTable($lg_TABLE_ID, $str_WORDING, $int_NUMBER_PLACE, $db);
} 
else if (isset($_POST['editTable'])) {
    $lg_TABLE_ID = htmlentities(trim($_POST['lg_TABLE_ID']));
    $str_WORDING = htmlspecialchars($_POST['str_UWORDING']);
    $int_NUMBER_PLACE = htmlspecialchars($_POST['int_UNUMBER_PLACE']);
    editTable($lg_TABLE_ID, $str_WORDING, $int_NUMBER_PLACE, $db);
}