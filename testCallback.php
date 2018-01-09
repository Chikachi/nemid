<?php

use Nodes\NemId\Login\CertificationCheck\CertificationCheck;
use Nodes\NemId\Login\Errors\ErrorHandler;

if (!isset($_POST['response'])) {
	die('Missing response');
}

require __DIR__.'/vendor/autoload.php';
$config = include __DIR__.'/config/nemid.php';

$config['test'] = true;
$config['login']['testSettings']['privateKeyPassword'] = 'Test1234';
$config['login']['testSettings']['privateKeyLocation'] = __DIR__.'/testcertificates/test_private.pem';
$config['login']['testSettings']['certificateLocation'] = __DIR__.'/testcertificates/test_public.pem';

$response = base64_decode($_POST['response']);
if (!CertificationCheck::isXml($response)) {
	$error = ErrorHandler::getByCode($response);
	// Redirect with error $error->toJson()
	var_dump($error->toJson());
	exit;
}

// Check certificate
try {
	$userCertificate = new CertificationCheck($config);
	$certificate = $userCertificate->checkAndReturnCertificate($response);
} catch (\Exception $e) {
	// Error with validation of certificate chain or signature
	var_dump($e);
	exit;
}

// Successfully
// Redirect with login info $certificate->getSubject()->toJson();
var_dump($certificate->getSubject()->toJson());