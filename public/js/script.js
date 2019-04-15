/*
#REMARQUES
Pour récupérer la valeur d'un champ de formulaire
- en js : .value
- en jQuery : .val()
*/

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
