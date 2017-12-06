<?php
namespace zpfei\hasher;

/** **********Example****************
	use zpfei\hasher\Rsa;
	
	$rsa = new Rsa(1024);
	$keys = $rsa->createKeys();
	$encode = Rsa::encode($keys['publicKey'],'hello word');

	echo Rsa::decode($keys['privateKey'],$encode);
***********************************/

class Rsa
{
	public $bits;
	public $config;
	private $ssl;
	public $privateKey;
	public $publicKey;

	public function __construct($bits=1024,$option = [])
	{
		$this->bits = $bits;
		$option = array_merge(['private_key_bits'=>$bits],$option);
		$this->config = $option;
		$this->ssl = openssl_pkey_new($this->config);
	}

	public function createKeys()
	{
		openssl_pkey_export($this->ssl, $this->privateKey);
		$publicInfo = openssl_pkey_get_details($this->ssl);
		$this->publicKey = $publicInfo['key'];

		return [
			'privateKey' => $this->privateKey,
			'publicKey'	 => $this->publicKey,
		];
	}

	public static function encode($key,$data)
	{
		$type = self::check($key);
		$enData = false;
		$type = stripos($key, 'PUBLIC')===false?'private':'public';
		if ($type==='private') {
			openssl_private_encrypt($data,$enData,$key);
		} else {
			openssl_public_encrypt($data,$enData,$key);
		}

		return $enData;
	}

	public static function decode($key,$data)
	{
		$type = self::check($key);
		$deData = false;
		if ($type==='private') {
			openssl_private_decrypt($data,$deData,$key);
		} else {
			openssl_public_decrypt($data,$deData,$key);
		}

		return $deData;
	}
	
	public static function check($key,$type=null)
	{
		if ($type===null) {
			$type = stripos($key, 'PUBLIC')===false?'private':'public';
		}

		if ($type==='private') {
			 $resource = openssl_pkey_get_private($key);
		} else {
			 $resource = openssl_pkey_get_public($key);
		}

		if (!$resource) {
			throw new Exception('key is Invalid');
			//return false;
		}

		unset($resource);
		return $type;
	}

}
