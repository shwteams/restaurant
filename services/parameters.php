<?php 
    define("HOST", "localhost");
    define("DBNAME", "restorant_db");
    define("PWD", "");
    define("USER", "");
    define("ALGO", "SHA256");
    define("URL_WS", "http://192.168.1.3:8080/global_booster/webresources/realalthissa/sendkeyaltissiaXml");//URL du webservice d'envoi de mail de la clé d'activation
	define("URL_WS_ALERT_KEY", "http://41.66.37.238:85/global_booster/webresources/realalthissa/sendAlertkeyInfo");
    define("URL_WS_INLINE", "http://41.66.37.238:85/global_booster/webresources/realalthissa/sendkeyaltissiaXml");//URL du webservice d'envoi de mail de la clé d'activation
    define("URL_WS_SEND_MAIL_BASIC", "http://ghita-solution.com/global_booster/webresources/realalthissa/sendMailInfo");//URL du webservice d'envoi de mail
    define("SUBJECT", "CLE D'ACTIVATION");//sujet du mail de la clé d'activation
    define("MAIL_FROM", "orangeedu@ghita-solution.com");
    define("KEY_PASSWORD", "SONATEL");
    define("ALERTE_KEY_SECURITY",10);
    define("STATUT_READ","read");
    define("STATUT_UNREAD","unread");
    define("MAIL_RECEIVED_QUESTION","morokojeanr@hotmail.com");
    define("SECRET_KEY_CAPTCHA","6LeTMx0TAAAAAKz_chdOoVhE2ajxryQw2B_HYPz5");
    define("SITE_KEY_CAPTCHA","6LeTMx0TAAAAAGOwb8HcwmT5z6yK-JgJitDmhlL6");
	define("NUMBER_FOR_PACK_FULL",2);
    define("SUBJECT_CONTACT_US","Formulaire de contact - Préoccupation de");
    define("MAIL_DEVELOPPER","morokojeanr@hotmail.com");
    define("LOGO","lien");
    define("LIEN_SITE","lien");
    
     //DEBUT Paramètres pour les SMS
    define("client_id","qK7iAP5TLern5Y04bb5hmAk51FUI3uAA");
    define("client_secret","RolN1U6Gcs4LJ1KJ");
    define("authorization","Basic cUs3aUFQNVRMZX48NVk2RWJiNWhtQWs1MUZVSTN1QUE6Um9sTjFVNkdjVjBMSjFLSg==");
    define("GRANT_TYPE","client_credentials");
    define("URL_TOKEN","https://api.orange.com/oauth/v2/token");
    define("URL_SENDSMS","https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B22500000000/requests");
    define("URL_GETBALANCE_SMS","https://api.orange.com/sms/admin/v1/contracts");
    define("URL_GETHISTOACHAT_SMS","https://api.orange.com/sms/admin/v1/purchaseorders");
    define("PARTNERCONTRACTS","partnerContracts");
    define("CONTRACTS","contracts");
    define("SERVICECONTRACTS","serviceContracts");
    define("AVAILABLEUNITS","availableUnits");
    define("EXPIRES","expires");
    define("INDEX_COUNTRY_COTEDIVOIRE","CIV");
    define("MAIL_TO_INFOS_SMS_ACCOUNT", "morokojeanr@hotmail.com");
    define("SUBJECT_INFOS_SMS_ACCOUNT", "Infos compte SMS");
    //FIN Paramètres pour les SMS
    
?>