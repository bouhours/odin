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
function compter() {
    var param = "s="+document.getElementById("id_selecteur").value;
    bfmw_jx("?count=disponibilites",function(resultat){
        tab = resultat.split("$");
        document.getElementById("id_nombre").innerText = tab[0];
        document.getElementById("id_coches").innerText = tab[1];
    },null,"post",param);
}

function cacher(me) {
    leDiv = document.getElementById(me.dataset.bfmw);
    if (leDiv != null) {
        if (me.checked) {
            leDiv.classList.remove("force_hide");
        } else {
            leDiv.classList.add("force_hide");
        }
    }
}
/*
INLINE
 */
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            var me = this;
            bind('iserytfbzoerudtyzpbncfyozhrbt', this.value, this.dataset.bfmw, this, this, function(){
                compter();
                cacher(me);
            }, function(){
                me.checked = !me.checked;
            });
        };
    }
});
toDoOnLoad(function () {
    var lesElements = document.getElementsByClassName("bind2");
    for (var i = 0; i < lesElements.length; i++) {
        lesElements[i].onclick = function () {
            var me = this;
            bind('iserytfbzoerudtyzpbncfyozhrbt', this.value, this.dataset.bfmw, this, this, null, function(){
                me.checked = !me.checked;
            });
        };
    }
});

toDoOnLoad(function () {
    compter();
    var lesElements = document.getElementsByClassName("tohide");
    for (var i = 0; i < lesElements.length; i++) {
        cacher(lesElements[i]);
    }
});