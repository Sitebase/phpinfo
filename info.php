<?php ob_start(); ?>
Server PHP info report<br />
----------------------<br />
<br />
PHP: <?php echo phpversion() ?><br />
<br />
Remote CURL: <?php echo check_curl_remote() ?><br />
Remote file_get_contents: <?php echo check_file_get_contents() ?><br />
JSON Encode/Decode: <?php echo check_json() ?><br />
<br />
<?php
$report = ob_get_contents();
ob_end_clean();

if(!isset($_GET['download'])) {
	echo $report;
	echo '<a href="?download">Download Report</a>';
} else {
	header('Content-type: text/plain');
	header('Content-Disposition: attachment; filename="report.txt"');
	echo str_replace('<br />', '', $report);
}

function check_curl_remote() {
	$curl = curl_init(); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($curl, CURLOPT_URL, 'http://www.google.be/'); 
	$content = curl_exec($curl); 
	curl_close($curl); 
	return !isset($content) || empty($content) ? false : true;
}

function check_file_get_contents() {
	$content = file_get_contents('http://www.google.be/');
	return !isset($content) || empty($content) ? false : true;
}

function check_json() {
	return json_encode(array('test')) == '["test"]' && is_array(json_decode('["test"]'));
}

