/**
 * 按钮添加
 */
$("#button-add").click(function(){
    var url = SCOPE.add_url;
    window.location.href = url;
});

/**
 * 表单提交添加
 */
$("#singcms-button-submit").click(function(){
    var data = $("#singcms-form").serializeArray();
    var postdata = {};

    $(data).each(function(i){
        postdata[this.name] = this.value;
    });

    var url = SCOPE.save_url;
    var jump_url = SCOPE.jump_url;

    $.ajax({
        type: "POST",
        url: url,
        data: postdata,
        dataType: "json",
        success: function(result){
            if ( result.status == 0 ) {
                return dialog.error( result.message );
            } else if ( result.status == 1 ) {
                return dialog.success( result.message, jump_url );
            }
        }
        // error: function(XMLHttpRequest, textStatus, errorThrown) {
        //     alert(XMLHttpRequest.status);
        //     alert(XMLHttpRequest.readyState);
        //     alert(textStatus);
        // }
    });
});

/**
 * 表单修改操作
 */
$(".singcms-table #singcms-edit").click(function(){
    var id = $(this).attr("attr-id");
    var url = SCOPE.edit_url + "&id=" + id;
    window.location.href = url;
});

/**
 * 删除操作
 */
$(".singcms-table #singcms-delete").click(function(){
    var id = $(this).attr("attr-id");
    var message = $(this).attr("attr-message");
    var data = {};
    var url = SCOPE.set_status_url + "&id=" + id;
    var jump_url = SCOPE.jump_url;
    data['id'] = id;
    data['status'] = -1;

    layer.open({
        type: 0,
        title: "是否提交操作？",
        btn: ['yes','no'],
        icon: 3,
        closeBtn: 2,
        content: "是否确定" + message,
        scrollbar: true,
        yes: function(){
            todelete(data,url,jump_url);
        }
    })
});

/**
 * 确认删除
 * @param data
 * @param url
 * @param jump_url
 */
function todelete(data, url, jump_url) {
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: "json",
        success: function(result){
            if ( result.status == 0 ) {
                return dialog.error( result.message );
            } else if ( result.status == 1 ) {
                return dialog.success( result.message, jump_url );
            }
        }
    })
}

/**
 * 排序
 */
$("#button-listorder").click(function(){
    var data = $("#singcms-listorder").serializeArray();
    var postdata = {};
    $(data).each(function(i){
        postdata[this.name] = this.value;
    });
    var url = SCOPE.listorder_url;
    $.ajax({
        type: "POST",
        url: url,
        data: postdata,
        dataType: "json",
        success: function(result){
            if ( result.status == 0 ) {
                return dialog.error( result.message );
            } else if ( result.status == 1 ) {
                return dialog.success( result.message, result.data.jump_url );
            }
        }
    });
});

/**
 * 切换status
 */
$("#singcms-on-off").click(function(){
    var id = $(this).attr("attr-id");
    var status = $(this).attr("attr-status");
    var data = {};
    var url = SCOPE.set_status_url + "&id=" + id;
    var jump_url = SCOPE.jump_url;
    data['id'] = id;
    if ( status == 1 ) {
        data['status'] = 0;
    } else if ( status == 0 ) {
        data['status'] = 1;
    }
    layer.open({
        type: 0,
        title: "是否提交操作？",
        btn: ['yes','no'],
        icon: 3,
        closeBtn: 2,
        content: "是否确定更换状态",
        scrollbar: true,
        yes: function(){
            todelete(data,url,jump_url);
        }
    })
});

/**
 * 全选/全不选
 */
$("#singcms-checkbox-all").click(function(){
    $("[name=pushcheck]:checkbox").prop('checked', this.checked);
});

/**
 * 全选框和复选框
 */
$("[name=pushcheck]:checkbox").click(function(){
    var $tmp = $('[name=pushcheck]:checkbox');
    $("#singcms-checkbox-all").prop('checked', $tmp.length==$tmp.filter(':checked').length);
});

/**
 * 文章推送
 */
$("#singcms-push").click(function(){
    var id = $("#select-push").val();
    if ( id == 0 ) {
        return dialog.error("请选择推荐位");
    }
    var data ={};
    $("input[name=pushcheck]:checkbox:checked").each(function(i){
        data[i] = $(this).val();
    });
    var postData = {};
    postData['push'] = data;
    postData['position_id'] = id;
    var url = SCOPE.push_url;
    var jump_url = SCOPE.jump_url;
    $.ajax({
        type: "POST",
        url: url,
        data: postData,
        dataType: "json",
        success: function(result){
            if ( result.status == 0 ) {
                return dialog.error( result.message );
            } else if ( result.status == 1 ) {
                return dialog.success( result.message, jump_url );
            }
        }
    });
});

/**
 * 文章预览
 */
$(".singcms-table #singcms-preview").click(function(){
    var id = $(this).attr("attr-id");
    var url = SCOPE.sing_news_view_url + "&id=" + id;
    window.open(url, "_blank");
});

/**
 * 更新缓存按钮
 */
$("#cache-index").click(function(){
    var url = "/index.php?c=index&a=build_html";
    var jump_url = "/admin.php?c=basic&a=cache";
    var postData = {};
    $.ajax({
        type: "POST",
        url: url,
        data: postData,
        dataType: "json",
        success: function(result){
            if ( result.status == 0 ) {
                return dialog.error( result.message );
            } else if ( result.status == 1 ) {
                return dialog.success( result.message, jump_url );
            }
        }
    });
});
