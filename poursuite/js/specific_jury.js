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
function autoupdate(annee, groupe, categorie){
    bfmw_jx("?exit=bind&getAvis=" + annee + "&groupe=" + groupe + "&categorie=" + categorie, function (texte) {
        if (texte !== "KO") {
            let sections = texte.split("¤**!!**¤");
            let lesEtudiants = sections[0].split("¤**¤");
            for (let i = 0; i < lesEtudiants.length; i++) {
                let lesElements = lesEtudiants[i].split("¤");
                let caseAMettreAJour = document.getElementById("id_avis_" + lesElements[0]);
                if (caseAMettreAJour != null) {
                    caseAMettreAJour.innerHTML = lesElements[1];
                }
                caseAMettreAJour = document.getElementById("id_appreciation_" + lesElements[0]);
                if (caseAMettreAJour != null) {
                    caseAMettreAJour.innerHTML = lesElements[2];
                }
            }
            let casesAMettreAJour = document.getElementsByClassName("computed_total");
            for (let i = 0; i < casesAMettreAJour.length; i++) {
                casesAMettreAJour[i].innerHTML = sections[1]
            }
        }
    }, null, "POST", "");
}

function checkVotes(comp){
    bfmw_jx("?checkvote=vote",function(reponse){
        let tab = reponse.split("¤**!!**¤");
        for (let i=0;i<tab.length;i=i+3) {
            if (tab[i] === "") {
                continue;
            }
            document.getElementById("vote_"+tab[i]).innerHTML = tab[i+2];
        }
        prepareVote();
    },null,"POST","j="+comp);
}
function checkVotesClots(comp){
    bfmw_jx("?checkvoteclot=vote",function(reponse){
        let tab = reponse.split("¤**!!**¤");
        for (let i=0;i<tab.length;i=i+2) {
            if (tab[i] === "") {
                continue;
            }
            document.getElementById("a_vote_"+tab[i]).innerHTML = tab[i+1];
        }
        prepareVote();
    },null,"POST","j="+comp);
}
function prepareVote(){
    lesElements = document.getElementsByClassName("vote");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            let vote = this.dataset.bfmw;
            bind('qsdhgfqksbhdfgqsdfmxqnuxsgd', this.value, this.dataset.bfmw, this, null, function() {
                document.getElementById("en_cours_de_sauvegarde_" + vote).innerText = "Vote en cours d'enregistrement...";
            }, null);
            return false;
        };
    }
}

/*
INLINE
 */
toDoOnLoad(function () {
   setInterval(function() {
       lesElements = document.getElementsByClassName("lazyload_bilan");
       for ( i = 0; i < lesElements.length; i++) {
           autoupdate(lesElements[i].dataset.bfmw2, lesElements[i].dataset.bfmw3, lesElements[i].dataset.bfmw4);
           break;
       }
    },5000);
});

toDoOnLoad(function () {
    let lesElements = document.getElementsByClassName("bind2");
    for ( i = 0; i < lesElements.length; i++) {
        lesElements[i].onblur = function () {
            bind('eytudsfghqfdfg', this.value, this.dataset.bfmw+"$"+this.dataset.bfmw2, this, this, null);
        };
    }

    document.getElementById("id_selecteur_groupe").onchange = function () {
        window.location.href = '?p=jury&g=' + this.value + '&categ=' + this.dataset.bfmw;
    };

    setTimeout(function(){
        let lesElements = document.getElementsByClassName("lazyload_bilan");
        for ( let i = 0; i < lesElements.length; i++) {
            let et_id = lesElements[i].dataset.bfmw;
            if (i === lesElements.length-1) {
                autoupdate(lesElements[i].dataset.bfmw2, lesElements[i].dataset.bfmw3, lesElements[i].dataset.bfmw4);
            }
            bfmw_jx("?exit=bind&lazyLoad_bilan="+et_id+"&a="+lesElements[i].dataset.bfmw2, function(texte){
                if (texte !== "KO") {
                    let destinataire = document.getElementById("lazyload_bilan_" + et_id);
                    if (destinataire != null) {
                        destinataire.innerHTML = texte;
                    }
                }
            }, null, "POST", "");
            bfmw_jx("?exit=bind&lazyLoad_absences="+et_id, function(texte){
                if (texte !== "KO") {
                    let destinataire = document.getElementById("lazyLoad_absences_" + et_id);
                    if (destinataire != null) {
                        destinataire.innerHTML = texte;
                    }
                }
            }, null, "POST", "");
        }
        bfmw_jx("?exit=bind&lazyLoad_avis_modele=0", function(texte){
            if (texte !== "KO") {
                lesElements = document.getElementsByClassName("lazyload_modele");
                for ( i = 0; i < lesElements.length; i++) {
                    lesElements[i].innerHTML = texte;
                }
            }
        }, null, "POST", "");
    },1000);

});
toDoOnLoad(function () {
    let comp1 = document.getElementById("data_comp1").value;
    checkVotesClots(comp1);
    setInterval(function() {
        // Vérification des votes en cours
        checkVotes(comp1);
    },2000);
    setInterval(function(){
        checkVotesClots(comp1);
    }, 5000);
});
