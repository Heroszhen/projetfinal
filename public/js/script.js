var tweet = $("#article_contenu"); //La zone de texte
var compteur = $("#counter em"); //Le compteur numérique

function counting() {
    tweet.val().length; //Calcule la longueur de la chaine de caractères

    (carac = tweet.val().length);
    compteur.text(carac);

    }

tweet.on("keyup", counting); //Détecte le relâchement d'une touche dans la zone de texte "tweet" et déclenche la fonction counting.


$('.delete-article').click(function(e){
    e.preventDefault();
    var href = $(this).attr('href');
    var id = $(this).attr('data-article');
    $.get(
        href,
        function(response){
            console.log(response);
            if(response === 'ok'){
                $('#'+id).remove();
            }
        }
    );
    console.log($(this).attr('href'));

});

$('.publier').click(function(){
    $("form[name='article']").find("input[name='action']").remove();
    $("form[name='article']").find("img").remove();
    $("form[name='article']").find('textarea').html("");
    $("form[name='article']").prepend("<input type='hidden' name='action' value='-1'>");
});

$("form[name='article']").find("input[type='file']").on("change",function(){
    $("form[name='article']").find("img").remove();
    function readURL(input) {
        if (input.files && input.files[0]) {
            //lire le contenu de fichiers de façon asynchrone
            var reader = new FileReader();
            reader.onload = function (e) {
                $("form[name='article']").append("<br><br><img src='"+e.target.result+"' alt='' width='200' class='img-fluid'>");
            }
            //démarrer la lecture du contenu pour le blob indiqué
            reader.readAsDataURL(input.files[0]);
        }
    }
    readURL(this);
});

$('.update-article').click(function(){
    $("form[name='article']").find("input[name='action']").remove();
    $("form[name='article']").find("img").remove();

    var id = $(this).attr('data-article');
    $("form[name='article']").prepend("<input type='hidden' name='action' value='"+id+"'>");
    $("form[name='article']").find('textarea').html($("#articles #article"+id+" .contenu").html());/*
	var src = $("#articles #article"+id+" .image img").attr('src');
	if(src){
		$("form[name='article']").append("<br><br><img src='"+src+"' width='200'>");
	}*/
});

$('.formcommentaire').each(function(){
    $(this).submit(function(e) {
        e.preventDefault();
        var action = $(this).attr("action");
        console.log(action);
        var form = $(this);
        $.post(
            action,
            $(this).serialize(),
            function(response){
               form.parent().parent().find("#touscommentaires").prepend(response);
            },
        );
    });
});

$(".delete-comment").click(function(e){
    e.preventDefault();
    var href= $(this).attr('href');
    var ba = $(this);
    $.get(
        href,
        function(response){
            if(response=="ok")ba.parent().parent().parent().remove();
        }
    );
});

$(".update-comment").click(function(e){
    e.preventDefault();
});