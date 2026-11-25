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

/*--------------------------------------------*/
/*!
* Signature Pad v3.0.0-beta.3 | https://github.com/szimek/signature_pad
* (c) 2018 Szymon Nowak | Released under the MIT license
*/



/*
Fonctions
 */
include('../bfmw/js/signature_v2.js');
/*
INLINE
 */
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("do_sign");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            if (this.dataset.bfmw6 > 0) {
                showSpecificDoSign(this.dataset.bfmw, this.dataset.bfmw2, this.dataset.bfmw3, this.dataset.bfmw4, false, this.dataset.bfmw5, this.dataset.bfmw6);
            }
        };
    }
});

toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("do_del");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function(){
            let element = this;
            showConfirm("Suppression de signature","Voulez-vous vraiment supprimer cette signature ?",true,function() {
                var params = "u=" + element.dataset.bfmw + "&g=" + element.dataset.bfmw2 + "&del=" + element.dataset.bfmw3;
                var id = element.dataset.bfmw3;
                bfmw_jx("?do_del=1", function (texte) {
                    if (texte === "OK") {
                        var lesToHide = document.getElementsByClassName("to_hide_" + id);
                        for (var j = 0; j < lesToHide.length; j++) {
                            lesToHide[j].classList.add("hide");
                        }
                        var lesToShow = document.getElementsByClassName("to_show_" + id);
                        for (j = 0; j < lesToShow.length; j++) {
                            lesToShow[j].classList.remove("hide");
                        }
                        let compteur = document.getElementById("compteur").innerText - 1;
                        document.getElementById("compteur").innerText = compteur;
                    } else {
                        showMessage("", "Suppression d'une signature", "Impossible de supprimer la signature.");
                    }
                }, null, "POST", params);
            })

            return false;
        };
    }
});