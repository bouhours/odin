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
            ajouterChangeEventPourAjouterIntervenant(leDiv);
            ajouterClicEventPourAjouterUnEnseignantExistant(leDiv);
        }
    }
}
function ajouterClicEventPourCharge(baseDOM) {
    let lesElements = baseDOM.getElementsByClassName("ajouter_une_charge");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            let element = this;
            bfmw_jx("?",function(reponse){
                formatCharge(reponse);
            },function(){

            },"POST","ajoutercharge=1&id="+this.dataset.bfmw+ "&m=" + this.dataset.bfmw2 + "&f="+document.getElementById("id_selection_annee").dataset.bfmw+"&a="+document.getElementById("id_selection_formation").dataset.bfmw);
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
                let element = this;
                bfmw_jx("?", function (reponse) {
                    formatCharge(reponse)
                    computeEqTDMat(document.getElementById("id_selection_formation").dataset.bfmw,element.dataset.bfmw3,document.getElementById("charge_"+element.dataset.bfmw3));
                }, function () {

                }, "POST", "supprimercharge=1&id=" + this.dataset.bfmw +"&charge=" + this.dataset.bfmw2 + "&f="+document.getElementById("id_selection_annee").dataset.bfmw+"&a="+document.getElementById("id_selection_formation").dataset.bfmw);
            }
            return false;
        };
    }

    lesElements = baseDOM.getElementsByClassName("confirm_supress_enseignant");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            if (confirm("Voulez-vous vraiment supprimer cet enseignant de la matière ?")) {
                let element = this;
                bfmw_jx("?", function (reponse) {
                    formatCharge(reponse)
                    computeEqTDMat(document.getElementById("id_selection_formation").dataset.bfmw,element.dataset.bfmw2,document.getElementById("charge_"+element.dataset.bfmw2));
                }, function () {

                }, "POST", "supprimerenseignant=1&id=" + this.dataset.bfmw + "&m=" + this.dataset.bfmw2 + "&f="+document.getElementById("id_selection_annee").dataset.bfmw+"&a="+document.getElementById("id_selection_formation").dataset.bfmw);
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
                //refreshComputeTD();
                computeEqTDMat(document.getElementById("id_selection_formation").dataset.bfmw,element.dataset.bfmw2,document.getElementById("charge_"+element.dataset.bfmw2));
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
                //refreshComputeTD();
                computeEqTDMat(document.getElementById("id_selection_formation").dataset.bfmw,element.dataset.bfmw2,document.getElementById("charge_"+element.dataset.bfmw2));
            });
        };
    }
}
function ajouterChangeEventPourAjouterIntervenant(baseDOM) {
    let lesElements = baseDOM.getElementsByClassName("ajouter_un_enseignant");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            let element = document.getElementById("ajouter_"+this.dataset.bfmw);
            if (element != null) {
                element.classList.remove("hide");
            }
            return false;
        };
    }
}
function ajouterClicEventPourAjouterUnEnseignantExistant(baseDOM) {
    let lesElements = baseDOM.getElementsByClassName("formulaire_ajout_enseignant_existant");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onsubmit = function () {
            autoLogOut();
            let element = this;
            bfmw_jx("?",function(reponse){
                formatCharge(reponse);
            },function(){

            },"POST","ajouterenseignantexistant=1&value="+this['a_ajouter'].value+ "&m=" + this.dataset.bfmw + "&f="+document.getElementById("id_selection_annee").dataset.bfmw+"&a="+document.getElementById("id_selection_formation").dataset.bfmw);
            return false;
        };
    }
}
function computeEqTDMat(annee,mat,container) {
    bfmw_jx("?",function(reponse){
        container.innerHTML = reponse;
    },function(){
        container.innerHTML = 0;
    },"POST","computetdensmat=1&a="+annee+"&m="+mat);
}
function computeEqTDToutesMat(annee,formation) {
    bfmw_jx("?",function(reponse){
        var data = JSON.parse(reponse);
        for (var i = 0; i < data.infos.length; i++) {
            var element = document.getElementById("charge_" + data.infos[i].MAT_ID);
            if (element != null) {
                element.innerHTML = data.infos[i].TOTAL;
            }
        }
    },function(){

    },"POST","computeetdtoutesmat=1&a="+annee+"&f="+formation);
}
/*
INLINE
 */
toDoOnLoad(function () {
    document.getElementById("id_selection_annee").onchange = function() {
        document.location.href = "?p=equipe&a="+this.value+"&f="+this.dataset.bfmw;
    }
    document.getElementById("id_selection_formation").onchange = function() {
        document.location.href = "?p=equipe&f="+this.value+"&a="+this.dataset.bfmw;
    }
    computeEqTDToutesMat(document.getElementById("id_selection_formation").dataset.bfmw,document.getElementById("id_selection_annee").dataset.bfmw)
});

toDoOnLoad(function () {
    bfmw_jx("?",function(reponse){
        formatCharge(reponse);
    },function(){

    },"POST","lazyLoad_charge=1&f="+document.getElementById("id_selection_annee").dataset.bfmw+"&a="+document.getElementById("id_selection_formation").dataset.bfmw);
});