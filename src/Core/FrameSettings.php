<?php
namespace Nodes\NemId\Core;

abstract class FrameSettings extends Settings {
	/**
	 * @var string
	 */
	protected $baseUrl;
	protected $uiMode;
	protected $privateKey;
	protected $privateKeyPassword;
	protected $certificate;
	/**
	 * @var bool | string
	 */
	protected $origin;
	/**
	 * @var bool
	 */
	protected $showCancelBtn;

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @return string
	 */
	public function getCertificate() {
		return $this->certificate;
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @return string
	 */
	public function getCertificateBase64() {
		return base64_encode($this->certificate);
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @return string
	 */
	public function getPrivateKey() {
		return $this->privateKey;
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @return string
	 */
	public function getPrivateKeyPassword() {
		return $this->privateKeyPassword;
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @return string
	 */
	public function getUiMode() {
		return $this->uiMode;
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @return string
	 */
	public function getBaseUrl() {
		return $this->baseUrl;
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @return bool
	 */
	public function hasOrigin() {
		return !empty($this->origin);
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @return bool|string
	 */
	public function getOrigin() {
		return $this->origin;
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @return bool
	 */
	public function showCancelBtn() {
		return $this->showCancelBtn;
	}
}