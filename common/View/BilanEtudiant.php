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

class BilanEtudiant extends Connectable
{
    public static function generateMaster(Template &$template, int $annee_courante, int $groupe_valide, int $ens_id, ?int $etudiant_courant=null) : void {
        /**
         * Affichage des étudiants
         */
        $les_etudiants = Etudiants::getEtudiantsGroupes($annee_courante, $groupe_valide);
        $les_controles = Notes::getNombreControlesPourUnEnseignantParEtudiant($ens_id);
        foreach ($les_etudiants as $etudiant) {
            if (isset($les_controles[$etudiant['ET_ID']]) && $les_controles[$etudiant["ET_ID"]]["TOTAL"]>0) {
                $etudiant['ME'] = "*";
            } else {
                $etudiant['ME'] = "";
            }

            $etudiant['SELECTED'] = ($etudiant_courant != null && $etudiant_courant==$etudiant['ET_ID'])?"jaune_force":"";

            affectToBloc($template, "un_etudiant", $etudiant);
        }

        $table = array(
            "GROUPE" => $groupe_valide
        );

        affectToXHTML($template, $table);
    }

    public static function generateBilan(Template &$template, int $annee_courante, int $etudiant_valide, int $formation_renseignement = -1) : void {

        /**
         * Detail
         */
        $etudiant = Etudiants::getEtudiant($etudiant_valide, $annee_courante);
        if ($etudiant != null) {
            openBloc($template, "show");
            /**
             * ETUDIANT
             */
            $etudiant = $etudiant[0];
            $etudiant['ET_AGE'] = getAge($etudiant['ET_NAISSANCE']);
            affectToXHTML($template, $etudiant);

            /**
             * GROUPES
             */
            $les_groupes = array();
            $les_groupes_annees = array();
            Etudiants::getGroupes($etudiant_valide, $les_groupes, $les_groupes_annees, CURRENT_DEPT_ID);
            $les_annees = Annees::getAnnee();

            $groupe_en_cours = 0;
            foreach ($les_groupes as $un_groupe) {
                $first = true;
                foreach ($les_annees as $une_annee) {
                    if (isset($les_groupes_annees[$un_groupe['GROUPE_ID'] . "$" . $une_annee['ANNEE_ID']])) {
                        if ($groupe_en_cours != $un_groupe['GROUPE_FORM_ID'] && $first) {
                            $groupe_en_cours = $un_groupe['GROUPE_FORM_ID'];
                            affectToBloc($template, "show.une_formation_groupe", $un_groupe);
                        }
                        if ($first) {
                            affectToBloc($template, "show.une_formation_groupe.un_groupe", $un_groupe);
                            $first = false;
                        }
                        affectToBloc($template, "show.une_formation_groupe.un_groupe.une_annee", $une_annee);
                    }
                }
            }

            /**
             * RENSEIGNEMENTS
             */
            $les_formations = Formations::getFormationDeLEtudiant($etudiant_valide,$annee_courante);
            foreach ($les_formations as $formation) {
                if ($formation['FORM_ID'] == $formation_renseignement) {
                    $les_champs = Fiches_Renseignements::getChampsDeLaFormationValorises($formation["FORM_ID"], $etudiant_valide);
                    affectToBlocAndRepeat($template, "show.une_formation_renseignement.un_champ", $les_champs);
                }
            }

            /**
             * ABSENCES EXPIREES
             */
            Absences::afficheurAbsences($etudiant_valide, $template, '1', "une_absence_expiree", "NOMBRE_ABSENCES_EXPIREES",-1,"show.","CRENEAU_DEPT_ID=".CURRENT_DEPT_ID." AND ");

            /**
             * ABSENCES
             */
            Absences::afficheurAbsences($etudiant_valide, $template, '0', "une_absence", "NOMBRE_ABSENCES");


            /**
             * BILAN COMPETENCES
             */
            BilanCompetences::afficheurBilan($annee_courante,$etudiant_valide, $template,"show");

            /**
             * NOTES
             */
            ReleveNotes::genererMoyennesSemestre(Etudiants::getSemestresInscrits($etudiant_valide,CURRENT_DEPT_ID), $template, $etudiant_valide, "show");
        }
    }
}