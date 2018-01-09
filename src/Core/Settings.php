<?php
namespace Nodes\NemId\Core;

abstract class Settings {
	/**
	 * @var *
	 */
	protected $rawSettings;
	/**
	 * @var boolean
	 */
	protected $isTest = false;

	/**
	 * @return bool
	 */
	public function isTest() {
		return $this->isTest == true;
	}
}