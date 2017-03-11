
function checkStatus()
{
    $.ajax({
        url:      '/study/ajaxCheck',
        type:     "get",
        dataType: "json",
        beforeSend: function(result){
            // A.showMask();
        },
        success: function(result, status){
            if (result.result) {
                // 定时检测验证状态
                setTimeout(function(){
                    checkStatus();
                }, 5000);
            } else {
                if (result.message == 'need validation') {
                    showValidator();
                } else {
                    A.alert(result.message);
                }
            }
        },
        complete: function(result, status){
            // A.hideMask();
        },
        error: function(result){

        }
    });
}

function reloadValidator() {
    $('#validator-image').attr('src', '/image/validator?'+Math.random());
}

function showValidator() {
    A.confirm('请输入验证码', $("#validator-content").html(), function(){
        var code = $('#validator-code').val();
        var url  = '/study/ajaxValidate?code=' + code;
        $.ajax({
            url:      url,
            type:     "get",
            dataType: "json",
            beforeSend: function(result){
                A.showMask();
            },
            success: function(result, status){
                if (result.result) {
                    setTimeout(function(){
                        checkStatus();
                    }, 5000);
                } else {
                    A.alert(result.message, function(){
                        showValidator();
                    });
                }
            },
            complete: function(result, status){
                A.hideMask();
            },
            error: function(result){

            }
        });
    }, function(){
        showValidator();
    });
    reloadValidator();
}