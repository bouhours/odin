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
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});

function clickCreneauSpecial(element) {
    autoLogOut();
    document.getElementById("special_text").disabled = !element.checked;
    document.getElementById("special_check_matin").disabled = !element.checked;
    document.getElementById("special_check_aprem").disabled = !element.checked;
}

function checkForm(formulaire) {
    autoLogOut();
    if (formulaire['ABS_DATE'].value.trim() === "") {
        showMessage("warning", "Attention", "La date de l'absence est obligatoire.");
        return false;
    }

    let creneau = false;
    formulaire['creneau[]'].forEach(function (item, index) {
        if (item.checked)
            creneau = true;
    });
    if (!creneau && !formulaire['creneau_special'].checked) {
        showMessage("warning", "Attention", "Vous devez sélectionner au moins un créneau horaire d'absence.");
        return false;
    }
    if (formulaire['creneau_special'].checked && formulaire['creneau_horaire'].value.trim() === "") {
        showMessage("warning", "Attention", "Vous devez saisir un créneau horaire.");
        return false;
    }
    if (formulaire['creneau_special'].checked && formulaire['creneau_horaire'].value.trim().match(/^([01]\d|2[0-3])h([0-5]\d)\s-\s([01]\d|2[0-3])h([0-5]\d)$/) === null) {
        showMessage("warning", "Attention", "Votre créneau horaire ne respecte pas le format (HHhMM - HHhMM).");
        return false;
    }

    var etudiants = false;
    for (var i = 0; i < formulaire['etudiant[]'].length; i++) {
        if (formulaire['etudiant[]'][i].checked) {
            etudiants = true;
            break;
        }
    }

    if (!etudiants) {
        showMessage("warning", "Attention", "Vous devez sélectionner au moins un étudiant absent.");
        return false;
    }

    return true;
}

function getSelecteurEtudiant(valeur,chef = false) {
    autoLogOut();
    let xhttp;
    if (window.XMLHttpRequest) {
        xhttp = new XMLHttpRequest();
    } else {
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    if (chef) {
        xhttp.open("POST", "index.php?generate=SelecteurEtudiant&chef=chef", true);
    } else {
        xhttp.open("POST", "index.php?generate=SelecteurEtudiant", true);
    }
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("s=" + valeur);
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState === 4 && xhttp.status === 200) {
            document.getElementById('id_generated_selecteur_etudiant').innerHTML = xhttp.responseText;
            if (document.getElementById("selecteur_promo") != null) {
                filter_etudiants(document.getElementById("selecteur_promo").value);
                document.getElementById("selecteur_promo").onchange = function () {
                    autoLogOut();
                    filter_etudiants(this.value);
                };
                let lesElements = document.getElementsByClassName("checkable");
                for (let i = 0; i < lesElements.length; i++) {
                    let element = lesElements[i];
                    element.onclick = function () {
                        autoLogOut();
                        checkAll(element.value, element.checked);
                    };
                }
            }
        }
    };
}

/*
INLINE
 */
toDoOnLoad(function () {
    var d = new Date();
    document.getElementById("id_date_cours").value =  d.toDateInputValue();
});
toDoOnLoad(function () {
    document.getElementById("id_main_form").onsubmit = function () {
        return checkForm(this);
    };
});
toDoOnLoad(function () {
    document.getElementById("id_show_creneau").onclick = function () {
        autoLogOut();
        document.getElementById('ajouter_creneau_id').style.display = 'block';
        this.style.display = 'none';
        return false;
    };
});
toDoOnLoad(function () {
    document.getElementById("id_show_creneau_rares").onclick = function () {
        autoLogOut();
        document.getElementById('id_afficher_creneaux_rares').style.display = 'block';
        this.style.display = 'none';
        return false;
    };
});
toDoOnLoad(function () {
    document.getElementById("id_creneau_special").onclick = function () {
        autoLogOut();
        clickCreneauSpecial(this);
    };
});
toDoOnLoad(function () {
    document.getElementById("id_nom_du_cours").onchange = function () {
        autoLogOut();
        document.getElementById('id_id_du_cours').value = 0;
    };
});
toDoOnLoad(function () {
    document.getElementById("selecteur_affectations").onchange = function () {
        getSelecteurEtudiant(this.value,true);
    };
});
toDoOnLoad(function () {
    getSelecteurEtudiant(document.getElementById("selecteur_affectations").value,true);
});
