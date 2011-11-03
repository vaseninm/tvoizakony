<?php
	
	class CDeclination {
		
		const IME = 1;
		const ROD = 2;
		const DAT = 3;
		const VIN = 4;
		const TVO = 5;
		const PRE = 6;
		
		public function get ($text, $num) {
			$id = 'decl_' . md5 ($text) . '_' . $num;
			$result = Yii::app()->cache->get($id);
			if ($result) return $result;
			$json = file_get_contents("http://export.yandex.ru/inflect.xml?format=json&name=" . urlencode($text));
			$array = json_decode($json, true);
			$result = !empty($array[$num]) ? $array[$num] : $text;
			Yii::app()->cache->set($id, $result);
			return $result;
		}
	}