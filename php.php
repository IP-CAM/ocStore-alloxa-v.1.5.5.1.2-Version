<?php
// Генератор лицензий для FilterPro 2.4.*
// Установка:
// В корне магазина создать php файл с любым названием, скопировать в него этот код и запустить
?>

<?php
include('config.php'); // инклудим конфиг чтоб руками не писать

$host = preg_replace( '#^www\.(.+)#i', '$1', $_SERVER['HTTP_HOST'] ); // получаем хост
$config_file = "../config.php"; // готовимся к подсчету хеша конфига
$md_5 = md5_file( DIR_SYSTEM . $config_file ); // считаем хеш конфига и адреса к папке system
$priv_key = "da491836af4a9b8f2"; // он не меняется
$lic_dir = DIR_SYSTEM . 'license'; // обозначаем папку с лицензией
echo $lic_dir;
$hash = hash( 'sha256', $host . '.' . $md_5 . '.' . $priv_key ); // Вычисляем ключ 
$file_lic = $lic_dir . '/filterpro.' . $hash . '.lic'; // генерируем лицензию

// удаляем папку с лицензией, чтоб фильтр не ругался что их несколько
$it = new RecursiveDirectoryIterator($lic_dir);
$files = new RecursiveIteratorIterator($it,
             RecursiveIteratorIterator::CHILD_FIRST);
foreach($files as $file) {
    if ($file->getFilename() === '.' || $file->getFilename() === '..') {
        continue;
    }
    if ($file->isDir()){
        rmdir($file->getRealPath());
    } else {
        unlink($file->getRealPath());
    }
}
rmdir($lic_dir);

if(!is_dir($lic_dir)) mkdir($lic_dir); // создаем пустую папку

//записываем изменения
$write_licence = fopen($file_lic,"w");
if (fwrite($write_licence,$hash)) 
  echo "OK";
else 
  echo "FAIL :(";
fclose($write_licence);
?>