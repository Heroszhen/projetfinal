var tweet = $("#tweet-content"); //La zone de texte
var compteur = $("#counter em"); //Le compteur numérique

function counting() {
    tweet.val().length; //Calcule la longueur de la chaine de caractères

    (carRest = (140 - tweet.val().length)); //On remplace le texte du compteur par différence de 140 et la longueur de la chaine de caractère tapée
    compteur.text(carRest);

    if (carRest < 0) { //Si 140 - la chaine de caractère est < à 0 alors
        compteur.addClass("danger");// on lui applique la classe danger qui la rend rouge
    } else {
        compteur.removeClass("danger"); //Sinon on retire la classe et ça redevient noir.
    }

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

