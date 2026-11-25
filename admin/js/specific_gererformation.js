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
    document.getElementById("id_select_formation").onchange = function() {
        document.location.href = "?p=gererformation&a="+this.dataset.bfmw+"&f="+this.value;
    }
});
toDoOnLoad(function () {
    document.getElementById("id_selection_annee").onchange = function() {
        document.location.href = "?p=gererformation&f="+this.dataset.bfmw+"&a="+this.value;
    }
});;
toDoOnLoad(function () {
    let lesElements = document.getElementsByName("confirm_suppres_formation");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment supprimer cette formation et tous ses semestres ?');
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByName("confirm_hide_formation");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            if (confirm('Voulez-vous vraiment masquer cette formation pour l\'année courante ?')) {
                return confirm('Cette action est irréversible. Voulez-vous vraiment masquer cette formation pour l\'année courante ?');
            } else {
                return false;
            }
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByName("confirm_suppres_semestre");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment supprimer ce semestre et toutes ses ue ?');
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByName("confirm_suppres_ue");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment supprimer cette ue et toutes ses matières ?');
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByName("confirm_suppres_matiere");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment supprimer cette matière ?');
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByName("confirm_hide_semestre");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            if (confirm('Voulez-vous vraiment masquer ce semestre pour l\'année courante ?')) {
                return confirm('Cette action est irréversible. Voulez-vous vraiment masquer ce semestre pour l\'année courante ?');
            } else {
                return false;
            }
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByName("confirm_hide_ue");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            if (confirm('Voulez-vous vraiment masquer cette ue pour l\'année courante ?')) {
                return confirm('Cette action est irréversible. Voulez-vous vraiment masquer cette ue pour l\'année courante ?');
            } else {
                return false;
            }
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByName("confirm_hide_matiere");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            if (confirm('Voulez-vous vraiment masquer cette matière pour l\'année courante ?')) {
                return confirm('Cette action est irréversible. Voulez-vous vraiment masquer cette matière pour l\'année courante ?');
            } else {
                return false;
            }
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByName("confirm_switch_semestre");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            if (confirm('Voulez-vous vraiment rendre ce semestre à nouveau modifiable ?')) {
                return confirm('Cette action est irréversible. Voulez-vous vraiment rendre ce semestre à nouveau modifiable ?');
            } else {
                return false;
            }
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByName("confirm_switch_ue");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            if (confirm('Voulez-vous vraiment rendre cette ue à nouveau modifiable ?')) {
                return confirm('Cette action est irréversible. Voulez-vous vraiment rendre cette ue à nouveau modifiable ?');
            } else {
                return false;
            }
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByName("confirm_switch_matiere");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            if (confirm('Voulez-vous vraiment rendre cette matière  à nouveau modifiable ?')) {
                return confirm('Cette action est irréversible. Voulez-vous vraiment rendre cette matière à nouveau modifiable ?');
            } else {
                return false;
            }
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("updater");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function (event) {
            autoLogOut();
            showUpdater(event,this.dataset.bfmw,document.getElementById(this.dataset.bfmw2).innerText,this.dataset.bfmw3,this.dataset.bfmw2,"oiuioy45itgfkjgh");
            return false;
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByClassName("bind");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            bind('oiuioy45itgfkjgh', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByClassName("bind2");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onchange = function () {
            bind('oiuioy45itgfkjgh', this.value, this.dataset.bfmw, this, this, null);
        };
    }
    lesElements = document.getElementsByClassName("bind25");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onchange = function () {
            bind('oiuioy45itgfkjgh', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByClassName("bind3");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            bind('dxwcvjkcvbnjkutyfgcb', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByClassName("bind4");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            bind('zeklhsdlfghnlsuidnczljekshfqsd', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByClassName("bind5");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onchange = function () {
            bind('dxwcvjkcvbnjkutyfgcb', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByClassName("bind_pro");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            bind('oiuioy45itgfkjgh', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});