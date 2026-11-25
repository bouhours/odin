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
function showHideDiv(leplus, elm, invert = null) {
    autoLogOut();
    if (elm.classList.contains("hide")) {
        elm.classList.remove("hide");
        if (invert != null) {
            invert.classList.add("hide");
        }
        if (leplus != null) {
            leplus.innerHTML = "[-]";
        }
    } else {
        elm.classList.add("hide");
        if (invert != null) {
            invert.classList.remove("hide");
        }
        if (leplus != null) {
            leplus.innerHTML = "[+]";
        }
    }
}

function check_bind(element) {
    if (element.name==="STAGE_MAIL") {
        if (element.value.trim().match(/^([a-zA-Z0-9_\-\.]+)@((([a-zA-Z0-9\-]+\.)+))([a-zA-Z]+|[0-9]+)(\]?)(,([a-zA-Z0-9_\-\.]+)@((([a-zA-Z0-9\-]+\.)+))([a-zA-Z]+|[0-9]+)(\]?))*$/) === null) {
            showMessage("warning","Modification d'un stage","Le format du mail de contact est invalide. S'il y en a plusieurs, il faut les séparer par des virgules");
            return false;
        }
    } else {
        if (element.value.trim() === "") {
            showMessage("warning", "Modification d'un stage", "Ce champ ne peut pas être vide");
            return false;
        }
    }
    return true;
}

function check_form(formulaire) {
    if (formulaire['*STAGE_REF'].value.trim() === "") {
        showMessage("warning","Création d'un stage","La référence du stage est obligatoire");
        return false;
    }
    if (formulaire['*STAGE_SUJET'].value.trim() === "") {
        showMessage("warning","Création d'un stage","Le sujet d'un stage est obligatoire");
        return false;
    }
    if (formulaire['*STAGE_CONTACT'].value.trim() === "") {
        showMessage("warning","Création d'un stage","Les informations de contacts sont obligatoires");
        return false;
    }
    if (formulaire['*STAGE_MAIL'].value.trim().match(/^([a-zA-Z0-9_\-\.]+)@((([a-zA-Z0-9\-]+\.)+))([a-zA-Z]+|[0-9]+)(\]?)(,([a-zA-Z0-9_\-\.]+)@((([a-zA-Z0-9\-]+\.)+))([a-zA-Z]+|[0-9]+)(\]?))*$/) === null) {
        showMessage("warning","Création d'un stage","Le format du mail de contact est invalide. S'il y en a plusieurs, il faut les séparer par des virgules");
        return false;
    }
    var ok = false;
    formulaire['FORM_ID[]'].forEach(function (item, index) {
        if (item.checked) {
            ok = true;
        }
    });
    if (ok) {
        return true;
    }

    showMessage("warning","Création d'un stage","Au moins une formation doit être cochée.");
    return false;
}
/*
INLINE
 */
toDoOnLoad(function () {
    document.getElementById("id_selection_annee").onchange = function() {
        document.location.href = "?p=accueil&f="+this.dataset.bfmw+"&a="+this.value;
    }
});

toDoOnLoad(function () {
    document.getElementById("id_selection_formation").onchange = function() {
        document.location.href = "?p=accueil&a="+this.dataset.bfmw+"&f="+this.value;
    }
});

toDoOnLoad(function () {
    document.getElementById("id_show_depose_complet").onclick = function(){
        showHideDiv(document.getElementById("id_show_depose"),document.getElementById("id_depose"));
        return false;
    };
    document.getElementById("id_depose").onsubmit = function(){
        return check_form(this);
    };
    document.getElementById("id_confirm_suppression").onclick = function(){
        return confirm("Voulez-vous vraiment supprimer définitivement ce stage ?");
    };
});

toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("afficheur");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            showHideDiv(this,document.getElementById("detail_"+this.dataset.bfmw));
            return false;
        }
    }
});

toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("confirm_suppression");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            return confirm("Voulez-vous vraiment supprimer la candidature de cet étudiant à ce stage ?");
        }
    }
});

toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("show_edit");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            showHideDiv(null,document.getElementById("modif_"+this.dataset.bfmw),document.getElementById("consult_"+this.dataset.bfmw));
            return false;
        }
    }
});

toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            autoLogOut();
            if (check_bind(this)) {
                bind('sdfyndflkhnfkjghsdlfk', this.value, this.dataset.bfmw, this, this, null);
            }
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind2");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            bind('sdfyndflkhnfkjghsdlfk',this.value,this.dataset.bfmw,this,document.getElementById("confirm_"+this.dataset.bfmw),null);
        };
    }
});