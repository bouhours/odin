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
    var lesElements = document.getElementsByName("confirm_supress_etudiant");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment supprimer cet étudiant et tout ce qui lui est attaché ?');
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            bind('iuzeksdf54szdfgjkdf1', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind2");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            bind('iuzeksdf54szdfgjkdf1', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind_date");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            if (this.value.trim().match(/^(0?[1-9]|[12][0-9]|3[01])[\/](0?[1-9]|1[012])[\/]([2][0][123][0-9])$/) === null) {
                showMessage("warning","Attention", "Le format de la date n'est pas correct (JJ/MM/AAAA).");
                return false;
            }

            bind('iuzeksdf54szdfgjkdf1', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});

toDoOnLoad(function () {
    document.getElementById("id_selecteur_promo").onchange = function () {
        window.location.href = '?p=gereretudiants&resp=1&f=' + this.value + '&a='+this.dataset.bfmw;
    };
});
toDoOnLoad(function () {
    document.getElementById("id_selecteur_annee").onchange = function () {
        window.location.href = '?p=gereretudiants&f='+this.dataset.bfmw+'&a=' + this.value;
    };
});
toDoOnLoad(function () {
   document.getElementById("confirm_dem").onclick = function () {
       return confirm("Voulez-vous vraiment déclarer cet étudiant comme démissionnaire ?")
    };
    document.getElementById("clic_show_fiche").onclick = function () {
        var bloc = document.getElementById("id_show_fiche");
        if (bloc.classList.contains("hide")) {
            bloc.classList.remove("hide");
            bloc.style = "";
            this.classList.remove("plus");
            this.classList.add("moins");
        } else {
            bloc.classList.add("hide");
            this.classList.add("plus");
            this.classList.remove("moins");
        }
    };
});
/*
Gestion des notes étudiants
 */
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("show_releve");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            var elm = document.getElementById("releve_"+this.dataset.bfmw);
            if (elm.style.display !== 'table') {
                elm.style.display = 'table';
                elm.style.visibility = 'visible';
                this.innerHTML = "- Cacher le " + this.dataset.bfmw2;
            } else {
                elm.style.display = 'none';
                elm.style.visibility = 'hidden';
                this.innerHTML = "+ Afficher le " + this.dataset.bfmw2;
            }
            return false;
        }
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("afficheur_controle");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            var elementCourant = this;
            var lesLignes = document.getElementsByClassName("specific_afficher_note_"+elementCourant.dataset.bfmw);
            if (elementCourant.innerHTML === "+") {
                elementCourant.innerHTML = "-";
                elementCourant.title = "Masquer les contrôles";
                for (var j = 0; j < lesLignes.length; j++) {
                    lesLignes[j].style.display = "table-row";
                }
            } else {
                elementCourant.innerHTML = "+";
                elementCourant.title = "Afficher les contrôles";
                for (var j = 0; j < lesLignes.length; j++) {
                    lesLignes[j].style.display = "none";
                }
            }
            return false;
        };
    }
});