<?php
namespace Nodes\NemId\Sign\PDF;

class LocalPDF implements IPDF {
	/**
	 * File path to local file
	 * @var string
	 */
	private $file;

	/**
	 * LocalPDF constructor.
	 *
	 * @param string $file File path to local file
	 */
	public function __construct($file) {
		$this->setFile($file);
	}

	/**
	 * Get file path to local file
	 *
	 * @return string
	 */
	public function getFile() {
		return $this->file;
	}

	/**
	 * Set file path to local file
	 *
	 * @param string $file
	 */
	public function setFile($file) {
		if (!file_exists($file)) {
			throw new \InvalidArgumentException('File not found');
		}

		if (!is_readable($file)) {
			throw new \InvalidArgumentException('File not readable');
		}

		$this->file = $file;
	}

	/**
	 * Get params for signing
	 *
	 * @return array
	 */
	public function getParams() {
		$data = file_get_contents($this->file);
		return [
			'SIGNTEXT' => base64_encode($data),
			'SIGNTEXT_REMOTE_HASH' => base64_encode(hash('sha256', $data)),
		];
	}
}