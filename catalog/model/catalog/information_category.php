<?php
class ModelCatalogInformationCategory extends Model {
	public function getInformationCategory($information_category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "information_category i LEFT JOIN " . DB_PREFIX . "information_category_description id ON (i.information_category_id = id.information_category_id) LEFT JOIN " . DB_PREFIX . "information_category_to_store i2s ON (i.information_category_id = i2s.information_category_id) WHERE i.information_category_id = '" . (int)$information_category_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1'");
	
		return $query->row;
	}
	
	public function getInformationCategories() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_category i LEFT JOIN " . DB_PREFIX . "information_category_description id ON (i.information_category_id = id.information_category_id) LEFT JOIN " . DB_PREFIX . "information_category_to_store i2s ON (i.information_category_id = i2s.information_category_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1' ORDER BY i.sort_order, LCASE(id.title) ASC");
		
		return $query->rows;
	}

	public function getInformations($category_id = 0) {
		if ($category_id != 0) {
			$sql = "AND category_id = " . (int)$category_id;
		} else {
			$sql = "";
		}
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1' AND i.category_id != 0 " . $sql . " ORDER BY i.date_added DESC");

		return $query->rows;
	}

	public function getTotalInformations($category_id = 0) {
		if ($category_id != 0) {
			$sql = "AND category_id = " . (int)$category_id;
		} else {
			$sql = "";
		}
		$query = $this->db->query("SELECT COUNT(*) AS count FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1' AND category_id != 0 " . $sql);

		return $query->row['count'];
	}
	
	public function getInformationCategoryLayoutId($information_category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_category_to_layout WHERE information_category_id = '" . (int)$information_category_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
		 
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return $this->config->get('config_layout_information_category');
		}
	}	
}
?>