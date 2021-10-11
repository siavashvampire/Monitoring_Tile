<?php

namespace paymentCms\core\component\jwt;
require_once ( __DIR__.'/vendor/autoload.php');

use Exception;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Token;

class jwt {

	private $timeExpire;
	private $secretKey;
	private $ServerName;
	private $Signer;

	public function __construct($secretKey = 'secretKey)(*IU HBSKJBHVFK$%@#$#@&89JKVN M24dg5vsdgvbsdvbsnbvksn dbs' , $timeExpire = 180 * 24 * 3600 ) {
		$this->timeExpire = time() + $timeExpire;
		$this->secretKey = $secretKey;
		$this->publicKey = 'systemPubLickKeyErfanEbrahimi';
		$this->ServerName = parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST);
		$this->Signer = new Sha256();
	}

	public function getToken($userSession, $moreUserData = null) {
		$text = $this->rand_code(10);
		$userData['session'] = $userSession;
		$userData['validate'] = md5('!@FD$$$$FFF' . $text . $userSession);
		$userData['moreData'] = $moreUserData;
		$token = (new Builder())->setIssuedAt(time())->setIssuer($this->ServerName)->set('userData', $userData)->setExpiration($this->timeExpire)->setId($text, true)->setHeader('alg', 'HS256')->sign($this->Signer, $this->secretKey)->getToken();
		$token = base64_encode(str_replace('.', '1NeW0!vF02', $token . '.' . $text));
		return $token;
	}

	public function validateToken($token) {
		$token = base64_decode($token);
		$tokens = explode('1NeW0!vF02', $token);
		$tokens[0] = ( isset($tokens[0])) ? $tokens[0] : '' ;
		$tokens[1] = ( isset($tokens[1])) ? $tokens[1] : '' ;
		$tokens[2] = ( isset($tokens[2])) ? $tokens[2] : '' ;
		$tokens[3] = ( isset($tokens[3])) ? $tokens[3] : '' ;
		$token = $tokens[0] . '.' . $tokens[1] . '.' . $tokens[2];
		$publicKey = $tokens[3];
		try {
			$token = (new Parser())->parse($token);
		} catch (Exception $exception) {
			return false;
		}

		$validationData = new ValidationData();
		$validationData->setIssuer($this->ServerName);
		$validationData->setId($publicKey);

		$validated = $token->validate($validationData) && $token->verify($this->Signer, $this->secretKey);

		$userData = json_decode(json_encode($token->getClaim('userData')), true);

		if ($userData['validate'] != md5('!@FD$$$$FFF' . $publicKey . $userData['session']))
			return false;

		unset($userData['validate']);
		if ($validated)
			return $userData;
		else
			return false;

	}

	private function rand_code($len = 50) {
		$min_lenght = 0;
		$max_lenght = 100;
		$bigL = "!@#$%^&*()_+{}ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$smallL = "qwertyuiopasdfghjklzxcvbnm";
		$number = "0123456789";
		$bigB = str_shuffle($bigL);
		$smallS = str_shuffle($smallL);
		$numberS = str_shuffle($number);
		$subA = substr($bigB, 0, 5);
		$subB = substr($bigB, 6, 5);
		$subC = substr($bigB, 10, 5);
		$subD = substr($smallS, 0, 5);
		$subE = substr($smallS, 6, 5);
		$subF = substr($smallS, 10, 5);
		$subG = substr($numberS, 0, 5);
		$subH = substr($numberS, 6, 5);
		$subI = substr($numberS, 10, 5);
		$RandCode1 = str_shuffle($subA . $subD . $subB . $subF . $subC . $subE);
		$RandCode2 = str_shuffle($RandCode1);
		$RandCode = $RandCode1 . $RandCode2;
		if ($len > $min_lenght && $len < $max_lenght) return substr($RandCode, 0, $len); else
			return $RandCode;
	}
}