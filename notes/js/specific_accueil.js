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
function propageValeur(valeur, clef) {
    autoLogOut();
    var lesInputs = document.getElementsByClassName('valuable');
    for (i = 0; i < lesInputs.length; i++) {
        if (lesInputs[i].dataset.propage === clef) {
            lesInputs[i].value = valeur;
        }
    }
}

function affecterNote(lesDonnees) {
    autoLogOut();
    var lesInfosCollees = lesDonnees.value.split(new RegExp("[\n]+", "g"));

    var lesInfosColleesClassees = {};
    var lesAvisColleesClassees = {};
    for (var i = 0; i < lesInfosCollees.length; i++) {
        var unEtudiant = lesInfosCollees[i].split(/\t/g);
        if (unEtudiant.length === 2 || unEtudiant.length === 3) {
            unEtudiant[1] = unEtudiant[1].replace(",", ".");
            if (unEtudiant[1].toUpperCase()  === "ABI" || unEtudiant[1].toUpperCase() === "ABJ" || unEtudiant[1] === "" || (!isNaN(unEtudiant[1]) && (parseFloat(unEtudiant[1]) >= 0.0 || document.getElementById('form')['CONTROLE_MOYENNE'].value === "2") && (parseFloat(unEtudiant[1]) <= parseFloat(document.getElementById("bareme").value) || document.getElementById('form')['CONTROLE_MOYENNE'].value === "2"))) {
                lesInfosColleesClassees[unEtudiant[0]] = unEtudiant[1].toUpperCase();
            } else {
                lesInfosColleesClassees[unEtudiant[0]] = "ERREUR";
            }
            if (unEtudiant.length === 3) {
                lesAvisColleesClassees[unEtudiant[0]] = unEtudiant[2];
            }
        }
    }

    var lesInputs = document.getElementsByClassName('valuable');
    for (i = 0; i < lesInputs.length; i++) {
        if (lesInputs[i].dataset.propage.startsWith("note_")) {
            if (lesInputs[i].dataset.numetudiant in lesInfosColleesClassees) {
                lesInputs[i].value = lesInfosColleesClassees[lesInputs[i].dataset.numetudiant];
                if (lesInputs[i].value !== "ERREUR") {
                    bind('sdflkg43sdfljhg', lesInputs[i].value, lesInputs[i].dataset.binding, lesInputs[i], lesInputs[i], null);
                }
            }
        }
        if (lesInputs[i].dataset.propage.startsWith("avis_")) {
            if (lesInputs[i].dataset.numetudiant in lesAvisColleesClassees) {
                lesInputs[i].value = lesAvisColleesClassees[lesInputs[i].dataset.numetudiant];
                bind('sdflkg43sdfljhg', lesInputs[i].value, lesInputs[i].dataset.binding, lesInputs[i], lesInputs[i], null);
            }
        }
    }

    checkNotes();
}

function checkNom() {
    autoLogOut();
    var formulaire = document.getElementById("form");
    if (formulaire['CONTROLE_NOM'].value.trim() === "") {
        showMessage("warning", "Attention", "Le nom du contrôle est obligatoire.");
        return false;
    }
    return true;
}

function checkCoeff(){
    autoLogOut();
    var formulaire = document.getElementById("form");
    if (formulaire['CONTROLE_COEFF'].value.trim().match(/^((0?[1-9]|[1-9][0-9])(((\.|,)[0-9]([0-9])?)?))|(0(\.|,)[0-9]([0-9])?)$/) === null) {
        showMessage("warning","Attention", "Le coefficient doit être compris entre 0.01 et 99.99");
        return false;
    }
    if (parseFloat(formulaire['CONTROLE_COEFF'].value) < 0.01 || parseFloat(formulaire['CONTROLE_COEFF'].value) > 99.99) {
        showMessage("warning","Attention", "Le coefficient doit être compris entre 0.01 et 99.99");
        return false;
    }
    return true;
}

function checkBareme(){
    autoLogOut();
    var formulaire = document.getElementById("form");
    if (formulaire['CONTROLE_BAREME'].value.trim().match(/^[0-9]\d*(\.\d+)?$/) === null) {
        showMessage("warning","Attention", "Le barême doit être un nombre décimal");
        return false;
    }
    if (parseFloat(formulaire['CONTROLE_BAREME'].value) < 1) {
        showMessage("warning","Attention", "Le barême doit être supérieur à 0");
        return false;
    }
    if (parseFloat(formulaire['CONTROLE_BAREME'].value) > 999) {
        showMessage("warning","Attention", "Le barême doit être inférieur à 999");
        return false;
    }
    return checkNotes();
}

function checkMoyenne(){
    return checkNotes();
}

function checkVisible() {
    return true;
}

function checkNotes(){
    var lesEtudiants = document.getElementsByClassName('valuable');
    var ok = (lesEtudiants.length > 0);
    for (var i = 0; i < lesEtudiants.length; i++) {
        if (lesEtudiants[i].dataset.propage.startsWith("note_")) {
            ok &= checkNote(lesEtudiants[i]);
        }
    }

    return ok;
}

function checkNote(etudiant){
    autoLogOut();
    var formulaire = document.getElementById("form");
    var fail = false;
    var lesOK = document.getElementsByName("ok_"+etudiant.dataset.numetudiant);
    var lesKO = document.getElementsByName("ko_"+etudiant.dataset.numetudiant);
    var noteATester = etudiant.value.replace(",",".");
    if (noteATester.trim() !== "") {
        if (noteATester === "ABI" || noteATester === "ABJ" || (!isNaN(noteATester) && (parseFloat(noteATester) >= 0.0 || formulaire['CONTROLE_MOYENNE'].value === "2")) && (parseFloat(noteATester) <= parseFloat(formulaire['CONTROLE_BAREME'].value) || formulaire['CONTROLE_MOYENNE'].value === "2")) {
            for (var i = 0; i < lesOK.length; i++) {
                lesOK[i].style.display = "inline";
            }
            for (var i = 0; i < lesKO.length; i++) {
                lesKO[i].style.display = "none";
            }
        } else {
            fail = true;
            for (var i = 0; i < lesOK.length; i++) {
                lesOK[i].style.display = "none";
            }
            for (var i = 0; i < lesKO.length; i++) {
                lesKO[i].style.display = "inline";
            }
        }
    }

    if (fail) {
        showMessage("warning", "Attention", "Certaines notes sont invalides.");
        return false;
    }

    return true;
}

function updateMoyenne($groupe, $dest) {
    autoLogOut();
    var xhttp;
    if (window.XMLHttpRequest) {
        xhttp = new XMLHttpRequest();
    } else {
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xhttp.open("POST", "index.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhttp.send("compute=moyenne&groupe=" + $groupe);
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState === 4 && xhttp.status === 200) {
            $dest.innerHTML = xhttp.responseText;
        }
    };
}

function forceCalcMoyenne(){
    autoLogOut();
    var lesElements = document.getElementsByName("SPECIAL_CALC_MOYENNE");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].click();
    }

}
/*
INLINE
 */
toDoOnLoad(function () {
    document.getElementById("id_selection_annee").onchange = function() {
        document.location.href = "?p=accueil&a="+this.value+"&f="+this.dataset.bfmw+"&m="+this.dataset.bfmw2;
    }
});
toDoOnLoad(function () {
    filter_etudiants(document.getElementById("selecteur_promo").value);
});
toDoOnLoad(function () {
    document.getElementById("selecteur_matiere").onchange = function () {
        window.location.href = '?p=accueil&resp=1&f='+this.dataset.bfmw+'&m=' + this.value+'&a=' + this.dataset.bfmw2;
    };
});
toDoOnLoad(function () {
    document.getElementById("selecteur_formation").onchange = function () {
        window.location.href = '?p=accueil&resp=1&f=' + this.value + '&a=' + this.dataset.bfmw;
    };
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("confirm_supprimer");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment supprimer ce contrôle ?');
        };
    }
});
toDoOnLoad(function () {
    document.getElementById("id_controle_nom").onblur = function () {
        var valeur = this.value;
        if (checkNom()) {
            var id = this.dataset.bfmw;
            bind('slkjf5ezlmkj', this.value, id, this, this, function () {
                document.getElementById('controle_' + id).innerHTML = valeur;
            });
        }
    };
});
toDoOnLoad(function () {
    document.getElementById("id_controle_brouillon_nom").onblur = function () {
        var valeur = this.value;
        if (checkNom()) {
            var id = this.dataset.bfmw;
            bind('slkjf5ezlmkj', this.value, id, this, this, function () {
                document.getElementById('controle_brouillon_' + id).innerHTML = valeur;
            });
        }
    };
});
toDoOnLoad(function () {
    document.getElementById("id_controle_coeff").onblur = function () {
        if (checkCoeff()) bind('slkjf5ezlmkj', this.value, this.dataset.bfmw, this, this, null);
    };
});
toDoOnLoad(function () {
    document.getElementById("bareme").onblur = function () {
        if (checkBareme()) bind('slkjf5ezlmkj', this.value, this.dataset.bfmw, this, this, null);
    };
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByName("CONTROLE_MOYENNE");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            if (checkMoyenne()) bind('slkjf5ezlmkj', this.value, this.dataset.bfmw, this, 'boxMoyenne', null);
        };
    }
});
toDoOnLoad(function () {
    document.getElementById("changeur_de_matiere").onchange = function () {
        var formation = this.dataset.bfmw2;
        var annee = this.dataset.bfmw3;
        var matiere = this.value;
        var controle =  this.dataset.bfmw;
        bind('slkjf5ezlmkj', this.value, this.dataset.bfmw, this, this, function () {
            location.href = '?p=accueil&m=' + matiere + '&c=' + controle + '&f=' + formation + '&a=' + annee;
        });
    }
});
toDoOnLoad(function () {
    document.getElementById("changeur_de_enseignant").onchange = function () {
        var annee = this.dataset.bfmw3;
        var formation = this.dataset.bfmw2;
        var controle =  this.dataset.bfmw;
        var matiere = this.dataset.bfmw4;
        bind('slkjf5ezlmkj', this.value, this.dataset.bfmw, this, this, function () {
            location.href = '?p=accueil&m=' + matiere + '&c=' + controle + '&f=' + formation + '&a=' + annee;
        });
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByName("CONTROLE_VISIBLE");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            if (checkVisible()) {
                var mat_id = this.dataset.bfmw2;
                var controle_id = this.dataset.bfmw;
                var valide = this.dataset.bfmw3;
                var valeur = this.value;
                bind('slkjf5ezlmkj', this.value, this.dataset.bfmw, this, 'boxVisible', function () {
                    if (valide==="1" && valeur==="1" && confirm('Souhaitez-vous envoyer un mail aux étudiants ?')) {
                        location.href = '?p=front&p2=accueil&mail=mail&m='+mat_id+'&c='+controle_id+'&f=' + document.getElementById('selecteur_matiere').dataset.bfmw;
                    }
                });
            }
        };
    }
});
toDoOnLoad(function () {
    document.getElementById("id_zone_paste").onpaste = function () {
        var e = this;
        setTimeout(function () {
            affecterNote(e);
            e.value = null;
            setTimeout(function(){
                forceCalcMoyenne();
            }, 1000);
        }, 10);
    };
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByName("SPECIAL_CALC_MOYENNE");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            updateMoyenne(this.dataset.bfmw, document.getElementById(this.dataset.bfmw2));
        }
    }
});
toDoOnLoad(function () {
    document.getElementById("id_download_excel").onclick = function () {
        window.location.href = '?generate=ResultatsMultiFormats&m=' + document.getElementById('selecteur_matiere').value;
    };
});
toDoOnLoad(function () {
    document.getElementById("id_download_ods").onclick = function () {
        window.location.href = '?generate=ResultatsMultiFormats&type=ods&m=' + document.getElementById('selecteur_matiere').value;
    };
});
toDoOnLoad(function () {
    document.getElementById("id_download_csv").onclick = function () {
        window.location.href = '?generate=ResultatsMultiFormats&type=csv&m=' + document.getElementById('selecteur_matiere').value;
    };
});
toDoOnLoad(function () {
    document.getElementById("id_download_excel_liste").onclick = function () {
        this.href='?generate=FicheNoteMultiFormat&a='+this.dataset.bfmw+'&g='+document.getElementById('selecteur_promo').value;
    };
});
toDoOnLoad(function () {
    document.getElementById("id_download_ods_liste").onclick = function () {
        this.href='?generate=FicheNoteMultiFormat&a='+this.dataset.bfmw+'&type=ods&g='+document.getElementById('selecteur_promo').value;
    };
});
toDoOnLoad(function () {
    document.getElementById("id_download_csv_liste").onclick = function () {
        this.href='?generate=FicheNoteMultiFormat&a='+this.dataset.bfmw+'&type=csv&g='+document.getElementById('selecteur_promo').value;
    };
});
toDoOnLoad(function () {
    document.getElementById("id_download_excel_controle").onclick = function () {
        window.location.href='?generate=ControleMultiFormat&c='+this.dataset.bfmw;
    };
});
toDoOnLoad(function () {
    document.getElementById("id_download_ods_controle").onclick = function () {
        window.location.href='?generate=ControleMultiFormat&c='+this.dataset.bfmw+'&type=ods';
    };
});
toDoOnLoad(function () {
    document.getElementById("id_download_csv_controle").onclick = function () {
        window.location.href='?generate=ControleMultiFormat&c='+this.dataset.bfmw+'&type=csv';
    };
});
toDoOnLoad(function () {
    document.getElementById("selecteur_promo").onchange = function () {
        filter_etudiants(this.value);
    };
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByName("NOTES_VALEUR");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onchange = function () {
            propageValeur(this.value, this.dataset.propage);
        };
        lesElements[i].onblur = function () {
            if (checkNote(this))
                bind('sdflkg43sdfljhg',this.value,this.dataset.binding,this,this,function(){setTimeout(function () {forceCalcMoyenne();},500)});
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByName("NOTES_AVIS");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onchange = function () {
            propageValeur(this.value, this.dataset.propage);
        };
        lesElements[i].onblur = function () {
            bind('sdflkg43sdfljhg',this.value,this.dataset.binding,this,this,null);
        };
    }
});
toDoOnLoad(
    setTimeout(function () {
        forceCalcMoyenne();
    }, 2000)
);
toDoOnLoad(function () {
    document.getElementById("id_lock").onclick = function () {
        if (confirm("Voulez-vous vraiment verrouiller la matière ?")) {
            if (confirm("Attention, une fois la matière verrouillée, il ne sera plus possible de modifier quoi que ce soit. Voulez-vous vraiment verrouiller la matière ?")) {
                window.location.href = '?p=front&p2=accueil&lock=sguilmql4qsg&a='+this.dataset.bfmw+'&f='+this.dataset.bfmw2+'&m=' + document.getElementById('selecteur_matiere').value
            }
        }
    };
});
toDoOnLoad(function () {
    document.getElementById("id_force_brouillon").onclick = function () {
        if (confirm("Voulez-vous vraiment rebasculer ce contrôle au brouillon ?")) {
            if (confirm("Attention, une fois le contrôle au brouillon, vous n'y aurez plus accès en tant que chef. Seul l'enseignant y aura accès. Etes-vous sûr ?")) {
                window.location.href = '?p=front&p2=accueil&a='+this.dataset.bfmw+'&c='+this.dataset.bfmw2+'&f='+this.dataset.bfmw3+'&m=' + document.getElementById('selecteur_matiere').value
            }
        }
        return false;
    };
});
toDoOnLoad(function () {
    document.getElementById("id_unlock").onclick = function () {
        if (confirm("Voulez-vous vraiment déverrouiller la matière ?")) {
            window.location.href = '?p=front&p2=accueil&unlock=sguilmql4qsg&a='+this.dataset.bfmw+'&f='+this.dataset.bfmw2+'&m=' + document.getElementById('selecteur_matiere').value
        }
    };
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("excel");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onkeypress = function (e) {
            var event = window.event ? window.event : e;
            var me = this;
            if (event.key === "Enter") {
                for (var j = 0; j < lesElements.length; j++) {
                    if (lesElements[j].dataset.me === me.dataset.next) {
                        event.stopPropagation();
                        lesElements[j].focus();
                    }
                }
            }
        };

    }
});