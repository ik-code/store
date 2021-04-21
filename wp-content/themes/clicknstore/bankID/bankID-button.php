<div class="loader--wrapper hide">
  <div class="loader">Laddar...</div>
  <p>Vänta medan vi hämtar dina uppgifter</p>
</div>

<h2 class="booking__title page-title">Identifiera dig med BankID</h2>
<p class="booking__description description">Välj vilken enhet du vill verifiera dig ifrån.</p>

<form action="#" id="form_select_device">
    <div class="booking__radio-wrapper">
        <input class="booking__radio" type="radio" id="this-device" name="device" value="this-device">
        <label class="booking__radio-label" for="this-device"><span></span> Denna enhet</label>
    </div>
    <div class="booking__radio-wrapper">
        <input class="booking__radio" type="radio" id="another-device" name="device" value="another-device">
        <label class="booking__radio-label" for="another-device"><span></span>Annan enhet</label>
    </div>
    <input type="hidden" id="orderRef" value="<?php echo $tocen->orderRef; ?>" />
    <input type="hidden" id="personal_number" value="<?php echo $personal_number; ?>" />
    <input type="hidden" id="redirect_id" value="<?php echo $redirect_id; ?>" />
    <input type="hidden" id="url_redirect" value="<?php echo $url_redirect; ?>" />

    <input type="hidden" id="personal_email" value="<?php echo $personal_email; ?>" />
    <input type="hidden" id="phone_number" value="<?php echo $phone_number; ?>" />
    <input type="hidden" id="company_name" value="<?php echo $company_name; ?>" />
    <input type="hidden" id="copnamy_number" value="<?php echo $copnamy_number; ?>" />
    <input type="hidden" id="auto_start_token" value="<?php echo $tocen->autoStartToken; ?>"/>

    <input type="hidden" id="page_type" value="<?php echo isset($get_page) ? $get_page : 'registration'; ?>" />


    <div id="zignsec_text"></div>
    <button class="booking__button btn btn--black" id="mbid_start" style="display: none;">Fortsätt</button>
</form>
<script type="text/javascript" src="https://zignsec-cdn.azureedge.net/scripts/zignsecautostart.js"></script>

<script>
    jQuery(document).ready(function($) {
        var myVar;
        var personal_number = $('#personal_number').val();
        $(".booking__radio").change(function() {
            submitForm();
        });

        function submitForm(){
             var form = $('#form_select_device').serializeArray();

            if(form[0]['value'] == 'this-device'){
                $('.loader--wrapper').removeClass('hide');
                var auto_start_token = $('#auto_start_token').val();
                location.href = "bankid:///?autostarttoken=" + auto_start_token + "&redirect=null";

                $('#zignsec_text').text('Försöker starta BankID-appen.');
                pollServerAPI();
            }else if(form[0]['value'] == 'another-device'){

                getAuthorization();
            }
            return false;
        }

        function getAuthorization() {
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: 'getAuthorization',
                    personal_number: personal_number
                },
                method: 'POST',
                success: function (response) {
                    var order_ref = JSON.parse(response).orderRef;
                    getUserData(order_ref);
                    return false;
                }
            });
        }

        function getUserData(order_ref) {
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: 'getProgressStatus',
                    orderRef: order_ref
                },
                method: 'POST',
                success: function (response) {
                    var errors = JSON.parse(response).errors;
                    if ( errors.length > 0 && errors[0].code === 'USER_CANCEL') {
                        $('.loader--wrapper').addClass('hide');
                        clearTimeout(myVar);
                        $('#another-device').attr('checked', false);
                        return false;
                    }
                    var status = JSON.parse(response).progressStatus ;
                    if (status == 'OUTSTANDING_TRANSACTION' || status == 'USER_SIGN') {
                        $('.loader--wrapper').removeClass('hide');
                        setTimeout(function() { getUserData(order_ref) }, 4000);
                    } else if (status == 'COMPLETE') {
                        $('.loader--wrapper').addClass('hide');
                        clearTimeout(myVar);
                        <?php if(isset($get_page) || !empty($get_page)){ ?>
                            loginBankIdUser(JSON.parse(response));
                        <?php }else{ ?>
                            registerBankIdUser(JSON.parse(response));
                        <?php } ?>
                    }
                    return false;
                }
            });
        }

        function renew_tokens_this_device() {
            $('.loader--wrapper').addClass('hide');
            clearTimeout(myVar);
            $('#this-device').attr('checked', false);

            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: 'getAuthorization',
                    personal_number: personal_number
                },
                method: 'POST',
                success: function (response) {
                    var order_ref = JSON.parse(response).orderRef;
                    if (order_ref) {
                        $('#orderRef').val(order_ref);
                    }

                    var auto_start_token = JSON.parse(response).autoStartToken;
                    if (auto_start_token) {
                        $('#auto_start_token').val(auto_start_token);
                    }
                    return false;
                }
            });
        }

        function pollServerAPI(){
            $.ajax({
                url : '/wp-admin/admin-ajax.php',
                data : {
                    action : 'getProgressStatus',
                    orderRef : $('#orderRef').val()
                },
                method : 'POST', 
                success : function( response ){ 

                    var errors = JSON.parse(response).errors;
                    if ( errors.length > 0 && errors[0].code ) {
                        switch (errors[0].code) {
                            case 'START_FAILED':
                                renew_tokens_this_device();
                                break;
                            case 'INVALID_PARAMETERS':
                                renew_tokens_this_device();
                                break;
                            case 'ALREADY_IN_PROGRESS':
                                renew_tokens_this_device();
                                break;
                            case 'Internal Exception':
                                renew_tokens_this_device();
                                break;
                        }
                    }
                    var json_response = JSON.parse(response);
                    if(json_response.errors.length>0)
                    {       
                        console.log(json_response.errors);
                    }
                    else if(json_response.progressStatus == 'COMPLETE')
                    {
                        clearTimeout(myVar);
                        <?php if(isset($get_page) || !empty($get_page)){ ?>
                            loginBankIdUser(json_response);
                        <?php }else{ ?>
                            registerBankIdUser(json_response);
                        <?php } ?>
                    }
                    else if(json_response.progressStatus == 'USER_SIGN')
                    {
                        myVar = setTimeout(pollServerAPI, 5000);
                        $('#zignsec_text').text('Skriv in din säkerhetskod i BankID-appen och välj Legitimera eller Skriv under.');                 
                    }
                    else if(json_response.progressStatus == 'NO_CLIENT')
                    {
                        renew_tokens_this_device();
                    }
                    else if(json_response.progressStatus == 'EXPIRED_TRANSACTION')
                    {
                        clearTimeout(myVar);
                        $('#zignsec_text').text('BankID-appen svarar inte. Kontrollera att den är startad och att du har internetanslutning.  Om du inte har något giltigt BankID kan du hämta ett hos din Bank. Försök sedan igen.');
                    }   
                    else if(json_response.progressStatus == 'CLIENT_ERR')
                    {
                        clearTimeout(myVar);
                        $('#zignsec_text').text('Internt tekniskt fel. Uppdatera BankID-appen och försök igen.');               
                    }                                                                   
                    else
                    {
                        myVar = setTimeout(pollServerAPI, 2000);
                    }
                    return false;
                },
                error : function(error){
                    $('#zignsec_text').text('Söker efter BankID, det kan ta en liten stund… '); 
                    console.log(error);
                    myVar = setTimeout(pollServerAPI, 20000);
                }
            });     
        }

        function pollServerAPIAnother(){
            $.ajax({
                url : '/wp-admin/admin-ajax.php',
                data : {
                    action : 'getProgressStatusAnother',
                    redirect_id : $('#redirect_id').val()
                },
                method : 'POST', 
                success : function( response ){

                    var json_response = JSON.parse(response);

                    if(json_response.errors.length>0)
                    {
                        console.log(json_response.errors);
                    }
                    else if(json_response.result.identity.state == 'PENDING')
                    {
                        myVar = setTimeout(pollServerAPIAnother, 2000);
                    }
                    else if(json_response.result.identity.state == 'FINISHED')
                    {
                        clearTimeout(myVar);
                        <?php if(isset($get_page) || !empty($get_page)){ ?>
                            loginBankIdUser(json_response);
                        <?php }else{ ?>
                            registerBankIdUser(json_response);
                        <?php } ?>
                    }
                },
                error : function(error){
                    $('#zignsec_text').text('Söker efter BankID, det kan ta en liten stund… '); 
                    console.log(error);
                    myVar = setTimeout(pollServerAPI, 20000);
                }
            });     
        }

        function registerBankIdUser(user_info){
            $('.loader--wrapper').addClass('hide');
            $.ajax({
                url : '/wp-admin/admin-ajax.php',
                data : {
                    action : 'registerBankIdUser',
                    user_info : user_info.LookupPersonAddress,
                    personal_email: $('#personal_email').val(),
                    phone_number: $('#phone_number').val(),
                    company_name: $('#company_name').val(),
                    copnamy_number: $('#copnamy_number').val(),
                    personal_number: personal_number
                },
                method : 'POST', 
                success : function( response ){
                    if(response.error_number){
                        $("#zignsec_text").text(response.error_number);
                        location.href = "/bank-id-register";
                    }else{
                        location.href = "/checkout";
                    }
                }
            });
        }
        function loginBankIdUser(user_info){
            $.ajax({
                url : '/wp-admin/admin-ajax.php',
                data : {
                    action : 'loginBankIdUser',
                    user_info : user_info.LookupPersonAddress,
                },
                method : 'POST', 
                success : function( response ){
                    location.href = "/my-account";
                }
            });
        }
    });
</script>
