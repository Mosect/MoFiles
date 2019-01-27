<?php
require_once __DIR__ . '/../config.php';

$path = $_SERVER['PATH_INFO'];
$str = file_get_contents(CONFIG_DIR . $path);
$config = json_decode($str, true);
// var_dump($config);
header('Disposition-Parm: $config[name]');
header("Content-Disposition: attachment;filename=$config[name]");
header("Content-Type: $config[type]");
echo file_get_contents(FILES_DIR . $config['path']);
?>