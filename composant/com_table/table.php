<?php

class Customer{
    static function showAllCustomer(){
    ?>
    <style type="text/css">
        .select2.select2-container.select2-container--default{width: 100% }
        .select2-container{z-index: 100000 !important;}
    </style>
    <script src="composant/com_customer/customer.js"></script>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="index.php">Tableau de bord</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="javascript:;">Outils</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">Clients</a>
            </li>
        </ul>
    </div>
    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <h2 class="page-title">
            Utilisateurs
            <small>Liste des utilisateurs</small>
        </h2>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list"></i>Liste des clients<br/>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" style="color:#fff;">
                        </a>
                        <span class="pull-left">
                            <button type="button" class="btn btn-success btn-block btn-sm" id="modal_add_key" data-toggle="modal">
                                <i class="fa fa-plus"></i> Ajouter
                            </button>
                        </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover clo table-responsive" id="examples" >
                            <thead>
                                <tr>
                                    <th>Photos de profils</th>
                                    <th>Noms</th>
                                    <th>Prénoms</th>
                                    <th>Mobiles</th>
                                    <th>Fixes</th>
                                    <th>Emails</th>
                                    <th>Noms d'utilisateurs</th>
                                    <th>Institutions</th>
                                    <th>Rôles</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-success fade" id="modal_add_key" role="dialog">
        <div class="modal-dialog ">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <!--a href="cmp_grid.js.jsp"><%=OTranslate20.getValue(MultilangueKeys.ml_justification.name())%></a-->
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ajouter</h4>
                </div> 
                <form class="form-horizontal" role="form" id="add-key-form">
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="str_NAME" class="col-sm-4 control-label">Nom <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="str_NAME" name="str_NAME" placeholder="Nom" type="text" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_LASTNAME" class="col-sm-4 control-label">Prénom <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="str_LASTNAME" name="str_LASTNAME" placeholder="Prénom" type="text" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_MOBILE" class="col-sm-4 control-label">Mobile <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control str_MOBILE" id="str_MOBILE" name="str_MOBILE" placeholder="48708129" type="tel" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_FIXE" class="col-sm-4 control-label">Fixe <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="str_FIXE" name="str_FIXE" placeholder="22447071" type="tel" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_EMAIL" class="col-sm-4 control-label">E-mail <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="str_EMAIL" name="str_EMAIL" placeholder="test@gmail.com" type="email" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_ILLUSTRATION" class="col-sm-4 control-label">Photo de profil :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="str_ILLUSTRATION" name="str_ILLUSTRATION" placeholder="icon" type="file" accept="image/gif, image/jpeg, image/png">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="str_LOGIN" class="col-sm-4 control-label">
                                    Nom d'utilisateur <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control str_LOGIN" id="str_LOGIN" name="str_LOGIN" placeholder="Nom d'utilisateur" min="4" type="text" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_PASSWORD" class="col-sm-4 control-label">Mot de passe <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="str_PASSWORD" name="str_PASSWORD" placeholder="Entrez le mot de passe" type="password" min="9" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_CPASSWORD" class="col-sm-4 control-label">Confirmer de passe <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="str_CPASSWORD" name="str_CPASSWORD" placeholder="Confirmer le mot de passe" type="password" min="9" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_INSTITUTION" class="col-sm-4 control-label">Institution <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <select name="str_INSTITUTION" id="str_INSTITUTION" class="form-control select2me str_INSTITUTION" required="">
                                        <option value="">Veuillez selectionner un element</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_ROLE" class="col-sm-4 control-label">Rôle <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <select name="str_ROLE" id="str_ROLE" class="form-control select2me str_ROLE" required="">
                                        <option value="">Veuillez selectionner un element</option>
                                        
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label for="bool_IS_CURRENT_INSTITUTION	" class="col-sm-4 control-label">Utilisateur e-capafrica ? :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="bool_IS_CURRENT_INSTITUTION	" name="bool_IS_CURRENT_INSTITUTION" type="checkbox" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="addcustomer" value="addcustomer"/>
                        <button type="submit" class="btn btn-warning pull-right" style="margin-left: 3px;">Enregistrer</button>
                        <button type="reset" class="btn btn-default pull-right" data-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div class="modal modal-success fade" id="modal_edit_key" role="dialog">
        <div class="modal-dialog ">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modification</h4>
                    <img src="" alt="image" id="str_IMAGE" />
                </div> 
                <form class="form-horizontal" role="form" id="edit-key-form">
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="str_NAME" class="col-sm-4 control-label">Nom <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="str_NAME" name="str_NAME" placeholder="Nom" type="text" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_LASTNAME" class="col-sm-4 control-label">Prénom <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="str_LASTNAME" name="str_LASTNAME" placeholder="Prénom" type="text" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_MOBILE" class="col-sm-4 control-label">Mobile <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control str_MOBILE" id="str_MOBILE" name="str_MOBILE" placeholder="48708129" type="tel" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_FIXE" class="col-sm-4 control-label">Fixe <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="str_FIXE" name="str_FIXE" placeholder="22447071" type="tel" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_EMAIL" class="col-sm-4 control-label">E-mail <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="str_EMAIL" name="str_EMAIL" placeholder="test@gmail.com" type="email" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_ILLUSTRATION" class="col-sm-4 control-label">Photo de profil :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="str_ILLUSTRATION" name="str_ILLUSTRATION" placeholder="icon" type="file" accept="image/gif, image/jpeg, image/png">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="str_LOGIN" class="col-sm-4 control-label">
                                    Nom d'utilisateur <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control str_LOGIN" id="str_LOGIN" name="str_LOGIN" placeholder="Nom d'utilisateur" min="4" type="text" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_PASSWORD" class="col-sm-4 control-label">Mot de passe <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="str_PASSWORD" name="str_PASSWORD" placeholder="Entrez le mot de passe" type="password" min="5" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_CPASSWORD" class="col-sm-4 control-label">Confirmer de passe <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="str_CPASSWORD" name="str_CPASSWORD" placeholder="Confirmer le mot de passe" type="password" min="9" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_INSTITUTION" class="col-sm-4 control-label">Institution <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <select name="str_INSTITUTION" id="str_INSTITUTION" class="form-control select2me str_INSTITUTION" required="">
                                        <option value="">Veuillez selectionner un element</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="str_ROLE" class="col-sm-4 control-label">Rôle <i class="require">*</i> :</label>
                                <div class="col-sm-8">
                                    <select name="str_ROLE" id="str_ROLE" class="form-control select2me str_ROLE" required="">
                                        <option value="">Veuillez selectionner un element</option>
                                        
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label for="bool_IS_CURRENT_INSTITUTION	" class="col-sm-4 control-label">Utilisateur e-capafrica ? :</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="bool_IS_CURRENT_INSTITUTION	" name="bool_IS_CURRENT_INSTITUTION" type="checkbox" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="editcustomer" value="editcustomer"/>
                        <input id="lg_CUSTOMER_ID" name="lg_CUSTOMER_ID" type="hidden">
                        <input id="lg_SECURITY_ID" name="lg_SECURITY_ID" type="hidden">
                        <button type="submit" class="btn btn-warning pull-right" style="margin-left: 3px;">Enregistrer</button>
                        <button type="reset" class="btn btn-default pull-right" data-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    }
    
}