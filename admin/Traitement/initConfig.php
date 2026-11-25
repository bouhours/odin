<?php
/**
 * @param array $configFile
 * @return string
 */
function scanDirToSetConfigfile(array $configFile): string
{
    $chemin = dirname(__DIR__, 2);
    foreach (scandir($chemin) as $element) {
        if ($element !== '.' && $element !== '..' && is_dir($chemin . '/' . $element)) {
            $confSampleFile = $chemin . '/' . $element . '/self_server_example.php';
            $cheminConfig = $chemin . '/' . $element . '/self_server_concrete.php';
            if (!file_exists($cheminConfig) && file_exists($confSampleFile)) {
                try {
                    createConfigFile($cheminConfig, $configFile);
                }
                catch (Exception $exception) {
                    return $exception->getMessage();
                }

                if($element === 'etudiants') {
                    try {
                        createUploadDir($chemin . '/' . $element . '/uploads');
                    }
                    catch (Exception $exception) {
                        return $exception->getMessage();
                    }
                }
            }
        }
    }
    
    return 'success';
}

/**
 * @param string $cheminConfig
 * @param array $configFile
 * @return void
 * @throws ErrorException
 */
function createConfigFile(string $cheminConfig, array $configFile): void
{
    $handle = fopen($cheminConfig, 'w');
    if (false !== $handle) {
        foreach ($configFile as $line) {
            fwrite($handle, $line);
        }
        
        fclose($handle);
    } else {
        $config_perms = fileperms($cheminConfig);
        if (!empty($config_perms) && !is_writable($cheminConfig))
            throw new ErrorException('Vous devez rendre le dossier "'.dirname($cheminConfig).'" accessible en écriture avant de pouvoir enregistrer vos modifications.');
        else
            throw new ErrorException('Impossible de créer le fichier dans le dossier "'.dirname($cheminConfig).'"');
    }
}

/**
 * @param string $path
 * @return void
 * @throws Exception
 */
function createUploadDir(string $path): void
{
    if (!makeDir($path) )
        throw new Exception('Impossible de créer le dossier "'.dirname($path).'"');

    $config_file = fopen($path . '/.htaccess', 'w');
    if ( !$config_file )
        throw new Exception('Impossible de créer le fichier htaccess dans le dossier "'.dirname($path).'"');

    fwrite($config_file, '<Files *>' . PHP_EOL);
    fwrite($config_file, 'Order Allow,Deny' . PHP_EOL);
    fwrite($config_file, 'Deny from All' . PHP_EOL);
    fwrite($config_file, '</Files>' . PHP_EOL);
    fclose($config_file);
}

/**
 * @param string $path
 * @return bool
 */
function makeDir(string $path)
{
    return is_dir($path) || mkdir($path);
}