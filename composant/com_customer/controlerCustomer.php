<?php
if(!isset($_SESSION))
    session_start();

include '../../services/lib.php';
include_once '../../services/parameters.php';
$db = DoConnexion(HOST, USER, PWD, DBNAME);
//echo $_POST['addcustomer'];
if (isset($_GET["task"])) {


    $task = $_GET["task"];
    //echo $task;
    if ($task == "") {
        echo 'Error';
    } 
    else if ($task == "getAllcustomer") 
    {
        //echo "test";
        if(isset($_GET['lg_CUSTOMER_ID']))
        {
            $lg_CUSTOMER_ID = htmlentities($_GET['lg_CUSTOMER_ID']);
        }
        getAllcustomer($lg_CUSTOMER_ID, $db);
    } 
    else if ($task == "detelecustomer") 
    {
       // echo 'del';
        $lg_CUSTOMER_ID = $_GET["lg_CUSTOMER_ID"];
        $lg_SECURITY_ID = $_GET['lg_SECURITY_ID'];
        //echo "je suis dans delete";
        detelecustomer($lg_CUSTOMER_ID, $lg_SECURITY_ID, $db);
    }
    else if ($task == "getAllUserNotInCustomer") 
    {
       // echo 'del';
        $lg_USER_ID = $_GET["lg_USER_ID"];
        //echo "je suis dans delete";
        getAllUserNotInCustomer($lg_USER_ID, $db);
    }
    else if ($task == "getAllInstitution") 
    {
        //echo "test";
        if(isset($_GET['lg_INSTITUTION_ID']))
        {
            $lg_INSTITUTION_ID = htmlentities($_GET['lg_INSTITUTION_ID']);
        }
        getAllInstitution($lg_INSTITUTION_ID, $db);
    } 
    else if ($task == "getAllRoleInInstitutionRole") 
    {
        $lg_INSTITUTION_ID = $_GET["lg_INSTITUTION_ID"];
        getAllRoleInInstitutionRole($lg_INSTITUTION_ID, $db);
    }
} 
else if (isset($_POST['addcustomer'])) 
{        
    $str_NAME = htmlspecialchars($_POST['str_NAME']);
    $str_LASTNAME = htmlspecialchars($_POST['str_LASTNAME']);
    $str_MOBILE = htmlspecialchars($_POST['str_MOBILE']);
    $str_FIXE = htmlspecialchars($_POST['str_FIXE']);
    $str_EMAIL = htmlspecialchars($_POST['str_EMAIL']);
     
    $str_LOGIN = htmlspecialchars($_POST['str_LOGIN']);
    $str_PASSWORD = htmlspecialchars($_POST['str_PASSWORD']);
    $str_INSTITUTION = htmlspecialchars($_POST['str_INSTITUTION']);
    $str_ROLE = htmlspecialchars($_POST['str_ROLE']);
    
   // $str_USER = htmlspecialchars($_POST['str_USER']);
    addCustomer($str_LOGIN,$str_PASSWORD,$str_INSTITUTION,$str_ROLE,  $str_NAME, $str_LASTNAME,$str_MOBILE, $str_FIXE, $str_EMAIL, $db);
} 
else if (isset($_POST['editcustomer'])) 
{
    $str_NAME = htmlspecialchars($_POST['str_NAME']);
    $str_LASTNAME = htmlspecialchars($_POST['str_LASTNAME']);
    $str_MOBILE = htmlspecialchars($_POST['str_MOBILE']);
    $str_FIXE = htmlspecialchars($_POST['str_FIXE']);
    $str_EMAIL = htmlspecialchars($_POST['str_EMAIL']);
    //$str_USER = htmlspecialchars($_POST['str_USER']);
    $lg_CUSTOMER_ID = htmlentities(trim($_POST['lg_CUSTOMER_ID']));
    
    $str_LOGIN = htmlspecialchars($_POST['str_LOGIN']);
    $str_PASSWORD = htmlspecialchars($_POST['str_PASSWORD']);
    $str_INSTITUTION = htmlspecialchars($_POST['str_INSTITUTION']);
    $str_ROLE = htmlspecialchars($_POST['str_ROLE']);
    $lg_SECURITY_ID = htmlentities(trim($_POST['lg_SECURITY_ID']));
    //$bool_IS_CURRENT_INSTITUTION = htmlentities(trim($_POST['bool_IS_CURRENT_INSTITUTION']));
    editcustomer($str_LOGIN,$str_PASSWORD,$str_INSTITUTION,$str_ROLE,$lg_SECURITY_ID, $lg_CUSTOMER_ID, $str_NAME, $str_LASTNAME, $str_MOBILE, $str_FIXE, $str_EMAIL, $db);
}