<?php
namespace Nodes\NemId\Sign\Data;

use Nodes\NemId\Sign\PDF\IPDF;

class PDFSignData implements ISignData {
	/**
	 * PDF content
	 *
	 * @var IPDF
	 */
	private $pdf = null;

	/**
	 * PDFSignData constructor.
	 *
	 * @param IPDF|null $pdf
	 */
	public function __construct($pdf = null) {
		$this->setPdf($pdf);
	}

	/**
	 * Get PDF content
	 *
	 * @return IPDF|null
	 */
	public function getPdf() {
		return $this->pdf;
	}

	/**
	 * Set PDF content
	 *
	 * @param IPDF $pdf
	 *
	 * @return PDFSignData
	 */
	public function setPdf($pdf) {
		$this->pdf = $pdf;

		return $this;
	}

	/**
	 * Check if PDF content is set
	 *
	 * @return bool
	 */
	public function isPdfSet() {
		return $this->getPdf() !== null;
	}

	/**
	 * Get params for signing
	 *
	 * @return array
	 */
	public function getParams() {
		return array_merge(
			[
				'SIGNTEXT_FORMAT' => 'PDF',
			],
			$this->getPdf()->getParams()
		);
	}
}