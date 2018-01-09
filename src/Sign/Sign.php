<?php

namespace Nodes\NemId\Sign;

use Nodes\NemId\Core\iFrameGenerator;
use Nodes\NemId\Core\Mode;
use Nodes\NemId\Core\Nemid52Compat;
use Nodes\NemId\Sign\Data\ISignData;

class Sign extends iFrameGenerator {
	protected $signData;

	/**
	 * Sign constructor.
	 *
	 * @param ISignData $signData
	 * @param array $settings
	 * @param Mode|null $mode
	 */
	public function __construct($signData, array $settings, $mode = null) {
		$this->signData = $signData;
		parent::__construct(new SignSettings($settings, $mode));
	}

	/**
	 * Generate the params for iFrame.
	 *
	 * @author Casper Rasmussen <cr@nodes.dk>
	 * @throws \Exception
	 */
	function generateParams() {
		if ($this->signData == null) {
			throw new \Exception('Missing data to sign');
		}

		$params = array_merge(
			[
				'SP_CERT' => $this->settings->getCertificateBase64(),
				'CLIENTFLOW' => 'OCESSIGN2',
				'TIMESTAMP' => $this->timeStamp,
			],
			$this->signData->getParams()
		);

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
