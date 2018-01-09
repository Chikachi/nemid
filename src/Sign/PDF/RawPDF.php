<?php
namespace Nodes\NemId\Sign\PDF;

class RawPDF implements IPDF {
	/**
	 * Raw PDF content
	 * @var string
	 */
	private $data;

	/**
	 * RawPDF constructor.
	 *
	 * @param string $data
	 */
	public function __construct($data) {
		$this->data = $data;
	}

	/**
	 * Get PDF content
	 *
	 * @return string
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * Set PDF content
	 *
	 * @param string $data
	 */
	public function setData($data) {
		$this->data = $data;
	}

	/**
	 * Get params for signing
	 *
	 * @return array
	 */
	public function getParams() {
		return [
			'SIGNTEXT' => base64_encode($this->data),
			'SIGNTEXT_REMOTE_HASH' => base64_encode(hash('sha256', $this->data)),
		];
	}
}