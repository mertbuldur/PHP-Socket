$(document).ready(function () {
    socket.emit('add_user',{'client':$("meta[name=client]").attr('content'),'messageId':$("meta[name=messageId]").attr('content')});
    scrollToEnd();
    $(".msg_send_btn").click(function () {
        var text = $("#message").val();
        $.ajax({
            type:"POST",
            url:"/message/send/"+$("meta[name=messageId]").attr('content'),
            data:{ text:text},
            dataType:"json",
            success:function (result) {
                var html = `<div class="outgoing_msg">
                            <div class="sent_msg">
                                    <p> `+result.text+`</p>
                                    <span class="time_date"> `+result.time+`</span> </div>
                            </div>`;
                $(".msg_history").append(html);
                scrollToEnd();
            }
        });

        $("#message").val("");
        scrollToEnd();

    });
    socket.on('message',function (result) {
        var html = `<div class="incoming_msg">
                            <div class="received_msg">
                                    <p> `+result.message+`</p>
                                    <span class="time_date"> `+result.time+`</span> </div>
                            </div>`;
        $(".msg_history").append(html);
        scrollToEnd();
    });
    function scrollToEnd() {
        var d = $(".msg_history");
        d.scrollTop(d.prop('scrollHeight'));
    }
    function updateIsRead() {
        $.ajax({
            type: "POST",
            url: "/message/update/" + $("meta[name=messageId]").attr('content'),
            data: {"text":""},
            dataType: "json",
            success: function (result) {
                $(".m-count").text('('+result.status+')');
            }
        });
    }
    setInterval(updateIsRead,3000);
    $("#searchUser").click(function () {
        setInterval(SearchingUser,1000);
    });

    var i = 0;
    function SearchingUser() {

        $.ajax({
            type:"POST",
            url:"/panel/search",
            data:{"submit":true},
            dataType:"json",
            success:function (result) {
                if(result.status)
                {
                    $("#second").html(i);
                    $("#searching").show();
                }
                else
                {
                    $("#searching").hide();
                }
            }
        });
        i++;
    }

    socket.on('search_result',function (data) {
        window.location = data.url;
    })

});