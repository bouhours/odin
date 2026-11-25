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
    document.getElementById("id_selection_annee").onchange = function() {
        document.location.href = "?p=gererinscriptions&a="+this.value;
    }
});
toDoOnLoad(function () {
    document.getElementById("numero_temporaire").onblur = function() {
        let me = this;
        let xhttp;
        if (window.XMLHttpRequest) {
            xhttp = new XMLHttpRequest();
        } else {
            xhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xhttp.open("POST", "index.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("search=temporaire&valeur=" + encodeURIComponent(this.value));
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                let resultat = document.getElementById('erreur_temporaire');
                if (xhttp.responseText === "KO") {
                    resultat.classList.remove("hide");
                    me.classList.add("specific_div_gererinscriptions_2");
                }else {
                    resultat.classList.add("hide");
                    me.classList.remove("specific_div_gererinscriptions_2");
                }
            }
        };
    }
});
toDoOnLoad(function () {
    document.getElementById("inscription_manuelle").onkeyup = function() {
        if (this.value.length > 2) {
            let xhttp;
            if (window.XMLHttpRequest) {
                xhttp = new XMLHttpRequest();
            } else {
                xhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }

            xhttp.open("POST", "index.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("search=etudiants&valeur=" + encodeURIComponent(this.value));
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState === 4 && xhttp.status === 200) {
                    let resultat = document.getElementById('resultats');
                    if (xhttp.responseText !== "KO") {
                        resultat.classList.remove("hide");
                        resultat.innerHTML = xhttp.responseText;
                        let leSemestre = document.getElementById("selecteur_semestre");
                        let lesElements = document.getElementsByClassName("auto_inscription");
                        for (let i = 0; i < lesElements.length; i++) {
                            lesElements[i].onclick = function () {
                                location.href = '?p=front&p2=gererinscriptions&auto=auto&s='+leSemestre.value+'&n='+lesElements[i].dataset.bfmw+'&a='+resultat.dataset.bfmw;
                            }
                        }
                    }else {
                        resultat.classList.add("hide");
                    }
                }
            };
        } else {
            let resultat = document.getElementById('resultats');
            resultat.classList.add("hide");
        }
    }
});
toDoOnLoad(function () {
    let lesElements = document.getElementsByClassName("synchro");
    for (let i = 0; i < lesElements.length; i++) {
        lesElements[i].onscroll = function () {
            let leFrere= null;
            if (this.id === "x_"+this.dataset.bfmw) {
                leFrere = document.getElementById("y_" + this.dataset.bfmw);
            } else {
                leFrere = document.getElementById("x_" + this.dataset.bfmw);
            }
            autoLogOut();
            if (leFrere.scrollTop !== this.scrollTop) {
                leFrere.scrollTop = this.scrollTop;
            }
        };
    }
});