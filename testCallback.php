<?php

use Nodes\NemId\Core\CertificationCheck\CertificationCheck;
use Nodes\NemId\Core\Errors\ErrorHandler;

if (!isset($_POST['response'])) {
	die('Missing response');
}

require __DIR__.'/vendor/autoload.php';
$config = include __DIR__.'/config/nemid.php';

$config['test'] = true;
$config['iframe']['testSettings']['privateKeyPassword'] = 'Test1234';
$config['iframe']['testSettings']['privateKeyLocation'] = __DIR__.'/testcertificates/test_private.pem';
$config['iframe']['testSettings']['certificateLocation'] = __DIR__.'/testcertificates/test_public.pem';

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
$userInfo = json_encode($certificate->getSubject()->toArray(), JSON_PRETTY_PRINT);
$signatureProperties = json_encode(CertificationCheck::getSignatureProperties($response), JSON_PRETTY_PRINT);
echo <<<HTML
<!DOCTYPE html>
<html>
<head>
<title></title>
</head>
<body>
<h1>Success</h1>
<h2>User info</h2>
<pre>{$userInfo}</pre>
<h2>Signature Properties</h2>
<pre>{$signatureProperties}</pre>
</body>
</html>
HTML;
