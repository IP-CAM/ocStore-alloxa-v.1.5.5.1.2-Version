<?php
class ModelCatalogAStickers extends Model {
	public function add($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "astickers SET name = '" . $this->db->escape($data['name']) . "', images = '" . serialize ($data['images']) . "', sort_order = '" . (int) $data['sort_order'] . "'");
		
		$this->cache->delete('astickers');
	}
	
	public function edit($asticker_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "astickers SET name = '" . $this->db->escape($data['name']) . "', images = '" . serialize ($data['images']) . "', sort_order = '" . (int) $data['sort_order'] . "' WHERE asticker_id = '" . (int) $asticker_id . "'");
		
		$this->cache->delete('astickers');
	}
	
	public function delete($asticker_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "astickers WHERE asticker_id = '" . (int) $asticker_id . "'");
		
		$this->cache->delete('astickers');
	}
	
	public function getAStickerById($asticker_id) {
		return $this->db->query("SELECT * FROM " . DB_PREFIX . "astickers WHERE asticker_id = '" . (int) $asticker_id . "'")->row;
	}
	
	public function getAStickersAll() {
		$astickers = $this->cache->get('astickers');
		
		if (!$astickers) {
			$astickers = $this->db->query("SELECT asticker_id, name FROM " . DB_PREFIX . "astickers")->rows;
			
			$this->cache->set('astickers', $astickers);
		}
		
		return $astickers;
	}
	
	public function getAStickers($data = array ()) {
		$sort_data = array ('ast.name', 'ast.sort_order');
		
		$sql = "SELECT * FROM " . DB_PREFIX . "astickers ast";
		
		if (isset ($data['sort']) && in_array ($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY ast.name";
		}
		
		if (isset ($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset ($data['start']) || isset ($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
			
			$sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
		}
		
		return $this->db->query($sql)->rows;
	}
	
	public function getProductsByAStickerId($asticker_id) {
		return $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE asticker_id = '" . (int) $asticker_id . "'")->row['total'];
	}
	
	public function getTotalAStickers($data = array ()) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "astickers");
		
		return $query->row['total'];
	}
	
	public function getProducts($data = array ()) {
		$sort_data = array ('p.image', 'pd.name', 'p.sort_order', 'p.price', 'ast.name', 'p.asticker_date_start', 'p.asticker_date_end');
		
		$sql = "SELECT p.product_id AS product_id, p.image AS image, pd.name AS name, p.price AS price, p.sort_order AS sort_order, p.date_available AS date_available, ast.name AS asticker_name, ast.images AS asticker_images, p.asticker_date_start AS asticker_date_start, p.asticker_date_end AS asticker_date_end FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "astickers ast ON (p.asticker_id = ast.asticker_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";
		
		if ($data['filter_category_id']) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";
		}
		
		$sql .= " WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "'";
		
		$sql .= $this->getFilterSql($data);
		
		$sql .= " GROUP BY p.product_id";
		
		if (isset ($data['sort']) && in_array ($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
		}
		
		if (isset ($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset ($data['start']) || isset ($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
			
			$sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
		}
		
		return $this->db->query($sql)->rows;
	}
	
	public function getTotalProducts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";
		
		if ($data['filter_category_id']) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";
		}
		
		if ($data['filter_asticker_id']) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "astickers ast ON (p.asticker_id = ast.asticker_id)";
		}
		
		$sql .= " WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "'";
		
		$sql .= $this->getFilterSql($data);
		
		return $this->db->query($sql)->row['total'];
	}
	
	public function editProducts($data) {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET asticker_id = '" . (int) $data['asticker_id'] . "', asticker_date_start = '" . $data['asticker_date_start'] . "', asticker_date_end = '" . $data['asticker_date_end'] . "' WHERE product_id IN (" . implode (',', $data['selected']) . ")");
	}
	
	private function getFilterSql($data) {
		$sql = '';
		
		if ($data['filter_keyword']) {
			$sql .= " AND LCASE(pd.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_keyword'])) . "%'";
		}
		
		if ($data['filter_category_id']) {
			$sql .= " AND p2c.category_id IN (" . implode (',', $data['filter_category_id']) . ")";
		}
		
		if ($data['filter_asticker_id']) {
			$sql .= " AND ast.asticker_id IN (" . implode (',', $data['filter_asticker_id']) . ")";
		}
		
		if ($data['filter_asticker_date_start']) {
			$sql .= " AND p.asticker_date_start = '" . $this->db->escape($data['filter_asticker_date_start']) . "'";
		}
		
		if ($data['filter_asticker_date_end']) {
			$sql .= " AND p.asticker_date_end = '" . $this->db->escape($data['filter_asticker_date_end']) . "'";
		}
		
		return $sql;
	}
}
?>