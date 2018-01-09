<?php
namespace Nodes\NemId\Sign\Data;

class TextSignData implements ISignData {
	/**
	 * Text content
	 * 
	 * @var string|null
	 */
	private $text;
	/**
	 * Whether or not to use monospaced font
	 * @var bool 
	 */
	private $monospaceFont = true;

	/**
	 * TextSignData constructor.
	 *
	 * @param string $text
	 * @param bool $monospaceFont
	 */
	public function __construct($text = null, $monospaceFont = true) {
		$this->setText($text);
		$this->setMonospaceFont($monospaceFont);
	}

	/**
	 * Get text content
	 *
	 * @return null|string
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * Set text content
	 *
	 * @param string $text
	 *
	 * @return TextSignData
	 */
	public function setText($text) {
		$this->text = $text;

		return $this;
	}

	/**
	 * Check if text content is set
	 *
	 * @return bool
	 */
	public function isTextSet() {
		return is_string($this->text);
	}

	/**
	 * Check if signing is set to use monospaced font
	 *
	 * @return bool
	 */
	public function isMonospaceFont() {
		return $this->monospaceFont;
	}

	/**
	 * Set the signing to use monospaced font
	 *
	 * @param bool $monospaceFont
	 *
	 * @return TextSignData
	 */
	public function setMonospaceFont($monospaceFont) {
		$this->monospaceFont = $monospaceFont;

		return $this;
	}

	/**
	 * Get params for signing
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function getParams() {
		if (!$this->isTextSet()) {
			throw new \Exception('Missing text');
		}

		$params = [
			'SIGNTEXT' => base64_encode($this->getText()),
			'SIGNTEXT_FORMAT' => 'TEXT',
		];
		if ($this->isMonospaceFont()) {
			$params['SIGNTEXT_MONOSPACEFONT'] = $this->isMonospaceFont() ? 'TRUE' : 'FALSE';
		}
		return $params;
	}
}