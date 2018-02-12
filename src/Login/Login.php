<?php

namespace Nodes\NemId\Login;

use Nodes\NemId\Core\iFrameGenerator;
use Nodes\NemId\Core\Mode;
use Nodes\NemId\Core\Nemid52Compat;

class Login extends iFrameGenerator {
	/**
	 * Login constructor.
	 *
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @param array $settings
	 * @param Mode|null $mode
	 */
	public function __construct(array $settings, $mode = null) {
		parent::__construct(new LoginSettings($settings, $mode));
	}

	/**
	 * Generate the params for iFrame.
	 *
	 * @author Casper Rasmussen <cr@nodes.dk>
	 */
	function generateParams() {
		// Init start params
		$params = [
			'SP_CERT' => $this->settings->getCertificateBase64(),
			'CLIENTFLOW' => 'OCESLOGIN2',
			'TIMESTAMP' => $this->timeStamp,
		];

		// Add origin if set
		if ($this->settings->hasOrigin()) {
			$params['ORIGIN'] = $this->settings->getOrigin();
		}

		// Remove cancel btn if set
		if (!$this->settings->showCancelBtn()) {
			$params['DO_NOT_SHOW_CANCEL'] = 'TRUE';
		}

		// Sort & normalize
		uksort($params, 'strnatcasecmp');
		$normalized = '';
		foreach ($params as $name => $value) {
			$normalized .= $name.$value;
		}

		// UTF8 encode it
		$normalized = utf8_encode($normalized);

		// Base64 and SHA256 Encode it
		$params['PARAMS_DIGEST'] = base64_encode(hash('sha256', $normalized, true));

		// Generate private key
		$privateKey = openssl_pkey_get_private($this->settings->getPrivateKey(), $this->settings->getPrivateKeyPassword());

		// Sign digest
		$signedDigest = Nemid52Compat::openSslSign($normalized, $privateKey, 'sha256WithRSAEncryption');

		// Base64 encode
		$params['DIGEST_SIGNATURE'] = base64_encode($signedDigest);

		// Json encode
		$encodedParams = json_encode($params, JSON_UNESCAPED_SLASHES);

		$this->params = $encodedParams;
	}
}
