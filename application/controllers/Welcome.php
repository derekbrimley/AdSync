<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
     
     
     http://dir3696.zonarsystems.net/interface.php?customer=dir3696&username=system&password=password&action=adminassets&operation=add&format=xml&fleet=FLT1234&exsid=7654&location=Ricky&type=Standard
http://dir3696.zonarsystems.net/interface.php?customer=dir3696&username=system&password=password&action=extgetlocations&operation=location&format=xml
http://dir3696.zonarsystems.net/interface.php?customer=dir3696&username=system&password=password&action=showposition&operation=current&format=xml&version=2&logvers=3.3


*/
	public function index()
	{
        
		$opts = array(
			'http'=>array(
				'method'=>"GET",
				'header'=>"Accept-language: en\r\n" .
									"Cookie: foo=bar\r\n",
				'user_agent'=>    $_SERVER['HTTP_USER_AGENT'] 
			)
		);

		$context = stream_context_create($opts);

		$xml = file_get_contents('http://dir3696.zonarsystems.net/interface.php?customer=dir3696&username=system&password=password&action=showposition&operation=current&format=xml&version=2&logvers=3.3', false, $context);

		$parsed_xml = simplexml_load_string($xml);

	  	$assets = array();
	  
		foreach($parsed_xml->children() as $child){
		  $time = intval ($child->time);
		  $datetime = date("g:i a",$time);

		  $meters = intval($child->odometer);
		  $miles = $meters * .000621371;
		  $miles = number_format($miles);
		  
		  $id = $child->attributes()->id;
		  
		  $asset['id'] = $id;
		  $asset['truck_num'] = $child->attributes()->fleet;
		  $asset['last_update'] = $datetime;
		  $asset['lat'] = $child->lat;
		  $asset['long'] = $child->long;
		  $asset['heading'] = $child->heading;
		  $asset['speed'] = $child->speed." MPH";
		  $asset['power'] = ucfirst($child->power);
		  $asset['odometer'] = $miles;
		  
		  $assets[] = $asset;
		}


		$data['assets'] = $assets;
		$this->load->view('welcome_message', $data);
        
	}
}
