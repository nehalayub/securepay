<?php


$clientID = '0oaxb9i8P9vQdXTsn3l5';
$secrectID = '0aBsGU3x1bc-UIF_vDBA2JzjpCPHjoCP7oI6jisp';

extract($_POST);


	$authorization = base64_encode($clientID . ":" . $secrectID);
	$header = array("Authorization: Basic {$authorization}","Content-Type: application/x-www-form-urlencoded");
	$content = 'grant_type=client_credentials&scope=https%3A%2F%2Fapi.payments.auspost.com.au%2Fpayhive%2Fpayments%2Fread%20https%3A%2F%2Fapi.payments.auspost.com.au%2Fpayhive%2Fpayments%2Fwrite%20https%3A%2F%2Fapi.payments.auspost.com.au%2Fpayhive%2Fpayment-instruments%2Fread%20https%3A%2F%2Fapi.payments.auspost.com.au%2Fpayhive%2Fpayment-instruments%2Fwrite';

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://hello.sandbox.auspost.com.au/oauth2/ausujjr7T0v0TTilk3l5/v1/token',
		CURLOPT_HTTPHEADER => $header,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $content
	));
	$response = curl_exec($curl);
	curl_close($curl);
	$responseData = json_decode($response);

	if (isset($responseData->error)) {
		echo $responseData->error_description;
	}else{
		$tokenType = $responseData->token_type;
		$authToken = $responseData->access_token;
		$ip = $_SERVER['REMOTE_ADDR'];
		$data = '{
			"amount" : '.$_POST["amount"].',
			"merchantCode": "'.$_POST["merchantCode"].'", 
			"token": "'.$_POST["token"].'", 
			"ip": "'.$ip.'", 
			"orderId": "'.$_POST["orderId"].'"
		}';


		$header = array("Authorization: {$tokenType} {$authToken}","Content-Type: application/json", "Idempotency-Key: 022361c6-3e59-40df-a58d-532bcc63c3ed");
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://payments-stest.npe.auspost.zone/v2/payments',
			CURLOPT_HTTPHEADER => $header,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $data
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$responseData = json_decode($response);

		if (isset($responseData->status) && $responseData->status == 'paid')  {
			$responseReturn = array(
			      'success' => true,
			      'msg' => $responseData->gatewayResponseMessage
			   );
		}else{
			$responseReturn = array(
			      'success' => false,
			      'msg' => 'Payment Failed'
			   );
		}

		var_dump($responseReturn);
		return json_encode($responseReturn);
	}


?>

