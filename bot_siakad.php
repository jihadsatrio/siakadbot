<?php
/**
 * Coded by abrisam
 * v1.0 PHP Object Oriented
 * using curl
 */

require_once __DIR__ . '/vendor/autoload.php';
use jc21\CliTable;
class apigrabber
{
	function menu(){
		echo "\033[31m
   _____ _______    ____  ____  ______
  / ___//  _/   |  / __ )/ __ \/_  __/
  \__ \ / // /| | / __  / / / / / /   
 ___/ // // ___ |/ /_/ / /_/ / / /    
/____/___/_/  |_/_____/\____/ /_/     
                                      \n abrisam \n";
        $data = array(
        	array(
        		'0' => '1',
        		'1' => 'Grab Fakultas',
        		'2' => 'Type : php siakad_bot.php 1',
        		'3' => 'Grab faculty data from curl',
        	),
        	array(
        		'0' => '2',
        		'1' => 'Grab Prodi',
        		'2' => 'Type : php siakad_bot.php 2 fakultas-teknik',
        		'3' => 'php siakad_bot.php [faculty-name] sesuaikan dengan nama fakultas',
        	),
        	array(
        		'0' => '3',
        		'1' => 'Grab MHS KHS',
        		'2' => 'Type : php siakad_bot.php 3 fakultas-teknik s1-teknik-mesin 2017',
        		'3' => 'php bot_siakad.php 3 [faculty-name] [prodi-name] [year]',

        	),
        );
        $table = new CliTable;
		$table->setTableColor('blue');
		$table->setHeaderColor('cyan');
		$table->addField('No', '0',    false,                               'white');
		$table->addField('features',  '1',     false,                               'white');
		$table->addField('example',  '2',     false,                               'white');
		$table->addField('description',  '3',     false,                               'yellow');
		$table->injectData($data);
		$table->display();                              
	}
	function grabfakultas(){
		$ch = curl_init('https://www.unesa.ac.id/page/akademik'); //iniliasisasi url untuk diteruskan curl_setopt
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //untuk mmeberikap options
		$page = curl_exec($ch); //eksekusi curl

		//DOM START
		$dom = new DOMDocument();
		libxml_use_internal_errors(true);
		$dom->loadHTML($page);
		libxml_clear_errors();
		$xpath = new DOMXPath($dom);

		$data = array();
		// get all table rows and rows which are not headers //td[@class='name']/a
		$table_rows = $xpath->query('//ul[@class="check"]/li');
		foreach ($table_rows as $key) {
		    $crutz[] = preg_replace('~[\r\n]+~', '', trim($key->nodeValue));

		}
		
		$crutz_new = array();
		for ($i=0; $i <= 7 ; $i++) { //using 7 cuz total of count faculty and deleting school
			$lower = preg_replace('/\s+/', '-', strtolower($crutz[$i]));
		    array_push($crutz_new, array("0"=>$i+1,"1"=>$lower)); 
		}//convert crutz indexed array to multidimensional 
		$table = new CliTable;
		$table->setTableColor('blue');
		$table->setHeaderColor('light_yellow');
		$table->addField('No', '0', false, 'white');
		$table->addField('Name', '1', false, 'white');
		$table->injectData($crutz_new);
		$table->display();
	}
	function grabprodi($fakultas){
		$ch = curl_init('https://www.unesa.ac.id/page/akademik/'.$fakultas); //iniliasisasi url untuk diteruskan curl_setopt
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //untuk mmeberikap options
		$page = curl_exec($ch); //eksekusi curl

		//DOM START
		$dom = new DOMDocument();
		libxml_use_internal_errors(true);
		$dom->loadHTML($page);
		libxml_clear_errors();
		$xpath = new DOMXPath($dom);

		$data = array();
		// get all table rows and rows which are not headers //td[@class='name']/a
		$table_rows = $xpath->query('//ul[@class="check"]/li');
		foreach ($table_rows as $key) {
		    $crutz[] = preg_replace('~[\r\n]+~', '', trim($key->nodeValue));

		}
		
		$crutz_new = array();
		for ($i=0; $i < count($crutz) ; $i++) { //using 7 cuz total of count faculty and deleting school
			$lower = preg_replace('/\s+/', '-', strtolower($crutz[$i]));
		    array_push($crutz_new, array("0"=>$i+1,"1"=>$lower)); 
		}//convert crutz indexed array to multidimensional 
		$table = new CliTable;
		$table->setTableColor('blue');
		$table->setHeaderColor('light_yellow');
		$table->addField('No', '0', false, 'white');
		$table->addField('Name', '1', false, 'white');
		$table->injectData($crutz_new);
		$table->display();

	}
	function grabmhs($argv){
		//print_r($argv);
		//$angkatan = $argv[1];
		$ch = curl_init('https://www.unesa.ac.id/page/akademik/'.$argv[2].'/'.$argv[3].'/mahasiswa/'.$argv[4]); //iniliasisasi url untuk diteruskan curl_setopt
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //untuk mmeberikap options
		$page = curl_exec($ch); //eksekusi curl

		//DOM START
		$dom = new DOMDocument();
		libxml_use_internal_errors(true);
		$dom->loadHTML($page);
		libxml_clear_errors();
		$xpath = new DOMXPath($dom);

		$data = array();
		// get all table rows and rows which are not headers
		$table_rows = $xpath->query('//table/tr');
		foreach($table_rows as $row => $tr) {
		    foreach($tr->childNodes as $td) {
		        $data[$row][] = preg_replace('~[\r\n]+~', '', trim($td->nodeValue));
		    }
		    $data[$row] = array_values(array_filter($data[$row]));
		}

		// echo '<pre>';
		//print_r($data);
		// echo $data[0][0];
		// $table = new CliTable;
		// $table->setTableColor('blue');
		// $table->setHeaderColor('cyan');
		// $table->addField('No', '0',    false,                               'white');
		// $table->addField('Nim',  '1',     false,                               'white');
		// $table->addField('Nama',  '2',     false,                               'white');
		// $table->injectData($data);
		// $table->display();
		
		
		for ($i=0; $i < count($data) ; $i++) { 
			$result_url[] = "http://siakadu.unesa.ac.id/api/apiunggun?kondisi=biodatamhsmobile&nipd=".$data[$i][1];
			//echo "http://siakadu.unesa.ac.id/api/apiunggun?kondisi=biodatamhsmobile&nipd=".$data[$i][1]."\n";
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'http://siakadu.unesa.ac.id/api/apiunggun',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => 'kondisi=biodatamhsmobile&nipd='.$data[$i][1],
			  CURLOPT_HTTPHEADER => array(
			    'Content-Type: application/x-www-form-urlencoded',
			    'Cookie: Cookie=_ga=GA1.1.131156962.1645078494; PHPSESSID=1juj6k246mh4mt1824u8vhhel5'
			  ),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			$cuy[] = json_decode($response, true);
			
		}


		//denny array change logic
			// $kyaa = [];
			// for ($i=0; $i < count($cuy) ; $i++) { 
			// 	// echo $cuy[$i]->nm_pd;
			// 	$kyaa[$i] = $cuy[$i];
			// }


			// print_r($kyaa);

		//myself tryin usin new method
			$reconstructed = [];
			foreach ((array) $cuy as $k => $v) {
			    $reconstructed[$k] = $v;
			}

		$table = new CliTable;
		$table->setTableColor('blue');
		$table->setHeaderColor('cyan');
		$table->addField('Nim', 'nipd',    false,                               'white');
		$table->addField('Nim',  'nm_pd',     false,                               'white');
		$table->addField('TglLahir', 'tgl_lahir', false, 'cyan');
		$table->addField('TmptLahir', 'tmpt_lahir', false, 'cyan');
		$table->addField('Nama ayah',  'nm_ayah',     false,                               'white');
		$table->addField('Nama mom',  'nm_ibu_kandung',     false,                               'white');
		$table->addField('ipk',  'ipk',     false,                               'white');
		$table->addField('email',  'email',     false,                               'white');
		$table->injectData($reconstructed);
		$table->display();
			


	}

}
if (!isset($argv[1])) {
	$start = new apigrabber;
	$start->menu();
}else {
	switch ($argv[1]) {
		case '1':
			$start = new apigrabber;
			$start->grabfakultas();
			echo "--> next php bot_siakad.php 2 [faculty-name]";
			break;
		
		case '2':
			$start = new apigrabber;
			$start->grabprodi($argv[2]);
			echo "--> next php bot_siakad.php 3 [faculty-name] [prodi-name] [year]";
			break;
		case '3':
			$start = new apigrabber;
			$start->grabmhs($argv);
			break;
		default:
			// code...
			break;
	}
}

?>
