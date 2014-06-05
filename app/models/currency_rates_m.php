<?php
class Currency_rates_m extends MY_Model {
	protected $_table_name = 'currency_rates';
	
	public function update_rates() {
		$this->load->helper('pharse');
		$url = 'http://finance.i.ua/converter/';
		$doc = new domDocument('1.0','UTF-8');
		$doc->recover=true;
		$doc->preserveWhiteSpace=false;
		$doc->strictErrorChecking=false;
		@$doc->loadHTML('<?xml encoding="UTF-8">'.get_page_html($url, false));
		// @$doc->loadHTML('<?xml encoding="UTF-8">'.get_page_html($url));
		$elements = $doc->getElementsByTagName('script');
		foreach($elements as $node) {
			$script = $node->nodeValue;
			if (substr($script, 0, 4) == '<!--') {
				$script = substr($script, 4, strlen($script));
			}
			$pattern = '/var fn_cs = (.+);/';
			if (preg_match($pattern, $script, $matches)) {
				$parsed = array();
				parse_jsobj($matches[1], $parsed);
				$currencies = $parsed;
			}
			$pattern = '/var fn_bR = (.+);/';
			if (preg_match($pattern, $script, $matches)) {
				$parsed = array();
				parse_jsobj($matches[1], $parsed);
				$rates = $parsed;
			}
		}
		$elements = $doc->getElementById('fn_bank')->getElementsByTagName('option');
		$banks = array();
		foreach($elements as $node) {
			$banks[$node->getAttribute('value')] = $node->nodeValue;
		}
		$banks[1] = 'НБУ';
		unset($currencies[1]);
		$currency_rates = array();
		foreach ($currencies as $currency_key => $currency) {
			$currency_rates[$currency_key] = array(
				'ask_summ' => 0,
				'bid_summ' => 0,
				'count' => 0,
				'ask_average' => 0,
				'ask_max' => 0,
				'ask_max_bank' => 0,
				'ask_min' => 0,
				'ask_min_bank' => 0,
				'bid_average' => 0,
				'bid_max' => 0,
				'bid_max_bank' => 0,
				'bid_min' => 0,
				'bid_min_bank' => 0
			);
		}
		foreach ($currencies as $currency_key => $currency) {
			foreach ($rates as $bank_id => $rate) {
				if (isset($rate[$currency_key]) && $bank_id != 1) {
					$currency_rates[$currency_key]['ask_summ']+= $rate[$currency_key][1];
					if ($currency_rates[$currency_key]['ask_max'] < $rate[$currency_key][1]) {
						$currency_rates[$currency_key]['ask_max'] = $rate[$currency_key][1];
						$currency_rates[$currency_key]['ask_max_bank'] = $bank_id;
					}
					if ($currency_rates[$currency_key]['ask_min'] > $rate[$currency_key][1] || $currency_rates[$currency_key]['ask_min'] == 0) {
						$currency_rates[$currency_key]['ask_min'] = $rate[$currency_key][1];
						$currency_rates[$currency_key]['ask_min_bank'] = $bank_id;
					}
					$currency_rates[$currency_key]['bid_summ']+= $rate[$currency_key][0];
					if ($currency_rates[$currency_key]['bid_max'] < $rate[$currency_key][0]) {
						$currency_rates[$currency_key]['bid_max'] = $rate[$currency_key][0];
						$currency_rates[$currency_key]['bid_max_bank'] = $bank_id;
					}
					if ($currency_rates[$currency_key]['bid_min'] > $rate[$currency_key][0] || $currency_rates[$currency_key]['bid_min'] == 0) {
						$currency_rates[$currency_key]['bid_min'] = $rate[$currency_key][0];
						$currency_rates[$currency_key]['bid_min_bank'] = $bank_id;
					}
					$currency_rates[$currency_key]['count']++;
				}
			}
		}
		foreach ($currency_rates as $key => $currency) {
			$currency_rates[$key]['ask_average'] = round($currency['ask_summ'] / $currency['count'], 6);
			$currency_rates[$key]['bid_average'] = round($currency['bid_summ'] / $currency['count'], 6);
			unset($currency_rates[$key]['ask_summ']);
			unset($currency_rates[$key]['bid_summ']);
			unset($currency_rates[$key]['count']);
		}
		$currency_types = $this->db->get('currency_types')->result_array();
		$currencies_db = array();
		if (count($currency_types)) {
			foreach ($currency_types as $currency) {
				$currencies_db[$currency['id']] = $currency['currency'];
			}
		}
		foreach ($currencies as $currency_key => $currency) {
			if (!isset($currencies_db[$currency_key])) {
				$data = array(
					'id' => $currency_key,
					'currency' => $currency
				);
				$this->db->insert('currency_types', $data);
			}
		}
		$currency_banks = $this->db->get('currency_banks')->result_array();
		$banks_db = array();
		if (count($currency_banks)) {
			foreach ($currency_banks as $bank) {
				$banks_db[$bank['id']] = $bank['bank'];
			}
		}
		foreach ($banks as $bank_key => $bank) {
			if (!isset($banks_db[$bank_key])) {
				$data = array(
					'id' => $bank_key,
					'bank' => $bank
				);
				$this->db->insert('currency_banks', $data);
			}
		}
		foreach ($currency_rates as $currency_type => $rates) {
			$rates['created'] = time();
			$rates['currency_type'] = $currency_type;
			$this->db->insert('currency_rates', $rates);
		}
		// dump($currency_rates);
		// dump($currencies);
		// dump($banks);
		// dump(time());
	}
	
	public function get_currency_type($currency_type) {
		$this->db->select('
			currency_types.currency,
			currency_rates.created,
			currency_rates.ask_average,
			currency_rates.ask_min,
			ask_min_bank_table.bank AS ask_min_bank,
			currency_rates.bid_average,
			currency_rates.bid_max,
			bid_max_bank_table.bank AS bid_max_bank
		');
		$this->db->from($this->_table_name);
		$this->db->join('currency_types', 'currency_types.id = currency_rates.currency_type', 'left');
		$this->db->join('currency_banks AS ask_min_bank_table', 'ask_min_bank_table.id = currency_rates.ask_min_bank', 'left');
		$this->db->join('currency_banks AS bid_max_bank_table', 'bid_max_bank_table.id = currency_rates.bid_max_bank', 'left');
		$this->db->where('currency_types.currency', $currency_type);
		$this->db->order_by('created', 'desc');
		$this->db->limit(1);
		$db_data = $this->db->get()->row_array();
		$db_data['ask_average'] = number_format($db_data['ask_average'], 4);
		$db_data['ask_min'] = number_format($db_data['ask_min'], 4);
		$db_data['bid_average'] = number_format($db_data['bid_average'], 4);
		$db_data['bid_max'] = number_format($db_data['bid_max'], 4);
		return $db_data;
	}
	
	public function get_last_rates() {
		$this->load->model('currency_types_m');
		$currency_types = $this->currency_types_m->get();
		$last_rates = array();
		foreach ($currency_types as $currency_type) {
			$last_rates[] = $this->get_currency_type($currency_type->currency);
		}
		return $last_rates;
	}
}