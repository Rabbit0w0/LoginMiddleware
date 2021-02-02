function validate (input) {
    if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
        if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
            return false;
        }
    }
    else {
        if($(input).val().trim() == ''){
            return false;
        }
    }
}


function showValidate(input) {
    var thisAlert = $(input).parent();

    $(thisAlert).addClass('alert-validate');
}

$("#submitNfo").on("click",function(){
    var pwd = $("#password").val();
    var usr = $("#email").val();
    var datap = "email="+usr+"&password="+pwd;
    $.ajax(      //ajax方式提交表单
    {
        url: './AuthProvider.php',
        type: 'post',
        data: datap,
        beforeSubmit: function (){
            for(var i=0; i<input.length; i++) {
                if(validate(input[i]) == false){
                    showValidate(input[i]);
                }
            }
            $("#submitNfo").val("验证中...");
        },
        success: function (data) {
            window.location.replace("register.php");
        }
    });
});