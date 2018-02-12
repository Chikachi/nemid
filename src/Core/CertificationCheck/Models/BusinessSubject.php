<?php
namespace Nodes\NemId\Core\CertificationCheck\Models;

class BusinessSubject extends Subject {
	protected $cvr;
	protected $rid;
	protected $businessData = null;

	/**
	 * BusinessSubject constructor.
	 *
	 * @param array $data
	 */
	public function __construct(array $data) {
		parent::__construct($data);
		list($cvr, $rid) = explode('-', $data['serialNumber']);
		$this->cvr = intval(explode(':', $cvr)[1], 10);
		$this->rid = intval(explode(':', $rid)[1], 10);
	}

	/**
	 * @return mixed
	 */
	public function getCvr() {
		return $this->cvr;
	}

	/**
	 * @return mixed
	 */
	public function getRid() {
		return $this->rid;
	}

	/**
	 * @return mixed
	 */
	public function getBusinessData() {
		if ($this->businessData == null) {
			$ch = curl_init();
			curl_setopt_array(
				$ch,
				[
					CURLOPT_URL => 'http://cvrapi.dk/api?vat='.$this->getCvr().'&country=dk',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_USERAGENT => 'Nodes/NemId - Chikachi fork - chikachi@chikachi.net',
				]
			);
			$result = curl_exec($ch);
			curl_close($ch);

			if ($result !== false) {
				$this->businessData = json_decode($result, true);
			}
		}

		return $this->businessData;
	}

	/**
	 * @author Casper Rasmussen <cr@nodes.dk>
	 *
	 * @param bool $withBusinessData
	 *
	 * @return array
	 */
	public function toArray($withBusinessData = false) {
		$result = [
			'name' => $this->getName(),
			'cvr' => $this->getCvr(),
			'rid' => $this->getRid(),
		];
		if ($withBusinessData) {
			$result['business'] = $this->getBusinessData();
		}
		return $result;
	}
}