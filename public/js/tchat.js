
thetime="";
interlocuteur="";
$(function(){
    $('.show-message').click(function (event) {
        // empeche d'aller vers la page de suppression
        event.preventDefault();
        clearInterval(thetime);

        interlocuteur = $(this).attr("data-ami");
        //$('#message-utilisateur').data('link', $(this).attr('href'));

        $('#message-container').html('');
        // ouvre la modal de confirmation
        $('#message-utilisateur').show();

        thetime=setInterval(getMessages,5000);
    });



    function getMessages() {
        if(interlocuteur != ""){
            if($("#message-container>div").last().length==0)var id=0;
            else var id = $("#message-container>div").last().attr("data-id");
            $.get(
                "/message/user/"+interlocuteur+"-"+id,
                function (response) {
                    $('#message-container').append(response);
                    if(id==0) $("#message-container").scrollTop($("#message-container").prop('scrollHeight'));
                }
            );
        }
    }

    $("#form-message").submit(function(e){
        e.preventDefault();
        $.get(
            "/message/addmessage/"+interlocuteur+"-"+$("input[name='messageinput']").val(),
            function (response) {

                $("input[name='messageinput']").val("");
            }
        );
    });
});
