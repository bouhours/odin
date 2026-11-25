<?php
    $dossier_racine = '.';
    require_once (__DIR__ . "/../bfmw/includes/secure.php");
    require_once(__DIR__ . '/../bfmw/includes/tpl_functions.php');
    require_once __DIR__ . '/Traitement/initConfig.php';

    $template = attachXHTML();
    setAttachment($template, "config", "config.html");
    require_once __DIR__ . '/Traitement/overall_header.php';

    if ( file_exists( 'self_server_concrete.php' ) )
        openBloc($template, "conf_already_exist");
    else {
        $step = isset( $_GET['bfmw_orig_step'] ) ? (int) $_GET['bfmw_num_step'] : -1;
        switch ($step) {
            case -1:
                openBloc($template, "no_step");
                break;
            case 1:
                affectToBloc($template, "first_step",  [
                    "SERVER_NAME" => $_SERVER['SERVER_NAME']
                ]);
                break;
            case 2:
                $configFile = file( 'self_server_example.php' );
                //on check si on peut écrire dans le dossier
                if (!is_writable( getcwd()))
                    openBloc($template, "first_or_second_step_right_error");
                else {
                    //on récup les infos pour test la co à la bdd
                    $listPostFieldsDb = ['db_database', 'db_user', 'db_pwd', 'db_server'];
                    foreach ($listPostFieldsDb as $nameField)
                        if (isset($_POST['bfmw_orig_'.$nameField]))
                            ${$nameField} = trim($_POST['bfmw_orig_' . $nameField]);

                    @$conn = new mysqli($db_server, $db_user, $db_pwd);
                    if (mysqli_connect_errno() !== 0)
                        openBloc($template, "first_step_bdd_error");
                    else {
                        $conn->close();
                        //on construit le fichier de conf
                        foreach ( $configFile as $lineNum => $line ) {
                            if (!preg_match('#^\$(db_[a-z]*)#', $line, $match))
                                continue;

                            $configFile[$lineNum] = $match[0] . " = '" .${$match[1]}. "';\r\n";
                        }

                        //on set les constantes
                        foreach ( $configFile as $lineNum => $line ) {
                            if (!preg_match('#^define\(\s*\"([A-Z_]+)\",#', $line, $match))
                                continue;

                            if (!strpos($match[1], '_')) {
                                $constPost = trim($_POST['bfmw_orig_' .strtolower($match[1])]);
                            } else
                                $constPost = trim($_POST['bfmw_orig_' .lcfirst(str_replace('_','', ucwords(strtolower($match[1]),'_')))]);

                            if ($match[1] == "ADE_TOKEN") {
                                $configFile[ $lineNum ] = "define(\"" . $match[1] . "\", array('" .  $constPost . "') );\r\n";
                            } else {
                                $configFile[ $lineNum ] = "define(\"" . $match[1] . "\", \"" .  $constPost . "\" );\r\n";
                            }
                        }

                        unset($line);

                        $rslt = scanDirToSetConfigfile($configFile) ;
                        if($rslt === 'success')
                            openBloc($template, 'second_step_success');
                        else {
                            affectToBloc($template,"first_or_second_step_right_error", [
                                "FOLDER_NAME_WRITE_ERROR"=> $rslt
                            ]);
                            affectToXHTML($template, [
                                "HAS_CUSTOM_ERROR" => true
                            ]);
                        }
                    }
                }

                break;
        }
    }

    generateCompleteXHTML($template, "config");