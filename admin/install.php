<?php
    if (file_exists( 'self_server_concrete.php' )) {
        $dossier_racine = '.';
        require_once (__DIR__ . "/../bfmw/includes/secure.php");
        require_once(__DIR__ . '/../bfmw/includes/tpl_functions.php');

        $template = attachXHTML();
        setAttachment($template, "config", "config.html");
        require_once __DIR__ . '/Traitement/overall_header.php';

        require_once __DIR__ . '/self_server_concrete.php';
        @$connInitialize = new mysqli($db_server, $db_user, $db_pwd);
        if (mysqli_connect_errno() !== 0)
            openBloc($template, "first_step_bdd_error");
        else {
            //on vérifie que la bdd n'est pas déjà créé
            @$connTmp= new mysqli($db_server, $db_user, $db_pwd, $db_database);
            @$tables = $connTmp->query('SHOW TABLES like "common_%"');
            if ($tables && $tables->num_rows > 0)
                openBloc($template, "install_db_error_table_exist");
            else {
                ini_set('display_errors',true);
                $sqlToImport = file_get_contents('../odin/initialize_database.sql');
                $rslt = $connInitialize->multi_query($sqlToImport);
                while (mysqli_next_result($connInitialize));
                $connInitialize->close();

                @$conn = new mysqli($db_server, $db_user, $db_pwd, $db_database);
                if($rslt) {
                    require_once(__DIR__ . '/../bfmw/includes/functions.php');
                    $datapost = [[
                        "*ENS_NOM" => "",
                        "*ENS_LOGIN" => USER_ADMIN,
                        "*ENS_MAIL" => ""
                    ]];
                    manual_bfmw_secure($datapost);
                    $idEnseignant = createData("common_enseignant", $datapost[0], 3);
                    if ($idEnseignant > 0) {
                        $datapost = [[
                            "*DEPT_NOM" => 'Département de test',
                            "*DEPT_CODE" => 'test00',
                            "*DEPT_ENS_ID" => $idEnseignant
                        ]];
                        manual_bfmw_secure($datapost);
                        $idDept = createData("common_departement", $datapost[0], 3);
                        if($idDept > 0) {
                            $tab = [[
                                "*DEPT_ENS_ID" => $idEnseignant,
                                "*ENS_DEPT_CURRENT" => 0,
                                "*ENS_DEPT_ID" => $idDept
                            ]];
                            manual_bfmw_secure($tab);
                            createData("common_enseignants_departement", $tab[0], 3);
                        }
                    }
                    openBloc($template, "install_success");
                }
                else
                    openBloc($template, "install_failed");

                $conn->close();
            }
        }

        generateCompleteXHTML($template, "config");
    } elseif (false === strpos( $_SERVER['REQUEST_URI'], 'setup-config' )) {
        header('Location: setup-config.php');
        exit;
    }