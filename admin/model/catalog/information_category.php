<?php
class ModelCatalogInformationCategory extends Model {
	public function addInformationCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "information_category SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "'");

		$information_category_id = $this->db->getLastId(); 
		
		foreach ($data['information_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "information_category_description SET information_category_id = '" . (int)$information_category_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', seo_title = '" . $this->db->escape($value['seo_title']) . "', seo_h1 = '" . $this->db->escape($value['seo_h1']) . "'");
		}
		
		if (isset($data['information_category_store'])) {
			foreach ($data['information_category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_category_to_store SET information_category_id = '" . (int)$information_category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['information_category_layout'])) {
			foreach ($data['information_category_layout'] as $store_id => $layout) {
				if ($layout) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "information_category_to_layout SET information_category_id = '" . (int)$information_category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
				
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information_category_id=" . (int)$information_category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('information_category');
	}
	
	public function editInformationCategory($information_category_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "information_category SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "' WHERE information_category_id = '" . (int)$information_category_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "information_category_description WHERE information_category_id = '" . (int)$information_category_id . "'");
					
		foreach ($data['information_category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "information_category_description SET information_category_id = '" . (int)$information_category_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', seo_title = '" . $this->db->escape($value['seo_title']) . "', seo_h1 = '" . $this->db->escape($value['seo_h1']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "information_category_to_store WHERE information_category_id = '" . (int)$information_category_id . "'");
		
		if (isset($data['information_category_store'])) {
			foreach ($data['information_category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "information_category_to_store SET information_category_id = '" . (int)$information_category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "information_category_to_layout WHERE information_category_id = '" . (int)$information_category_id . "'");

		if (isset($data['information_category_layout'])) {
			foreach ($data['information_category_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "information_category_to_layout SET information_category_id = '" . (int)$information_category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
				
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'information_category_id=" . (int)$information_category_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information_category_id=" . (int)$information_category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('information_category');
	}
	
	public function deleteInformationCategory($information_category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "information_category WHERE information_category_id = '" . (int)$information_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "information_category_description WHERE information_category_id = '" . (int)$information_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "information_category_to_store WHERE information_category_id = '" . (int)$information_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "information_category_to_layout WHERE information_category_id = '" . (int)$information_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'information_category_id=" . (int)$information_category_id . "'");

		$this->cache->delete('information_category');
	}	

	public function getInformationCategory($information_category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'information_category_id=" . (int)$information_category_id . "') AS keyword FROM " . DB_PREFIX . "information_category WHERE information_category_id = '" . (int)$information_category_id . "'");
		
		return $query->row;
	}
		
	public function getInformationCategories($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "information_category i LEFT JOIN " . DB_PREFIX . "information_category_description id ON (i.information_category_id = id.information_category_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
			$sort_data = array(
				'id.title',
				'i.sort_order'
			);		
		
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY id.title";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
		
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}		

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}	
			
			$query = $this->db->query($sql);
			
			return $query->rows;
		} else {
			$information_category_data = $this->cache->get('information_category.' . (int)$this->config->get('config_language_id'));
		
			if (!$information_category_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_category i LEFT JOIN " . DB_PREFIX . "information_category_description id ON (i.information_category_id = id.information_category_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY id.title");
	
				$information_category_data = $query->rows;
			
				$this->cache->set('information_category.' . (int)$this->config->get('config_language_id'), $information_category_data);
			}	
	
			return $information_category_data;			
		}
	}
	
	public function getInformationCategoryDescriptions($information_category_id) {
		$information_category_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_category_description WHERE information_category_id = '" . (int)$information_category_id . "'");

		foreach ($query->rows as $result) {
			$information_category_description_data[$result['language_id']] = array(
				'seo_title'        => $result['seo_title'],
				'seo_h1'           => $result['seo_h1'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'title'       => $result['title']
			);
		}
		
		return $information_category_description_data;
	}
	
	public function getInformationCategoryStores($information_category_id) {
		$information_category_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_category_to_store WHERE information_category_id = '" . (int)$information_category_id . "'");

		foreach ($query->rows as $result) {
			$information_category_store_data[] = $result['store_id'];
		}
		
		return $information_category_store_data;
	}

	public function getInformationCategoryLayouts($information_category_id) {
		$information_category_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_category_to_layout WHERE information_category_id = '" . (int)$information_category_id . "'");
		
		foreach ($query->rows as $result) {
			$information_category_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $information_category_layout_data;
	}
		
	public function getTotalInformationCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "information_category");
		
		return $query->row['total'];
	}	
	
	public function getTotalInformationCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "information_category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}	
}
?>