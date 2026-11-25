# Odin

Plateforme Odin, outil dédié à la gestion des départements en IUT.

## Migration réalisée

Ce dépôt contient désormais la migration complète de `bouhours/plateforme-odin` (branche `prod`) vers `bouhours/odin`, intégrée sur la branche `migration`.

L'organisation reste orientée modules métier (ex: `admin`, `notes`, `absences`, `stage`) et respecte le cycle BFMW déjà utilisé dans la plateforme :

- point d'entrée par module (`index.php`) ;
- initialisation commune via `common/Initialisation.php` ;
- enchaînement BFMW `overall_header -> menu -> page active -> overall_footer`.

## Alignement framework BFMW

Pour rester conforme aux paradigmes du framework `b_fmw/bfmw` (référence `sample`) tout en conservant le comportement existant :

- un bootstrap unique `common/framework_bootstrap.php` centralise le chargement Composer et BFMW ;
- `common/Initialisation.php` délègue explicitement au bootstrap commun ;
- le chargement d'autoload BFMW supporte les deux modes d'installation (framework embarqué ou dépendance Composer).

## Installation

```bash
composer install
```

Configurer ensuite les fichiers d'environnement de l'instance (`self_server_concrete.php`, configuration CAS et accès BDD) avant exécution.
