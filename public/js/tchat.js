$(function(){
    $('.show-message').click(function (event) {
        // empeche d'aller vers la page de suppression
        event.preventDefault();

        $('#message-utilisateur').data('link', $(this).attr('href'));

        $('#message-container').html('');
        // ouvre la modal de confirmation
        $('#message-utilisateur').show();

        //setInterval(getMessages,2000);
    });



    function getMessages() {
        $.get(
            $('#message-utilisateur').data('link'),
            function (response) {
                $('#message-container').append(response);
            }
        );
    }
});
