function send_message() {
    var name = jQuery("#name").val();
    var email = jQuery("#email").val();
    var mobile = jQuery("#mobile").val();
    var comment = jQuery("#comment").val();

    if (name == "") {
        alert('Please enter name');
    } else if (email == "") {
        alert('Please enter email');
    } else if (mobile == "") {
        alert('Please enter mobile');
    } else if (comment == "") {
        alert('Please enter comment');
    } else {
        jQuery.ajax({
            url: 'send_message.php',
            type: 'post',
            data: 'name=' + name + '&email=' + email + '&mobile=' + mobile + '&comment=' + comment,
            success: function (result) {
                alert(result);
            }
        });
    }
}

function user_register() {
    jQuery('.field_error').html('');
    var name = jQuery("#name").val();
    var email = jQuery("#email").val();
    var mobile = jQuery("#mobile").val();
    var password = jQuery("#password").val();

    var is_error = '';
    if (name == '') {
        jQuery('#name_error').html('please enter name');
        is_error = 'yes';
    }
    if (email == '') {
        jQuery('#email_error').html('please enter email');
        is_error = 'yes';
    }
    if (mobile == '') {
        jQuery('#mobile_error').html('please enter mobile');
        is_error = 'yes';
    }
    if (password == '') {
        jQuery('#password_error').html('please enter password');
        is_error = 'yes';
    } if (is_error == '') {
        jQuery.ajax({
            url: 'register_submit.php',
            type: 'post',
            data: 'name=' + name + '&email=' + email + '&mobile=' + mobile + '&password=' + password,
            success: function (result) {
                if (result == 'email_present') {
                    jQuery('#email_error').html('Email is already present');
                }
                if (result == 'insert') {
                    jQuery('.register-msg p').html('Thank you for registering');
                }
                window.location.href = 'index.php';
            }
        });
        alert ("welcome to BA Traders.Your account has been created please Login");
    }
}

function user_login() {
    jQuery('.field_error').html('');
    var name = jQuery("#login_name").val();
    var password = jQuery("#login_password").val();

    var is_error = '';
    if (name == '') {
        jQuery('#login_name_error').html('please enter name');
        is_error = 'yes';
    }
    if (password == '') {
        jQuery('#login_password_error').html('please enter password');
        is_error = 'yes';
    } if (is_error == '') {
        jQuery.ajax({
            url: 'login_submit.php',
            type: 'post',
            data: 'name=' + name + '&password=' + password,
            success: function (result) {
                if (result == 'wrong') {
                    jQuery('.login-msg p').html('Please Enter Valid Login Details');
                }
                if (result == 'valid') {
                    window.location.href = window.location.href;
                }
            }
        });
    }
}

function manage_cart(pid,type) {
    if(type == 'update'){
        var qty = jQuery("#"+pid+"qty").val();
    }else{
        var qty = jQuery("#qty").val();
    }
    jQuery.ajax({
        url: 'manage_cart.php',
        type: 'post',
        data: 'pid=' + pid + '&qty=' + qty + '&type=' + type,
        success:function (result) {
            if(type == 'update' || type == 'remove'){
                window.location.href=window.location.href;
            }
            jQuery('.htc__qua').html(result);
        }
    });
}

