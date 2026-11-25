<?php
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
header("Content-Type:text/plain; charset=utf-8");

if(isset($_GET['toto']))
{
    require_once __DIR__."/../../self_server_concrete.php";
    require_once __DIR__."/../../../bfmw/includes/Connectable.php";
    require_once __DIR__."/../../../bfmw/includes/functions.php";
    require_once __DIR__."/../../../common/Model/Edt.php";
    $conn = openConnexion($db_server,$db_user,$db_pwd,$db_database);
    Edt::static_init($conn);
    require_once __DIR__."/../../../common/Model/WS_ADE.php";
    WS_ADE::static_init($conn);
    require_once __DIR__."/../../../common/Model/Enseignants.php";
    WS_ADE::static_init($conn);
    require_once __DIR__."/../../../common/Model/WS_Event.php";
    require_once __DIR__."/../../../common/Model/Annees.php";
    Annees::static_init($conn);

    $annee_courante = Annees::getIdAnneeCourante();
    $req = "SELECT GROUPE_ADE,GROUPE_NOM FROM etudiants_groupes,common_formation WHERE ET_GROUPE_ANNEE_ID=$annee_courante AND FORM_ID=GROUPE_FORM_ID AND FORM_DEPT_ID=1 AND GROUPE_ADE IS NOT NULL GROUP BY GROUPE_ID";
    $res = $conn->query($req);
    $les_resources = array();
    $retour = "";
    while ($un_groupe = $res->fetch_assoc()) {
        $event_affiche = array();
        if (!Edt::collectEDTv2(Edt::$current_project_id,array($un_groupe['GROUPE_ADE']),$event_affiche,1,false,true,false,true)) {
            response(400,"ADE not responding. Try again",NULL);
        }
        //Edt::collectEDT("http://edt.uca.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources=" . $un_groupe['GROUPE_ADE'] . "&projectId=".Edt::$current_project_id."&nbWeeks=1&calType=ical",$event_affiche);

        foreach ($event_affiche as $un_event) {
            $retour .= date('l',$un_event['REAL_DATE_DEBUT']).";";
            $retour .= $un_event["DATE_DEBUT"].";";
            $retour .= str_replace(" ","",$un_groupe["GROUPE_NOM"]).";";
            //$retour .= str_replace(" ","",$un_event["SALLE"])." ";
            $retour .= $un_event["HEURE_DEBUT"].";";
            $retour .= $un_event["HEURE_FIN"].";";
            $retour .= (($un_event["REAL_DATE_FIN"]-$un_event["REAL_DATE_DEBUT"])/60).";";
            $retour .= $un_event["ENSEIGNANTS"].";";
            $retour .= $un_event["NOM"]."";
            $retour .= "\n";
        }

    }
    if($retour === "")
    {
        response(200,"Rien à rendre",NULL);
    }
    else
    {
        response(200,"",$retour);
    }

}
else
{
    response(400,"Invalid Request",NULL);
}

function response($status,$status_message,$data)
{
    header("HTTP/1.1 ".$status);

    echo $status_message;
    echo $data;
}
