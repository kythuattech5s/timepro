<?php 
namespace paymentonline\manager\helpers;
class PaymentHelper{
	
	public static function curl($url,$header = '',$method = 'GET',$data){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $method,			
		));
		if($header != ''){
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				"Accept: */*",
				"Accept-Encoding: gzip, deflate",
				"Cache-Control: no-cache",
				"Connection: keep-alive",
				"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36",
				"cache-control: no-cache"
			));
		}
		else{
			curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
		}
		if($method == 'POST'){
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); 
		$response = curl_exec($curl);
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
		$err = curl_error($curl); 
		curl_close($curl);
		if ($err) { 
			return ['status' => $status, 'err' => $err];
		} else {
			return ['status' => $status, 'response' => $response];
		}
	}
}