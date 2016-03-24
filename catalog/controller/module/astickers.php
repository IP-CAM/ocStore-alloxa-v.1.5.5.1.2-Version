<?php
class ControllerModuleAStickers extends Controller {
	protected function index() {
		$this->data['settings'] = $this->getSettings();
		
		if (isset ($this->request->get['product_id'])) {
			$this->data['product_id'] = $this->request->get['product_id'];
		} else {
			$this->data['product_id'] = '';
		}
		
		$this->data['request_url'] = 'index.php?route=module/astickers/getAStickers';
		
		if (file_exists (DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/astickers.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/astickers.tpl';
		} else {
			$this->template = 'default/template/module/astickers.tpl';
		}
		
		$this->render();
	}
	
	public function getAStickers() {
		$settings = $this->getSettings();
		
		$products_id = $products_url_alias = $products_astickers = array ();
		
		if (isset ($this->request->post['id']) && is_array ($this->request->post['id'])) {
			foreach ($this->request->post['id'] as $index=>$id) {
				$products_id[$index] = (int) $id;
			}
		}
		
		if (isset ($this->request->post['ua']) && is_array ($this->request->post['ua'])) {
			foreach ($this->request->post['ua'] as $index=>$ua) {
				$products_url_alias[$index] = $this->db->escape(utf8_strtolower(urldecode ($ua)));
			}
		}
		
		if ($products_url_alias) {
			$query = $this->db->query('SELECT query, LCASE(keyword) AS keyword FROM ' . DB_PREFIX . 'url_alias WHERE keyword IN ("' . implode ('","', $products_url_alias) . '") AND query LIKE "product_id=%"');
			
			foreach ($query->rows as $data) {
				foreach ($products_url_alias as $index=>$keyword) {
					if ($keyword == $data['keyword']) {
						$products_id[$index] = (int) str_replace ('product_id=', '', $data['query']);
						unset ($products_url_alias[$index]);
					}
				}
			}
		}
		
		if ($products_id) {
			if ($this->customer->isLogged()) {
				$customer_group_id = $this->customer->getCustomerGroupId();
			} else {
				$customer_group_id = $this->config->get('config_customer_group_id');
			}
			
			$query = $this->db->query('SELECT p.product_id AS product_id, p.date_available AS date_available, p.quantity AS quantity, p.asticker_date_start AS date_start, p.asticker_date_end AS date_end, ast.images AS images, m.image AS manufacturer, ps.price AS special FROM ' . DB_PREFIX . 'product p LEFT JOIN ' . DB_PREFIX . 'astickers ast ON (ast.asticker_id = p.asticker_id) LEFT JOIN ' . DB_PREFIX . 'manufacturer m ON (m.manufacturer_id = p.manufacturer_id) LEFT JOIN ' . DB_PREFIX . 'product_special ps ON (ps.product_id = p.product_id AND ps.customer_group_id = "' . (int) $customer_group_id . '" AND ((ps.date_start = "0000-00-00" OR ps.date_start < NOW()) AND (ps.date_end = "0000-00-00" OR ps.date_end > NOW()))) WHERE p.product_id IN (' . implode (',', array_unique ($products_id)) . ') AND p.date_available <= NOW() AND p.status = "1" ORDER BY ps.priority DESC, ps.price DESC');
			
			$results = array ();
			
			foreach ($query->rows as $value) {
				$results[$value['product_id']] = array (
					'images'         => $value['images'],
					'quantity'       => $value['quantity'],
					'manufacturer'   => $value['manufacturer'],
					'special'        => $value['special'],
					'date_available' => $value['date_available'],
					'date_start'     => $value['date_start'],
					'date_end'       => $value['date_end']
				);
			}
			
			if ($results) {
				$positions = array ('tl' => 'top left', 'tc' => 'top center', 'tr' => 'top right', 'cl' => 'center left', 'cc' => 'center center', 'cr' => 'center right', 'bl' => 'bottom left', 'bc' => 'bottom center', 'br' => 'bottom right');
				
				$this->load->model('catalog/product');
				$this->load->model('tool/image');
				
				foreach ($products_id as $index=>$product_id) {
					$astickers = '';
					
					if (isset ($results[$product_id])) {
						$positions_status = array ('tl' => 1, 'tc' => 1, 'tr' => 1, 'cl' => 1, 'cc' => 1, 'cr' => 1, 'bl' => 1, 'bc' => 1, 'br' => 1);
						
						### System AStickers ###
						// Special
						if ($settings['special_status'] && $results[$product_id]['special'] && file_exists (DIR_IMAGE . $settings['special_image'])) {
							$astickers .= '<div class="asticker" style="background:url(' . HTTP_IMAGE . $settings['special_image'] . ') ' . $positions[$settings['special_position']] . ' no-repeat"></div>';
							$positions_status[$settings['special_position']] = 0;
						}
						// New
						if ($settings['new_status'] && file_exists (DIR_IMAGE . $settings['new_image'])) {
							$time = explode ('-', $results[$product_id]['date_available']);
							
							if (time () < (mktime (0, 0, 0, $time[1], $time[2], $time[0]) + ($settings['days_new'] * 86400))) {
								$astickers .= '<div class="asticker" style="background:url(' . HTTP_IMAGE . $settings['new_image'] . ') ' . $positions[$settings['new_position']] . ' no-repeat"></div>';
								$positions_status[$settings['new_position']] = 0;
							}
						}
						// Quantity
						if ($settings['quantity_status'] && $settings['quantity']) {
							foreach ($settings['quantity'] as $quantity) {
								if (($results[$product_id]['quantity'] >= $quantity['min']) && ($results[$product_id]['quantity'] <= $quantity['max'])) {
									$astickers .= '<div class="asticker" style="background:url(' . HTTP_IMAGE . $quantity['image'] . ') ' . $positions[$settings['quantity_position']] . ' no-repeat"></div>';
									$positions_status[$settings['quantity_position']] = 0;
									
									break;
								}
							}
						}
						// Manufacturer
						if ($settings['manufacturer_status'] && file_exists (DIR_IMAGE . $results[$product_id]['manufacturer'])) {
							$astickers .= '<div class="asticker" style="background:url(' . $this->model_tool_image->resize($results[$product_id]['manufacturer'], $settings['width'], $settings['height']) . ') ' . $positions[$settings['manufacturer_position']] . ' no-repeat"></div>';
							$positions_status[$settings['manufacturer_position']] = 0;
						}
						
						### Not System AStickers ###
						if ((date ('Y-m-d') >= $results[$product_id]['date_start']) && (date ('Y-m-d') <= $results[$product_id]['date_end']) || (($results[$product_id]['date_start'] == '0000-00-00') && ($results[$product_id]['date_end'] == '0000-00-00'))) {
							$images = unserialize ($results[$product_id]['images']);
							
							if ($images) {
								foreach ($positions as $position=>$value) {
									if ($positions_status[$position] && isset ($images[$position]) && file_exists (DIR_IMAGE . $images[$position])) {
										$astickers .= '<div class="asticker" style="background:url(' . HTTP_IMAGE . $images[$position] . ') ' . $value . ' no-repeat"></div>';
									}
								}
							}
						}
					}
					
					$products_astickers[$index] = $astickers;
				}
			}
		}
		
		header ('Content-type: text/html; charset=utf-8');
		
		echo json_encode ($products_astickers);/**/
	}
	
	private function getSettings() {
		$settings = $this->config->get('astickers_settings');
		
		$default = array ('class' => '.image', 'class_main_image' => '.fancybox', 'class_tabs' => '.htabs', 'min_width' => 40, 'min_height' => 40, 'hide_hover' => 1, 'show_effect' => 0, 'z_index' => 0, 'width' => 40, 'height' => 40, 'days_new' => 3, 'special_status' => 0, 'special_position' => 'tl', 'special_image' => 'data/astickers/special_top_left.png', 'new_status' => 0, 'new_position' => 'br', 'new_image' => 'data/astickers/new_bottom_right.png', 'quantity_status' => 0, 'quantity_position' => 'tr', 'manufacturer_status' => 0, 'manufacturer_position' => 'bl', 'quantity' => array (array ('min' => -1000, 'max' => 0, 'image' => 'data/astickers/quantity_0.png'), array ('min' => 1, 'max' => 50, 'image' => 'data/astickers/quantity_1.png'), array ('min' => 51, 'max' => 100, 'image' => 'data/astickers/quantity_2.png'), array ('min' => 101, 'max' => 150, 'image' => 'data/astickers/quantity_3.png'), array ('min' => 151, 'max' => 200, 'image' => 'data/astickers/quantity_4.png'), array ('min' => 201, 'max' => 1000, 'image' => 'data/astickers/quantity_5.png')));
		
		foreach ($default as $setting=>$value) {
			if (!isset ($settings[$setting])) {
				$settings[$setting] = $value;
			}
		}
		
		return $settings;
	}
}
?>