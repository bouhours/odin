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

class Signatures extends Connectable
{
    public static function executeSignature(int $et_id, int $ens_id, string $groupe_id, string $edt_uid): bool
    {
        /*if (!Formations::isResponsable() && !Formations::isSecretaire()) {
            if (preg_match(PATTERN_SIGNATURE, $_SERVER['HTTP_USER_AGENT']) !== 1) {
                die("Vous ne pouvez pas signer avec ce support. Utilisez les tablettes ARCHOS.");
            }
        }*/

        $tab = explode("$", $groupe_id);
        if (count($tab) == 0) {
            $tab[] = $groupe_id;
        }

        if (array_search(-1, $tab) !== false) {
            unset($tab[array_search(-1, $tab)]);
        }

        if ($et_id != 0 && $ens_id == 0) {
            $les_signatures = Absences_Automatiques::getSignaturesPourUnEtudiant(CURRENT_ID, implode(",", $tab), $edt_uid);
            return (count($les_signatures) == 0);
        }
        if ($et_id == 0 && $ens_id != 0) {
            $les_signatures = Absences_Automatiques::getSignaturesPourUnEnseignant($ens_id, implode(",", $tab), $edt_uid);
            return (count($les_signatures) != count($tab));
        }
        return false;
    }

    public static function isSigneeParEnseignant(string $edt_uid, string $groupe_id) : bool {
        $tab = explode("$", $groupe_id);
        if (count($tab) == 0) {
            $tab[] = $groupe_id;
        }

        $retour = false;
        foreach ($tab as $un_groupe) {
            $table = Groupes::isPro($un_groupe) ? "common_pro_signatures" : "common_absences_signatures";
            $req = "SELECT *
                FROM $table
                WHERE SIGNATURE_EDT_UID = '$edt_uid'
                AND SIGNATURE_ENS_ID IS NOT NULL AND SIGNATURE_GROUPE_ID = $un_groupe
            ";
            $retour |= count(self::getRequete($req)) > 0;
        }

        return $retour;
    }

    public static function enregistrerSignature(int $et_id, int $ens_id, string $data_signature, string $groupes_id, string $edt_uid, int $mat_id = -1): void
    {
        if (!Formations::isSecretaire() && !Formations::isResponsable() && !Formations::isChef() && !Formations::isGestionnaireDeStage(CURRENT_ID,CURRENT_DEPT_ID)) {
            if ($et_id != 0) {
                try {
                    $deja_signee = self::isSigneeParEnseignant($edt_uid, $groupes_id);
                    if ($deja_signee) {
                        $aujourdhui = new DateTime();
                        try {
                            sendMail("cedric.bouhours@uca.fr", "HACK PLANCHON", "
                        CURRENT_ID : " . CURRENT_ID . "\n
                        SIGNATURE ENREGISTREE LE " . time() . "\n
                        ID SIGNATAIRE : $et_id \n
                        NOM SIGNATAIRE : " . Etudiants::getEtudiant($et_id, Annees::getIdAnneeCourante())[0]["ET_NOM"] . "\n
                        FORMAT : " . $aujourdhui->format("d/m/Y H:i:s") . "\n
                        ADRESSE : " . $_SERVER['REMOTE_ADDR'] . "\n
                        COURS ID : $edt_uid\n
                        DEJA SIGNE : " . ($deja_signee ? "Oui" : "Non") . "\n
                        ");
                        } catch (Exception $e) {
                            sendMail("cedric.bouhours@uca.fr", "HACK PLANCHON", "
                        CURRENT_ID : " . CURRENT_ID . "\n
                        SIGNATURE ENREGISTREE LE " . time() . "\n
                        ID SIGNATAIRE : $et_id \n
                        FORMAT : " . $aujourdhui->format("d/m/Y H:i:s") . "\n
                        ADRESSE : " . $_SERVER['REMOTE_ADDR'] . "\n
                        COURS ID : $edt_uid\n
                        DEJA SIGNE : " . ($deja_signee ? "Oui" : "Non") . "\n
                        ");
                        }
                        mysql_rollback();
                        echo "Vous essayez de signer après l'enseignant. Ce n'est pas possible.";
                        return;
                    }
                } catch (Exception $e) {
                    sendMail("cedric.bouhours@uca.fr", "HACK PLANCHON", "
                        CURRENT_ID : " . CURRENT_ID . "\n
                        SIGNATURE ENREGISTREE LE " . time() . "\n
                        ID SIGNATAIRE : $et_id \n
                        FORMAT : " . $aujourdhui->format("d/m/Y H:i:s") . "\n
                        ADRESSE : " . $_SERVER['REMOTE_ADDR'] . "\n
                        COURS ID : $edt_uid\n
                        ");
                    mysql_rollback();
                    echo "Vous essayez de signer après l'enseignant. Ce n'est pas possible.";
                    return;
                }
            }
        }



        $signature = base64_decode(strtr($data_signature, ' ', '+'), true);
        if ($signature === false) {
            echo "Erreur lors de la transmission de la signature (erreur #8745). Rententez de valider.";
        } else {
            $tab = explode("$", $groupes_id);
            if (count($tab) == 0) {
                $tab[] = $groupes_id;
            }

            $validation = false;
            mysql_start_transaction();
            foreach ($tab as $groupe_id) {
                if ($groupe_id == -1) {
                    continue;
                }
                $tosave['*SIGNATURE_EDT_UID'] = $edt_uid;
                $mem_abs = false;
                if ($et_id == 0 && $ens_id != 0) {
                    $tosave['*SIGNATURE_ENS_ID'] = $ens_id;
                    $mem_abs = true;
                }
                if ($et_id != 0 && $ens_id == 0) {
                    $tosave['*SIGNATURE_ET_ID'] = $et_id;
                }
                $tosave['*SIGNATURE'] = base64_encode(gzcompress($signature, 9));
                $tosave['*SIGNATURE_GROUPE_ID'] = $groupe_id;
                if ($mat_id == -1) {
                    $tosave['*SIGNATURE_MAT_ID'] = "NULL";
                } else {
                    $tosave['*SIGNATURE_MAT_ID'] = $mat_id;
                }

                $data = array($tosave);
                manual_bfmw_secure($data);
                $id = createData(Groupes::isPro($groupe_id) ? "common_pro_signatures" : "common_absences_signatures", $data[0], 5);
                if ($id > 0) {
                    $validation = true;
                    if ($mem_abs) {
                        Absences_Automatiques::insererAbsenceAutomatiquement(Annees::getIdAnneeCourante(), $edt_uid, $groupe_id, $ens_id, $mat_id);
                    } else {
                        Absences::supprimerAbsence(null, $edt_uid, $et_id);
                    }
                } else {
                    continue;
                }
            }
            if ($validation) {
                echo "ok";
                mysql_commit();
            } else {
                mysql_rollback();
                echo "Erreur lors de l'enregistrement de la signature (erreur #8254). Retentez de valider.";
            }
        }
    }

    public static function getFicheEmargementSansSignatureDeLEnseignant(string $groupes, int $annee_courante, int $start = -1, int $end = -1): array
    {
        $date = "";
        if ($start != -1) {
            $date = "AND common_backup_ade_enseignant.EDT_DATE_DEBUT >= $start ";
        }
        if ($end != -1) {
            $date .= "AND common_backup_ade_enseignant.EDT_DATE_FIN <= $end ";
        }

        $req = "SELECT common_backup_ade_enseignant.EDT_NOM,common_backup_ade_enseignant.EDT_UID,ENS_NOM, ENS_ID,
                    DATE_FORMAT(FROM_UNIXTIME(common_backup_ade_enseignant.EDT_DATE_DEBUT),'%d/%m/%Y') AS DEBUT,
                    DATE_FORMAT(FROM_UNIXTIME(common_backup_ade_enseignant.EDT_DATE_FIN),'%d/%m/%Y') AS FIN,
                    DATE_FORMAT(FROM_UNIXTIME(common_backup_ade_enseignant.EDT_HEURE_DEBUT),'%Hh%i') AS HORAIRE_START,
                    DATE_FORMAT(FROM_UNIXTIME(common_backup_ade_enseignant.EDT_HEURE_FIN),'%Hh%i') AS HORAIRE_END,
                    SUM(IF(common_pro_signatures.SIGNATURE_ENS_ID IS NOT NULL,1,0)) AS TOTAL_PRO,
                    SUM(IF(common_absences_signatures.SIGNATURE_ENS_ID IS NOT NULL,1,0)) AS TOTAL_ABS
                    FROM common_backup_ade_etudiant
                        JOIN common_backup_ade_enseignant ON (common_backup_ade_etudiant.EDT_UID=common_backup_ade_enseignant.EDT_UID)
                        LEFT JOIN common_pro_signatures ON (common_pro_signatures.SIGNATURE_EDT_UID=common_backup_ade_etudiant.EDT_UID)
                        LEFT JOIN common_absences_signatures ON (common_absences_signatures.SIGNATURE_EDT_UID=common_backup_ade_etudiant.EDT_UID)
                        LEFT JOIN common_enseignant ON (ENS_ID = EDT_ENS_ID)
                        LEFT JOIN common_backup_ade_enseignant_nonfacture ON (common_backup_ade_enseignant.EDT_UID=NONFACTURE_EDT_UID)
                    WHERE common_backup_ade_etudiant.EDT_UID=common_backup_ade_enseignant.EDT_UID
                    AND EDT_GROUPE_ID IN ($groupes) AND NONFACTURE_EDT_UID IS NULL AND common_backup_ade_enseignant.EDT_ANNEE_ID=$annee_courante
                    $date
                    GROUP BY common_backup_ade_enseignant.EDT_UID HAVING TOTAL_PRO + TOTAL_ABS = 0
                    ORDER BY ENS_NOM,ENS_ID, common_backup_ade_enseignant.EDT_DATE_DEBUT,common_backup_ade_enseignant.EDT_HEURE_DEBUT
                    ";

        return self::getRequete($req);
    }

    public static function getFicheEmargement(int $groupe_courant, int $annee_courante, string $order = "DESC"): array
    {
        $table = Groupes::isPro($groupe_courant) ? "common_pro_signatures" : "common_absences_signatures";
        $req = "SELECT *,
                    DATE_FORMAT(FROM_UNIXTIME(common_backup_ade_etudiant.EDT_DATE_DEBUT),'%d/%m/%Y') AS DEBUT,
                    DATE_FORMAT(FROM_UNIXTIME(common_backup_ade_etudiant.EDT_DATE_DEBUT),'%Y-%m-%d') AS TRIEUR,
                    DATE_FORMAT(FROM_UNIXTIME(common_backup_ade_etudiant.EDT_HEURE_DEBUT),'%Hh%i') AS HORAIRE_START,
                    DATE_FORMAT(FROM_UNIXTIME(common_backup_ade_etudiant.EDT_HEURE_FIN),'%Hh%i') AS HORAIRE_END,
                    IF(NONFACTURE_EDT_UID IS NULL,'checked','') AS FACTURER,
                    SUM(IF(SIGNATURE_ENS_ID IS NULL,0,1)) AS PUCE  
                FROM common_backup_ade_etudiant
                    JOIN common_backup_ade_enseignant ON (common_backup_ade_enseignant.EDT_UID=common_backup_ade_etudiant.EDT_UID)
                    LEFT JOIN $table ON (SIGNATURE_EDT_UID=common_backup_ade_etudiant.EDT_UID AND SIGNATURE_GROUPE_ID=$groupe_courant)
                    LEFT JOIN common_backup_ade_enseignant_nonfacture ON (common_backup_ade_etudiant.EDT_UID=NONFACTURE_EDT_UID)
                WHERE common_backup_ade_etudiant.EDT_ANNEE_ID=$annee_courante
                    AND EDT_ARCHIVE IS NULL
                    AND common_backup_ade_etudiant.EDT_GROUPE_ID = $groupe_courant 
                GROUP BY common_backup_ade_etudiant.EDT_GROUPE_ID,common_backup_ade_etudiant.EDT_UID
                ORDER BY common_backup_ade_etudiant.EDT_DATE_DEBUT $order,common_backup_ade_etudiant.EDT_HEURE_DEBUT $order";

        return self::getRequete($req);
    }

    public static function getFicheEmargementArchivees(int $groupe_selectionne, int $annee_courante): array
    {
        $req = "SELECT EDT_ARCHIVE,DATE_FORMAT(FROM_UNIXTIME(EDT_ARCHIVE),'%d/%m/%Y') AS DATE_ARCHIVAGE
                FROM common_backup_ade_etudiant
                WHERE EDT_ARCHIVE IS NOT NULL AND EDT_GROUPE_ID=$groupe_selectionne AND EDT_ANNEE_ID=$annee_courante
                GROUP BY EDT_ARCHIVE
                ORDER BY EDT_ARCHIVE";
        return self::getRequete($req);
    }

    public static function restaurerArchives(int $groupe_id, int $annee_id, int $archive): bool
    {
        $req = "UPDATE common_backup_ade_etudiant SET EDT_ARCHIVE = NULL WHERE EDT_GROUPE_ID=$groupe_id AND EDT_ANNEE_ID=$annee_id AND EDT_ARCHIVE=$archive";
        return self::execRequete($req);

    }

    public static function getCreneauxDeCoursNonSignes(int $ens_id, int $annee_courante, string $table_signature = "common_absences_signatures", string $masque = "0", string $condition = "FORM_ABSENCES_AUTO=1"): array
    {
        $req = "SELECT common_backup_ade_enseignant.EDT_DATE_DEBUT,
                       common_backup_ade_enseignant.EDT_HEURE_DEBUT,
                       common_backup_ade_enseignant.EDT_HEURE_FIN,
                       common_backup_ade_enseignant.EDT_NOM,
                       GROUPE_NOM,
                       common_backup_ade_enseignant.EDT_SALLE,
                       ENS_NOM,
                       common_backup_ade_enseignant.EDT_UID,
                       common_backup_ade_enseignant.EDT_ENS_ID,
                       GROUPE_ID,
                       GROUPE_PRO
                FROM common_backup_ade_etudiant
                         JOIN common_backup_ade_enseignant
                              ON (common_backup_ade_etudiant.EDT_UID = common_backup_ade_enseignant.EDT_UID)
                         JOIN common_enseignant ON (ENS_ID = EDT_ENS_ID)
                         JOIN etudiants_groupes ON (GROUPE_ID = EDT_GROUPE_ID)
                         JOIN common_formation ON (FORM_ID = GROUPE_FORM_ID)
                         LEFT JOIN $table_signature
                                   ON (SIGNATURE_EDT_UID = common_backup_ade_etudiant.EDT_UID AND
                                       SIGNATURE_GROUPE_ID = EDT_GROUPE_ID AND SIGNATURE_ET_ID IS NULL)
                         LEFT JOIN common_backup_ade_enseignant_nonfacture
                                   ON (common_backup_ade_enseignant.EDT_UID = NONFACTURE_EDT_UID)
                WHERE NONFACTURE_EDT_UID IS NULL
                  AND $condition
                  AND SIGNATURE_ENS_ID IS NULL
                  AND ENS_ID = common_backup_ade_enseignant.EDT_ENS_ID
                  AND EDT_ARCHIVE IS NULL
                  AND ET_GROUPE_ANNEE_ID = $annee_courante
                  AND GROUPE_FEUILLE = 1
                  AND ENS_ID = $ens_id
                  AND common_backup_ade_enseignant.EDT_ANNEE_ID = $annee_courante
                  AND EDT_MASQUE = $masque
                  AND (FORM_ABSENCES_AUTO = 1 OR ET_PROFESSIONNALISATION = 1)
                GROUP BY common_backup_ade_enseignant.EDT_UID, GROUPE_ID
                ORDER BY common_backup_ade_etudiant.EDT_HEURE_DEBUT";

        return self::getRequete($req);
    }

    public static function getCreneauEnseignant(int $groupe_id, string $edt_uid): array
    {
        $table = Groupes::isPro($groupe_id) ? "common_pro_signatures" : "common_absences_signatures";
        $req = "SELECT ENS_NOM, EDT_UID,ENS_ID, EDT_NOM, EDT_DATE_DEBUT, EDT_DATE_FIN, SIGNATURE, SIGNATURE_EDT_UID,SIGNATURE_GROUPE_ID,SIGNATURE_ID,
                        DATE_FORMAT(FROM_UNIXTIME(EDT_DATE_DEBUT),'%d/%m/%Y') AS DEBUT,
                        DATE_FORMAT(FROM_UNIXTIME(EDT_HEURE_DEBUT),'%Hh%i') AS HORAIRE_START,
                        DATE_FORMAT(FROM_UNIXTIME(EDT_HEURE_FIN),'%Hh%i') AS HORAIRE_END
                FROM common_backup_ade_enseignant
                         JOIN common_enseignant ON (ENS_ID = EDT_ENS_ID)
                         LEFT JOIN $table ON (ENS_ID = SIGNATURE_ENS_ID AND SIGNATURE_EDT_UID = '$edt_uid' AND
                                                             SIGNATURE_GROUPE_ID = $groupe_id)
                WHERE EDT_UID = '$edt_uid'
                ORDER BY EDT_DATE_DEBUT, EDT_HEURE_DEBUT, ENS_NOM, ENS_ID";
        return self::getRequete($req);
    }

    public static function getFicheEmargementAvecEnseignants(int $annee_id, int $groupe_id) : array
    {
        $table = Groupes::isPro($groupe_id) ? "common_pro_signatures" : "common_absences_signatures";
        $req = "SELECT SIGNATURE_ET_ID,
                       SIGNATURE_EDT_UID,
                       SIGNATURE_ENS_ID,
                       SIGNATURE,
                       IFNULL(ens2.ENS_NOM,ens1.ENS_NOM) AS ENS_NOM,
                       common_backup_ade_etudiant.EDT_NOM,
                       common_backup_ade_etudiant.EDT_DATE_DEBUT,
                       common_backup_ade_etudiant.EDT_HEURE_DEBUT,
                       common_backup_ade_etudiant.EDT_HEURE_FIN
                FROM $table
                         JOIN common_backup_ade_etudiant
                              ON (SIGNATURE_EDT_UID = common_backup_ade_etudiant.EDT_UID AND
                                  common_backup_ade_etudiant.EDT_ANNEE_ID = $annee_id AND
                                  common_backup_ade_etudiant.EDT_ARCHIVE IS NULL AND
                                  SIGNATURE_GROUPE_ID = common_backup_ade_etudiant.EDT_GROUPE_ID)
                         JOIN common_backup_ade_enseignant
                              ON (common_backup_ade_enseignant.EDT_UID = common_backup_ade_etudiant.EDT_UID AND
                                  common_backup_ade_enseignant.EDT_ANNEE_ID = common_backup_ade_etudiant.EDT_ANNEE_ID)
                        JOIN common_enseignant ens1 ON (common_backup_ade_enseignant.EDT_ENS_ID = ens1.ENS_ID)
                        LEFT JOIN common_enseignant ens2 ON (SIGNATURE_ENS_ID = ens2.ENS_ID)
                WHERE SIGNATURE_GROUPE_ID = $groupe_id
                GROUP BY SIGNATURE_EDT_UID, SIGNATURE_ET_ID, SIGNATURE_ENS_ID
                ORDER BY EDT_DATE_DEBUT, EDT_HEURE_DEBUT, SIGNATURE_ENS_ID DESC, ENS_NOM
        ";
        return self::getRequete($req);
    }
}