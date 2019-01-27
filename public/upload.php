<?php

require_once __DIR__.'/../config.php';

function mkdirs($dir, $mode = 0777)
{
    if (is_dir($dir) || @mkdir($dir, $mode))
        return TRUE;
    if (! mkdirs(dirname($dir), $mode))
        return FALSE;
    
    return @mkdir($dir, $mode);
}

// 返回当前的毫秒时间戳
function msectime()
{
    list ($msec, $sec) = explode(' ', microtime());
    return (int) sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
}

function writeFile($file, $str)
{
    $res = fopen($file, 'w');
    if ($res) {
        fwrite($res, $str);
        fclose($res);
    }
}

header('Content-Type: application/json');
$project = $_POST['project'];
$model = $_POST['model'];
$user = $_POST['user'];
$configDir = "$project/$model/$user";
$filesDir = "$project/$model/$user";
if (! is_dir(CONFIG_DIR . $configDir)) {
    mkdirs(CONFIG_DIR . $configDir);
}
if (! is_dir(FILES_DIR . $filesDir)) {
    mkdirs(FILES_DIR . $filesDir);
}

if (count($_FILES) > 0) {
    $result = array();
    foreach ($_FILES as $file) {
        $error = $file['error'];
        if ($error > 0) {
            $data = [
                'error' => $code,
                'files' => null
            ];
            echo json_encode($data);
            return;
        }
        $type = strtolower($file['type']);
        $name = $file['name'];
        $time = msectime();
        $filePath = $filesDir . '/' . $time;
        $config = [
            'type' => $type,
            'name' => $name,
            'time' => $time,
            'path' => $filePath
        ];
        $json = json_encode($config, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $configPath = $configDir . '/' . $time;
        writeFile(CONFIG_DIR . $configPath, $json);
        
        $tmp_name = $file['tmp_name'];
        move_uploaded_file($tmp_name, FILES_DIR . $filePath);
        
        array_push($result, $configPath);
        
        $data = [
            'error' => 0,
            'files' => $result
        ];
        echo json_encode($data);
    }
}
?>