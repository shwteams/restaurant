<?php
if(!isset($_SESSION))
    session_start();
if(!isset($_SESSION['lg_SECURITY_ID']))
{
?>
<!DOCTYPE html>
<html>
	<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
        <title>E-capafrica - Login</title>
		
	<!-- Maniac stylesheets -->
        <link rel="stylesheet" href="services/css/login/bootstrap.min.css" />
        <link rel="stylesheet" href="services/css/login/font-awesome.min.css" />
        <link rel="stylesheet" href="services/css/login/animate/animate.min.css" />
        <link rel="stylesheet" href="services/css/login/bootstrapValidator/bootstrapValidator.min.css" />
        <link rel="stylesheet" href="services/css/login/iCheck/all.css" />
        <link rel="stylesheet" href="services/css/login/style.css" />
        <link rel="shortcut icon" href="./services/logo/ecap-Copie.png"/>
        <script src="services/js/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="services/css/sweetalert.css">
        <link rel="stylesheet" type="text/css" href="services/css/login.css">
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.services/js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">
            body{
                background-color: #fff;
            }
            #conteneu .header_page{
                height: 65px;
                align-content: center;
                padding: 10px;
                background-color: #9e1330;
                
            }
            #lien_site{
                text-align: center;
                color: #f3f3f4;
                padding: 4px;
            }
            .link{
                color: #fff;
                font-size: 1.5em;
            }
            
            #bloc-forms{
                background: #ededed;
                    background-image: none;
                    background-repeat: repeat;
                    background-attachment: scroll;
                    background-clip: border-box;
                    background-origin: padding-box;
                    background-position-x: 0%;
                    background-position-y: 0%;
                    background-size: auto auto;
                margin-top: 35px;
                margin-bottom: 20px;
                
                -webkit-border-radius: 3px;
                -moz-border-radius: 3px;
                border-radius: 3px;
                width: 100%;
                box-shadow: 0px 0 3px 0px rgba(0, 0, 0, 0.1);
                
               
               /* top: 10em;*/
                
                min-height: 350px;
                width: 62%;
                /* height: 100%; */
                height: 485px;
                min-height: 300px;
                max-height: 500px;
                align-content: center;
            }
            .hr{
                border: 1px solid #9e1332;
                width: 72%;
                text-align:center; 
                margin: 0 auto;
            }
            .margin-30{
                margin: 30px;
            }
            .margin-40{
                margin: 40px;
                padding-top: 80px;
            }
            .img_gestion
            {
                max-width: 350px;
                max-height: 20px;
            }
            
            .img_gestion_reclamation
            {
                max-width: 500px;
                max-height: 50px;
                text-align:center; 
                margin: 0 auto;
            }
            .logo_ecap:hover{
                cursor: pointer;
            }
        </style>
	</head>
        <body class="container-fluid">
            <!-- wrapper animated flipInY -->
            <div id="conteneu">
                <div class="row header_page">
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                        <a href="#"><img src="./services/logo/logo_connexion.png" alt="Logo ecap" class="logo_ecap img-responsive"></a>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 col-lg-offset-1" id="lien_site">
                        <a href="http://www.e-capafrica.com/" target="_blank" title="Acceder au site de E-capafrica" class="link">Acceder au site</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-5 col-xs-12 col-lg-offset-3 col-md-offset-3 col-sm-offset-3 top-18">
                        <img src="./services/logo/gestion.png" alt="img gestion" class="img_gestion_reclamation img-responsive">
                    </div>
                </div>
                <div class="row" id="id_im_connexion">
                    <div class="col-lg-6 col-md-6 col-sm-5 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-md-offset-2 top-20">
                        <img src="./services/logo/imgfond.jpg" alt="img gestion" class="img_arriere_plan img-responsive">
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 top-18">
                        <div  id="bloc-forms">
                            <form id="frm-add">
                                <div id="" class="margin-40">
                                    <img src="./services/logo/connectez-vous.png" alt="image de connexion" class="img-responsive margin-5"/>
                                </div>
                                <div class="">
                                    <div class="form-group margin-30">
                                        <input type="text" placeholder="Identifiant" class="form-control rounded" id="str_LOGIN" name="str_LOGIN">
                                    </div>
                                    <div class="form-group margin-30">
                                        <input type="password" placeholder="Mot de passe" class="form-control rounded" id="str_PASSWORD" name="str_PASSWORD">
                                    </div>
                                    <div class="form-group margin-30" >
                                        <button type="submit" class="btn btn-success btn-block btn-lg">Connexion</button>  
                                    </div>
                                </div>                                                       
                                    
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 top-18 align-center">
                       <hr class="hr" />
                   </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  top-18" style="text-align:center;">
                        <img src="./services/logo/footer.png" alt="img footer" class="img_gestion" >
                    </div>
                </div>
            </div>
        <!-- Javascript -->
        <script src="services/js/plugins/jquery/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="services/js/plugins/jquery-ui/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
		
		<!-- Bootstrap -->
        <script src="services/js/plugins/bootstrap/bootstrap.min.js" type="text/javascript"></script>
		
		<!-- Interface -->
        <script src="services/js/plugins/pace/pace.min.js" type="text/javascript"></script>
		
		<!-- Forms -->
        <script src="services/js/plugins/bootstrapValidator/bootstrapValidator.min.js" type="text/javascript"></script>
        
        <script src="services/js/jquery.form.js" type="text/javascript"></script>
		
		<script>
            $('#frm-add').on('submit', function(e){
                e.preventDefault();
                var $frm = $(this);
                var str_LOGIN = $("#frm-add #str_LOGIN").val();
                var str_PASSWORD = $("#frm-add #str_PASSWORD").val();
                var task = "connUser";
                var url = "composant/com_security/controlersecurity.php?task="+task+"&str_LOGIN="+str_LOGIN+"&str_PASSWORD="+str_PASSWORD;
                $.ajax(url)
                     .done(function(data, status, jqxhr){
                         var obj = $.parseJSON(jqxhr.responseText);
                        // console.log(JSON.stringify(obj[0]));
                         if (obj[0].code_statut == "1")
                         {
                            window.location.href = "index.php";
                         } else {
                             //alert(obj[0].results);
                             swal({
                                 title: "Echec de l'opéraion",
                                 text: obj[0].results,
                                 type: "error",
                                 confirmButtonText: "Ok"
                             });
                         }
                     });
               
            });
        </script>
    </body>
</html>
<?php
}
else
    header("location:index.php");
?>
