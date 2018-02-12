<?php

namespace Nodes\NemId\Login;

use Nodes\NemId\Core\FrameSettings;
use Nodes\NemId\Core\Mode;

/**
 * Class Settings.
 *
 * @author Casper Rasmussen <cr@nodes.dk>
 */
class LoginSettings extends FrameSettings {
	/**
	 * Settings constructor.
	 *
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @param array $settings
	 * @param null $mode
	 *
	 * @throws \Exception
	 */
	public function __construct(array $settings, $mode = null) {
		// Fallback to default mode
		if (!$mode || !($mode instanceof Mode)) {
			$mode = new Mode();
		}

		$this->rawSettings = $settings;

		// Decide on mode and key in settings
		if ($mode->isFromSettings()) {
			$this->isTest = (bool)$this->rawSettings['test'];
		} else {
			$this->isTest = $mode->isTest();
		}

		// Find key for setting array
		$key = $this->isTest ? 'testSettings' : 'settings';

		// Subtract settings for mode
		$settings = $this->rawSettings['iframe'][$key];

		// Init variables
		$this->baseUrl = $settings['baseUrl'];
		$this->uiMode = $settings['uiMode'];
		$this->origin = $settings['origin'];
		$this->showCancelBtn = $settings['showCancelBtn'];
		$this->privateKeyPassword = $settings['privateKeyPassword'];
		$this->privateKey = file_get_contents($settings['privateKeyLocation']);
		$this->certificate = file_get_contents($settings['certificateLocation']);
	}
}
