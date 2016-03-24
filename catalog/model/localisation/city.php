<?php
error_reporting(E_ALL);
class ModelLocalisationCity extends Model {
	
	public function test($zone_id,$zone_name) {
		/*
		echo $zone_id;
		//$this->db->query("DELETE FROM " . DB_PREFIX . "city WHERE zone_id = {$zone_id}");
		
		echo '<meta charset="utf-8">';
		echo '<pre>';
		//$this->db->query("DELETE FROM " . DB_PREFIX . "city WHERE zone_id = "); 
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "city");
		print_r($query->rows);
		*/
		if($zone_id!=0){
			
			$q = $this->db->query("SELECT ref FROM " . DB_PREFIX . "zone WHERE zone_id = {$zone_id}");
			$this->updateCity($zone_id, $q->row['ref']);
			
		}
    }
	public function updateCity($zone_id, $ref){
		$key = '4b78edcc0991a64316c960a9e313a442';
		
		$data = array(
			'apiKey' => $key,
			'modelName' => 'Address',
			'calledMethod' => 'getWarehouses',
			'language' => 'ru',
			'methodProperties' => array(
				'CityRef'=>$ref
			)
		);
		$data = json_encode($data);
		$ch = curl_init();                                                                      
		  
			curl_setopt($ch, CURLOPT_URL, 'https://api.novaposhta.ua/v2.0/json/');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		   
		$output = curl_exec($ch);
		$data = json_decode($output);
		if($data->success==false){
			$this->db->query("INSERT " . DB_PREFIX . "novaposhta_report SET text='При запросе API вернул false. Проверте ключ, или доступ к сервису', date='{date('Y-m-d')}'");
		}
		$i = 0;
		foreach($data->data as $row){
			
			$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "city WHERE ref = '{$row->Ref}'");
			
			if(!empty($row->DescriptionRu)&&empty($query->row['name'])){
				$i++;
				$this->db->query(
					"INSERT INTO `" . DB_PREFIX . "city` (`city_id`, `zone_id`, `name`, `code`, `status`, `ref`) VALUES
					(NULL, '{$zone_id}', '{$row->DescriptionRu}', '', '1', '{$row->Ref}')");
			}
		}
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "zone WHERE zone_id = '{$zone_id}'");
		$city = $query->row['name'];
		$date = date('Y-m-d');
		
		if($i>0)
			$this->db->query("INSERT " . DB_PREFIX . "novapochta_report SET text='Парсер успешно добавил {$i} отделений в городе {$city}', date='{$date}'");
	}
	
    public function getCity($city_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "city WHERE city_id = '" . (int)$city_id . "'");

		return $query->row;
    }

    public function getCities($data = array()) {
        $city_data = $this->cache->get('city.status');

		if (!$city_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "city WHERE status = '1' ORDER BY name ASC");

			$city_data = $query->rows;

			$this->cache->set('city.status', $city_data);
		}

		return $city_data;
    }

    public function getCitiesByZoneId($zone_id) {
		$city_data = $this->cache->get('city.' . (int)$zone_id);

		if (!$city_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "city WHERE zone_id = '" . (int)$zone_id . "' AND status = '1' ORDER BY name");

			$city_data = $query->rows;

			$this->cache->set('city.' . (int)$zone_id, $city_data);
		}

		return $city_data;
	}
}
?>