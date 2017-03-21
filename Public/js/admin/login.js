var login = {
    check : function() {
        var username = $("input[name='username']").val();
        var password = $("input[name='password']").val();

        if ( !username ) return dialog.error("用户名不能为空");
        if ( username && !password ) return dialog.error("密码不能为空");

        var url = '/admin.php?c=login&a=check';
        var data = {'username': username, 'password': password};
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: "json",
            success: function(result){
                if ( result.status == 0 ) {
                    return dialog.error( result.message );
                } else if ( result.status == 1 ) {
                    return dialog.success( result.message, "/admin.php" );
                }
            }
        });
    }
};
