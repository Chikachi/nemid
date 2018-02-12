<?php

namespace Nodes\NemId\Core\CertificationCheck\Models;

/**
 * Class Subject.
 *
 * @author  Casper Rasmussen <cr@nodes.dk>
 */
abstract class Subject {
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * Subject constructor.
	 *
	 * @param array $data
	 */
	public function __construct(array $data) {
		$this->name = $data['commonName'];
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @param bool $withBusinessData
	 *
	 * @return array
	 */
	public abstract function toArray($withBusinessData = false);

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @param bool $withBusinessData
	 *
	 * @return string
	 */
	public function toJson($withBusinessData = false) {
		return json_encode($this->toArray($withBusinessData));
	}
}
