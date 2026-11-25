/*
 * Auteur : Cédric BOUHOURS
 * Ce code est mis à disposition selon les termes de la Licence Creative Commons Attribution
 * Pas d'Utilisation Commerciale - Pas de Modification 4.0 International.
 *
 * Attribution — Vous devez créditer l'Œuvre, intégrer un lien vers la licence. Vous devez indiquer ces informations par tous les moyens raisonnables, sans toutefois suggérer que l'Offrant vous soutient ou soutient la façon dont vous avez utilisé son Oeuvre.
 *
 * Pas d’Utilisation Commerciale — Vous n'êtes pas autorisé à faire un usage commercial de cette Oeuvre, tout ou partie du matériel la composant.
 *
 * Pas de modifications — Dans le cas où vous effectuez un remix, que vous transformez, ou créez à partir du matériel composant l'Oeuvre originale, vous n'êtes pas autorisé à distribuer ou mettre à disposition l'Oeuvre modifiée.
 *
 * Pas de restrictions complémentaires — Vous n'êtes pas autorisé à appliquer des conditions légales ou des mesures techniques qui restreindraient légalement autrui à utiliser l'Oeuvre dans les conditions décrites par la licence.
 *
 *
 */

/*
Fonctions
 */
/*
INLINE
 */
toDoOnLoad(function () {
    document.getElementById("id_select_groupe").onchange = function () {
        autoLogOut();
        window.location.href = '?p=mediateur_pro&g=' + this.value;
    };
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByName("id_justif_medic");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment indiquer que cette absence est justifiée pour raisons médicales ?');
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByName("id_justif_convoc");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment indiquer que cette absence est justifiée par une convocation administrative ?');
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByName("id_justif_chef");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment indiquer que cette absence est justifiée par le responsable de la formation ?');
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByName("id_justif_credit");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment indiquer que cette absence est justifiée avec un crédit-jour ?');
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByName("name_justification");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            bind('sdfkjhze83xwdf475zsdf',this.value,this.dataset.bfmw,this,this,null);
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("confirm_suppr");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment supprimer cette justification ? Les absences déjà justifiées grâce à elle ne seront pas "dé-justifiées".');
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("confirm_suppr_justif");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment supprimer cette justification ?');
        };
    }
});