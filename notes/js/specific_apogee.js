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
function propageNote(note, clef) {
    autoLogOut();
    var lesInputs = document.getElementsByClassName('valuable');
    for (i = 0; i < lesInputs.length; i++) {
        if ("note_"+lesInputs[i].dataset.propage === clef) {
            lesInputs[i].value = note;
        }
    }
}

function affecterNote(lesDonnees) {
    autoLogOut();
    var lesInfosCollees = lesDonnees.value.split(new RegExp("[ ]+", "g"));

    var lesInfosColleesClassees = {}
    for (var i = 0; i < lesInfosCollees.length; i++) {
        var unEtudiant = lesInfosCollees[i].split(/\t/g);
        unEtudiant[1] = unEtudiant[1].replace(",", ".");
        if (unEtudiant[1] === "ABI" || unEtudiant[1] === "ABJ" || (!isNaN(unEtudiant[1]) && (parseFloat(unEtudiant[1]) >= 0.0 || document.getElementById('form')['CONTROLE_MOYENNE'].value === "2")) && (parseFloat(unEtudiant[1]) <= parseFloat(document.getElementById("bareme").value) ||document.getElementById('form')['CONTROLE_MOYENNE'].value === "2")) {
            lesInfosColleesClassees[unEtudiant[0]] = unEtudiant[1];
        } else {
            lesInfosColleesClassees[unEtudiant[0]] = "ERREUR";
        }
    }

    var lesInputs = document.getElementsByClassName('valuable');
    for (i = 0; i < lesInputs.length; i++) {
        if (lesInputs[i].dataset.numetudiant in lesInfosColleesClassees) {
            lesInputs[i].value = lesInfosColleesClassees[lesInputs[i].dataset.numetudiant];
            if (lesInputs[i].value !== "ERREUR") {
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
    if (formulaire['CONTROLE_BAREME'].value.trim().match(/^(([1-9])|([1-9]([0-9])+))$/) === null) {
        showMessage("warning","Attention", "Le barême doit être supérieur à 0");
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
        ok &= checkNote(lesEtudiants[i]);
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
        document.location.href = "?p=apogee&a="+this.value;
    }
});
toDoOnLoad(function () {
    filter_etudiants(document.getElementById("selecteur_promo").value);
});
toDoOnLoad(function () {
    document.getElementById("selecteur_matiere").onchange = function () {
        window.location.href = '?p=apogee&resp=1&m=' + this.value +'&a='+this.dataset.bfmw;
    };
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
    let lesElements = document.getElementsByName("CONTROLE_VISIBLE");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            if (checkVisible()) {
                let mat_id = this.dataset.bfmw2;
                let controle_id = this.dataset.bfmw;
                let annee_id = this.dataset.bfmw3;
                let valeur = this.value;
                bind('slkjf5ezlmkj', this.value, this.dataset.bfmw, this, 'boxVisible', function () {
                    if (valeur==="1" && confirm('Souhaitez-vous envoyer un mail aux étudiants ?')) {
                        location.href = '?p=front&p2=apogee&mail=mail&m='+mat_id+'&c='+controle_id+'&a='+annee_id;
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
        window.location.href = '?generate=ResultatsMultiFormats&a='+this.dataset.bfmw+'&m=' + document.getElementById('selecteur_matiere').value
    };
});
toDoOnLoad(function () {
    document.getElementById("id_download_ods").onclick = function () {
        window.location.href = '?generate=ResultatsMultiFormats&a='+this.dataset.bfmw+'&type=ods&m=' + document.getElementById('selecteur_matiere').value
    };
});
toDoOnLoad(function () {
    document.getElementById("id_download_csv").onclick = function () {
        window.location.href = '?generate=ResultatsMultiFormats&a='+this.dataset.bfmw+'&type=csv&m=' + document.getElementById('selecteur_matiere').value
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
            propageNote(this.value, 'note_'+this.dataset.propage);
        };
        lesElements[i].onblur = function () {
            if (checkNote(this))
                bind('sdflkg43sdfljhg',this.value,this.dataset.binding,this,this,function(){setTimeout(function () {forceCalcMoyenne();},500)});
        };
    }
});
toDoOnLoad(
    setTimeout(function () {
        forceCalcMoyenne();
    }, 1000)
);
toDoOnLoad(function () {
    document.getElementById("id_lock").onclick = function () {
        if (confirm("Voulez-vous vraiment verrouiller la matière ?")) {
            if (confirm("Attention, une fois la matière verrouillée, il ne sera plus possible de modifier quoi que ce soit. Voulez-vous vraiment verrouiller la matière ?")) {
                window.location.href = '?p=front&p2=apogee&lock=sguilmql4qsg&a='+this.dataset.bfmw+'&m=' + document.getElementById('selecteur_matiere').value
            }
        }
    };
});

toDoOnLoad(function () {
    document.getElementById("id_unlock").onclick = function () {
        if (confirm("Voulez-vous vraiment déverrouiller la matière ?")) {
            window.location.href = '?p=front&p2=apogee&unlock=sguilmql4qsg&a='+this.dataset.bfmw+'&m=' + document.getElementById('selecteur_matiere').value
        }
    };
});