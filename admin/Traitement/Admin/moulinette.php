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
/*
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

$conn = new mysqli($db_server, $db_user, $db_pwd, $db_database);
$conn->set_charset('utf8');

mysql_start_transaction();

$req = "SELECT * FROM common_enseignants_matieres";
$res = $conn->query($req);
while ($un_enseignant = $res->fetch_assoc()) {
    $req = "SELECT * FROM common_charge_enseignant WHERE CHARGE_AFFECT_ID=".$un_enseignant["ID"];
    $la_charge = $conn->query($req)->fetch_all(MYSQLI_ASSOC);
    $id = $un_enseignant["ID"];
    foreach ($la_charge as $une_charge) {
        if ($une_charge['CHARGE_GROUPES_CM'] != "") {
            $req = "INSERT INTO common_charge_v2(CHARGE_AFFECTATION_ID, CHARGE_GROUPE, CHARGE_MULTIPLICATEUR, CHARGE_TYPE, CHARGE_VALEUR, CHARGE_SEMAINE)
                            VALUES ($id," . ($une_charge['CHARGE_GROUPES_CM'] ?? 0) . "," . ($une_charge['CHARGE_MULT_CM'] ?? 1) . ",'CM'," . ($une_charge['CHARGE_CM'] ?? 0) . "*" . ($une_charge['CHARGE_SEMAINES_CM'] ?? 0) . "," . ($une_charge['CHARGE_SEMAINES_CM'] ?? "NULL") . ")";
            $conn->query($req);
        }
        if ($une_charge['CHARGE_GROUPES_TD'] != "") {
            $req = "INSERT INTO common_charge_v2(CHARGE_AFFECTATION_ID, CHARGE_GROUPE, CHARGE_MULTIPLICATEUR, CHARGE_TYPE, CHARGE_VALEUR, CHARGE_SEMAINE)
                            VALUES ($id," . ($une_charge['CHARGE_GROUPES_TD'] ?? 0) . "," . ($une_charge['CHARGE_MULT_TD'] ?? 1) . ",'TD'," . ($une_charge['CHARGE_TD'] ?? 0) . "*" . ($une_charge['CHARGE_SEMAINES_TD'] ?? 0) . "," . ($une_charge['CHARGE_SEMAINES_TD'] ?? "NULL") . ")";
            $conn->query($req);
        }
        if ($une_charge['CHARGE_GROUPES_TP'] != "") {
            $req = "INSERT INTO common_charge_v2(CHARGE_AFFECTATION_ID, CHARGE_GROUPE, CHARGE_MULTIPLICATEUR, CHARGE_TYPE, CHARGE_VALEUR, CHARGE_SEMAINE)
                            VALUES ($id," . ($une_charge['CHARGE_GROUPES_TP'] ?? 0) . "," . ($une_charge['CHARGE_MULT_TP'] ?? 1) . ",'TP'," . ($une_charge['CHARGE_TP'] ?? 0) . "*" . ($une_charge['CHARGE_SEMAINES_TP'] ?? 0) . "," . ($une_charge['CHARGE_SEMAINES_TP'] ?? "NULL") . ")";
            $conn->query($req);
        }
        if ($une_charge['CHARGE_GROUPES_TPR'] != "") {
            $req = "INSERT INTO common_charge_v2(CHARGE_AFFECTATION_ID, CHARGE_GROUPE, CHARGE_MULTIPLICATEUR, CHARGE_TYPE, CHARGE_VALEUR, CHARGE_SEMAINE)
                            VALUES ($id," . ($une_charge['CHARGE_GROUPES_TPR'] ?? 0) . "," . ($une_charge['CHARGE_MULT_TPR'] ?? 1) . ",'TP'," . ($une_charge['CHARGE_TPR'] ?? 0) . "*" . ($une_charge['CHARGE_SEMAINES_TPR'] ?? 0) . "," . ($une_charge['CHARGE_SEMAINES_TPR'] ?? "NULL") . ")";
            $conn->query($req);
        }
        if ($une_charge['CHARGE_GROUPES_TDR'] != "") {
            $req = "INSERT INTO common_charge_v2(CHARGE_AFFECTATION_ID, CHARGE_GROUPE, CHARGE_MULTIPLICATEUR, CHARGE_TYPE, CHARGE_VALEUR, CHARGE_SEMAINE)
                            VALUES ($id," . ($une_charge['CHARGE_GROUPES_TDR'] ?? 0) . "," . ($une_charge['CHARGE_MULT_TDR'] ?? 1) . ",'TD'," . ($une_charge['CHARGE_TDR'] ?? 0) . "*" . ($une_charge['CHARGE_SEMAINES_TDR'] ?? 0) . "," . ($une_charge['CHARGE_SEMAINES_TDR'] ?? "NULL") . ")";
            $conn->query($req);
        }
        if ($une_charge['CHARGE_GROUPES_DS'] != "") {
            $req = "INSERT INTO common_charge_v2(CHARGE_AFFECTATION_ID, CHARGE_GROUPE, CHARGE_MULTIPLICATEUR, CHARGE_TYPE, CHARGE_VALEUR, CHARGE_SEMAINE)
                            VALUES ($id," . ($une_charge['CHARGE_GROUPES_DS'] ?? 0) . "," . ($une_charge['CHARGE_MULT_DS'] ?? 1) . ",'DS'," . ($une_charge['CHARGE_DS'] ?? 0) . "*" . ($une_charge['CHARGE_SEMAINES_DS'] ?? 0) . "," . ($une_charge['CHARGE_SEMAINES_DS'] ?? "NULL") . ")";
            $conn->query($req);
        }
        if ($une_charge['CHARGE_GROUPES_TPV'] != "") {
            $req = "INSERT INTO common_charge_v2(CHARGE_AFFECTATION_ID, CHARGE_GROUPE, CHARGE_MULTIPLICATEUR, CHARGE_TYPE, CHARGE_VALEUR, CHARGE_SEMAINE)
                            VALUES ($id," . ($une_charge['CHARGE_GROUPES_TPV'] ?? 0) . "," . ($une_charge['CHARGE_MULT_TPV'] ?? 1) . ",'TP'," . ($une_charge['CHARGE_TPV'] ?? 0) . "*" . ($une_charge['CHARGE_SEMAINES_TPV'] ?? 0) . "," . ($une_charge['CHARGE_SEMAINES_TPV'] ?? "NULL") . ")";
        }
    }
}

mysql_commit();
exit;
*/
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

$conn = new mysqli($db_server, $db_user, $db_pwd, $db_database);
$conn->set_charset('utf8');

mysql_start_transaction();

$req = "SELECT DEPT_CODE, DEPT_ID FROM common_departement";
$res = $conn->query($req);
while ($un_dept = $res->fetch_array()) {

    $code = $un_dept['DEPT_CODE'];
    $id = $un_dept['DEPT_ID'];

    $req = "
        create or replace definer = odin@`%` view ".$code."_notes_moyennes_matiere_sans_bonus as
    select sum(if(`odin`.`common_notes`.`NOTES_SPECIAL` = 'ABJ', 0,
                  `odin`.`common_notes`.`NOTES_VALEUR` * 20 / `odin`.`common_controle`.`CONTROLE_BAREME` *
                  `odin`.`common_controle`.`CONTROLE_COEFF`)) / sum(if(`odin`.`common_notes`.`NOTES_SPECIAL` = 'ABJ', 0,
                                                                       `odin`.`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,
           `odin`.`common_matiere`.`MAT_COEF`                                                                      AS `MOYMAT_COEF`,
           `odin`.`common_matiere`.`MAT_ID`                                                                        AS `MOYMAT_MAT_ID`,
           `odin`.`common_notes`.`NOTES_ET_ID`                                                                     AS `MOYMAT_ET_ID`,
           `odin`.`common_controle`.`CONTROLE_ANNEE_ID`                                                            AS `MOYMAT_ANNEE_ID`,
           `odin`.`common_ue`.`UE_ID`                                                                              AS `MOYMAT_UE_ID`,
           `odin`.`common_ue`.`UE_COEF`                                                                            AS `MOYMAT_UE_COEF`,
           `odin`.`common_semestre`.`SEM_COEF`                                                                     AS `MOYMAT_SEM_COEF`,
           `odin`.`common_semestre`.`SEM_ID`                                                                       AS `MOYMAT_SEM_ID`,
           `odin`.`common_semestre`.`SEM_FORM_ID`                                                                  AS `MOYMAT_FORM_ID`,
           `odin`.`common_matiere`.`MAT_SURMAT_ID`                                                                 AS `MOYMAT_SURMAT_ID`,
           min(`odin`.`common_notes`.`NOTES_SPECIAL`)                                                              AS `MOYMAT_SPECIAL`
    from `odin`.`common_controle`
             join `odin`.`common_notes`
                  on (`odin`.`common_controle`.`CONTROLE_ID` = `odin`.`common_notes`.`NOTES_CONTROLE_ID`)
             join `odin`.`common_matiere`
                  on (ifnull(`odin`.`common_matiere`.`MAT_COPIE_MAT_ID`, `odin`.`common_matiere`.`MAT_ID`) =
                      `odin`.`common_controle`.`CONTROLE_MAT_ID`)
             join `odin`.`common_ue` on (`odin`.`common_ue`.`UE_ID` = `odin`.`common_matiere`.`MAT_UE_ID`)
             join `odin`.`common_semestre` on (odin.`common_semestre`.`SEM_ID` = `odin`.`common_ue`.`UE_SEM_ID`)
             join `odin`.`common_annee`
                  on (`odin`.`common_annee`.`ANNEE_ID` = `odin`.`common_controle`.`CONTROLE_ANNEE_ID` and
                      (common_matiere.MAT_END_ANNEE_ID IS NULL or
                       common_matiere.MAT_END_ANNEE_ID = `odin`.`common_controle`.`CONTROLE_ANNEE_ID` + 1))
             join `odin`.`common_formation`
                  on (`odin`.`common_formation`.`FORM_ID` = `odin`.`common_semestre`.`SEM_FORM_ID`)
    where `odin`.`common_formation`.`FORM_DEPT_ID` = $id
      and `odin`.`common_controle`.`CONTROLE_MOYENNE` = '1'
      and `odin`.`common_controle`.`CONTROLE_VALIDE` = '1'
      and `odin`.`common_matiere`.`MAT_HAS_NOTE` = 1
      and (`odin`.`common_notes`.`NOTES_VALEUR` is not null or `odin`.`common_notes`.`NOTES_SPECIAL` is not null)
      and `odin`.`common_annee`.`ANNEE_CLOSE` = 0
    group by `odin`.`common_matiere`.`MAT_ID`, `odin`.`common_notes`.`NOTES_ET_ID`,
             `odin`.`common_controle`.`CONTROLE_ANNEE_ID`;
    ";

    if (!$conn->query($req)) {
        echo "ERREUR : $code<br/>";
    } else {
        echo "OK : $code<br/>";
    }

    $req = "
        create or replace definer = odin@`%` view ".$code."_notes_moyennes_matiere_somme_bonus as
            select ifnull(sum(`odin`.`common_notes`.`NOTES_VALEUR`), 0) AS `MOYMAT_BONUS_VALEUR`,
                   `odin`.`common_matiere`.`MAT_ID`                     AS `MOYMAT_MAT_ID`,
                   `odin`.`common_notes`.`NOTES_ET_ID`                  AS `MOYMAT_ET_ID`,
                   `odin`.`common_controle`.`CONTROLE_ANNEE_ID`         AS `MOYMAT_ANNEE_ID`,
                   `odin`.`common_ue`.`UE_ID`                           AS `MOYMAT_UE_ID`,
                   `odin`.`common_ue`.`UE_COEF`                         AS `MOYMAT_UE_COEF`,
                   `odin`.`common_semestre`.`SEM_COEF`                  AS `MOYMAT_SEM_COEF`,
                   `odin`.`common_semestre`.`SEM_ID`                    AS `MOYMAT_SEM_ID`,
                   `odin`.`common_semestre`.`SEM_FORM_ID`               AS `MOYMAT_FORM_ID`,
                   `odin`.`common_matiere`.`MAT_SURMAT_ID`              AS `MOYMAT_SURMAT_ID`,
                   min(`odin`.`common_notes`.`NOTES_SPECIAL`)           AS `MOYMAT_BONUS_SPECIAL`
            from `odin`.`common_controle`
                     join `odin`.`common_notes`
                          on (`odin`.`common_controle`.`CONTROLE_ID` = `odin`.`common_notes`.`NOTES_CONTROLE_ID`)
                     join `odin`.`common_matiere`
                          on (ifnull(`odin`.`common_matiere`.`MAT_COPIE_MAT_ID`, `odin`.`common_matiere`.`MAT_ID`) =
                              `odin`.`common_controle`.`CONTROLE_MAT_ID`)
                     join `odin`.`common_ue` on (`odin`.`common_ue`.`UE_ID` = `odin`.`common_matiere`.`MAT_UE_ID`)
                     join `odin`.`common_semestre` on (`odin`.`common_semestre`.`SEM_ID` = `odin`.`common_ue`.`UE_SEM_ID`)
                     join `odin`.`common_annee`
                          on (`odin`.`common_annee`.`ANNEE_ID` = `odin`.`common_controle`.`CONTROLE_ANNEE_ID` and
                              (common_matiere.MAT_END_ANNEE_ID IS NULL or
                               common_matiere.MAT_END_ANNEE_ID = `odin`.`common_controle`.`CONTROLE_ANNEE_ID` + 1))
                     join `odin`.`common_formation`
                          on (`odin`.`common_formation`.`FORM_ID` = `odin`.`common_semestre`.`SEM_FORM_ID`)
            where `odin`.`common_formation`.`FORM_DEPT_ID` = $id
              and `odin`.`common_controle`.`CONTROLE_MOYENNE` = '2'
              and `odin`.`common_controle`.`CONTROLE_VALIDE` = '1'
              and `odin`.`common_matiere`.`MAT_HAS_NOTE` = 1
              and `odin`.`common_annee`.`ANNEE_CLOSE` = 0
            group by `odin`.`common_matiere`.`MAT_ID`, `odin`.`common_notes`.`NOTES_ET_ID`,
                     `odin`.`common_controle`.`CONTROLE_ANNEE_ID`;
    ";

    if (!$conn->query($req)) {
        echo "ERREUR : $code<br/>";
    } else {
        echo "OK : $code<br/>";
    }

    $req = "
        create or replace definer = odin@`%` view ".$code."_notes_moyennes_matiere as
select `sansbonus`.`MOYMAT_COEF`                                                           AS `MOYMAT_COEF`,
       `sansbonus`.`MOYMAT_MAT_ID`                                                         AS `MOYMAT_MAT_ID`,
       `sansbonus`.`MOYMAT_ET_ID`                                                          AS `MOYMAT_ET_ID`,
       `sansbonus`.`MOYMAT_ANNEE_ID`                                                       AS `MOYMAT_ANNEE_ID`,
       `sansbonus`.`MOYMAT_UE_ID`                                                          AS `MOYMAT_UE_ID`,
       `sansbonus`.`MOYMAT_UE_COEF`                                                        AS `MOYMAT_UE_COEF`,
       `sansbonus`.`MOYMAT_SEM_COEF`                                                       AS `MOYMAT_SEM_COEF`,
       `sansbonus`.`MOYMAT_SEM_ID`                                                         AS `MOYMAT_SEM_ID`,
       `sansbonus`.`MOYMAT_FORM_ID`                                                        AS `MOYMAT_FORM_ID`,
       `sansbonus`.`MOYMAT_SURMAT_ID`                                                      AS `MOYMAT_SURMAT_ID`,
       if(`sansbonus`.`MOYMAT_SPECIAL` = ' ABI ', NULL,
          if(ifnull(`sommebonus`.`MOYMAT_BONUS_VALEUR`, 0) + `sansbonus`.`MOYMAT_VALEUR` > 20, 20,
             ifnull(`sommebonus`.`MOYMAT_BONUS_VALEUR`, 0) + `sansbonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,
       `sansbonus`.`MOYMAT_SPECIAL`                                                        AS `MOYMAT_SPECIAL`,
       `sommebonus`.`MOYMAT_BONUS_SPECIAL`                                                 AS `MOYMAT_BONUS_SPECIAL`,
       `odin`.`common_dispense_ue`.`DISP_UE_ID`                                            AS `MOYMAT_DISPENSE`
from ((`odin`.`".$code."_notes_moyennes_matiere_sans_bonus` `sansbonus` left join `odin`.`common_dispense_ue`
       on (`sansbonus`.`MOYMAT_ET_ID` = `odin`.`common_dispense_ue`.`DISP_ET_ID` and
           `sansbonus`.`MOYMAT_UE_ID` = `odin`.`common_dispense_ue`.`DISP_UE_ID` and `sansbonus`.`MOYMAT_ANNEE_ID` =
                                                                                     `odin`.`common_dispense_ue`.`DISP_ANNEE_ID`)) left join `odin`.`".$code."_notes_moyennes_matiere_somme_bonus` `sommebonus`
      on (`sommebonus`.`MOYMAT_MAT_ID` = `sansbonus`.`MOYMAT_MAT_ID` and
          `sommebonus`.`MOYMAT_ET_ID` = `sansbonus`.`MOYMAT_ET_ID` and
          `sommebonus`.`MOYMAT_ANNEE_ID` = `sansbonus`.`MOYMAT_ANNEE_ID` and
          `sommebonus`.`MOYMAT_UE_ID` = `sansbonus`.`MOYMAT_UE_ID` and
          `sommebonus`.`MOYMAT_SEM_ID` = `sansbonus`.`MOYMAT_SEM_ID` and
          `sommebonus`.`MOYMAT_FORM_ID` = `sansbonus`.`MOYMAT_FORM_ID`));
    ";

    if (!$conn->query($req)) {
        echo "ERREUR : $code<br/>";
    } else {
        echo "OK : $code<br/>";
    }

    $req = "
        create or replace definer = odin@`%` view ".$code."_notes_moyennes_absences as
select `odin`.`common_notes`.`NOTES_ET_ID`          AS `ET_ID`,
       `odin`.`common_matiere`.`MAT_ID`             AS `MAT_ID`,
       `odin`.`common_matiere`.`MAT_CODE_APOGE`     AS `MAT_CODE_APOGE`,
       `odin`.`common_controle`.`CONTROLE_ANNEE_ID` AS `ANNEE_ID`,
       min(`odin`.`common_notes`.`NOTES_SPECIAL`)   AS `MOYMAT_REMONTEE`,
       `odin`.`common_etudiant`.`ET_NUMERO`         AS `ET_NUMERO_ABS`
from ((((`odin`.`common_notes` join `odin`.`common_controle`) join `odin`.`common_matiere`) join `odin`.`common_etudiant`) join `odin`.`common_annee`)
where `odin`.`common_matiere`.`MAT_ID` = `odin`.`common_controle`.`CONTROLE_MAT_ID`
  and `odin`.`common_controle`.`CONTROLE_ID` = `odin`.`common_notes`.`NOTES_CONTROLE_ID`
  and `odin`.`common_etudiant`.`ET_ID` = `odin`.`common_notes`.`NOTES_ET_ID`
  and `odin`.`common_annee`.`ANNEE_ID` = `odin`.`common_controle`.`CONTROLE_ANNEE_ID`
  and `odin`.`common_annee`.`ANNEE_CLOSE` = 0
group by `odin`.`common_notes`.`NOTES_ET_ID`, `odin`.`common_matiere`.`MAT_ID`,
         `odin`.`common_controle`.`CONTROLE_ANNEE_ID`;
    ";

    if (!$conn->query($req)) {
        echo "ERREUR : $code<br/>";
    } else {
        echo "OK : $code<br/>";
    }

    $req = "
        create or replace definer = odin@`%` view ".$code."_notes_moyennes_annee as
select sum(`".$code."_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `".$code."_notes_moyennes_semestre`.`MOYSEM_COEF`) /
       sum(`".$code."_notes_moyennes_semestre`.`MOYSEM_COEF`)    AS `MOYAN_VALEUR`,
       `".$code."_notes_moyennes_semestre`.`MOYSEM_ET_ID`        AS `MOYAN_ET_ID`,
       `".$code."_notes_moyennes_semestre`.`MOYSEM_FORM_ID`      AS `MOYAN_FORM_ID`,
       `".$code."_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID`     AS `MOYAN_ANNEE_ID`,
       min(`".$code."_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL`
from `odin`.`".$code."_notes_moyennes_semestre`
group by `".$code."_notes_moyennes_semestre`.`MOYSEM_ET_ID`, `".$code."_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID`;
    ";

    if (!$conn->query($req)) {
        echo "ERREUR : $code<br/>";
    } else {
        echo "OK : $code<br/>";
    }

    $req = "
        create or replace definer = odin@`%` view ".$code."_notes_moyennes_export as
select `total`.`MOYMAT_VALEUR`                                                AS `MOYMAT_VALEUR`,
       `total`.`MOYMAT_ET_ID`                                                 AS `MOYMAT_ET_ID`,
       `total`.`MOYMAT_ANNEE_ID`                                              AS `MOYMAT_ANNEE_ID`,
       `total`.`MOYMAT_MAT_ID`                                                AS `MOYMAT_MAT_ID`,
       `odin`.`common_etudiant`.`ET_NUMERO`                                   AS `ET_NUMERO`,
       `total`.`MOYMAT_SPECIAL`                                               AS `MOYMAT_SPECIAL`,
       `total`.`MOYMAT_SEM_ID`                                                AS `MOYMAT_SEM_ID`,
       `total`.`MOYMAT_UE_ID`                                                 AS `MOYMAT_UE_ID`,
       `total`.`MOYMAT_FORM_ID`                                               AS `MOYMAT_FORM_ID`,
       `total`.`MOYMAT_COEF`                                                  AS `MOYMAT_COEF`,
       `total`.`MOYMAT_VALEUR`                                                AS `VALEUR_TO_EXPORT`,
       if(`meilleures`.`MOYUE_BARREE` is null, NULL, `total`.`MOYMAT_VALEUR`) AS `VALEUR_BARREE`
from ((((((select `matieres`.`MOYMAT_VALEUR`   AS `MOYMAT_VALEUR`,
                  `matieres`.`MOYMAT_ET_ID`    AS `MOYMAT_ET_ID`,
                  `matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,
                  `matieres`.`MOYMAT_MAT_ID`   AS `MOYMAT_MAT_ID`,
                  `matieres`.`MOYMAT_SPECIAL`  AS `MOYMAT_SPECIAL`,
                  `matieres`.`MOYMAT_SEM_ID`   AS `MOYMAT_SEM_ID`,
                  `matieres`.`MOYMAT_UE_ID`    AS `MOYMAT_UE_ID`,
                  `matieres`.`MOYMAT_FORM_ID`  AS `MOYMAT_FORM_ID`,
                  `matieres`.`MOYMAT_COEF`     AS `MOYMAT_COEF`
           from `odin`.`".$code."_notes_moyennes_matiere` `matieres`)
          union all
          (select `surmatieres`.`MOYMAT_VALEUR`   AS `MOYMAT_VALEUR`,
                  `surmatieres`.`MOYMAT_ET_ID`    AS `MOYMAT_ET_ID`,
                  `surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,
                  `surmatieres`.`MOYMAT_MAT_ID`   AS `MOYMAT_MAT_ID`,
                  `surmatieres`.`MOYMAT_SPECIAL`  AS `MOYMAT_SPECIAL`,
                  `surmatieres`.`MOYMAT_SEM_ID`   AS `MOYMAT_SEM_ID`,
                  `surmatieres`.`MOYMAT_UE_ID`    AS `MOYMAT_UE_ID`,
                  `surmatieres`.`MOYMAT_FORM_ID`  AS `MOYMAT_FORM_ID`,
                  `surmatieres`.`MOYMAT_COEF`     AS `MOYMAT_COEF`
           from `odin`.`".$code."_notes_moyennes_surmatieres` `surmatieres`)) `total` join `odin`.`common_etudiant`
         on (`odin`.`common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID`)) join `odin`.`".$code."_notes_moyennes_ue_meilleures` `meilleures`
        on (`total`.`MOYMAT_UE_ID` = `meilleures`.`MOYUE_UE_ID` and
            `meilleures`.`MOYUE_ET_ID` = `odin`.`common_etudiant`.`ET_ID` and `meilleures`.`MOYUE_ANNEE_ID` =
                                                                              `total`.`MOYMAT_ANNEE_ID`)) left join `odin`.`common_clotures_moyennes_matiere` `anciennes`
       on (`anciennes`.`MOYMAT_MAT_ID` = `total`.`MOYMAT_MAT_ID` and
           `anciennes`.`MOYMAT_ET_ID` = `odin`.`common_etudiant`.`ET_ID` and `anciennes`.`MOYMAT_ANNEE_ID` =
                                                                             `total`.`MOYMAT_ANNEE_ID` -
                                                                             1)) left join `odin`.`common_clotures_moyennes_surmatieres` `anciennes_surmatieres`
      on (`anciennes_surmatieres`.`MOYMAT_MAT_ID` = `total`.`MOYMAT_MAT_ID` and
          `anciennes_surmatieres`.`MOYMAT_ET_ID` = `odin`.`common_etudiant`.`ET_ID` and
          `anciennes_surmatieres`.`MOYMAT_ANNEE_ID` = `total`.`MOYMAT_ANNEE_ID` - 1))
where `total`.`MOYMAT_COEF` is not null
group by `total`.`MOYMAT_ET_ID`, `total`.`MOYMAT_ANNEE_ID`, `total`.`MOYMAT_MAT_ID`;


    ";

    if (!$conn->query($req)) {
        echo "ERREUR : $code<br/>";
    } else {
        echo "OK : $code<br/>";
    }

    $req = "
        create or replace definer = odin@`%` view ".$code."_notes_moyennes_semestre as
select sum(`nouvelle`.`MOYUE_VALEUR` * `nouvelle`.`MOYUE_COEF_CALC`) /
       sum(`nouvelle`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,
       `nouvelle`.`MOYUE_ET_ID`          AS `MOYSEM_ET_ID`,
       `nouvelle`.`MOYUE_FORM_ID`        AS `MOYSEM_FORM_ID`,
       `nouvelle`.`MOYUE_ANNEE_ID`       AS `MOYSEM_ANNEE_ID`,
       `nouvelle`.`MOYUE_SEM_COEF`       AS `MOYSEM_COEF`,
       `nouvelle`.`MOYUE_SEM_ID`         AS `MOYSEM_ID`,
       min(`nouvelle`.`MOYUE_SPECIAL`)   AS `MOYSEM_SPECIAL`
from `odin`.`".$code."_notes_moyennes_ue_meilleures` `nouvelle`
group by `nouvelle`.`MOYUE_SEM_ID`, `nouvelle`.`MOYUE_ET_ID`, `nouvelle`.`MOYUE_ANNEE_ID`;
    ";

    if (!$conn->query($req)) {
        echo "ERREUR : $code<br/>";
    } else {
        echo "OK : $code<br/>";
    }

    $req = "
        create or replace definer = odin@`%` view ".$code."_notes_moyennes_surmatieres as
select sum(if(`matieres`.`MOYMAT_VALEUR` is null, 0, `matieres`.`MOYMAT_VALEUR` * `matieres`.`MOYMAT_COEF`)) /
       sum(if(`matieres`.`MOYMAT_VALEUR` is null, 0, `matieres`.`MOYMAT_COEF`))          AS `MOYMAT_VALEUR`,
       ifnull(`arborescence_matiere`.`MAT_SURMAT_ID`, `arborescence_matiere`.`MAT_ID`)   AS `MOYMAT_MAT_ID`,
       (select `odin`.`common_matiere`.`MAT_COEF`
        from `odin`.`common_matiere`
        where `odin`.`common_matiere`.`MAT_ID` = `arborescence_matiere`.`MAT_SURMAT_ID`) AS `MOYMAT_COEF`,
       `matieres`.`MOYMAT_ET_ID`                                                         AS `MOYMAT_ET_ID`,
       `matieres`.`MOYMAT_ANNEE_ID`                                                      AS `MOYMAT_ANNEE_ID`,
       `matieres`.`MOYMAT_UE_ID`                                                         AS `MOYMAT_UE_ID`,
       `matieres`.`MOYMAT_UE_COEF`                                                       AS `MOYMAT_UE_COEF`,
       `matieres`.`MOYMAT_SEM_COEF`                                                      AS `MOYMAT_SEM_COEF`,
       `matieres`.`MOYMAT_SEM_ID`                                                        AS `MOYMAT_SEM_ID`,
       `matieres`.`MOYMAT_FORM_ID`                                                       AS `MOYMAT_FORM_ID`,
       min(`matieres`.`MOYMAT_SPECIAL`)                                                  AS `MOYMAT_SPECIAL`,
       `matieres`.`MOYMAT_DISPENSE`                                                      AS `MOYMAT_DISPENSE`
from (`odin`.`".$code."_notes_moyennes_matiere` `matieres` join `odin`.`arborescence_matiere`
      on (`arborescence_matiere`.`MAT_SOURCE` = `matieres`.`MOYMAT_MAT_ID`))
where `matieres`.`MOYMAT_SURMAT_ID` is not null
group by `arborescence_matiere`.`MAT_SURMAT_ID`, `matieres`.`MOYMAT_ET_ID`, `matieres`.`MOYMAT_ANNEE_ID`;
    ";

    if (!$conn->query($req)) {
        echo "ERREUR : $code<br/>";
    } else {
        echo "OK : $code<br/>";
    }

    $req = "
        create or replace definer = odin@`%` view ".$code."_notes_moyennes_ue as
select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null, 0,
              `total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) /
       sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null, 0,
              `total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,
       `total`.`MOYMAT_ET_ID`         AS `MOYUE_ET_ID`,
       `total`.`MOYMAT_ANNEE_ID`      AS `MOYUE_ANNEE_ID`,
       `total`.`MOYMAT_UE_ID`         AS `MOYUE_UE_ID`,
       `total`.`MOYMAT_UE_COEF`       AS `MOYUE_COEF`,
       `total`.`MOYMAT_SEM_COEF`      AS `MOYUE_SEM_COEF`,
       `total`.`MOYMAT_SEM_ID`        AS `MOYUE_SEM_ID`,
       `total`.`MOYMAT_FORM_ID`       AS `MOYUE_FORM_ID`,
       sum(`total`.`MOYMAT_COEF`)     AS `MOYUE_COEF_CALC`,
       min(`total`.`MOYMAT_SPECIAL`)  AS `MOYUE_SPECIAL`,
       `total`.`MOYMAT_DISPENSE`      AS `MOYUE_DISPENSE`
from ((select `matieres`.`MOYMAT_VALEUR`   AS `MOYMAT_VALEUR`,
              `matieres`.`MOYMAT_COEF`     AS `MOYMAT_COEF`,
              `matieres`.`MOYMAT_ET_ID`    AS `MOYMAT_ET_ID`,
              `matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,
              `matieres`.`MOYMAT_UE_ID`    AS `MOYMAT_UE_ID`,
              `matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,
              `matieres`.`MOYMAT_SEM_ID`   AS `MOYMAT_SEM_ID`,
              `matieres`.`MOYMAT_FORM_ID`  AS `MOYMAT_FORM_ID`,
              `matieres`.`MOYMAT_UE_COEF`  AS `MOYMAT_UE_COEF`,
              `matieres`.`MOYMAT_SPECIAL`  AS `MOYMAT_SPECIAL`,
              `matieres`.`MOYMAT_DISPENSE` AS `MOYMAT_DISPENSE`
       from `odin`.`".$code."_notes_moyennes_matiere` `matieres`
       where `matieres`.`MOYMAT_SURMAT_ID` is null)
      union all
      (select `surmatieres`.`MOYMAT_VALEUR`   AS `MOYMAT_VALEUR`,
              `surmatieres`.`MOYMAT_COEF`     AS `MOYMAT_COEF`,
              `surmatieres`.`MOYMAT_ET_ID`    AS `MOYMAT_ET_ID`,
              `surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,
              `surmatieres`.`MOYMAT_UE_ID`    AS `MOYMAT_UE_ID`,
              `surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,
              `surmatieres`.`MOYMAT_SEM_ID`   AS `MOYMAT_SEM_ID`,
              `surmatieres`.`MOYMAT_FORM_ID`  AS `MOYMAT_FORM_ID`,
              `surmatieres`.`MOYMAT_UE_COEF`  AS `MOYMAT_UE_COEF`,
              `surmatieres`.`MOYMAT_SPECIAL`  AS `MOYMAT_SPECIAL`,
              `surmatieres`.`MOYMAT_DISPENSE` AS `MOYMAT_DISPENSE`
       from (`odin`.`".$code."_notes_moyennes_surmatieres` `surmatieres` join `odin`.`arborescence_matiere`
             on (`surmatieres`.`MOYMAT_MAT_ID` = `arborescence_matiere`.`MAT_ID` and
                 `arborescence_matiere`.`MAT_ID` = `arborescence_matiere`.`MAT_SOURCE`))
       where `arborescence_matiere`.`MAT_SURMAT_ID` is null)) `total`
group by `total`.`MOYMAT_ET_ID`, `total`.`MOYMAT_ANNEE_ID`, `total`.`MOYMAT_UE_ID`;


    ";

    if (!$conn->query($req)) {
        echo "ERREUR : $code<br/>";
    } else {
        echo "OK : $code<br/>";
    }

    $req = "
        create or replace definer = odin@`%` view ".$code."_notes_moyennes_ue_meilleures as
select if(`anciennes`.`MOYUE_VALEUR` is null or `meilleure`.`MEILLEURE_ET_ID` is null, `nouvelle`.`MOYUE_VALEUR`, if(
        (`nouvelle`.`MOYUE_VALEUR` >= `anciennes`.`MOYUE_VALEUR` or `anciennes`.`MOYUE_VALEUR` < 10) and
        `nouvelle`.`MOYUE_DISPENSE` is null, `nouvelle`.`MOYUE_VALEUR`, `anciennes`.`MOYUE_VALEUR`)) AS `MOYUE_VALEUR`,
       if(`anciennes`.`MOYUE_VALEUR` is null or `meilleure`.`MEILLEURE_ET_ID` is null, NULL, if(
               (`nouvelle`.`MOYUE_VALEUR` >= `anciennes`.`MOYUE_VALEUR` or `anciennes`.`MOYUE_VALEUR` < 10) and
               `nouvelle`.`MOYUE_DISPENSE` is null, NULL, `nouvelle`.`MOYUE_VALEUR`))                AS `MOYUE_BARREE`,
       `nouvelle`.`MOYUE_ET_ID`                                                                      AS `MOYUE_ET_ID`,
       `nouvelle`.`MOYUE_ANNEE_ID`                                                                   AS `MOYUE_ANNEE_ID`,
       `nouvelle`.`MOYUE_UE_ID`                                                                      AS `MOYUE_UE_ID`,
       `nouvelle`.`MOYUE_COEF`                                                                       AS `MOYUE_COEF`,
       `nouvelle`.`MOYUE_SEM_COEF`                                                                   AS `MOYUE_SEM_COEF`,
       `nouvelle`.`MOYUE_SEM_ID`                                                                     AS `MOYUE_SEM_ID`,
       `nouvelle`.`MOYUE_FORM_ID`                                                                    AS `MOYUE_FORM_ID`,
       `nouvelle`.`MOYUE_COEF_CALC`                                                                  AS `MOYUE_COEF_CALC`,
       `nouvelle`.`MOYUE_SPECIAL`                                                                    AS `MOYUE_SPECIAL`
from ((`odin`.`".$code."_notes_moyennes_ue` `nouvelle` left join `odin`.`common_clotures_moyennes_ue` `anciennes`
       on (`nouvelle`.`MOYUE_UE_ID` = `anciennes`.`MOYUE_UE_ID` and
           `nouvelle`.`MOYUE_ET_ID` = `anciennes`.`MOYUE_ET_ID` and
           `anciennes`.`MOYUE_ANNEE_ID` = `nouvelle`.`MOYUE_ANNEE_ID` - 1 and
           `nouvelle`.`MOYUE_SEM_ID` = `anciennes`.`MOYUE_SEM_ID` and `nouvelle`.`MOYUE_FORM_ID` =
                                                                      `anciennes`.`MOYUE_FORM_ID`)) left join `odin`.`common_etudiant_meilleure_ue` `meilleure`
      on (`meilleure`.`MEILLEURE_ANNEE_ID` = `nouvelle`.`MOYUE_ANNEE_ID` and
          `meilleure`.`MEILLEURE_ET_ID` = `nouvelle`.`MOYUE_ET_ID`));


    ";

    if (!$conn->query($req)) {
        echo "ERREUR : $code<br/>";
    } else {
        echo "OK : $code<br/>";
    }
}

mysql_commit();
exit;