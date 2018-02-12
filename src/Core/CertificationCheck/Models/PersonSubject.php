<?php
namespace Nodes\NemId\Core\CertificationCheck\Models;

class PersonSubject extends Subject {
	protected $pid;

	/**
	 * Subject constructor.
	 *
	 * @param array $data
	 */
	public function __construct(array $data) {
		parent::__construct($data);
		$this->pid = explode(':', $data['serialNumber'])[1];
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @return string
	 */
	public function getPid() {
		return $this->pid;
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @param bool $withBusinessData
	 *
	 * @return array
	 */
	public function toArray($withBusinessData = false) {
		return [
			'name' => $this->getName(),
			'pid' => $this->getPid(),
		];
	}
}