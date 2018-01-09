<?php
namespace Nodes\NemId\Sign\Data;

interface ISignData {
	/**
	 * Get params for signing
	 *
	 * @return array
	 */
	public function getParams();
}