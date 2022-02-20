<?php 
require 'vendor/autoload.php';
use jc21\CliTable;
/**
 * auto trade dengan logika menentukan harga beli dan harga saat menjual
 	dilakukan looping tak terhingga selama proses berjalan

 	cara penggunaan aplikasi menjalankan bot php , bot php akan melakukan curl ke api indodax untuk melakukan pengecheckan apikey dan secret key
 */
//if($argv[0] == null) $cover = new trader; $cover->cover();
class trader
{
	
	function __construct()
	{
		$key = 'NCMDH4LS-DIRIYHLA-FXWQUB99-EZNVSYUX-NXA1BRKG';
		$secret = '8025efa00e37c16ffddf9e6051ff1658a57b5d412e2abb325f1f9b555d770af0bbb846f90c0012ac';


		$req['method'] = 'getInfo';
		$req['nonce'] = time();

		//generate the POST data string
		$post_data = http_build_query($req, '', '&');
		$sign = hash_hmac('sha512', $post_data, $secret);

		//generate the extra headers
		$headers = array(
			'Sign:'.$sign,
			'Key:'.$key,
		);
	//our curl handle (initialize if required)
		static $ch = null;
		if (is_null($ch)) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; INDODAXCOM PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
		}
		curl_setopt($ch, CURLOPT_URL, 'https://indodax.com/tapi/');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		//php 7.2
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

		//RUN 
		$result = curl_exec($ch);
		//return $result;
		if ($result == false) throw new Exception('Could not get reply: '.curl_error($ch));

		$decode = json_decode($result, true);

		if(!$decode) throw new Exception('Invalid data received, please make sure connection is working and requested API exists: '.$result);
		curl_close($ch);
		$ch = null;
		//return $decode;
		$keys = array_keys($decode['return']['balance']);
		echo "Akun :  {$decode['return']['name']}\n";
		for ($i=0; $i < count($decode['return']['balance']); $i++) { 
			if ($decode['return']['balance'][$keys[$i]] != 0) {
				echo "\t[i] {$keys[$i]} : {$decode['return']['balance'][$keys[$i]]}\n";}
		}
	}
	function price(){
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://indodax.com/api/summaries");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		$decode = json_decode($result,true);
		curl_close($ch);
		echo "\n ---------PRICE-------- \n";
		echo "[+] BTC_IDR\n";
		echo "\t [i]Harga : {$decode['tickers']['btc_idr']['last']}\n";
		echo "\t [i]Beli : {$decode['tickers']['btc_idr']['buy']}\n";
		echo "\t [i]Jual : {$decode['tickers']['btc_idr']['sell']}\n";
		echo "\t [i]High 24h  : {$decode['tickers']['btc_idr']['high']}\n";
		echo "\t [i]Low 24h : {$decode['tickers']['btc_idr']['low']}\n";
		//echo "\033[31m some colored text \033[0m some white text \n";
	}
}
switch ($argv[1]) {
	case 'price':
		$data = new trader;
		$data->price();
		
		break;
	case 'trade':
		# code...
		break;
	case 'watchdog':
		# code...
		break;
	default:
		# code...
		break;
}
?>