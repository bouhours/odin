<?php
/**
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

class WS_ADE extends Connectable
{
    private static $url = "https://wsadeplanning-odin.dsi.uca.fr";
    private static $version = "v7";

    private static function curl_init()
    {
        $ch = curl_init();
        $date = new DateTime();
        $token = md5(ADE_TOKEN . $date->format('m-d'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-AUTH-TOKEN: $token"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        return $ch;
    }

    /*
     * Concernant le niveau de détail, je viens de faire le nécessaire, et du coup il est différent en fonction de l'élèment =>


  api_ade_disconnect                     GET      ANY      ANY    /api/ade/{version}/idProjet/{idProjet}/disconnect.{_format}
  api_ade_get_resourcename               GET      ANY      ANY    /api/ade/{version}/idProjet/{idProjet}/resourcenames/{idResource}.{_format}
  api_ade_get_list_projects              GET      ANY      ANY    /api/ade/{version}/list/projects.{_format}
  api_ade_get_list_resources             GET      ANY      ANY    /api/ade/{version}/idProjet/{idProjet}/listResource/category/{category}/detail/{detail}.{_format}    (category => trainee | instructor | room )
  api_ade_get_activities                 GET      ANY      ANY    /api/ade/{version}/idProjet/{idProjet}/listActivities/detail/{detail}/idResources/{idResources}.{_format} (detail => 1 à 17)
  api_ade_get_activities                 GET      ANY      ANY    /api/ade/{version}/idProjet/{idProjet}/activity/{idActivity}/detail/{detail} (detail => 1 à 17)
  api_ade_get_events                     GET      ANY      ANY    /api/ade/{version}/idProjet/{idProjet}/listEvents/detail/{detail}/idResources/{idResources}.{_format}
  api_ade_get_fullname                   GET      ANY      ANY    /api/ade/{version}/idProjet/{idProjet}/fullnames/{idEnseignant}.{_format}
  api_ade_get_grade                      GET      ANY      ANY    /api/ade/{version}/idProjet/{idProjet}/grades/{idEnseignant}.{_format}
  api_ade_get_info_resource              GET      ANY      ANY    /api/ade/{version}/idProjet/{idProjet}/infoResource/category/{category}/detail/{detail}/idResource/{idResource}.{_format}
  api_ade_get_inforoom_type              GET      ANY      ANY    /api/ade/{version}/idProjet/{idProjet}/inforooms/{idRoom}/type/{type}.{_format}


Ressources =>
	- 1: id
	- 2: & name
	- 3: & category & path
	- 4: & isGroup
	- 5: & type
	- 6: & email
	- 7: & url
	- 8: & size
	- 9: & nb & nbEventsPlaced & durationInMinutes & firstWeek & firstDay & firstSlot & lastWeek & lastDay & lastSlot &
	creation & lastUpdate
	- 10: & fatherId & fatherName
	- 11: & color & code & address1 & address2 & zipCode & state & city & country & telephone & fax & timezone &
	jobCategory & manager & codeX & codeY & codeZ & info
	- 12: & rights & owner & levelAccess
	- 13 or 0: & contraints

Activités =>
	- 1: id
	- 2: & name
	- 3: & type & folderId
	- 4: & url
	- 5: & size
	- 6: & repetition
	- 7: & duration & nbEventsPlaced & durationInMinutes & firstWeek & firstDay & firstSlot & lastWeek & lastDay &
	lastSlot & creation & lastUpdate
	- 8: & email
	- 9: & color & code & timezone & codeX & codeY & codeZ & info & maxSeats & seatsLeft & weight
	- 10: & isActive
	- 11: & isNotSameDay
	- 12: & isGrouped
	- 13: & isAligned & isSuccessiveDay
	- 14: & rights & owner
	- 15: & resources
	- 16 or 0: & resource costs
	- 17: & events of the activity

Events =>
	- 1: id, activityId, externalId, session, repetition
	- 2: & name
	- 3: & week, day, slot, absoluteSlot, date, startHour, endHour
	- 4: & duration
	- 5: & color, note
	- 6: & isLockPosition
	- 7: & isLockResources & creation & lastUpdate
	- 8: & resources


     */

    public static function getEvenements(int $idProject, int $ens_code_ade, int $nbSemaines, bool $avec_passe = false, bool $avec_futur = true, bool $compute_groupes = false, bool $compute_enseignants = false, ?DateTime $start=null, ?DateTime $end=null) : ?array
    {
        $ch = self::curl_init();
        $complement_date = "";
        if ($start == null && $end == null) {
            if (!$avec_passe && !$avec_futur) {
                $aujourdhui = new DateTime();
                $complement_date = "?date=" . $aujourdhui->format("m/d/Y");;
            }
            if (!$avec_passe && $avec_futur) {
                $aujourdhui = new DateTime();
                $aujourdhui_start = $aujourdhui->format("m/d/Y");
                $aujourdhui->add(new DateInterval("P" . $nbSemaines . "W"));
                $aujourdhui_end = $aujourdhui->format("m/d/Y");
                $complement_date = "?startDate=" . $aujourdhui_start . "&endDate=" . $aujourdhui_end;
            }
            if ($avec_passe && !$avec_futur) {
                $aujourdhui = new DateTime();
                $aujourdhui_start = $aujourdhui->format("m/d/Y");
                $complement_date = "?endDate=" . $aujourdhui_start;
            }
        }
        if ($start != null && $end == null) {
            $aujourdhui_start = $start->format("m/d/Y");
            $start->add(new DateInterval("P" . $nbSemaines . "W"));
            $aujourdhui_end = $start->format("m/d/Y");
            $complement_date = "?startDate=" . $aujourdhui_start . "&endDate=" . $aujourdhui_end;
        }
        if ($start == null && $end != null) {
            $aujourdhui = new DateTime();
            $aujourdhui_start = $aujourdhui->format("m/d/Y");
            $aujourdhui_end = $end->format("m/d/Y");
            $complement_date = "?startDate=" . $aujourdhui_start . "&endDate=" . $aujourdhui_end;
        }
        if ($start != null && $end != null) {
            $aujourdhui_start = $start->format("m/d/Y");
            $aujourdhui_end = $end->format("m/d/Y");
            $complement_date = "?startDate=" . $aujourdhui_start . "&endDate=" . $aujourdhui_end;
        }


        curl_setopt($ch, CURLOPT_URL, self::$url."/api/ade/".self::$version."/idProjet/".$idProject."/listEvents/detail/8/idResources/".$ens_code_ade.$complement_date);
        $data = curl_exec($ch);
        if (curl_getinfo($ch,CURLINFO_RESPONSE_CODE) != 200) {
            //curl_close($ch);
            return null;
        }
        //curl_close($ch);
        try {
            $xml = new SimpleXMLElement($data);
            $retour = array();

            foreach ($xml->{'event'} as $resource) {
                $departements = array();
                $attributs = $resource->attributes();
                $enseignants = array();
                $salles = array();
                $groupes = array();
                foreach ($resource->{'resources'}->{'resource'} as $un_detail) {
                    $sous_attributs = $un_detail->attributes();
                    switch ($sous_attributs["category"]) {
                        case "instructor" :
                            if (!$compute_enseignants) {
                                $enseignants[] = $sous_attributs["id"][0];
                            } else {
                                $les_enseignants = Enseignants::getEnseigantAPartirDuCodeADE($sous_attributs["id"][0]);
                                if (isset($les_enseignants[0])) {
                                    $enseignants[] = $les_enseignants[0]["ENS_NOM"];
                                }
                                //$enseignants[] = ucwords(strtolower($sous_attributs["name"][0]));
                            }
                            break;
                        case "classroom" :
                            $salles[] = $sous_attributs["name"][0];
                            break;
                        case "trainee" :
                            if ($compute_groupes) {
                                $les_groupes = Groupes::getGroupesAPartirDuCodeADE($sous_attributs["id"][0]);
                                if (isset($les_groupes[0])) {
                                    $les_departements = Departements::getDepartementDuGroupe($les_groupes[0]["GROUPE_ID"]);
                                    if (isset($les_departements[0])) {
                                        $departements[$les_departements[0]["DEPT_ID"]] = $les_departements[0]["DEPT_NOM"];
                                    }
                                    $groupes[$les_groupes[0]["GROUPE_CODE"]] = $les_groupes[0]["GROUPE_NOM"];
                                }
                            } else {
                                $groupes[] = $sous_attributs["id"][0];
                            }
                            break;
                    }
                }

                ksort($groupes);
                sort($enseignants);

                $event = new WS_Event(
                    $attributs["id"][0],
                    $attributs["activityId"][0],
                    $attributs["name"][0],
                    transformDateHeureSepares($attributs["date"][0], $attributs["startHour"][0], ":"),
                    transformDateHeureSepares($attributs["date"][0], $attributs["endHour"][0], ":"),
                    $attributs["color"][0],
                    $enseignants,
                    $salles,
                    $groupes,
                    $departements
                );

                $retour[] = $event;
            }
            return $retour;
        } catch (Exception $e)
        {
            return null;
        }
    }

    public static function updateGroupes() : int
    {
        $ch = self::curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$url."/api/ade/".self::$version."/idProjet/".Edt::$current_project_id."/listResource/category/trainee/detail/4");
        $data = curl_exec($ch);
        //curl_close($ch);
        $createur = array();
        $retour = array();
        try {
            $xml = new SimpleXMLElement($data);
            foreach ($xml->{'category'} as $groupe) {
                self::descendreDansLesBranches($groupe,$retour);
                foreach ($retour as $un_element) {
                    $createur[] = array(
                        "*RES_ID" => $un_element["id"],
                        "*RES_NAME" => addslashes($un_element["name"]),
                        "*RES_PATH" => addslashes($un_element["path"]),
                        "*RES_LEAF" => $un_element["isGroup"]=="true"?0:1
                    );
                }
            }
        } catch (Exception $e) {
            echo $e->getTraceAsString();
        }
        manual_bfmw_secure($createur);
        $compteur = 0;
        foreach ($createur as $un_groupe) {
            $compteur++;
            createData("extraction_groupes_ade",$un_groupe,4);
        }
        return $compteur;
    }

    public static function updateExtractResAde()
    {
        $ch = self::curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$url."/api/ade/".self::$version."/idProjet/".Edt::$current_project_id."/listResource/category/instructor/detail/11");
        $data = curl_exec($ch);
        //curl_close($ch);
        $createur = array();
        $retour = array();
        $compteur = 0;
        try {
            $xml = new SimpleXMLElement($data);
            foreach ($xml->{'category'} as $enseignant) {
                self::descendreDansLesBranches($enseignant,$retour);
                foreach ($retour as $un_element) {
                    $createur[] = array(
                        "*EXTRACT_CODE" => $un_element["code"],
                        "*EXTRACT_NUMERO" => $un_element["id"]
                    );
                }
            }
            manual_bfmw_secure($createur);
            self::startTransaction();
            $req = "DELETE FROM extraction_res_ade";
            self::execRequete($req);
            foreach ($createur as $un_groupe) {
                $compteur++;
                createData("extraction_res_ade",$un_groupe,2);
            }
            self::commit();
        } catch (Exception $e) {
            echo $e->getTraceAsString();
            echo "<br/>";
            echo $data;
        }
        return $compteur;
    }

    private static function descendreDansLesBranches(SimpleXMLElement $data,array &$retour){
        foreach ($data->{'branch'} as $groupes) {
            self::descendreDansLesBranches($groupes,$retour);
        }
        foreach ($data->{'leaf'} as $groupes) {
            self::descendreDansLesBranches($groupes,$retour);
        }

        $attributs = $data->attributes();
        if (count($attributs) > 0) {
            $retour[] = $attributs;
        }

    }

    public static function getDetailActivite(int $idProject,int $activityId) : ?array {
        $ch = self::curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$url."/api/ade/".self::$version."/idProjet/".$idProject."/activity/$activityId/detail/9");
        $data = curl_exec($ch);
        if (curl_getinfo($ch,CURLINFO_RESPONSE_CODE) != 200) {
            //curl_close($ch);
            return null;
        }
        //curl_close($ch);
        try {
            $xml = new SimpleXMLElement($data);
            $retour = array();

            foreach ($xml->{'activity'} as $activity) {
                $attributs = $activity->attributes();
                if ($attributs["id"] == $activityId) {
                    $retour[] = array(
                        "id" => $attributs["id"],
                        "name" => $attributs["name"],
                        "type" => $attributs["type"],
                        "code" => $attributs["code"]
                    );
                }
            }
            return $retour;
        } catch (Exception $e)
        {
            return null;
        }
    }
}
