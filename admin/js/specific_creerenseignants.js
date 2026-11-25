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
    var lesElements = document.getElementsByName("confirm_supress_enseignant");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment supprimer du département cet enseignant?');
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            bind('55fgh43241dfgh557sh', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind2");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            if (this.value.trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)(,([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?))*$/) === null) {
                showMessage("warning","Modification de l'adresse mail","Le format du mail de contact est invalide.");
                return false;
            }
            bind('55fgh43241dfgh557sh', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("specific_check_creerenseignants_1");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            bind('55fgh43241dfgh557sh', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    document.getElementById("id_search").onclick = function () {
        search(document.getElementById('nomachercher').value,document.getElementById('resultatrecherche'));
    };
});
toDoOnLoad(function () {
    document.getElementById("id_manual_add").onclick = function () {
        location.href='?p=front&p2=creerenseignants&manuel=manuel&name='+document.getElementById('nomacreer').value;
    };
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("updater");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function (event) {
            autoLogOut();
            showUpdater(event,this.dataset.bfmw,document.getElementById(this.dataset.bfmw2).innerText,this.dataset.bfmw3,this.dataset.bfmw2,"55fgh43241dfgh557sh");
            return false;
        };
    }
});