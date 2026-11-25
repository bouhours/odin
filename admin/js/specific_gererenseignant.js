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
function computeEqTD(sem,annee,container) {
    bfmw_jx("?",function(reponse){
        container.innerHTML = reponse;
    },function(){
        container.innerHTML = 0;
    },"POST","computetd=1&s="+sem+"&a="+annee);
}
function computeEqTDEnsMat(annee,ens,mat,container) {
    bfmw_jx("?",function(reponse){
        container.innerHTML = reponse;
    },function(){
        container.innerHTML = 0;
    },"POST","computetdensmat=1&a="+annee+"&e="+ens+"&m="+mat);
}
function computeEqTDMat(annee,sem) {
    bfmw_jx("?",function(reponse){
        var data = JSON.parse(reponse);
        for (var i = 0; i < data.infos.length; i++) {

            var element = document.getElementById("charge_" + data.infos[i].ENS_ID +"_"+ data.infos[i].MAT_ID);
            if (element != null) {
                element.innerHTML = data.infos[i].TOTAL;
            }
        }
    },function(){

    },"POST","computeetdmat=1&a="+annee+"&s="+sem);
}
function refreshComputeTD() {
    computeEqTD(document.getElementById("id_s").value,document.getElementById("id_a").value,document.getElementById("id_charge_eqtd"));
}
function formatCharge(reponse) {
    const lesBlocs = reponse.split('¤¤¤$§£$§£$§£$§£¤¤¤');
    for (let i = 0; i < lesBlocs.length; i++) {
        const uneAffectation = lesBlocs[i].split('¤¤§£$§£$§£¤¤');
        const leDiv = document.getElementById(uneAffectation[0].trim());
        if (leDiv != null) {
            leDiv.innerHTML = uneAffectation[1].trim();
            ajouterClicEventPourCharge(leDiv);
            ajouterClicEventPourSupprimerCharge(leDiv);
            ajouterBlurEventPourCharge(leDiv);
            ajouterChangeEventPourCharge(leDiv);

        }
    }
}
function ajouterClicEventPourCharge(baseDOM) {
    let lesElements = baseDOM.getElementsByClassName("ajouter_une_charge");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            bfmw_jx("?",function(reponse){
                formatCharge(reponse)
            },function(){

            },"POST","ajoutercharge=1&id="+this.dataset.bfmw);
            return false;
        };
    }
}
function ajouterClicEventPourSupprimerCharge(baseDOM) {
    let lesElements = baseDOM.getElementsByClassName("confirm_supress_charge");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            if (confirm("Voulez-vous vraiment supprimer cette charge ?")) {
                bfmw_jx("?", function (reponse) {
                    formatCharge(reponse)
                }, function () {

                }, "POST", "supprimercharge=1&id=" + this.dataset.bfmw +"&charge=" + this.dataset.bfmw2);
            }
            return false;
        };
    }
}

function ajouterBlurEventPourCharge(baseDOM) {
    let lesElements = baseDOM.getElementsByClassName("bind_charge");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            autoLogOut();
            var element = this;
            bind('opzieruxczenuxrazerx', this.value, this.dataset.bfmw, this, this, function () {
                refreshComputeTD();
                computeEqTDEnsMat(document.getElementById("id_a").value,element.dataset.bfmw3,element.dataset.bfmw2,document.getElementById("charge_"+element.dataset.bfmw3+"_"+element.dataset.bfmw2));
            });
        };
    }
}
function ajouterChangeEventPourCharge(baseDOM) {
    let lesElements = baseDOM.getElementsByClassName("bind_charge2");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onchange = function () {
            autoLogOut();
            var element = this;
            bind('opzieruxczenuxrazerx', this.value, this.dataset.bfmw, this, this, function () {
                refreshComputeTD();
                computeEqTDEnsMat(document.getElementById("id_a").value,element.dataset.bfmw3,element.dataset.bfmw2,document.getElementById("charge_"+element.dataset.bfmw3+"_"+element.dataset.bfmw2));
            });
        };
    }
}
/*
INLINE
 */
toDoOnLoad(function () {
    var lesElements = document.getElementsByName("confirm_suppres_affectation");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            return confirm('Voulez-vous vraiment supprimer cette affectation ?');
        };
    }
});

toDoOnLoad(function () {
    document.getElementById("id_selection_annee").onchange = function() {
        document.location.href = "?p=gererenseignant&s="+this.dataset.bfmw+"&a="+this.value;
    }
});

toDoOnLoad(function () {
    document.getElementById("id_selection_semestre").onchange = function() {
        document.location.href = "?p=gererenseignant&a="+this.dataset.bfmw+"&s="+this.value;
    }
});

toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            bind('opzieruxczenuxrazerx', this.value, this.dataset.bfmw, this, this, null);
        };
    }
});

toDoOnLoad(function () {
    ajouterClicEventPourCharge(document);
});

toDoOnLoad(function () {
    bfmw_jx("?",function(reponse){
        formatCharge(reponse);
    },function(){

    },"POST","lazyLoad_charge=1&s="+document.getElementById("id_s").value+"&a="+document.getElementById("id_a").value);
});

toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind2");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            autoLogOut();
            var element = this;
            bind('opzieruxczenuxrazerx', this.value, this.dataset.bfmw, this, this, function () {
                refreshComputeTD();
                computeEqTDEnsMat(document.getElementById("id_a").value,element.dataset.bfmw3,element.dataset.bfmw2,document.getElementById("charge_"+element.dataset.bfmw3+"_"+element.dataset.bfmw2));
            });
        };
    }
});

toDoOnLoad(function () {
    refreshComputeTD();
    computeEqTDMat(document.getElementById("id_a").value,document.getElementById("id_s").value);
});