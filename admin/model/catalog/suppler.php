<?php 
class ModelCatalogSuppler extends Model {
	public function createTables() {
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "suppler (form_id INT(10) AUTO_INCREMENT, suppler_id INT(11), name varchar(64), sort_order INT(13), rate decimal(12,4), cod varchar(128), item varchar(128), cat varchar(128), qu varchar(128), price varchar(128), descrip varchar(128), pic_ext varchar(64), manuf varchar(128), warranty varchar(64), ad varchar(1), status INT(2), my_cat INT(5), my_qu varchar(128), my_price INT(2), my_descrip varchar(512), my_manuf varchar(64), my_mark varchar(512), weight varchar(3), length varchar(3), width varchar(3), height varchar(3), parent  varchar(1), hide varchar(1), newphoto varchar(1), my_photo varchar(512), cheap varchar(3), addopt varchar(1), addseo varchar(1), related varchar(3), updte varchar(1), pmanuf varchar(1), upattr varchar(1), upopt varchar(1), upname varchar(1), myplus varchar(3), cprice varchar(3), minus varchar(1), chcode varchar(1), importseo varchar(1), sorder  varchar(3), spec varchar(3), upurl varchar(3), ref varchar(3), addattr varchar(1), exsame varchar(1), sku2  varchar(3), parss varchar(3), points varchar(64), places varchar(5), parsi varchar(3), pointi varchar(64), placei varchar(5), parsc varchar(3), pointc varchar(64), placec varchar(5), parsp varchar(3), pointp varchar(64), placep varchar(5), parsd varchar(3), pointd varchar(64), placed varchar(5), parsm varchar(3), pointm varchar(64), placem varchar(5), parsk varchar(3), catcreate varchar(1), stay varchar(1), joen varchar(1), off varchar(1), umanuf varchar(1), onn   varchar(12),  refer varchar(3), disc varchar(12), newurl varchar(1), upc varchar(3), ean varchar(3), mpn varchar(3), ddata varchar(3), PRIMARY KEY (form_id)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "suppler_data (nom_id int(11) AUTO_INCREMENT, form_id int(11), cat_ext varchar(128), category_id int(11), pic_int varchar(160), cat_plus varchar(512), PRIMARY  KEY (nom_id)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "suppler_attributes (nom_id int(11) AUTO_INCREMENT, form_id int(11), attr_ext varchar(128), attr_point varchar(64), attribute_id int(11), tags varchar(1), PRIMARY KEY (nom_id))  ENGINE=MyISAM DEFAULT CHARSET=utf8");
		
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "suppler_options (nom_id int(11) AUTO_INCREMENT, 
		form_id int(11), option_id int(11), opt varchar(3), po varchar(3), ko varchar(3), pr varchar(3), we varchar(3), `option_required` varchar(1), PRIMARY KEY (nom_id)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "suppler_sku_description (nom_id int(11) AUTO_INCREMENT, sku_id int(11), sku varchar(128), PRIMARY  KEY (nom_id)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "suppler_sku (nom_id int(11) AUTO_INCREMENT, sku_id int(11), product_id int(11), PRIMARY  KEY (nom_id)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "relatedoptions (relatedoptions_id int(11) AUTO_INCREMENT, product_id int(11), quantity int(4), PRIMARY  KEY (relatedoptions_id)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "relatedoptions_option  (relatedoptions_id int(11), product_id int(11), option_id int(11), option_value_id int(11)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "relatedoptions_variant  (relatedoptions_variant_id int(11) AUTO_INCREMENT, relatedoptions_variant_name varchar(255), PRIMARY  KEY (relatedoptions_variant_id)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
				
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "relatedoptions_variant_option  (relatedoptions_variant_id int(11), option_id int(11)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "relatedoptions_variant_product  (relatedoptions_variant_id int(11), product_id int(11), relatedoptions_use tinyint(1)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "suppler_price (nom_id int(11) AUTO_INCREMENT, form_id int(11), nom varchar(3), ident varchar(16), param varchar(128), point varchar(64),  PRIMARY  KEY (nom_id)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "suppler_ref (nom_id int(11) AUTO_INCREMENT, product_id int(11), ident varchar(16), param varchar(128), point varchar(64), url text, PRIMARY  KEY (nom_id)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
		
		$this->cache->delete('suppler');
	}
	
	public function getMaxSuppler() {	
		$query = $this->db->query("SELECT max(suppler_id) FROM " . DB_PREFIX . "suppler");	
		return $query->row;
	}
	
	public function getMaxCategoryID() {	
		$query = $this->db->query("SELECT max(category_id) FROM " . DB_PREFIX . "category");	
		return $query->row;
	}
	
	public function getMaxManufacturerID() {	
		$query = $this->db->query("SELECT max(manufacturer_id) FROM " . DB_PREFIX . "manufacturer");	
		return $query->row;
	}

	public function addSuppler($data) {
		if (!isset($data['suppler_id']) or !$data['suppler_id']) {
			$row = $this->getMaxSuppler();
			if (!empty($row)) $data['suppler_id'] = $row['max(suppler_id)'] + 1;
			else $data['suppler_id'] = 1;		
		}
		$data['rate'] = str_replace(',','.',trim($data['rate']));
		if (!$data['rate']) $data['rate'] = 1.0;
		
		$lang = $this->config->get('config_language_id');
		
      	$this->db->query("INSERT INTO " . DB_PREFIX . "suppler SET `suppler_id` = '". $data['suppler_id'] . "', `name` = '" . $this->db->escape($data['name']) . "', `sort_order` = '" . $lang . "', `rate` = '" . $data['rate'] . "', `cod` = '" . $this->db->escape($data['cod']) . "', `item` = '" . $this->db->escape($data['item']) . "', `cat` = '" . $this->db->escape($data['cat']) . "', `qu` = '" . $this->db->escape($data['qu']) . "', `price` = '" . $this->db->escape($data['price']) . "', `descrip` = '" . $this->db->escape($data['descrip']) . "', `pic_ext` = '" . $this->db->escape($data['pic_ext']) . "', `manuf` = '" . $this->db->escape($data['manuf']) . "', `warranty` = '" . $this->db->escape($data['warranty']) . "', `ad` = '" . $data['ad'] . "', `status` = '" . $data['status'] . "', `my_cat` = '" . $data['my_cat'] . "', `my_qu` = '" . $this->db->escape($data['my_qu']) . "', `my_price` = '" . $data['my_price'] . "', `my_descrip` = '" . $this->db->escape($data['my_descrip']) . "', `my_manuf` = '" . $this->db->escape($data['my_manuf']) . "', `my_mark` = '" . $this->db->escape($data['my_mark']) . "', `weight` = '" . $this->db->escape($data['weight']) . "', `length` = '" . $this->db->escape($data['length']) . "', `width` = '" . $this->db->escape($data['width']) . "', `height` = '" . $this->db->escape($data['height']) ."', `parent` = '" . $data['parent'] ."', `hide` = '" . $data['hide'] ."', `newphoto` = '" . $this->db->escape($data['newphoto']) ."', `my_photo` = '" . $this->db->escape($data['my_photo']) ."', `cheap` = '" . $data['cheap'] ."', `addopt` = '" . $data['addopt'] ."', `addseo` = '" . $data['addseo'] . "', `related` = '" . $this->db->escape($data['related']) ."', `updte` = '" . $data['updte'] . "', `pmanuf` = '" . $data['pmanuf'] ."', `upattr` = '" . $data['upattr']."', `upopt` = '" . $data['upopt']. "', `upname` = '" . $data['upname']. "', `myplus` = '" . $data['myplus']. "', `cprice` = '" . $data['cprice']. "', `minus` = '" . $data['minus']. "', `chcode` = '" . $data['chcode']. "',  `importseo` = '" . $data['importseo'] ."', `sorder` = '" . $data['sorder']."', `spec` = '" . $data['spec']."', `upurl` = '" . $data['upurl']."', `ref` = '" . $data['ref']."', `addattr` = '" . 0 ."', `exsame` = '" . 0 ."', `sku2` = '" . $data['sku2']."', `parss` = '" . $data['parss'] . "', `points` = '" . $data['points'] . "', `places` = '" . $data['places'] . "', `parsi` = '" . $data['parsi'] . "', `pointi` = '" . $data['pointi'] . "', `placei` = '" . $data['placei'] . "', `parsc` = '" . $data['parsc'] . "', `pointc` = '" . $data['pointc'] . "', `placec` = '" . $data['placec'] . "', `parsp` = '" . $data['parsp'] . "', `pointp` = '" . $data['pointp'] . "', `placep` = '" . $data['placep'] . "', `parsd` = '" . $data['parsd'] . "', `pointd` = '" . $data['pointd'] . "', `placed` = '" . $data['placed'] . "', `parsm` = '" . $data['parsm'] . "', `pointm` = '" . $data['pointm'] . "', `placem` = '" . $data['placem'] . "', `parsk` = '" . $data['parsk'] . "', `catcreate` = '" .  0 . "', `stay` = '" . $data['stay'] . "', `joen` = '" . $data['joen'] . "', `off` = '" . $data['off'] . "', `umanuf` = '" . $data['umanuf'] . "', `onn` = '" . $data['onn'] . "', `refer` = '" . $data['refer'] . "', `disc` = '" . $data['disc'] . "', `newurl` = '" . $data['newurl'] ."', `upc` = '" . $data['upc'] . "', `ean` = '" . $data['ean'] . "', `mpn` = '" . $data['mpn'] . "', `ddata` = '" . 0 ."'");
		
		$form_id = $this->db->getLastId();
				
		$i = 0;	
		foreach ($data['cat_ext'] as $value) {
		  if ($data['cat_ext'][$i]) {		  
			$this->db->query("INSERT INTO " . DB_PREFIX . "suppler_data SET `form_id` = '" . (int)$form_id . "', `cat_ext` = '" . $this->db->escape($data['cat_ext'][$i]) . "', `category_id` = '" . (int)$data['category_id'][$i] . "', `pic_int` = '" . $data['pic_int'][$i] . "', `cat_plus` = '" . $data['cat_plus'][$i] . "'");
		  }
			$i = $i +1;
		}
	
		$i = 0;	
		foreach ($data['attr_ext'] as $value) {
		  if ($data['attr_ext'][$i]) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "suppler_attributes SET `form_id` = '" . (int)$form_id . "', `attr_ext` = '" . $this->db->escape($data['attr_ext'][$i]) . "', `attr_point` = '". $this->db->escape($data['attr_point'][$i]) . "', `attribute_id` = '" . (int)$data['attribute_id'][$i] . "', `tags` = '" . $data['tags'][$i] . "'");
		  }
			$i = $i +1;			
		}

		$i = 0;	
		foreach ($data['opt'] as $value) {
		  if ($data['opt'][$i]) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "suppler_options SET `form_id` = '" . (int)$form_id . "', `opt` = '" . (int)$data['opt'][$i] . "', `option_id` = '" . (int)$data['option_id'][$i] . "', `po` = '" . $this->db->escape($data['po'][$i]) ."', `ko` = '" . $this->db->escape($data['ko'][$i]) . "', `pr` = '" . $this->db->escape($data['pr'][$i]) ."', `we` = '" . $this->db->escape($data['we'][$i]) ."',   `option_required` = '" . $this->db->escape($data['option_required'][$i]) ."'");
		  }
			$i = $i +1;			
		}
		
		$i = 0;	
		foreach ($data['nom'] as $value) {
		  if ($data['nom'][$i]) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "suppler_price SET `form_id` = '" . (int)$form_id . "', `nom` = '" . $data['nom'][$i] . "', `ident` = '" . $data['ident'][$i] . "', `param` = '" . $this->db->escape($data['param'][$i]) ."', `point` = '" . $this->db->escape($data['point'][$i]) . "'");
		  }
			$i = $i +1;			
		}
		
		$this->cache->delete('suppler');		
	}
	
	public function editsuppler($form_id, $data) {
		if (!isset($data['suppler_id']) or !$data['suppler_id']) return;
		
		if ($data['name'] == "New" or $data['name'] == "new" or $data['name'] == "NEW")  {			
			$this->addSuppler($data);
			return;
		}	
			
		$data['rate'] = str_replace(',','.',trim($data['rate']));
		if (!$data['rate']) $data['rate'] = 1.0;
	
		$lang = $this->config->get('config_language_id');
			
      	$this->db->query("UPDATE " . DB_PREFIX . "suppler SET `suppler_id` =  '". $data['suppler_id'] . "', `name` = '" . $this->db->escape($data['name']) . "', `sort_order` = '" . $lang . "', `rate` = '" . $data['rate'] . "', `cod` = '" . $this->db->escape($data['cod']) . "', `item` = '" . $this->db->escape($data['item']) . "', `cat` = '" . $this->db->escape($data['cat']) . "', `qu` = '" . $this->db->escape($data['qu']) . "', `price` = '" . $this->db->escape($data['price']) . "', `descrip` = '" . $this->db->escape($data['descrip']) . "', `pic_ext` = '" . $this->db->escape($data['pic_ext']) . "', `manuf` = '" . $this->db->escape($data['manuf']) . "', `warranty` = '" . $this->db->escape($data['warranty']) . "', `ad` = '" . $data['ad'] . "', `status` = '" . $data['status'] . "', `my_cat` = '" . $data['my_cat'] . "', `my_qu` = '" . $this->db->escape($data['my_qu']) . "', `my_price` = '" . $data['my_price'] . "', `my_descrip` = '" . $this->db->escape($data['my_descrip']) . "', `my_manuf` = '" . $this->db->escape($data['my_manuf']) . "', `my_mark` = '" . $this->db->escape($data['my_mark']) . "', `weight` = '" . $this->db->escape($data['weight']) . "', `length` = '" . $this->db->escape($data['length']) . "', `width` = '" . $this->db->escape($data['width']) . "', `height` = '" . $this->db->escape($data['height']) . "', `parent` = '" . $data['parent'] . "', `hide` = '" . $data['hide'] . "', `newphoto` = '" . $this->db->escape($data['newphoto']) ."', `my_photo` = '" . $this->db->escape($data['my_photo']) ."', `cheap` = '" . $data['cheap'] ."', `addopt` = '" . $data['addopt'] ."', `addseo` = '" . $data['addseo'] . "', `related` = '" . $this->db->escape($data['related']) . "', `updte` = '" . $data['updte'] . "', `pmanuf` = '" . $data['pmanuf'] . "', `upattr` = '" . $data['upattr']."', `upopt` = '" . $data['upopt']. "', `upname` = '" . $data['upname']. "', `myplus` = '" . $data['myplus']. "', `cprice` = '" . $data['cprice']. "', `minus` = '" . $data['minus']. "', `chcode` = '" . $data['chcode']. "',  `importseo` = '" . $data['importseo'] ."', `sorder` = '" . $data['sorder']."', `spec` = '" . $data['spec']."', `upurl` = '" . $data['upurl']."', `ref` = '" . $data['ref']."', `addattr` = '" . 0 ."', `exsame` = '" . 0 ."', `sku2` = '" . $data['sku2']."', `parss` = '" . $data['parss'] . "', `points` = '" . $data['points'] . "', `places` = '" . $data['places'] . "', `parsi` = '" . $data['parsi'] . "', `pointi` = '" . $data['pointi'] . "', `placei` = '" . $data['placei'] . "', `parsc` = '" . $data['parsc'] . "', `pointc` = '" . $data['pointc'] . "', `placec` = '" . $data['placec'] . "', `parsp` = '" . $data['parsp'] . "', `pointp` = '" . $data['pointp'] . "', `placep` = '" . $data['placep'] . "', `parsd` = '" . $data['parsd'] . "', `pointd` = '" . $data['pointd'] . "', `placed` = '" . $data['placed'] . "', `parsm` = '" . $data['parsm'] . "', `pointm` = '" . $data['pointm'] . "', `placem` = '" . $data['placem'] . "', `parsk` = '" . $data['parsk'] . "', `catcreate` = '" .  0 . "', `stay` = '" . $data['stay'] . "', `joen` = '" . $data['joen'] . "', `off` = '" . $data['off'] . "', `umanuf` = '" . $data['umanuf'] . "', `onn` = '" . $data['onn'] . "', `refer` = '" . $data['refer'] . "', `disc` = '" . $data['disc'] . "', `newurl` = '" . $data['newurl'] ."', `upc` = '" . $data['upc'] . "', `ean` = '" . $data['ean'] . "', `mpn` = '" . $data['mpn'] . "', `ddata` = '" . 0 ."' WHERE `form_id` = '" . (int)$form_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "suppler_data WHERE `form_id`='" . (int)$form_id. "'");
		
		$i = 0;	
		foreach ($data['cat_ext'] as $value) {
		  if ($data['cat_ext'][$i]) {			
			$this->db->query("INSERT INTO " . DB_PREFIX . "suppler_data SET `form_id` = '" . (int)$form_id . "', `cat_ext` = '" . $this->db->escape($data['cat_ext'][$i]) . "', `category_id` = '" . (int)$data['category_id'][$i] . "', `pic_int` = '" . $data['pic_int'][$i] . "', `cat_plus` = '" . $data['cat_plus'][$i] . "'");
		  }
			$i = $i +1;
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "suppler_attributes WHERE `form_id`='" . (int)$form_id. "'");
		
		$i = 0;			
		foreach ($data['attr_ext'] as $value) {
		  if ($data['attr_ext'][$i]) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "suppler_attributes SET `form_id` = '" . (int)$form_id . "', `attr_ext` = '" . $this->db->escape($data['attr_ext'][$i]) . "', `attr_point` = '". $this->db->escape($data['attr_point'][$i]) . "', `attribute_id` = '" . (int)$data['attribute_id'][$i] . "', `tags` = '" . $data['tags'][$i] . "'");
		  }
			$i = $i +1;			
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "suppler_options WHERE `form_id`='" . (int)$form_id. "'");
		
		$i = 0;	
		foreach ($data['opt'] as $value) {
		  if ($data['opt'][$i]) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "suppler_options SET `form_id` = '" . (int)$form_id . "', `opt` = '" . (int)$data['opt'][$i] . "', `option_id` = '" . (int)$data['option_id'][$i] . "', `po` = '" . $this->db->escape($data['po'][$i]) ."', `ko` = '" . $this->db->escape($data['ko'][$i]) . "', `pr` = '" . $this->db->escape($data['pr'][$i]) ."', `we` = '" . $this->db->escape($data['we'][$i]) ."',   `option_required` = '" . $this->db->escape($data['option_required'][$i]) ."'");
		  }
			$i = $i +1;			
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "suppler_price WHERE `form_id`='" . (int)$form_id. "'");
		
		$i = 0;	
		foreach ($data['nom'] as $value) {
		  if ($data['nom'][$i]) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "suppler_price SET `form_id` = '" . (int)$form_id . "', `nom` = '" . $data['nom'][$i] . "', `ident` = '" . $data['ident'][$i] . "', `param` = '" . $this->db->escape($data['param'][$i]) ."', `point` = '" . $this->db->escape($data['point'][$i]) . "'");
		  }
			$i = $i +1;			
		}
		
		$this->cache->delete('suppler');		
	}
	
	public function deletesuppler($form_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "suppler WHERE `form_id` = '" . (int)$form_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "suppler_data WHERE `form_id` = '" . (int)$form_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "suppler_attributes WHERE `form_id`='" . (int)$form_id. "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "suppler_options WHERE `form_id`='" . (int)$form_id. "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "suppler_price WHERE `form_id`='" . (int)$form_id. "'");
		
		$this->cache->delete('suppler');
	}
	
	public function getAllCategories() {
		$category_data = $this->cache->get('category.all.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'));

		if (!$category_data || !is_array($category_data)) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  ORDER BY c.parent_id, c.sort_order, cd.name");

			$category_data = array();
			foreach ($query->rows as $row) {
				$category_data[$row['parent_id']][$row['category_id']] = $row;
			}

			$this->cache->set('category.all.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'), $category_data);
		}

		return $category_data;
	}
	
	public function getDataForm($cat, $form_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler_data WHERE `form_id` = '" . (int)$form_id . "' and `cat_ext` = '" . $cat . "'");
		
		return $query->rows;
	}
	
	public function getsuppler($form_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler WHERE `form_id` = '" . (int)$form_id . "'");
		
		return $query->row;
	}	

	public function getSupplerOptions($form_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler_options WHERE `form_id` = '" . (int)$form_id . "' ORDER BY nom_id");
			
		return $query->rows;
	}
	
	public function getSupplerPrice($form_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler_price WHERE `form_id` = '" . (int)$form_id . "' ORDER BY nom_id");
			
		return $query->rows;
	}
	
	public function getlanguages() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language ORDER BY `language_id` ASC");
			
		return $query->rows;
	}
	
	public function getAllLanguages() {
		$rows = $this->getlanguages();
		for ($i=1; $i<20; $i++) {
			if (!isset($rows[$i-1]['language_id'])) break;
			$langs[$i] = $rows[$i-1]['language_id'];
		}
	return $langs;	
	}
	
	public function getOptionsById($option_id) {		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value_description WHERE `option_id` = '" . (int)$option_id . "'");
			
		return $query->rows;
	}	
	
	public function addValueDescription($option_id, $ovid, $opt_val, $langs) {
	
		for	($i=1; $i<=count($langs); $i++) {					
			$query = $this->db->query("INSERT INTO " . DB_PREFIX . "option_value_description SET `option_value_id` = '" . (int)$ovid . "', `language_id` = '" . $langs[$i] . "', `option_id` = '" . (int)$option_id . "', `name` = '" . $this->db->escape($opt_val) . "'");
		}
		$this->cache->delete('option');	
	}
	
	
	public function addValue($option_id, &$ovid) {
		$query = $this->db->query("INSERT INTO " . DB_PREFIX . "option_value SET `option_id` = '" . (int)$option_id . "',  `sort_order` = '" . 0 . "'");
		
		$ovid = $this->db->getLastId();
	
		$this->cache->delete('option');
	
	}
	public function getOptionValue($product_id, $option_value_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE `option_value_id` = '" . (int)$option_value_id. "' and `product_id` = '" . (int)$product_id . "'");
		
		return $query->rows;
	}	
	
	public function getProductOption($product_id, $option_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option WHERE `option_id` = '" . (int)$option_id. "'  and `product_id` = '" . $product_id . "'");
		
		return $query->rows;
	}
	
	public function cleanQuantityOption($product_id, $option_id) {
		$query = $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET `quantity` = '" . 0 . "' WHERE `product_id` = '" . (int)$product_id . "' AND `option_id` = '" . (int)$option_id . "'");
		
		$this->cache->delete('option');
	}
		
	public function upProductOption($product_id, $option_id, $data_option, $subtract) {
		$rows = $this->getProductOption($product_id, $option_id);
		
		if (empty($rows)) {
			$query = $this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET `product_id` = '" . (int)$product_id . "', `option_id` = '" . (int)$option_id . "', `required` = '" . $data_option['option_required'] . "'");
			
			$prod_opt_id = $this->db->getLastId();
			
		} else {
			$query = $this->db->query("UPDATE " . DB_PREFIX . "product_option SET `required` = '" . $data_option['option_required'] . "' WHERE `product_id` = '" . (int)$product_id . "' AND `option_id` = '" . (int)$option_id . "'");
		
			$prod_opt_id = $rows[0]['product_option_id'];	
		}
		
		$rows = $this->getOptionValue($product_id, $data_option['op_val_id']);	
	
		if (empty($rows)) {				
			$query = $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET `product_option_id` = '" . (int)$prod_opt_id . "', `product_id` = '" . (int)$product_id. "', `option_id` = '" . (int)$option_id. "', `option_value_id` = '" . (int)$data_option['op_val_id'] . "', `quantity` = '" . (int)$data_option['ko'] . "', `subtract` = '" . (int)$subtract . "', `price` = '" . $data_option['pr'] . "', `price_prefix` = '" . $data_option['pr_prefix'] . "', `points` = '" . (int)$data_option['po'] . "', `points_prefix` = '" . $data_option['po_prefix'] . "', `weight` = '" . $data_option['we'] . "', `weight_prefix` = '" . $data_option['we_prefix'] . "'");	
			
		} else {	
			$st = "UPDATE " . DB_PREFIX . "product_option_value SET `subtract` = '" . (int)$subtract . "'";
			if ($data_option['ko'] != 0) $st = $st . ", `quantity` = '" . (int)$data_option['ko'] . "'";
			if ($data_option['pr'] != 0) $st = $st . " , `price` = '" . $data_option['pr'] . "', `price_prefix` = '" . $data_option['pr_prefix'] . "'";
			if ($data_option['po'] != 0) $st = $st . " , `points` = '" . (int)$data_option['po'] . "', `points_prefix` = '" . $data_option['po_prefix'] . "'";
			if ($data_option['we'] != 0) $st = $st . " , `weight` = '" . $data_option['we'] . "', `weight_prefix` = '" . $data_option['we_prefix'] . "'";
			
			$st = $st ." WHERE `option_value_id` = '" . (int)$data_option['op_val_id'] . "' and `product_id` = '" . (int)$product_id . "'";
			
			if (strlen($st) > 56) $query = $this->db->query($st);
		}
		
		$this->cache->delete('option');
		
	}
	
	public function getVariant($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "relatedoptions_variant_product WHERE `product_id` = '" . $product_id. "'");
			
		return $query->row;
	}
	
	public function getMaxjOptoinID() {	
		$query = $this->db->query("SELECT max(relatedoptions_id) FROM " . DB_PREFIX . "relatedoptions");
			
		return $query->row;
	}
	
	public function getGroups($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "relatedoptions_option WHERE `product_id` = '" . $product_id. "' ORDER BY `relatedoptions_id` ");
			
		return $query->rows;

	}
	
	public function getjOptionsID($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "relatedoptions_option WHERE `product_id` = '" . $product_id . "'");
			
		return $query->rows;
	}
	
	public function getGroupSumma($product_id, $gr) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "relatedoptions WHERE `product_id` = '" . $product_id. "' and  `relatedoptions_id` = '" . $gr . "'");
			
		return $query->row;
	
	}
	
	public function getAllGroups($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "relatedoptions WHERE `product_id` = '" . $product_id. "'");
			
		return $query->rows;
	
	}
	
	public function summaOption($product_id, &$sum) {
		$rows = $this->getjOptionsID($product_id);
		if (!empty($rows)) {
			$min = 0;
			foreach ($rows as $val) {
				if ($val['option_value_id'] < $min) $min = $val['option_value_id'];			
			}
			$summ = array();
			for ($i=0; $i<10000; $i++) {
				$summ[$i] = 0;
			}	
			for ($i=0; $i<200; $i++) {
				if (!isset($rows[$i]['option_value_id'])) break;
				$row = $this->getGroupSumma($product_id, $rows[$i]['relatedoptions_id']);
				if (!empty($row)) {
					$v = $rows[$i]['option_value_id'] - $min;
					$summ[$v] = $summ[$v] + $row['quantity'];
				}
			}
			$dim = count($summ);
			for ($i=0; $i<$dim; $i++) {
				if (!isset($summ[$i]) or empty($summ[$i])) continue;
				$v = $i + $min;
				$query = $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET `quantity` = '" . $summ[$v] . "' WHERE `product_id` = '" . (int)$product_id . "' AND `option_value_id` = '" . $v . "'");
			}				
				
		}
		
		$rows = $this->getAllGroups($product_id);
		if (!empty($rows)) {
			$sum = 0;
			foreach ($rows as $val) {
				$sum = $sum + $val['quantity'];
			}
			$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET `quantity` = '" . $sum . "' WHERE `product_id` = '" . (int)$product_id . "'");		
		}
	}
	
	public function jOption($gr_data) {
		$row = $this->getMaxjOptoinID();
		$max_gr = $row['max(relatedoptions_id)'];
		$mas1 = array();
		$mas2 = array();
		$rows = $this->getGroups($gr_data[1][1]);			
		$found = 0;
		$nom = 0;
		while(1) {	
			if (!isset($rows[$nom]['relatedoptions_id'])) break; 
			$mas1 = '';
			$mas2 = '';
			$k = 0;
			for ($j=0; $j<10; $j++) {					
				if ($j == 0) {
					$mas1[$k] = $rows[$j+$nom]['option_id'];
					$mas2[$k] = $rows[$j+$nom]['option_value_id'];
					$gr = $rows[$j+$nom]['relatedoptions_id'];
				} else {
					if (isset($rows[$j+$nom]['relatedoptions_id']) and $rows[$j+$nom-1]['relatedoptions_id'] == $rows[$j+$nom]['relatedoptions_id']) {
						$k++;
						$mas1[$k] = $rows[$j+$nom]['option_id'];
						$mas2[$k] = $rows[$j+$nom]['option_value_id'];
					} else break;
				}	
			}

			$found = 0;	
			$nom = $nom+$k+1;			
			for ($i=0; $i<10; $i++) {
				if (!isset($mas1[$i])) break;
				$ok = 0;
				for ($j=1; $j<10; $j++) {
					if (!isset($gr_data[$j][2])) break;
					if ($mas1[$i] == $gr_data[$j][2] and $mas2[$i] == $gr_data[$j][3]) {
						$ok = 1;
						break;
					}					
				}				
				if (!$ok) break;			
			}
			if ($ok) {
				$found = 1;	
				break;
			}	
		}
	
		if ($found) {
			$this->db->query("UPDATE " . DB_PREFIX . "relatedoptions SET `quantity` = '" . $gr_data[1][4] . "' WHERE `relatedoptions_id` = '" . $gr . "' and `product_id` = '" . $gr_data[1][1]. "'");			
			
		} else {
			$max_gr++;
			for ($i=1; $i<10; $i++) {
				if (!isset($gr_data[$i][0])) break;
				$this->db->query("INSERT INTO " . DB_PREFIX . "relatedoptions_option SET `relatedoptions_id` =  '" . $max_gr . "', `product_id` = '" . (int)$gr_data[1][1] . "', `option_id` = '" . $gr_data[$i][2] . "', `option_value_id` = '" . $gr_data[$i][3] . "'");
			}		
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "relatedoptions SET `product_id` = '" . (int)$gr_data[1][1] . "', `quantity` = '" . (int)$gr_data[1][4] . "'");			
			
		}
		
		$row = $this->getVariant($gr_data[1][1]);
		if (empty($row)) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "relatedoptions_variant_product SET `relatedoptions_use` = '" . 1 . "', `product_id` = '" . $gr_data[1][1]. "'");
		}
			
		$this->cache->delete('option');
	}
	
	public function getSupplerAttributes($form_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler_attributes WHERE `form_id` = '" . (int)$form_id . "' ORDER BY nom_id");
			
		return $query->rows;
	}
	
	public function	deleteAttribute($product_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		
		$this->cache->delete('product');
	}
	
	public function	getAllAttributes() {		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_description");
				
		return $query->rows;
	}
	
	public function	getAttributes($product_id) {
		$lang = $this->config->get('config_language_id');
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE `product_id` = '" . (int)$product_id . "' and `language_id` = '" . $lang . "' ORDER BY attribute_id");
			
		return $query->rows;
	}
	
	public function	getAttributeID($name) {		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_description WHERE `name` = '" . $this->db->escape($name) . "'");
				
		return $query->rows;
	}
	
	public function upDesc($newdesc, $id) {
		$lang = $this->config->get('config_language_id');
		$this->db->query("UPDATE " . DB_PREFIX . "product_description SET `description` = '" . $this->db->escape($newdesc) . "' WHERE `product_id` = '" . $id . "' and `language_id` = '" . $lang. "'");
		
		$this->cache->delete('*');
	}	
	
	public function getMaxAttributeID() {	
		$query = $this->db->query("SELECT max(attribute_id) FROM " . DB_PREFIX . "attribute");
			
		return $query->row;
	}
	
	public function	checkAttribute($id, $lang) {		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_description WHERE `attribute_id` = '" . (int)$id . "' and `language_id` = '" . $lang . "'");
			
		return $query->rows;
	}	
	
	public function	getAttributeName($id) {
		$lang = $this->config->get('config_language_id');
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_description WHERE `attribute_id` = '" . (int)$id . "' and `language_id` = '" . $lang . "'");
			
		return $query->rows;
	}	
	
	public function getAttributeById($product_id, $attribute_id, $lang) {        
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE `product_id` = '" . (int)$product_id . "' and `attribute_id` = '". $attribute_id . "' and `language_id` = '". $lang. "'");
            
        return $query->rows;
    }

	public function changeAttributeId($product_id, $attribute_id_new, $attribute_id_old, $text) {
		$lang = $this->config->get('config_language_id');
		$rows = $this->getAttributeById($product_id, $attribute_id_new, $lang);
		if (empty ($rows)) {			
			$text = htmlspecialchars($text, ENT_COMPAT, 'UTF-8');
			$this->db->query("UPDATE " . DB_PREFIX . "product_attribute SET `attribute_id` = '" . $this->db->escape($attribute_id_new). "', `text` = '" . $this->db->escape($text). "' WHERE `product_id` = '" . $product_id . "' and `attribute_id` = '" . $attribute_id_old. "' and `language_id` = '" . $lang . "'");
		} else {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' and `attribute_id` ='" . $this->db->escape($attribute_id_old). "'");
		}
		$this->cache->delete('suppler');		
	}
	
	public function putAttributeById($data, $langs) {
		if (empty($data['text1'])) return;
        $text1 = $data['text1'];
        $text1 = htmlspecialchars($text1, ENT_COMPAT, 'UTF-8');
		$text2 = $data['text2'];
        $text2 = htmlspecialchars($text2, ENT_COMPAT, 'UTF-8');
		
        $rows = $this->getAttributeById((int)$data['product_id'], (int)$data['attribute_id'], $langs[1]);
		if (empty($rows)) {			
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET `product_id` = '" . (int)$data['product_id'] . "', `attribute_id` = '" . (int)$data['attribute_id'] . "', `language_id` = '" . $langs[1] . "', `text` = '" . $this->db->escape($text1) . "'");				
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "product_attribute SET `text` = '" . $this->db->escape($text1). "' WHERE `product_id` = '" . (int)$data['product_id'] . "' and `attribute_id` = '" . (int)$data['attribute_id'] . "' and `language_id` = '" . $langs[1] . "'");
		}
		if (!empty($text2)) {
			$rows = $this->getAttributeById((int)$data['product_id'], (int)$data['attribute_id'], $langs[2]);
			if (empty($rows)) {	
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET `product_id` = '" . (int)$data['product_id'] . "', `attribute_id` = '" . (int)$data['attribute_id'] . "', `language_id` = '" . $langs[2] . "', `text` = '" . $this->db->escape($text2) . "'");
			} else {
				$this->db->query("UPDATE " . DB_PREFIX . "product_attribute SET `text` = '" . $this->db->escape($text2). "' WHERE `product_id` = '" . (int)$data['product_id'] . "' and `attribute_id` = '" . (int)$data['attribute_id'] . "' and `language_id` = '" . $langs[2] . "'");
			}	
		}
		
        $this->cache->delete('attribute');        
    }	

	public function createAttribute($data, &$attID, $langs) {		
		if (!empty($data['text2']) and count($langs) < 2) {
			$attID = 0;
			return;
		}
		$t1 = 0;
		$t2 = 0;		
		if (!empty($data['text1'])) $rows = $this->getAttributeID($data['text1']);		
		if (!empty($rows)) {
			$t1 = 1;
			$attID1 = $rows[0]['attribute_id'];
		}	
		$rows = '';
		if (!empty($data['text2'])) $rows = $this->getAttributeID($data['text2']);
		if (!empty($rows)) {
			$t2 = 1;
			$attID2 = $rows[0]['attribute_id'];
		}
			
		if (!$t1 and !$t2 and (!empty($data['text1']) or !empty($data['text2']))) {				
			$this->db->query("INSERT INTO " . DB_PREFIX . "attribute SET attribute_group_id = '" . 1 . "', sort_order = '" . 0 . "'");
			
			$attID = $this->db->getLastId();
			
			if (!empty($data['text1'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . $attID . "', language_id = '" . $langs[1] . "', name = '" . $this->db->escape($data['text1']) . "'");
			}
			if (!empty($data['text2'])) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . $attID . "', language_id = '" . $langs[2] . "', name = '" . $this->db->escape($data['text2']) . "'");			
			}
			
		} 
		if ($t1 and !$t2) {
			$attID = $attID1;
			if (!empty($data['text2'])) {
				$rows = $this->checkAttribute($attID, $langs[2]);
				if (empty($rows))
				$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . $attID . "', language_id = '" . $langs[2] . "', name = '" . $this->db->escape($data['text2']) . "'");			
			}		
		}
		if (!$t1 and $t2) {
			$attID = $attID2;
			if (!empty($data['text1'])) {
				$rows = $this->checkAttribute($attID, $langs[1]);
				if (empty($rows))
				$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . $attID . "', language_id = '" . $langs[1] . "', name = '" . $this->db->escape($data['text1']) . "'");
			}	
		}
		if ($t1 and $t2 and $attID1 != $attID2) {
			$attID = $attID1;
			if (!empty($data['text2'])) {
				$rows = $this->checkAttribute($attID, $langs[2]);
				if (empty($rows))
				$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . $attID . "', language_id = '" . $langs[2] . "', name = '" . $this->db->escape($data['text2']) . "'");
			}	
		}
		if ($t1 and $t2 and $attID1 == $attID2) $attID = $attID1;
		
		$this->cache->delete('attribute');	
	
	}
	
	public function getRefIdent($product_id, $ident) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler_ref WHERE `product_id` = '" . (int)$product_id . "' and `ident` = '" . $ident . "'");
			
		return $query->row;
	}
	
	public function saveRef($product_id, $ident, $param, $point, $url) {
		$row = $this->getRefIdent($product_id, $ident);
		if (empty($row)) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "suppler_ref SET `product_id` = '" . $product_id . "', `ident` = '" . $ident . "', `param` = '" . $param . "', `point` = '" . $point . "', `url` = '" . $url . "'");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "suppler_ref SET `url` = '" . $url . "', `param` = '" . $param . "', `point` = '" . $point . "' WHERE `product_id` = '" . $product_id . "' and `ident` = '" . $ident . "'");
		}
	}	
	
	public function getReferens($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler_ref WHERE `product_id` = '" . (int)$product_id . "'");
		
		return $query->rows;
	}
	
	public function getMySuppler($form_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler WHERE `form_id` = '" . (int)$form_id . "'");
			
		return $query->rows;
	}	
	
	public function getSupplers() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler ORDER BY form_id ASC");			
		
		return $query->rows;
	}	
	
	public function getSame($manufacturer_id, $category_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";
		
		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 
		
		if ((int)$category_id != 0) {
			$sql .= " AND p2c.category_id = '" . (int)$category_id . "'";
		}
		
		if ((int)$manufacturer_id != 0) {
			$sql .= " AND p.manufacturer_id = '" . $manufacturer_id . "'";
		}
			
		$sql .= " ORDER BY pd.name ASC";	
			
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	
	public function getMargin($form_id, $category_id) {				
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler_data WHERE `form_id` = '" . (int)$form_id . "' and `category_id` ='" . $category_id . "'");
			
		return $query->rows;
	}
		
	public function getWholesale($product_id, $customer_group_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE `product_id` ='" .$product_id."' AND `customer_group_id` ='" . $customer_group_id . "'");
	
		return $query->row;
	}	
	
	public function upWholesale($data) {	
		$row = $this->getWholesale($data['product_id'], $data['customer_group_id']);
		if (!empty($row)) {
			if ($data['price'] == 0) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$data['product_id'] . "' AND `customer_group_id` ='" . $data['customer_group_id'] . "'");
			} else {
				if ($data['price'] != '') $this->db->query("UPDATE " . DB_PREFIX . "product_discount SET `customer_group_id` = '".$data['customer_group_id']."', `quantity` = '".$data['quantity']."', `priority` = '".$data['priority']."', `price` = '".$data['price']."', `date_start` = '".$data['date_start']."', `date_end` = '".$data['date_end']."' WHERE `product_id` ='" .$data['product_id']."' AND `customer_group_id` ='" . $data['customer_group_id'] . "'");
			}	
		}  else $this->putWholesale($data);
	
		$this->cache->delete('product');	
	}
	
	public function putWholesale($data) {
		if ($data['price'] != '' and $data['price'] != 0) $this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET `product_id` ='" .$data['product_id']."', `customer_group_id` = '".$data['customer_group_id']."', `quantity` = '".$data['quantity']."', `priority` = '".$data['priority']."', `price` = '".$data['price']."', `date_start` = '".$data['date_start']."', `date_end` = '".$data['date_end']."'");
	
		$this->cache->delete('product');	
	}	
	
	public function getActionPrice($product_id, $customer_group_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE `product_id` ='" .$product_id."' AND `customer_group_id` ='" . $customer_group_id . "'");
	
		return $query->row;
	}	
	
	public function upActionPrice($data) {	
		$row = $this->getActionPrice($data['product_id'], $data['customer_group_id']);
		if (!empty($row)) {
			if ($data['price'] == 0) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$data['product_id'] . "' AND `customer_group_id` ='" . $data['customer_group_id'] . "'");
			} else {
				if ($data['price'] != '') $this->db->query("UPDATE " . DB_PREFIX . "product_special SET `customer_group_id` = '".$data['customer_group_id']."', `priority` = '".$data['priority']."', `price` = '".$data['price']."', `date_start` = '".$data['date_start']."', `date_end` = '".$data['date_end']."' WHERE `product_id` ='" .$data['product_id']."' AND `customer_group_id` ='" . $data['customer_group_id'] . "'");
			}	
		}  else $this->putActionPrice($data);
	
		$this->cache->delete('product');	
	}
	
	public function putActionPrice($data) {
		if ($data['price'] != '' and $data['price'] != 0) $this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET `product_id` ='" .$data['product_id']."', `customer_group_id` = '".$data['customer_group_id']."', `priority` = '".$data['priority']."', `price` = '".$data['price']."', `date_start` = '".$data['date_start']."', `date_end` = '".$data['date_end']."'");
	
		$this->cache->delete('product');	
	}
	
	public function getTotalData($form_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "suppler_data WHERE `form_id` = '" . (int)$form_id . "'");
		
		return $query->row['total'];
	}
	
	public function getTotalSupplers() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "suppler");
		
		return $query->row['total'];
	}	

	public function getSupplerData($form_id) {				
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler_data WHERE `form_id` = '" . (int)$form_id . "' ORDER BY cat_ext ASC");
			
		return $query->rows;
	}
	
	public function getProductBySKU($sku) {		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE `sku` = '" . $this->db->escape($sku) . "'");
			
		return $query->rows;
	}
	
	public function getCategory($category_id) {	
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE `category_id` = '" . (int)$category_id . "'");
		
		return $query->rows;
	}
	
	public function getURLmanufacturer($manufacturer_id) {	
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'manufacturer_id=".(int)$manufacturer_id . "'");
	
		return $query->row;	
	}
	
	public function getURLcategory($category_id) {	
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'category_id=".(int)$category_id . "'");
	
		return $query->row;	
	}
	
	public function getURL($product_id) {	
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'product_id=".(int)$product_id."'");
	
		return $query->row;	
	}
	
	public function isLink($parent_id, $category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE `category_id` = '" . (int)$category_id . "' and `parent_id` = '" . (int)$parent_id . "'");
		
		return $query->rows;
	
	}
	
	public function getProductDiscount($product_id, $j) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE `product_id` = '" . (int)$product_id . "' and `customer_group_id` = '" . $j . "'");
		
		return $query->rows;
	}
	
	public function getCategoryPhoto($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE `category_id` = '" . (int)$category_id . "'");
		
		return $query->rows;
	}
	
	public function getCategoryName($category_id) {
		$lang = $this->config->get('config_language_id');
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE `category_id` = '" . (int)$category_id . "' and `language_id` = '" . $lang . "'");
		
		return $query->rows;
	}
	
	public function getCategoryIDbyName($name) {
		$lang = $this->config->get('config_language_id');
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE `name` = '" . $this->db->escape($name) . "' and `language_id` = '" . $lang . "'");
		
		return $query->rows;
	}	
	
	public function CreateCategory($name, $langs, $parent_category_id, &$new_id, $date, $refer) {
		$lang = $this->config->get('config_language_id');
		if (!empty($refer)) $refer = "data/" . $refer;
		$this->db->query("INSERT INTO " . DB_PREFIX . "category SET `image` = '" . $refer . "', `parent_id` = '" . (int)$parent_category_id . "', `top` = '" . 0 . "', `column` = '" . 1 ."', `sort_order` = '" . 0 . "', `status` = '" . 1 . "', `date_added` = '" . $date . "', `date_modified` = '" . $date . "'");
		
		$new_id = $this->db->getLastId();
				
		$n = "config_name";
		$rows = $this->getStore($n);				
		$store = 'Мой магазин'; 
		if (isset($rows[0]['value'])) $store = $rows[0]['value'];
		
		// Мета-данные
		$seo_h1 = $name;		
		$seo_title = $name . " купить в ......., в интернет-магазине | " . $store;
		$desc = $name . " от известных мировых брендов, соответствующих самым высоким стандартам качества. " .  $name . ", в магазине " . $store . " - безошибочный выбор: мы даем гарантию на все товары, купленные у нас.";
		$seo_desc = "Купить " . $name . " в  интернет-магазине  с ***бесплатно доставкой*** по ...... Свыше 500 наименований продукции " . $name . ". 100% гарантия качества. Мы доставляем в ...., ....., ..... и другие города";
		$seo_keyword = $store . "," . $name . ",....,.....,......,......,интернет-магазин";
		
		$seo_url = $this->TransLit($name);
		$seo_url = $this->MetaURL($seo_url);	
		$seo_url = strtolower($seo_url);
		
		for	($i=1; $i<=count($langs); $i++) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET `category_id` = '". (int)$new_id . "', `language_id` = '" . $langs[$i] . "', `name` = '" . $this->db->escape($name) . "', `description` = '" . $this->db->escape($desc) . "', `meta_description` = '" . $this->db->escape($seo_desc) . "', `meta_keyword` = '" . $this->db->escape($seo_keyword) . "', `seo_h1` = '" . $this->db->escape($seo_h1) . "', `seo_title` = '" . $this->db->escape($seo_title) . "'");
		}

		$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET `category_id` = '". (int)$new_id . "', `store_id` = '". 0 ."'");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$new_id . "', keyword = '" . $this->db->escape($seo_url) . "'");		
		
		$this->cache->delete('category');
	}	
	
	public function getProductImage($product_id) {	
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE `product_id` = '" . (int)$product_id . "'");
		
		return $query->rows;
	}
	
	public function getStore($key) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `key` = '" . $key . "'");
						
		return $query->rows;
	}
	
	public function getProductCategory($product_id) {				
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE `product_id` = '" . (int)$product_id . "'");
			
		return $query->rows;
	}
	
	public function getProdOptions($product_id, $opt_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE `product_id` = '" . (int)$product_id . "' and `option_id` = '" . (int)$opt_id ."'");
			
		return $query->rows;
	
	}
	
	public function getNameOption($option_value_id) {
		$lang = $this->config->get('config_language_id');
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value_description WHERE `option_value_id` = '" . $option_value_id . "' and `language_id` = '" . $lang . "'");		
			
		return $query->rows;	
	}
	
	public function getOptions() {	
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "option` ORDER BY option_id");
	
		return $query->rows;
	}
	
	public function getRalated($new, $old) {
	
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_related` WHERE `product_id` = '" . $this->db->escape($new) . "' and `related_id` = '" . $this->db->escape($old) . "'");
	
		return $query->rows;
	
	}	
	
	public function addRelated($new, $old) {
	
		$query = $this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET `product_id` = '" . $this->db->escape($new) . "', `related_id` = '" . $this->db->escape($old) . "'");
	
		$this->cache->delete('product');	
	}
	
	public function getMaxID() {	
		$query = $this->db->query("SELECT max(product_id) FROM " . DB_PREFIX . "product");
			
		return $query->row;
	}

	public function getMaxAttribute() {	
		$query = $this->db->query("SELECT max(attribute_id) FROM " . DB_PREFIX . "attribute");
			
		return $query->row;
	}

	public function getMaxLanguage() {	
		$query = $this->db->query("SELECT max(language_id) FROM " . DB_PREFIX . "language");
			
		return $query->row;
	}
	
	public function addManufacturer($data, $langs, &$last_id) {
		$name = $this->db->escape($data['name']);
		$name = str_replace('ООО' , '' , $name);		
		$name = str_replace('ТОВ' , '' , $name);
		$name = $this->Code($name);
		$name = str_replace("\\" , '' , $name);
		$name = trim($name);
		$n = "config_name";
		$rows = $this->getStore($n);				
		$store = 'Мой магазин'; 
		if (isset($rows[0]['value'])) $store = $rows[0]['value'];
		// Мета-данные
		$seo_h1 = $name;			
		$seo_title = "Купить " . $name . " в ......, ......., ......., ...... Самые низкие цены в интернет-магазине | " . $store;
		$desc = $name . " от известных мировых брендов, соответствующих самым высоким стандартам качества. " .  $name . ", в магазине " . $store . " - безошибочный выбор: мы даем гарантию на все товары, купленные у нас.";
		$seo_desc = "Купить ". $name . " в  интернет-магазине  с доставкой по ...... Заходите у нас большой выбор " . $name . " и отличные цены. Мы доставляем в ....., ......, ....., ...... и другие города";
		$seo_keyword = $store . "," . $name . ",.....,......,......,......,интернет-магазин";			
		$seo_url = $this->TransLit($name);
		$seo_url = $this->MetaURL($seo_url);
		$seo_url = strtolower($seo_url);
						
		$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer SET name = '" . $this->db->escape($name) . "', sort_order = '" . (int)$data['sort_order'] . "'");
		
		$last_id = $this->db->getLastId();

		for	($i=1; $i<=count($langs); $i++) {	
			$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_description SET `manufacturer_id` = '". (int)$last_id . "', `language_id` = '" . $langs[$i] . "', `description` = '" . $this->db->escape($desc) . "', `meta_description` = '" . $this->db->escape($seo_desc) . "', `meta_keyword` = '" . $this->db->escape($seo_keyword) . "', `seo_h1` = '" . $this->db->escape($seo_h1) . "', `seo_title` = '" . $this->db->escape($seo_title) . "'");
		}
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . (int)$last_id . "', store_id = '" . 0 . "'");
						
		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$last_id . "', keyword = '" . $this->db->escape($seo_url) . "'");		
		
		$this->cache->delete('manufacturer');
	}
	
	public function getTable() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "suppler_sku_description` WHERE `nom_id` = '" . 1 . "'");
	
		return $query->rows;
	
	}
	
	public function getMaxSkuID() {
		$query = $this->db->query("SELECT max(sku_id) FROM " . DB_PREFIX . "suppler_sku_description");
	
		return $query->row;
	}
	
	public function getskuDescription($sku) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler_sku_description WHERE `sku` = '" . $this->db->escape($sku) . "'");
	
		return $query->row;	
	
	}
	
	public function findskuDescription($sku) {
		$sku = $this->db->escape($sku);
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler_sku_description WHERE `sku` LIKE '%" . $this->db->escape($sku) . "%'");
	
		return $query->rows;
	
	}
	
	public function getSku($sku_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler_sku_description WHERE `sku_id` = '" . $sku_id . "'");
	
		return $query->rows;
	
	}
	
	public function getAllRecordsLibrary($sku) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler_sku_description WHERE `sku` = '" . $sku . "'");
	
		return $query->rows;
	
	}
	
	public function getSkuID($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler_sku WHERE `product_id` = '" . $product_id . "'");
	
		return $query->row;	
	
	}
		
	public function getProductIDbySkuID($sku_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler_sku WHERE `sku_id` = '" . $sku_id . "'");
	
		return $query->row;	
	
	}
	
	public function getskuIDbyProductID($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler_sku WHERE `product_id` = '" . $product_id . "'");
	
		return $query->row;	
	}
	
	public function issetsku($id, $product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "suppler_sku WHERE `product_id` = '" . $product_id . "' and `sku_id` = '". $id. "'");
	
		return $query->row;	
	}
	
	public function putsku($product_id, $sku_id) {
		$row = $this->issetsku($sku_id, $product_id);
		if (empty($row)) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "suppler_sku SET `sku_id` = '" . $sku_id . "', `product_id` = '" . $product_id . "'");
		}	
		
		$this->cache->delete('suppler');
	}	
	
	public function putProductBySKU($sku, $row_product, $updte, $upname, $max_attr, $attr_ext, $row, $tags, $addseo, $upurl, $umanuf) {		
		$this->db->query("UPDATE `" . DB_PREFIX . "product` SET `quantity` = '" . $row_product[0]['quantity'] . "',  `model` = '" . $row_product[0]['model'] . "', `sku` = '" . $this->db->escape($row_product[0]['sku']) . "', `price` = '" . $row_product[0]['price'] . "', `stock_status_id` = '" . $row_product[0]['stock_status_id'] . "', `quantity` = '" . $row_product[0]['quantity'] . "', `subtract` = '". $row_product[0]['subtract']. "', `image` = '". $this->db->escape($row_product[0]['image']). "', `status` = '". $row_product[0]['hide'] ."',  `sort_order` = '" . (int)$row_product[0]['sort_order'] . "', `date_modified` = '" . $row_product[0]['date_modified'] . "' WHERE `product_id` = '" .(int)$row_product[0]['product_id'] . "'");		
		
		if (!empty($row_product[0]['ref']) or $row_product[0]['ref'] == '0')
			$this->db->query("UPDATE `" . DB_PREFIX . "product` SET `location` = '" . $this->db->escape($row_product[0]['ref']) . "' WHERE `product_id` = '" .(int)$row_product[0]['product_id'] . "'");
				
		if (!empty($row_product[0]['upc']) or $row_product[0]['upc'] == '0')
			$this->db->query("UPDATE `" . DB_PREFIX . "product` SET `upc` = '" . $this->db->escape($row_product[0]['upc']) . "' WHERE `product_id` = '" .(int)$row_product[0]['product_id'] . "'");

		if (!empty($row_product[0]['ean']) or $row_product[0]['ean'] == '0')
			$this->db->query("UPDATE `" . DB_PREFIX . "product` SET `ean` = '" . $this->db->escape($row_product[0]['ean']) . "' WHERE `product_id` = '" .(int)$row_product[0]['product_id'] . "'");
			
		if (!empty($row_product[0]['mpn']) or $row_product[0]['mpn'] == '0')
			$this->db->query("UPDATE `" . DB_PREFIX . "product` SET `mpn` = '" . $this->db->escape($row_product[0]['mpn']) . "' WHERE `product_id` = '" .(int)$row_product[0]['product_id'] . "'");	
		
		if ($row_product[0]['manufacturer_id'])
			$this->db->query("UPDATE `" . DB_PREFIX . "product` SET `manufacturer_id` = '" . $row_product[0]['manufacturer_id'] . "' WHERE `product_id` = '" .(int)$row_product[0]['product_id'] . "'");
		
		$lang = $this->config->get('config_language_id');
		$date = $row_product[0]['date_modified'];
		
		// Описание оригинал
		$descript = "";
		if (isset($row_product[0]['description'])) {
			$descript = $row_product[0]['description'];
			$descript = $this->symbol($descript);
		}	
		
		// Наименование товара
		$prod_name = "";
		if (isset($row_product[0]['item'])) {
			$prod_name = $row_product[0]['item'];						
			$prod_name = $this->Code($prod_name);
			$prod_name = str_replace("#" , '' , $prod_name);
			$prod_name = trim($prod_name);
		}	
		
		// Мета-данные		
	
		// Имя производителя. Удалить ООО и ТОВ
		$meta_manuf = '';
		if (isset($row_product[0]['manuf_name'])) {
			$meta_manuf = str_replace('ООО' , '' , $row_product[0]['manuf_name']);		
			$meta_manuf = str_replace('ТОВ' , '' , $meta_manuf);
			$meta_manuf = $this->Code($meta_manuf);		
		}
		
		// Сео-имя
		$seo_h1 = $prod_name;

		// Вытаскиваем из БД название магазина
		$n = "config_name";
		$rows = $this->getStore($n);				
		$meta_store = 'Мой магазин'; 
		if (isset($rows[0]['value'])) $meta_store = $rows[0]['value'];
		
		$seo_title = $prod_name . " купить в ......, ......, ....... в интернет-магазине | " . $meta_store;
		
		// Вытаскиваем название категории для этого продукта 
		$rows = $this->getCategoryName((int)$row_product[0]['category_id']);
		$meta_category_name = '';	
		if (isset($rows[0]['name'])) $meta_category_name = $rows[0]['name'];
		
		$meta_bla = 'купить,заказать,дешево'; // Дополнительные слова. Можно менять, добавлять		
		
		// Мета-кейвордз Ключевые слова: имя магазина, производитель, продукт, категория, бла-бла-бла
		$meta_keywords = '';
		$meta_keywords = $meta_store;
		if (!empty($meta_manuf)) $meta_keywords = $meta_keywords . ','. $meta_manuf;		
		if (!empty($seo_h1)) $meta_keywords = $meta_keywords . ','. $seo_h1;
		if (!empty($meta_category_name)) $meta_keywords = $meta_keywords . ','. $meta_category_name;		
		if (!empty($meta_bla)) $meta_keywords = $meta_keywords . ','. $meta_bla;		
		
		// Мета-данные
		$meta_desc = "В интернет магазине ***". $meta_store . "*** тел.: .....  Вы можете купить " . $prod_name . "  по выгодной цене. У нас лучший выбор " . $meta_category_name . " отличные цены на " . $prod_name . " доставка в ......, ......, ......, ...... и другие города .....";
		
		// Метки: атрибуты товара см. стр "Атрибуты"
		$at ='';
		if ($max_attr) {			
			for ($j = 1; $j <= $max_attr; $j++) {
				if ($j > 30) break;
				if (isset($row[$attr_ext[$j]]) and !empty($row[$attr_ext[$j]])) {
					if (!preg_match('/^[0-9 ]+$/', $row[$attr_ext[$j]])) {
						if ($tags[$j]) {						
							$add = $this->symbol($row[$attr_ext[$j]]);
							if (empty($at)) $at = $add;
							else $at = $at.','.$add;
						}	
					}	
				}	
			}
		}
		
		$tag = '';
		$tag = $meta_category_name;
		if (!empty($meta_manuf)) $tag = $tag . ','. $meta_manuf;
		if (!empty($at)) $tag = $tag .',' . $at;

	if ($umanuf) {
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET `tag` = '" . $this->db->escape($tag) . "'  WHERE `product_id` = '" .(int)$row_product[0]['product_id'] . "' and `language_id` = '" . $lang. "'");
		}	
		
	// SEO URL
		$seo_url = $prod_name;			
	//	$seo_url = substr($seo_url, 0, 64);  // обрезать до 64 символов        
	//	$seo_url = $seo_url.'_'.$row_product[0]['model']; // название товара+Модель
	//  $seo_url = $row_product[0]['sku']."_".$row_product[0]['model']; // sku+model
	//	$seo_url = $seo_url."_".$row_product[0]['sku']; // название+sku
		$seo_url = $this->TransLit($seo_url);
		$seo_url = $this->MetaURL($seo_url);		
		$seo_url = strtolower($seo_url);
			
		$meta_prod_name_t = $seo_title;
		$meta_prod_name = $seo_h1;
		// Импорт мета-данных из прас-листа. Из колонкок праса номера: 23, 24, 25, 26, 27, 28
		if ($addseo == 2) {	
			if (isset($row_product[0]['seo_h1']) and !empty($row_product[0]['seo_h1'])) $meta_prod_name = $row_product[0]['seo_h1'];
			if (isset($row_product[0]['seo_title']) and !empty($row_product[0]['seo_title'])) $meta_prod_name_t = $row_product[0]['seo_title'];
			if (isset($row_product[0]['meta_keyword']) and !empty($row_product[0]['meta_keyword'])) $meta_keywords = $row_product[0]['meta_keyword'];
			if (isset($row_product[0]['meta_description']) and !empty($row_product[0]['meta_description'])) $meta_desc = $row_product[0]['meta_description'];
			if (isset($row_product[0]['tag']) and !empty($row_product[0]['tag'])) $tag = $row_product[0]['tag'];
		}
			
		if ($upurl > 1) {
			if (isset($row_product[0]['url']) and !empty($row_product[0]['url'])) $seo_url = $row_product[0]['url'];
		}
		
		if ($addseo) {			
			if (!empty($meta_keywords)) {
				$this->db->query("UPDATE " . DB_PREFIX . "product_description SET `meta_keyword` = '" . $this->db->escape($meta_keywords) . "', `tag` = '" . $this->db->escape($tag) . "' WHERE `product_id` = '" .(int)$row_product[0]['product_id'] . "' and `language_id` = '" . $lang. "'");				
			}	
			if (!empty($meta_desc)) {	
				$this->db->query("UPDATE " . DB_PREFIX . "product_description SET `meta_description` = '" . $this->db->escape($meta_desc) . "' WHERE `product_id` = '" .(int)$row_product[0]['product_id'] . "' and `language_id` = '" . $lang. "'");
			}
			if (!empty($meta_prod_name)) {
				$this->db->query("UPDATE " . DB_PREFIX . "product_description SET `seo_title` = '" . $this->db->escape($meta_prod_name_t) . "', `seo_h1` = '" . $this->db->escape($meta_prod_name) . "' WHERE `product_id` = '" .(int)$row_product[0]['product_id'] . "' and `language_id` = '" . $lang. "'");				
			}
		}
		
		if ($upurl and !empty($seo_url)) {
			$this->db->query("UPDATE " . DB_PREFIX . "url_alias SET `keyword` = '" . $this->db->escape($seo_url) . "' WHERE `query` = 'product_id=".(int)$row_product[0]['product_id']."'");
		}
		
		if ($updte > 1) {		
			if (!empty($descript)) {
				$this->db->query("UPDATE " . DB_PREFIX . "product_description SET `description` = '" . $this->db->escape($descript) . "' WHERE `product_id` = '" .(int)$row_product[0]['product_id'] . "' and `language_id` = '" . $lang. "'");
			}
		}
		
		if ($upname) {		
			if (!empty($prod_name)) {
				$this->db->query("UPDATE " . DB_PREFIX . "product_description SET `name` = '" . $this->db->escape($prod_name) . "' WHERE `product_id` = '" .(int)$row_product[0]['product_id'] . "' and `language_id` = '" . $lang. "'");
			}
		}
		
		$this->cache->delete('suppler');
	}
	
	public function getManufacturerID($name) {	
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer WHERE `name` = '" . $this->db->escape($name) . "'");
			
		return $query->rows;
	}
	
	public function getManufacturerName($id) {	
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer WHERE `manufacturer_id` = '" . $id . "'");
			
		return $query->rows;
	}
	
	public function getProductDesc($id) {
		$lang = $this->config->get('config_language_id');
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE `product_id` = '" . $id . "' and `language_id` = '" . $lang . "'");
			
		return $query->rows;
	}	
	
	public function getProductsByID($product_id) {				
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE `product_id` = '" . (int)$product_id . "'");
			
		return $query->rows;
	}
	
	public function getProductByID($product_id) {				
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE `product_id` = '" . (int)$product_id . "'");
			
		return $query->row;
	}
	
	public function	upProduct($data) {	
		$this->db->query("UPDATE `" . DB_PREFIX . "product` SET `quantity` = '" . $data['quantity'] . "', `sku` = '" . $this->db->escape($data['sku']) . "', `price` = '" . $data['price'] . "', `status` = '". $data['status'] . "' , `stock_status_id` = '" . $data['stock_status_id'] . "' WHERE `product_id` = '" . $data['product_id'] . "'");
		
		$this->cache->delete('*');
	}
	
	public function addPicture($product_id, $pic_addr) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET `product_id` = '" . $product_id . "', `image` = '" .$this->db->escape($pic_addr). "'");
	
		$this->cache->delete('*');
	}
	
	public function setCategory($product_id, $cat) {		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET `product_id` = '" .(int)$product_id. "', `category_id` = '" . (int)$cat . "', `main_category` = 1");

		$rows = $this->getCategoryName($cat);
		$category_name = '';	
		if (isset($rows[0]['name'])) $category_name = $rows[0]['name'];
		$rows = $this->getProductDesc($product_id);	
		if (!empty($rows) and isset($rows[0]['tag'])) {
			$p = stripos($rows[0]['tag'], ',');		
			if ($p) {			
				$lang = $this->config->get('config_language_id');
				$hvost = substr($rows[0]['tag'], $p);				
				$tag = $category_name.$hvost;
		
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET `tag` = '" . $this->db->escape($tag) . "' WHERE `product_id` = '" . $product_id . "' and `language_id` = '" . $lang. "'");
			
			}	
		}
		$this->cache->delete('*');
	}
	
	public function issetProductCategory($product_id, $cat) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE `product_id` = '" . (int)$product_id . "' and `category_id` = '" . (int)$cat . "'");
			
		return $query->rows;
	}	
	
	public function toCategory($product_id, $cat) {	
		$rows = $this->issetProductCategory($product_id, $cat);
		
		if (empty($rows)) {	
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET `product_id` = '" .(int)$product_id. "', `category_id` = '" . (int)$cat . "', `main_category` = 0");	
		
			$this->cache->delete('*');
		}
	}
	
	public function	putNewProduct($row_product, $parent, &$last_product_id, $attr_ext, $max_attr, $langs, $row, $tags, $addseo, $catmany, $catcreate, $newurl, $refers) {
	
		if (!$catcreate) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product SET `model` = '" . $row_product[0]['model'] . "', `sku` = '" . $this->db->escape($row_product[0]['sku']) . "', `upc` = '" . $this->db->escape($row_product[0]['upc']) . "', `ean` = '" . $this->db->escape($row_product[0]['ean']) . "', `mpn` = '" . $this->db->escape($row_product[0]['mpn']) . "', `location` = '" . $this->db->escape($row_product[0]['ref']) . "', `quantity` = '" . $row_product[0]['quantity'] . "', `stock_status_id` = '" . $row_product[0]['stock_status_id'] . "', `image` = '" . $this->db->escape($row_product[0]['image']) . "', `manufacturer_id` = '" . $row_product[0]['manufacturer_id'] . "', `shipping` = '" . $row_product[0]['shipping'] . "', `price` = '" . $row_product[0]['price'] . "', `points` = '0' , `tax_class_id` = '0' , `date_available` = '" . $row_product[0]['date_available'] . "', `weight` = '". $row_product[0]['weight'] . "', `weight_class_id` = '1' , `length` = '". $row_product[0]['length'] ."', `width` = '". $row_product[0]['width'] ."', `height` = '". $row_product[0]['height'] ."' , `length_class_id` = '1' , `subtract` = '". $row_product[0]['subtract']. "', `minimum` = '' ,  `sort_order` = '" . (int)$row_product[0]['sort_order'] . "', `status` = '". $row_product[0]['hide'] ."', `date_added` = '" . $row_product[0]['date_added'] . "', `date_modified` = '" . $row_product[0]['date_added'] . "', `viewed` = '0'");
		
			$product_id = $this->db->getLastId();
			$last_product_id = $product_id;			
		}
		$date = $row_product[0]['date_added'];
		
		if ($catcreate) {
			$dim = count($catmany);
			if (!$parent and $dim > 1) {									
				$rows = $this->getCategoryIDbyName($catmany[$dim-1]);			
				if (!empty($rows)) {
					$parent_id = $rows[0]['category_id'];
				
					$dim = $dim - 2;				
					for($i=$dim; $i>=0; $i--) {					
						$rows1 = $this->getCategoryIDbyName($catmany[$i]);					
						if (!empty($rows1)) {										
							$fl = 0;								
							foreach ($rows1 as $r1) {
								$rows2 = $this->isLink($parent_id, $r1['category_id']); 
								if (!empty($rows2)) {
									$parent_id = $r1['category_id'];
									$cat_id = $r1['category_id'];
									$fl = 1;			
									break;
								}
							}
							if (!$fl) {
								$this->CreateCategory($catmany[$i], $langs, $parent_id, $cat_id, $date, $refers[$i]);
								$parent_id = $cat_id;								
							} 				
							
						} else {
							$this->CreateCategory($catmany[$i], $langs, $parent_id, $cat_id, $date, $refers[$i]);					
							$parent_id = $cat_id;						
						}				
					}				
				}
			}		
			return;
		}
		// Описание оригинал
		$descript = "";
		if (isset($row_product[0]['description'])) {
			$descript = $row_product[0]['description'];
			$descript = $this->symbol($descript);
		}	
			
		// Наименование товара
		$prod_name = "";
		if (isset($row_product[0]['item'])) {
			$prod_name = $row_product[0]['item'];						
			$prod_name = $this->Code($prod_name);
			$prod_name = str_replace("#" , '' , $prod_name);
			$prod_name = trim($prod_name);
		}	
		
		// Мета-данные	
		
		// Сео-Имя производителя. Удалить ООО и ТОВ
		$meta_manuf = '';
		if (isset($row_product[0]['manuf_name'])) {
			$meta_manuf = str_replace('ООО' , '' , $row_product[0]['manuf_name']);		
			$meta_manuf = str_replace('ТОВ' , '' , $meta_manuf);
			$meta_manuf = $this->Code($meta_manuf);
			$meta_manuf = str_replace("\\" , '' , $meta_manuf);
			$meta_manuf = trim($meta_manuf);
		}	
			
		// Сео-Наименование товара
		$seo_h1 = $prod_name;

		// Вытаскиваем из БД название магазина
		$n = "config_name";
		$rows = $this->getStore($n);				
		$meta_store = 'Мой магазин'; 
		if (isset($rows[0]['value'])) $meta_store = $rows[0]['value'];
		
		$seo_title = $prod_name . " купить в ......, ......., ...... в интернет-магазине | " . $meta_store;
		
		// Вытаскиваем название категории для этого продукта 
		$rows = $this->getCategoryName((int)$row_product[0]['category_id']);
		$meta_category_name = '';	
		if (isset($rows[0]['name'])) $meta_category_name = $rows[0]['name'];
		
		$meta_bla = 'купить,заказать,дешево'; // Дополнительные слова. Можно менять, добавлять		
		
		// Мета-кейвордз Ключевые слова: имя магазина, производитель, продукт, категория, бла-бла-бла
		$meta_keywords = '';
		$meta_keywords = $meta_store;
		if (!empty($meta_manuf)) $meta_keywords = $meta_keywords . ','. $meta_manuf;		
		if (!empty($seo_h1)) $meta_keywords = $meta_keywords . ','. $seo_h1;
		if (!empty($meta_category_name)) $meta_keywords = $meta_keywords . ','. $meta_category_name;		
		if (!empty($meta_bla)) $meta_keywords = $meta_keywords . ','. $meta_bla;		
		
		// Мета-данные
		$meta_desc = "В интернет магазине ***". $meta_store . "*** тел.: ......  Вы можете купить " . $prod_name . "  по выгодной цене. У нас лучший выбор " . $meta_category_name . " отличные цены на " . $prod_name . " доставка в ......, ......, ......, ...... и другие города ......";
		
		// Метки: атрибуты товара см. стр "Атрибуты"
		$at ='';
		if ($max_attr) {			
			for ($j = 1; $j <= $max_attr; $j++) {
				if ($j > 30) break;
				if (isset($row[$attr_ext[$j]]) and !empty($row[$attr_ext[$j]])) {
					if (!preg_match('/^[0-9 ]+$/', $row[$attr_ext[$j]])) {
						if ($tags[$j]) {						
							$add = $this->symbol($row[$attr_ext[$j]]);
							if (empty($at)) $at = $add;
							else $at = $at.','.$add;
						}	
					}	
				}	
			}
		}
		
		$tag = '';
		$tag = $meta_category_name;
		if (!empty($meta_manuf)) $tag = $tag . ','. $meta_manuf;
		if (!empty($at)) $tag = $tag .',' . $at;
		
		// SEO URL
		$seo_url = $prod_name;			
	//	$seo_url = substr($seo_url, 0, 64);  // обрезать до 64 символов        
	//	$seo_url = $seo_url.'_'.$row_product[0]['model']; // название товара+Модель
	//  $seo_url = $row_product[0]['sku']."_".$row_product[0]['model']; // sku+model
	//	$seo_url = $seo_url."_".$row_product[0]['sku']; // название+sku
		$seo_url = $this->TransLit($seo_url);
		$seo_url = $this->MetaURL($seo_url);			
		$seo_url = strtolower($seo_url);
		
		$meta_prod_name_t = $seo_title;
		$meta_prod_name = $seo_h1;
		// Импорт мета-данных из прас-листа. Из колонкок праса номера: 23, 24, 25, 26, 27, 28
		if ($addseo == 2) {
			if (isset($row_product[0]['seo_h1']) and !empty($row_product[0]['seo_h1'])) $meta_prod_name = $row_product[0]['seo_h1'];
			if (isset($row_product[0]['seo_title']) and !empty($row_product[0]['seo_title'])) $meta_prod_name_t = $row_product[0]['seo_title'];
			if (isset($row_product[0]['meta_keyword']) and !empty($row_product[0]['meta_keyword'])) $meta_keywords = $row_product[0]['meta_keyword'];
			if (isset($row_product[0]['meta_description']) and !empty($row_product[0]['meta_description'])) $meta_desc = $row_product[0]['meta_description'];
			if (isset($row_product[0]['tag']) and !empty($row_product[0]['tag'])) $tag = $row_product[0]['tag'];
		}		
		if ($newurl) {
			if (isset($row_product[0]['url']) and !empty($row_product[0]['url'])) $seo_url = $row_product[0]['url'];
		}
		
		for	($i=1; $i<=count($langs); $i++) {			
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET `product_id` = '" .(int)$product_id. "', `language_id` = '" .$langs[$i]. "', `name` = '" . $this->db->escape($prod_name) . "', `description` = '" . $this->db->escape($descript). "'");
			
			if ($addseo) {
				$this->db->query("UPDATE " . DB_PREFIX . "product_description SET `meta_description` = '" . $this->db->escape($meta_desc) . "', `meta_keyword` = '" . $this->db->escape($meta_keywords) . "', `seo_title` = '" . $this->db->escape($meta_prod_name_t) . "', `seo_h1` = '" . $this->db->escape($meta_prod_name) . "', `tag` = '" . $this->db->escape($tag) . "' WHERE `product_id` = '" .(int)$product_id. "'");					
			}
		}		
		
		for ($i=0; $i<10; $i++) {
			if (!isset($catmany[$i])) break;
			if ($i == 0) {			
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET `product_id` = '" .(int)$product_id. "', `category_id` = '" . (int)$row_product[0]['category_id'] . "', `main_category` = 1");
			} else {
				$rows = $this->getCategoryIDbyName($catmany[$i]);			
				if (!empty($rows)) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET `product_id` = '" .(int)$product_id. "', `category_id` = '" . (int)$rows[0]['category_id'] . "', `main_category` = 0");
				}	
			}	
		}	
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET `product_id` = '" .(int)$product_id. "', `store_id` = 0");		

		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($seo_url) . "'");
	
		if ($parent) {
			$category_id = (int)$row_product[0]['category_id'];
			$rows  = $this->getCategory($category_id);
			if (!empty($rows)) {
				$parent_id = $rows[0]['parent_id'];		
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET `product_id` = '" .(int)$product_id. "', `category_id` = '" . $parent_id . "', `main_category` = 0");
			}	
		}
		
		$this->cache->delete('*');
	}
	
	public function deleteProduct($product_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE product_id = '" . (int)$product_id . "'");		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");	
		$this->db->query("DELETE FROM " . DB_PREFIX . "suppler_sku WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions_option WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "relatedoptions_variant_product WHERE product_id = '" . (int)$product_id . "'");
		
		$this->cache->delete('product');
	}
	
	public function clearCache() {
		$this->cache->delete('*');
	}
	
	public function Code($text) {
		
		$text = $this->symbol($text);		
		
	//	$text = str_replace('?' , '' , $text);
	//	$text = str_replace('@' , '' , $text);
	//	$text = str_replace('+' , '' , $text);
	//	$text = str_replace('!' , '' , $text);
	//	$text = str_replace(',' , '' , $text);		
	//	$text = str_replace('&nbsp;' , ' ' , $text);		
		$text = str_replace('"', '&quot;' , $text);
		$text = str_replace("'" , '&#039;' , $text);		
		$text = preg_replace('| +|', ' ', $text);		
		$text = preg_replace('|-+|', '-', $text);
		$text = preg_replace('|_+|', '_', $text);
		
		$text = trim($text);

		return $text;
	}
	
	public function MetaURL($text) {
			
		$text = str_replace('&amp;&quot;' , '-' , $text);			
		$text = str_replace('&amp;' , '-' , $text);
		$text = str_replace('&quot;' , '-' , $text);
		$text = str_replace('&gt;' , '-' , $text);
		$text = str_replace('&lt;' , '-' , $text);
		$text = str_replace("'" , '-' , $text);
		$text = str_replace('"' , '-' , $text);
		$text = str_replace('.' , '-' , $text);
		$text = str_replace(':' , '-' , $text);
		$text = str_replace('|' , '-' , $text);
		$text = str_replace('*' , '-' , $text);
		$text = str_replace('=' , '-' , $text);
		$text = str_replace('^' , '-' , $text);
		$text = str_replace('%' , '-' , $text);
		$text = str_replace('$' , '-' , $text);
		$text = str_replace('?' , '-' , $text);
		$text = str_replace('@' , '-' , $text);
		$text = str_replace('+' , '-' , $text);
		$text = str_replace('!' , '-' , $text);
		$text = str_replace('<' , '' , $text);		
		$text = str_replace('>' , '' , $text);
		$text = str_replace('#' , '' , $text);
		$text = str_replace(',' , '-' , $text);		
		$text = str_replace('\\' , '-' , $text);
		$text = str_replace('\/' , '-' , $text);		
		$text = str_replace('_' , '-' , $text);
		$text = str_replace("/" , '-' , $text);		
		$text = str_replace("(" , '' , $text);
		$text = str_replace(")" , '' , $text);
		$text = str_replace("[" , '' , $text);
		$text = str_replace("]" , '' , $text);
		$text = str_replace('&' , '-' , $text);
		$text = str_replace('#' , '' , $text);		
		$text = str_replace(" " , '-' , $text);		
		$text = preg_replace('|-+|', '-', $text);		
		$l = strlen($text);		
		if (substr($text, $l-1, 1) == "-") $text = substr($text, 0, $l-1);
		$text = trim($text);

		return $text;
	}
	
	public function symbol($text) {
	
		$tr = array(
				"&amp;#000;"=>"","&amp;#001;"=>"","&amp;#002;"=>"","&amp;#003;"=>"","&amp;#004;"=>"","&amp;#005;"=>"",
				"&amp;#006;"=>"","&amp;#007;"=>"","&amp;#008;"=>"","&amp;#009;"=>"","&amp;#010;"=>"","&amp;#011;"=>"",
				"&amp;#012;"=>"","&amp;#013;"=>"","&amp;#014;"=>"","&amp;#015;"=>"","&amp;#016;"=>"","&amp;#017;"=>"",
				"&amp;#018;"=>"","&amp;#019;"=>"","&amp;#020;"=>"","&amp;#021;"=>"","&amp;#022;"=>'"',"&amp;#023;"=>"",
				"&amp;#024;"=>"","&amp;#025;"=>"","&amp;#026;"=>"","&amp;#027;"=>"","&amp;#028;"=>"","&amp;#029;"=>"",
				"&amp;#030;"=>"","&amp;#031;"=>"","&amp;#032;"=>"",
                "&amp;#033;"=>"!","&amp;#034;"=>'"',"&amp;#035;"=>"#","&amp;#036;"=>"$",
                "&amp;#037;"=>"%","&amp;#038;"=>"&","&amp;#039;"=>"'","&amp;#040;"=>"(",
				"&amp;#041;"=>")","&amp;#042;"=>"*","&amp;#043;"=>"+","&amp;#044;"=>'"',"&amp;#045;"=>"-",
				"&amp;#046;"=>".","&amp;#047;"=>"/","&amp;#058;"=>":","&amp;#059;"=>";","&amp;#060;"=>"<",
				"&amp;#061;"=>"=","&amp;#062;"=>">","&amp;#064;"=>"?","&amp;#064;"=>"@",
				"&amp;#091;"=>"[","&amp;#092;"=>"\\","&amp;#093;"=>"]","&amp;#094;"=>"^","&amp;#095;"=>"_",
				"&amp;#096;"=>"`","&amp;#123;"=>"{","&amp;#124;"=>"|","&amp;#125;"=>"}","&amp;#126;"=>"~",
				"&amp;#128;"=>"EUR","&amp;#130;"=>'"',"&amp;#131;"=>"f","&amp;#132;"=>'"',"&amp;#133;"=>"...",
				"&amp;#134;"=>"+","&amp;#135;"=>"","&amp;#136;"=>"^","&amp;#137;"=>"%.","&amp;#138;"=>"S",
				"&amp;#139;"=>"","&amp;#140;"=>"","&amp;#141;"=>"","&amp;#142;"=>"","&amp;#143;"=>"",
				"&amp;#144;"=>"","&amp;#145;"=>"`","&amp;#146;"=>'"',"&amp;#147;"=>'"',"&amp;#148;"=>'"',
				"&amp;#149;"=>"*","&amp;#150;"=>"-","&amp;#151;"=>"-","&amp;#152;"=>"~","&amp;#153;"=>"TM",
				"&amp;#154;"=>"s","&amp;#155;"=>">","&amp;#156;"=>"","&amp;#157;"=>"","&amp;#158;"=>"",
				"&amp;#159;"=>"","&amp;#160;"=>" ","&amp;#161;"=>"","&amp;#162;"=>"","&amp;#163;"=>"",
				"&amp;#164;"=>"","&amp;#165;"=>"","&amp;#166;"=>"|","&amp;#167;"=>"","&amp;#168;"=>"..",
				"&amp;#169;"=>"","&amp;#170;"=>"a","&amp;#171;"=>'"',"&amp;#172;"=>"","&amp;#173;"=>"",
				"&amp;#174;"=>"","&amp;#175;"=>"","&amp;#176;"=>"","&amp;#177;"=>"","&amp;#178;"=>"",
				"&amp;#179;"=>"","&amp;#180;"=>"","&amp;#181;"=>"","&amp;#182;"=>"","&amp;#183;"=>"",
				"&amp;#184;"=>"","&amp;#185;"=>"","&amp;#186;"=>"","&amp;#187;"=>'"',"&amp;#188;"=>"",
				"&amp;#189;"=>"","&amp;#190;"=>"","&amp;#191;"=>"","&amp;#192;"=>"","&amp;#193;"=>"",
				"&amp;#194;"=>"","&amp;#195;"=>"","&amp;#196;"=>"","&amp;#197;"=>"","&amp;#198;"=>"",
				"&amp;#199;"=>"","&amp;#200;"=>"","&amp;#201;"=>"","&amp;#202;"=>"","&amp;#203;"=>"",
				"&amp;#204;"=>"","&amp;#205;"=>"","&amp;#206;"=>"","&amp;#207;"=>"","&amp;#208;"=>"",
				"&amp;#209;"=>"","&amp;#210;"=>"","&amp;#211;"=>"","&amp;#212;"=>"","&amp;#213;"=>"",
				"&amp;#214;"=>"","&amp;#215;"=>"","&amp;#216;"=>"","&amp;#217;"=>"","&amp;#218;"=>"",
				"&amp;#219;"=>"","&amp;#220;"=>"","&amp;#221;"=>"","&amp;#222;"=>"","&amp;#223;"=>"",
				"&amp;#224;"=>"","&amp;#225;"=>"","&amp;#226;"=>"","&amp;#227;"=>"","&amp;#228;"=>"",
				"&amp;#229;"=>"","&amp;#230;"=>"","&amp;#231;"=>"","&amp;#232;"=>"","&amp;#233;"=>"",
				"&amp;#234;"=>"","&amp;#235;"=>"","&amp;#236;"=>"","&amp;#237;"=>"","&amp;#238;"=>"",
				"&amp;#239;"=>"","&amp;#240;"=>"","&amp;#241;"=>"","&amp;#242;"=>"","&amp;#243;"=>"",
				"&amp;#244;"=>"","&amp;#245;"=>"","&amp;#246;"=>"","&amp;#247;"=>"","&amp;#248;"=>"",
				"&amp;#240;"=>"","&amp;#250;"=>"","&amp;#251;"=>"","&amp;#252;"=>"","&amp;#253;"=>"",
				"&amp;#254;"=>"","&amp;#255;"=>"","&amp;#8221;"=>'"',"&amp;quot;" =>'"', "&amp;laquo;" =>'"', 
				"&amp;raquo;" =>'"', "&amp;raquo;" =>'"', "&amp;ndash;" =>"-", "&amp;plusmn;"=>"", "&amp;amp;"=>"&",
				"&amp;gt;"=>">", "&amp;lt;"=>"<", "&amp;nbsp;"=>" ",
				
				"&#000;"=>"","&#001;"=>"","&#002;"=>"","&#003;"=>"","&#004;"=>"","&#005;"=>"",
				"&#006;"=>"","&#007;"=>"","&#008;"=>"","&#009;"=>"","&#010;"=>"","&#011;"=>"",
				"&#012;"=>"","&#013;"=>"","&#014;"=>"","&#015;"=>"","&#016;"=>"","&#017;"=>"",
				"&#018;"=>"","&#019;"=>"","&#020;"=>"","&#021;"=>"","&#022;"=>"","&#023;"=>"",
				"&#024;"=>"","&#025;"=>"","&#026;"=>"","&#027;"=>"","&#028;"=>"","&#029;"=>"",
				"&#030;"=>"","&#031;"=>"","&#032;"=>"", "&#33;"=>"!","&#34;"=>'"',"&#35;"=>"#","&#36;"=>"$",
                "&#37;"=>"%","&#38;"=>"&","&#39;"=>"'","&#40;"=>"(",
				"&#41;"=>")","&#42;"=>"*","&#43;"=>"+","&#44;"=>'"',"&#45;"=>"-",
				"&#46;"=>".","&#47;"=>"/","&#58;"=>":","&#59;"=>";","&#60;"=>"<",
				"&#61;"=>"=","&#62;"=>">","&#64;"=>"?","&#64;"=>"@",
				"&#91;"=>"[","&#92;"=>"\\","&#93;"=>"]","&#94;"=>"^","&#95;"=>"_",
				"&#96;"=>"`",
                "&#033;"=>"!","&#034;"=>'"',"&#035;"=>"#","&#036;"=>"$",
                "&#037;"=>"%","&#038;"=>"&","&#039;"=>"'","&#040;"=>"(",
				"&#041;"=>")","&#042;"=>"*","&#043;"=>"+","&#044;"=>'"',"&#045;"=>"-",
				"&#046;"=>".","&#047;"=>"/","&#058;"=>":","&#059;"=>";","&#060;"=>"<",
				"&#061;"=>"=","&#062;"=>">","&#064;"=>"?","&#064;"=>"@",
				"&#091;"=>"[","&#092;"=>"\\","&#093;"=>"]","&#094;"=>"^","&#095;"=>"_",
				"&#096;"=>"`","&#123;"=>"{","&#124;"=>"|","&#125;"=>"}","&#126;"=>"~",
				"&#128;"=>"EUR","&#130;"=>'"',"&#131;"=>"f","&#132;"=>'"',"&#133;"=>"...",
				"&#134;"=>"+","&#135;"=>"","&#136;"=>"^","&#137;"=>"%.","&#138;"=>"S",
				"&#139;"=>"","&#140;"=>"","&#141;"=>"","&#142;"=>"","&#143;"=>"",
				"&#144;"=>"","&#145;"=>"`","&#146;"=>'"',"&#147;"=>'"',"&#148;"=>'"',
				"&#149;"=>"*","&#150;"=>"-","&#151;"=>"-","&#152;"=>"~","&#153;"=>"TM",
				"&#154;"=>"s","&#155;"=>">","&#156;"=>"","&#157;"=>"","&#158;"=>"",
				"&#159;"=>"","&#160;"=>" ","&#161;"=>"","&#162;"=>"","&#163;"=>"",
				"&#164;"=>"","&#165;"=>"","&#166;"=>"|","&#167;"=>"","&#168;"=>"..",
				"&#169;"=>"","&#170;"=>"a","&#171;"=>'"',"&#172;"=>"","&#173;"=>"",
				"&#174;"=>"","&#175;"=>"","&#176;"=>"","&#177;"=>"","&#178;"=>"",
				"&#179;"=>"","&#180;"=>"","&#181;"=>"","&#182;"=>"","&#183;"=>"",
				"&#184;"=>"","&#185;"=>"","&#186;"=>"","&#187;"=>'"',"&#188;"=>"",
				"&#189;"=>"","&#190;"=>"","&#191;"=>"","&#192;"=>"","&#193;"=>"",
				"&#194;"=>"","&#195;"=>"","&#196;"=>"","&#197;"=>"","&#198;"=>"",
				"&#199;"=>"","&#200;"=>"","&#201;"=>"","&#202;"=>"","&#203;"=>"",
				"&#204;"=>"","&#205;"=>"","&#206;"=>"","&#207;"=>"","&#208;"=>"",
				"&#209;"=>"","&#210;"=>"","&#211;"=>"","&#212;"=>"","&#213;"=>"",
				"&#214;"=>"","&#215;"=>"","&#216;"=>"","&#217;"=>"","&#218;"=>"",
				"&#219;"=>"","&#220;"=>"","&#221;"=>"","&#222;"=>"","&#223;"=>"",
				"&#224;"=>"","&#225;"=>"","&#226;"=>"","&#227;"=>"","&#228;"=>"",
				"&#229;"=>"","&#230;"=>"","&#231;"=>"","&#232;"=>"","&#233;"=>"",
				"&#234;"=>"","&#235;"=>"","&#236;"=>"","&#237;"=>"","&#238;"=>"",
				"&#239;"=>"","&#240;"=>"","&#241;"=>"","&#242;"=>"","&#243;"=>"",
				"&#244;"=>"","&#245;"=>"","&#246;"=>"","&#247;"=>"","&#248;"=>"",
				"&#240;"=>"","&#250;"=>"","&#251;"=>"","&#252;"=>"","&#253;"=>"",
				"&#254;"=>"","&#255;"=>"", "&#8221;"=>'"', "&quot;" =>'"', "&laquo;" =>'"', 
				"&raquo;" =>'"', "&raquo;" =>'"', "&ndash;" =>"-", "&plusmn;"=>"");
				
		$text = strtr($text, $tr);
		$text = preg_replace('#^(:?&)(.*&?)(;)$#','',$text);		

		return $text;
	}

	public function litteras($text) {
	
		$tr = array(
				"&#45;"=>'-',"&#46;"=>'.',"&#47;"=>'/',
				"&#33;"=>'!',"&#34;"=>'"',"&#40;"=>'(',"&#41;"=>")","&#42;"=>"*","&#43;"=>"+",
				"&#758;"=>'"',"&#760;"=>":","&#782;"=>'"',"&#800;"=>"_","&#39;"=>"'","&#38;"=>"&",
				"&#840;"=>'"',"&#818;"=>"_","&#824;"=>"/","&#822;"=>"-","&#817;"=>"-","&#451;"=>"!",
				"&#1030;"=>"I","&#1031;"=>"Ї","&#1042;"=>"В","&#1110;"=>"і","&#1111;"=>"ї","&#835;"=>"'",
				"&#1040;"=>"А","&#1041;"=>"Б","&#1042;"=>"В","&#1043;"=>"Г","&#1044;"=>"Д","&#1045;"=>"Е",
				"&#1046;"=>"Ж","&#1047;"=>"З","&#1048;"=>"И","&#1049;"=>"Й","&#1050;"=>"К","&#1051;"=>"Л",
				"&#1052;"=>"М","&#1053;"=>"Н","&#1054;"=>"О","&#1055;"=>"П","&#1056;"=>"Р","&#1057;"=>"С",
				"&#1058;"=>"Т","&#1059;"=>"У","&#1060;"=>"Ф","&#1061;"=>"Х","&#1062;"=>"Ц","&#1063;"=>"Ч",
				"&#1064;"=>"Ш","&#1065;"=>"Щ","&#1066;"=>"Ъ","&#1067;"=>"Ы","&#1068;"=>"Ь","&#1069;"=>"Э",
				"&#1070;"=>"Ю","&#1071;"=>"Я","&#1072;"=>"а","&#1073;"=>"б","&#1074;"=>"в","&#1075;"=>"г",
				"&#1076;"=>"д","&#1077;"=>"е","&#1078;"=>"ж","&#1079;"=>"з","&#1080;"=>"и","&#1081;"=>"й",
				"&#1082;"=>"к","&#1083;"=>"л","&#1084;"=>"м","&#1085;"=>"н","&#1086;"=>"о","&#1087;"=>"п",
				"&#1088;"=>"р","&#1089;"=>"с","&#1090;"=>"т","&#1091;"=>"у","&#1092;"=>"ф","&#1093;"=>"х",
				"&#1094;"=>"ц","&#1095;"=>"ч","&#1096;"=>"ш","&#1097;"=>"щ","&#1098;"=>"ъ","&#1099;"=>"ы",
				"&#1100;"=>"ь","&#1101;"=>"э","&#1102;"=>"ю","&#1103;"=>"я");				
				
		$text = strtr($text, $tr);
		$text = preg_replace('#^(:?&)(.*&?)(;)$#','',$text);		

		return $text;
	}

	public function TransLit($text) {
	
		$tr = array(
                "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
                "Д"=>"d","Е"=>"e","Ё"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
                "Й"=>"J","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
                "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
                "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
                "Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"y","Ь"=>"",
                "Э"=>"e","Ю"=>"yu","Я"=>"ya","Ї"=>"ji","Ґ" =>"g","І" =>"I","а"=>"a","б"=>"b",
                "в"=>"v","г"=>"g","д"=>"d","е"=>"e", "ё"=>"e","ж"=>"j",
                "з"=>"z","и"=>"i","й"=>"j","к"=>"k","л"=>"l",
                "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
                "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
                "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
                "ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
                "ї"=> "ji", "і"=> "i", "ґ" =>"g" );
				
		$text = strtr($text, $tr);		
		return $text;
	}
	
	public function FixURLcategory() {
		$lang = $this->config->get('config_language_id');
		$n = "config_name";
		$rows = $this->getStore($n);				
		$store = 'Мой магазин'; 
		if (isset($rows[0]['value'])) $store = $rows[0]['value'];
		
		$row = $this->getMaxCategoryID();
		$max = $row['max(category_id)'];
		for ($i=1; $i<=$max; $i++) {
			$rows = $this->getCategoryName($i);
			if (empty($rows)) continue;
			
		// Мета-данные		
			$name = $rows[0]['name'];
			$seo_h1 = $name;		
			$seo_title = $name . " купить в ...., ...., .... в интернет-магазине | " . $store;
			$desc = $name . " от известных мировых брендов, соответствующих самым высоким стандартам качества. " .  $name . ", в магазине " . $store . " - безошибочный выбор: мы даем гарантию на все товары, купленные у нас.";
			$seo_desc = "Купить " . $name . " в  интернет-магазине  с ***бесплатно доставкой*** по ..... Свыше 500 наименований продукции " . $name . ". 100% гарантия качества. Мы доставляем в ....., ....., ..... и другие города";
			$seo_keyword = $store . "," . $name . ",.....,.....,.....,.....,интернет-магазин";
			$seo_url = $this->TransLit($name);
			$seo_url = $this->MetaURL($seo_url);
			$seo_url = strtolower($seo_url);
			
			$this->db->query("UPDATE " . DB_PREFIX . "category_description SET `name` = '" . $this->db->escape($name) . "', `description` = '" . $desc . "', `meta_description` = '" . $seo_desc . "', `meta_keyword` = '" . $this->db->escape($seo_keyword) . "', `seo_h1` = '" . $this->db->escape($seo_h1) . "', `seo_title` = '" . $this->db->escape($seo_title) . "' WHERE `category_id` = '". $i . "' and `language_id` = '" . $lang . "'");
			
			$row = $this->getURLcategory($i);
			if (empty($row)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . $i . "', keyword = '" . $this->db->escape($seo_url) . "'");
			} else {		
				$this->db->query("UPDATE " . DB_PREFIX . "url_alias SET `keyword` = '" . $this->db->escape($seo_url) . "' WHERE `query` = 'category_id=" . $i . "'");
			}
		}		
	}
	
	public function FixURLmanufacturer() {
		$lang = $this->config->get('config_language_id');
		$n = "config_name";
		$rows = $this->getStore($n);				
		$store = 'Мой магазин'; 
		if (isset($rows[0]['value'])) $store = $rows[0]['value'];
		
		$row = $this->getMaxManufacturerID();
		$max = $row['max(manufacturer_id)'];
		for ($i=1; $i<=$max; $i++) {					
			$rows = $this->getManufacturerName($i);
			if (empty($rows)) continue;
		
		// Мета-данные
			$name = $rows[0]['name'];
			$seo_h1 = $name;			
			$seo_title = "Купить " . $name . " в ....., ......, ......, ...... Самые низкие цены в интернет-магазине | " . $store;
			$desc = $name . " от известных мировых брендов, соответствующих самым высоким стандартам качества. " .  $name . ", в магазине " . $store . " - безошибочный выбор: мы даем гарантию на все товары, купленные у нас.";
			$seo_desc = "Купить ". $name . " в  интернет-магазине  с доставкой по ...... Заходите у нас большой выбор " . $name . " и отличные цены. Мы доставляем в ....., ......, ....., ..... и другие города";
			$seo_keyword = $store . "," . $name . ",.....,.....,.....,.....,интернет-магазин";				
			$seo_url = $this->TransLit($name);
			$seo_url = $this->MetaURL($seo_url);
			$seo_url = strtolower($seo_url);

			$this->db->query("UPDATE " . DB_PREFIX . "manufacturer_description SET `description` = '" . $this->db->escape($desc) . "', `meta_description` = '" . $this->db->escape($seo_desc) . "', `meta_keyword` = '" . $this->db->escape($seo_keyword) . "', `seo_h1` = '" . $this->db->escape($seo_h1) . "', `seo_title` = '" . $this->db->escape($seo_title) . "' WHERE `manufacturer_id` = '". $i . "' and `language_id` = '" . $lang . "'");
			
			$row = $this->getURLmanufacturer($i);
			if (empty($row)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . $i . "', keyword = '" . $this->db->escape($seo_url) . "'");
			} else {		
				$this->db->query("UPDATE " . DB_PREFIX . "url_alias SET `keyword` = '" . $this->db->escape($seo_url) . "' WHERE `query` = 'manufacturer_id=" . $i . "'");
			}
		}
	}
	public function FixURL($row) {
		$product_id = $row['product_id'];
		$rows = $this->getProductsByID($product_id);
		$model = '';
		$sku = '';
		if (!empty($rows)) {
			$model = $rows[0]['model'];
			$sku = $rows[0]['sku'];
		}
		$rows = $this->getProductDesc($product_id);		
		$name = '';
		$name = $this->Code($rows[0]['name']);
		$seo_url = $this->TransLit($name);		
		$seo_url = $this->MetaURL($seo_url);
		$seo_url = strtolower($seo_url);
		
	//	$seo_url = substr($seo_url, 0, 64);  // обрезать до 64 символов        
	//	$seo_url = $seo_url.'_'.$model; // название товара+Модель
	//  $seo_url = $row_product[0]['sku']."_".$model; // sku+model
	//	$seo_url = $seo_url."_".$sku; // название+sku
	
		$row = $this->getURL($row['product_id']);
		if (empty($row)) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($seo_url) . "'");
		} else {		
			$this->db->query("UPDATE " . DB_PREFIX . "url_alias SET `keyword` = '" . $this->db->escape($seo_url) . "' WHERE `query` = 'product_id=" . $product_id . "'");
		}
	}
	
	public function FixMetaproduct($row) {	
		$product_id = $row['product_id'];
		$rows = $this->getProductsByID($product_id);
		$model = '';
		$sku = '';
		if (!empty($rows)) {
			$model = $rows[0]['model'];
			$sku = $rows[0]['sku'];
		}
		$rows = $this->getProductDesc($product_id);		
		$lang = $this->config->get('config_language_id');
		$name = '';
		$name = $this->Code($rows[0]['name']);
		$description = $rows[0]['description'];
		$rows = $this->getProductCategory($product_id);
		$category_id = 0;
		$category_id = $rows[0]['category_id'];
		$rows = $this->getCategoryName($category_id);
		$cat_name = '';
		$cat_name = $rows[0]['name'];
		$rows = $this->getManufacturerName($row['manufacturer_id']);
		$manuf_name = '';
		$manuf_name = $rows[0]['name'];
		$n = "config_name";
		$rows = $this->getStore($n);				
		$store = 'Мой магазин'; 
		if (isset($rows[0]['value'])) $store = $rows[0]['value'];		
		
	// Мета-данные				
		$seo_h1 = $name;		
		$seo_title = $name . " купить в ......, ......., " . "в  интернет-магазине | " . $store;		
		$seo_keyword = $store . ", заказать, купить, дешево, " . $name . ", ........";
		$seo_desc = "В интернет магазине ***". $store . "*** тел.: ........  Вы можете купить " . $name . "  по выгодной цене. У нас лучший выбор " . $cat_name . " отличные цены на " . $name . " доставка в ......, ......, ......, ...... и другие города .......";
		
		$seo_tags = $cat_name . ',' . $manuf_name;		
		
		if (!empty($name)) 
		$this->db->query("UPDATE " . DB_PREFIX . "product_description SET `seo_title` = '" . $this->db->escape($seo_title) . "', `name` = '" . $this->db->escape($name) . "', `seo_h1` = '" . $this->db->escape($seo_h1) . "', `meta_description` = '" . $this->db->escape($seo_desc) . "', `meta_keyword` = '" . $this->db->escape($seo_keyword) . "', `tag` = '" . $this->db->escape($seo_tags) . "' WHERE `product_id` = '" .(int)$product_id . "' and `language_id` = '" . $lang. "'");
				
	}
	
	public function findProduct($cod) {
		$rows = '';
		$rows  = $this->getProductBySKU($cod);
		if (empty($rows)) {
			$row = $this->getskuDescription($cod);
			if (empty($row)) return "";			
			$id = $row['sku_id'];
			$row = $this->getProductIDbySkuID($id);			
			if (!empty($row)) $rows = $this->getProductsByID($row['product_id']);		
		}
		return $rows;
	}	
	
	public function getProduct($cod) {
		$c = $cod;
		$rows = "";	
		$rows = $this->findProduct($c);
		if (empty($rows)) {
			$c = str_replace(" ", "", $cod);
			$c = trim($c);
			$rows = $this->findProduct($c);
		}	
		return $rows;
	}		
	
	public function addSkuToTable($c, &$sku_id) {
		if (!$sku_id) {
			$row = $this->getMaxSkuID();
			$sku_id = $row['max(sku_id)'];
			$sku_id = $sku_id + 1;
		}		
		$row = $this->getskuDescription($c);
		if (!empty($row) and !empty($c) and !empty($sku_id)) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "suppler_sku_description WHERE sku = '" . $c . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "suppler_sku_description SET `sku_id` = '" .$sku_id. "', `sku` = '" . $this->db->escape($c) . "'");		
		}
		if ((!isset($row) or empty($row)) and !empty($c)) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "suppler_sku_description SET `sku_id` = '" .$sku_id. "', `sku` = '" . $this->db->escape($c) . "'");
			
		} 
		
	}
	
	public function addProductToTable($product_id, $code, &$last_sku_id) {			
		$row = $this->getskuDescription($code);
		if (!empty($row)) {
			$this->putsku($product_id, $row['sku_id']);
			$last_sku_id = $row['sku_id'];			
		} else {
			$code = trim($code);			
			$last_sku_id = 0;
			$this->addSkuToTable($code, $last_sku_id);			
			$this->putsku($product_id, $last_sku_id);			
		}	
	}
	
	public function CreateSkuTable($row) {
		$last_sku_id = 0;
	// запишем sku существующего товара (с пробелами и без пробелов) в библиотеку
		$this->addProductToTable($row['product_id'], $row['sku'], $last_sku_id);
		$c = str_replace(" ", "", $row['sku']);
		$c = trim($c);
		if ($c != $row['sku'] and !empty($c)) $this->addSkuToTable($c, $last_sku_id);
	// если sku состоит из двух разных ску, разделенных слешем, то пишем все по одному до 2-х штук
		if (substr_count($row['sku'], "/")) {
			$codes = explode("/", $row['sku']);
			if (isset($codes[0]) and !empty($codes[0]) and isset($codes[1]) and !empty($codes[1])) {
				$l1 = strlen($codes[0]);
				$l2 = strlen($codes[1]);				
				if (substr($codes[0],0,1) == substr($codes[1],0,1) and $l1 == $l2) {
					$this->addSkuToTable($codes[0], $last_sku_id);
					$c = str_replace(" ", "", $codes[0]);
					$c = trim($c);
					if ($c != $codes[0] and !empty($c)) $this->addSkuToTable($c, $last_sku_id);
					$this->addSkuToTable($codes[1], $last_sku_id);
					$c = str_replace(" ", "", $codes[1]);
					$c = trim($c);
					if ($c != $codes[1] and !empty($c)) $this->addSkuToTable($c, $last_sku_id);					
				}				
			}			
		}
	/*	
	// Если в названии товара есть скобки, то пишем в библиотеку все, что в скобках, если там не только русские буквы
		$rows = $this->getProductDesc($row['product_id']);
		if (!empty($rows)) {
			$pb = strpos($rows[0]['name'], "(");
			if ($pb) {
				$pe = strpos($rows[0]['name'], ")");
				if ($pe) {
					$l = $pe - $pb - 1;
					if ($l > 0) {
						$txt = substr($rows[0]['name'], $pb+1, $l);
						if (!preg_match('/^[А-Яа-я.,-:? ]+$/', $txt) and !empty($txt)) {
							$this->addSkuToTable($txt, $last_sku_id);
							$c = str_replace(" ", "", $txt);
							$c = trim($c);
							if ($c != $txt and !empty($c)) $this->addSkuToTable($c, $last_sku_id);
						}
					}
				}
			}
		}	*/
	}	
	
	public function DoubleFoto($product_id) {
		$row = $this->getProductByID($product_id);
		if (isset($row) and !empty($row)) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' and `image` = '".$row['image']."'");
		}
		
		$rows = $this->getProductImage($product_id);
	// проверяем до 20 дополнительных фото
		for ($i=0; $i<20; $i++) {
			if (!isset($rows[$i]['image'])) break;
			if ($rows[$i]['image'] == "del") continue;
			for ($j=0; $j<20; $j++) {
				if (!isset($rows[$j]['image'])) break;
				if ($i != $j) {
					if ($rows[$i]['image'] == $rows[$j]['image']) {		
						$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' and `product_image_id` = '".$rows[$j]['product_image_id']."'");
						$rows[$j]['image'] = "del";
					}
				}
			}
		}	
	}
	
	public function deleteProductWithoutAttribute($product_id) {
		$rows = $this->getAttributes($product_id);
		if (empty($rows)) $this->deleteProduct($product_id);
	
	}
	
	public function DeleteSpecialPrice($product_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . $product_id . "'");
		
	}
	
	public function findreplaceAttribute($product_id, $name, $find, $replace) {
		if (empty($find)) return;
		$rows = $this->getAttributes($product_id);
		if (empty($rows)) return;
		$finds = explode("|", $find);
		$replaces = explode("|", $replace);
		$max = count($finds);
		if (!$name) {
			foreach ($rows as $r) {				
				for ($j=0; $j<$max; $j++) {
					if (!isset($replaces[$j])) $replaces[$j] = '';
					if (substr_count($r['text'], $finds[$j])) {
						$new = str_replace($finds[$j], $replaces[$j], $r['text']);
						$lang = $this->config->get('config_language_id');
						$this->db->query("UPDATE " . DB_PREFIX . "product_attribute SET `text` = '" . $this->db->escape($new). "' WHERE `product_id` = '" . (int)$product_id . "' and `attribute_id` = '" . (int)$r['attribute_id'] . "' and `language_id` = '" . $lang . "'");
						break;
					}	
				}
			}	
		} else {
			$rows = $this->getAttributeID($name);
			if (empty($rows)) return;
			$lang = $this->config->get('config_language_id');
			$rows = $this->getAttributeById($product_id, $rows[0]['attribute_id'], $lang);
			if (empty($rows)) return;			
			for ($j=0; $j<$max; $j++) {
				if (!isset($replaces[$j])) $replaces[$j] = '';
				if (substr_count($rows[0]['text'], $finds[$j])) {
					$new = str_replace($finds[$j], $replaces[$j], $rows[0]['text']);
					$lang = $this->config->get('config_language_id');	
					$this->db->query("UPDATE " . DB_PREFIX . "product_attribute SET `text` = '" . $this->db->escape($new). "' WHERE `product_id` = '" . (int)$product_id . "' and `attribute_id` = '" . (int)$rows[0]['attribute_id'] . "' and `language_id` = '" . $lang . "'");
					break;
					
				}	
			}
		}		
	}
	
	public function shipping($product_id) {
		$this->db->query("UPDATE `" . DB_PREFIX . "product` SET `shipping` = '" . 1 . "' WHERE `product_id` = '" . (int)$product_id . "'");
	
	}
	
	public function noshipping($product_id) {
		$this->db->query("UPDATE `" . DB_PREFIX . "product` SET `shipping` = '" . 0 . "' WHERE `product_id` = '" . (int)$product_id . "'");
	
	}
	
	public function findreplaceMetaDesc($product_id, $find, $replace) {
		if (empty($find)) return;
		$rows = $this->getProductDesc($product_id);
		if (empty($rows)) return;
		if (!isset($rows[0]['meta_description'])) return;
		$finds = explode("|", $find);
		$replaces = explode("|", $replace);
		$max = count($finds);		
		$fl = 0;		
		$newmeta = $rows[0]['meta_description'];
		for ($j=0; $j<$max; $j++) {
			if (!isset($replaces[$j])) $replaces[$j] = '';			
			if (substr_count($newmeta, $finds[$j])) {
				$newmeta = str_replace($finds[$j], $replaces[$j], $newmeta);
				$fl = 1;
			}
		}
		if ($fl) {
			$lang = $this->config->get('config_language_id');
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET `meta_description` = '" . $this->db->escape($newmeta) . "' WHERE `product_id` = '" .(int)$product_id . "' and `language_id` = '" . $lang. "'");		
		}	
	}
	
	public function findreplaceH1($product_id, $find, $replace) {
		if (empty($find)) return;
		$rows = $this->getProductDesc($product_id);
		if (empty($rows)) return;
		if (!isset($rows[0]['seo_h1'])) return;
		$finds = explode("|", $find);
		$replaces = explode("|", $replace);
		$max = count($finds);		
		$fl = 0;		
		$newh1 = $rows[0]['seo_h1'];
		for ($j=0; $j<$max; $j++) {
			if (!isset($replaces[$j])) $replaces[$j] = '';
			if (substr_count($newh1, $finds[$j])) {
				$newh1 = str_replace($finds[$j], $replaces[$j], $newh1);
				$fl = 1;
			}
		}
		if ($fl) {
			$lang = $this->config->get('config_language_id');
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET `seo_h1` = '" . $this->db->escape($newh1) . "' WHERE `product_id` = '" .(int)$product_id . "' and `language_id` = '" . $lang. "'");		
		}	
	}
	
	public function findreplaceTitle($product_id, $find, $replace) {
		if (empty($find)) return;
		$rows = $this->getProductDesc($product_id);
		if (empty($rows)) return;
		if (!isset($rows[0]['seo_title'])) return;
		$finds = explode("|", $find);
		$replaces = explode("|", $replace);
		$max = count($finds);		
		$fl = 0;		
		$newtitle = $rows[0]['seo_title'];
		for ($j=0; $j<$max; $j++) {
			if (!isset($replaces[$j])) $replaces[$j] = '';
			if (substr_count($newtitle, $finds[$j])) {
				$newtitle = str_replace($finds[$j], $replaces[$j], $newtitle);
				$fl = 1;
			}
		}
		if ($fl) {
			$lang = $this->config->get('config_language_id');
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET `seo_title` = '" . $this->db->escape($newtitle) . "' WHERE `product_id` = '" .(int)$product_id . "' and `language_id` = '" . $lang. "'");		
		}	
	}
	
	public function findreplaceName($product_id, $find, $replace) {
		if (empty($find)) return;
		$rows = $this->getProductDesc($product_id);
		if (empty($rows)) return;
		$finds = explode("|", $find);
		$replaces = explode("|", $replace);
		$max = count($finds);		
		$fl = 0;
		$newname = $rows[0]['name'];
		for ($j=0; $j<$max; $j++) {
			if (!isset($replaces[$j])) $replaces[$j] = '';
			if (substr_count($newname, $finds[$j])) {
				$newname = str_replace($finds[$j], $replaces[$j], $newname);
				$fl = 1;
			}
		}
		if ($fl) {
			$lang = $this->config->get('config_language_id');
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET `name` = '" . $this->db->escape($newname) . "' WHERE `product_id` = '" .(int)$product_id . "' and `language_id` = '" . $lang. "'");		
		}	
	}
	
	public function findreplaceDescription($product_id, $find, $replace) {
		if (empty($find)) return;
		$rows = $this->getProductDesc($product_id);
		if (empty($rows)) return;
		$finds = explode("|", $find);
		$replaces = explode("|", $replace);
		$max = count($finds);		
		$fl = 0;
		$newdesc = $rows[0]['description'];
		for ($j=0; $j<$max; $j++) {
			if (!isset($replaces[$j])) $replaces[$j] = '';
			if (substr_count($newdesc, $finds[$j])) {
				$newdesc = str_replace($finds[$j], $replaces[$j], $newdesc);
				$fl = 1;
			}
		}
		if ($fl) {
			$lang = $this->config->get('config_language_id');
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET `description` = '" . $this->db->escape($newdesc) . "' WHERE `product_id` = '" .(int)$product_id . "' and `language_id` = '" . $lang. "'");				
		
		}	
	}
	
	public function shortDescription($product_id, $find, $replace) {
		if (empty($find)) return;
		$rows = $this->getProductDesc($product_id);
		if (empty($rows)) return;
		if (!preg_match('/[0-9]+$/', $find)) return;
		$st = $this->TransLit($rows[0]['description']);
		$st = strip_tags($st);	
		if (strlen($st) < $find) {
			$newdesc = '';
			$lang = $this->config->get('config_language_id');
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET `description` = '" . $newdesc . "' WHERE `product_id` = '" .(int)$product_id . "' and `language_id` = '" . $lang. "'");
		}
	}
	
	public function minimum($product_id, $find, $replace) {
		if (empty($find)) return;
		$rows = $this->getProductsByID($product_id);
		if (empty($rows)) return;
		if (!preg_match('/[0-9]+$/', $find)) return;
		$this->db->query("UPDATE " . DB_PREFIX . "product SET `minimum` = '" . $find . "' WHERE `product_id` = '" .(int)$product_id . "'");
	}
	
	public function sortPhoto($product_id) {		
		$rows = $this->getProductsByID($product_id);		
		if (!empty($rows)) {
			$p = strpos($rows[0]['model'], "-");
			$papka = substr($rows[0]['model'], $p-1, 1);
			$a = substr_count($rows[0]['image'], "/0/");
			if (!$a) $a = substr_count($rows[0]['image'], "/1/");
			if (!$a) $a = substr_count($rows[0]['image'], "/2/");
			if (!$a) $a = substr_count($rows[0]['image'], "/3/");
			if (!$a) $a = substr_count($rows[0]['image'], "/4/");
			if (!$a) $a = substr_count($rows[0]['image'], "/5/");
			if (!$a) $a = substr_count($rows[0]['image'], "/6/");
			if (!$a) $a = substr_count($rows[0]['image'], "/7/");
			if (!$a) $a = substr_count($rows[0]['image'], "/8/");
			if (!$a) $a = substr_count($rows[0]['image'], "/9/");
			if (!$a) {
				$path_old = "../image/" . $rows[0]['image'];
				$p = strrpos($rows[0]['image'], "/");
				if ($p) {
					$b = substr($rows[0]['image'], 0, $p);
					$e = substr($rows[0]['image'], $p+1);
					$addr_new = $b . "/" . $papka . "/" . $e;
					$path = "../image/" . $b . "/" . $papka . "/";
					$path_new = $path . $e;
					if (!is_dir($path)) @mkdir($path, 0755);					
					$a = copy ($path_old, $path_new);
					if ($a) {
						$this->db->query("UPDATE " . DB_PREFIX . "product SET `image` = '" . $this->db->escape($addr_new) . "' WHERE `product_id` = '" . $product_id . "'");
					} else {
						$err = " Photo: " . $path_old . " was not copied. Product_ID: " . $product_id . " \n";
						$this->adderr($err);
					}
				}	
			}
		
			$rows = $this->getProductImage($product_id);
			if (!empty($rows)) {
				for ($j=0; $j<10; $j++) {
					if (!isset($rows[$j]['image'])) break;
					$a = substr_count($rows[$j]['image'], "/0/");
					if (!$a) $a = substr_count($rows[$j]['image'], "/1/");
					if (!$a) $a = substr_count($rows[$j]['image'], "/2/");
					if (!$a) $a = substr_count($rows[$j]['image'], "/3/");
					if (!$a) $a = substr_count($rows[$j]['image'], "/4/");
					if (!$a) $a = substr_count($rows[$j]['image'], "/5/");
					if (!$a) $a = substr_count($rows[$j]['image'], "/6/");
					if (!$a) $a = substr_count($rows[$j]['image'], "/7/");
					if (!$a) $a = substr_count($rows[$j]['image'], "/8/");
					if (!$a) $a = substr_count($rows[$j]['image'], "/9/");
					if (!$a) {
						$path_old = "../image/" . $rows[$j]['image'];
						$p = strrpos($rows[$j]['image'], "/");
						if ($p) {
							$b = substr($rows[$j]['image'], 0, $p);
							$e = substr($rows[$j]['image'], $p+1);
							$addr_new = $b . "/" . $papka . "/" . $e;
							$path = "../image/" . $b . "/" . $papka . "/";
							$path_new = $path . $e;
							if (!is_dir($path)) @mkdir($path, 0755);							
							if (copy($path_old, $path_new)) {								
								$this->db->query("UPDATE " . DB_PREFIX . "product_image SET `image` = '" . $this->db->escape($addr_new) . "' WHERE `product_image_id` = '" . $rows[$j]['product_image_id'] . "'");
							} else {
								$err = " Photo: " . $path_old . " was not copied. Product_ID: " . $product_id . " \n";
								$this->adderr($err);
							}
						}	
					}
				}
			}
		}	
		return 0;
	}
	
	public function DeletePhoto($product_id) {
		$path = "../image1/";
		if (!is_dir($path)) return 29;
		$rows = $this->getProductsByID($product_id);
		if (!empty($rows)) {
			$path_old = "../image/" . $rows[0]['image'];
			$path_new = "../image1/" . $rows[0]['image'];
			$a = copy ($path_old, $path_new);
			if (!$a) {
				$err = " Photo: " . $path_old . " was not copied. Product_ID: " . $product_id . " \n";
				$this->adderr($err);				
			}
		}	
		$rows = $this->getProductImage($product_id);
		if (!empty($rows)) {
			foreach ($rows as $r) {
				$path_old = "../image/" . $r['image'];
				$path_new = "../image1/" . $r['image'];
				$a = copy ($path_old, $path_new);
				if (!$a) {
					$err = " Photo: " . $path_old . " was not copied. Product_ID: " . $product_id . " \n";
					$this->adderr($err);				
				}
			}
		}	
		return 0;
	}
	
	public function importAtt($product_id, &$masatt) {
		$lang = $this->config->get('config_language_id');
		for ($i=0; $i<2000; $i++) {
			if (!isset($masatt[$i][0])) break;
			$attribute_id = $masatt[$i][0];			
			$rows = $this->getAttributeById($product_id, $attribute_id, $lang);
			if (!empty($rows)) {
				$rows1 = $this->getAttributeName($attribute_id);
				if (!$rows1) continue;
				if (isset($masatt[$i][2]) and !empty($masatt[$i][2]) and $masatt[$i][2] != "0" and ($rows1[0]['name'] != $masatt[$i][2])) {				
					$this->db->query("UPDATE " . DB_PREFIX . "attribute_description SET `name` = '" . $this->db->escape($masatt[$i][2]) . "' WHERE `attribute_id` = '" . $attribute_id . "' and `language_id` = '" . $lang. "'");
				
					$this->cache->delete('attribute');
				}	
				for ($j=4; $j<400; $j=$j+2) {
					if (empty($masatt[$i][$j-1])) break;
					if (isset($masatt[$i][$j]) and $masatt[$i][$j] != "") {					
						if ($masatt[$i][$j] == "0") {		
							$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE text = '" . $this->db->escape($masatt[$i][$j-1]) . "' and `attribute_id` = '" . $attribute_id . "' and `language_id` = '" . $lang. "' and `product_id` = '" . $product_id. "'");
		
							$this->cache->delete('product');
						} else {
							$this->db->query("UPDATE " . DB_PREFIX . "product_attribute SET `text` = '" . $this->db->escape($masatt[$i][$j]) . "' WHERE `attribute_id` = '" . $attribute_id . "' and `language_id` = '" . $lang. "' and `product_id` = '" . $product_id. "' and `text` = '" . $this->db->escape($masatt[$i][$j-1]) ."'");
		
							$this->cache->delete('product');
						}	
					}	
				}
			}
		}	
	
	}
	
	public function exportAtt($product_id, &$masatt) {		
		$rows = $this->getAttributes($product_id);
		if (!empty($rows)) {
			foreach ($rows as $r) {				
				$f = 0;
				for ($i=0; $i<2000; $i++) {
					if (!isset($masatt[$i][0])) break;
					if ($r['attribute_id'] == $masatt[$i][0]) {
						$f = 1;
						break;
					}
				}
				if (!$f) {
					$masatt[$i][0] = $r['attribute_id'];
					$masatt[$i][1] = '';
					$rows1 = $this->getAttributeName($r['attribute_id']);
					if (!empty($rows1)) $masatt[$i][1] = $rows1[0]['name'];
				}	
				$f = 0;	
				for ($j=2; $j<201; $j++) {
					if (!isset($masatt[$i][$j])) break;
					if ($r['text'] == $masatt[$i][$j]) {
						$f = 1;
						break;
					}
				}
				if (!$f) $masatt[$i][$j] = $r['text'];
			}
		}	
	}
	
	public function Convert($product_id, $mas_con, $text) {
		$rows = $this->getProductDesc($product_id);
		if ($rows) {
			$newdesc = strtr($rows[0]['description'], $mas_con);
			$newdesc = ucfirst($newdesc);
			$j=0;
			$rep = ' ';
			while (1) {
				if (!isset($text[$j][1])) break;
				$pe = stripos($newdesc, $text[$j][1]);	
				if ($pe) {
					$a = substr($text[$j][2], 0, 80);
					if (!substr_count($rep, $a)) {
						if (substr($text[$j][2], 0, 3) == "<B>") {
							$pen = stripos($newdesc, '<p>', $pe) -1;
							if (!$pen) $pen = stripos($newdesc, '</p>', $pe) +4;
							if (!$pen) $pen = stripos($newdesc, '</ul>', $pe) +5;
							if (!$pen) $pen = stripos($newdesc, '<br />', $pe) +6;
							if (!$pen) $pen = stripos($newdesc, '&lt;p&gt;', $pe) +9;
							if (!$pen) $pen = stripos($newdesc, "&lt;/p&gt;", $pe) +10;
							if (!$pen) $pen = stripos($newdesc, "&lt;/ul&gt;", $pe) +11;
							if (!$pen) $pen = stripos($newdesc, "&lt;br /&gt;", $pe) +12;							
							
							if ($pen) {
								$newdesc = substr($newdesc, 0, $pen) . '<p>' . $text[$j][2] . '</p>'. substr($newdesc, $pen);
								$rep = $rep.substr($text[$j][2], 0, 80);
							}	
							
						} else {
							$a = substr($text[$j][2], 0, 1);
							if (preg_match('/^[A-ZА-Я ]+$/', $a) or $a == "<") {
		
								$pen = stripos($newdesc, "<", $pe);
								if (!$pen) $pen = stripos($newdesc, "&lt;", $pe);
								if (!$pen) $pen = stripos($newdesc, ". ", $pe);
								
								if ($pen) {
									$newdesc = substr($newdesc, 0, $pen) . ' ' . $text[$j][2] . substr($newdesc, $pen);
									$rep = $rep.substr($text[$j][2], 0, 80);
								}	
							} else {
		
								$pe = $pe + strlen($text[$j][1]);
								$newdesc = substr($newdesc, 0, $pe) . ' ' . $text[$j][2] . substr($newdesc, $pe);
								$rep = $rep.substr($text[$j][2], 0, 80);
							}	
						}
					}	
				}
				$j++;
			}
			$this->upDesc($newdesc, $product_id); 
		}	
		
	}
	
	public function printSkuLibrary($row) {
		$path = "./uploads/ex.xml";			
		if (!file_exists($path)) {
			$this->StartEx();			
			
			for ($j=0; $j<5; $j++) {
				$st = ' <Column ss:AutoFitWidth="0" ss:Width="100"/>'."\n";
				$this->addex($st);
			}
			$st = '<Row>'."\n";
			$this->addex($st);			
			$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Product Code</Data></Cell>'."\n";
			$this->addex($st);
			$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Main SKU</Data></Cell>'."\n";
			$this->addex($st);
			$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Alt SKU</Data></Cell>'."\n";
			$this->addex($st);
			$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Name</Data></Cell>'."\n";
			$this->addex($st);						
			$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Price</Data></Cell>'."\n";
			$this->addex($st);			
			$st = '</Row>'."\n";
			$this->addex($st);			
		} else {				
			$ex = @fopen($path,'r+');
			$st ='usergio';
			$offsetB = 0;
			$offsetE = 0;
			while (!@feof($ex)) {
				$st = @fgets($ex, 2048);
				if (substr_count($st, "<Row")) $offsetB = @ftell($ex);
				if (substr_count($st, "</Row")) $offsetE = @ftell($ex);
			}
			if ($offsetB > $offsetE) {
				$st = '</Row>'."\n";
				@fclose($ex);
				$this->addex($st);
			}				
		}
		$price = $row['price'];
		$model = $row['model'];
		$product_id = $row['product_id'];		
		$main_sku = $row['sku'];
		$row = $this->getSkuID($product_id);
		
		if (!empty($row)) {
			$fl = 0;			
			$rows = $this->getSku($row['sku_id']);				
			if (!empty($rows)) {
				foreach ($rows as $r) {				
					if ($r['sku'] != $main_sku) {
						$fl = 1;
						$alt = $r['sku'];						
					}
		
					if ($fl) {
						$fl = 0;
						$rows1 = $this->getProductDesc($product_id);
						if (!empty($rows1)) $name = $rows1[0]['name'];				
						$st = '<Row>'."\n";
						$this->addex($st);
						$st = $model;
						$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
						$this->addex($st);
						$st = $main_sku;
						$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
						$this->addex($st);
						$st = $alt;
						$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
						$this->addex($st);
						$st = $name;
						$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
						$this->addex($st);
						$st = $price;
						$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
						$this->addex($st);
						$st = '</Row>'."\n";
						$this->addex($st);
					}	
				}	
			}
		}
	}
	
	public function addPrefix($row, $prefix, $infix) {	
		$sku = $row['sku'];
		if (empty($sku)) return;
		$a = 1;
		$b = 1;
		$new_sku = '';
		if (!empty($prefix)) $a = substr_count($sku, $prefix);
		if (!empty($infix)) $b = substr_count($sku, $infix);
		if (!$a and !$b) $new_sku = $prefix . $sku . $infix;
		if (!$b and $a) $new_sku = $sku . $infix;
		if ($b and !$a) $new_sku = $prefix . $sku;
		if (!empty($new_sku)) {
			$this->db->query("UPDATE `" . DB_PREFIX . "product` SET `sku` = '" . $this->db->escape($new_sku) . "' WHERE `product_id` = '" . $row['product_id'] . "'");

			$rows = $this->getAllRecordsLibrary($sku);
			if (!empty($rows)) {
				foreach ($rows as $r) {	
					if ($r['sku'] == $sku) {
						$this->db->query("UPDATE `" . DB_PREFIX . "suppler_sku_description` SET `sku` = '" . $this->db->escape($new_sku) . "' WHERE `nom_id` = '" . $r['nom_id'] . "'");
					}
				}
			}
		}	
	}
	
	public function putsos($row_count) {
		$file_sos    = "./uploads/sos.tmp";
		
		$sos = @fopen($file_sos,'r+');
		if (!$sos) { $row_count = -5; return $row_count; }
		else {			
			fseek($sos, 0);
			$row_count_old = fgets($sos, 10);
			$row_count_old = $row_count_old +0;
				
			if (empty($row_count_old)) $row_count_old = -1;	
			if ($row_count_old > $row_count) {
				fclose($sos); 
				unlink ($file_sos);
				$row_count = -5; 
				return $row_count; 
			}
			fseek($sos, 0);	
			if (!@fputs($sos, (int)$row_count)) {
				fclose($sos); 
				unlink ($file_sos);
				$row_count = -5; 
				return $row_count; 
			}
			fclose($sos);		
			$row_count = $row_count + 1;
			return $row_count;
		}
	}
	
	public function addReport($report, $row, $sku) {
		$file_rep    = "./uploads/report.tmp";
		$rep = @fopen($file_rep,'a');
		if (!$rep) $rep = @fopen($file_rep,'w+');
		$line =  " Row =~ ".$row." SKU = ".$sku." ".$report. "\n";
		@fputs($rep, $line);
		@fclose($rep);	
	}
	
	public function adderr($err) {
		$file_er    = "./uploads/errors.tmp";
		$er = @fopen($file_er,'a');
		if (!$er) $er = @fopen($file_er,'w+');
		@fputs($er, $err);
		@fclose($er);	
	}
	
	public function addex($st) {
		$file_ex    = "./uploads/ex.xml";		
		$ex = @fopen($file_ex,'a');
		if (!$ex) $ex = @fopen($file_ex,'w+');			
		if (!$ex) return 3;
		@fputs($ex, $st);
		@fclose($ex);		
	}
			
	public function checkurl($url) {	
		$url=trim($url);
		if (strlen($url) < 4) return -1;
		if (!substr_count($url, "http://") and !substr_count($url, "/")) return -1;
		$url = str_replace("\/" , "/" , $url);
		$url = str_replace("\\" , "/" , $url);		
		if (!strstr($url,"://")) $url = "http://".$url;
		$url = str_replace("&#45;", "-", $url);
		$url = str_replace("&amp;", "&", $url);
	
		return $url;
	}
	
	public function StartEx() {
		$st = '<?xml version="1.0"?>'."\n";
		$this->addex($st);
		$st = '<?mso-application progid="Excel.Sheet"?>'."\n";
		$this->addex($st);
		$st = '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"'."\n";
		$this->addex($st);
		$st = 'xmlns:o="urn:schemas-microsoft-com:office:office"'."\n";
		$this->addex($st);
		$st = 'xmlns:x="urn:schemas-microsoft-com:office:excel"'."\n";
		$this->addex($st);
		$st = 'xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"'."\n";
		$this->addex($st);
		$st = 'xmlns:html="http://www.w3.org/TR/REC-html40">'."\n";
		$this->addex($st);
		$st = '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">'."\n";
		$this->addex($st);
		$st = ' <Author>usergio</Author>'."\n";
		$this->addex($st);
		$st = ' <LastAuthor>me</LastAuthor>'."\n";
		$this->addex($st);
		$st = ' <Created>'.date('Y-m-d H:i:s').'</Created>'."\n";
		$this->addex($st);
		$st = ' <LastSaved>'.date('Y-m-d H:i:s').'</LastSaved>'."\n";
		$this->addex($st);
		$st = ' <Company>'.HTTP_CATALOG.'</Company>'."\n";
		$this->addex($st);
		$st = ' <Version>12.00</Version>'."\n";
		$this->addex($st);
		$st = '</DocumentProperties>'."\n";
		$this->addex($st);
		$st = '<ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">'."\n";
		$this->addex($st);
		$st = ' <WindowHeight>12396</WindowHeight>'."\n";
		$this->addex($st);
		$st = ' <WindowWidth>23256</WindowWidth>'."\n";
		$this->addex($st);				
		$st = ' <WindowTopX>180</WindowTopX>'."\n";
		$this->addex($st);
		$st = ' <WindowTopY>456</WindowTopY>'."\n";
		$this->addex($st);
		$st = ' <ProtectStructure>False</ProtectStructure>'."\n";
		$this->addex($st);
		$st = ' <ProtectWindows>False</ProtectWindows>'."\n";
		$this->addex($st);
		$st = '</ExcelWorkbook>'."\n";
		$this->addex($st);
		$st = '<Styles>'."\n";
		$this->addex($st);
		$st = ' <Style ss:ID="Default" ss:Name="Normal">'."\n";
		$this->addex($st);
		$st = ' <Alignment ss:Vertical="Bottom"/>'."\n";
		$this->addex($st);
		$st = ' <Borders/>'."\n";
		$this->addex($st);
		$st = ' <Font ss:FontName="Calibri" ss:Size="11"/>'."\n";
		$this->addex($st);
		$st = ' <Interior/>'."\n";
		$this->addex($st);				
		$st = ' <NumberFormat/>'."\n";
		$this->addex($st);
		$st = ' <Protection/>'."\n";
		$this->addex($st);
		$st = '</Style>'."\n";
		$this->addex($st);
		$st = '<Style ss:ID="s16">'."\n";
		$this->addex($st);
		$st = ' <NumberFormat ss:Format="Fixed"/>'."\n";
		$this->addex($st);
		$st = '</Style>'."\n";
		$this->addex($st);
		$st = '<Style ss:ID="s17">'."\n";
		$this->addex($st);
		$st = ' <NumberFormat ss:Format="0"/>'."\n";
		$this->addex($st);
		$st = '</Style>'."\n";
		$this->addex($st);
		$st = '<Style ss:ID="s18">'."\n";
		$this->addex($st);
		$st = ' <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="11"/>'."\n";
		$this->addex($st);
		$st = '</Style>'."\n";
		$this->addex($st);
		$st = '<Style ss:ID="s19">'."\n";
		$this->addex($st);
		$st = ' <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="11"/>'."\n";
		$this->addex($st);
		$st = ' <NumberFormat ss:Format="0"/>'."\n";
		$this->addex($st);
		$st = '</Style>'."\n";
		$this->addex($st);
		$st = '<Style ss:ID="s20">'."\n";
		$this->addex($st);
		$st = '<Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>'."\n";
		$this->addex($st);
		$st = '<Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="11" ss:Bold="1"/>'."\n";
		$this->addex($st);		
		$st = '</Style>'."\n";
		$this->addex($st);
		$st = '<Style ss:ID="s21">'."\n";
		$this->addex($st);   
		$st = ' <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="11"/>'."\n";
		$this->addex($st);
		$st = ' <NumberFormat ss:Format="0.0000"/>'."\n";
		$this->addex($st);
		$st = '</Style>'."\n";
		$this->addex($st);
		$st = '<Style ss:ID="s22">'."\n";
		$this->addex($st);
		$st = ' <NumberFormat ss:Format="0.0000"/>'."\n";
		$this->addex($st);
		$st = '</Style>'."\n";
		$this->addex($st);
		$st = '<Style ss:ID="s23">'."\n";
		$this->addex($st);
		$st = ' <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="11"/>'."\n";
		$this->addex($st);
		$st = ' <NumberFormat/>'."\n";
		$this->addex($st);
		$st = '</Style>'."\n";
		$this->addex($st);
		$st = '<Style ss:ID="s24">'."\n";
		$this->addex($st);
		$st = ' <NumberFormat/>'."\n";
		$this->addex($st);
		$st = '</Style>'."\n";
		$this->addex($st);
		$st = '<Style ss:ID="s25">'."\n";
		$this->addex($st);
		$st = ' <NumberFormat ss:Format="Standard"/>'."\n";
		$this->addex($st);
		$st = '</Style>'."\n";
		$this->addex($st);
		$st = '</Styles>'."\n";
		$this->addex($st);
		$st = '<Worksheet ss:Name="ERC price">'."\n";
		$this->addex($st);
		$st = '<Table ss:ExpandedColumnCount="47" ss:ExpandedRowCount="1" x:FullColumns="1"'."\n";
		$this->addex($st);
		$st = '           x:FullRows="1" ss:DefaultRowHeight="14">'."\n";
		$this->addex($st);	
	}
	
	public function EndEx($kol_cell) {
		$file_ex  = "./uploads/ex.xml";		
		$ex = @fopen($file_ex,'r');
		$st ='usergio';
		$kol_row = 0;
		while (!@feof($ex)) {
				$st = @fgets($ex, 2048);
				if (substr_count($st, "<Row")) $kol_row++;
			}
		fclose($ex);
		
		$ex = @fopen($file_ex,'r+');
		$st ='usergio';
		while (!@feof($ex) and !substr_count($st, "<Worksheet ss:Name=")) {
				$st = @fgets($ex, 2048);
			}			
		
		if ($kol_row < 1) $kol_row = 1;
		$st = '<Table ss:ExpandedColumnCount="'.$kol_cell.'" ss:ExpandedRowCount="'.$kol_row.'" x:FullColumns="1"'."\n";
		$ste = $st;
		@fputs($ex, $st);
		@fclose($ex);	
		
		$st = '</Table>'."\n";
		$this->addex($st);
		$st = '<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">'."\n";
		$this->addex($st);
		$st = '<PageSetup>'."\n";
		$this->addex($st);
		$st = '<Header x:Margin="0.3"/>'."\n";
		$this->addex($st);
		$st = '<Footer x:Margin="0.3"/>'."\n";
		$this->addex($st);
		$st = '<PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>'."\n";
		$this->addex($st);
		$st = '</PageSetup>'."\n";
		$this->addex($st);
		$st = '<Print>'."\n";
		$this->addex($st);
		$st = '<ValidPrinterInfo/>'."\n";
		$this->addex($st);
		$st = '<PaperSizeIndex>9</PaperSizeIndex>'."\n";
		$this->addex($st);
		$st = '<HorizontalResolution>600</HorizontalResolution>'."\n";
		$this->addex($st);
		$st = '<VerticalResolution>600</VerticalResolution>'."\n";
		$this->addex($st);
		$st = '</Print>'."\n";
		$this->addex($st);
		$st = '<Selected/>'."\n";
		$this->addex($st);
		$st = '<Panes>'."\n";
		$this->addex($st);
		$st = '<Pane>'."\n";
		$this->addex($st);
		$st = '<Number>3</Number>'."\n";
		$this->addex($st);
		$st = '<ActiveCol>26</ActiveCol>'."\n";
		$this->addex($st);
		$st = '<RangeSelection>R1C27:R22C36</RangeSelection>'."\n";
		$this->addex($st);
		$st = '</Pane>'."\n";
		$this->addex($st);
		$st = '</Panes>'."\n";
		$this->addex($st);
		$st = '<ProtectObjects>False</ProtectObjects>'."\n";
		$this->addex($st);
		$st = '<ProtectScenarios>False</ProtectScenarios>'."\n";
		$this->addex($st);
		$st = '</WorksheetOptions>'."\n";
		$this->addex($st);
		$st = '</Worksheet>'."\n";
		$this->addex($st);
		$st = '<Worksheet ss:Name="Лист1">'."\n";
		$this->addex($st);
		$st = $ste;
		$this->addex($st);
		$st = 'x:FullRows="1" ss:DefaultRowHeight="14.4">'."\n";
		$this->addex($st);
		$st = '</Table>'."\n";
		$this->addex($st);
		$st = '<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">'."\n";
		$this->addex($st);
		$st = '<PageSetup>'."\n";
		$this->addex($st);
		$st = '<Header x:Margin="0.3"/>'."\n";
		$this->addex($st);
		$st = '<Footer x:Margin="0.3"/>'."\n";
		$this->addex($st);
		$st = '<PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>'."\n";
		$this->addex($st);  
		$st = '</PageSetup>'."\n";
		$this->addex($st);
		$st = '<ProtectObjects>False</ProtectObjects>'."\n";
		$this->addex($st);
		$st = '<ProtectScenarios>False</ProtectScenarios>'."\n";
		$this->addex($st);
		$st = '</WorksheetOptions>'."\n";
		$this->addex($st);
		$st = '</Worksheet>'."\n";
		$this->addex($st);
		$st = '</Workbook>'."\n";
		$this->addex($st);	
	}
	
	public function PrintSame($model, $sku1, $sku2, $name1, $name2, $price1, $price2) {
					
		$st = '<Row>'."\n";
		$this->addex($st);
		$st = $model;
		$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
		$this->addex($st);
		$st = $sku1;
		$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
		$this->addex($st);
		$st = $sku2;
		$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
		$this->addex($st);
		$st = $name1;
		$st = strip_tags($st, '<p><em><i><br><li><ul><i><b><strong>');
		$st = htmlspecialchars($st);				
		$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
		$this->addex($st);			
		$st = $name2;
		$st = strip_tags($st, '<p><em><i><br><li><ul><i><b><strong>');
		$st = htmlspecialchars($st);				
		$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
		$this->addex($st);				
		$st = $price1;
		$st = '<Cell ss:StyleID="s22"><Data ss:Type="Number">'.$st.'</Data></Cell>'."\n";
		$this->addex($st);
		$st = $price2;
		$st = '<Cell ss:StyleID="s22"><Data ss:Type="Number">'.$st.'</Data></Cell>'."\n";
		$this->addex($st);
		$st = '</Row>'."\n";
		$this->addex($st);	
	}
	
	public function Same($sku, $name, $category_id, $manufacturer_id, $price2) {	
		
		if (empty($name) and empty($sku)) return "";
		if (empty($category_id)) $category_id = 0;
		
		$name2 = str_replace("-", " ", $name);
		$name2 = str_replace("/", " ", $name2);
		$name2 = str_replace("III", "3", $name2);
		$name2 = str_replace("II", "2", $name2);		
		$name2 = str_replace("V", "5", $name2);
		$name2 = str_replace("IV", "4", $name2);
		$name2 = str_replace("(", "", $name2);
		$name2 = str_replace(")", "", $name2);
		$name2 = strtolower($name2);
		$ms2 = explode (" ", $name2);		
		
		$rows = $this->getSame($manufacturer_id, $category_id);	
		
		if (empty($rows)) return "";
		
		foreach ($rows as $r) {			
			$name1 = $r['name'];
			$model = $r['model'];
			$sku1 = $r['sku'];
			$price1 = $r['price'];
			$r['name'] = str_replace("-", " ", $r['name']);
			$r['name'] = str_replace("/", " ", $r['name']);
			$r['name'] = str_replace("III", "3", $r['name']);
			$r['name'] = str_replace("II", "2", $r['name']);			
			$r['name'] = str_replace("V", "5", $r['name']);
			$r['name'] = str_replace("IV", "4", $r['name']);
			$r['name'] = str_replace("(", "", $r['name']);
			$r['name'] = str_replace(")", "", $r['name']);
			$r['name'] = strtolower($r['name']);
			$ms1 = explode (" ", $r['name']);
			$equal = 0;
			$max1 = count($ms1);
			$max2 = count($ms2);			
			for ($i=0; $i<$max1; $i++) {				
				for ($j=0; $j<$max2; $j++) {
					if (strlen($ms1[$i]) < 2) continue;
					if (strlen($ms2[$j]) < 2) continue;
					$p = stripos($ms1[$i], $ms2[$j]);
					if ($p === false) $p = stripos($ms2[$j], $ms1[$i]);
					if (!($p === false)) $equal++;	
				}
			}
			
			preg_match( '%(\d+)%', $name, $a);
			preg_match( '%(\d+)%', $name1, $b);
			$yes = 0;
			if (isset($a[1]) and isset($b[1])) {
				 if ($a[1] == $b[1]) $yes = 1;
			}		
			
			$max = $max1;			
			if ($max < $max2) $max = $max2;									
			$c = $equal/$max + 0.00000001;
			if ($c > 0.49 and $yes and $sku != $sku1) $this->PrintSame($model, $sku1, $sku, $name1, $name, $price1, $price2);
			   
		}	
	}

	public function Action($data, $id) {
			
		if ($data['command'] == 31) {
			$this->FixURLcategory();
			return 0;
		}
		if ($data['command'] == 32) {
			$this->FixURLmanufacturer();
			return 0;
		}
		
		$data['act_mult'] = str_replace(',', '.', $data['act_mult']);		
		$table_sku = "";
		$table_sku = $this->getTable();
		$lang = $this->config->get('config_language_id');

		$path = "./uploads/";		
		if (!is_dir($path)) return 30;
		
		$rows = $this->getMySuppler($id);
		if (empty($rows)) return;
		$id	= $rows[0]['suppler_id'];
		
		if ($data['command'] == 14) {
	
			$row = $this->getMaxAttributeID();
			$max = $row['max(attribute_id)'];
			
			$file_table = "./uploads/attribute.tmp";
			$file_sos    = "./uploads/sos.tmp"; 
			if (!file_exists ($file_sos)) {
						
				if (file_exists($file_table)) @unlink ($file_table);				
				
				$i = 1;
				for ($k=1; $k<=$max; $k++) {
					$rows = $this->getAttributeName($k);
					if (!empty($rows)) {					
						$rows = $this->getAttributeID($rows[0]['name']);	
						$j=0;
						foreach ($rows as $r) {
							$table[$i][$j] = $r['attribute_id'];
							$j++;
						}
						$i++;	
					}
				}				
				
				$tab = fopen($file_table,'w+b');
				$str_table = serialize($table);
				if (fwrite($tab, $str_table) === false) {
					@fclose($tab);
					return 26;
				}	
				@fclose($tab);

				$sos = fopen($file_sos,'w+');
				if (!$sos) { @fclose($sos); return 2;}
				@fclose($sos);
				$pid = 0;				
				
			} else {			
				$sos = fopen($file_sos,'r+');
				$pid = (int)fgets($sos, 10);
				if (empty($pid)) $pid = 0;
				@fclose($sos);
				
				$tab = fopen($file_table,'rb');
				if(!$tab) return 27;
				$table = unserialize(fread($tab, filesize($file_table)));	
				if (empty($table)) return 26;
			}	
			
			$row = $this->getMaxID();
			$max_id = $row['max(product_id)'];
		
			for ($k=$pid; $k<=$max_id; $k++) {
				$row  = $this->getProductByID($k);
				if (empty($row)) continue;
					
				$e = $this->putsos($k);
				if ($e < 0) return 2;	
				
				$rows = $this->getAttributes($row['product_id']);
				foreach ($rows as $r){			
					for ($i=1; $i<=$max; $i++) {
						for ($j=0; $j<60; $j++) {
							if (!isset($table[$i][$j])) break; 
							if ($r['attribute_id'] == $table[$i][$j]) {						
								if ($table[$i][0] != $r['attribute_id']) {
									$this->changeAttributeId($row['product_id'], $table[$i][0], $r['attribute_id'], $r['text']);				
									break;
								}
							}
						}	
					}	
				}				
			}
			
			
			if (file_exists($file_table)) unlink ($file_table);
			if (file_exists($file_sos)) unlink ($file_sos);
			return 0;	
		}
		
		if ($data['command'] == 15) {
		
			$file_con  = "./uploads/conv.xml"; 
			$con = @fopen($file_con,'r');			
			if (!$con) return 25;
						
			$st = '';
			$j = 0;
			$text = array();	
			$mas_con = array();	
			while (!feof($con)) {		
				while (!@feof($con) and !substr_count($st, "<Row")){
					$st = @fgets($con, 4096);
				}	
				if (@feof($con)) break;						
					
				for ($i=1; $i<4; $i++) {
					$m = '';
					while (1) {						
						$st = @fgets($con, 4096);
						$m = $m.$st;
						if (@feof($con)) break;				
						if (substr_count($st, "</Row>"))  break;		
						if (substr_count($st, "<Cell") and substr_count($st, "</Cell")) break;	
											
						$st = @fgets($con, 4096);
						$m = $m.$st;
						if (@feof($con)) break;				
						if (substr_count($st, "</Row>"))  break;
						if (substr_count($st, "</Cell"))  break;
					}
					$posb = stripos($m, "String");	
					
					if (!$posb) break;
					$posb = $posb;
					$posb = stripos($m, ">", $posb)+1;
					$pose = stripos($m, "</Data", $posb);
					if (!$pose) $pose = stripos($m, "</ss:Data", $posb);
		
					if ($pose > $posb) {						
						$len = $pose - $posb;
						$m = substr($m, $posb, $len);
						if ($i < 3) $mas[$i] = $m;
						if ($i == 2) $mas_con[$mas[1]] = $mas[2];
						if ($i == 3) {
							$m = str_replace("&gt;", '>', $m);	
							$m = str_replace("&lt;", '<', $m);
							$m = str_replace("&quot;", '"', $m);
							$m = str_replace("&amp;nbsp;", " ", $m);
							$m = str_replace("&amp;quot;", '"', $m);	
							$m = str_replace("html:", "", $m);						
							$m = str_replace("&#10;", "<br />", $m);
							$m = str_replace("&amp;#xD;&amp;#xA;", "<br />", $m);
							$m = str_replace("&#xD;&#xA;", "<br />", $m);		
							$m = str_replace('Size="8"', 'size="0"', $m);
							$m = str_replace('Size="9"', 'size="0"', $m);
							$m = str_replace('Size="10"', 'size="2"', $m);
							$m = str_replace('Size="11"', 'size="3"', $m);
							$m = str_replace('Size="12"', 'size="3"', $m);
							$text[$j][1] = $mas[2];
							$text[$j][2] = $m;
							$j++;
			
						}			
					} 
				}			
			}
			@fclose($con);	
		}
			
		$file_sos    = "./uploads/sos.tmp"; 
		if (!file_exists ($file_sos)) {
		
			$path = "./uploads/report.tmp";
			if (file_exists($path)) @unlink ($path);
		
			$path = "./uploads/errors.tmp";
			if (file_exists($path)) @unlink ($path);
			
			$path = "./uploads/ex.xml";
			if (file_exists($path) and $data['command'] != 26) @unlink ($path);
		}

		$masatt = array();
		
		if ($data['command'] == 30) {			
			$path = "./uploads/ex.xml";			
			if (!file_exists($path)) {
				$this->StartEx();			
			
				for ($j=0; $j<7; $j++) {
					$st = ' <Column ss:AutoFitWidth="0" ss:Width="100"/>'."\n";
					$this->addex($st);
				}
				$st = '<Row>'."\n";
				$this->addex($st);			
				$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Product in Store</Data></Cell>'."\n";
				$this->addex($st);
				$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Main SKU in Store</Data></Cell>'."\n";
				$this->addex($st);
				$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">SKU in Price-list</Data></Cell>'."\n";
				$this->addex($st);
				$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Name in Store</Data></Cell>'."\n";
				$this->addex($st);			
				$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Name in Price-list</Data></Cell>'."\n";
				$this->addex($st);			
				$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Price in Store</Data></Cell>'."\n";
				$this->addex($st);
				$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Price in Price-list</Data></Cell>'."\n";
				$this->addex($st);
				$st = '</Row>'."\n";
				$this->addex($st);			
			} else {				
				$ex = @fopen($path,'r+');
				$st ='usergio';
				$offsetB = 0;
				$offsetE = 0;
				while (!@feof($ex)) {
					$st = @fgets($ex, 2048);
					if (substr_count($st, "<Row")) $offsetB = @ftell($ex);
					if (substr_count($st, "</Row")) $offsetE = @ftell($ex);
				}
				if ($offsetB > $offsetE) {
					$st = '</Row>'."\n";
					@fclose($ex);
					$this->addex($st);
				}				
			}	
		}

		if 	($data['command'] == 26) {
			$file_ex  = "./uploads/ex.xml";
			if (!file_exists($file_ex)) return 3;
			$ex = @fopen($file_ex,'r');			
			if (!$ex) return 3;		
		
			$st = '';
			while (!@feof($ex) and !substr_count($st, "</Row")) {
				$st = @fgets($ex, 4096);
			}
			$k = -1;
			while (!feof($ex)) {
				$k++;
				while (!@feof($ex) and !substr_count($st, "<Row")) {
					$st = @fgets($ex, 4096);
				}	
				if (@feof($ex)) break;

				for ($j=1; $j<500; $j++) { $row[$j] = NULL;}	
				$i = -1;
				$br = 0;
				$ext = 1;			
				while ($ext) {			
					$st = @fgets($ex, 4096);
					if (@feof($ex)) break;				
					if (substr_count($st, "</Row>"))  break;
								
					if (!substr_count($st, "<Cell")) {
				
						if (substr_count($st, "</Data")) $pose = strpos($st, "</Data"); 
							else if (substr_count($st, "</ss:Data")) $pose = strpos($st, "</ss:Data"); 
									else $pose = strlen($st) - 1;
						if ($pose and $br) $row[$i] = $row[$i].preg_replace('| +|', ' ', substr($st, 0, $pose));					
						continue;
					
					} else {					
						$p = strpos($st, "Index=");
						if ($p != 0) {
							$pe = strpos($st, '"', $p+7);
							$i = substr ($st, $p+7, $pe-$p-7) + 0;
						} else $i ++;
					
						$br = 0;
						$a = ">";
						$posb1 = strpos($st, "String");
						if ($posb1 === false) $posb1 = 999;
						$posb2 = strpos($st, "Number");
						if ($posb2 === false) $posb2 = 999;
						$posb3 = strpos($st, "HRef=");
						if ($posb3 === false) $posb3 = 999;
						if ($posb1 < $posb2) $posb = $posb1;
						else $posb = $posb2;
						if ($posb3 < $posb) {
							$posb = $posb3;
							$a = '"';						
						}		
						if ($posb != 999)	{					
							$posb = strpos($st, $a , $posb) +1;
							if ($posb < 0) continue;
							$pose = 0;
							if ($a != '"') {						
								if (substr_count($st, "</Data")) $pose = strpos($st, "</Data", $posb); 
								else if (substr_count($st, "</ss:Data")) $pose = strpos($st, "</ss:Data", $posb); 
							} else $pose = strpos($st, $a, $posb); 
							if (!$pose) {
								$br = 1;
								$row[$i] = substr($st, $posb);
								continue;
							}	
							if ($pose and $pose > $posb) {						
								$len = $pose - $posb;
								$row[$i] = substr($st, $posb, $len);		
							} 
						} else continue;
					}
					$masatt[$k][$i] = $row[$i];
				}		
			}	
		}	
		
		if 	($data['command'] == 25) {
	//		if (empty($data['act_cat'])) return 28;
			
			$path = "./uploads/ex.xml";
			if (!file_exists($path)) {
				$this->StartEx();				

				for ($j=0; $j<403; $j++) {
					$st = ' <Column ss:AutoFitWidth="0" ss:Width="82"/>'."\n";
					$this->addex($st);
				}
				
				$st = '<Row>'."\n";
				$this->addex($st);
				$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Attribute ID</Data></Cell>'."\n";
				$this->addex($st);
				$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Attribute Name</Data></Cell>'."\n";
				$this->addex($st);
				$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">New Name</Data></Cell>'."\n";
				$this->addex($st);
			
				for ($j=0; $j<200; $j++) {
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Attribute Value</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">New Value</Data></Cell>'."\n";
					$this->addex($st);
				}		

				$st = '</Row>'."\n";
				$this->addex($st);
			
			} else {
				$ex = @fopen($path,'r+');
				$st ='usergio';
				$offsetB = 0;
				$offsetE = 0;
				while (!@feof($ex)) {
					$st = @fgets($ex, 2048);
					if (substr_count($st, "<Row")) $offsetB = @ftell($ex);
					if (substr_count($st, "</Row")) $offsetE = @ftell($ex);
				}
				if ($offsetB > $offsetE) {
					$st = '</Row>'."\n";
					@fclose($ex);
					$this->addex($st);
				}
			}
		}
				
		if 	($data['command'] == 12) {
				$rows = $this->getMySuppler($id);
		//		$np = substr_count($rows[0]['pic_ext'], ",");				
		//		$ns = substr_count($rows[0]['warranty'], ",");				
		//		$nf = $np+$ns;
				$nf = 5;
				$max_a = 80;
				$max_att = $max_a/2;
				
				$rows = $this->getOptions();
				$max_options = 0;				
				foreach ($rows as $value) {
					$max_options++;
					$allOptions[$max_options] = $value['option_id'];
					}
				$max_opt5 = $max_options*5;
				
				$path = "./uploads/ex.xml";
				if (!file_exists($path)) {
					$this->StartEx();				
				
					for ($j=1; $j<12; $j++) {
						$st = ' <Column ss:AutoFitWidth="0" ss:Width="100"/>'."\n";
						$this->addex($st);
					}
				
					$st = ' <Column ss:StyleID="s16" ss:AutoFitWidth="0" ss:Width="100"/>'."\n";
					$this->addex($st);				
				
					for ($j=1; $j<=$nf; $j++) {
						$st = ' <Column ss:StyleID="s16" ss:AutoFitWidth="0" ss:Width="100"/>'."\n";
						$this->addex($st);
					}				
				
					for ($j=1; $j<12; $j++) {
						$st = ' <Column ss:StyleID="s16" ss:AutoFitWidth="0" ss:Width="100"/>'."\n";
						$this->addex($st);
					}
					
					for ($j=1; $j<9; $j++) {
						$st = ' <Column ss:StyleID="s16" ss:AutoFitWidth="0" ss:Width="82"/>'."\n";
						$this->addex($st);
					}
					
					$rows = $this->getOptions();
					$max_options = 0;				
					foreach ($rows as $value) {
						$max_options++;
						$allOptions[$max_options] = $value['option_id'];
						$st = ' <Column ss:StyleID="s16" ss:AutoFitWidth="0" ss:Width="82"/>'."\n";
						$this->addex($st);
					}
						
					for ($j=1; $j<=$max_a; $j++) {
						$st = ' <Column ss:StyleID="s16" ss:AutoFitWidth="0" ss:Width="82"/>'."\n";
						$this->addex($st);
					}
				
					$st = '<Row>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Main SKU</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Name</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Category</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Parent Category</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Parent Category</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Parent Category</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Parent Category</Data></Cell>'."\n";
					$this->addex($st);					
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Quantity</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Price</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Special Price</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Description</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Main photo</Data></Cell>'."\n";
					$this->addex($st);
				
					
					for ($j=1; $j<=$nf; $j++) {
						$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Photo'.$j.'</Data></Cell>'."\n";
						$this->addex($st);
					}
				
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Manufacturer</Data></Cell>'."\n";
					$this->addex($st);				
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Weight</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Length</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Width</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Height</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">HTML-tag H1</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">HTML-tag Title</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Meta-tag Keywords</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Meta-tag Description</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Tags</Data></Cell>'."\n";
					$this->addex($st);	
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">URL</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Photo for category</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Photo for Parentcategory</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Photo for Parentcategory</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Photo for Parentcategory</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Photo for Parentcategory</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Discount1</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Discount2</Data></Cell>'."\n";
					$this->addex($st);
					$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Discount3</Data></Cell>'."\n";
					$this->addex($st);
				
					$max_opt5 = $max_options*5;
					for ($j=1; $j<=$max_options; $j++) {					
						$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">OPTION'.$j.'-&gt;</Data></Cell>'."\n";
						$this->addex($st);
						$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Quantity'.$j.'</Data></Cell>'."\n";
						$this->addex($st);
						$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Add to price'.$j.'</Data></Cell>'."\n";
						$this->addex($st);
						$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Points'.$j.'</Data></Cell>'."\n";
						$this->addex($st);
						$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Weight'.$j.'</Data></Cell>'."\n";
						$this->addex($st);
					}				
				
					$max_att = $max_a/2;
				
					for ($j=1; $j<=$max_att; $j++) {
						$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Attribute Name</Data></Cell>'."\n";
						$this->addex($st);
						$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Attribute Value</Data></Cell>'."\n";
						$this->addex($st);
					}
				
					$st = '</Row>'."\n";
					$this->addex($st);
				} else {
					$ex = @fopen($path,'r+');
					$st ='usergio';
					$offsetB = 0;
					$offsetE = 0;
					while (!@feof($ex)) {
						$st = @fgets($ex, 2048);
						if (substr_count($st, "<Row")) $offsetB = @ftell($ex);
						if (substr_count($st, "</Row")) $offsetE = @ftell($ex);
					}
					if ($offsetB > $offsetE) {
						$st = '</Row>'."\n";
						@fclose($ex);
						$this->addex($st);
					}
				}
		}	

		if (file_exists ($file_sos)) {
			$sos = @fopen($file_sos,'r+');
			$pid = (int)fgets($sos, 10);
			if (empty($pid)) $pid = 0;
			@fclose($sos);
		} else {
			$sos = @fopen($file_sos,'w+');
			if (!$sos) { @fclose($sos); return 2;}
			$pid = 0;		
		}		
	
		$pid++;	
		
		$row = $this->getMaxID();
		$max_id = $row['max(product_id)'];
		
		for ($i=$pid; $i<=$max_id; $i++) {
			$row  = $this->getProductByID($i);
			if (!isset($row['model'])) continue;
			
			$p = strpos($row['model'], "-");
			if (preg_match('/^[0-9-]+$/', $row['model']) and $p > 0) {				
				$sup = substr($row['model'], $p+1, 2);
				$number = substr($row['model'], 0, $p);				
				if (!empty ($data['cod_from']) and (int)$data['cod_from'] > (int)$number) continue;
				if (!empty ($data['cod_to']) and (int)$data['cod_to'] < (int)$number) continue;
				if ((int)$data['all'] == 0 and $id != (int)$sup) continue;				
			} else { 
				if ((int)$data['all'] == 0) continue;
				if (!empty ($data['cod_from']) or !empty ($data['cod_to'])) continue;				
			}			
	
			if (!isset($row) or !isset($row['date_modified']) or !isset($row['price']) or 
				!isset($row['stock_status_id']) or !isset($row['quantity']) or !isset($row['manufacturer_id']) or 
				!isset($row['status'])) continue;			
			
			if (!empty($data['act_cat'])) {			
				$rows = $this->getProductCategory($row['product_id']);				
				
				$j = 0;
				foreach ($rows as $cat) {
					if ($cat['category_id'] == (int)$data['act_cat']) {
						$j++;
						break;
					}	
				}				
				if ($j == 0) continue;
			}
			
			if (!empty($data['act_manuf']) and ((int)$row['manufacturer_id'] != (int)$data['act_manuf'])) continue;	
	
			$y1 = (int)substr($data['filter_date_start'], 0, 4);
			$m1 = (int)substr($data['filter_date_start'], 5, 2);
			$d1 = (int)substr($data['filter_date_start'], 8, 2);
			$y2 = (int)substr($data['filter_date_end'], 0, 4);
			$m2 = (int)substr($data['filter_date_end'], 5, 2);
			$d2 = (int)substr($data['filter_date_end'], 8, 2);
			$y = (int)substr($row['date_modified'], 0, 4);
			$m = (int)substr($row['date_modified'], 5, 2);
			$d = (int)substr($row['date_modified'], 8, 2);
			$t1 = mktime(0, 0, 0, $m1, $d1, $y1);
			$t2 = mktime(0, 0, 0, $m2, $d2, $y2);
			$t = mktime(0, 0, 0, $m, $d, $y);	
		
			if (($t<$t1 or $t>$t2) and ($data['filter_date_start'] != '0000-00-00' or $data['filter_date_end'] != '0000-00-00')) continue;
  
			if ($data['isno'] == 1 and $row['quantity'] > 0) continue;
			
			if ($data['offproduct'] == 1 and $row['status'] == 0) continue;
			if ($data['offproduct'] == 2 and $row['status'] == 1) continue;
			
			if ($data['act_attribut'] and !$data['act_noattribut']) {
				$rows = $this->getAttributeID($data['act_attribut']);
				if (empty($rows)) continue;
				$rows = $this->getAttributeById($row['product_id'], $rows[0]['attribute_id'], $lang);
				if (empty($rows)) continue;
			}
			if ($data['act_noattribut'] and !$data['act_attribut']) {
				$rows = $this->getAttributeID($data['act_noattribut']);
				if (!empty($rows)) { 
					$rows = $this->getAttributeById($row['product_id'], $rows[0]['attribute_id'], $lang);
					if (!empty($rows)) continue;
				}	
			}
			if ($data['act_noattribut'] and $data['act_attribut'] and $data['act_attribut'] != $data['act_noattribut']) {
				$rows = $this->getAttributeID($data['act_attribut']);
				if (empty($rows)) continue;
				$rows = $this->getAttributeById($row['product_id'], $rows[0]['attribute_id'], $lang);
				if (empty($rows)) continue;
				
				$rows = $this->getAttributeID($data['act_noattribut']);
				if (!empty($rows)) { 
					$rows = $this->getAttributeById($row['product_id'], $rows[0]['attribute_id'], $lang);
					if (!empty($rows)) continue;
				}
			}
		
			switch ($data['command']) {			
				case 1: if ($data['act_mult'] != 1)
					$row['price'] = $row['price'] * $data['act_mult'];
					$this->upProduct($row);
					break;
				case 2: $row['stock_status_id']	= 7;
					$this->upProduct($row);
					break;
				case 3: $row['stock_status_id']	= 6;
					$this->upProduct($row);
					break;
				case 4: $row['stock_status_id']	= 8;
					$this->upProduct($row);
					break;
				case 5: $row['stock_status_id']	= 5;
					$this->upProduct($row);
					break;
				case 6: $row['quantity']	= 99;
					$this->upProduct($row);
					break;
				case 7: if (!$data['zact_cat']) return;	
					$this->toCategory($row['product_id'], $data['zact_cat']);				
					break;	
				case 8: $this->setCategory($row['product_id'], $data['act_cat']);			
					break;	
				case 9: $row['status']	= 1;
					$this->upProduct($row);
					break;
				case 10: $row['status']	= 0;
					$this->upProduct($row);
					break;
				case 11: $this->deleteProduct($row['product_id']);					
					break;		
				case 13: $row['quantity']	= 0;
					$this->upProduct($row);
					break;				
				case 15: $this->Convert($row['product_id'], $mas_con, $text);		
					break;				
				case 16: $this->DoubleFoto($row['product_id']);		
					break;
				case 17: $this->FixMetaproduct($row);
					break;					
				case 18: $this->CreateSkuTable($row);
					break;				
				case 19: $this->deleteProductWithoutAttribute($row['product_id']);
					break;	
				case 20: $this->findreplaceAttribute($row['product_id'], $data['act_attribut'], $data['act_find'], $data['act_change']);
				 $this->cache->delete('product');
					break;
				case 21: $this->findreplaceDescription($row['product_id'], $data['act_find'], $data['act_change']);
					break;
				case 22: $this->shipping($row['product_id']);
					break;
				case 23: $this->noshipping($row['product_id']);
					break;
				case 24: $this->findreplaceName($row['product_id'], $data['act_find'], $data['act_change']);
					break;
				case 25: $this->exportAtt($row['product_id'], $masatt);
					break;
				case 26: $err = $this->importAtt($row['product_id'], $masatt);
					if ($err) return $err;
					break;
				case 27: $err = $this->DeletePhoto($row['product_id']);
					if ($err) return $err;
					break;
				case 28: $this->addPrefix($row, $data['act_find'], $data['act_change']);					
					break;
				case 29: $this->printSkuLibrary($row);					
					break;
				case 30:
					$category_id = 0;
					$rows = $this->getProductCategory($row['product_id']);
					if (!empty($rows)) $category_id = $rows[0]['category_id'];
					$name = '';
					$rows = $this->getProductDesc($row['product_id']);
					if (!empty($rows)) $name = $rows[0]['name'];
				    $this->Same($row['sku'], $name, $category_id, $row['manufacturer_id'], $row['price']);		
					break;
				case 33:
					$err = $this->DeleteSpecialPrice($row['product_id']);					
					break;	
				case 34: $this->FixURL($row);
					break;
				case 35: $this->findreplaceTitle($row['product_id'], $data['act_find'], $data['act_change']);
					break;
				case 36: $this->findreplaceH1($row['product_id'], $data['act_find'], $data['act_change']);
					break;
				case 37: $this->findreplaceMetaDesc($row['product_id'], $data['act_find'], $data['act_change']);
					break;
				case 38: $this->sortPhoto($row['product_id']);		
					break;
				case 39: $this->shortDescription($row['product_id'], $data['act_find'], $data['act_change']);
				    break;
				case 40: $this->minimum($row['product_id'], $data['act_find'], $data['act_change']);
				    break;	
			}			
			
			if 	($data['command'] == 12) {
				$product_id = $row['product_id'];
				$manufacturer_id = $row['manufacturer_id'];
				
				$rows = $this->getProductDesc($product_id);
				if (empty($rows)) continue;	
				$desc = $rows;
				
				$st = '<Row>'."\n";
				$this->addex($st);
				
				$st = '';
				if (isset($row['sku'])) $st = $row['sku'];
				$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
				$this->addex($st);				
				
				$description = $rows[0]['description'];
				$st = '';
				if (isset($rows[0]['name'])) {
					$st = $rows[0]['name'];
					$st = strip_tags($st, '<p><em><i><br><li><ul><i><b><strong>');
					$st = htmlspecialchars($st);
					$st = str_replace("&amp;", "&", $st);
				}	
				$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
				$this->addex($st);
	
				$rows = $this->getProductCategory($product_id);
				$child = 0;
				for ($j=0; $j<10; $j++) {					
					if (!isset($rows[$j]['category_id'])) continue;
					else if ((int)$rows[$j]['category_id'] > $child) $child = $rows[$j]['category_id'];					
				}					
				if ($child) {
					$pach[0] = $child;
					for ($j=1; $j<5; $j++) {					
						$rows1 = $this->getCategory($child);
						if (empty($rows1)) break;
						$pach[$j] = $rows1[0]['parent_id'];
						$child = $pach[$j];					
					}	
				}
		
				for ($j=0; $j<5; $j++) {
					$st = '';
					if (isset($pach[$j])) {
						$rows = $this->getCategoryName($pach[$j]);						
						if (!empty($rows)) $st = $rows[0]['name'];
					}	
					$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
					$this->addex($st);
				}	
				
				$st = '';
				if (isset($row['quantity'])) $st = $row['quantity'];
				$st = '<Cell ss:StyleID="s21"><Data ss:Type="Number">'.$st.'</Data></Cell>'."\n";
				$this->addex($st);
				
				$st = '';
				if (isset($row['price'])) $st = $row['price'];
				$st = '<Cell ss:StyleID="s22"><Data ss:Type="Number">'.$st.'</Data></Cell>'."\n";
				$this->addex($st);
				
				$image = '';
				if (isset($row['image'])) $image = $row['image'];
				$weight = '';
				if (isset($row['weight'])) $weight = $row['weight'];
				$length = '';
				if (isset($row['length'])) $length = $row['length'];
				$width = '';
				if (isset($row['width'])) $width = $row['width'];
				$height = '';
				if (isset($row['height'])) $height = $row['height'];
				
				$spec = '';
				$row = $this->getActionPrice($product_id, 1);
				if (isset($row) and !empty($row)) $spec = $row['price'];
				
				$st = '<Cell ss:StyleID="s22"><Data ss:Type="Number">'.$spec.'</Data></Cell>'."\n";
				$this->addex($st);					
				
				$st = $description;
				$st = strip_tags($st, '<p><em><i><br><li><ul><i><b><strong>');
				$st = htmlspecialchars($st);
				$st = str_replace("&amp;", "&", $st);
				$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
				$this->addex($st);				
				
				$st = $image;
				$st = '<Cell ss:StyleID="s18"><Data ss:Type="String">'.HTTP_CATALOG."image/".$st.'</Data></Cell>'."\n";
				$this->addex($st);
								
				$rows = $this->getProductImage($product_id);
				for ($j=0; $j<$nf; $j++) {
					$st = '';
					if (isset($rows[$j]['image'])) {
						$st = $rows[$j]['image'];				
						$st = '<Cell ss:StyleID="s18"><Data ss:Type="String">'.HTTP_CATALOG.'image/'.$st.'</Data></Cell>'."\n";
					} else $st = '<Cell ss:StyleID="s18"><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";	
					$this->addex($st);
				}				
				
				if (!empty($data['act_manuf'])) $manufacturer_id = $data['act_manuf'];
				
				$rows = $this->getManufacturerName($manufacturer_id);
				$st = '';
				if (isset($rows[0]['name'])) $st = $rows[0]['name'];
				$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
				$this->addex($st);

				$st = '<Cell ss:StyleID="s21"><Data ss:Type="Number">'.$weight.'</Data></Cell>'."\n";
				$this->addex($st);			
				
				$st = '<Cell ss:StyleID="s21"><Data ss:Type="Number">'.$length.'</Data></Cell>'."\n";
				$this->addex($st);			
				
				$st = '<Cell ss:StyleID="s21"><Data ss:Type="Number">'.$width.'</Data></Cell>'."\n";
				$this->addex($st);				
				
				$st = '<Cell ss:StyleID="s21"><Data ss:Type="Number">'.$height.'</Data></Cell>'."\n";
				$this->addex($st);
				
				$st = '';
				if (isset($desc[0]['seo_h1'])) $st = $desc[0]['seo_h1'];
				$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
				$this->addex($st);
				
				$st = '';
				if (isset($desc[0]['seo_title'])) $st = $desc[0]['seo_title'];
				$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
				$this->addex($st);
				
				$st = '';
				if (isset($desc[0]['meta_keyword'])) $st = $desc[0]['meta_keyword'];
				$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
				$this->addex($st);
				
				$st = '';
				if (isset($desc[0]['meta_description'])) $st = $desc[0]['meta_description'];
				$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
				$this->addex($st);
				
				$st = '';
				if (isset($desc[0]['tag'])) $st = $desc[0]['tag'];
				$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
				$this->addex($st);

				$row1 = $this->getURL($product_id);
				
				$st = '';
				if (!empty($row1)) $st = $row1['keyword'];
				$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
				$this->addex($st);
				
				for ($j=0; $j<5; $j++) {
					$st = '';
					if (isset($pach[$j])) {
						$rows = $this->getCategoryPhoto($pach[$j]);						
						if (!empty($rows)) {
							$st = $rows[0]['image'];
							$st = str_replace("data/", "", $st);
						}
					}	
					$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
					$this->addex($st);
				}

				for ($j=1; $j<4; $j++) {
					$st = '';
					$rows = $this->getProductDiscount($product_id, $j);
					if (!empty($rows)) $st = $rows[0]['price'];
					$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
					$this->addex($st);
				}
				for ($j=1; $j<=$max_options; $j++) {
					$rows = $this->getProdOptions($product_id, $allOptions[$j]);
					$prod = $rows;
					
					$st = '';
					foreach ($prod as $one) {
						$rows = $this->getNameOption($one['option_value_id']);
						if (empty($rows)) $st = ';';
						else $st = $st . $rows[0]['name'].';';
					}
					$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
					$this->addex($st);
					
					$st = '';
					foreach ($prod as $one) {
						if (!isset($one['quantity'])) $st = ';';
						else $st = $st . $one['quantity'].';';
					}
					$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
					$this->addex($st);
					
					$st = '';
					foreach ($prod as $one) {
						if (!isset($one['price'])) $st = ';';
						else $st = $st . $one['price'].$one['price_prefix'].';';
					}
					$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
					$this->addex($st);
					
					$st = '';
					foreach ($prod as $one) {
						if (!isset($one['points'])) $st = ';';
						$st = $st . $one['points'].$one['points_prefix'].';';
					}
					$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
					$this->addex($st);
					
					$st = '';
					foreach ($prod as $one) {
						if (!isset($one['weight'])) $st = ';';
						$st = $st . $one['weight'].$one['weight_prefix'].';';
					}
					$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
					$this->addex($st);
				
				}
				
				$rows = $this->getAttributes($product_id);
				for ($j=0; $j<$max_att; $j++) {
					$st = '';
					$name = "";					
					if (isset($rows[$j]['text']) and isset($rows[$j]['attribute_id'])) {
						$rows1 = $this->getAttributeName($rows[$j]['attribute_id']);
						if (isset($rows1[0]['name'])) $name = $rows1[0]['name'];
						$st = $name;
						if ($data['act_attribut'] and $data['act_noattribut'] and $data['act_attribut'] == $data['act_noattribut']) {
							if ($data['act_noattribut'] == $name) {
								$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
								$this->addex($st);
								$st = $rows[$j]['text'];
								$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
								$this->addex($st);
							}	
						} else {							
							$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
							$this->addex($st);
							$st = $rows[$j]['text'];
							$st = '<Cell><Data ss:Type="String">'.$st.'</Data></Cell>'."\n";
							$this->addex($st);
						}	
					}					
				}
				
				$st = '</Row>'."\n";
				$this->addex($st);				
			}			
			$e = $this->putsos($i);
			if ($e < 0) return 2;	
		}
		
		if 	($data['command'] == 12) {
			$kol_cell = 32 + $nf + $max_a + $max_opt5;
			$this->EndEx($kol_cell);			
		}
		
		if 	($data['command'] == 29) {			
			$this->EndEx(5);			
		}
		
		if 	($data['command'] == 30) {			
			$this->EndEx(7);			
		}
		
		if 	($data['command'] == 25) {		
			for ($k=0; $k<2000; $k++) {
				if (!isset($masatt[$k][0])) break;
				$st = '<Row>'."\n";
				$this->addex($st);
				for ($j=0; $j<2; $j++) {
					if (!isset($masatt[$k][$j])) break;						
					$st = '<Cell><Data ss:Type="String">'.$masatt[$k][$j].'</Data></Cell>'."\n";
					$this->addex($st);
				}				
				for ($j=2; $j<203; $j++) {
					if (!isset($masatt[$k][$j])) break;
					$st = '<Cell><Data ss:Type="String">'."".'</Data></Cell>'."\n";
					$this->addex($st);
					$st = '<Cell><Data ss:Type="String">'.$masatt[$k][$j].'</Data></Cell>'."\n";
					$this->addex($st);
					
				}
				$st = '<Cell><Data ss:Type="String">'."".'</Data></Cell>'."\n";
				$this->addex($st);
				$st = '</Row>'."\n";
				$this->addex($st);	
			}		
		
			$kol_cell = 403;
			$this->EndEx($kol_cell);			
		}
		$path = "./uploads/sos.tmp";
		if (file_exists($path)) @unlink ($path);
		
		return 0;	
	}
	
	function getHead(&$url) {
		$ch = curl_init();	
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; ru-RU; rv:1.7.12) Gecko/20050919 Firefox/1.0.7");
		// допустимый заголовок HTTP Referer:
	//	curl_setopt ($ch, CURLOPT_REFERER, 'https://'.$url.'/index.php');
		// сохранять информацию Cookie в файл
	//	curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		// не проверять SSL сертификат
	//	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		// не проверять Host SSL сертификата
	//	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		$headers = array (
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*;q=0.8',
			'Accept-Language: ru,en-us;q=0.7,en;q=0.3',
			'Accept-Encoding: identity',
			'Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7'
		); 
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		curl_setopt($ch, CURLOPT_ENCODING, '');
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	//	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_NOBODY, 1);
	//	curl_setopt($curl, CURLOPT_COOKIE, "login=Admin;password=123456");
	
		$head = curl_exec($ch);
		if($head === false) {
			$s=curl_error($ch);	
			$err = " curl error head = " . $s ." \n";
			$this->adderr($err);
			
		}	
		curl_close($ch);	
		return $head; 		
	}	
	
	function getBody($url) {
		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; ru-RU; rv:1.7.12) Gecko/20050919 Firefox/1.0.7");
		// допустимый заголовок HTTP Referer:
	//	curl_setopt ($ch, CURLOPT_REFERER, 'https://'.$url.'/index.php');
		// сохранять информацию Cookie в файл
	//	curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		// не проверять SSL сертификат
	//	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		// не проверять Host SSL сертификата
	//	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		$headers = array (
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*;q=0.8',
			'Accept-Language: ru,en-us;q=0.7,en;q=0.3',
			'Accept-Encoding: identity',
			'Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7'
		); 
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		curl_setopt($ch, CURLOPT_ENCODING, '');
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	//	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_NOBODY, 0);
	//	curl_setopt($curl, CURLOPT_COOKIE, "login=Admin;password=123456");
	
		$body = curl_exec($ch);
		if($body === false) {
			$s=curl_error($ch);	
			$err = " curl body error = " . $s ." \n";
			$this->adderr($err);
			
		}
		curl_close($ch);		
		return $body; 		
	}
	
	function getRef($head, $url) {
		$new_url = 0;
		$p = strpos($head, "Location:");
		if (!$p) {
			$p = strpos($head, "src");
			if (!$p) $p = strpos($head, "href");
			if (!$p) return 0;
			$a = strpos($head, '"', $p)+1;			
			$b = strpos($head, '"', $p+9);
			$p = $b - $a;
			$new_url = substr($head, $a, $p);			
		} else {
			$pb = $p + 10;
			$pe = strpos($head, "\r\n", $pb);
			if (!$pe) return 0;
			$p = $pe - $pb;
			$new_url = substr($head, $pb, $p);
		}	
		if ($new_url) {
			if (!substr_count($new_url, "http://")) {							
				$pe = strpos($url, "//");
				if ($pe) $pe = $pe + 2;
				$pe = strpos($url, "/", $pe);
				$a = substr($url, 0, $pe);							
				if (substr($new_url, 0 ,1) != "/") $new_url = '/'.$new_url;
				$new_url = $a.$new_url;
				$new_url = str_replace ("../", "", $new_url);
				$new_url = str_replace ("./", "", $new_url);
			} else {
				$pe = strpos($new_url, "//");
				if ($pe) $pe = $pe + 2;
				$pe = strpos($new_url, "/", $pe);
				if (substr($new_url, $pe+1, 1) == ".") {
					$new_url = str_replace ("../", "", $new_url);
					$new_url = str_replace ("./", "", $new_url);
				}
			}
		}
		
		return $new_url;
	}
	
	function getCode($head) {		
		$s = substr($head, 0, 64);
		$ms = explode (" ", $s);
		if (!isset($ms[1])) return "dupa";
		if ($ms[1] == "200") return "OK";
		if ($ms[1] < "300" or $ms[1] > "399") return "dupa";	
		
		return "redirect";
	}
	
	function getContents(&$url) { 
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; ru-RU; rv:1.7.12) Gecko/20050919 Firefox/1.0.7");
		// допустимый заголовок HTTP Referer:
	//	curl_setopt ($ch, CURLOPT_REFERER, 'https://'.$url.'/index.php');
		// сохранять информацию Cookie в файл
	//	curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		// не проверять SSL сертификат
	//	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		// не проверять Host SSL сертификата
	//	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		$headers = array (
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*;q=0.8',
			'Accept-Language: ru,en-us;q=0.7,en;q=0.3',
			'Accept-Encoding: identity',
			'Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7'
		); 
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headers); 
		curl_setopt($ch, CURLOPT_ENCODING, '');
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	//	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_NOBODY, false);
	//	curl_setopt($curl, CURLOPT_COOKIE, "login=Admin;password=123456");
	
		$out = curl_exec($ch);
		
		if($out === false) {
			$s=curl_error($ch);	
			$err = " curl contens error = " . $s ." \n";
			$this->adderr($err);	
		}
		curl_close($ch);
		return $out; 		
	}	
	
	function curl_get_contents(&$url, $pi) {

		if ($pi) {
			$body = file_get_contents($url);
			return $body;
		}		
		for ($r=0; $r<5; $r++) {
			$head = $this->getHead($url);	
			if ($head === false) {
				$body = $this->getContents($url);					
				break;
			}	
			$code = $this->getCode($head);
		
			if ($code == "dupa") {
				$body = $this->getContents($url);				
				break;
			}
		
			if ($code == "OK") {			
				$body = $this->getBody($url);
				if (!$pi) break;
				if ($this->isPicture($body)) break;				
				$head = $body;
			}
			
			$ref = $this->getRef($head, $url);				
			if (!$ref) {
				$body = $this->getContents($url);
				break;
			}
			
			if ($ref) $url = $ref;	
		}	
		$charset = '';
		$fl = 0;
		$p = stripos($body, "charset=");
		if ($p) $charset = substr($body, $p+8, 20);		
		if (!empty($charset) and (substr_count($charset, "1251") or (substr_count($charset, "utf-8") and !$this->detect_utf($body)))) $fl = 1;	
	
		if (!$pi and $fl) $body = $this->win_to_utf($body);
		
		return $body;
	}

	function isPicture($pic) {
		$beg = substr($pic, 0, 3);
		$a = 0;
		if (ord($beg[0]) == 0x47 && ord($beg[1]) == 0x49 && ord($beg[2]) == 0x46) $a = 1;
		if (ord($beg[0]) == 0xff && ord($beg[1]) == 0xd8 && ord($beg[2]) == 0xff) $a = 1;
		if (ord($beg[0]) == 0x89 && ord($beg[1]) == 0x50 && ord($beg[2]) == 0x4e) $a = 1;
	
		return $a;		
	}	
	
	
	function detect_utf($string) {
        return preg_match('%(?:
        [\xC2-\xDF][\x80-\xBF]    
        |\xE0[\xA0-\xBF][\x80-\xBF]  
        |[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}
        |\xED[\x80-\x9F][\x80-\xBF] 
        |\xF0[\x90-\xBF][\x80-\xBF]{2}
        |[\xF1-\xF3][\x80-\xBF]{3}
        |\xF4[\x80-\x8F][\x80-\xBF]{2}
        )+%xs', $string);
	}
	
	function win_to_utf($s) {
		$t ='';
		for($i=0, $m=strlen($s); $i<$m; $i++)    {
			$c=ord($s[$i]);
			if ($c<=127) {$t.=chr($c); continue; }
			if ($c>=192 && $c<=207) {$t.=chr(208).chr($c-48); continue; }
			if ($c>=208 && $c<=239) {$t.=chr(208).chr($c-48); continue; }
			if ($c>=240 && $c<=255) {$t.=chr(209).chr($c-112); continue; }
			if ($c==184) { $t.=chr(209).chr(145); continue; }; // ё
			if ($c==168) { $t.=chr(208).chr(129); continue; }; // Ё
			if ($c==179) { $t.=chr(209).chr(150); continue; }; // і
			if ($c==178) { $t.=chr(208).chr(134); continue; }; // І
			if ($c==191) { $t.=chr(209).chr(151); continue; }; // ї
			if ($c==175) { $t.=chr(208).chr(135); continue; }; // ї
			if ($c==186) { $t.=chr(209).chr(148); continue; }; // є
			if ($c==170) { $t.=chr(208).chr(132); continue; }; // Є
			if ($c==180) { $t.=chr(210).chr(145); continue; }; // ґ
			if ($c==165) { $t.=chr(210).chr(144); continue; }; // Ґ
			if ($c==250) { $t.=chr(208).chr(170); continue; }; // ъ			
			
		}
		return $t;
	}

	
	public function ParsAttribute($ht, $key, $point, &$text) {
		$text = '';
		
		if (!empty($point)) {
			$point = str_replace('&quot;', '"',$point);
			$point = str_replace('&lt;', '<',$point);
			$point = str_replace('&gt;', '>',$point);
			$point = str_replace('&amp;', '&',$point);
		}	
		
		if (!empty($key) and strlen($ht) > 500) {
	
			$key = str_replace('&quot;', '"',$key);
			$key = str_replace('&lt;', '<',$key);
			$key = str_replace('&gt;', '>',$key);
			$key = str_replace('&amp;', '&',$key);
			
			$k = explode(",", $key);
			if (empty($k[0]) or empty($k[1]) or empty($k[2])) {
				$err = " Attribute keyword error \n";
				$this->adderr($err);
				return $text;
			}			
			$lk0 = strlen($k[0]);
			$lk1 = strlen($k[1]);
			$lk2 = strlen($k[2]);
			$lk3 = 0;
			if (isset($k[3]) and !empty($k[3])) $lk3 = strlen($k[3]);
			
			$pos = 0;			
			if (!empty($point))	{
				$pos = strpos($ht, $point);				
				if (!$pos) return;
			}
			$pos = stripos($ht, $k[0], $pos);			
			
			if ($pos) {
				$h = substr($ht, $pos-1, 75000);	
				$posa = 0;
				$i = 0;				
				while ($posa < 73000) {						
					$posa = stripos($h, $k[0], $posa);
					if ($posa) {						
						$posa = $posa + $lk0;						
						$pe = stripos($h, $k[1], $posa);						
						if (!$pe) break;						
						$le = $pe - $posa;
						if ($le > 100) $le = 100; 
						$a = substr($h, $posa, $le);
						$a = strip_tags($a);						
						$a = $this->litteras($a);
						$a = str_replace('&amp;', '&',$a);
						$a = trim($a);
						$posa = $pe + $lk1;
						
						if (!$lk3) $posv = $posa;		
						else $posv = stripos($h, $k[2], $posa);
						if ($posv) {
							if ($lk3) {
								$posv = $posv + $lk2;								
								$pe = stripos($h, $k[3], $posv);
							} else $pe = stripos($h, $k[2], $posv);
							if (!$pe) break;
							$le = $pe - $posv;
							if ($le > 2048) $le = 2048; 
							$v = substr($h, $posv, $le);
							$v = $this->symbol($v);
							$v = $this->litteras($v);							
							$v = trim($v);
	
							if ($v) {
								$text[$i]['name'] = $a;
								$v = str_replace("<ul><li>", "", $v);
								$v = str_replace("</li><li>", ", ", $v);
								$v = str_replace('&nbsp;', '',$v);
								$v = str_replace('&amp;', '&',$v);
								$text[$i]['val'] = strip_tags($v, '<em><i><b><strong>');								
								$i++;			
							}	
						} else break;
						$posa = $pe+$lk2;						
	
					} else break;
				}
			}	
		}
		return;
	}

	public function Parsing($ht, $k, $point, $place) {	
		
		if (!empty($point)) {
			$point = str_replace('&quot;', '"',$point);
			$point = str_replace('&lt;', '<',$point);
			$point = str_replace('&gt;', '>',$point);
			$point = str_replace('&amp;', '&',$point);
		}
		
		$text = '';
		$lk0 = strlen($k[0]);
		$num = 1;
		if (!empty($place) and $place > 0 and preg_match('/^[0-9]+$/', $place)) $num = $place;
	
		$pos = 0;
		$back = 0;
		if (!empty($point)) {
			$nn = strlen($point) - 2;
			if ($nn > 0) {
				$a = substr($point, $nn);
				if ($a == ",<") {
					$back = 1;
					$point = substr($point, 0, $nn);
				}	
				$pos = stripos($ht, $point);
				if (!$pos) return $text;
			}	
		}	
	
		if (!$back) {
			for ($j=1; $j<= $num; $j++) {				
				$pos = stripos($ht, $k[0], $pos+1);
				if (!$pos) break;					
			}
		} else {			
			$h = $ht;
			for ($j=1; $j<= $num; $j++) {				
				$h = substr($h, 0, $pos);
				$pos = strrpos($h, $k[0]);
				$pos--;
				if (!$pos) return $text;		
			}	
			$pos++;
		}	
	
		if ($pos) {
			$posa = $pos + $lk0;				
			if ($back) $pose = stripos($ht, $k[1], $posa);
			else $pose = stripos($ht, $k[1], $posa);
		
			if (isset($k[2]) and !empty($k[2])) {
				while(1) {
					$p = stripos($ht, $k[2], $pose+1);
					if (!$p) { 
						$pose = 0;
						break;
					}					
					$l = $p - $pose + strlen($k[2]);
					$end = substr($ht, $pose, $l);
					$end = preg_replace('%[^A-Za-zА-Яа-я0-9-/<>.:"=+;]%', '', $end);									
					$pose = $p;
					if ($end == $k[1].$k[2]) break;
					else {
						$pose = stripos($ht, $k[1], $p);
						if (!$pose) break;
					}				
				}
			}	
			if ($pose) {
				$l = $pose - $posa;
				if ($l > 0) {
					$text = substr($ht, $posa, $l);
					$text = trim($text);
					
				}	
			}	
		}
	
		$text = $this->litteras($text);
	
		return $text;	
	}
	
	public function ParsPrice($ht, $key, $point, $place) {
		$text = '';			
		if (!empty($key) and strlen($ht) > 500) {	
			$key = str_replace('&quot;', '"',$key);
			$key = str_replace('&lt;', '<',$key);
			$key = str_replace('&gt;', '>',$key);
			$key = str_replace('&amp;', '&',$key);
			
			$k = explode(",", $key);
			if (empty($k[0]) or empty($k[1])) {
				$err = " Price keyword error \n";
				$this->adderr($err);
				return $text;
			}			
			$pr = $this->Parsing($ht, $k, $point, $place);

			$pr = strip_tags($pr);
			$pr = str_replace(',','.',$pr);				
			$pr = str_replace('руб.','',$pr);
			$pr = str_replace('р.','',$pr);				
			$pr = str_replace('грн.','',$pr);
			$pr = str_replace('гр.','',$pr);				
			$pr = str_replace('руб','',$pr);
			$pr = str_replace('р','',$pr);				
			$pr = str_replace('грн','',$pr);
			$pr = str_replace('гр','',$pr);
			$pr = str_replace(' ','',$pr);
			$pr = str_replace("'", "", $pr);
			$text = trim($pr);
			if (strlen($text) > 16) $text = substr($text, 0, 16);
			$text = preg_replace('/[^0-9.+-]/','',$text);
		}	
		return $text;
			
	}
	
	
	public function ParsCategory($ht, $key, $point, $place) {
		$text = '';			
		if (!empty($key) and strlen($ht) > 500) {	
			$key = str_replace('&quot;', '"',$key);
			$key = str_replace('&lt;', '<',$key);
			$key = str_replace('&gt;', '>',$key);
			$key = str_replace('&amp;', '&',$key);
			
			$k = explode(",", $key);
			if (empty($k[0]) or empty($k[1])) {
				$err = " Category keyword error \n";
				$this->adderr($err);
				return $text;
			}
			$text = $this->Parsing($ht, $k, $point, $place);
			$text = strip_tags($text);
			$text = str_replace('&amp;', '&',$text);
			if (strlen($text) > 64) $text = substr($text, 0, 64);	
			$text = trim($text);
		}	
		return $text;
			
	}
	
	public function ParsManufacturer($ht, $key, $point, $place) {
		$text = '';			
		if (!empty($key) and strlen($ht) > 500) {	
			$key = str_replace('&quot;', '"',$key);
			$key = str_replace('&lt;', '<',$key);
			$key = str_replace('&gt;', '>',$key);
			$key = str_replace('&amp;', '&',$key);
			
			$k = explode(",", $key);
			if (empty($k[0]) or empty($k[1])) {
				$err = " Manufacturer keyword error \n";
				$this->adderr($err);
				return $text;
			}
			$text = $this->Parsing($ht, $k, $point, $place);
			$text = strip_tags($text);
			$text = str_replace('&amp;', '&',$text);
			if (strlen($text) > 48) $text = substr($text, 0, 48);
			$text = trim($text);			
		}
		
		return $text;
			
	}
	
	public function ParsCode($ht, $key, $point, $place) {
		$text = '';
		
		if (!empty($key) and strlen($ht) > 500) {
		
			$key = str_replace('&quot;', '"',$key);
			$key = str_replace('&lt;', '<',$key);
			$key = str_replace('&gt;', '>',$key);
			$key = str_replace('&amp;', '&',$key);
			
			$k = explode(",", $key);
			if (empty($k[0]) or empty($k[1])) {
				$err = " SKU keyword error = ". $key."\n";
				$this->adderr($err);
				return $text;
			}
			$text = $this->Parsing($ht, $k, $point, $place);
			$text = strip_tags($text);
			$text = str_replace('&amp;', '&',$text);
			if (strlen($text) > 48) $text = substr($text, 0, 48);
			$text = trim($text);
		}	
		return $text;
			
	}	
	
	public function ParsName($ht, $key, $point, $place) {
		
		$text = '';			
		if (!empty($key) and strlen($ht) > 500) {	
			$key = str_replace('&quot;', '"',$key);
			$key = str_replace('&lt;', '<',$key);
			$key = str_replace('&gt;', '>',$key);
			$key = str_replace('&amp;', '&',$key);
			
			$k = explode(",", $key);
			if (empty($k[0]) or empty($k[1])) {
				$err = " Product name keyword error \n";
				$this->adderr($err);
				return $text;
			}
			
			$text = $this->Parsing($ht, $k, $point, $place);
			$text = str_replace('&amp;', '&',$text);
			$text = strip_tags($text, '<em><i><b><strong>');
			if (strlen($text) > 128) $text = substr($text, 0, 128);
			$text = trim($text);
		}	
		return $text;
			
	}
	
	public function ParsDescription($ht, $key, $point, $place) {
	
		$text = '';			
		if (!empty($key) and strlen($ht) > 500) {	
			$key = str_replace('&quot;', '"',$key);
			$key = str_replace('&lt;', '<',$key);
			$key = str_replace('&gt;', '>',$key);
			$key = str_replace('&amp;', '&',$key);
			
			$k = explode(",", $key);
			if (empty($k[0]) or empty($k[1])) {
				$err = " Product description keyword error \n";
				$this->adderr($err);
				return $text;
			}			
			$text = $this->Parsing($ht, $k, $point, $place);			
	
            $text = str_replace('Описание', '', $text);
            $text = str_replace('Description', '', $text);
			$text = preg_replace('/<p.*?>/','<p>',$text);
			$text = preg_replace('/<P.*?>/','<P>',$text);
			$text = str_replace('<h2>', '<br><strong>', $text);
			$text = str_replace('</h2>', '</strong><br><br>', $text);
			$text = str_replace('<h3>', '<br><br><strong>', $text);
			$text = str_replace('</div>', '</div><br>', $text);
			$text = str_replace('</h3>', '</strong><br><br>', $text);
			$text = strip_tags($text, '<p><em><i><br><li><ul><i><b><strong>');     
			$text = str_replace('&amp;', '&',$text);
			$text = str_replace('&nbsp;', ' ',$text);			
			$posa = strrpos($text, "<!--");
			if ($posa) $text = substr($text, 0, $posa);
	
			/************ Вырезать текст начиная, с ********************/
			$pos = stripos($text, 'Купить', 0);
			if ($pos) $text = substr($text, 0, $pos);
			else {
				$pos = stripos($text, 'Сделать заказ', 0);
				if ($pos) $text = substr($text, 0, $pos);
				else {
					$pos = stripos($text, 'Продажа', 0);
					if ($pos) $text = substr($text, 0, $pos);
					else {
						$pos = stripos($text, 'Заказ', 0);
						if ($pos) $text = substr($text, 0, $pos);
						else {
							$pos = stripos($text, 'Расширяйте', 0);
							if ($pos) $text = substr($text, 0, $pos);
							else {
								$pos = stripos($text, 'Гарантия', 0);
								if ($pos) $text = substr($text, 0, $pos);
								else {
									$pos = stripos($text, 'Почему именно в', 0);
									if ($pos) $text = substr($text, 0, $pos);
									else {
										$pos = stripos($text, 'Инструкция', 0);
										if ($pos) $text = substr($text, 0, $pos);
										else {
											$pos = stripos($text, 'Сайт производителя', 0);
											if ($pos) $text = substr($text, 0, $pos);
										}	
									}
								}	
							}	
						}	
					}
				}
			}	
			/********************************/
	
            $text = trim($text);    
        }
		return $text;
    }
	
	public function ParsPic($ht, $url, $key, $warranty, $fname) {
	
		$fname = str_replace('&quot;', '"',$fname);
		$fname = str_replace('&lt;', '<',$fname);
		$fname = str_replace('&gt;', '>',$fname);
		$fname = str_replace('&amp;', '&',$fname);
				
		$l = strlen($ht);
		$im = 0;
		if ( $l > 500) {							
			$posb = 0;
			$pos = 0;							
			$num = substr($warranty, 4) + 0;
			
			for ($j=1; $j<= $num; $j++) {				
				$pos = stripos($ht, $fname, $pos+1);
				if (!$pos) break;					
			}	
					
			$s = '';
			if ($pos) {
				$sign = substr($warranty,0, 4);
				$fl = 0;
				if ($sign == "&lt;") {
					$s = substr ($ht, $pos-500, 500);					
					if (empty($key)) {						
						$posb = strrpos($s, "href=");
						if (!$posb) $posb=0;
						$posb1 = strrpos($s, "src=");
						if (!$posb1) $posb1=0;
						$posb2 = strrpos($s, "http");
						if (!$posb2) $posb2=0;
						$max = 0;
						if ($posb > $max) $max = $posb;
						if ($posb1 > $max) $max = $posb1;
						if ($posb2 > $max) {
							$max = $posb2;
							$fl = 1;
						}	
						$posb = $max;
						if ($fl) $posb = $posb - 2;
					} else $posb = strrpos($s, $key);						
					
				} else {
					$s = substr ($ht, $pos, 500);	
					if (empty($key)) {						
						$posb = stripos($s, "href=");
						if (!$posb) $posb=500;
						$posb1 = stripos($s, "src=");
						if (!$posb1) $posb1=500;
						$posb2 = stripos($s, "http");
						if (!$posb2) $posb2=500;
						$min = 99999999;
						if ($posb < $min) $min = $posb;
						if ($posb1 < $min) $min = $posb1;
						if ($posb2 < $min) {
							$min = $posb2;
							$fl = 1;
						}
						$posb = $min;
						if ($fl) $posb = $posb - 2;
					} else $posb = stripos($s, $key);	
				}	
			
				if ($posb != 500 and $posb != 0) {
					if (!empty($key)) $posb = $posb + strlen($key);
					$posb1 = stripos($s, "'", $posb);
					if ($posb1 > 500 or !$posb1) $posb1 = 500;
					$posb2 = stripos($s, '"', $posb);
					if ($posb2 > 500 or !$posb2) $posb2 = 500;
													
					if ($posb1 > $posb2) {
						$posb = $posb2;
						$posb1 = 0;
					} else {
						$posb = $posb1;
						$posb2 = 0;
					}				
					$pose=0;
					if ($posb != 500) {
						if ($posb1) $pose = stripos($s, "'", $posb+1);					
						if ($posb2) $pose = stripos($s, '"', $posb+1);
					}
					if ($posb != 500 and $pose) {
						$len = $pose-$posb-1;
						$im = 0;
						$im = substr($s, $posb+1, $len);
						if (!substr_count($im, "http")) {							
							$pe = strpos($url, "//");
							if ($pe) $pe = $pe + 2;
							$pe = strpos($url, "/", $pe);
							$a = substr($url, 0, $pe);							
							if (substr($im, 0 ,1) != "/") $im = '/'.$im;
							if (substr($im, 0 ,2) == "//") {
								$im = substr($im, 2);
								return $im;
							}	
							$im = $a.$im;
							$im = str_replace ("../", "", $im);
							$im = str_replace ("./", "", $im);
						} else {
							$pe = strpos($im, "//");
							if ($pe) $pe = $pe + 2;
							$pe = strpos($im, "/", $pe);
							if (substr($im, $pe+1, 1) == ".") {
								$im = str_replace ("../", "", $im);
								$im = str_replace ("./", "", $im);
							}
						}
					}
				}	
			}							
		}
		return $im;
	}
	
	public function checkException($cod, $masex, $nex) {
		$yes = 0;
		for ($i=0; $i<$nex; $i++) {
			if ($masex[$i] == $cod) {
				$yes = 1;
				break;
			}
		}
		return $yes;
	}
	
	public function loadfile($file_tmp, $file_name, $form_id) {				
		$allowed_filetypes = '.xml';
		$max_filesize = 500000000; 
					
		$f = htmlspecialchars($file_name);
		$ext = substr($f, strpos($f,'.'));
	  	
		if($ext != $allowed_filetypes) return 1;
		else if ( $_SERVER['CONTENT_LENGTH'] > $max_filesize) return 2;
			else {
				$file_xml = @fopen($file_tmp,"r");
					if(!$file_xml) return 3; 
					else {
							for ($i=0; $i < 2; $i++) {
								$st = fgets ($file_xml, 256);
								$res = substr_count($st, "Excel.Sheet");
							}
							if (!$res) return 4;
						}	
				}
		$path = "./uploads/";	
		if (!is_dir($path)) return 26;
				
		$rows = $this->getMySuppler($form_id);
		
			$id		  = $rows[0]['suppler_id'];
			$rate     = $rows[0]['rate'];
			$ccod      = $rows[0]['cod'];
			$related  = $rows[0]['related'];
			$lang 	  = $rows[0]['sort_order'];
			$iitem     = $rows[0]['item'];
			$ccat      = $rows[0]['cat'];			
			$qu       = $rows[0]['qu'];
			$pprice    = $rows[0]['price'];
			$ddescrip  = $rows[0]['descrip'];
			$ppic_ext  = $rows[0]['pic_ext'];
			$mmanuf    = $rows[0]['manuf'];
			$warranty = $rows[0]['warranty'];
			$sku2 	  = $rows[0]['sku2'];
			$ad       = $rows[0]['ad'];
			
			$st_status   = $rows[0]['status'];
			$my_cat   = $rows[0]['my_cat'];
			$my_qu    = $rows[0]['my_qu'];
			$my_price = $rows[0]['my_price'];
			$my_descrip = $rows[0]['my_descrip'];
			$my_manuf = $rows[0]['my_manuf'];
			$my_photo  = $rows[0]['my_photo'];
			$cheap    = $rows[0]['cheap'];
			$my_mark  = $rows[0]['my_mark'];
			$weight  = $rows[0]['weight'];
			$length  = $rows[0]['length'];
			$width  = $rows[0]['width'];
			$height  = $rows[0]['height'];
			$parent  = $rows[0]['parent'];
			$hide  = $rows[0]['hide'];
			$newphoto = $rows[0]['newphoto'];
			$addopt = $rows[0]['addopt'];
			$addseo = $rows[0]['addseo'];
			$ignore_margin = $rows[0]['importseo'];
			$updte  = $rows[0]['updte'];
			$pmanuf  = $rows[0]['pmanuf'];
			$upattr = $rows[0]['upattr'];
			$upopt = $rows[0]['upopt'];
			$upname = $rows[0]['upname'];
			$myplus = $rows[0]['myplus'];
			$cprice = $rows[0]['cprice'];
			$minus = $rows[0]['minus'];
			$chcode = $rows[0]['chcode'];
			$sorder = $rows[0]['sorder'];
			$spec = $rows[0]['spec'];
			$upurl = $rows[0]['upurl'];
			$ref = $rows[0]['ref'];
			$addattr = $rows[0]['addattr'];
			$exsame = $rows[0]['exsame'];
			$parss = $rows[0]['parss'];
			$points = $rows[0]['points'];
			$places = $rows[0]['places'];
			$parsi = $rows[0]['parsi'];
			$pointi = $rows[0]['pointi'];
			$placei = $rows[0]['placei'];
			$parsc = $rows[0]['parsc'];
			$pointc = $rows[0]['pointc'];
			$placec = $rows[0]['placec'];
			$parsp = $rows[0]['parsp'];
			$pointp = $rows[0]['pointp'];
			$placep = $rows[0]['placep'];
			$parsd = $rows[0]['parsd'];
			$pointd = $rows[0]['pointd'];
			$placed = $rows[0]['placed'];
			$parsm = $rows[0]['parsm'];
			$pointm = $rows[0]['pointm'];
			$placem = $rows[0]['placem'];
			$parsk = $rows[0]['parsk'];
			$catcreate = $rows[0]['catcreate'];
			$stay	 = $rows[0]['stay'];
			$joen	 = $rows[0]['joen'];
			$off	 = $rows[0]['off'];
			$umanuf  = $rows[0]['umanuf'];
			$onn	 = $rows[0]['onn'];
			$refer  = $rows[0]['refer'];
			$disc  = $rows[0]['disc'];
			$upc  = $rows[0]['upc'];
			$ean  = $rows[0]['ean'];
			$mpn  = $rows[0]['mpn'];
			$newurl  = $rows[0]['newurl'];
			$ddata  = $rows[0]['ddata'];			
			
			$catcreate = 0;
			$ddata = 0;
			$exsame = 0;			
			if ($ad == 5) $catcreate = 1;			
			if ($ad == 6) $ddata = 1;
			if ($ad == 7) $ddata = 2;
			if ($ad == 8) $exsame = 1;			
			
			$cod = $ccod;
			$item = $iitem;
			$cat = $ccat;
			$manuf = $mmanuf;
			$price = $pprice;
			$descrip = $ddescrip;
			$pic_ext = $ppic_ext;
			
		$np = substr_count($rows[0]['pic_ext'], ",");				
		$np = $np + 1;
		$ns = substr_count($rows[0]['warranty'], ",");
		$ns = $ns + 1;	
			
		$rows  = $this->getSupplerData($form_id);

		if (empty($rows) and !$ddata) return 21;
		
		$max = 0;
		foreach ($rows as $value) {
			$max++;
			$cat_ext[$max] = trim($value['cat_ext']);
			$category_id[$max] = $value['category_id'];
			$pic_int[$max] = trim($value['pic_int']);
			$cat_plus[$max] = trim($value['cat_plus']);
		}			
	
		$rows  = $this->getSupplerAttributes($form_id);
		
		$tags = '0';
		$attr_ext = '';
		$max_attr = 0;		
		if ($rows) {			
			foreach ($rows as $value) {
				$max_attr++;
				$attr_ext[$max_attr] = '';
				$attr_point[$max_attr] = '';
				$tags[$max_attr] = '0';
				$attr_ext[$max_attr] = $value['attr_ext'];
				$attr_point[$max_attr] = $value['attr_point'];
				$attribute_id[$max_attr] = $value['attribute_id'];
				$tags[$max_attr] = $value['tags'];
			}
		}		
		
		$langs = $this->getAllLanguages();
		
		$rows  = $this->getSupplerOptions($form_id);
	
		$max_opt = 0;
		if ($rows) {			
			foreach ($rows as $value) {
				$max_opt++;				
				$option_id[$max_opt] = $value['option_id'];
				$opt[$max_opt] = $value['opt'];
				$ko[$max_opt] = $value['ko'];
				$po[$max_opt] = $value['po'];
				$prr[$max_opt] = $value['pr'];
				$we[$max_opt] = $value['we'];
				$option_required[$max_opt] = $value['option_required'];
			}	
		}

		$rows  = $this->getSupplerPrice($form_id);
	
		$max_site = 0;
		if ($rows) {			
			foreach ($rows as $value) {								
				$nomkol[$max_site] = $value['nom'];
				$ident[$max_site] = $value['ident'];
				$param[$max_site] = $value['param'];
				$point[$max_site] = $value['point'];
				$max_site++;
			}	
		}			
		
		if (!empty ($rate) and !preg_match('/^[0-9.,]+$/', $rate)) return 7;
		if (empty ($rate)) $rate = 1;	
		$rate = str_replace(',','.',$rate);		
		if (empty ($cod)) return 8;
	//	if (empty ($item)) return 16;
		if (empty ($price)) return 19;	
		if (!empty ($qu) and !preg_match('/^[0-9,]+$/', $qu)) return 10;			
	//	if (!empty ($pic_ext) and !preg_match('/^[0-9,]+$/', $pic_ext)) return 13;
		if (empty ($pic_ext) and empty ($parsk) and ($ad == 1 or $ad == 3)) return 13;
		if (!empty ($weight) and !preg_match('/^[0-9]+$/', $weight)) return 18;
		if ((!empty ($length) and !preg_match('/^[0-9]+$/', $length)) or
			(!empty ($width) and !preg_match('/^[0-9]+$/', $width)) or
			(!empty ($height) and !preg_match('/^[0-9]+$/', $height))) return 11;
		if (!empty ($related) and !preg_match('/^[0-9]+$/', $related)) return 12;
		if (!empty ($myplus) and !preg_match('/^[0-9]+$/', $myplus)) return 9;
			
		if (!empty($warranty) and !preg_match('/^[0-9,&lt;&gt;]+$/', $warranty)) return 15;
		if ((!empty($parss) and !preg_match('/^[0-9]+$/', $parss)) or 
			(!empty($parsi) and !preg_match('/^[0-9]+$/', $parsi)) or 
			(!empty($parsc) and !preg_match('/^[0-9]+$/', $parsc)) or
			(!empty($parsp) and !preg_match('/^[0-9]+$/', $parsp)) or
			(!empty($parsd) and !preg_match('/^[0-9]+$/', $parsd)) or
			(!empty($parsm) and !preg_match('/^[0-9]+$/', $parsm)) or
			(!empty($parsk) and !preg_match('/^[0-9]+$/', $parsk))) return 14;
				
		for ($i = 1; $i <= $max; $i++) {
			if (empty($category_id[$i]) and !$catcreate and $ad != 6 and $ad != 7) return 25;			
			if (empty($pic_int[$i]) and $ad != 6 and $ad != 7) return 22;
		}
		
		$file_sos    = "./uploads/sos.tmp"; 
		if (!file_exists ($file_sos)) {
		
			$path = "./uploads/report.tmp";
			if (file_exists($path)) @unlink ($path);
		
			$path = "./uploads/errors.tmp";
			if (file_exists($path)) @unlink ($path);
			
			$path = "./uploads/ex.xml";
			if (file_exists($path)) @unlink ($path);
		}
		
		$row = array();
		
		$file_sos    = "./uploads/sos.tmp"; 
		if (file_exists ($file_sos)) {
			$sos = @fopen($file_sos,'r+');
			$row_count = (int)fgets($sos, 10);
			if (empty($row_count)) $row_count = 0;
			@fclose($sos);
		} else {
			$sos = @fopen($file_sos,'w+');
			if (!$sos) { @fclose($sos); return 5;}
			$row_count = 0;		
		}
		
		$except = 0;
		$path = "./uploads/exception.xml";
		if (file_exists($path)) {
			$except = 1;
			$file_con  = "./uploads/exception.xml"; 
			$con = @fopen($file_con,'r');			
			if (!$con) return 25;
						
			$st = '';
			$nex = 0;			
			$masex = array();	
			while (!feof($con)) {		
				while (!@feof($con) and !substr_count($st, "<Row")){
					$st = @fgets($con, 4096);
				}	
				if (@feof($con)) break;					
				
				$m = '';
				while (1) {						
					$st = @fgets($con, 4096);
					$m = $m.$st;
					if (@feof($con)) break;				
					if (substr_count($st, "</Row>"))  break;		
					if (substr_count($st, "<Cell") and substr_count($st, "</Cell")) break;	
										
					$st = @fgets($con, 4096);
					$m = $m.$st;
					if (@feof($con)) break;				
					if (substr_count($st, "</Row>"))  break;
					if (substr_count($st, "</Cell"))  break;
				}
				$posb = stripos($m, "String");
				if (!$posb) $posb = stripos($m, "Number");
					
				if (!$posb) break;
				$posb = $posb;
				$posb = stripos($m, ">", $posb)+1;
				$pose = stripos($m, "</Data", $posb);
				if (!$pose) $pose = stripos($m, "</ss:Data", $posb);
		
				if ($pose > $posb) {						
					$len = $pose - $posb;
					$m = substr($m, $posb, $len);
					$masex[$nex] = $m;
					$nex++;		
				}			
			}
			@fclose($con);		
		}	

		if ($exsame) {
			$path = "./uploads/ex.xml";			
			if (!file_exists($path)) {
				$this->StartEx();			
			
				for ($j=0; $j<7; $j++) {
					$st = ' <Column ss:AutoFitWidth="0" ss:Width="100"/>'."\n";
					$this->addex($st);
				}
				$st = '<Row>'."\n";
				$this->addex($st);			
				$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Product in Store</Data></Cell>'."\n";
				$this->addex($st);
				$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Main SKU in Store</Data></Cell>'."\n";
				$this->addex($st);
				$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">SKU in Price-list</Data></Cell>'."\n";
				$this->addex($st);
				$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Name in Store</Data></Cell>'."\n";
				$this->addex($st);			
				$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Name in Price-list</Data></Cell>'."\n";
				$this->addex($st);			
				$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Price in Store</Data></Cell>'."\n";
				$this->addex($st);
				$st = ' <Cell ss:StyleID="s20"><Data ss:Type="String">Price in Price-list</Data></Cell>'."\n";
				$this->addex($st);
				$st = '</Row>'."\n";
				$this->addex($st);			
			} else {				
				$ex = @fopen($path,'r+');
				$st ='usergio';
				$offsetB = 0;
				$offsetE = 0;
				while (!@feof($ex)) {
					$st = @fgets($ex, 2048);
					if (substr_count($st, "<Row")) $offsetB = @ftell($ex);
					if (substr_count($st, "</Row")) $offsetE = @ftell($ex);
				}
				if ($offsetB > $offsetE) {
					$st = '</Row>'."\n";
					@fclose($ex);
					$this->addex($st);
				}				
			}	
		}
		$table_sku = "";
		$table_sku = $this->getTable();	
	
		if (!@rewind($file_xml)) return 3;
	
		if ($row_count) {
			$i = 0;
			while (!@feof($file_xml) and ($i < $row_count)) {
				$st = @fgets($file_xml, 4096);
				if (substr_count($st, "<Row")) $i++; 
			}
		}	
		if (@feof($file_xml) and ($row_count > 0)) return 6;
		if (@feof($file_xml) and ($row_count = 0)) return 17;
	
		while (!feof($file_xml)) {		
			while (!@feof($file_xml) and !substr_count($st, "<Row")) {
				$st = @fgets($file_xml, 4096);
			}	
			if (@feof($file_xml)) break;

			for ($j=1; $j<2048; $j++) { $row[$j] = NULL;}	
			$i = 0;
			$br = 0;
			$ext = 1;			
			while ($ext) {			
				$st = @fgets($file_xml, 4096);
				if (@feof($file_xml)) break;				
				if (substr_count($st, "</Row>"))  break;
								
				if (!substr_count($st, "<Cell")) {
				
					if (substr_count($st, "</Data")) $pose = strpos($st, "</Data"); 
						else if (substr_count($st, "</ss:Data")) $pose = strpos($st, "</ss:Data"); 
								else $pose = strlen($st) - 1;
					if ($pose and $br) $row[$i] = $row[$i].preg_replace('| +|', ' ', substr($st, 0, $pose));					
					continue;
					
				} else {					
					$p = strpos($st, "Index=");
					if ($p != 0) {
						$pe = strpos($st, '"', $p+7);
						$i = substr ($st, $p+7, $pe-$p-7) + 0;
					} else $i ++;
					
					$br = 0;
					$a = ">";
					$posb1 = strpos($st, "String");
					if ($posb1 === false) $posb1 = 999;
					$posb2 = strpos($st, "Number");
					if ($posb2 === false) $posb2 = 999;
					$posb3 = strpos($st, "HRef=");
					if ($posb3 === false) $posb3 = 999;
					if ($posb1 < $posb2) $posb = $posb1;
					else $posb = $posb2;
					if ($posb3 < $posb) {
						$posb = $posb3;
						$a = '"';						
					}		
					if ($posb != 999)	{					
						$posb = strpos($st, $a , $posb) +1;
						if ($posb < 0) continue;
						$pose = 0;
						if ($a != '"') {						
							if (substr_count($st, "</Data")) $pose = strpos($st, "</Data", $posb); 
							else if (substr_count($st, "</ss:Data")) $pose = strpos($st, "</ss:Data", $posb); 
						} else $pose = strpos($st, $a, $posb); 
						if (!$pose) {
							$br = 1;
							$row[$i] = substr($st, $posb);
							continue;
						}	
						if ($pose and $pose > $posb) {						
							$len = $pose - $posb;
							$row[$i] = substr($st, $posb, $len);		
						} 
					} else continue;
				}
			}	
	
			$pname = "";
			$ht = "";
			$parsed = "";
			$cod = $ccod;
			$item = $iitem;
			$cat = $ccat;
			$manuf = $mmanuf;
			$price = $pprice;
			$descrip = $ddescrip;
			$pic_ext = $ppic_ext;
			
			if (!preg_match('/^[0-9]+$/', $cod)) {
				if (empty($row[$parss])) {
					$row_count = $this->putsos((int)$row_count);
					if ($row_count < 0) return 5;
					$err = " The Product was passed: Row ~= " . $row_count . " Empty link in column = ".$parss."\n";
					$this->adderr($err);					
					continue;
				}
				$url = $this->checkurl($row[$parss]);
				if ($url == -1) {
					$err = " The Product was passed: Row ~= " . $row_count . " Incorrect link = ".$row[$parss]. " in column = ".$parss."\n";
					$this->adderr($err);
					$row_count = $this->putsos((int)$row_count);
					if ($row_count < 0) return 5;
					continue;
				}
				
				$ht = $this->curl_get_contents($url, 0);
				if (strlen($ht) > 2048)  $parsed = $parss;
				else {
					$parsed = '';
					$err = " The Product was passed: Row ~= " . $row_count . " url = ". $url. " Site no answer \n";
					$this->adderr($err);
					$row_count = $this->putsos((int)$row_count);
					if ($row_count < 0) return 5;
					continue;
				}
	
				$in = $this->ParsCode($ht, $ccod, $points, $places);
				
				if (empty($in) or strlen($in) > 64) {
					$err = " The Product was passed: Row ~= " . $row_count . " parsing sku fail, sku = " . $in . " \n";
					$this->adderr($err);
					$row_count = $this->putsos((int)$row_count);
					if ($row_count < 0) return 5;
					continue;
				}
				$cod = 'cod';				
				$row[$cod] = $in;
			}
	/***********************/
			if (!empty($cat)) {
				if (!preg_match('/^[0-9,]+$/', $cat)) {
					if (empty($row[$parsc])) {
						$row_count = $this->putsos((int)$row_count);
						if ($row_count < 0) return 5;
						$err = " The Product was passed: Row ~= " . $row_count . " Empty link in column = ".$parsc."\n";
						$this->adderr($err);						
						continue;
					}
					$url = $this->checkurl($row[$parsc]);
					if ($url == -1) {
						$err =  " The Product was passed: Row ~= " . $row_count . " Incorrect link = ".$row[$parsc]. " in column = ".$parsc."\n";
						$this->adderr($err);
						$row_count = $this->putsos((int)$row_count);
						if ($row_count < 0) return 5;
						continue;
					}
					if (strlen($ht) < 1024 or $parsed != $parsc) {
						$ht = $this->curl_get_contents($url, 0);
						if (strlen($ht) > 2048) $parsed = $parsc;
						else {
							$parsed = '';
							$err = " The Product was passed: Row ~= " . $row_count . " url = ". $url. " Site no answer \n";
							$this->adderr($err);
							$row_count = $this->putsos((int)$row_count);
							if ($row_count < 0) return 5;
							continue;
						}	
					}
					$in = $this->ParsCategory($ht, $ccat, $pointc, $placec);
					
					if (empty($in) or strlen($in) > 100 or strlen($in) < 2) {
						$err = " The Product was passed: Row ~= " . $row_count . " parsing product category fail, category = ". $in . " \n";
						$this->adderr($err);
						$row_count = $this->putsos((int)$row_count);
						$cat = 'cat';
						$row[$cat] = '';
					} else {
						$cat = 'cat';
						$row[$cat] = $in;
					}	
				}
			}	
		/**************/
			if (!preg_match('/^[0-9,]+$/', $price)) {
				if (empty($row[$parsp])) {
					$row_count = $this->putsos((int)$row_count);
					if ($row_count < 0) return 5;
					$err = " The Product was passed: Row ~= " . $row_count . " Empty link in column = ".$parsp."\n";
					$this->adderr($err);					
					continue;
				}
				$url = $this->checkurl($row[$parsp]);
				if ($url == -1) {
					$err = " The Product was passed: Row ~= " . $row_count . " Incorrect link = ".$row[$parsp]. " in column = ".$parsp."\n";
					$this->adderr($err);
					$row_count = $this->putsos((int)$row_count);
					if ($row_count < 0) return 5;
					continue;
				}
				if (strlen($ht) < 1024 or $parsed != $parsp) {
					$ht = $this->curl_get_contents($url, 0);					
					if (strlen($ht) > 2048) $parsed = $parsp;
					else {
						$parsed = '';
						$err = " The Product was passed: Row ~= " . $row_count . " url = ". $url. " Site no answer \n";
						$this->adderr($err);
						$row_count = $this->putsos((int)$row_count);
						if ($row_count < 0) return 5;
						continue;
					}						
				}
				
				$in = $this->ParsPrice($ht, $pprice, $pointp, $placep);				
								
				if (empty($in) or strlen($in) > 40 or !preg_match('/^[0-9,.]+$/', $in)) {
					$err = " The Product was passed: Row ~= " . $row_count . " parsing product price fail, price = " . $in . " \n";
					$this->adderr($err);
					$row_count = $this->putsos((int)$row_count);
					if ($row_count < 0) return 5;
					continue;
				}
				$price = 'price';
				$row[$price] = $in;
			}
		/**************/
			if (!empty($manuf)) {
				if (!preg_match('/^[0-9]+$/', $manuf)) {
					if (empty($row[$parsm])) {
						$row_count = $this->putsos((int)$row_count);
						if ($row_count < 0) return 5;
						$err = " The Product was passed: Row ~= " . $row_count . " Empty link in column = ".$parsm."\n";
						$this->adderr($err);						
						continue;
					}
					$url = $this->checkurl($row[$parsm]);
					if ($url == -1) {
						$err = " The Product was passed: Row ~= " . $row_count . " Incorrect link = ".$row[$parsm]. " in column = ".$parsm."\n";
						$this->adderr($err);
						$row_count = $this->putsos((int)$row_count);
						if ($row_count < 0) return 5;
						continue;
					}
					if (strlen($ht) < 1024 or $parsed != $parsm) {
						$ht = $this->curl_get_contents($url, 0);
						if (strlen($ht) > 2048) $parsed = $parsm;
						else {
							$parsed = "";
							$err = " The Product was passed: Row ~= " . $row_count . " url = ". $url. " Site no answer \n";
							$this->adderr($err);
							$row_count = $this->putsos((int)$row_count);
							if ($row_count < 0) return 5;
							continue;
						}	
					}
					$in = $this->ParsManufacturer($ht, $mmanuf, $pointm, $placem);					
					if (empty($in) or strlen($in) > 100 ) {
						$err = " The Product was passed: Row ~= " . $row_count . " parsing manufacturer fail, manufacturer = " . $in . " \n";
						$this->adderr($err);
						$row_count = $this->putsos((int)$row_count);
						$manuf = 'manuf';
						$row[$manuf] = '';
					} else {
						$manuf = 'manuf';
						$row[$manuf] = $in;
					}	
				}
			}	
			//  Форматирование текста в описании, можно закоментировать ненужное:
			if (isset($row[$descrip])) {			
			//	 Разрешить теги HTML 
			//	$row[$descrip] = htmlspecialchars_decode($row[$descrip]);	
			//   Удалить теги html 
			//  $row[$descrip]  = strip_tags($row[$descrip]); 
			
			$row[$descrip] = str_replace("&gt;", '>', $row[$descrip]);	
			$row[$descrip] = str_replace("&lt;", '<', $row[$descrip]);
			$row[$descrip] = str_replace("&quot;", '"', $row[$descrip]);
			$row[$descrip] = str_replace("&amp;nbsp;", " ", $row[$descrip]);
			$row[$descrip] = str_replace("&amp;quot;", '"', $row[$descrip]);	
			$row[$descrip] = str_replace("html:", "", $row[$descrip]);						
			$row[$descrip] = str_replace("&#10;", "&lt;br&gt;", $row[$descrip]);
			$row[$descrip] = str_replace("&amp;#xD;&amp;#xA;", "&lt;br&gt;", $row[$descrip]);
			$row[$descrip] = str_replace("&#xD;&#xA;", "&lt;br&gt;", $row[$descrip]);		
			$row[$descrip] = str_replace('Size="8"', 'size="0"', $row[$descrip]);
			$row[$descrip] = str_replace('Size="9"', 'size="0"', $row[$descrip]);
			$row[$descrip] = str_replace('Size="10"', 'size="2"', $row[$descrip]);
			$row[$descrip] = str_replace('Size="11"', 'size="3"', $row[$descrip]);
			$row[$descrip] = str_replace('Size="12"', 'size="3"', $row[$descrip]);
						
			$row[$descrip] = $this->symbol($row[$descrip]);
						
		// Разделить текст на строки
		//	$row[$descrip] = str_replace('. ', '.<br />', $row[$descrip]);
		//	$row[$descrip] = str_replace('! ', '!<br />', $row[$descrip]);
					
		// Удалить из описания слово "Описание"
		//	$row[$descrip] = str_replace('Описание', '', $row[$descrip]);
		//	$row[$descrip] = str_replace('Description', '', $row[$descrip]);			
		
		}
			$report = '';
			$row_count = $this->putsos((int)$row_count);
			if ($row_count < 0) return 5;
			
			if ($ad == 2) {
				$cheap = 0;
				$upopt = 0;
				$updte = 0;
				$upname = 0;
				$addseo = 0;
				$upurl = 0;
				$umanuf = 0;
				$upattr = 0;			
				$chcode = 0;				
			}
			if ($ad == 4) {				
				$upopt = 0;
				$updte = 0;
				$upname = 0;
				$addseo = 0;
				$upurl = 0;
				$umanuf = 0;
				$upattr = 0;				
				$chcode = 0;				
			}
			$mprice = '';
			if (preg_match('/^[0-9,]+$/', $price)) {				
				$mprice = explode("," , $price);
				$price = $mprice[0];				
			}
			
			if (isset($row[$price])) {
				$pr = trim($row[$price]);
				$pr = str_replace(',','.',$pr);				
				// Удалить в колонке цена лишний текст
				$pr = str_replace('руб.','',$pr);
				$pr = str_replace('р.','',$pr);				
				$pr = str_replace('грн.','',$pr);
				$pr = str_replace('гр.','',$pr);				
				$pr = str_replace('руб','',$pr);
				$pr = str_replace('р','',$pr);				
				$pr = str_replace('грн','',$pr);
				$pr = str_replace('гр','',$pr);
				$pr = str_replace(' ','',$pr);
				$pr = str_replace("'", "", $pr);
				
				$row[$price] = $pr;
			}
			
			if ((empty($row[$price]) or !preg_match('/^[0-9.Ee-]+$/', $row[$price])) and $ad != 2) {				
				$err = " The Product was passed: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Invalid price of product = ". $row[$price]. "\n";
				$this->adderr($err);
				continue;
			}
				
			if (empty($row[$cod]) and empty($row[$sku2])) {				
				$err = " The Product was passed: Row ~= " . $row_count . " SKU was not found \n";
				$this->adderr($err);
				continue;				
			}
	
			$rows = '';
			$sku = '';
			if (!empty($row[$cod])) {
				if (!empty($table_sku)) {
					$rows = $this->getProduct($row[$cod]);
					if (!empty($rows)) $sku = $rows[0]['sku'];
				} else {
					$rows  = $this->getProductBySKU($row[$cod]);
					$sku = $row[$cod];	
				}	
			}	
			if (!empty($row[$sku2])) {
				if (empty($rows)) {
					if (!empty($table_sku)) {
						$rows = $this->getProduct($row[$sku2]);
						if (!empty($rows)) $sku =  $rows[0]['sku'];	
					} else {
						$rows  = $this->getProductBySKU($row[$sku2]);
						$sku = $row[$sku2];	
					}	
				} else {
					if ($joen) {
						$row1 = '';
						if (!empty($row[$cod])) $row1 = $this->getskuDescription($row[$cod]);
						if (!empty($row1)) $this->addSkuToTable($row[$sku2], $row1['sku_id']);
						else if (!empty($row[$cod])) {
							$rows1  = $this->getProductBySKU($row[$cod]);
							if (!empty($rows1)) {
								$last_sku_id = 0;
								$this->addSkuToTable($row[$cod], $last_sku_id);			
								$this->putsku($rows1[0]['product_id'], $last_sku_id);
								$this->addSkuToTable($row[$sku2], $last_sku_id);
								$sku = $rows1[0]['sku'];
							}
						}					
					}					
				}
				if (!empty($rows) and $stay) $rows[0]['sku'] = $row[$sku2];
			}			
			
			if (!empty($sku)) $row[$cod] = $sku;
			else if (empty($row[$cod])) $row[$cod] = $row[$sku2];
			$row_product  = $rows;	
			
			if ($ddata) {
				if (!empty($row[$cat])) {					
					$pic_int = '';
					$cat_plus = '';
					$category_id = 0;
					$name = '';
					$rows = $this->getCategoryIDbyName($row[$cat]);
					if (!empty($rows)) {
						$category_id = $rows[0]['category_id'];
						$rows = $this->getCategoryName($category_id);
						$name = $rows[0]['name'];
					}						
					if ($ddata == 2 and !empty($name)) {
						$app = $this->TransLit($name);
						$nom = strlen($app);										
						if ($nom > 20) $app = substr($app, 0, 20);
						if ($nom < 2) $app = rand(0, 9999);									
						$app = $this->MetaURL($app);
						$path = "../image/data/" .$app."/";
						if (!is_dir($path)) @mkdir($path, 0755);
						$pic_int = $app;
					}	
					$rows = $this->getDataForm($row[$cat], $form_id);
					if (empty($rows)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "suppler_data SET `form_id` = '" . (int)$form_id . "', `cat_ext` = '" . $this->db->escape($row[$cat]) . "', `category_id` = '" . (int)$category_id . "', `pic_int` = '" . $pic_int . "', `cat_plus` = '" . $cat_plus . "'");
					} else {
						$nom_id = $rows[0]['nom_id'];
						$this->db->query("UPDATE " . DB_PREFIX . "suppler_data SET `cat_ext` = '" . $this->db->escape($row[$cat]) . "', `category_id` = '" . (int)$category_id . "', `pic_int` = '" . $pic_int . "', `cat_plus` = '" . $cat_plus . "' WHERE `nom_id` = '" . (int)$nom_id . "'");
					}				
				}
				continue;
			}
			
			$flag = 0;
			$i = 1;
			$text_cat = "";
			$catmany = '';
			$refers = '';
			$cats = explode(",", $cat);
			if (isset($cats[0]) and preg_match('/^[0-9]+$/', $cats[0])) {
				$cat = $cats[0];
				$j = 0;
				foreach ($cats as $c) {
					if (!empty($c) and preg_match('/^[0-9]+$/', $c) and isset($row[$c]) and !empty($row[$c])) {
						$catmany[$j] = $row[$c];
						$refers[$j] = $row[$c+26];
						$j++;
					}	
				}
			}
	
			if (!empty($row[$cat])) {
				$text_cat = trim($row[$cat]);			
				for ($i=1; $i<=$max; $i++) {
					if ($text_cat == trim($cat_ext[$i])) {
						$flag = 1;
						break;
					}
				}
			}			
			
			if ($catcreate) {
				$row_product[0]['date_added'] = date('Y-m-d H:i:s');
				$this->putNewProduct($row_product, 0, $a, 1, 1, $langs, 1, 1, 0, $catmany, $catcreate, $newurl, $refers);
				continue;
			}
			
			$product_found = 0;
			if (isset($rows) and !empty($rows)) $product_found = 1;
			if ((!isset($rows) or empty($rows)) and $ad == 2) continue;
			if ((!isset($rows) or empty($rows)) and $ad == 4) continue;
			if ($product_found and $ad != 3) {			
				
				$p = strpos($row_product[0]['model'], "-");
				$papka = substr($row_product[0]['model'], $p-1, 1);
							
				$exc = 0;
				if ($except) {
					if ($this->checkException($row[$cod], $masex, $nex)) $exc = 1;					
				}
	
				if ($row[$price] == 0) {				
					$err = " The Product was passed: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Zero price of product \n";
					$this->adderr($err);
					continue;
				}				
	
				$quantity = 0;
				$qus = explode("," , $qu);
				for ($k=0; $k<9; $k++) {
					$quant = 0;
					if (!isset($qus[$k])) break;
					$quk = $qus[$k];	
					if (isset($row[$quk]) and preg_match('/^[0-9]+$/', $row[$quk])) {
						$quant = (int)$row[$quk];		
					} else {
						if (!empty($my_qu)) {
							if (substr_count($my_qu, "=")) {												
								$t = explode("," , $my_qu);
								foreach ($t as $value) {
									if (isset($value)) {
										$m = explode("=" , $value);
										if (isset($row[$quk]) and isset($m[0]) and isset($m[1]) and preg_match('/^[0-9]+$/', $m[1])) {
											if ($m[0] == trim($row[$quk])) {
												$quant = (int)$m[1];												
											}
										}
									}
								}
							}
						} 					
					}
					
				    $quantity = $quantity + $quant;
				}				
				
				if (!$quantity and preg_match('/^[0-9]+$/', $my_qu)) {
					$quantity = $my_qu;
					$report = $report."Quantity was set by default ";
				}				
				
				$new_price = 0;
				$plus = 0;
				if ($cheap) {
					if ($ad == 4 or ($quantity and !$exc)) {
						if (!$refer) {
							$mas = array();
							$identificator = array();
							$k = 0;
							for ($l=0; $l<$max_site; $l++) {						
								if (!empty($row[$nomkol[$l]])) $url = $this->checkurl($row[$nomkol[$l]]);
								if ($url != -1) {
									$ht = $this->curl_get_contents($url, 0);
									if (strlen($ht) > 1024) {
										$pr = $this->ParsPrice($ht, $param[$l], $point[$l], 1);		
										if (!empty($pr)) {
											$mas[$k] = $pr;
											$this->saveRef($row_product[0]['product_id'], $ident[$l], $param[$l], $point[$l], $url);
											$identificator[$k] = $ident[$l];
											$k++;
										}
									}
								}	
							}
						} else {
							$rows = $this->getReferens($row_product[0]['product_id']);								
							if (!empty($rows)) {
								$k = 0;
								foreach ($rows as $r) {	
									$ht = $this->curl_get_contents($r['url'], 0);
									if (strlen($ht) > 1024) {
										$pr = $this->ParsPrice($ht, $r['param'], $r['point'], 1);	
										if (!empty($pr)) {
											$mas[$k] = $pr;
											$k++;	
										}
									}
								}
							}
						}	
						if (!empty($mas)) {
							switch ($cheap) {			
								case 1:
									$min = 1000000000;
									for ($j=0; $j<$k; $j++) {
										if ($mas[$j] <= $min) $min = $mas[$j];
									}
									$new_price = $min - $onn;
									break;
								case 2:	
									$sum = 0;
									for ($j=0; $j<$k; $j++) {
										$sum = $sum + $mas[$j];
									}
									$new_price = $sum/$j - $onn;
									break;
								case 3:	
									$max = 0;
									for ($j=0; $j<$k; $j++) {
										if ($mas[$j] >= $max) $max = $mas[$j];
									}
									$new_price = $max - $onn;
									break;							
					
							}
							$pr = $row[$price]*$rate;
							$pr = $pr - $pr*$disc/100;
							if ($pr > $new_price) $new_price = 0;			
								
							
						}						
					}		
				}
				
				if (!$new_price and $ad != 2) {	
					$ff = 1; // Категория не найдена на стр Данные, ценa не меняется, если не включено: Игнорировать маржу
					$plus = 0;
					$old_price = $row_product[0]['price'];
					$row[$price] = $row[$price]*$rate;  // сначала, умножаем на курс					
					if ($ad == 4 or ($quantity and !$exc)) {
						if (!$flag and $my_price != 4 and !$cprice and empty($myplus)) {
							$rows = $this->getProductCategory($row_product[0]['product_id']);
							if (!isset($rows) or empty($rows)) {							
								$err = " The Product was missing: Row ~= " . $row_count . " SKU = " . $row[$cod] . " error in database: unknown Category \n";
								$this->adderr($err);
								continue;
							}	
							$cat_id = $rows[0]['category_id'];
							foreach ($rows as $value) {
								if ($cat_id < $value['category_id']) 
									$cat_id = $value['category_id'];							
							}		
			
							$rows = $this->getMargin($form_id, $cat_id);					
							if ((!isset($rows) or empty($rows)) and !$ignore_margin) {							
								$err =  " Warning: can not calculate margin. Row ~= " . $row_count . " SKU = " . $row[$cod] . "  Price was not updated \n";
								$this->adderr($err);
								$ff = 0;
							} else {
								if (!empty($rows)) $text = $rows[0]['cat_plus'];							
								if (!empty($text)) {
									if (preg_match('/^[-0-9,.]+$/', $text)) {
										$plus = str_replace(',','.',$text);
									} else {
										$pj = explode(",", $text);
										for ($j=0; $j<60; $j++) {
											if (!isset($pj[$j])) break;
											if (!substr_count($pj[$j], "(")) continue;
											if (!substr_count($pj[$j], ")")) continue;
											$pj[$j] = str_replace('(','',$pj[$j]);		
											$p = strpos($pj[$j], ')');
											if (!$p) continue;
											$d = substr($pj[$j], 0, $p);
											$p12 = explode("-", $d);
											$p1 = trim($p12[0]);
											$p2 = trim($p12[1]);
											if ($row[$price] >= $p1 and $row[$price] <= $p2) {
												$plus = substr($pj[$j], $p+1);			
												$plus = trim($plus);
												break;
											}
										}	
									}
									if ($plus != 0 and !$ignore_margin) $report = $report."Margin added success ";
								}
							}
						} else {
							if (!empty($myplus) and $my_price != 4 and preg_match('/^[-0-9,.]+$/', $row[$myplus])) {
								$plus = str_replace(',','.',$row[$myplus])+0.01-0.01;							
							} else {
								if ((empty($cat_plus[$i]) or $cat_plus[$i] == 0) and $my_price != 4 and $cprice) {
									$doll = $row[$price]/$rate + 0.01 - 0.01;	// переведем цену в доллары					
					
				// Таблица наценок. Зависит от цены товара в долларах. $m - множитель 
			
									if ($doll > 500.00) $m = 1.01;   // 1%
									if ($doll <= 500.00) $m = 1.05;  // пол процента
									if ($doll <= 200.00) $m = 1.06;
									if ($doll <= 100.00) $m = 1.1;			
									if ($doll <= 50.00) $m = 1.07;	
									if ($doll <= 30.00) $m = 1.15;
									if ($doll <= 20.00) $m = 1.2;
									if ($doll <= 10.00) $m = 1.35;
									if ($doll <= 5.00) $m = 1.4;
									if ($doll <= 4.00) $m = 1.5;
									if ($doll <= 3.00) $m = 1.6;
									if ($doll <= 2.00) $m = 1.7;
									if ($doll <= 1.40) $m = 1.8;
									if ($doll <= 1.20) $m = 1.9;
									if ($doll <= 1.00) $m = 2.0;	// 100 процентов				
					
									$plus = 100*($m-1);
									$report = $report."Margin was set by formula ";
								
								} else {
									if (!empty($cat_plus[$i])) {
										if (preg_match('/^[-0-9,.]+$/', $cat_plus[$i])) {
											$plus = str_replace(',','.',$cat_plus[$i]);
										} else {
											$pj = explode(",", $cat_plus[$i]);
											for ($j=0; $j<60; $j++) {
												if (!isset($pj[$j])) break;
												if (!substr_count($pj[$j], "(")) continue;
												if (!substr_count($pj[$j], ")")) continue;
												$pj[$j] = str_replace('(','',$pj[$j]);		
												$p = strpos($pj[$j], ')');
												if (!$p) continue;
												$d = substr($pj[$j], 0, $p);
												$p12 = explode("-", $d);
												$p1 = trim($p12[0]);
												$p2 = trim($p12[1]);
												if ($row[$price] >= $p1 and $row[$price] <= $p2) {
													$plus = substr($pj[$j], $p+1);
													$plus = trim($plus);
													break;
												}
											}	
										}
										if ($plus != 0 and !$ignore_margin) $report = $report."Margin added success ";
									}	
								}
							}
						}					
					}
					if ($ignore_margin) $plus = 0;
					if ($ff or (!$ff and $ignore_margin)) $new_price = $row[$price] + ($row[$price] * $plus/100);
				}
				
				$row_product[0]['hide'] = $row_product[0]['status'];
				if ($off and !$quantity) $row_product[0]['hide'] = 0;
				if ($quantity and $new_price) $row_product[0]['hide'] = 1;
				if ($ad == 2 and $quantity) $row_product[0]['hide'] = 1;
					
				$n = round($new_price, 2); 	// округление цены до копеек, 2 цифры после запятой
				if (($plus == 0 and $quantity and !$exc and $ad != 2 and !$ignore_margin) or ($ad == 4 and $plus == 0 and !$exc  and !$ignore_margin)) $report = $report."Price was not updated, because Margin = 0 ";
												
				$price_changed = 0;
				if ((!$row_product[0]['quantity'] and $quantity and $new_price and !$exc and $ad != 2 and $my_price != 4) or ($ad == 4 and !$exc and $my_price != 4)) {
					$row_product[0]['price'] = $n;
					$price_changed = 1;
					$report = $report."Price was updated ";
				} else {				
					if ($my_price == 1 and $quantity and $new_price and !$exc and $ad != 2) {
						$row_product[0]['price'] = $n;
						$price_changed = 1;
						$report = $report."Price was updated ";
					} else { 
						if ($my_price == 2 and $new_price and $new_price > $old_price and $quantity and !$exc  and $ad != 2)	{
							$row_product[0]['price'] = $n;
							$price_changed = 1;
							$report = $report."Price was updated ";
						} else {
							if ($my_price == 3 and $new_price and $new_price < $old_price and $quantity and !$exc and $ad != 2) {
								$row_product[0]['price'] = $n;
								$price_changed = 1;
								$report = $report."Price was updated ";
							}								
						}
					}
				}
				
				// Обновление акционных цен
				if ((!empty($spec) and $quantity and !$exc and $ad != 2) or (!empty($spec) and !$exc and $ad == 4)) {
					$data['product_id'] = $row_product[0]['product_id'];
					$data['customer_group_id'] = 1;
					$data['priority'] = 1;
					$pr = $row[$spec];
					$pr = str_replace(",", ".", $pr);
			// Удалить в колонке спец-цена цена лишний текст
					$pr = str_replace('руб.','',$pr);
					$pr = str_replace('р.','',$pr);				
					$pr = str_replace('грн.','',$pr);
					$pr = str_replace('гр.','',$pr);				
					$pr = str_replace('руб','',$pr);
					$pr = str_replace('р','',$pr);				
					$pr = str_replace('грн','',$pr);
					$pr = str_replace('гр','',$pr);
					$pr = str_replace(' ','',$pr);
					$pr = str_replace("'", "", $pr);
					if (!preg_match('/^[0-9.Ee-]+$/', $pr)) $pr = '';
					else $pr = $pr*$rate;
					$data['price'] = $pr;
					$data['date_start'] = "2000-01-01";
					$data['date_end'] = "2040-01-01";
					if ($pr) $report = $report."Special price was updated ";
					$this->upActionPrice($data);
				}
				
				$ff = 0;
				if (count($mprice) > 1 and $ad != 2) {   // Скидочные цены, скидки
					for ($j=1; $j<20; $j++) {
						if (!isset($mprice[$j])) break;
						if (empty($mprice[$j])) continue;
						$ff = 1;
						$data['product_id'] = $row_product[0]['product_id'];
						$data['customer_group_id'] = $j;
						$data['priority'] = 1;
						$pr = $row[$mprice[$j]];
						$pr = str_replace(",", ".", $pr);
			// Удалить в колонке спец-цена цена лишний текст
						$pr = str_replace('руб.','',$pr);
						$pr = str_replace('р.','',$pr);				
						$pr = str_replace('грн.','',$pr);
						$pr = str_replace('гр.','',$pr);				
						$pr = str_replace('руб','',$pr);
						$pr = str_replace('р','',$pr);				
						$pr = str_replace('грн','',$pr);
						$pr = str_replace('гр','',$pr);
						$pr = str_replace(' ','',$pr);
						$pr = str_replace("'", "", $pr);
						if (!preg_match('/^[0-9.Ee-]+$/', $pr)) $pr = '';
						else $pr = $pr*$rate;
						$data['price'] = $pr;
						$data['quantity'] = $quantity;
						$data['date_start'] = "2000-01-01";
						$data['date_end'] = "2040-01-01";
						
						$this->upWholesale($data);
					}
				}
				if ($ff) $report = $report."Wholesale price was updated ";
				
				$equ = 0;
				$p = strpos($row_product[0]['model'], "-");
				if (preg_match('/^[0-9-]+$/', $row_product[0]['model']) and $p > 0) {
					$nom = substr($row_product[0]['model'], $p+1, 2);
					if ((int)$id == (int)$nom) $equ = 1;
				}
				
				if (!$quantity and $equ and $ad != 4) $row_product[0]['quantity'] = 0;
				if (($quantity and $equ and $ad != 4) or ($quantity and $price_changed and $ad != 4) or ($quantity and $exc and $equ and $ad != 4) or $ad == 2) {
					$row_product[0]['quantity'] = $quantity;
					$report = $report."Quantity was updated ";					
				}
				
				if ($price_changed) {
					$p = strpos($row_product[0]['model'], "-");
					$nom = substr($row_product[0]['model'], 0, $p);
					$nom = $nom."-";
					$l = strlen($id);
					if ($l < 2) $nom = $nom."0";
					$nom = $nom.$id;							
					$row_product[0]['model'] = $nom;
					if (!$equ) $report = $report. "Supplier has been changed ";					
				}				
				$summa_options = 0;
				if ($max_opt and $upopt) {
					$mas_opt = array();					
					for ($j = 1; $j <= $max_opt; $j++) {
						if (!$option_id[$j] or !isset($row[$opt[$j]]) or empty($row[$opt[$j]])) continue;
						$rows = $this->getOptionsById($option_id[$j]);	
						if (!$rows) continue;
						
						if ($upopt == 2)
						$this->cleanQuantityOption($row_product[0]['product_id'], $option_id[$j]);
												
						$opt_val = explode(";" , $row[$opt[$j]]);
		
						if (isset($row[$ko[$j]])) $opt_ko = explode(";" , $row[$ko[$j]]);
						if (isset($row[$po[$j]])) $opt_po = explode(";" , $row[$po[$j]]);
						if (isset($row[$prr[$j]])) $opt_pr = explode(";" , $row[$prr[$j]]);
						if (isset($row[$we[$j]])) $opt_we = explode(";" , $row[$we[$j]]);		
		
						for ($l=0; $l<30; $l++) {
							$e = false;
							if (empty($opt_val[$l]) and !isset($opt_val[$l+1])) break;							
							foreach ($rows as $r) {
								if ($r['name'] == $opt_val[$l]) {
									$e = true;
									$data_option['op_val_id'] = $r['option_value_id'];
									break;
								}	
							}
							if (!$e) {
								if ($addopt and !empty($opt_val[$l])) {
									$this->addValue($option_id[$j], $ovid);									
									$this->addValueDescription($option_id[$j], $ovid, $opt_val[$l], $langs);
									$data_option['op_val_id'] = $ovid;
									$report = $report."Option value ".$opt_val[$l]." has been added";
								} else	$data_option['op_val_id'] = 0;							
							}
							$data_option['opt'] = $opt_val[$l];
							
							$data_option['ko'] = 0;							
							if (isset($opt_ko[$l]) and !empty($opt_ko[$l])) $data_option['ko'] = $opt_ko[$l];				
							
							$data_option['pr'] = 0;
							$data_option['pr_prefix'] = '+';
							if (isset($opt_pr[$l]) and !empty($opt_pr[$l])) {
								$e = substr($opt_pr[$l], strlen($opt_pr[$l])-1, 1);
								if ($e == '+' or $e == '-' or $e == '=' or $e == '%' or $e == '*' or $e == '#') {
									$data_option['pr_prefix'] = $e;								
									$b = substr($opt_pr[$l], 0, strlen($opt_pr[$l])-1);
								} else 	$b = substr($opt_pr[$l], 0, strlen($opt_pr[$l]));
								if (preg_match('/^[0-9.,]+$/', $b)) $data_option['pr'] = str_replace("," , ".", $b)*$rate;		
							}
							
							$data_option['po'] = 0;
							$data_option['po_prefix'] = '+';
							if (isset($opt_po[$l])) {
								$e = substr($opt_po[$l], strlen($opt_po[$l])-1, 1);
								if ($e == '+' or $e == '-' or $e == '=' or $e == '%' or $e == '*' or $e == '#') $data_option['po_prefix'] = $e;							
								$b = substr($opt_po[$l], 0, strlen($opt_po[$l])-1);
								if (preg_match('/^[0-9.,]+$/', $b)) $data_option['po'] = str_replace("," , ".", $b);		
							}
							
							$data_option['we'] = 0;
							$data_option['we_prefix'] = '+';
							if (isset($opt_we[$l]) and !empty($opt_we[$l])) {
								$e = substr($opt_we[$l], strlen($opt_we[$l])-1, 1);
								if ($e == '+' or $e == '-' or $e == '=' or $e == '%' or $e == '*' or $e == '#') $data_option['we_prefix'] = $e;								
								$b = substr($opt_we[$l], 0, strlen($opt_we[$l])-1);
								if (preg_match('/^[0-9.,]+$/', $b)) $data_option['we'] = str_replace("," , ".", $b);		
							}							
				
							$sub = 0;
							if (isset($row_product[0]['subtract'])) $sub = $row_product[0]['subtract'];				
							$data_option['option_required'] = $option_required[$j];
							$this->upProductOption($row_product[0]['product_id'], $option_id[$j], $data_option, $sub);
							
							$mas_opt[$j][$l][0] = $row_product[0]['product_id'];
							$mas_opt[$j][$l][1] = $option_id[$j];
							$mas_opt[$j][$l][2] = $data_option['op_val_id'];
							$mas_opt[$j][$l][3] = $ko[$j];
							$mas_opt[$j][$l][4] = $data_option['ko'];							
			/*				$mas_opt[$j][$l][5] = $data_option['pr'];							
							$mas_opt[$j][$l][6] = $data_option['po'];							
							$mas_opt[$j][$l][7] = $data_option['we'];	*/

						}	
					}					
					$gr_data = array();
					$gr_data ='';
					for ($l=0; $l<30; $l++) {
					$gr_data ='';
					if (!isset($mas_opt[1][$l][0])) break;
						$n = 0; $a = ''; $b = '';
						for ($j=1; $j<=$max_opt; $j++) {
							if (!isset($mas_opt[$j][$l][0])) continue;
							$m = 0;
							for ($k=1; $k<=$max_opt; $k++) {
								if (!isset($mas_opt[$k][$l][0])) continue;
								if ($mas_opt[$j][$l][3] == $mas_opt[$k][$l][3] and $j != $k and $a != $mas_opt[$j][$l][1] and $b != $mas_opt[$j][$l][2]) {								
									$a = $mas_opt[$j][$l][1];
									$b = $mas_opt[$j][$l][2];
									$n++;
									$m++;
									$gr_data[$n][0] = $l;
									$gr_data[$n][1] = $row_product[0]['product_id'];
									$gr_data[$n][2] = $mas_opt[$j][$l][1];
									$gr_data[$n][3] = $mas_opt[$j][$l][2];
									$gr_data[$n][4] = $mas_opt[$j][$l][4];
					/*				$gr_data[$n][5] = $mas_opt[$j][$l][5];
									$gr_data[$n][6] = $mas_opt[$j][$l][6];
									$gr_data[$n][7] = $mas_opt[$j][$l][7];	*/
									
								}
							}							
					
						}		
			
						if (!empty($gr_data)) $this->jOption($gr_data);
					}	
				}
				
				if (isset($gr_data)) {
					$this->summaOption($row_product[0]['product_id'], $summa_options);
					if ($summa_options) $row_product[0]['quantity'] = $summa_options;
				}	
				if (isset($row[$sorder]))
					$row_product[0]['sort_order'] = $row[$sorder];				
				
				$stat = 7;
				if ($st_status == 2) $stat = 6;
				if ($st_status == 3) $stat = 8;
				if ($st_status == 4) $stat = 5;
				if ($ad != 2 and $ad != 4) $row_product[0]['stock_status_id'] = $stat;

				$pictures ='';
				$pi = explode(",", $pic_ext);
				if (!empty($parsk)) {
					$pictures[0] = $parsk;
					$m = 0;
					for ($l=1; $l<20; $l++) {
						if (!isset($pi[$m])) break;							
						$pictures[$l] = $pi[$m];
						$m++;
					}	
				} else $pictures = $pi;				
	
				$nojpg = 0;			
				if ($newphoto > 1 and $ad != 2 and $ad != 4) {					
					for ($k=0; $k<$np; $k++) {
						if (!isset($pictures[$k])) break;
						$pic = $pictures[$k];						
						if (isset($row[$pic]) and !empty ($row[$pic])) {
							$url = $row[$pic];
							if (substr_count($url, "/")) $url = $this->checkurl($url);							
							if ($url == -1) continue;								
							$url = str_replace("&#45;", "-", $url);
							$url = str_replace("&amp;", "&", $url);			
						} else {
							if ($k == 0) {
								$url = $this->checkurl($my_photo);
								$url = str_replace("&#45;", "-", $url);
								$url = str_replace("&amp;", "&", $url);
							} else continue;
						}
					
						$rout = 0;
						$a = strlen($url)-6;
						$en = substr($url, $a);
						if (!substr_count($url, "/") and (stripos($en, '.jpg') or stripos($en, '.png') or stripos($en, '.jpeg') or stripos($en, '.gif'))) {					
							$nom = stripos($url, ".j");
							if (!$nom) $nom = stripos($url, ".png");
							if (!$nom) $nom = stripos($url, ".gif");
							if (!$nom) $se = ".jpg";
							else $se = substr($url, $nom);							
							$app = substr($url, 0, $nom);
							$nom = strrpos($app, ".");
							$app = substr($app, $nom);
							$app = $this->TransLit($app);							
							$app = $this->MetaURL($app);							
							$try = "../image/data/".$url;
							if (file_exists($try)) {						
								if (!empty ($pic_int[$i]))	{
									$spath = "../image/data/" .$pic_int[$i]."/";
									$path = "../image/data/" .$pic_int[$i]."/".$papka."/";
									$spic_addr = "data/".$pic_int[$i]."/".$app.$se;
									$pic_addr = "data/".$pic_int[$i]."/".$papka."/".$app.$se;				
								} else {
									$err =  " Please, set folder for photo on page Data. Row ~= " . $row_count ." The Product was passed" . " \n";
									$this->adderr($err);
									continue;
								}		
								if (!is_dir($spath)) {											
									$err =  " Photo has not been updated: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Folder: " . $path. "  not found \n";
									$this->adderr($err);
									continue;
								}
								if (!is_dir($path)) @mkdir($path, 0755);
								
								$path = $path.$app.$se;
								$a = @copy ($try, $path);
								if (!$a) {
									$a = @copy ($try, $spath);
									$pic_addr = $spic_addr;
								}	
								if ($a) {
									if ($k == 0) $row_product[0]['image'] = $pic_addr;			
									$rout = 1;
									if ($k>0) {
										$rows = $this->getProductImage($row_product[0]['product_id']);
										$e = 1;										
										foreach ($rows as $p) {
											if ($p['image'] == $pic_addr) $e = 0;
										}	
										if ($e) $this->addPicture($row_product[0]['product_id'], $pic_addr);				
									}	
								} else if ($k==0) $url = $this->checkurl($my_photo);
							}	
						}
					
						if (!$rout) {
							$pars = 0;
							$a = strlen($url)-6;
							$en = substr($url, $a);						
							
							if ((strlen($url) > 4) and !stripos($en, '.jpg') and !stripos($en, '.png') and !stripos($en, '.jpeg') and !stripos($en, '.gif') and $url != -1 and $k == 0 and $parsk) $pars = 1;
							
							$save = $row_product[0]['image'];														
							if ($pars) {									
								$fname = "photo";
								$marks = explode(",", $my_mark);								
								for ($j=0; $j<20; $j++) {
									if (!isset($marks[$j])) break;
									if (!empty($marks[$j])) {
										$fname = $marks[$j];
									} else {						
										if (isset($row[$manuf]) and !empty($row[$manuf])) {
											$fname = trim($row[$manuf]);											
											$fname = substr($fname, 0, 16);
										}
									}										
									$nojpg = 1;							
									$seeks = explode(",", $warranty);
									if (!isset($seeks[$j]) or empty($seeks[$j])) break;								
									$seek = $seeks[$j];															
									
									if (strlen($ht) < 1024 or $parsed != $parsk) {
										$ht = $this->curl_get_contents($url, 0);
										if (strlen($ht) > 1024) $parsed = $parsk;
										else {
											$parsed = '';
											$err =  " The Product was passed: Row ~= " . $row_count . " url = ". $url. " Site no answer \n";
											$this->adderr($err);												
											continue;
										}	
									}
									$key = '';														
									$urlp = $this->ParsPic($ht, $url, $key, $seek, $fname);							
									$urlp = $this->checkurl($urlp);			
									if ($urlp == -1) continue;								
										
									$nom = stripos($urlp, ".j");
									if (!$nom) $nom = stripos($urlp, ".png");
									if (!$nom) $nom = stripos($urlp, ".gif");
									$a = strlen($urlp);
									if (!$nom or $a - $nom > 5) {
										$se = ".jpg";
										$nom = $a;
									} else $se = substr($urlp, $nom);										
									$app = substr($urlp, 0, $nom);
									$nom = strrpos($app, ".");
									$app = substr($app, $nom+3);
									$app = $this->TransLit($app);
									$nom = strlen($app);										
									if ($nom > 40) $app = substr($app, $nom-40, 40);
									if ($nom < 2) $app = rand(0, 9999);									
									$app = $this->MetaURL($app);
		
									if (!empty ($pic_int[$i]))	{
										$spath = "../image/data/" .$pic_int[$i]."/";
										$path = "../image/data/" .$pic_int[$i]."/".$papka."/";
										$spic_addr = "data/".$pic_int[$i]."/".$app.$se;
										$pic_addr = "data/".$pic_int[$i]."/".$papka."/".$app.$se;				
									} else {
										$err =  " Please, set folder for photo on page Data. Row ~= " . $row_count ." The Product was passed" . " \n";
										$this->adderr($err);
										continue;
									}		
									if (!is_dir($spath)) {											
										$err =  " Photo has not been updated: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Folder: " . $path. "  not found \n";
										$this->adderr($err);
										continue;
									}
									if (!is_dir($path)) @mkdir($path, 0755);
									$path = $path.$app.$se;
									if ($j == 0) $row_product[0]['image'] = $pic_addr;
										
									if (!file_exists($path)) {											
										$pict = $this->curl_get_contents($urlp, 1);
										if (!$this->isPicture($pict)) {
											$row_product[0]['image'] = $save;							
											$err =  " Download photo fails. Row ~= " . $row_count ." Url = ". $urlp . " \n";
											$this->adderr($err);											
										} else {
											if ($newphoto == 2) {
												$bytes = @file_put_contents($path, $pict);
												if (!$bytes) {
													$bytes = @file_put_contents($spath, $pict);
													$pic_addr = $spic_addr;
												}	
											} else {
												$yes = 0;
												$temp = "../image/data/temp/temp".$se;
												$bytes = @file_put_contents($temp, $pict);
												if ($bytes) {
													$sizen = getimagesize ($temp);
													$vol = filesize($temp);
													$pn = $vol/$sizen[0]/$sizen[1];
													$pn = round($pn, 2);												
													$old = "../image/".$save;
													if (file_exists($old)) {
														$sizeo = getimagesize ($old);
														$vol = filesize($old);
														$po = $vol/$sizeo[0]/$sizeo[1];
														$po = round($po, 2);
														$maxn = $sizen[0];
														if ($maxn < $sizen[1]) $maxn = $sizen[1];
														$maxo = $sizeo[0];
														if ($maxo < $sizeo[1]) $maxo = $sizeo[1];
														$rn = $maxn/$maxo + sqrt($pn)/sqrt($po);
														$ro = $maxo/$maxn + sqrt($po)/sqrt($pn);
														if ($rn >= $ro) $yes = 1;
													} else $yes = 1;
														
													if ($yes) {
														$a = @copy ($temp, $path);
														if (!$a) {
															$a = @copy ($temp, $spath);
															$pic_addr = $spic_addr;
														}	
													} else if ($j == 0) $row_product[0]['image'] = $save;
														
												} else {														
													$err =  " Please, create folder image/data/temp" . "\n";
													$this->adderr($err);
													if ($j == 0) $row_product[0]['image'] = $save;
												}
											}	
											if ($j>0) {												
												if ($bytes) {
													$rows = $this->getProductImage($row_product[0]['product_id']);
													$e = 1;
													if (!empty ($rows)) {	
														foreach ($rows as $p) {
															if ($p['image'] == $pic_addr) $e = 0;
														}
													}	
													if ($e) $this->addPicture($row_product[0]['product_id'], $pic_addr);
												}
											} else {
												if (!$bytes) {											
													$row_product[0]['image'] = $save;									
													$err =  " Photo has not been updated  Url: ". $urlp . " Row = ".$row_count." Folder: ". $path . " is bad \n";
													$this->adderr($err);
												} else $report = $report."Photo was updated ";
											}	
										}
									} else {
										if ($j>0) {												
											$rows = $this->getProductImage($row_product[0]['product_id']);
											$e = 1;
											if (!empty ($rows)) {	
												foreach ($rows as $p) {
													if ($p['image'] == $pic_addr) $e = 0;
												}
											}
											if ($e) {
												$this->addPicture($row_product[0]['product_id'], $pic_addr);
												$report = $report."Additional photo was added ";
											} 	
										}
									} 
								}
							} else {							
								$nom = stripos($url, ".j");
								if (!$nom) $nom = stripos($url, ".png");
								if (!$nom) $nom = stripos($url, ".gif");
								$a = strlen($url);
								if (!$nom or $a - $nom > 5) {
									$se = ".jpg";
									$nom = $a;
								} else $se = substr($url, $nom);	
								$app = substr($url, 0, $nom);
								$nom = strrpos($app, ".");
								$app = substr($app, $nom+3);
								$app = $this->TransLit($app);
								$nom = strlen($app);
								if ($nom > 40) $app = substr($app, $nom-40, 40);
								if ($nom < 2) $app = rand(0, 9999);					
									
								$app = $this->MetaURL($app);
									
								if (!empty ($pic_int[$i]))	{
									$spath = "../image/data/" .$pic_int[$i]."/";
									$path = "../image/data/" .$pic_int[$i]."/".$papka."/";
									$spic_addr = "data/".$pic_int[$i]."/".$app.$se;
									$pic_addr = "data/".$pic_int[$i]."/".$papka."/".$app.$se;				
								} else {
									$err =  " Please, set folder for photo on page Data. Row ~= " . $row_count ." The Product was passed" . " \n";
									$this->adderr($err);
									continue;
								}		
								if (!is_dir($spath)) {											
									$err =  " Photo has not been updated: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Folder: " . $path. "  not found \n";
									$this->adderr($err);
									continue;
								}
								if (!is_dir($path)) @mkdir($path, 0755);
							}	
							if (!$pars) {	
								$path = $path.$app.$se;
								if ($k == 0) $row_product[0]['image'] = $pic_addr;
								if (!file_exists($path)) {												
									$pict = $this->curl_get_contents($url, 1);
									if (!$this->isPicture($pict)) {
										$row_product[0]['image'] = $save;											
										$err =  " Download photo fails. Row ~= " . $row_count ." Url = ". $url . " \n";
										$this->adderr($err);											
									} else {
										if ($newphoto == 2) {
											$bytes = @file_put_contents($path, $pict);
											if (!$bytes) {
												$bytes = @file_put_contents($spath, $pict);
												$pic_addr = $spic_addr;
											}	
										} else {
											$yes = 0;
											$temp = "../image/data/temp/temp".$se;
											$bytes = @file_put_contents($temp, $pict);
											if ($bytes) {
												$sizen = getimagesize ($temp);
												$vol = filesize($temp);
												$pn = $vol/$sizen[0]/$sizen[1];
												$pn = round($pn, 2);												
												$old = "../image/".$save;
												if (file_exists($old)) {
													$sizeo = getimagesize ($old);
													$vol = filesize($old);
													$po = $vol/$sizeo[0]/$sizeo[1];
													$po = round($po, 2);
													$maxn = $sizen[0];
													if ($maxn < $sizen[1]) $maxn = $sizen[1];
													$maxo = $sizeo[0];
													if ($maxo < $sizeo[1]) $maxo = $sizeo[1];
													$rn = $maxn/$maxo + sqrt($pn)/sqrt($po);
													$ro = $maxo/$maxn + sqrt($po)/sqrt($pn);
													if ($rn >= $ro) $yes = 1;
												} else $yes = 1;
												
												if ($yes) {
													$a = @copy ($temp, $path);
													if (!$a) {
														$a = @copy ($temp, $spath);
														$pic_addr = $spic_addr;
													}	
												} else if ($j == 0) $row_product[0]['image'] = $save;
													
											} else {														
												$err =  " Please. create folder image/data/temp" . "\n";
												$this->adderr($err);
												if ($j == 0) $row_product[0]['image'] = $save;
											}
										}	
										if ($k>0) {												
											if ($bytes) {
												$rows = $this->getProductImage($row_product[0]['product_id']);
												$e = 1;
												if (!empty ($rows)) {	
													foreach ($rows as $p) {
														if ($p['image'] == $pic_addr) $e = 0;
													}
												}	
												if ($e) $this->addPicture($row_product[0]['product_id'], $pic_addr);
											}
										} else {
											if (!$bytes) {
												$row_product[0]['image'] = $save;										
												$err =  " Photo has not been updated  Url: ". $url . " Row = ".$row_count." Folder: ". $path . " ist schlecht \n";
												$this->adderr($err);
											} else $report = $report."Photo was updated ";
										}	
									}
								}										
							}				
						}				
					}
				}
				
				$yes = 0;
				$rating_old =0;
				$l_old = 0;
				$row_product[0]['description'] = '';
				$rows = $this->getProductDesc($row_product[0]['product_id']);
				if (!empty($rows)) {
					$row_product[0]['description'] = $rows[0]['description'];
					if (substr_count($rows[0]['description'], "<br")) $rating_old++;
					if (substr_count($rows[0]['description'], "<strong")) $rating_old++;
					if (substr_count($rows[0]['description'], "<em")) $rating_old++;					
					if (substr_count($rows[0]['description'], "<b")) $rating_old++;
					if (substr_count($rows[0]['description'], "<li")) $rating_old++;
					$l_old = strlen($rows[0]['description']);					
				}	
								
				if ($updte > 1 or $upname or $addseo == 1 or $upurl) {
					$text = "";
					$pname = "";					
					if (!empty($descrip) and preg_match('/^[0-9]+$/', $descrip) and !empty($row[$descrip]) and $updte > 1){		
						$rating_new =0;						
						if (substr_count($row[$descrip], "<br")) $rating_new++;
						if (substr_count($row[$descrip], "<strong")) $rating_new++;
						if (substr_count($row[$descrip], "<em")) $rating_new++;						
						if (substr_count($row[$descrip], "<b")) $rating_new++;
						if (substr_count($row[$descrip], "<li")) $rating_new++;
						$l_new = strlen($row[$descrip]);						
						if ($l_old > $l_new) $rating_old++;
						if ($l_old < $l_new) $rating_new++;
							
						if ($updte == 3 and (empty($row_product[0]['description']) or $rating_new > $rating_old)) {
							$row_product[0]['description'] = $row[$descrip];
							$yes = 1;
						}
						if ($updte == 2 and !empty($row[$descrip])) {
							$row_product[0]['description'] = $row[$descrip];
							$yes = 1;
						}	
						
					}
					if (!empty($descrip) and !preg_match('/^[0-9]+$/', $descrip) and isset($row[$parsd])) {					
						$url = $this->checkurl($row[$parsd]);
						if ($url != -1) {							
							if ($updte > 1 or $addseo == 1) {												
								if (strlen($ht) < 1024 or $parsed != $parsd) $ht = $this->curl_get_contents($url, 0);
								if (strlen($ht) > 1024) {
									$parsed = $parsd;
									$text = $this->ParsDescription($ht, $descrip, $pointd, $placed);
									if (strlen($text) < 10) $text = '';
								} else {
									$parsed = '';
									$err =  " Parsing description error: Row ~= " . $row_count . " url = ". $url. " Site no answer \n";
									$this->adderr($err);										
								}
							}	
						}	
					}
					
					if (isset($row[$item]) and preg_match('/^[0-9]+$/', $item) and !empty($row[$item]) and $upname )  {	  
						$row_product[0]['item'] = trim($row[$item]);
						$report = $report."Product name was updated ";	
					}
					
					if (!empty($item) and !preg_match('/^[0-9]+$/', $item) and ($upname or $addseo == 1 or $upurl) and isset($row[$parsi])) {
						$url = $this->checkurl($row[$parsi]);
						if ($url != -1) {							
							if (strlen($ht) < 1024 or $parsed != $parsi) $ht = $this->curl_get_contents($url, 0);
							if (strlen($ht) > 1024) {
								$parsed = $parsi;
								$pname = $this->ParsName($ht, $item, $pointi, $placei);
								if (strlen($pname) < 2) {
									$err =  " Parsing Product Name error: Row ~= " . $row_count . " url = ". $url. " Product Name has not been updated \n";
									$this->adderr($err);
									$pname = "";
								}	
							} else {									
								$err =  " Parsing Product Name error: Row ~= " . $row_count . " url = ". $url. " Site no answer \n";
								$this->adderr($err);								
							}	
											
							if (!empty($pname)) {
								$row_product[0]['item'] = $pname;
								$report = $report."Product name was parsed and updated ";
							} else $report = $report."Product name has not been parsed ";
						}					
					}						
										
					if (!empty($my_descrip) and empty($text) and !$yes) {
						if (!preg_match('/^[0-9]+$/', $my_descrip)) $row_product[0]['description'] = $my_descrip;
						else if (!empty($row[$my_descrip])) $row_product[0]['description'] = $row[$my_descrip];
						$report = $report."Description set by default ";
					} else {
						if (empty($my_descrip) and empty($text) and !$yes) {
							$row_product[0]['description'] = '';							
						} else {
							if (!empty($my_descrip) and preg_match('/^[0-9]+$/', $my_descrip) and !empty($row[$my_descrip]))
							    $text = $row[$my_descrip] . "&lt;br&gt;&lt;br&gt;". $text;
							if (!empty($text)) {
								$rating_new =0;						
								if (substr_count($text, "<br")) $rating_new++;
								if (substr_count($text, "<strong")) $rating_new++;
								if (substr_count($text, "<em")) $rating_new++;							
								if (substr_count($text, "<b")) $rating_new++;
								$l_new = strlen($text);
								if ($l_old > $l_new) $rating_old++;
								else $rating_new++;
						
								if ($updte == 3 and ($rating_new > $rating_old or empty($row_product[0]['description']))) {
									$row_product[0]['description'] = $text;
									$report = $report."Description was parsed and updated ";
								}								
								if ($updte == 2) {
									$row_product[0]['description'] = $text;
									$report = $report."Description was parsed and updated ";
								}	
							} else $report = $report."Description was updated ";							
						}					
					}
				}
				
				$row_product[0]['category_id'] = '';
				if ($flag) $row_product[0]['category_id'] = $category_id[$i];					
				else $row_product[0]['category_id'] = $my_cat;
				
				$row_product[0]['manufacturer_id'] = 0;
				$name = '0';
				$row_product[0]['manuf_name'] = '';
				
				if (isset($row[$manuf]) and !empty ($row[$manuf])) $name = trim($row[$manuf]);
				else {
					if ($my_manuf) {
						$rows = $this->getManufacturerName($my_manuf);
						$name = $rows[0]['name'];
					}	
				}
				
				$row_product[0]['manuf_name'] = $name;
				if ($umanuf and $name) {
					$rows  = $this->getManufacturerID($name);					
					if(!empty($rows) and $rows[0]['manufacturer_id'] != 0) 
					$row_product[0]['manufacturer_id'] = $rows[0]['manufacturer_id'];
				}				
				
				$yesno = 0;
				if ($max_attr and $upattr) {					
					$fl =0;
					$er = 0;
					for ($j = 1; $j <= $max_attr; $j++) {
						$at = $attribute_id[$j];
						$col = explode(",", $attr_ext[$j]);
						if (!empty($col[0]) and preg_match('/^[0-9]+$/', $col[0])) {
							
							if (!$fl and $upattr == 1) {								
								$this->deleteAttribute($row_product[0]['product_id']);
								$fl = 1;
							}
							if ($at == 0 and !empty($row[$col[0]-1])) {													
								$rows = $this->getAttributeID($row[$col[0]-1]);								
								if (isset($rows[0]['attribute_id'])) $at = $rows[0]['attribute_id'];
	
								if ($upattr == 1 or $upattr == 2) {
									$data['text1'] = $row[$col[0]-1];
									$data['text2'] = '';
									if (isset($col[1]) and !empty($col[1])) $data['text2'] = $row[$col[1]-1];
									$this->createAttribute($data, $attID, $langs);
									$at = $attID;
									if (!$at) {
										$er = 1;
										break;
									}	
								} 
								if (!$at) continue;
							}
							if ($upattr == 4 and $at) {
								$rows = $this->getAttributeById($row_product[0]['product_id'], $at, $lang);
								if (empty($rows)) continue;
							}
							if (isset($row[$col[0]]) and !empty($row[$col[0]])) {
								$t = $this->symbol($row[$col[0]]);
								$t = trim($t);
								$data['text1'] = $t;
								$t = '';
								if (isset($col[1]) and !empty($col[1])) $t = $this->symbol($row[$col[1]]);
								$t = trim($t);
								$data['text2'] = $t;
								$data['product_id'] = $row_product[0]['product_id'];
								$data['attribute_id'] = $at;
								$this->putAttributeById($data, $langs);
								$yesno = 1;
							}								
						} else {											
							if (isset($row[$parsi])) $url = $this->checkurl($row[$parsi]);
							else $url = -1;
							if ($url != -1) {	
								if (strlen($ht) < 1024 or $parsed != $parsi) $ht = $this->curl_get_contents($url, 0);
								if (strlen($ht) > 1024) {
									$parsed = $parsi;
									$this->ParsAttribute($ht, $attr_ext[$j], $attr_point[$j], $text);
								} else {
									$parsed = '';
									$text = '';										
								}														
								if (!empty ($text)) {
									if (!$fl and $upattr == 1) {
										$this->deleteAttribute($row_product[0]['product_id']);
										$fl = 1;
									}				
									foreach ($text as $t) {
										if (empty ($t['name']) or empty ($t['val'])) continue;
										if (strlen($t['name'] > 64)) {
											$err =  " Attribute name: ". $t['name'] . " is too large \n";
											$this->adderr($err);
											continue;
										}		
										$rows = $this->getAttributeID($t['name']);										
										if (isset($rows[0]['attribute_id'])) $at = $rows[0]['attribute_id'];
										else {
											if ($upattr == 1 or $upattr == 2) {
												$data['text1'] = $t['name'];
												$data['text2'] = '';
												$this->createAttribute($data, $attID, $langs);
												$at = $attID;												
												if ($at) $report = $report." Attribute: ". $t['name'] . " was created \n";
											} else continue;
										}
										if ($upattr == 4 and $at) {
											$rows = $this->getAttributeById($row_product[0]['product_id'], $at, $lang);
											if (empty($rows)) continue;
										}
																		
										$data['product_id'] = $row_product[0]['product_id'];
										$data['text1'] = $t['val'];
										$data['text2'] = '';
										$data['attribute_id'] = $at;										
										$this->putAttributeById($data, $langs);
										$yesno = 1;
									}
								} else {
									$err =  "Row ~= " . $row_count . " SKU = " . $row[$cod] . " Attribute parse error \n";
									$this->adderr($err);
								}							
							}
						} 						
					}
					if ($er) {
						$err =  "Language 2 is not provided in the Store \n";
						$this->adderr($err);
					}	
				}
				if ($yesno) $report = $report." Attribute was updated \n";

				if ($ad != 2 and $ad != 4) $row_product[0]['subtract'] = $minus;
				if ($chcode and $ad != 4) {
					$model = $row_product[0]['product_id']."-";
					$l = strlen($id);
					if ($l < 2) $model = $model."0";
					$row_product[0]['model'] = $model.$id;
				}
				$row_product[0]['upc'] = "";				
				if (isset($row[$upc]) and $ad != 2 and $ad != 4) $row_product[0]['upc'] = $row[$upc];
				$row_product[0]['ean'] = "";				
				if (isset($row[$ean]) and $ad != 2 and $ad != 4) $row_product[0]['ean'] = $row[$ean];
				$row_product[0]['mpn'] = "";				
				if (isset($row[$mpn]) and $ad != 2 and $ad != 4) $row_product[0]['mpn'] = $row[$mpn];
				$row_product[0]['ref'] = "";				
				if (isset($row[$ref]) and $ad != 2 and $ad != 4) $row_product[0]['ref'] = $row[$ref];
				$row_product[0]['seo_h1'] = 0;
				if (isset($row[23]) and $ad != 2 and $ad != 4) $row_product[0]['seo_h1'] = $row[23];
				$row_product[0]['seo_title'] = 0;
				if (isset($row[24]) and $ad != 2 and $ad != 4) $row_product[0]['seo_title'] = $row[24];
				$row_product[0]['meta_keyword'] = 0;
				if (isset($row[25]) and $ad != 2 and $ad != 4) $row_product[0]['meta_keyword'] = $row[25];
				$row_product[0]['meta_description'] = 0;
				if (isset($row[26]) and $ad != 2 and $ad != 4) $row_product[0]['meta_description'] = $row[26];
				$row_product[0]['tag'] = 0;
				if (isset($row[27]) and $ad != 2 and $ad != 4) $row_product[0]['tag'] = $row[27];
				$row_product[0]['url'] = '';
				if (isset($row[28]) and $ad != 2 and $ad != 4) $row_product[0]['url'] = $row[28];				
				
				$row_product[0]['date_modified'] = date('Y-m-d H:i:s');
				
				$this->putProductBySKU($row[$cod], $row_product, $updte, $upname, $max_attr, $attr_ext, $row, $tags, $addseo,  $upurl, $umanuf);
				
				if (!empty($related)) {
					$related_val = explode(";" , $row[$related]);
					foreach ($related_val as $val) {						
						$rows = $this->getProductBySKU($val);
						if (isset($rows) and !empty($rows)) {
							$related_id = $rows[0]['product_id'];
							$rows = $this->getRalated($row_product[0]['product_id'], $related_id);
							if (isset($rows) and empty($rows)) $this->addRelated($row_product[0]['product_id'], $related_id);

							$rows = $this->getRalated($related_id, $row_product[0]['product_id']);
							if (isset($rows) and empty($rows)) $this->addRelated($related_id, $row_product[0]['product_id']);
							
						}	
					}
				}
	/*****************************************************************************************/							
			} else if (!$product_found) {			

				if ($ad == 0 or $ad == 2) {						
					$err = " Row ~= " . $row_count . " SKU = " . $row[$cod] . " not found in store. " . " \n";
					$this->adderr($err);
				}
				
				$row_product[0]['cat_name'] = $text_cat;
				$row_product[0]['category_id'] = '';
				
				if ($flag) {
					$row_product[0]['category_id'] = $category_id[$i];
					$catmany[0] = $category_id[$i];
				} else {
					$row_product[0]['category_id'] = $my_cat;
					$catmany[0] = $my_cat;
					$report = $report."Category was set by default ";
				}
				
				$row_product[0]['manufacturer_id'] = '0';
				$name = '0';
				$row_product[0]['manuf_name'] = '';
				
				if (isset($row[$manuf]) and !empty ($row[$manuf])) $name = trim($row[$manuf]);
				else {
					if ($my_manuf) {
						$rows = $this->getManufacturerName($my_manuf);
						$name = $rows[0]['name'];
					}	
				}
				$name = str_replace('ООО' , '' , $name);		
				$name = str_replace('ТОВ' , '' , $name);
				$name = $this->Code($name);
				$name = str_replace("\\" , '' , $name);
				$name = trim($name);
				$row_product[0]['manuf_name'] = $name;
				
				$rows  = $this->getManufacturerID($name);				
				
				if(!empty($rows) and $rows[0]['manufacturer_id'] != 0) {
					$row_product[0]['manufacturer_id'] = $rows[0]['manufacturer_id'];
				} else {
					if ($pmanuf and $name and ($ad == 1 or $ad == 3)) {
						$data['name'] = $name;
						$data['sort_order'] = '0';
						$data['manufacturer_store'] = '0';						
						$this->addManufacturer($data, $langs, $last_id);
						$row_product[0]['manufacturer_id'] = $last_id;
						$report = $report."Manufacturer ".$name." was created ";
					} else {
						if ($my_manuf and ($ad == 1 or $ad == 3)) {
							$row_product[0]['manufacturer_id'] = $my_manuf;
							$report = $report."Manufacturer was set by default";											
						} else {
							if ($ad == 1 or $ad == 3) {							
								$err = " Warning. Row ~= " . $row_count . " SKU = " . $row[$cod] . " Manufacturer: '". $name. "' not found \n";
								$this->adderr($err);
							}	
						}						
					}
				}

				$max_id = $this->getMaxID();
				$max_model = $max_id['max(product_id)'];				
				$max_model = $max_model + 1;
				$max_model = $max_model."-";
				$l = strlen($id);
				if ($l < 2) $max_model = $max_model."0";
				$max_model = $max_model.$id;
				
				$row_product[0]['model'] = $max_model;				 
				$row_product[0]['sku'] = $row[$cod];
				$row_product[0]['lang'] = $lang;				
	
				if ($exsame and isset($row[$cod]) and !empty($row[$cod])) {
				
					if (!empty($item) and preg_match('/^[0-9]+$/', $item)) $pname = $row[$item];
					else {
						if (!empty($item) and !preg_match('/^[0-9]+$/', $item) and empty($pname) and isset($row[$parsi])) {
							$pname = "";
							$url = $this->checkurl($row[$parsi]);
							if ($url != -1) {							
								if (strlen($ht) < 1024 or $parsed != $parsi) $ht = $this->curl_get_contents($url, 0);
								if (strlen($ht) > 1024) {
									$parsed = $parsi;
									$pname = $this->ParsName($ht, $item, $pointi, $placei);
									if (strlen($pname) < 2) {
										$err =  " Parsing Product Name error: Row ~= " . $row_count . " url = ". $url. " \n";
										$this->adderr($err);
										$pname = "";
									}	
								} else {									
									$err =  " Parsing Product Name error: Row ~= " . $row_count . " url = ". $url. " Site no answer \n";
									$this->adderr($err);								
								}							
							}					
						}					
					}
					if (!empty($pname))
					$this->Same($row[$cod], $pname, $row_product[0]['category_id'], $row_product[0]['manufacturer_id'], $row[$price]);
					
					continue;
				}
				
				if ($ad == 0 or $ad == 2) continue;
					
				if ($catcreate and empty($catmany)) {					
					$err =  " The Product has not been added: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Can not create category(s) \n";
					$this->adderr($err);
					continue;
				}

				if (!$flag and empty($my_cat) and !$catcreate) {					
					$err =  " The Product has not been added: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Category: '".$text_cat."' not found in your settings (see page 'Data')\n";
					$this->adderr($err);
					continue;
				}
				
				if (empty($row[$cat]) and empty($my_cat)) {					
					$err =  " The Product has not been added: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Product category not found in price-list\n";
					$this->adderr($err);
					continue;
				}				
				
				if (empty($pic_ext) and empty($my_photo) and empty($parsk)) {					
					$err =  " The Product has not been added: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Please, set picture column \n";
					$this->adderr($err);
					continue;				
				}
				
				$p = strpos($max_model, "-");
				$papka = substr($max_model, $p-1, 1);
								
				$photo_default = 0;								
				$nolink = 0;
				$nojpg = 0;
				$pictures ='';
				$pi = explode(",", $pic_ext);
				if (!empty($parsk)) {
					$pictures[0] = $parsk;
					$m = 0;
					for ($l=1; $l<20; $l++) {
						if (!isset($pi[$m])) break;							
						$pictures[$l] = $pi[$m];
						$m++;
					}
				} else $pictures = $pi;
	
				$pic = $pictures[0];
				if (!empty ($row[$pic])) {
					if (!substr_count($row[$pic], "/")) $nolink = 1;
					$url = $row[$pic];
					if (!$nolink) $url = $this->checkurl($row[$pic]);					
					if ($url == -1) {						
						if ($my_photo) {
							$url = $my_photo;
							$photo_default = 1;
							$nolink = 0;
						} else {						
							$err =  " The Product has not been added: Row ~= " . $row_count . " SKU = " . $row[$cod] ." Invalid picture link\n";
							$this->adderr($err);							
							continue;
						}	
					}					
					$a = strlen($url)-6;
					$en = substr($url, $a);
					if (strlen($url) > 4 and !stripos($en, '.jpg') and !stripos($en, '.png') and !stripos($en, '.jpeg') and !stripos($en, '.gif') and $url != -1 and $parsk) {							
						
						$fname = "photo";
						$marks = explode(",", $my_mark);
						if (isset($marks[0]) and !empty($marks[0])) {													
							$fname = $marks[0];
						} else {						
							if (isset($row[$manuf]) and !empty($row[$manuf])) {
								$fname = $row[$manuf];							
								$fname = substr($fname, 0, 16);
							}
						}							
					
						if ((empty ($row[$manuf]) or !isset($row[$manuf])) and (!isset($my_mark) or empty ($my_mark))) {	
							if ($my_photo) {
								$url = $my_photo;
								$photo_default = 1;
								$nolink = 0;
							} else {									
								$err =  " Photo can not be found: Row ~= " . $row_count . " SKU = " . $row[$cod] ." Please, set  Manufacturer or keyword \n";
								$this->adderr($err);							
								continue;								
							}
						}							
						$nojpg = 1;
						$seeks = explode(",", $warranty);
						$seek = $seeks[0];
						if (strlen($ht) < 1024 or $parsed != $parsk) $ht = $this->curl_get_contents($url, 0);
						if (strlen($ht) > 1024) {
							$parsed = $parsk;								
							$key = '';
							$url = $this->ParsPic($ht, $url, $key, $seek, $fname);
							if ($this->checkurl($url) == -1) {
								if (empty($my_photo)) {
									$err =  " Parsing main photo error: Row ~= " . $row_count . " url = ". $url. " Check your settings \n";
									$this->adderr($err);
									continue;	
								}														
								$url = $my_photo;
								$photo_default = 1;
								$nolink = 0;
							}	
						} else {
							if (empty($my_photo)) {
								$err =  " The Product was passed: Row ~= " . $row_count . " url = ". $url. " Site no answer \n";
								$this->adderr($err);
								$row_count = $this->putsos((int)$row_count);
								if ($row_count < 0) return 5;
								continue;
							}	
							$url = $my_photo;
							$photo_default = 1;
							$nolink = 0;
						}										
	
						if (!$url) {
							$row_product[0]['image'] = '';							
							if (!empty($my_photo)) {
								$url = $my_photo;
								$photo_default = 1;
								$nolink = 0;
							} else {					
								$err =  " The Product has not been added: Row ~= " . $row_count . " SKU = " . $row[$cod] ." Photo not found on the site: " . $url." Check your setting field in form: 'location photo'"." keywords = ".$fname." seek = ".$seek."\n";
								$this->adderr($err);								
								continue;
							}
						}  					
							
					} else {						
						if (strlen($url) < 5) {					
							$row_product[0]['image'] = '';							
							if ($my_photo) {
								$url = $my_photo;
								if ((strlen($url) < 3) or (!stristr($url, '.jpg') and !stristr($url, '.png') and !stristr($url, '.jpeg') and !stristr($url, '.gif'))) {
									$err =  " The Product has not been added: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Default link: " . $url. " too short "." \n";
									$this->adderr($err);								
									continue;
								}
							} else {					
								$err =  " The Product has not been added: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Link: " . $url. " too short "." \n";
								$this->adderr($err);								
								continue;
							}	
						}
					}					
					$rout = 0;
					$try = "";					
					if (!$nolink) $url = $this->checkurl($url);		
					if ($url != -1) {
						if ($nolink) {
							$nom = stripos($url, ".j");
							if (!$nom) $nom = stripos($url, ".png");
							if (!$nom) $nom = stripos($url, ".gif");
							$a = strlen($url);
							if (!$nom or $a - $nom > 5) {
								$se = ".jpg";
								$nom = $a;
							} else $se = substr($url, $nom);	
							$app = substr($url, 0, $nom);
							$nom = strrpos($app, ".");
							$app = substr($app, $nom);
							$app = $this->TransLit($app);							
							$app = $this->MetaURL($app);							
							$try = "../image/data/".$url;							
							
							if (file_exists($try)) {						
								if (!empty ($pic_int[$i]))	{
									$spath = "../image/data/" .$pic_int[$i]."/";
									$path = "../image/data/" .$pic_int[$i]."/".$papka."/";
									$spic_addr = "data/".$pic_int[$i]."/".$app.$se;
									$pic_addr = "data/".$pic_int[$i]."/".$papka."/".$app.$se;				
								} else {
									$err =  " Please, set folder for photo on page Data. Row ~= " . $row_count ." The Product was passed" . " \n";
									$this->adderr($err);
									continue;
								}		
								if (!is_dir($spath)) {											
									$err =  " Photo has not been updated: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Folder: " . $path. "  not found \n";
									$this->adderr($err);
									continue;
								}
								if (!is_dir($path)) @mkdir($path, 0755);
								$path = $path.$app.$se;
								$a = @copy ($try, $path);
								if (!$a) {
									$a = @copy ($try, $spath);
									$pic_addr = $spic_addr;
								}	
								$row_product[0]['image'] = $pic_addr;			
								$rout = 1;
							} else $photo_default = 1;		
						}					
						if (!$rout) {
							$nom = stripos($url, ".j");
							if (!$nom) $nom = stripos($url, ".png");
							if (!$nom) $nom = stripos($url, ".gif");
							$a = strlen($url);
							if (!$nom or $a - $nom > 5) {
								$se = ".jpg";
								$nom = $a;
							} else $se = substr($url, $nom);	
							$app = substr($url, 0, $nom);
							$nom = strrpos($app, ".");
							$app = substr($app, $nom+3);
							$app = $this->TransLit($app);
							$nom = strlen($app);
							if ($nom > 40) $app = substr($app, $nom-40, 40);
							if ($nom < 2) $app = rand(0, 9999);		
							
							$app = $this->MetaURL($app);							
							if (!empty ($pic_int[$i]))	{
								$spath = "../image/data/" .$pic_int[$i]."/";
								$path = "../image/data/" .$pic_int[$i]."/".$papka."/";
								$spic_addr = "data/".$pic_int[$i]."/".$app.$se;
								$pic_addr = "data/".$pic_int[$i]."/".$papka."/".$app.$se;				
							} else {
								$err =  " Please, set folder for photo on page Data. Row ~= " . $row_count ." The Product was passed" . " \n";
								$this->adderr($err);
								continue;
							}		
							if (!is_dir($spath)) {											
								$err =  " Photo has not been updated: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Folder: " . $path. "  not found \n";
								$this->adderr($err);
								continue;
							}
							if (!is_dir($path)) @mkdir($path, 0755);		
							$path = $path.$app.$se;			
							$row_product[0]['image'] = $pic_addr;
							if (!file_exists($path)) {
								$pict = $this->curl_get_contents($url, 1);								
								if (!$this->isPicture($pict)) {									
									$err =  " Download main photo fails. Url: ". $url . " Row ~= " . $row_count . " SKU = " . $row[$cod] . " I'l try insert default photo \n";
									$this->adderr($err);
									$photo_default = 1;
								} else {
									$bytes = @file_put_contents($path, $pict);
									if (!$bytes) {
										$bytes = @file_put_contents($spath, $pict);
										$row_product[0]['image'] = $spic_addr;
									}	
									if (!$bytes) {										
										$err =  " The Product has not been added: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Link in price-list: ". $row[$pic]. " patch = ".$path." url = ".$url." is not available \n";
										$this->adderr($err);										
										continue;
									}	
								}	
							}
						}
					}
				}	// new
	
				if (empty ($row[$pic])) $photo_default = 1;
				if ($photo_default) {
					if ($my_photo) {						
						$url = $my_photo;											
						$ff = $url;										
						$ff = strrchr($ff, "/");					
						$nom = stripos($ff, ".");
						$sb = substr($ff, 1, $nom-1);
						$se = substr($ff, $nom);
						$pic_name = $sb.$se;
						
						if (!empty ($pic_int[$i]))	{
							$spath = "../image/data/" .$pic_int[$i]."/";
							$path = "../image/data/" .$pic_int[$i]."/".$papka."/";
							$spic_addr = "data/".$pic_int[$i]."/".$pic_name;
							$pic_addr = "data/".$pic_int[$i]."/".$papka."/".$pic_name;				
						} else {
							$err =  " Please, set folder for photo on page Data. Row ~= " . $row_count ." The Product was passed" . " \n";
							$this->adderr($err);
							continue;
						}		
						if (!is_dir($spath)) {											
							$err =  " Photo has not been updated: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Folder: " . $path. "  not found \n";
							$this->adderr($err);
							continue;
						}
						if (!is_dir($path)) @mkdir($path, 0755);
						$path = $path.$pic_name;					
						$row_product[0]['image'] = $pic_addr;
						if (!file_exists($path)) {
							$pict = $this->curl_get_contents($url, 1);
							if (!$this->isPicture($pict)) {								
								$err =  " Download default photo fails. Url: ". $url . " Row ~= " . $row_count . " SKU = " . $row[$cod] ." \n";
								$this->adderr($err);
								continue;
							}
							$bytes = @file_put_contents($path, $pict);
							if (!$bytes) {
								$bytes = @file_put_contents($spath, $pict);
								$row_product[0]['image'] = $spic_addr;
							}
							if (!$bytes) {								
								$err =  " Defaul photo has not been added: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Default link: ". $row[$pic]. " patch = ".$path." url = ".$url." is not available \n";
								$this->adderr($err);								
								continue;
							}
						}						
					} else {						
						$err =  " Any photo not found: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Default photo expected \n";
						$this->adderr($err);
						continue;
					}	
				}	
	
				if ($photo_default > 0) $report = $report."Photo was set by default ";				
				
				if (isset($row[$weight]))				
					$row_product[0]['weight'] = $row[$weight];
				else $row_product[0]['weight'] = 0;				
				
				if (isset($row[$length]))
					$row_product[0]['length'] = $row[$length];
				else $row_product[0]['length'] = 0;	
				
				if (isset($row[$width]))
					$row_product[0]['width'] = $row[$width];
				else $row_product[0]['width'] = 0;	
				
				if (isset($row[$height]))
					$row_product[0]['height'] = $row[$height];
				else $row_product[0]['height'] = 0;
				
				if (isset($row[$sorder]))
					$row_product[0]['sort_order'] = $row[$sorder];
				else $row_product[0]['sort_order'] = 0;				
				
				$row_product[0]['quantity'] = 0;
				
				$qus = explode("," , $qu);
				for ($k=0; $k<9; $k++) {
					$quant = 0;
					if (!isset($qus[$k])) break;
					$quk = $qus[$k];	
					if (isset($row[$quk]) and preg_match('/^[0-9]+$/', $row[$quk])) {
						$quant = (int)$row[$quk];		
					} else {
						if (!empty($my_qu)) {
							if (substr_count($my_qu, "=")) {												
								$t = explode("," , $my_qu);
								foreach ($t as $value) {
									if (isset($value)) {
										$m = explode("=" , $value);
										if (isset($row[$quk]) and isset($m[0]) and isset($m[1]) and preg_match('/^[0-9]+$/', $m[1])) {
											if ($m[0] == trim($row[$quk])) {
												$quant = (int)$m[1];												
											}
										}
									}
								}
							}
						} 					
					}			
					$row_product[0]['quantity'] = $row_product[0]['quantity'] + $quant;
				}	
				
				if (!$row_product[0]['quantity'] and preg_match('/^[0-9]+$/', $my_qu)) {
					$row_product[0]['quantity'] = $my_qu;
					$report = $report."Quantity was set by default ";
				} else {	
					if (!$row_product[0]['quantity']) $report = $report."Quantity = 0 ";				
					else if ($row_product[0]['quantity'] > 0) $report = $report."Quantity was found ";
				}
				
				$row_product[0]['hide'] = 1;
				if (!$hide) $row_product[0]['hide'] = 0;
				else if ($off and $row_product[0]['quantity'] == 0) $row_product[0]['hide'] = 0;
				
				$plus = 0;				
				$row[$price] = $row[$price]*$rate;  // сначала, умножаем на курс	
								
				if (!$flag and !$cprice and $my_cat and empty($myplus)) {								
					$rows = $this->getMargin($id, $my_cat);					
					if (!isset($rows) or empty($rows)) {						
						$err =  " Warning: cannot set Margin. Row ~= " . $row_count . " SKU = " . $row[$cod] . " because  category was not found on page Data \n";
						$this->adderr($err);							
					} else {					
						$plus = $rows[0]['cat_plus'];
						$report = $report."Margin was set by default category ";
					}
				} else {
					if (!empty($row[$myplus]) and preg_match('/^[-0-9,.]+$/', $row[$myplus])) {		
						$plus = str_replace(',','.',$row[$myplus])+0.01-0.01;
						$report = $report."Margin was set manualy ";
					} else {
						if ($cprice and $cat_plus[$i] == 0 and (empty($row[$myplus]) or !preg_match('/^[-0-9,.]+$/', $row[$myplus]))) {
							$doll = $row[$price]/$rate + 0.01 - 0.01;	// переведем цену в доллары					
					
				// Таблица наценок. Зависит от цены товара в долларах. $m - множитель 
		
							if ($doll > 500.00) $m = 1.01;   // 1%
							if ($doll <= 500.00) $m = 1.05;  // пол процента
							if ($doll <= 200.00) $m = 1.06;
							if ($doll <= 100.00) $m = 1.1;			
							if ($doll <= 50.00) $m = 1.07;	
							if ($doll <= 30.00) $m = 1.15;
							if ($doll <= 20.00) $m = 1.2;
							if ($doll <= 10.00) $m = 1.35;
							if ($doll <= 5.00) $m = 1.4;
							if ($doll <= 4.00) $m = 1.5;
							if ($doll <= 3.00) $m = 1.6;
							if ($doll <= 2.00) $m = 1.7;
							if ($doll <= 1.40) $m = 1.8;
							if ($doll <= 1.20) $m = 1.9;
							if ($doll <= 1.00) $m = 2.0;	// 100 процентов				
					
							$plus = 100*($m-1);
							$report = $report."Margin was set by formula ";
								
						} else {				
							if (!empty($cat_plus[$i])) {		
								if (preg_match('/^[-0-9,.]+$/', $cat_plus[$i])) {
									$plus = str_replace(',','.',$cat_plus[$i]);
								} else {
									$pj = explode(",", $cat_plus[$i]);
									for ($j=0; $j<60; $j++) {
										if (!isset($pj[$j])) break;
										if (!substr_count($pj[$j], "(")) continue;
										if (!substr_count($pj[$j], ")")) continue;
										$pj[$j] = str_replace('(','',$pj[$j]);		
										$p = strpos($pj[$j], ')');
										if (!$p) continue;
										$d = substr($pj[$j], 0, $p);
										$p12 = explode("-", $d);
										$p1 = trim($p12[0]);
										$p2 = trim($p12[1]);
										if ($row[$price] >= $p1 and $row[$price] <= $p2) {
											$plus = substr($pj[$j], $p+1);
											$plus = trim($plus);
											break;
										}
									}	
								}
							if ($plus != 0) $report = $report."Margin was added success ";
							}	
						}
					}
				}
				if ($ignore_margin) $plus = 0;
				$new_price = $row[$price] + ($row[$price] * $plus/100);
					
				$n = round($new_price, 2); 	// округление цены до копеек, 2 цифры после запятой
				if ($plus == 0) $report = $report."Margin = 0 ";
				$row_product[0]['price'] = round($new_price,2);						
				
				$row_product[0]['date_added'] = date('Y-m-d H:i:s');
				$row_product[0]['date_available'] = date('Y-m-d H:i:s');				
				$row_product[0]['shipping'] = 1;
				
				$stat = 7;
				if ($st_status == 2) $stat = 6;
				if ($st_status == 3) $stat = 8;
				if ($st_status == 4) $stat = 5;
				$row_product[0]['stock_status_id'] = $stat;

				$text =	'';
				$pname = '';
				$row_product[0]['description'] = '';
				if (!empty($descrip) and preg_match('/^[0-9]+$/', $descrip) and !empty($row[$descrip])) 
					$row_product[0]['description'] = trim($row[$descrip]);
				
				if (isset($row[$item]) and !empty($row[$item]) and preg_match('/^[0-9]+$/', $item))
				    $pname = trim($row[$item]);	
	
				if (!preg_match('/^[0-9]+$/', $descrip) and isset($row[$parsd])) {					
					$url = $this->checkurl($row[$parsd]);
					if ($url != -1) {							
						if (strlen($ht) < 1024 or $parsed != $parsd) $ht = $this->curl_get_contents($url, 0);
						if (strlen($ht) > 1024) {
							$parsed = $parsd;
							$text = $this->ParsDescription($ht, $descrip, $pointd, $placed);
							if (strlen($text) < 10) $text = '';			
						} else {
							$parsed = '';
							$err =  " The Product was passed: Row ~= " . $row_count . " url = ". $url. " Site no answer \n";
							$this->adderr($err);										
						}					
					}
				}	
				if (!preg_match('/^[0-9]+$/', $item) and isset($row[$parsi])) {
					$url = $this->checkurl($row[$parsi]);
					if ($url != -1) {							
						if (strlen($ht) < 1024 or $parsed != $parsi) $ht = $this->curl_get_contents($url, 0);
						if (strlen($ht) > 1024) {
							$parsed = $parsi;
							$pname = $this->ParsName($ht, $item, $pointi, $placei);
							if (strlen($pname) < 2) {
								$err =  " Parsing Product Name error: Row ~= " . $row_count . " url = ". $url. " Check your settings \n";
								$this->adderr($err);								
								continue;
							}	
						} else {
							$parsed = '';
							$err =  " The Product was passed: Row ~= " . $row_count . " url = ". $url. " Site no answer \n";
							$this->adderr($err);										
						}						
					}								
				}	
		
				if (!empty($pname)) $row_product[0]['item'] = $pname;
						
				if (!empty($my_descrip) and empty($row_product[0]['description']) and empty($text)) {
					if (!preg_match('/^[0-9]+$/', $my_descrip)) $row_product[0]['description'] = $my_descrip;
					else if (!empty($row[$my_descrip])) $row_product[0]['description'] = $row[$my_descrip];
					$report = $report."Description set by default ";
				} else {
					if (empty($my_descrip) and empty($row_product[0]['description']) and empty($text)) {
						$row_product[0]['description'] = "";
						$report = $report."No Description ";
					} else {
						if (!empty($text) and !empty($my_descrip) and preg_match('/^[0-9]+$/', $my_descrip) and !empty($row[$my_descrip])) $row_product[0]['description'] = $row[$my_descrip] . "&lt;br&gt;&lt;br&gt;". $text;	
					    else if (!empty($text)) $row_product[0]['description'] = $text;						
					}					
				}	
				
				$row_product[0]['subtract'] = $minus;
				$row_product[0]['upc'] = "";				
				if (isset($row[$upc])) $row_product[0]['upc'] = $row[$upc];
				$row_product[0]['ean'] = "";				
				if (isset($row[$ean])) $row_product[0]['ean'] = $row[$ean];
				$row_product[0]['mpn'] = "";				
				if (isset($row[$mpn])) $row_product[0]['mpn'] = $row[$mpn];
				$row_product[0]['ref'] = "";				
				if (isset($row[$ref])) $row_product[0]['ref'] = $row[$ref];
				$row_product[0]['seo_h1'] = 0;
				if (isset($row[23])) $row_product[0]['seo_h1'] = $row[23];
				$row_product[0]['seo_title'] = 0;
				if (isset($row[24])) $row_product[0]['seo_title'] = $row[24];
				$row_product[0]['meta_keyword'] = 0;
				if (isset($row[25])) $row_product[0]['meta_keyword'] = $row[25];
				$row_product[0]['meta_description'] = 0;
				if (isset($row[26])) $row_product[0]['meta_description'] = $row[26];
				$row_product[0]['tag'] = 0;
				if (isset($row[27])) $row_product[0]['tag'] = $row[27];
				$row_product[0]['url'] = '';
				if (isset($row[28])) $row_product[0]['url'] = $row[28];
				
				$report = $report."Product was added ";					

				$this->putNewProduct($row_product, $parent, $last_product_id, $attr_ext, $max_attr, $langs, $row, $tags, $addseo, $catmany, $catcreate, $newurl, $refers);
				
				if (!isset($last_product_id) or !$last_product_id) {					
					$err =  " Database write error Row ~= " . $row_count . " SKU = " . $row[$cod] . " \n";
					$this->adderr($err);
					continue;
				}
				
				$last_sku_id = 0;
				$this->addProductToTable($last_product_id, $row_product[0]['sku'], $last_sku_id);
				if (!empty($row[$sku2])) $this->addSkuToTable($row[$sku2], $last_sku_id);
				$er = 0;
				if ($max_attr and $upattr != 4) {					
					for ($j = 1; $j <= $max_attr; $j++) {					
						$at = $attribute_id[$j];
						$col = explode(",", $attr_ext[$j]);
						if (!empty($col[0]) and preg_match('/^[0-9]+$/', $col[0])) {
							if ($at == 0 and !empty($row[$col[0]-1])) {								
								$rows = $this->getAttributeID($row[$col[0]-1]);								
								if (isset($rows[0]['attribute_id'])) $at = $rows[0]['attribute_id'];
								if ($upattr == 1 or $upattr == 2) {
									$data['text1'] = $row[$col[0]-1];
									$data['text2'] = '';
									if (isset($col[1]) and !empty($col[1])) $data['text2'] = $row[$col[1]-1];
									$this->createAttribute($data, $attID, $langs);
									$at = $attID;
									if (!$at) {
										$er = 1;
										break;
									}								
								}
								if (!$at) continue;
							}					
							if (isset($row[$col[0]]) and !empty($row[$col[0]])) {
								$t = $this->symbol($row[$col[0]]);
								$t = trim($t);
								$data['text1'] = $t;
								$t = '';
								if (isset($col[1]) and !empty($col[1])) $t = $this->symbol($row[$col[1]]);
								$t = trim($t);
								$data['text2'] = $t;
								$data['product_id'] = $last_product_id;
								$data['attribute_id'] = $at;
								$this->putAttributeById($data, $langs);								
							}								
						} else {											
							if (isset($row[$parsi])) $url = $this->checkurl($row[$parsi]);
							else $url = -1;
							if ($url != -1) {	
								if (strlen($ht) < 1024 or $parsed != $parsi) $ht = $this->curl_get_contents($url, 0);
								if (strlen($ht) > 1024) {
									$parsed = $parsi;
									$this->ParsAttribute($ht, $attr_ext[$j], $attr_point[$j], $text);
								} else {
									$parsed = '';
									$text = '';										
								}	
														
								if (!empty ($text)) {
									foreach ($text as $t) {
										if (empty ($t['name']) or empty ($t['val'])) continue;
										if (strlen($t['name'] > 64)) {
											$err =  " Attribute: ". $t['name'] . " is incorrect \n";
											$this->adderr($err);
											continue;
										}	
										$rows = $this->getAttributeID($t['name']);										
										if (empty($rows)) {
										    if ($upattr == 1 or $upattr == 2) {									
												$data['text1'] = $t['name'];
												$data['text2'] = '';
												$this->createAttribute($data, $attID, $langs);
												$at = $attID;											
												if (!$at) $report = $report." Attribute: ". $t['name'] . " was created \n";
											} else continue;	
										} else 	$at = $rows[0]['attribute_id'];									
																			
										$data['product_id'] = $last_product_id;
										$data['text1'] = $t['val'];
										$data['text2'] = '';
										$data['attribute_id'] = $at;										
										$this->putAttributeById($data, $langs);										
									}
								} else {
									$err =  "Row ~= " . $row_count . " SKU = " . $row[$cod] . " Attribute parse error \n";
									$this->adderr($err);
								}								
							}
						} 						
					}
					if ($er) {
						$err =  "Language 2 is not provided in the Store \n";
						$this->adderr($err);
					}	
				}				
				
				if ($max_opt) {
					for ($j = 1; $j <= $max_opt; $j++) {
						if (!$option_id[$j] or !isset($row[$opt[$j]]) or empty($row[$opt[$j]])) continue;
						$rows = $this->getOptionsById($option_id[$j]);	
						if (!$rows) continue;						
												
						$opt_val = explode(";" , $row[$opt[$j]]);
		
						if (isset($row[$ko[$j]])) $opt_ko = explode(";" , $row[$ko[$j]]);
						if (isset($row[$po[$j]])) $opt_po = explode(";" , $row[$po[$j]]);
						if (isset($row[$prr[$j]])) $opt_pr = explode(";" , $row[$prr[$j]]);
						if (isset($row[$we[$j]])) $opt_we = explode(";" , $row[$we[$j]]);		
		
						for ($l=0; $l<30; $l++) {
							$e = false;
							if (empty($opt_val[$l]) and !isset($opt_val[$l+1])) break;							
							foreach ($rows as $r) {
								if ($r['name'] == $opt_val[$l]) {
									$e = true;
									$data_option['op_val_id'] = $r['option_value_id'];
									break;
								}	
							}
							if (!$e) {
								if ($addopt and !empty($opt_val[$l])) {
									$this->addValue($option_id[$j], $ovid);									
									$this->addValueDescription($option_id[$j], $ovid, $opt_val[$l], $langs);
									$data_option['op_val_id'] = $ovid;
									$report = $report."Option value ".$opt_val[$l]." was added";
								} else {									
									$err =  " The Option value: '". $opt_val[$l] . "' not found in Store.  Row ~= " . $row_count . " SKU = " . $row[$cod] . " Please, set this Option value \n";
									$this->adderr($err);
									continue;
								}
							}
							$data_option['opt'] = $opt_val[$l];
							
							$data_option['ko'] = 0;							
							if (isset($opt_ko[$l]) and !empty($opt_ko[$l])) $data_option['ko'] = $opt_ko[$l];				
							
							$data_option['pr'] = 0;
							$data_option['pr_prefix'] = '+';
							if (isset($opt_pr[$l]) and !empty($opt_pr[$l])) {
								$e = substr($opt_pr[$l], strlen($opt_pr[$l])-1, 1);
								if ($e == '+' or $e == '-' or $e == '=' or $e == '%' or $e == '*' or $e == '#') {
									$data_option['pr_prefix'] = $e;								
									$b = substr($opt_pr[$l], 0, strlen($opt_pr[$l])-1);
								} else 	$b = substr($opt_pr[$l], 0, strlen($opt_pr[$l]));
								if (preg_match('/^[0-9.,]+$/', $b)) $data_option['pr'] = str_replace("," , ".", $b)*$rate;		
							}
							
							$data_option['po'] = 0;
							$data_option['po_prefix'] = '+';
							if (isset($opt_po[$l])) {
								$e = substr($opt_po[$l], strlen($opt_po[$l])-1, 1);
								if ($e == '+' or $e == '-' or $e == '=' or $e == '%' or $e == '*' or $e == '#') $data_option['po_prefix'] = $e;							
								$b = substr($opt_po[$l], 0, strlen($opt_po[$l])-1);
								if (preg_match('/^[0-9.,]+$/', $b)) $data_option['po'] = str_replace("," , ".", $b);		
							}
							
							$data_option['we'] = 0;
							$data_option['we_prefix'] = '+';
							if (isset($opt_we[$l]) and !empty($opt_we[$l])) {
								$e = substr($opt_we[$l], strlen($opt_we[$l])-1, 1);
								if ($e == '+' or $e == '-' or $e == '=' or $e == '%' or $e == '*' or $e == '#') $data_option['we_prefix'] = $e;								
								$b = substr($opt_we[$l], 0, strlen($opt_we[$l])-1);
								if (preg_match('/^[0-9.,]+$/', $b)) $data_option['we'] = str_replace("," , ".", $b);		
							}							
							
							$sub = 0;
							if (isset($row_product[0]['subtract'])) $sub = $row_product[0]['subtract'];
							$data_option['option_required'] = $option_required[$j];
							$this->upProductOption($last_product_id, $option_id[$j], $data_option, $sub);	
							
							$mas_opt[$j][$l][0] = $last_product_id;
							$mas_opt[$j][$l][1] = $option_id[$j];
							$mas_opt[$j][$l][2] = $data_option['op_val_id'];
							$mas_opt[$j][$l][3] = $ko[$j];
							$mas_opt[$j][$l][4] = $data_option['ko'];							
			/*				$mas_opt[$j][$l][5] = $data_option['pr'];							
							$mas_opt[$j][$l][6] = $data_option['po'];							
							$mas_opt[$j][$l][7] = $data_option['we'];	*/

						}	
					}					
					$gr_data = array();
					$gr_data ='';
					for ($l=0; $l<30; $l++) {
					$gr_data ='';
					if (!isset($mas_opt[1][$l][0])) break;
						$n = 0; $a = ''; $b = '';
						for ($j=1; $j<=$max_opt; $j++) {
							if (!isset($mas_opt[$j][$l][0])) continue;
							$m = 0;
							for ($k=1; $k<=$max_opt; $k++) {
								if (!isset($mas_opt[$k][$l][0])) continue;
								if ($mas_opt[$j][$l][3] == $mas_opt[$k][$l][3] and $j != $k and $a != $mas_opt[$j][$l][1] and $b != $mas_opt[$j][$l][2]) {								
									$a = $mas_opt[$j][$l][1];
									$b = $mas_opt[$j][$l][2];
									$n++;
									$m++;
									$gr_data[$n][0] = $l;
									$gr_data[$n][1] = $last_product_id;
									$gr_data[$n][2] = $mas_opt[$j][$l][1];
									$gr_data[$n][3] = $mas_opt[$j][$l][2];
									$gr_data[$n][4] = $mas_opt[$j][$l][4];
					/*				$gr_data[$n][5] = $mas_opt[$j][$l][5];
									$gr_data[$n][6] = $mas_opt[$j][$l][6];
									$gr_data[$n][7] = $mas_opt[$j][$l][7];	*/
									
								}
							}							
					
						}		
			
						if (!empty($gr_data)) $this->jOption($gr_data);
					}	
				}
				
				if (isset($gr_data)) $this->summaOption($last_product_id, $summa_options);
								
				// Добавление акционных цен
				if (isset($row[$spec]) and !empty($row[$spec])) {
					$data['product_id'] = $last_product_id;
					$data['customer_group_id'] = 1;
					$data['priority'] = 1;
					$pr = $row[$spec];
					$pr = str_replace(",", ".", $pr);
			// Удалить в колонке спец-цена цена лишний текст
					$pr = str_replace('руб.','',$pr);
					$pr = str_replace('р.','',$pr);				
					$pr = str_replace('грн.','',$pr);
					$pr = str_replace('гр.','',$pr);				
					$pr = str_replace('руб','',$pr);
					$pr = str_replace('р','',$pr);				
					$pr = str_replace('грн','',$pr);
					$pr = str_replace('гр','',$pr);
					$pr = str_replace(' ','',$pr);
					$pr = str_replace("'", "", $pr);
					if (!preg_match('/^[0-9.Ee-]+$/', $pr)) $pr = '';
					else $pr = $pr*$rate;					
					$data['price'] = $pr;
					$data['date_start'] = "2000-01-01";
					$data['date_end'] = "2040-01-01";
					if ($pr) $report = $report."Special price was added ";
					$this->putActionPrice($data);
				}

				$ff = 0;
				if (count($mprice) > 1) {   // Скидочные цены, скидки
					for ($j=1; $j<20; $j++) {
						if (!isset($mprice[$j])) break;
						if (empty($mprice[$j])) continue;
						$ff = 1;
						$data['product_id'] = $last_product_id;
						$data['customer_group_id'] = $j;
						$data['priority'] = 1;
						$pr = $row[$mprice[$j]];
						$pr = str_replace(",", ".", $pr);
			// Удалить в колонке спец-цена цена лишний текст
						$pr = str_replace('руб.','',$pr);
						$pr = str_replace('р.','',$pr);				
						$pr = str_replace('грн.','',$pr);
						$pr = str_replace('гр.','',$pr);				
						$pr = str_replace('руб','',$pr);
						$pr = str_replace('р','',$pr);				
						$pr = str_replace('грн','',$pr);
						$pr = str_replace('гр','',$pr);
						$pr = str_replace(' ','',$pr);
						$pr = str_replace("'", "", $pr);
						if (!preg_match('/^[0-9.Ee-]+$/', $pr)) $pr = '';
						else $pr = $pr*$rate;					
						$data['price'] = $pr;
						$data['quantity'] = $row_product[0]['quantity'];
						$data['date_start'] = "2000-01-01";
						$data['date_end'] = "2040-01-01";
						
						$this->putWholesale($data);
					}	
				}
				if ($ff) $report = $report."Wholesale price was added ";
				
				for ($k=1; $k<=$np; $k++) {		
					if (!isset($pictures[$k])) break;
					$nn = $pictures[$k];
					if (isset($row[$nn]) and !empty ($row[$nn])) {
						$nolink = 0;
						if (!substr_count($row[$nn], "/")) $nolink = 1;
						if (!$nolink) $url = $this->checkurl($row[$nn]);
						if ($url == -1) continue;
						if ($nolink) {
							$url = $row[$nn];
							$nom = stripos($url, ".j");
							if (!$nom) $nom = stripos($url, ".png");
							if (!$nom) $nom = stripos($url, ".gif");
							if (!$nom) $se = ".jpg";
							else $se = substr($url, $nom);							
							$app = substr($url, 0, $nom);
							$nom = strrpos($app, ".");
							$app = substr($app, $nom);
							$app = $this->TransLit($app);							
							$app = $this->MetaURL($app);							
							$try = "../image/data/".$url;
							if (file_exists($try)) {						
								if (!empty ($pic_int[$i]))	{
									$spath = "../image/data/" .$pic_int[$i]."/";
									$path = "../image/data/" .$pic_int[$i]."/".$papka."/";
									$spic_addr = "data/".$pic_int[$i]."/".$app.$se;
									$pic_addr = "data/".$pic_int[$i]."/".$papka."/".$app.$se;				
								} else {
									$err =  " Please, set folder for photo on page Data. Row ~= " . $row_count . " \n";
									$this->adderr($err);
									continue;
								}		
								if (!is_dir($spath)) {											
									$err =  " Additional photo has not been added: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Folder: " . $spath. "  not found \n";
									$this->adderr($err);
									continue;
								}
								if (!is_dir($path)) @mkdir($path, 0755);
								$path = $path.$app.$se;
								$a = @copy ($try, $path);
								if (!$a) {
									$a = @copy ($try, $spath);
									$pic_addr = $spic_addr;
								}	
								if ($a) {
									$rows = $this->getProductImage($last_product_id);
									$e = 1;										
									foreach ($rows as $p) {
										if ($p['image'] == $pic_addr) $e = 0;
									}	
									if ($e) $this->addPicture($last_product_id, $pic_addr);						
								}
							}
						} else {						
							$nom = stripos($url, ".j");
							if (!$nom) $nom = stripos($url, ".png");
							if (!$nom) $nom = stripos($url, ".gif");
							$a = strlen($url);
							if (!$nom or $a - $nom > 5) {
								$se = ".jpg";
								$nom = $a;
							} else $se = substr($url, $nom);	
							$app = substr($url, 0, $nom);
							$nom = strrpos($app, ".");
							$app = substr($app, $nom+3);
							$app = $this->TransLit($app);
							$nom = strlen($app);
							if ($nom > 40) $app = substr($app, $nom-40, 40);
							if ($nom < 2) $app = rand(0, 9999);					
						
							$app = $this->MetaURL($app);		
							if (!empty ($pic_int[$i]))	{
								$spath = "../image/data/" .$pic_int[$i]."/";
								$path = "../image/data/" .$pic_int[$i]."/".$papka."/";
								$spic_addr = "data/".$pic_int[$i]."/".$app.$se;
								$pic_addr = "data/".$pic_int[$i]."/".$papka."/".$app.$se;		
							} else {
								$err =  " Please, set folder for photo on page Data. Row ~= " . $row_count ." The Product was passed" . " \n";
								$this->adderr($err);
								continue;
							}		
							if (!is_dir($spath)) {											
								$err =  " Photo has not been updated: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Folder: " . $spath. "  not found \n";
								$this->adderr($err);
								continue;
							}
							if (!is_dir($path)) @mkdir($path, 0755);					
							$path = $path.$app.$se;
							if (!file_exists($path)) {
								$pict = $this->curl_get_contents($url, 1);
								if (!$this->isPicture($pict)) {								
									$err =  " Download additional photo fails. Url: ". $url . " Row ~= " . $row_count . " SKU = " . $row[$cod] ." \n";
									$this->adderr($err);
									continue;
								}
								$bytes = @file_put_contents($path, $pict);
								if (!$bytes) {
									$bytes = @file_put_contents($spath, $pict);
									$pic_addr = $spic_addr;
								}	
								if ($bytes) $this->addPicture($last_product_id, $pic_addr);	
							} else {
								$rows = $this->getProductImage($last_product_id);
								$e = 1;
								if (!empty ($rows)) {	
									foreach ($rows as $p) {
										if ($p['image'] == $pic_addr) $e = 0;
									}
								}
								if ($e) $this->addPicture($last_product_id, $pic_addr);										
							}			
						}
					}
				}
				if ($nojpg) {
					if (!empty($parsk) and isset($row[$parsk])) {
						$url = $this->checkurl($row[$parsk]);					
						if (strlen($ht) < 1024 or $parsed != $parsk) $ht = $this->curl_get_contents($url, 0);
						if (strlen($ht) < 1024) {										
							$err =  " Parsing additional photo error: Row ~= " . $row_count . " url = ". $url. " Check your settings \n";
							$this->adderr($err);										
							continue;
						}
					}
					$parsed = $parsk;
					for ($k=1; $k<=$ns; $k++) {						
						if (!isset($seeks[$k]) or empty($seeks[$k])) break;						
						$fname = "photo";
						if (isset($marks[$k]) and !empty($marks[$k])) {												
							$fname = $marks[$k];
						} else {						
							if (isset($row[$manuf]) and !empty($row[$manuf])) {
								$fname = $row[$manuf];								
								$fname = substr($fname, 0, 16);
							}
						}						
						$key = '';						 
						$urlp = $this->ParsPic($ht, $url, $key, $seeks[$k], $fname);		
						if ($urlp) {				
							$nom = stripos($urlp, ".j");
							if (!$nom) $nom = stripos($urlp, ".png");
							if (!$nom) $nom = stripos($urlp, ".gif");
							$a = strlen($urlp);
							if (!$nom or $a - $nom > 5) {
								$se = ".jpg";
								$nom = $a;
							} else $se = substr($urlp, $nom);	
							$app = substr($urlp, 0, $nom);
							$nom = strrpos($app, ".");
							$app = substr($app, $nom+3);
							$app = $this->TransLit($app);
							$nom = strlen($app);
							if ($nom > 40) $app = substr($app, $nom-40, 40);
							if ($nom < 2) $app = rand(0, 9999);					
							
							$app = $this->MetaURL($app);
							if (!empty ($pic_int[$i]))	{
								$spath = "../image/data/" .$pic_int[$i]."/";
								$path = "../image/data/" .$pic_int[$i]."/".$papka."/";
								$spic_addr = "data/".$pic_int[$i]."/".$app.$se;
								$pic_addr = "data/".$pic_int[$i]."/".$papka."/".$app.$se;		
							} else {
								$err =  " Please, set folder for photo on page Data. Row ~= " . $row_count ." The Product was passed" . " \n";
								$this->adderr($err);
								continue;
							}		
							if (!is_dir($spath)) {											
								$err =  " Photo has not been updated: Row ~= " . $row_count . " SKU = " . $row[$cod] . " Folder: " . $path. "  not found \n";
								$this->adderr($err);
								continue;
							}
							if (!is_dir($path)) @mkdir($path, 0755);
							$path = $path.$app.$se;							
							if (!file_exists($path)) {					
								$pict = $this->curl_get_contents($urlp, 1);
								if (!$this->isPicture($pict)) break;									
								$bytes = @file_put_contents($path, $pict);
								if (!$bytes) {
									$bytes = @file_put_contents($spath, $pict);
									$pic_addr = $spic_addr;
								}	
								if ($bytes) $this->addPicture($last_product_id, $pic_addr);
							} else {
								$rows = $this->getProductImage($last_product_id);
								$e = 1;
								if (!empty ($rows)) {	
									foreach ($rows as $p) {
										if ($p['image'] == $pic_addr) $e = 0;
									}
								}
								if ($e) $this->addPicture($last_product_id, $pic_addr);										
							}					
						} // !er				
					} // end for picture
				}	
			
				if (!empty($related)) {
					$related_val = explode(";" , $row[$related]);
					foreach ($related_val as $val) {						
						$rows = $this->getProductBySKU($val);
						if (isset($rows) and !empty($rows[0]['product_id'])) {
							$related_id = $rows[0]['product_id'];
							$rows = $this->getRalated($last_product_id, $related_id);
							if (isset($rows) and empty($rows)) $this->addRelated($last_product_id, $related_id);			
												
							$rows = $this->getRalated($related_id, $last_product_id);
							if (isset($rows) and empty($rows)) $this->addRelated($related_id, $last_product_id);
						
						}	
					}
				}
			}			
			
			if (!empty($report)) $this->addReport($report, $row_count, $row[$cod]);				
		}
		$path = "./uploads/sos.tmp";
		if (file_exists($path)) unlink ($path);
		
		if ($exsame) {
			$this->EndEx(7);
		}
		
		return 0;	
	}	
}
?>