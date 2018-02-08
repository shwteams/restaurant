<?php

//session_start();
include_once 'parameters.php';

//processDescativeToken();
//sendSMSToSuscriber();

Class SMSManager {

    private $db;

    const PROCESS_SUCCESS = "1";
    const PROCESS_FAILED = "0";
    const MESSAGE_INSERT_SUCCESS = "Insertion effectuée avec succès";
    const MESSAGE_INSERT_FAILED = "Erreur lors de l'insertion";
    const MESSAGE_UPDATE_SUCCESS = "Modification effectuée avec succès";
    const MESSAGE_UPDATE_FAILED = "Erreur lors de la modification";
    const MESSAGE_DELETE_SUCCESS = "Suppression effectuée avec succès";
    const MESSAGE_DELETE_FAILED = "Erreur lors de la suppression";

    public function __construct($db) {
        $this->setDb($db);
        $this->processDescativeToken();
        $this->sendInfoSMSAccount(INDEX_COUNTRY_COTEDIVOIRE);
    }

    static function DoConnexion($host, $user, $pass, $dbname) {
        $dsn = "mysql:host=$host;dbname=$dbname";
        try {
            $db = new PDO($dsn, $user, $pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            return $db;
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }
    }

    public function getDbToken($url) {
        $str_STATUT = "enable";
        $sql = "SELECT * FROM t_smstoken WHERE str_STATUT = :str_STATUT ORDER BY dt_CREATED DESC";
        $stmt = $this->getDb()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $data = array(
            ':str_STATUT' => $str_STATUT
        );
        $stmt->execute($data);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result[0]['str_ACCESSTOKEN'];
        } else {
            return $this->getAccessToken(client_id,client_secret, $url,GRANT_TYPE, $this->getDb());
        }
    }

    public function RandomString() {
        $characters = "0123456789abcdefghijklmnopqrstxwz";
        $randstring = '';
        for ($i = 0; $i < 5; $i++) {
            $randstring = $randstring . $characters[rand(0, strlen($characters))];
        }
        $unique = uniqid($randstring, "");
        return $unique;
    }

    public function RandomNumber() {
        $characters = "0123456789034163131";
        $randstring = '';
        for ($i = 0; $i < 5; $i++) {
            $randstring = $randstring . $characters[rand(0, strlen($characters))];
        }
        $unique = uniqid($randstring, "");
        return "0123" . $unique;
    }

    public function getAllSMS($lg_SMS_ID, $search_value, $db) {
        $arrayJson = array();
        $arraySql = array();
        $code_statut = "0";
        $str_STATUT = "enable";
        $intResult = 0;
        if ($lg_SMS_ID == "" || $lg_SMS_ID == null) {
            $lg_SMS_ID = "%%";
        }
        if ($search_value == "" || $search_value == null) {
            $search_value = "%%";
        } else {
            $search_value = "%" . $search_value . "%";
        }
        $lg_SMS_ID = $db->quote($lg_SMS_ID);
        $search_value = $db->quote($search_value);
        $sql = "SELECT * FROM j3_sms WHERE lg_SMS_ID LIKE " . $lg_SMS_ID . " AND str_DESTINATAIRE LIKE $search_value AND str_STATUT = '" . $str_STATUT . "' ORDER BY dt_CREATED DESC";
        $stmt = $db->query($sql);
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


    public function addSMS($str_DESTINATAIRE, $str_DESCRIPTION, $lg_CUSTOMER_ID,  $db) {
        $arrayJson = array();
        $message = "";
        $code_statut = "";
        $str_STATUT = "enable";

        $sql = "INSERT INTO t_sms(lg_SMS_ID,str_DESTINATAIRE,str_DESCRIPTION,str_STATUT,dt_CREATED, str_CUSTOMER_ID)"
                . "VALUES (:lg_SMS_ID,:str_DESTINATAIRE,:str_DESCRIPTION,:str_STATUT,:dt_CREATED, :str_CUSTOMER_ID)";
        try {
            $lg_SMS_ID = RandomString();
            $stmt = $db->prepare($sql);
            $stmt->BindParam(':lg_SMS_ID', $lg_SMS_ID);
            $stmt->BindParam(':str_DESTINATAIRE', $str_DESTINATAIRE);
            $stmt->BindParam(':str_DESCRIPTION', $str_DESCRIPTION);
            $stmt->BindParam(':str_STATUT', $str_STATUT);
            $date = date("y-m-d, H:i:s");
            $stmt->BindParam(':dt_CREATED', $date);
            $stmt->BindParam(':str_CUSTOMER_ID', $lg_CUSTOMER_ID);
            $int = $this->isBalanceAvailableOrOutOfDate(URL_GETBALANCE_SMS, INDEX_COUNTRY_COTEDIVOIRE);
            switch ($int) {
                case 1:
                    $message = "La période active de votre compte SMS a expiré. Veuillez-vous recharger SVP.";
                    break;
                case 2:
                    $message = "Veuillez recharger votre compte SMS SVP.";
                    break;
                case 3:
                    if ($stmt->execute()) {
                        $success = $this->sendSMS($str_DESTINATAIRE, $str_DESCRIPTION);
                        //var_dump($success);
                        if ($success) {
                            $message = "Message envoyé avec succès";
                            $code_statut = "1";
                        } else {
                            $message = "Echec lors de l'envoi du message";
                        }
                    }
                    break;
                default:
                    break;
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }
        //Message apres envoie de sms 
//        $arrayJson["results"] = $message;
//        $arrayJson["code_statut"] = $code_statut;
//        $arrayJson["desc_statut"] = $db->errorInfo();
//        echo "[" . json_encode($arrayJson) . "]";
    }

    public function addSmstoken($str_ACCESSTOKEN, $str_EXPRIRESIN, $int_DAYSNUMBER, $db) {
        $str_STATUT = "enable";

        $sql = "INSERT INTO t_smstoken(str_ACCESSTOKEN,int_EXPRIRESIN,int_DAYSNUMBER,dt_EXPIRATION,str_STATUT,dt_CREATED)"
                . "VALUES (:str_ACCESSTOKEN,:int_EXPRIRESIN,:int_DAYSNUMBER,:dt_EXPIRATION,:str_STATUT,:dt_CREATED)";
        try {
            $stmt = $db->prepare($sql);
            $stmt->BindParam(':str_ACCESSTOKEN', $str_ACCESSTOKEN);
            $stmt->BindParam(':int_EXPRIRESIN', $str_EXPRIRESIN);
            $stmt->BindParam(':int_DAYSNUMBER', $int_DAYSNUMBER);
            $stmt->BindParam(':str_STATUT', $str_STATUT);

            $my_date_time = time("Y-m-d H:i:s");
            $date = date("y-m-d, H:i:s", $my_date_time);
            $my_new_date_time = $my_date_time + intval($str_EXPRIRESIN);
            $dt_expiration = date("Y-m-d H:i:s", $my_new_date_time);
            $stmt->BindParam(':dt_EXPIRATION', $dt_expiration);
            $stmt->BindParam(':dt_CREATED', $date);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
            //return false;
        }
    }

    public function getAccessToken($cient_id, $client_secret, $url, $GRANT_TYPE, $db) {
//        var_dump($cient_id);
//        var_dump($client_secret);
//        var_dump($url);
//        var_dump($GRANT_TYPE);
//        return;
        $headers = array(
            "Authorization: Basic " . base64_encode($cient_id . ":" . $client_secret)
        );

        $postfields = array(
            'grant_type' => $GRANT_TYPE
        );

        $fields = (is_array($postfields)) ? http_build_query($postfields) : $postfields;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //pour retourner le transfert sous une chaine au lieu de l'afficher
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            print "Error: " . curl_error($ch);
        } else {
            $json_decode = json_decode($result, true);
//            var_dump($json_decode);
//            print_r($json_decode);
            if(in_array('access_token', $json_decode)){
                $str_ACCESSTOKEN = $json_decode['access_token'];
                $str_EXPRIRESIN = $json_decode['EXPIRES_in'];
                $int_DAYSNUMBER = $str_EXPRIRESIN / 86400;
                if ($this->addSmstoken($str_ACCESSTOKEN, $str_EXPRIRESIN, $int_DAYSNUMBER, $db)) {
                    return $str_ACCESSTOKEN;
                }
            }
        }
        curl_close($ch);
    }

    public function getDataFromJson($array, $index) {
        if (array_key_exists($index, $array)) {
            $json = $array[$index];
            $json = json_encode($json);
            return json_decode($json, true);
        } else {
            return FALSE;
        }
    }

    public function isBalanceAvailable($url, $index_country) {
        $array = $this->getBalance($url, $index_country);
        return $array['unit'] > 0;
    }

    public function getBalance($url, $index_country) {

        $headers = array(
            "Authorization: Bearer " . $this->getDbToken(URL_TOKEN, GRANT_TYPE),
            "Content-Type: application/json"
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //pour retourner le transfert sous une chaine au lieu de l'afficher
        $result = curl_exec($ch);
        //print_r($result);
        if (curl_errno($ch)) {
            print "Error: " . curl_error($ch);
            return false;
        } else {
//            $array_index = array('PARTNERCONTRACTS', 'CONTRACTS', '0', 'SERVICECONTRACTS');
            $array_index = array(PARTNERCONTRACTS, CONTRACTS, '0', SERVICECONTRACTS);
            $array_from_json = json_decode($result, true);
            for ($i = 0; $i < count($array_index); $i++) {
                $array_from_json = $this->getDataFromJson($array_from_json, $array_index[$i]);
                if (!$array_from_json)
                    break;
            }
            if ($array_from_json == FALSE) {
                return false;
            } else {
                foreach ($array_from_json as $value) {
                    if ($value['country'] == $index_country) {
                        $timestp = strtotime($value[EXPIRES]);
                        $date_expiration = date('d/m/Y H:i:s', $timestp);
                        $array_balance = array(
                            'unit' => $value[AVAILABLEUNITS],
                            'date_expiration' => $date_expiration
                        );
                        return $array_balance;
                    }
                }
                curl_close($ch);
            }
        }
    }

    public function isBalanceAvailableOrOutOfDate($url, $index_country) {
        $array = $this->getBalance($url, $index_country);
        $datearray = str_replace("/", "-", $array['date_expiration']);
        $date = date('d-m-Y H:i:s');
        if (!$this->datecompare($date, $datearray)) {//compte toujours valide
            if ($array['unit'] <= 0) {//Nombre de sms a zero
                return 2;
            } else
                return 3;
        }else {//date de validité dépassé
            return 1;
        }
    }

    public function getHistoAchat($url, $index_country) {

        $headers = array(
            "Authorization: Bearer " . $this->getDbToken(URL_TOKEN, GRANT_TYPE),
            "Content-Type: application/json"
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //pour retourner le transfert sous une chaine au lieu de l'afficher
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            print "Error: " . curl_error($ch);
            return false;
        } else {
            return json_decode($result, true);
        }
    }

    public function sendSMS($tel_number, $message) {

        $headers = array(
            "Authorization: Bearer " . $this->getDbToken(URL_TOKEN, GRANT_TYPE),
            "Content-Type: application/json"
        );
        //echo GRANT_TYPE;        return;
        $array_message = array('message' => $message);
        $outboundSMSMessageRequestdata = array(
            'address' => "tel:+" . $tel_number,
            'senderAddress' => "tel:+22500000000",
            'outboundSMSTextMessage' => $array_message
        );
        $outboundSMSMessageRequest = array(
            'outboundSMSMessageRequest' => $outboundSMSMessageRequestdata
        );

        $json = json_encode($outboundSMSMessageRequest);
        echo "$json";
        //return;

        $postfields = $json;
//
        $fields = (is_array($postfields)) ? http_build_query($postfields) : $postfields;
        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_URL, URL_SENDSMS);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //pour retourner le transfert sous une chaine au lieu de l'afficher
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            print "Error: " . curl_error($ch);
            return false;
        } else {
//            print_r($result);
            $json_decode = json_decode($result, true);

//        curl_close($ch);
            //var_dump($json_decode);
//            print_r($json_decode);
            if (array_key_exists('outboundSMSMessageRequest', $json_decode)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function processDescativeToken() {
        $str_STATUT = "enable";
        $str_STATUT_DISABLE = "disable";
        $sql = "SELECT *
            FROM
              t_smstoken t
            WHERE
              t.str_STATUT = '$str_STATUT' AND 
              t.dt_EXPIRATION < NOW()";
        try {
            $stmt = $this->getDb()->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $item_result) {
                $sql_updated = "UPDATE t_smstoken t "
                        . "SET str_STATUT = '$str_STATUT_DISABLE',"
                        . " dt_UPDATED = '" . date("y-m-d, H:i:s") . "' "
                        . " WHERE t.lg_SMSTOKEN_ID = '" . $item_result["lg_SMSTOKEN_ID"] . "'";
                $sucess = $this->getDb()->exec($sql_updated);
            }
        } catch (PDOException $e) {
            die("Erreur ! : " . $e->getMessage());
        }
    }


    public function sendInfoSMSAccount($index_country) {
        $int = $this->isBalanceAvailableOrOutOfDate(URL_GETBALANCE_SMS, $index_country);
        switch ($int) {
            case 1:
                $message = "La période active de votre compte SMS $index_country a expiré. Veuillez-vous recharger SVP.";
                $this->sendMailInfo(URL_WS_SEND_MAIL_BASIC, MAIL_FROM, MAIL_TO_INFOS_SMS_ACCOUNT, SUBJECT_INFOS_SMS_ACCOUNT, $message);
                break;
            case 2:
                $message = "Veuillez recharger votre compte SMS $index_country SVP.";
                $this->sendMailInfo(URL_WS_SEND_MAIL_BASIC,MAIL_FROM, MAIL_TO_INFOS_SMS_ACCOUNT, SUBJECT_INFOS_SMS_ACCOUNT, $message);
                break;
            default:
                break;
        }
    }

    public function sendMailInfo($urlbase, $from, $Mail_to, $subject, $message) {
        $url_final = "$urlbase?Mail_adresse=" . urlencode($Mail_to) . "&From=" . urlencode($from) . "&Subject=" . urlencode($subject) . "&str_Messages=" . urlencode($message) . "";
        $responseXml = file_get_contents($url_final);
        $responseXml = simplexml_load_string($responseXml);
        return utf8_decode($responseXml);
    }

    public function datecompare($StringDate_1, $StringDate_2) {
//        try {
            $datetime1 = new DateTime($StringDate_1);
            $datetime2 = new DateTime($StringDate_2);
            return $datetime1 > $datetime2;
//        } catch (Exception $e) {
//            echo $e->getMessage();
//        }
    }

    public function getDb() {
        return $this->db;
    }

    public function setDb($db) {
        $this->db = $db;
    }


}
?>