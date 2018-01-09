<?php
namespace Nodes\NemId\Sign\PDF;

/**
 * Interface IPDF
 * Can be raw PDF content, local or remote PDF file
 * @package Nodes\NemId\Sign\PDF
 */
interface IPDF {
	/**
	 * Get params for signing
	 *
	 * @return array
	 */
	public function getParams();
}