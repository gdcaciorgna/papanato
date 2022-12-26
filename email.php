<?php
	$from = 'mailto:papanatomarketing@gmail.com';
	$sendTo = 'mailto:papanatomarketing@gmail.com';
	$subject = 'Consulta web / Papanato';
	$fields = array('nombre' => 'Nombre', 'email' => 'Email', 'telefono' => 'Teléfono', 'mensaje' => 'Mensaje'); 
	$okMessage = 'Gracias por contactarnos, te responderemos a la brevedad.';
	$errorMessage = 'Hubo un error mientras se realizaba el envío, por favor intentalo de nuevo.';
	error_reporting(E_ALL & ~E_NOTICE);
	try
	{
		if(count($_POST) == 0) throw new \Exception('Form is empty');
		$emailText = "La siguiente consulta ha sido enviada desde la web:\n-------------------------------\n\n";
		foreach ($_POST as $key => $value) {if (isset($fields[$key])) {$emailText .= "$fields[$key]: $value\n";}}
		$headers = array('Content-Type: text/plain; charset="UTF-8";',
			'From: ' . $from,
			'Reply-To: ' . $from,
			'Return-Path: ' . $from,
		);
		mail($sendTo, $subject, $emailText, implode("\n", $headers));
		$responseArray = array('type' => 'success', 'message' => $okMessage);
	}

	catch (\Exception $e)
		{$responseArray = array('type' => 'danger', 'message' => $errorMessage);}

	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$encoded = json_encode($responseArray);
		header('Content-Type: application/json');
		echo $encoded;
	}
	else {echo $responseArray['message'];
}
