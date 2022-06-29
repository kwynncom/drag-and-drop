<?php

require_once('/opt/kwynn/kwutils.php');

class dragDemo extends dao_generic_3 {
	
	const elen = 5;
	const ordxInterval = 100000;
	const baseOrdx     = 100000000000;
	
	public function __construct() {
		$this->init();
		$this->initcli();
		$this->set();
	}
	
	private function init() {
		parent::__construct('dragEx');
		$this->creTabs('order');
		
	}
	
	private function initcli() {
		if (isrv('action') !== 'init') return;
		$this->initDat();
		$dat = $this->ocoll->find([], ['sort' => ['ordx' => 1]]);
		$r['dat'] = $dat;
		$r['meta'] = $this->getMeta();
		kwjae($r);
		
	}
	
	private function getMeta() {
		// $a['dragURL'] = '/t/22/06/drag/server.php';
		$a['interval'] = self::ordxInterval;
		$a['dbuqid'  ] = '_id';
		$a['dbuqidType'] = 'string';
		$a['dbordxfn'  ] = 'ordx';
		$a['actionName'  ] = 'action';
		$a['actionValue'] = 'setOrder';
		$a['returnStatusName'] = 'postOrdxSave';
		$a['returnStatusOKValue'] = 'OK';
				return $a;
	}
	
	private function initDat() {
		if ($this->ocoll->count() > 0) return;
		
		$dat = [];
		
		for ($i=0; $i < self::elen; $i++) {
			$d = [];
			$v = chr(ord('A') + $i);
			$d['_id'] = $v;
			$d['ordx'] = self::baseOrdx + (self::ordxInterval * ($i + 1));
			$d['v'] = $v;
			
			$dat[] = $d;
			continue;
		}
		
		$this->ocoll->insertMany($dat);
		
		return;
	}
	
	private function set() {
		if (isrv('action') !== 'setOrder') return;
		$id = isrv('_id');
		kwas(preg_match('/^[A-Z]$/', $id), 'bad id');
		$or = isrv('ordx');
		kwas(is_numeric($or), 'bad orderx');
		$ox = floatval($or); unset($or);
		kwas($ox > 0, 'ordx must be positive');
		$q = ['_id' => $id];
		$dat = $q;
		$dat['ordx'] = $ox;
		$this->ocoll->upsert($q, $dat);
		$dat['postOrdxSave'] = 'OK';
		kwjae($dat);
	}
	
	
}

new dragDemo();