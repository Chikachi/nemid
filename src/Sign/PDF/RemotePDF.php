<?php
namespace Nodes\NemId\Sign\PDF;

class RemotePDF implements IPDF {
	/**
	 * URI to remote file
	 * @var string
	 */
	private $uri;
	/**
	 * SHA256 hash of remote file
	 * @var null|string
	 */
	private $hash;

	/**
	 * RemotePDF constructor.
	 *
	 * @param string $uri
	 * @param string|null $hash
	 */
	public function __construct($uri, $hash = null) {
		$this->setUri($uri);
		$this->setHash($hash);
	}

	/**
	 * Get URI to remote file
	 *
	 * @return string
	 */
	public function getUri() {
		return $this->uri;
	}

	/**
	 * Set URI to remote file
	 *
	 * @param $uri
	 *
	 * @return $this
	 */
	public function setUri($uri) {
		$this->uri = $uri;

		return $this;
	}

	/**
	 * Check if URI to remote file is set
	 *
	 * @return bool
	 */
	public function isUriSet() {
		return $this->getUri() != null;
	}

	/**
	 * Get SHA256 hash of remote file
	 *
	 * @return null|string
	 */
	public function getHash() {
		return $this->hash;
	}

	/**
	 * Set SHA256 hash of remote file
	 *
	 * @param null $hash
	 *
	 * @return RemotePDF
	 */
	public function setHash($hash) {
		$this->hash = $hash;

		return $this;
	}

	/**
	 * Check if SHA256 hash is set
	 *
	 * @return bool
	 */
	public function isHashSet() {
		return $this->getHash() != null;
	}

	/**
	 * Get params for signing
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function getParams() {
		if (!$this->isUriSet()) {
			throw new \Exception('Missing URI');
		} else if (!in_array(parse_url($this->getUri(), PHP_URL_SCHEME), ['http', 'https'])) {
			throw new \Exception('Invalid URI');
		}

		if (!$this->isHashSet()) {
			$data = file_get_contents($this->getUri());
			if ($data === false) {
				throw new \Exception('Could not fetch PDF file to calculate hash');
			}
			$this->setHash(hash('sha256', $data));
		}

		return [
			'SIGNTEXT_URI' => $this->getUri(),
			'SIGNTEXT_REMOTE_HASH' => base64_encode($this->getHash()),
		];
	}
}