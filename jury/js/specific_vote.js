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
function checkVotes(comp,comp2){
    bfmw_jx("?checkvote=vote",function(reponse){
        let tab = reponse.split("¤**!!**¤");
        for (let i=0;i<tab.length;i=i+3) {
            if (tab[i] === "") {
                continue;
            }
            document.getElementById("vote_"+tab[i]).innerHTML = tab[i+2];
        }
        prepareVote();
    },null,"POST","j="+comp+"&f="+comp2);
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
    let comp1 = document.getElementById("data_comp1").value;
    let comp2 = document.getElementById("data_comp2").value;
    let comp3 = document.getElementById("data_comp3").value;
    checkVotesClots(comp3);
    setInterval(function() {
        // Vérification des votes en cours
        checkVotes(comp3,comp1);
    },2000);
    setInterval(function(){
        checkVotesClots(comp3);
    }, 5000);
});

toDoOnLoad(function () {
    let lesElements = document.getElementsByClassName("show_bilan");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            let et = this.dataset.bfmw;
            let an = this.dataset.bfmw2;
            let gr = this.dataset.bfmw3;
            document.getElementById("detail_" + et + gr).innerHTML = "<li><img alt='patientez' class='specific_img_vote_1' title='Chargement en cours' src='../bfmw/images/loading.gif'></li>";
            bfmw_jx("?show_bilan=vote", function (reponse) {
                document.getElementById("detail_" + et + gr).innerHTML = reponse;
                activateTreeView(document.getElementById("detail_treeview_" + et + gr),false);
                document.getElementById("detail_li_" + et + gr).classList.add("moins");
                document.getElementById("detail_li_" + et + gr).classList.remove("plus", "survol");
                activateAutoHider(document.getElementById("detail_" + et + gr));
            }, null, "POST", "e=" + et + "&a=" + an);
            return false;
        };
    }
});

toDoOnLoad(function () {
    let lesElements = document.getElementsByClassName("show_competences");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            let et = this.dataset.bfmw;
            let an = this.dataset.bfmw2;
            let gr = this.dataset.bfmw3;
            document.getElementById("competences_" + et + gr).innerHTML = "<li><img alt='patientez' class='specific_img_vote_1' title='Chargement en cours' src='../bfmw/images/loading.gif'></li>";
            bfmw_jx("?show_competences=vote", function (reponse) {
                document.getElementById("competences_" + et + gr).innerHTML = reponse;
                activateTreeView(document.getElementById("competences_treeview_" + et + gr),false);
                document.getElementById("competences_li_" + et + gr).classList.add("moins");
                document.getElementById("competences_li_" + et + gr).classList.remove("plus", "survol");
                activateAutoHider(document.getElementById("competences_" + et + gr));
            }, null, "POST", "e=" + et + "&a=" + an);
            return false;
        };
    }
});

toDoOnLoad(function () {
    let lesElements = document.getElementsByClassName("show_resume_matieres");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            autoLogOut();
            let et = this.dataset.bfmw;
            let an = this.dataset.bfmw2;
            let gr = this.dataset.bfmw3;
            document.getElementById("resume_matieres_" + et + gr).innerHTML = "<li><img alt='patientez' class='specific_img_vote_1' title='Chargement en cours' src='../bfmw/images/loading.gif'></li>";
            bfmw_jx("?show_resume_matieres=vote", function (reponse) {
                document.getElementById("resume_matieres_" + et + gr).innerHTML = reponse;
                activateTreeView(document.getElementById("competences_treeview_" + et + gr),false);
                document.getElementById("resume_matieres_li_" + et + gr).classList.add("moins");
                document.getElementById("resume_matieres_li_" + et + gr).classList.remove("plus", "survol");
                activateAutoHider(document.getElementById("resume_matieres_" + et + gr));
            }, null, "POST", "e=" + et + "&a=" + an);
            return false;
        };
    }
});