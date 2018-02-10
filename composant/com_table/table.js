var url = "composant/com_customer/controlercustomer.php";
var datatable = "";
$(function () {
    getAllUserNotInCustomer("");
    getAllUser("");
    getAllCustomer("");
    getInstitution("");
    $('.str_LOGIN').on("keydown", function(e){
        var value = $(this).val();
        if(e.keyCode==32){
            e.preventDefault();
            return false;
        } 
    });
    $('.str_MOBILE').on("keydown", function(e){
        var value = $(this).val();
        if(e.keyCode==32){
            e.preventDefault();
            return false;
        } 
    });
    $("#add-key-form .str_INSTITUTION").on("change", function(){
        var lg_INSTITUTION_ID = $(this).val();
        getAllRoleInInstitutionRole(lg_INSTITUTION_ID);
    });
    
    $("#edit-key-form .str_INSTITUTION").on("change", function(){
        var lg_INSTITUTION_ID = $(this).val();
        //alert("ok")
        getAllRoleInInstitutionRoleForUpdate(lg_INSTITUTION_ID);
    });
    $('#modal_edit_key').submit(function (e) {
        e.preventDefault();
        var lg_CUSTOMER_ID = $('#modal_edit_key #lg_CUSTOMER_ID').val();
        var str_NAME = $('#modal_edit_key #str_NAME').val();
        var str_LASTNAME = $('#modal_edit_key #str_LASTNAME').val();
        var str_MOBILE = $('#modal_edit_key #str_MOBILE').val();
        var str_FIXE = $('#modal_edit_key #str_FIXE').val();
        var str_EMAIL = $('#modal_edit_key #str_EMAIL').val();
        var str_ILLUSTRATION = $('#modal_edit_key #str_ILLUSTRATION').val();
        var bool_IS_CURRENT_INSTITUTION = $('#modal_edit_key #bool_IS_CURRENT_INSTITUTION').val();
        var str_USER = $('#modal_edit_key #str_USER').val();
        
        if (lg_CUSTOMER_ID == "" || str_NAME == "" || str_LASTNAME =="" || str_MOBILE == "" || str_FIXE =="" || str_EMAIL == "" || str_USER == "")  
        {
            swal({
                title: "Echec",
                text: "Veuillez remplir tous les champs",
                type: "error",
                confirmButtonText: "Ok"
            });
            return false;
        } else {
            editcustomer();
        }
        
    });

    $('#add-key-form').submit(function (e) {
        e.preventDefault();
        var str_NAME = $('#add-key-form #str_NAME').val();
        var str_LASTNAME = $('#add-key-form #str_LASTNAME').val();
        var str_MOBILE = $('#add-key-form #str_MOBILE').val();
        var str_FIXE = $('#add-key-form #str_FIXE').val();
        var str_EMAIL = $('#add-key-form #str_EMAIL').val();
        var str_USER = $('#add-key-form #str_USER').val();
        
        var str_LOGIN = $('#add-key-form #str_LOGIN').val();
        var str_PASSWORD = $('#add-key-form #str_PASSWORD').val();
        var str_CPASSWORD = $('#add-key-form #str_CPASSWORD').val();
        var str_INSTITUTION = $('#add-key-form #str_INSTITUTION').val();
        var str_ROLE = $('#add-key-form #str_ROLE').val();
        
        if(str_PASSWORD == str_CPASSWORD)
        {
            //alert(str_PASSWORD.length)
            if(str_PASSWORD.length > 8)
            {
                if (str_LOGIN == "" || str_PASSWORD == "" || str_INSTITUTION == "" || str_ROLE == ""   || str_NAME == "" || str_LASTNAME =="" || str_MOBILE == "" || str_FIXE =="" || str_EMAIL == "" || str_USER == "")  
                {
                    swal({
                        title: "Echec",
                        text: "Veuillez remplir tous les champs",
                        type: "error",
                        confirmButtonText: "Ok"
                    });
                    return false;
                } else {
                    addcustomer();
                }
            }
            else{
                swal({
                    title: "Echec",
                    text: "Veuillez saisir au moins 9 caractères dans le champs mot de passe.",
                    type: "error",
                    confirmButtonText: "Ok"
                });
                return false;
            }
        }
        else
        {
            swal({
                    title: "Echec",
                    text: "Les deux mots de passe ne sont pas identique.",
                    type: "error",
                    confirmButtonText: "Ok"
                });
                return false;
        }

    })

    $('.btn[id="modal_add_key"]').click(function () {
        $('.modal[id="modal_add_key"]').modal('show');
        $('#modal_add_key select').select2({
            language: "fr"
        });
    });
    $('#modal_edit_key select').select2({
        language: "fr"
    });
});


function getAllRoleInInstitutionRoleForUpdate(lg_INSTITUTION_ID){
    
    $('#modal_edit_key .str_ROLE').select2(); //a delete
    $("#modal_edit_key .str_ROLE").select2('destroy');
    $('#modal_edit_key .str_ROLE').html('<option value="">Selectionner un rôle</option>');
            
    var task = "getAllRoleInInstitutionRole";
    $.get(url+"?task="+task+'&lg_INSTITUTION_ID='+lg_INSTITUTION_ID, function(json, textStatus){
        var obj = $.parseJSON(json);
        if (obj[0].code_statut == "1")
        {
            var results = obj[0].results;
            
            if (obj[0].results.length > 0)
            {
                $.each(results, function (i, value)//
                {
                    var option =$('<option value="' + results[i].lg_ROLE_ID + '">'+results[i].str_WORDING+'</option>');; 
                    $('#modal_edit_key .str_ROLE').append(option);
                });
                
            }
        }
    });
    $('#modal_edit_key .str_ROLE').select2();
}
function getAllRoleInInstitutionRole(lg_INSTITUTION_ID){
    $("#modal_add_key .str_ROLE").select2('destroy');
    $('#modal_add_key .str_ROLE').html('<option value="">Selectionner un rôle</option>');
            
    var task = "getAllRoleInInstitutionRole";
    $.get(url+"?task="+task+'&lg_INSTITUTION_ID='+lg_INSTITUTION_ID, function(json, textStatus){
        var obj = $.parseJSON(json);
        if (obj[0].code_statut == "1")
        {
            var results = obj[0].results;
            
            if (obj[0].results.length > 0)
            {
                $.each(results, function (i, value)//
                {
                    var option =$('<option value="' + results[i].lg_ROLE_ID + '">'+results[i].str_WORDING+'</option>');; 
                    $('#modal_add_key .str_ROLE').append(option);
                });
                
            }
        }
    });
    $('#modal_add_key .str_ROLE').select2();
}
function getInstitution(lg_INSTITUTION_ID){
    var task = "getAllInstitution";
    $.get(url+"?task="+task+'&lg_INSTITUTION_ID='+lg_INSTITUTION_ID, function(json, textStatus){
        var obj = $.parseJSON(json);
        if (obj[0].code_statut == "1")
        {
            var results = obj[0].results;
            
            if (obj[0].results.length > 0)
            {
                $.each(results, function (i, value)//
                {
                    //alert(results[i].str_WORDING);
                    var option = $('<option value="' + results[i].lg_INSTITUTION_ID + '">'+results[i].str_WORDING+'</option>');
                    var options =$('<option value="' + results[i].lg_INSTITUTION_ID + '">'+results[i].str_WORDING+'</option>');
                    $('#modal_edit_key .str_INSTITUTION').append(option);    
                    $('#modal_add_key .str_INSTITUTION').append(options);
                });
            }
        }
    });
}
function getAllCustomer(lg_CUSTOMER_ID)
{
    var task = "getAllcustomer";
    
    $.get(url+"?task="+task+"&lg_CUSTOMER_ID="+lg_CUSTOMER_ID, function(json, textStatus){
        
        var obj = $.parseJSON(json);
        $("#examples tbody").empty();
        
        if (obj[0].code_statut == "1")
        {
            //alert("ok");
            var results = obj[0].results;
            
            if (obj[0].results.length > 0)
            {
                $.each(results, function (i, value)//
                {
                    var tr = $('<tr class="line-data-table" id="' + results[i].lg_CUSTOMER_ID + '"></tr>');
                    var td_icone = $('<td class="column-data-table"><img src="' + (results[i].str_ILLUSTRATION?'composant/com_customer/'+results[i].str_ILLUSTRATION:'composant/com_customer/documents/default.png') + '" alt="'+results[i].str_ILLUSTRATION+'" class="img-circle" width="50" height="50"/> </td>');
                    var td_name = $('<td class="column-data-table">' + results[i].str_FIRST_NAME + '</td>');
                    var td_lastname = $('<td class="column-data-table">' + results[i].str_LAST_NAME + '</td>');
                    var td_mobile = $('<td class="column-data-table">' + results[i].str_MOBILE_NUMBER + '</td>');
                    var td_fixe = $('<td class="column-data-table">' + results[i].str_NUMBER + '</td>');
                    var td_email = $('<td class="column-data-table">' + results[i].str_EMAIL + '</td>');
                    var td_user = $('<td class="column-data-table">' + results[i].str_LOGIN + '</td>');
                    
                    var td_institution = $('<td class="column-data-table">' + results[i].str_WORDING_INSTITUTION + '</td>');
                    var td_role = $('<td class="column-data-table">' + results[i].str_WORDING_ROLE + '</td>');
                    var btn_edit = $('<span class="fa fa-edit btn-action-custom btn-action-edit" id="modal_edit_key" data-toggle="modal"  title="Modifier"> | </span> ').click(function () {
                        $('.modal[id="modal_edit_key"]').modal('show');
                        var id_key = $(this).parent().parent().attr('id');
                        /*$('#edit-key-form select').select2({
                            language: "fr"
                        });*/
                        $('#edit-key-form #lg_SECURITY_ID').val(results[i].lg_SECURITY_ID );
                        $('#edit-key-form #lg_CUSTOMER_ID').val(id_key);
                        getKeyById(id_key);
                    });
                    var btn_delete = $('&nbsp;<span class="fa fa-trash btn-action-custom btn-action-delete" title="Supprimer"> </span>').click(function () {
                        var id_key = $(this).parent().parent().attr('id');
                        
                        swal({
                            title: 'Demande de Confirmation',
                            text: "Etes-vous sûr de vouloir supprimer cette donnée ?'",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#7a4c57',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Oui',
                            cancelButtonText: 'Non',
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonClass: 'btn btn-danger',
                            buttonsStyling: false,
                            closeOnConfirm: false,
                            closeOnCancel: false
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                deleteCustomer(id_key, results[i].lg_SECURITY_ID)
                            } else {
                                swal(
                                        'Annulation',
                                        'Opération annulé',
                                        'error'
                                    );
                            }
                        })
                        getKeyById(id_key);
                    });
                    ;
                    var td_action = $('<td class="column-data-table" align="center"></td>');
                    td_action.append(btn_edit);
                    td_action.append(btn_delete);
                    tr.append(td_icone);
                    tr.append(td_name);
                    tr.append(td_lastname);
                    tr.append(td_mobile);
                    tr.append(td_fixe);
                    tr.append(td_email);
                    tr.append(td_user);
                    tr.append(td_institution);
                    tr.append(td_role);
                    tr.append(td_action);
                    $("#examples tbody").append(tr);
                });
            }
            if ($.fn.dataTable.isDataTable('#example')) {
                table = $('#example').DataTable();
            }
            else {
                table = $('#example').DataTable({
                    paging: false
                });
            }
            datatable = $('#examples').DataTable({
                "language": {
                    "lengthMenu": "Afficher _MENU_ enregistrements",
                    "zeroRecords": "Aucune ligne trouvée",
                    "info": "Affichage des enregistrements _START_ &agrave; _END_ sur _TOTAL_ enregistrements",
                    "infoEmpty": "Aucun enregistrement trouvé",
                    "infoFiltered": "(filtr&eacute; de _MAX_ enregistrements au total)",
                    "emptyTable": "Aucune donnée disponible dans le tableau",
                    "search": "Recherche",
                    "zeroRecords":    "Aucun enregistrement &agrave; afficher",
                            "paginate": {
                                "first": "Premier",
                                "last": "Dernier",
                                "next": "Suivant",
                                "previous": "Précédent"
                            }
                },
                aria: {
                    sortAscending: ": activer pour trier la colonne par ordre croissant",
                    sortDescending: ": activer pour trier la colonne par ordre décroissant"
                }, responsive: true, retrieve: true/*, /*"destroy": true,*/
                        
            });
        }

    });
}
function editcustomer() {
    var form = $('#edit-key-form').get(0);
    var formData = new FormData(form);
    $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url		: url, // the url where we want to POST
            data	: formData, // our data object
            dataType	: 'text', // what type of data do we expect back from the server
            processData: false,
            contentType: false,
            success: function (response) {
            var obj = $.parseJSON(response);
            if (obj[0].code_statut == "1")
            {
                swal({
                    title: "Opération réussie!",
                    text: obj[0].results,
                    type: "success",
                    confirmButtonText: "Ok"
                });
                $('#contenue-application .modal').modal('hide');
                if($.fn.DataTable.isDataTable('#examples')) {            
                    datatable.destroy();                            
                }
                getAllCustomer("");
            } else {
                //alert(obj[0].results);
                swal({
                    title: "Echec de l'opéraion",
                    text: obj[0].results,
                    type: "error",
                    confirmButtonText: "Ok"
                });
                $('#contenue-application .modal').modal('hide');
            }
        }
    });
}


function addcustomer() {
    var form = $('#add-key-form').get(0);
    var formData = new FormData(form);
    $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url		: url, // the url where we want to POST
            data	: formData, // our data object
            dataType	: 'text', // what type of data do we expect back from the server
            processData: false,
            contentType: false,
            success: function (response) {
            var obj = $.parseJSON(response);
            if (obj[0].code_statut == "1")
            {
                swal({
                    title: "Opération réussie!",
                    text: obj[0].results,
                    type: "success",
                    confirmButtonText: "Ok"
                });
                $('#contenue-application .modal').modal('hide');
                if($.fn.DataTable.isDataTable('#examples')) {            
                    datatable.destroy();                            
                }
                getAllCustomer("");
            } else {
                //alert(obj[0].results);
                swal({
                    title: "Echec de l'opéraion",
                    text: obj[0].results,
                    type: "error",
                    confirmButtonText: "Ok"
                });
                $('#contenue-application .modal').modal('hide');
            }
        }
    });
}


function deleteCustomer(lg_CUSTOMER_ID, lg_SECURITY_ID) {
    //alert(lg_CUSTOMER_ID);
    $.ajax({
        url: url, // La ressource ciblée
        type: 'GET', // Le type de la requête HTTP.
        data: 'task=detelecustomer&lg_CUSTOMER_ID=' + lg_CUSTOMER_ID+'&lg_SECURITY_ID='+lg_SECURITY_ID,
        dataType: 'text',
        success: function (response) {
            var obj = $.parseJSON(response);
            if (obj[0].code_statut == "1")
            {
                swal({
                    title: "Opération réussie!",
                    text: obj[0].results,
                    type: "success",
                    confirmButtonText: "Ok"
                });

                $('#contenue-application .modal').modal('hide');
                if($.fn.DataTable.isDataTable('#examples')) {            
                    datatable.destroy();                            
                }
                getAllCustomer("");
            } else {
                //alert(obj[0].results);
                swal({
                    title: "Echec de l'opéraion",
                    text: obj[0].results,
                    type: "error",
                    confirmButtonText: "Ok"
                });
                $('#contenue-application .modal').modal('hide');
            }
        }
    });
}
function getKeyById(lg_CUSTOMER_ID)
{
    //alert(lg_OFFRE_ID);
    var task = "getAllcustomer";
    $.get(url + "?task=" + task + "&lg_CUSTOMER_ID=" + lg_CUSTOMER_ID, function (json, textStatus)
    {
        var obj = $.parseJSON(json);
        if (obj[0].code_statut == "1")
        {

            var results = obj[0].results;
            if (obj[0].results.length > 0)
            {
                $.each(results, function (i, value)
                {
                    $('#modal_edit_key #str_NAME').val(results[i].str_FIRST_NAME);
                    $('#modal_edit_key #str_LASTNAME').val(results[i].str_LAST_NAME);
                    $('#modal_edit_key #str_MOBILE').val(results[i].str_MOBILE_NUMBER);
                    $('#modal_edit_key #str_FIXE').val(results[i].str_NUMBER);
                    $('#modal_edit_key #str_EMAIL').val(results[i].str_EMAIL);
                    $('#modal_edit_key #lg_CUSTOMER_ID').val(results[i].lg_CUSTOMER_ID);
                    $('#modal_edit_key #str_USER').val(results[i].lg_USER_ID);
                    if(parseInt(results[i].bool_IS_CURRENT_INSTITUTION) == 1){
                        $('#modal_edit_key #bool_IS_CURRENT_INSTITUTION').attr("checked")
                    }
                    else
                    {
                        $('#modal_edit_key #bool_IS_CURRENT_INSTITUTION').attr("checked", false)
                    }
                    $('#modal_edit_key #str_LOGIN').val(results[i].str_LOGIN);
                    $('#modal_edit_key #str_INSTITUTION').val( results[i].lg_INSTITUTION_ID );
                });
            }
        }
    });
}
function getAllUser(lg_USER_ID){
    var task = "getAllUser";
    $.get("composant/com_user/controlerUser.php?task="+task+'&lg_USER_ID='+lg_USER_ID, function(json, textStatus){
        var obj = $.parseJSON(json);
        if (obj[0].code_statut == "1")
        {
            var results = obj[0].results;
            
            if (obj[0].results.length > 0)
            {
                $.each(results, function (i, value)
                {
                    var option = $('<option value="' + results[i].lg_USER_ID + '">'+results[i].str_LOGIN+'</option>');
                    $('#edit-key-form .str_USER').append(option);   
                    //alert(results[i].lg_USER_ID +' '+results[i].str_LOGIN);
                });
            }
        }
    });
}
function getAllUserNotInCustomer(lg_USER_ID){
    var task = "getAllUserNotInCustomer";
    $.get(url+"?task="+task+'&lg_USER_ID='+lg_USER_ID, function(json, textStatus){
        var obj = $.parseJSON(json);
        if (obj[0].code_statut == "1")
        {
            var results = obj[0].results;
            
            if (obj[0].results.length > 0)
            {
                $.each(results, function (i, value)
                {
                    var option = $('<option value="' + results[i].lg_USER_ID + '">'+results[i].str_LOGIN+'</option>');
                    $('#modal_add_key .str_USER').append(option);   
                    //alert(results[i].lg_USER_ID +' '+results[i].str_LOGIN);
                });
            }
        }
    });
}
function isInteger(string) {
    var regx = /^\d+$/;
    if (!regx.test(string)) {
        return false
    } else {
        return true;
    }
}