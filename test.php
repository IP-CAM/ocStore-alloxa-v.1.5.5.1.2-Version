<?
ini_set("display_errors", "1");
ini_set("error_reporting", E_ALL);

define('LN', chr(13).chr(10), True);
define('BR', '<BR>', True);

function BuildDT($sep = '_') {
	$ms = microtime(true);
	$ms = floor(($ms-floor($ms))*1000);
	while (strlen($ms) < 3) $ms = '0'.$ms;
	return date('Y-m-d'.$sep.'H.i.s').'.'.$ms;
};

ob_start();

echo 'session_start()...'.BR;
session_start();

echo 'session current content:'.BR;
echo '<pre>';
print_r($_SESSION);
echo '</pre>'.BR;

echo 'session content write...'.BR;

$_SESSION['TEST'] = 'tra-la-la-la... '.BuildDT(' ');

echo 'session_write_close()...'.BR;
session_write_close();
	
echo 'done!';

echo ob_get_clean();

?>