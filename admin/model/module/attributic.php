<?php 
class ModelModuleAttributic extends Model {
	public function getAttributes($data = array()) {
		$query = $this->db->query("SELECT *, (SELECT agd.name FROM " . DB_PREFIX . "attribute_group_description agd WHERE agd.attribute_group_id = a.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS attribute_group FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.attribute_group_id, a.sort_order ASC");

		return $query->rows;
	}

	public function getAttribute($attribute_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE a.attribute_id = '" . (int)$attribute_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getSetting() {
		$data = array(); 
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `store_id` = 0 AND `group` = 'attributic' AND `serialized` = 1 ORDER BY `setting_id` ASC");

		foreach ($query->rows as $result) {
			$data[$result['key']] = unserialize($result['value']);
		}

		return $data;
	}

	public function addTemplate($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `store_id` = 0, `group` = 'attributic', `key` = '" . (int)$data['settings']['template_id'] . "', `value` = '" . $this->db->escape(serialize($data['settings'])) . "', `serialized` = 1");

		$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = " . (int)$data['settings']['template_id'] . " + 1 WHERE `store_id` = 0 AND `group` = 'attributic' AND `key` = 'active'");
	}

	public function addTemplateFromProduct($data) {
		$d = $this->db->query("SELECT `value` FROM " . DB_PREFIX . "setting WHERE `store_id` = 0 AND `group` = 'attributic' AND `key` = 'active'");

		$dat['settings']['title'] = "Новый шаблон на основе " . $d->row['value'];
		$dat['settings']['template_id'] = $d->row['value'];

		foreach($data['product_attribute'] as $v){
			$dat['settings']['selected'][$v['attribute_id']] = $v['attribute_id'];
			$dat['settings']['attribute_description'][$v['attribute_id']][1] = $v['product_attribute_description'][1]['text'];
		}
		$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `store_id` = 0, `group` = 'attributic', `key` = '" . (int)$dat['settings']['template_id'] . "', `value` = '" . $this->db->escape(serialize($dat['settings'])) . "', `serialized` = 1");

		$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = " . (int)$dat['settings']['template_id'] . " + 1 WHERE `store_id` = 0 AND `group` = 'attributic' AND `key` = 'active'");

	}

	public function saveTemplate($data) {
		$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape(serialize($data['settings'])) . "' WHERE `key` = '" . (int)$data['settings']['template_id'] . "' AND `store_id` = 0 AND `group` = 'attributic'");

		if (isset($data['template_category'])) {
			foreach ($data['settings']['template_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "attributic_to_category SET template_id = '" . (int)$data['settings']['template_id'] . "', category_id = '" . (int)$category_id . "'");
			}
		}
	}

	public function deleteTemplate($template_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `store_id` = 0 AND `group` = 'attributic' AND `key` = '" . (int)$template_id . "'");
	}

	public function getTemplateCategories($template_id) {
		$template_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attributic_to_category WHERE template_id = '" . (int)$template_id . "'");

		foreach ($query->rows as $result) {
			$template_category_data[] = $result['category_id'];
		}

		return $template_category_data;
	}

	public function install() {
		$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `store_id` = 0, `group` = 'attributic', `key` = 'active', `value` = 1, `serialized` = 0");

		$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "attributic_to_category (
			`template_id` int(11) NOT NULL,
			`category_id` int(11) NOT NULL,
			PRIMARY KEY (`template_id`,`category_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
	}
}
?>