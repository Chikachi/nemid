<?php

namespace Nodes\NemId\Login\CertificationCheck\Models;

/**
 * Class Subject.
 *
 * @author  Casper Rasmussen <cr@nodes.dk>
 */
class Subject {
	/**
	 * @var string
	 */
	protected $name;
	protected $pid;
	protected $cvr;
	protected $rid;
	protected $isPerson = false;

	/**
	 * Subject constructor.
	 *
	 * @param array $data
	 */
	public function __construct(array $data) {
		$this->name = $data['commonName'];
		$this->isPerson = strpos($data['serialNumber'], 'PID') === 0;
		if ($this->isPerson) {
			$this->pid = explode(':', $data['serialNumber'])[1];
		} else {
			list($cvr, $rid) = explode('-', $data['serialNumber']);
			$this->cvr = intval(explode(':', $cvr)[1], 10);
			$this->rid = intval(explode(':', $rid)[1], 10);
		}
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
	 * @return string
	 * @throws \Exception
	 */
	public function getPid() {
		if (!$this->isPerson()) {
			throw new \Exception('Tried to get PID on non-person');
		}
		return $this->pid;
	}

	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public function getCvr() {
		if ($this->isPerson()) {
			throw new \Exception('Tried to get CVR on person');
		}
		return $this->cvr;
	}

	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public function getRid() {
		if ($this->isPerson()) {
			throw new \Exception('Tried to get RID on person');
		}
		return $this->rid;
	}

	/**
	 * @return bool
	 */
	public function isPerson() {
		return $this->isPerson;
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @return array
	 */
	public function toArray() {
		$result = [
			'name' => $this->getName(),
		];
		try {
			if ($this->isPerson()) {
				$result['pid'] = $this->getPid();
			} else {
				$result['cvr'] = $this->getCvr();
				$result['rid'] = $this->getRid();
			}
		} catch (\Exception $ignored) {}
		return $result;
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @return string
	 */
	public function toJson() {
		return json_encode($this->toArray());
	}
}
