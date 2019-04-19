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
               form.parent().parent().find(".touscommentaires").prepend(response);
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

function fdelete(id){
    var ba=$("#d"+id);
    $.get(
        '/commentaire/delete/'+id,
        function(response){
            if(response=="ok")ba.parent().parent().parent().remove();
        }
    );
}



$(".update-comment").click(function(e){
    e.preventDefault();
    var span = $(this).parent().parent().parent().find("span");
    var texte = span.text();
    var id = $(this).attr('data-id');
    span.html("<form method='post' id='"+id+"' onsubmit='fcommentaire("+id+");return false;'><input type='text' name='comment' value='"+texte+"'>&nbsp;<button type='submit' class='btn btn-link btn-sm'>Commenter</button></form>");
});

function fcommentaire(id) {
    var value = $("#"+id).find('input').val();
    var url = $("a[data-id='"+id+"']").attr("href");
    console.log(value);
    $.ajax({
        type: "post",
        url: url,
        data: "id="+id+"&input="+value,
        datatype: "text",
        success: function(rep){
            if(rep=='ok'){
                $("form#"+id).parent().html(value);
            }
        },
        error: function(xhr, status, err){}
    })
}

function fupdate(id){
    var span = $("#up"+id).parent().parent().parent().find("span");
    var texte = span.text();
    span.html("<form method='post' id='"+id+"' onsubmit='fcommentaire2("+id+");return false;'><input type='text' name='comment' value='"+texte+"'>&nbsp;<button type='submit' class='btn btn-link btn-sm'>Commenter</button></form>");
}

function fcommentaire2(id) {
    var value = $("#"+id).find('input').val();
    $.ajax({
        type: "post",
        url: '/commentaire/update/'+id,
        data: "input="+value,
        datatype: "text",
        success: function(rep){
            if(rep=='ok'){
                $("form#"+id).parent().html(value);
            }
        },
        error: function(xhr, status, err){}
    })
}

$('.div-friend').on('click', ".delete-friend", function(e){
//$(".delete-friend").click(function(e){
    e.preventDefault();
    var href= $('.delete-friend').attr('data-href');
    console.log(href);
    $.get(
        href,
        function(response){
            $('.delete-friend').hide();
            $('.add-friend').show();
        }
    );
});

$('.div-friend').on('click', ".add-friend", function(e){
//$(".add-friend").click(function () {

    var href=$('.add-friend').attr('data-href');
    console.log(href);
    $.get(
        href,
        function(response){
           $('.delete-friend').show();
           $('.add-friend').hide();
        }
    );
});
//
//
//
// $(".del-friend").click(function(){
//
//     var href=$(this).attr('data-href');
//     var bb=$(this);
//     var userid=$(this).attr('data-id');
//     $.get(
//         href,
//         function(response){
//             if(response=="ok")
//             bb.parent().append("<button data-id='"+userid+"' class=\"btn btn-primary col-3 mx-2 add-friend\" data-href=\"{{ path('app_amis_follow', {'id': "+userid+"}) }}\">\n" + "<i class=\"fas fa-user-plus\"></i></button>");
//             bb.remove();
//         }
//     );
// });
//

$(".showcomments").each(function(){
    $(this).click(function(e){
        e.preventDefault();
        $(this).parent().parent().parent().find(".touscommentaires > div").toggle();
    })
});
