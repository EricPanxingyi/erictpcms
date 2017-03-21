/**
 * 加载更多
 */
var curPage = 1;
var total,pageSize,totalPage;
var i = 1;

(function($){
    getData(1);
})(jQuery);

function getData(page) {
    $.ajax({
        type: "POST",
        url: "/index.php?c=index&a=getAjaxMore",
        data: {'pageNum' : page},
        dataType: "json",
        afterSend: function(){
            $('.news-list').append("<dl id='loading'>loading</dl>");
        },
        success: function(json){
            total = json.total;
            pageSize = json.pageSize;
            curPage = page;
            totalPage = json.totalPage;
            var str = "";
            var list = json.list;
            $.each(list, function(index, array){
                str += '<dl>';
                str += '<dt><a href="/article/'+array['catid']+'/'+array['news_id']+'" target="_blank">'+array['title']+'</a></dt>';
                str += '<dd class="news-img"><a href="/article/'+array['catid']+'/'+array['news_id']+'" target="_blank"><img width="200" height="120" src="'+array['thumb']+'" alt="'+array['title']+'"></a></dd>';
                str += '<dd class="news-intro">'+array['description']+'</dd>';
                str += '<dd class="news-info">'+array['keywords']+' <span>'+array['create_time']+'</span> 阅读(<i news-id="'+array['news_id']+'" class="news_count node-'+array['news_id']+'">'+array['count']+'</i>) </dd>';
                str += '</dl>';
            });
            $(".news-list").append(str);
        }
    });
}

$(document).ready(function() {
    $(window).scroll(function() {
            if (totalPage - i > 0) {
                if ($(document).scrollTop() >= $(document).height() - $(window).height()) {
                    if (totalPage - i > 0) {
                        setTimeout(function () {
                            $('.news-list').append(getData(i));
                        }, 200);
                        i++;
                    }
                }
            } else {
                $(".nodata").html("没有更多数据了...");
                setTimeout(function () {
                    $(".nodata").hide();
                }, 3000);
            }
    });
});

/**
 * 排行榜
 */
$(".right-content li").hover(function(){
    $(this).addClass('curr').find('div').show();
    $(this).siblings('li').removeClass('curr').find('div').hide();
});

/**
 * 计数器
 */
var newsId = {};
$(".news_count").each(function(i){
    newsId[i] = $(this).attr("news-id");
});
var url = "/index.php?c=index&a=getCount";
$.ajax({
    type: "POST",
    url: url,
    data: newsId,
    dataType: "json",
    success: function(result){
        if ( result.status == 1 ) {
            counts = result.data;
            $.each(counts, function(news_id, count){
                $(".node-" + news_id).html(count);
            })
        }
    }
});



