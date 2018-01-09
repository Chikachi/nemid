<?php
namespace Nodes\NemId\Core;

abstract class iFrameGenerator {
	/**
	 * @var FrameSettings
	 */
	protected $settings;
	/**
	 * @var int
	 */
	protected $timeStamp;
	/**
	 * @var string
	 */
	protected $iFrameUrl;
	protected $params;

	/**
	 * iFrameGenerator constructor.
	 *
	 * @param FrameSettings $settings
	 */
	public function __construct(FrameSettings $settings) {
		$this->settings = $settings;
		$this->timeStamp = (int)round(microtime(true) * 1000);

		$this->generateIFrameUrl();
		$this->generateParams();
	}

	/**
	 * Generates the iFrame url by combining baseUrl, uiMode and timeStamp.
	 */
	private function generateIFrameUrl() {
		$this->iFrameUrl = $this->settings->getBaseUrl().'launcher/'.$this->settings->getUiMode().'/'.$this->timeStamp;
	}

	/**
	 * Generate the params for iFrame.
	 */
	abstract function generateParams();

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @return string
	 */
	public function getIFrameUrl() {
		return $this->iFrameUrl;
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @return mixed
	 */
	public function getParams() {
		return $this->params;
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @return string
	 */
	public function getBaseUrl() {
		return $this->settings->getBaseUrl();
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @return FrameSettings
	 */
	public function getSettings() {
		return $this->settings;
	}
}