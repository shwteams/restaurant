<?php
/**
CONTIENT TOUTES LES FONCTIONS DE MON APPLICATIONS
*/
    error_reporting(E_ALL ^ E_DEPRECATED);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
//    set_time_limit(30000) ;
//    ini_set('memory_limit', '-1');
    include 'SMSManager.php';
    if (!isset($_SESSION)) {
	  session_start();
          $_SESSION['str_CUSTOMER_ID'] = "test";
	}
    function DoConnexion($host, $SECURITY, $pass, $dbname) {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        try {
            $db = new PDO($dsn, $SECURITY, $pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            return $db;
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }
    }
    function DoDeconnexion() {
        session_destroy();
        header("location:../../login.php");
    }
    function generatePassword($algo, $pwd) {
        $data = array();
        $data["ALGO"] = $algo;
        $data["DATE"] = $pwd;
        ksort($data);
        $message = http_build_query($data);
        $cle_bin = pack("a", KEY_PASSWORD);
        return strtoupper(hash_hmac(strtolower($data["ALGO"]), $message, $cle_bin));
    }
    function RandomString() {
        $characters = "0123456789abcdefghijklmnopqrstxwz";
        $randstring = '';
        for ($i = 0; $i < 5; $i++) {
            $randstring = $randstring . $characters[rand(0, strlen($characters))];
        }
        $unique = uniqid($randstring, "");
        return $unique;
    }
    function sendMailInfo($from, $Mail_to, $subject, $htmlMail) {
        
        $URL_WS_SEND_MAIL_BASIC_RELAY = URL_WS_SEND_MAIL_BASIC ;//$config->get('URL_WS_SEND_MAIL_BASIC_RELAY');
        $url_final = $URL_WS_SEND_MAIL_BASIC_RELAY . "?Mail_adresse=" . urlencode($Mail_to) . "&From=" . urlencode($from) . "&Subject=" . urlencode($subject) . "&str_Messages=" . urlencode($message) . "";
//        echo $url_final;
        $responseXml = file_get_contents($url_final);
        $responseXml = simplexml_load_string($responseXml);
        return utf8_decode($responseXml);
    }
    function getListeOfNotify( $lg_NOTIFICATION_ID, $db) {
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "%%";
        $intResult = 0;
        if ($lg_NOTIFICATION_ID == "" || $lg_NOTIFICATION_ID == null) {
            $lg_NOTIFICATION_ID = "%%";
        }
        $lg_CUSTOMER_ID = $db -> quote($_SESSION['lg_CUSTOMER_ID']);
        
        $lg_NOTIFICATION_ID = $db -> quote($lg_NOTIFICATION_ID);
        $sql = "SELECT * FROM t_notification "
                . " WHERE lg_NOTIFICATION_ID LIKE " . $lg_NOTIFICATION_ID . ""
                . " AND P_KEY_RECEIVER LIKE $lg_CUSTOMER_ID"
                . " ORDER BY dt_CREATED DESC;";
        $stmt = $db -> query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $item_result) {
            $arraySql[] = $item_result;
            $intResult++;
            $code_statut = "1";
            
        }
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["desc_statut"] = $db->errorInfo();
        $arrayJson["code_statut"] = $code_statut;
        echo "[" . json_encode($arrayJson) . "]";
    }
    function getAllNotification($lg_NOTIFICATION_ID, $lg_CUSTOMER_ID, $db) {
        
        $timeout = 0;
        if(!isset($_SESSION['lg_CUSTOMER_ID'])){
            $timeout = 1;
        }
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = STATUT_UNREAD;
        $intResult = 0;
        if ($lg_NOTIFICATION_ID == "" || $lg_NOTIFICATION_ID == null) {
            $lg_NOTIFICATION_ID = "%%";
        }
        if ($lg_CUSTOMER_ID == "" || $lg_CUSTOMER_ID == null) {
            $lg_CUSTOMER_ID = $db -> quote($_SESSION['lg_CUSTOMER_ID']);
        }
        
        $lg_NOTIFICATION_ID = $db -> quote($lg_NOTIFICATION_ID);
        try{
            $sql = "SELECT * FROM t_notification "
                . " WHERE lg_NOTIFICATION_ID LIKE " . $lg_NOTIFICATION_ID . ""
                . " AND str_STATUT = '" . $str_STATUT."'"
                . " AND P_KEY_RECEIVER LIKE $lg_CUSTOMER_ID;";
        $stmt = $db -> query($sql);
        } catch (Exception $ex) {
            die("Erreur ! : " . $e->getMessage());
        }
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $item_result) {
            $arraySql[] = $item_result;
            $intResult++;
            $code_statut = "1";
            $status = STATUT_READ;
            $sqlupdate = "UPDATE t_notification "
                        . "SET str_STATUT = '$status', "
                        . "dt_UPDATED = '" . gmdate("y-m-d, H:i:s") . "' "
                        . "WHERE lg_NOTIFICATION_ID = '".$item_result['lg_NOTIFICATION_ID']."';";
            try {
                $db->exec($sqlupdate);
            } catch (PDOException $e) {
                die("Erreur ! : " . $e->getMessage());
            }
        }
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["desc_statut"] = $db->errorInfo();
        $arrayJson["code_statut"] = $code_statut;
        $arrayJson["session_time_out"] = $timeout;
        //fin code sql liste des criteres de recherche annuaire d'un customer
        echo "[" . json_encode($arrayJson) . "]";
    }
    function addNotification($str_SUBJECT, $str_DESCRIPTION, $P_KEY_SENDER, $P_KEY_RECEIVER, $lg_CANALNOTIFICATION_ID, $db) {
        $arrayJson = array();
        $message = "";
        $code_statut = "0";
        $str_STATUT = STATUT_UNREAD;
        $insert_notif = 0;
        $dt_CREATED = $db -> quote(gmdate("y-m-d, H:i:s"));
        $sql = "INSERT INTO t_notification(lg_NOTIFICATION_ID,str_SUBJECT,str_DESCRIPTION,P_KEY_SENDER,P_KEY_RECEIVER,str_STATUT,dt_CREATED,lg_CANALNOTIFICATION_ID)"
                . "VALUES (:lg_NOTIFICATION_ID,:str_SUBJECT,:str_DESCRIPTION,:P_KEY_SENDER,:P_KEY_RECEIVER,:str_STATUT,$dt_CREATED,:lg_CANALNOTIFICATION_ID)";
        try {
            $db->beginTransaction();
            if ($lg_CANALNOTIFICATION_ID == null || $lg_CANALNOTIFICATION_ID == "") {
                $lg_CANALNOTIFICATION_ID = "%%";
            }
            if( $P_KEY_RECEIVER != null || $P_KEY_RECEIVER != "" ){
                $Notification = getAllCanalNotification($lg_CANALNOTIFICATION_ID, $db);
                foreach ($Notification as $itemNotification) {
                    $lg_NOTIFICATION_ID = RandomString();
                    $stmt = $db->prepare($sql);
                    $stmt->BindParam(':lg_NOTIFICATION_ID', $lg_NOTIFICATION_ID);
                    $stmt->BindParam(':str_SUBJECT', $str_SUBJECT);
                    $stmt->BindParam(':str_DESCRIPTION', $str_DESCRIPTION);
                    $stmt->BindParam(':P_KEY_SENDER', $P_KEY_SENDER);
                    $stmt->BindParam(':P_KEY_RECEIVER', $P_KEY_RECEIVER);
                    $stmt->BindParam(':str_STATUT', $str_STATUT);
                    $stmt->BindParam(':lg_CANALNOTIFICATION_ID', $itemNotification["lg_CANALNOTIFICATION_ID"]);
                    if ($stmt->execute()) {
                        $insert_notif++;
                    }
                }
            }
            else
            {
                $EcapUser = getEcapUser("", $db);
                foreach ($EcapUser as $itemEcapUser) {
                    $Notification = getAllCanalNotification($lg_CANALNOTIFICATION_ID, $db);
                    foreach ($Notification as $itemNotification) {
                        $lg_NOTIFICATION_ID = RandomString();
                        $stmt = $db->prepare($sql);
                        $stmt->BindParam(':lg_NOTIFICATION_ID', $lg_NOTIFICATION_ID);
                        $stmt->BindParam(':str_SUBJECT', $str_SUBJECT);
                        $stmt->BindParam(':str_DESCRIPTION', $str_DESCRIPTION);
                        $stmt->BindParam(':P_KEY_SENDER', $P_KEY_SENDER);
                        $stmt->BindParam(':P_KEY_RECEIVER', $itemEcapUser['lg_CUSTOMER_ID']);
                        $stmt->BindParam(':str_STATUT', $str_STATUT);
                        $stmt->BindParam(':lg_CANALNOTIFICATION_ID', $itemNotification["lg_CANALNOTIFICATION_ID"]);
                        if ($stmt->execute()) {
                            $insert_notif++;
                        }
                    }
                }
            }
            if (count($Notification) == $insert_notif || $insert_notif == count($EcapUser)*count($Notification)) {
                $db->commit();
                $message = "Insertion effectue avec succes";
                $code_statut = "1";
            } else {
                $db->rollBack();
                $message = "Erreur lors de l'insertion";
            }
        } catch (PDOException $e) {
            $db->rollBack();
            die("Erreur ! : " . $e->getMessage());
        }
//        $arrayJson["results"] = $message;
//        $arrayJson["code_statut"] = $code_statut;
//        //$arrayJson["desc_statut"] = $db->errorInfo();
//        echo "[" . json_encode($arrayJson) . "]";
    }
    function getAllCanalNotification($lg_CANALNOTIFICATION_ID, $db) {
        $str_STATUT = "enable";
        if ($lg_CANALNOTIFICATION_ID == "" || $lg_CANALNOTIFICATION_ID == null) {
            $lg_CANALNOTIFICATION_ID = "%%";
        }
//        $lg_REQUEST_ID = $db->quote($lg_REQUEST_ID);
        $sql = "SELECT * FROM t_canalnotification WHERE lg_CANALNOTIFICATION_ID LIKE " . $db->quote($lg_CANALNOTIFICATION_ID) . " AND str_STATUT = '" . $str_STATUT . "'";
        //echo $sql;
        $stmt = $db->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    function setUpdatePassword($db)	{
        $lg_SECURITY_ID = $_SESSION['lg_SECURITY_ID'];
        $lg_SECURITY_ID = $db -> quote($lg_SECURITY_ID);
        $arrayJson = array();
        $sql = "UPDATE t_security "
                . "SET bl_IS_UPDATE = 0 "
                . "WHERE lg_SECURITY_ID = $lg_SECURITY_ID;";
    //    echo $sql;
        try {
            $sucess = $db->exec($sql);
            if ($sucess > 0) {
                $message = "Modification effectué avec succès.";
                $code_statut = "1";
                $_SESSION['bl_IS_UPDATE'] = 0;
            } else {
                $message = "Erreur lors de la prise en compte de la réclamation.";
                $code_statut = "0";
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }
        header("location:../../index.php");
    }
    function getAllPrivilegeLevel($lg_PRIVILEGE_LEVEL_ID, $db) {
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "enable";
        $intResult = 0;
        if ($lg_PRIVILEGE_LEVEL_ID == "" || $lg_PRIVILEGE_LEVEL_ID == null) {
            $lg_PRIVILEGE_LEVEL_ID = "%%";
        }
        $lg_PRIVILEGE_LEVEL_ID = $db->quote($lg_PRIVILEGE_LEVEL_ID);
        $sql = "SELECT * FROM t_privilege_level WHERE lg_PRIVILEGE_LEVEL_ID LIKE " . $lg_PRIVILEGE_LEVEL_ID . " AND str_STATUS = '" . $str_STATUT."'";
        $stmt = $db -> query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $item_result) {
            $arraySql[] = $item_result;
            $intResult++;
            $code_statut = "1";
        }
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["desc_statut"] = $db->errorInfo();
        $arrayJson["code_statut"] = $code_statut;

        //fin code sql liste des criteres de recherche annuaire d'un customer
        echo "[" . json_encode($arrayJson) . "]";
    }
    function getAllInstitutionRole($lg_INSTITUTION_ROLE_ID, $db) {
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "enable";
        $intResult = 0;
        if ($lg_INSTITUTION_ROLE_ID == "" || $lg_INSTITUTION_ROLE_ID == null) {
            $lg_INSTITUTION_ROLE_ID = "%%";
        }
        $lg_INSTITUTION_ROLE_ID = $db->quote($lg_INSTITUTION_ROLE_ID);
        $sql = "SELECT r.lg_ROLE_ID, i.lg_INSTITUTION_ID,ir.lg_INSTITUTION_ROLE_ID, i.str_ICONE, i.str_WORDING AS str_WORDING_INSTITUTION, r.str_WORDING AS str_WORDING_ROLE "
             . "FROM t_institution i, t_institution_role ir, t_role r"
             . " WHERE i.lg_INSTITUTION_ID = ir.lg_INSTITUTION_ID AND ir.lg_ROLE_ID = r.lg_ROLE_ID "
             . " AND lg_INSTITUTION_ROLE_ID LIKE " . $lg_INSTITUTION_ROLE_ID . " AND ir.str_STATUS = '" . $str_STATUT."'";
        $stmt = $db -> query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $item_result) {
            $arraySql[] = $item_result;
            $intResult++;
            $code_statut = "1";
        }
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["desc_statut"] = $db->errorInfo();
        $arrayJson["code_statut"] = $code_statut;

        //fin code sql liste des criteres de recherche annuaire d'un customer
        echo "[" . json_encode($arrayJson) . "]";
    }
    function getAllrole($lg_ROLE_ID, $db) {
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "enable";
        $intResult = 0;
        if ($lg_ROLE_ID == "" || $lg_ROLE_ID == null) {
            $lg_ROLE_ID = "%%";
        }
        $lg_ROLE_ID = $db->quote($lg_ROLE_ID);
        $sql = "SELECT * FROM t_role WHERE lg_ROLE_ID LIKE " . $lg_ROLE_ID . " AND str_STATUS = '" . $str_STATUT."'";
        $stmt = $db -> query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $item_result) {
            $arraySql[] = $item_result;
            $intResult++;
            $code_statut = "1";
        }
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["desc_statut"] = $db->errorInfo();
        $arrayJson["code_statut"] = $code_statut;

        //fin code sql liste des criteres de recherche annuaire d'un customer
        echo "[" . json_encode($arrayJson) . "]";
    }
    function getAllPrivilegeMenu($lg_MENU_ID, $db) {
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "enable";
        $intResult = 0;
        if ($lg_MENU_ID == "" || $lg_MENU_ID == null) {
            $lg_MENU_ID = "%%";
        }
        $lg_MENU_ID = $db->quote($lg_MENU_ID);
        $sql = "SELECT * FROM t_menu WHERE lg_MENU_ID LIKE " . $lg_MENU_ID . " AND str_STATUS = '" . $str_STATUT."'";
        $stmt = $db -> query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $item_result) {
            $arraySql[] = $item_result;
            $intResult++;
            $code_statut = "1";
        }
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["desc_statut"] = $db->errorInfo();
        $arrayJson["code_statut"] = $code_statut;

        //fin code sql liste des criteres de recherche annuaire d'un customer
        echo "[" . json_encode($arrayJson) . "]";
    }
    function getAllPrivilegeMenuNotAccepterSousMenu($lg_MENU_ID, $db) {
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "enable";
        $intResult = 0;
        if ($lg_MENU_ID == "" || $lg_MENU_ID == null) {
            $lg_MENU_ID = "%%";
        }
        $lg_MENU_ID = $db->quote($lg_MENU_ID);
        $sql = "SELECT * FROM t_menu WHERE lg_MENU_ID LIKE " . $lg_MENU_ID . " AND str_URL = '' AND str_STATUS = '" . $str_STATUT."'";
        $stmt = $db -> query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $item_result) {
            $arraySql[] = $item_result;
            $intResult++;
            $code_statut = "1";
        }
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["desc_statut"] = $db->errorInfo();
        $arrayJson["code_statut"] = $code_statut;

        //fin code sql liste des criteres de recherche annuaire d'un customer
        echo "[" . json_encode($arrayJson) . "]";
    }
    function getAllPrivilegeInstitutionRole($lg_PRIVILEGE_INSTITUTION_ROLE_ID, $db) {
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "enable";
        $intResult = 0;
        if ($lg_PRIVILEGE_INSTITUTION_ROLE_ID == "" || $lg_PRIVILEGE_INSTITUTION_ROLE_ID == null) {
            $lg_PRIVILEGE_INSTITUTION_ROLE_ID = "%%";
        }
        $lg_PRIVILEGE_INSTITUTION_ROLE_ID = $db->quote($lg_PRIVILEGE_INSTITUTION_ROLE_ID);
        $sql = "SELECT pir.lg_PRIVILEGE_INSTITUTION_ROLE_ID,p.str_NAME, i.str_WORDING, r.str_WORDING AS str_WORDING_ROLE, pir.dt_CREATED, pir.str_STATUS, pir.str_CREATED_BY, pir.dt_UPDATED, pir.str_UPDATED_BY "
            . " FROM t_privilege_institution_role pir, t_privilege p, t_institution i, t_role r "
            . " WHERE pir.lg_PRIVILEGE_ID = p.lg_PRIVILEGE_ID AND pir.lg_INSTITUTION_ID = i.lg_INSTITUTION_ID AND pir.P_KEY_ROLE = r.lg_ROLE_ID AND lg_PRIVILEGE_INSTITUTION_ROLE_ID LIKE " . $lg_PRIVILEGE_INSTITUTION_ROLE_ID . " AND pir.str_STATUS = '" . $str_STATUT."'";
        $stmt = $db -> query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $item_result) {
            $arraySql[] = $item_result;
            $intResult++;
            $code_statut = "1";
        }
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["desc_statut"] = $db->errorInfo();
        $arrayJson["code_statut"] = $code_statut;

        //fin code sql liste des criteres de recherche annuaire d'un customer
        echo "[" . json_encode($arrayJson) . "]";
    }
    function getAllPrivilegeSousMenu($lg_SOUS_MENU_ID, $db) {
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "enable";
        $intResult = 0;
        if ($lg_SOUS_MENU_ID == "" || $lg_SOUS_MENU_ID == null) {
            $lg_SOUS_MENU_ID = "%%";
        }
        $lg_SOUS_MENU_ID = $db->quote($lg_SOUS_MENU_ID);
        $sql = "SELECT s.lg_SOUS_MENU_ID, s.str_VALUE, s.str_DESCRIPTION, s.int_PRIORITY, s.str_URL, s.dt_CREATED, s.str_STATUS, s.str_CREATED_BY, s.dt_UPDATED, s.str_UPDATED_BY, s.P_KEY, m.str_VALUE AS str_VALUE_MENU "
                . " FROM t_sous_menu s, t_menu m "
                . " WHERE s.lg_MENU_ID = m.lg_MENU_ID AND s.lg_SOUS_MENU_ID LIKE " . $lg_SOUS_MENU_ID . " AND s.str_STATUS = '" . $str_STATUT."'";
        $stmt = $db -> query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $item_result) {
            $arraySql[] = $item_result;
            $intResult++;
            $code_statut = "1";
        }
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["desc_statut"] = $db->errorInfo();
        $arrayJson["code_statut"] = $code_statut;

        //fin code sql liste des criteres de recherche annuaire d'un customer
        echo "[" . json_encode($arrayJson) . "]";
    }
    function addPrivilegeLevel($lg_PRIVILEGE_LEVEL_ID, $str_WORDING, $db) {
        $arrayJson = array();
        $message = "";
        $code_statut = "";
        $str_STATUT = "enable";

        $lg_PRIVILEGE_LEVEL_ID = RandomString();
        $str_CREATED_BY = $db -> quote($_SESSION['lg_SECURITY_ID']);
        $dt_CREATED = $db -> quote(gmdate("y-m-d, H:i:s"));
        $sql = "INSERT INTO t_privilege_level(lg_PRIVILEGE_LEVEL_ID,str_WORDING,dt_CREATED,str_STATUS,str_CREATED_BY)"
                . "VALUES (:lg_PRIVILEGE_LEVEL_ID,:str_WORDING,$dt_CREATED,:str_STATUS,$str_CREATED_BY)";
        try {

            if (!isExistCodePrivilegeLevel($lg_PRIVILEGE_LEVEL_ID, $db)) {
                $stmt = $db->prepare($sql);
                $stmt->BindParam(':lg_PRIVILEGE_LEVEL_ID', $lg_PRIVILEGE_LEVEL_ID);
                $stmt->BindParam(':str_WORDING', $str_WORDING);
                //$stmt->BindParam(':dt_CREATED', gmdate("y-m-d, H:i:s"));
                $stmt->BindParam(':str_STATUS', $str_STATUT);
                //$stmt->BindParam(':str_CREATED_BY', $str_CREATED_BY);
                if ($stmt->execute()) {
                    $message = "Insertion effectué avec succès";
                    $code_statut = "1";
                } else {
                    $message = "Erreur lors de l'insertion";
                    $code_statut = "0";
                }
            } else {
                $message = "Ce Code  : \" " . $lg_PRIVILEGE_LEVEL_ID . " \" de niveau de privilège existe déja! \n";
                $code_statut = "0";
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }
        $arrayJson["results"] = $message;
        $arrayJson["code_statut"] = $code_statut;
        $arrayJson["desc_statut"] = $db->errorInfo();
        echo "[" . json_encode($arrayJson) . "]";
    }
    function isExistCodePrivilegeLevel($lg_PRIVILEGE_LEVEL_ID, $db) {
        $str_STATUT = 'delete';
        $lg_PRIVILEGE_LEVEL_ID = $db->quote($lg_PRIVILEGE_LEVEL_ID);
        $sql = "SELECT * FROM t_privilege_level WHERE lg_PRIVILEGE_LEVEL_ID LIKE " . $lg_PRIVILEGE_LEVEL_ID . " AND str_STATUS <> '" . $str_STATUT . "'";
        try {
            $stmt = $db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
            return false;
        }
    }
    function deleteprivilegelevel($lg_PRIVILEGE_LEVEL_ID, $db) {
        $arrayJson = array();
        $message = "";
        $code_statut = "";
        $str_STATUT = "delete";
        $lg_PRIVILEGE_LEVEL_ID = $db->quote($lg_PRIVILEGE_LEVEL_ID);
        $sql = "UPDATE t_privilege_level "
                . "SET str_STATUS = '$str_STATUT',"
                . "dt_UPDATED = '" . gmdate("y-m-d, H:i:s") . "' "
                . "WHERE lg_PRIVILEGE_LEVEL_ID = $lg_PRIVILEGE_LEVEL_ID";
        try {
            $sucess = $db->exec($sql);

            if ($sucess > 0) {
                $message = "Suppression effectuée avec succès";
                $code_statut = "1";
            } else {
                $message = "Erreur lors de la modification";
                $code_statut = "0";
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }
        $arrayJson["results"] = $message;
        $arrayJson["total"] = $sucess;
        $arrayJson["code_statut"] = $code_statut;
    //    $arrayJson["desc_statut"] = $db->errorInfo();
        echo "[" . json_encode($arrayJson) . "]";
    }
    function editPrivilegeLevel($lg_PRIVILEGE_LEVEL_ID, $str_WORDING, $db) {
        $arrayJson = array();
        $message = "";
        $code_statut = "";

        $lg_PRIVILEGE_LEVEL_ID = $db->quote($lg_PRIVILEGE_LEVEL_ID);
        $str_WORDING = $db->quote($str_WORDING);

        $str_UPDATING_BY = $db -> quote($_SESSION['lg_SECURITY_ID']);
        $sql = "UPDATE t_privilege_level "
                . "SET str_WORDING = $str_WORDING,"
                . "str_UPDATED_BY = $str_UPDATING_BY,"
                . "dt_UPDATED = '" . gmdate("y-m-d, H:i:s") . "'"
                . "WHERE lg_PRIVILEGE_LEVEL_ID = $lg_PRIVILEGE_LEVEL_ID";
    //    echo $sql;
        try {
            $sucess = $db->exec($sql);
            if ($sucess > 0) {
                $message = "Modification effectuée avec succès";
                $code_statut = "1";
            } else {
                $message = "Erreur lors de la modification";
                $code_statut = "0";
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }

        $arrayJson["results"] = $message;
        $arrayJson["total"] = $sucess;
        $arrayJson["code_statut"] = $code_statut;
    //    $arrayJson["desc_statut"] = $db->errorInfo();
        echo "[" . json_encode($arrayJson) . "]";
    }
    function sendSms($to_THIS_NUMBER, $subject, $wo, $db){
        $sms->addSMS($number, $subject, $wo, $db);
    }
    function moveMyFile($file_name, $file_error, $file_size, $file_tmp_name, $directory, $array_extension){
        //Testons la taille des fichiers par rapport à 2Mo = 2000000 octets
            /**
###############################################################################################################
##############################RESUMER DES VARIABLE A PASSER EN PARAMETTRE######################################
###############################################################################################################
                $file_name = $_FILES['str_ILLUSTRATION']['name']
                $file_error = $_FILES['str_ILLUSTRATION']['error']
                $file_size = $_FILES['str_ILLUSTRATION']['size']
                $file_tmp_name = $_FILES['str_ILLUSTRATION']['tmp_name']
                $directory = "document/"
                $array_extension = ['exe', 'pdf', 'csv']
            */
        $return_value = false;
        if (isset($file_name) && $file_error == 0) {
            if ($file_size <= 8000000) 
            {
                $file_name = basename($file_name);
                $extention = strtolower( substr( strrchr($file_name, '.') ,1) );
                //var_dump($extention);
                if(in_array($extention, $array_extension)){
                    $nom_crypter = sha1($str_ILLUSTRATION);
                    $str_ILLUSTRATION = $directory.$nom_crypter.".".$extention;
                    $Resultmove = move_uploaded_file($file_tmp_name, $file_name);  
                    //var_dump($Resultmove);
                    $return_value = $Resultmove;
                }
            }
        }
        return $return_value;
    }
    /**
        SAMPLE SEND MAIL HTML
    */
    function sendMailClosedReclamation($lg_TICKET_ID, $db){
        $message = '<html>
        <head>
            <title>Fermeture de reclamation</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body>
            <table id="container" style="width: 100%;margin:auto;border-radius: 5px 5px 0px 0px;">
                <tr>
                    <td>
                        <table id="table-container" style="width: 100%;margin: auto;border-collapse: collapse;border: 1px solid #6b0218;font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, tahoma ;">
                            <thead>
                                <tr id="row-header" align="center">
                                    <th colspan="2" class="td-row-header" id="td-content-row-header" style="height: 40px;border-radius: 5px 5px 0px 0px; border: 1px solid #6b0218;color: #ffffff;font-weight: bold;font-size: 20px;background-color: #6b0218;font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto ;padding:10px;">str_TITLE_MAIL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="row-content-logo">
                                    <td class="td-row-content-logo" style="padding: 25px;">
                                        <!--<img src="LOGO_ECAP" alt="Logo ecap" height="50" width="50" style="max-width: 100px; max-height: 90px;"/>-->
                                    </td>
                                    <td class="td-row-content-logo" align="right" style="padding: 25px;">
                                        <!--<img src="LOGO_ECAP" alt="Logo ecap" height="50" width="50" style="max-width: 100px; max-height: 90px;"/>-->
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <img src="LOGO_ECAP" alt="Logo ecap" style="max-width: 100px; max-height: 90px;"/>
                                    </td>
                                </tr>
                                <tr id="row-content-body">
                                    <td colspan="2" class="td-row-content-body" style="padding: 10px;line-height: 35px;color: #444; font-size: 18px;">
                                        Bonjour Mr/Mme/Mlle <span style="color: #6b0218">str_NAME</span>,<br />
                                        La réclamation n°<b>int_NUMERO</b> vient d\'être cloturée.<br/>
                                        Bien à vous,<br/>Votre équipe capital conseil et développement.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

            </table>

        </body>
    </html>';
    //    $message2 = $message;
        $messagetemp = $message;
        //echo $lg_TICKET_ID;
        $tab_SECURITY = getArrayCustomerHasCreateTicket($lg_TICKET_ID, $db);
       // var_dump($tab_SECURITY);
        $message = str_replace('LOGO_ECAP', LOGO_ECAP, $message);
        $message = str_replace('str_TITLE_MAIL', "Ouverture de réclamation", $message);
        $message = str_replace('str_NAME', $tab_SECURITY['str_LAST_NAME'].' '.$tab_SECURITY['str_FIRST_NAME'], $message, $count);
        $message = str_replace('int_NUMERO', $tab_SECURITY['int_NUMERO'], $message);
        $int_NUMERO = $tab_SECURITY['int_NUMERO'];
        $subject = "VOTRE RECLAMATION.";
        $from = MAIL_FROM;
        sendMailInfo($from, $tab_SECURITY['str_EMAIL'], $subject, $message);
        $lg_CUSTOMER_ID = $db -> quote($tab_SECURITY['lg_CUSTOMER_ID']);
        //recupéraion des contact du client
        $req = "SELECT c.str_NAME, c.str_EMAIL FROM t_contact c "
                . "WHERE c.str_STATUS = 'enable' AND c.lg_CUSTOMER_ID LIKE $lg_CUSTOMER_ID;";
        $query = $db -> query($req);
        while($data_query = $query -> fetch()){
    //        $message2 = $messagetemp;
    //        $message2 = str_replace('LOGO_ECAP', LOGO_ECAP, $message2);
    //        $message2 = str_replace('str_TITLE_MAIL', "Ouverture de réclamation", $message2);
    //        $message2 = str_replace('str_NAME', $data_query['str_NAME'], $message2, $count);
    //        //echo $data_query['str_NAME'];
    //        $message2 = str_replace('int_NUMERO', $int_NUMERO, $message2);
            sendMailInfo($from, $data_query['str_EMAIL'], $subject, $message);
        }

    }
    
    function getAllTable( $lg_TABLE_ID, $db) {
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "%%";
        $intResult = 0;
        if ($lg_TABLE_ID == "" || $lg_TABLE_ID == null) {
            $lg_TABLE_ID = "%%";
        }
        $lg_TABLE_ID = $db -> quote($lg_TABLE_ID);
        
        $sql = "SELECT * FROM t_table "
                . " WHERE lg_TABLE_ID LIKE " . $lg_TABLE_ID . " "
                . " ORDER BY dt_CREATED DESC;";
        $stmt = $db -> query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $item_result) {
            $arraySql[] = $item_result;
            $intResult++;
            $code_statut = "1";
        }
        $arrayJson["results"] = $arraySql;
        $arrayJson["total"] = $intResult;
        $arrayJson["desc_statut"] = $db->errorInfo();
        $arrayJson["code_statut"] = $code_statut;
        echo "[" . json_encode($arrayJson) . "]";
    }
    function deleteTable($lg_TABLE_ID, $db) {
        $arrayJson = array();
        $message = "";
        $code_statut = "";
        $str_STATUT = "delete";
        $lg_TABLE_ID = $db->quote($lg_TABLE_ID);
        $sql = "UPDATE t_table "
                . "SET str_STATUS = '$str_STATUT',"
                . "str_UPDATED_BY = '', "
                . "dt_UPDATED = '" . gmdate("y-m-d, H:i:s") . "' "
                . "WHERE lg_TABLE_ID = $lg_TABLE_ID";
        try {
            $sucess = $db->exec($sql);
            if ($sucess > 0) {
                $message = "Suppression effectuée avec succès";
                $code_statut = "1";
            } else {
                $message = "Erreur lors de la modification";
                $code_statut = "0";
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }
        $arrayJson["results"] = $message;
        $arrayJson["total"] = $sucess;
        $arrayJson["code_statut"] = $code_statut;
        echo "[" . json_encode($arrayJson) . "]";
    }
    function editTable($lg_TABLE_ID, $str_WORDING, $int_NUMBER, $db) {
        $arrayJson = array();
        $message = "";
        $code_statut = "";

        $lg_TABLE_ID = $db->quote($lg_TABLE_ID);
        $str_WORDING = $db->quote($str_WORDING);
        $int_NUMBER = $db -> quote($int_NUMBER);
        //$str_UPDATING_BY = $db -> quote($_SESSION['lg_SECURITY_ID']);
        $sql = "UPDATE t_table "
                . "SET str_WORDING = $str_WORDING,"
                . "int_NUMBER_PLACE = $int_NUMBER, "
                . "str_UPDATED_BY = $str_UPDATING_BY,"
                . "dt_UPDATED = '" . gmdate("y-m-d, H:i:s") . "'"
                . "WHERE lg_TABLE_ID = $lg_TABLE_ID";
    //    echo $sql;
        try {
            $sucess = $db->exec($sql);
            if ($sucess > 0) {
                $message = "Modification effectuée avec succès";
                $code_statut = "1";
            } else {
                $message = "Erreur lors de la modification";
                $code_statut = "0";
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }

        $arrayJson["results"] = $message;
        $arrayJson["total"] = $sucess;
        $arrayJson["code_statut"] = $code_statut;
    //    $arrayJson["desc_statut"] = $db->errorInfo();
        echo "[" . json_encode($arrayJson) . "]";
    }
    function isExistCodeTable($lg_TABLE_ID, $db) {
        $str_STATUT = 'delete';
        $lg_TABLE_ID = $db->quote($lg_TABLE_ID);
        $sql = "SELECT * FROM t_table WHERE lg_TABLE_ID LIKE " . $lg_TABLE_ID . " AND str_STATUS <> '" . $str_STATUT . "'";
        try {
            $stmt = $db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
            return false;
        }
    }
    function addTable($lg_TABLE_ID, $str_WORDING, $int_NUMBER_PLACE, $db) {
        $arrayJson = array();
        $message = "";
        $code_statut = "";
        $str_STATUT = "enable";
        $lg_TABLE_ID = RandomString();
        $str_WORDING = $db -> quote($str_WORDING);
//        $str_CREATED_BY = $db -> quote($_SESSION['lg_SECURITY_ID']);
        $dt_CREATED = $db -> quote(gmdate("y-m-d, H:i:s"));
       echo $sql = "INSERT INTO t_table(lg_TABLE_ID, str_WORDING, int_NUMBER_PLACE,str_STATUS, dt_CREATED, str_CREATED_BY, dt_UPDATED, str_UPDATED_BY)"
                . "VALUES (:lg_TABLE_ID,:str_WORDING,:int_NUMBER_PLACE,:str_STATUS,$dt_CREATED,:str_CREATED_BY, $dt_CREATED, :str_UPDATED_BY)";
        try {
        
            if (!isExistCodeTable($lg_TABLE_ID, $db)) {
                $stmt = $db->prepare($sql);
                $stmt->BindParam(':lg_TABLE_ID', $lg_TABLE_ID);
                $stmt->BindParam(':str_WORDING', $str_WORDING);
                $stmt->BindParam(':int_NUMBER_PLACE', $int_NUMBER_PLACE);
                $stmt->BindParam(':str_STATUS', $str_STATUT);
                $stmt->BindParam(':str_CREATED_BY', $_SESSION['str_CUSTOMER_ID']);
                $stmt->BindParam(':str_UPDATED_BY', $_SESSION['str_CUSTOMER_ID']);
                if ($stmt->execute()) {
                    $message = "Insertion effectué avec succès";
                    $code_statut = "1";
                } else {
                    $message = "Erreur lors de l'insertion";
                    $code_statut = "0";
                }
            } else {
                $message = "Ce Code  : \" " . $lg_TABLE_ID . " \" de table existe déja! \n";
                $code_statut = "0";
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }
        $arrayJson["results"] = $message;
        $arrayJson["code_statut"] = $code_statut;
        $arrayJson["desc_statut"] = $db->errorInfo();
        echo "[" . json_encode($arrayJson) . "]";
    }
    
?>