<?php
/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 4/23/2019
 * Time: 11:32 AM
 * project : paymentCMS
 * virsion : 0.0.0.1
 * update Time : 4/23/2019 - 11:32 AM
 * Discription of this Page :
 */


use paymentCms\component\mold\Mold;
use paymentCms\component\security;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


function getIP()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	{
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

function getUserAgent()
{
	return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
}

function curl($url,$data,$header = null){
	$curl_conn = curl_init();
	curl_setopt($curl_conn, CURLOPT_URL, $url);
	if ( $data != null ) {
		curl_setopt($curl_conn, CURLOPT_POST, 1);
		curl_setopt($curl_conn, CURLOPT_POSTFIELDS, $data);
	}
	if ( $header != null ) {
		curl_setopt($curl_conn, CURLOPT_HTTPHEADER, $header);
	}
	curl_setopt($curl_conn, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl_conn, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl_conn, CURLOPT_TIMEOUT, 5);
	$output = curl_exec($curl_conn);
	curl_close($curl_conn);
	return $output;
}

function show($pram = null , $exit = true ){
	echo '<pre>';
	var_dump($pram);
	echo '</pre>';
	if ( $exit ) {
		Mold::stopAllAutoCompile();
		exit;
	}
}

$_SERVER['s'] = base64_decode('aHR0cHM6Ly93d3cucGF5bWVudGNtcy5pci9hcGkvYXBwcy91cGRhdGVXaXRoTmV3cw==');
function phpinfo_array($return=false){
	$beforeHtml  = ob_get_contents();
	ob_end_clean();
	ob_start();
	phpinfo(-1);

	$pi = preg_replace(
		array('#^.*<body>(.*)</body>.*$#ms', '#<h2>PHP License</h2>.*$#ms',
			'#<h1>Configuration</h1>#',  "#\r?\n#", "#</(h1|h2|h3|tr)>#", '# +<#',
			"#[ \t]+#", '#&nbsp;#', '#  +#', '# class=".*?"#', '%&#039;%',
			'#<tr>(?:.*?)" src="(?:.*?)=(.*?)" alt="PHP Logo" /></a>'
			.'<h1>PHP Version (.*?)</h1>(?:\n+?)</td></tr>#',
			'#<h1><a href="(?:.*?)\?=(.*?)">PHP Credits</a></h1>#',
			'#<tr>(?:.*?)" src="(?:.*?)=(.*?)"(?:.*?)Zend Engine (.*?),(?:.*?)</tr>#',
			"# +#", '#<tr>#', '#</tr>#'),
		array('$1', '', '', '', '</$1>' . "\n", '<', ' ', ' ', ' ', '', ' ',
			'<h2>PHP Configuration</h2>'."\n".'<tr><td>PHP Version</td><td>$2</td></tr>'.
			"\n".'<tr><td>PHP Egg</td><td>$1</td></tr>',
			'<tr><td>PHP Credits Egg</td><td>$1</td></tr>',
			'<tr><td>Zend Engine</td><td>$2</td></tr>' . "\n" .
			'<tr><td>Zend Egg</td><td>$1</td></tr>', ' ', '%S%', '%E%'),
		ob_get_contents());
	echo 'sss';
	ob_end_clean();
	echo $beforeHtml ;
	$sections = explode('<h2>', strip_tags($pi, '<h2><th><td>'));
	unset($sections[0]);

	$pi = array();
	foreach($sections as $section){
		$n = substr($section, 0, strpos($section, '</h2>'));
		preg_match_all(
			'#%S%(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?%E%#',
			$section, $askapache, PREG_SET_ORDER);
		foreach($askapache as $m)
			$pi[$n][$m[1]]=(!isset($m[3])||$m[2]==$m[3])?$m[2]:array_slice($m,2);
	}

	return ($return === false) ? print_r($pi) : $pi;
}


function microtime_float($micro = null )
{
	list($usec, $sec) = explode(" ", ( $micro == null ) ? microtime() : $micro);
	return ((float)$usec + (float)$sec);
}