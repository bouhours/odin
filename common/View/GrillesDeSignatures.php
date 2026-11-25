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

class GrillesDeSignatures extends Connectable
{
    public static function showGrilleEtudiant(array $les_etudiants, Template &$template, string $edt_uid, ?array &$groupe_id = null) {
        foreach ($les_etudiants as $un_etudiant) {
            if ($groupe_id != null) {
                $groupe_id[] = $un_etudiant['GROUPE_ID'];
            }

            if (($un_etudiant['ET_ID'] != CURRENT_ID) && (CURRENT_ID != -1 || $_SESSION['signatures_nom'] != "Tablette Odin")) {
                continue;
            }

            if (Absences_Automatiques::isCreneauDejaSigne($un_etudiant['ET_ID'],$un_etudiant['GROUPE_ID'],$edt_uid)) {
                $un_etudiant['HAS_SIGNED'] = true;
            } else {
                $un_etudiant['HAS_SIGNED'] = false;
            }

            $un_etudiant['EDT_UID'] = $edt_uid;
            affectToBloc($template, "un_etudiant", $un_etudiant);
        }
    }

    public static function showGrilleEnseignant(array $les_etudiants, Template &$template, int $mat_id, int $annee_courante, int $form_id, ?array &$groupe_id = null) : int {
        $les_etudiants_passes = array();
        //$la_formation = Formations::getFormation($form_id)[$form_id];
        $les_semestres = Formations::getSemestres($form_id,$annee_courante);
        $les_etudiants_autorises[] = -1;
        foreach ($les_semestres as $un_semestre) {
            $les_etudiants_autorises = array_merge($les_etudiants_autorises,array_keys(Etudiants::getEtudiantsInscritsAuSemestre($un_semestre["SEM_ID"],$annee_courante)));
        }
        $les_id_des_etudiants_autorises = array_values($les_etudiants_autorises);
        $nombre_signatures = 0;
        foreach ($les_etudiants as $un_etudiant) {
            if (! in_array($un_etudiant['ET_ID'],$les_id_des_etudiants_autorises)) {
                continue;
            }
            /*if ($la_formation["FORM_PRO"] == 1 && $un_etudiant["GROUPE_PRO"] == 0) {
                continue;
            }*/
            if ($groupe_id != null) {
                $groupe_id[] = $un_etudiant['GROUPE_ID'];
            }

            if (isset($les_etudiants_passes[$un_etudiant['ET_ID']])){
                continue;
            } else {
                $les_etudiants_passes[$un_etudiant['ET_ID']] = "0";
            }

            if (Etudiants::isDispense($un_etudiant['ET_ID'],$annee_courante,$mat_id)) {
                continue;
            }

            $table = Groupes::isPro($un_etudiant['GROUPE_ID'])?"common_pro_signatures":"common_absences_signatures";
            $req = "SELECT * FROM $table WHERE SIGNATURE_ET_ID=" . $un_etudiant['ET_ID'] . " AND SIGNATURE_EDT_UID='" . $_POST['bfmw_orig_d'] . "'";
            $resSIGNATURE = self::doRequete($req);
            if ($resSIGNATURE->num_rows > 0) {
                $nombre_signatures++;
                $une_signature = $resSIGNATURE->fetch_assoc();
                $un_etudiant['HAS_SIGNED'] = true;
                $un_etudiant['SIGNATURE_EDT_UID'] = $une_signature['SIGNATURE_EDT_UID'];
                $un_etudiant['SIGNATURE_GROUPE_ID'] = $une_signature['SIGNATURE_GROUPE_ID'];
                $un_etudiant['SIGNATURE_ET_ID'] = $une_signature['SIGNATURE_ET_ID'];
                $un_etudiant['SIGNATURE_ID'] = $une_signature['SIGNATURE_ID'];
                try {
                    $un_etudiant['SIGNATURE'] = gzuncompress(base64_decode($une_signature['SIGNATURE']));
                } catch (Exception $e) {
                    $un_etudiant['SIGNATURE'] = base64_decode($une_signature['SIGNATURE']??"");
                }
            } else {
                $un_etudiant['HAS_SIGNED'] = false;
            }
            affectToBloc($template, "un_etudiant", $un_etudiant);
        }
        return $nombre_signatures;
    }
}