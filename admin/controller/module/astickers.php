<?php
class ControllerModuleAStickers extends Controller {
	private $error = array ();
	private $vars = array ();
	private $systems = array ('special', 'new', 'quantity', 'manufacturer');
	private $positions = array ('tl' => 'top left', 'tc' => 'top center', 'tr' => 'top right', 'cl' => 'center left', 'cc' => 'center center', 'cr' => 'center right', 'bl' => 'bottom left', 'bc' => 'bottom center', 'br' => 'bottom right');
	
	public function index() {
		$this->load->language('module/astickers');
		
		$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('catalog/astickers');
		
		$this->getList();
	}
	
	public function getProducts() {
		$this->load->model('catalog/astickers');
		
		$this->load->language('module/astickers');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			if (isset ($this->request->post['selected']) && $this->request->post['selected']) {
				$this->model_catalog_astickers->editProducts($this->request->post);
				
				$this->session->data['success'] = $this->language->get('success_edit_products');
			} else {
				$this->error['warning'] = $this->language->get('error_selected_products');
			}
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		
		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_asticker_name'] = $this->language->get('column_asticker_name');
		$this->data['column_date_start'] = $this->language->get('column_date_start');
		$this->data['column_date_end'] = $this->language->get('column_date_end');
		$this->data['column_date_available'] = $this->language->get('column_date_available');
		$this->data['column_categories'] = $this->language->get('column_categories');
		
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_filter'] = $this->language->get('button_filter');
		
		if (isset ($this->request->post['selected'])) {
			$selected = $this->request->post['selected'];
		} else {
			$selected = array ();
		}
		
		if (isset ($this->request->post['asticker_id'])) {
			$this->data['asticker_id'] = $this->request->post['asticker_id'];
		} else {
			$this->data['asticker_id'] = 0;
		}
		
		if (isset ($this->request->post['asticker_date_start'])) {
			$this->data['asticker_date_start'] = $this->request->post['asticker_date_start'];
		} else {
			$this->data['asticker_date_start'] = '0000-00-00';
		}
		
		if (isset ($this->request->post['asticker_date_end'])) {
			$this->data['asticker_date_end'] = $this->request->post['asticker_date_end'];
		} else {
			$this->data['asticker_date_end'] = '0000-00-00';
		}
		
		// Filter start
		$filter = '';
		
		if (isset ($this->request->get['filter_keyword'])) {
			$this->data['filter_keyword'] = trim ($this->request->get['filter_keyword']);
			
			$filter .= '&filter_keyword=' . $this->request->get['filter_keyword'];
		} else {
			$this->data['filter_keyword'] = '';
		}
		
		$this->data['filter_category_id'] = array ();
		
		if (isset ($this->request->get['fc_id']) && is_array ($this->request->get['fc_id'])) {
			foreach ($this->request->get['fc_id'] as $value) {
				$this->data['filter_category_id'][] = (int) $value;
				
				$filter .= '&fc_id[]=' . $value;
			}
		}
		
		$this->data['filter_asticker_id'] = array ();
		
		if (isset ($this->request->get['fa_id']) && is_array ($this->request->get['fa_id'])) {
			foreach ($this->request->get['fa_id'] as $value) {
				$this->data['filter_asticker_id'][] = (int) $value;
				
				$filter .= '&fa_id[]=' . $value;
			}
		}
		
		if (isset ($this->request->get['filter_asticker_date_start'])) {
			$this->data['filter_asticker_date_start'] = $this->request->get['filter_asticker_date_start'];
			
			$filter .= '&filter_asticker_date_start=' . $this->request->get['filter_asticker_date_start'];
		} else {
			$this->data['filter_asticker_date_start'] = '';
		}
		
		if (isset ($this->request->get['filter_asticker_date_end'])) {
			$this->data['filter_asticker_date_end'] = $this->request->get['filter_asticker_date_end'];
			
			$filter .= '&filter_asticker_date_end=' . $this->request->get['filter_asticker_date_end'];
		} else {
			$this->data['filter_asticker_date_end'] = '';
		}
		// Filter end
		
		$this->getVars();
		
		$url = '';
		
		if ($this->vars['order'] == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		
		$url .= $this->getUrl(array ('page'));
		
		$this->data['sort_image'] = $this->url->link('module/astickers/getProducts', 'token=' . $this->session->data['token'] . '&sort=p.image' . $url . $filter, 'SSL');
		$this->data['sort_product_name'] = $this->url->link('module/astickers/getProducts', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url . $filter, 'SSL');
		$this->data['sort_price'] = $this->url->link('module/astickers/getProducts', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url . $filter, 'SSL');
		$this->data['sort_name'] = $this->url->link('module/astickers/getProducts', 'token=' . $this->session->data['token'] . '&sort=ast.name' . $url . $filter, 'SSL');
		$this->data['sort_date_start'] = $this->url->link('module/astickers/getProducts', 'token=' . $this->session->data['token'] . '&sort=p.asticker_date_start' . $url . $filter, 'SSL');
		$this->data['sort_date_end'] = $this->url->link('module/astickers/getProducts', 'token=' . $this->session->data['token'] . '&sort=p.asticker_date_end' . $url . $filter, 'SSL');
		$this->data['sort_date_available'] = $this->url->link('module/astickers/getProducts', 'token=' . $this->session->data['token'] . '&sort=p.date_available' . $url . $filter, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('module/astickers/getProducts', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url . $filter, 'SSL');
		
		
		$this->data['breadcrumbs'] = array (
			array (
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'text'      => $this->language->get('text_home'),
				'separator' => FALSE
			),
			array (
				'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
				'text'      => $this->language->get('text_module'),
				'separator' => ' :: '
			),
			array (
				'href'      => $this->url->link('module/astickers', 'token=' . $this->session->data['token'], 'SSL'),
				'text'      => $this->language->get('heading_title'),
				'separator' => ' :: '
			),
			array (
				'href'      => $this->url->link('module/astickers/getProducts', 'token=' . $this->session->data['token'], 'SSL'),
				'text'      => $this->language->get('button_products'),
				'separator' => ' :: '
			)
		);
		
		if (isset ($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset ($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$this->data['sort'] = $this->vars['sort'];
		
		$this->data['order'] = $this->vars['order'];
		
		$data = array (
			'filter_keyword' => $this->data['filter_keyword'],
			'filter_category_id' => $this->data['filter_category_id'],
			'filter_asticker_id' => $this->data['filter_asticker_id'],
			'filter_asticker_date_start' => $this->data['filter_asticker_date_start'],
			'filter_asticker_date_end' => $this->data['filter_asticker_date_end'],
			'sort'  => $this->vars['sort'],
			'order' => $this->vars['order'],
			'start' => ($this->vars['page'] - 1) * (int) $this->config->get('config_admin_limit'),
			'limit' => (int) $this->config->get('config_admin_limit')
		);
		
		$products = $this->model_catalog_astickers->getProducts($data);
		
		$total_products = $this->model_catalog_astickers->getTotalProducts($data);
		
		$this->load->model('tool/image');
		
		$this->load->model('catalog/product');
		
		$this->data['products'] = array ();
		
		foreach ($products as $product) {
			if ($product['image'] && file_exists (DIR_IMAGE . $product['image'])) {
				$image = $this->model_tool_image->resize($product['image'], (int) $this->config->get('config_image_product_width'), (int) $this->config->get('config_image_product_height'));
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', (int) $this->config->get('config_image_product_width'), (int) $this->config->get('config_image_product_height'));
			}
			
			$this->data['products'][] = array (
				'selected'            => in_array ($product['product_id'], $selected),
				'product_id'          => $product['product_id'],
				'image'               => $image,
				'name'                => $product['name'],
				'price'               => $product['price'],
				'date_available'      => $product['date_available'],
				'sort_order'          => $product['sort_order'],
				'href'                => HTTP_CATALOG . 'index.php?route=product/product&product_id=' . $product['product_id'],
				'asticker_images'     => $this->getImages($product['asticker_images']),
				'asticker_name'       => ($product['asticker_name']) ? $product['asticker_name'] : $this->language->get('text_none'),
				'asticker_date_start' => $product['asticker_date_start'],
				'asticker_date_end'   => $product['asticker_date_end']
			);
		}
		
		$url = $this->getUrl(array ('sort', 'order'));
		
		$pagination = new Pagination();
		$pagination->total = $total_products;
		$pagination->page = $this->vars['page'];
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/astickers/getProducts', 'token=' . $this->session->data['token'] . $url . '&page={page}' . $filter, 'SSL');
		
		$this->data['pagination'] = $pagination->render();
		
		$this->data['cancel'] = $this->url->link('module/astickers', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action'] = $this->url->link('module/astickers/getProducts', 'token=' . $this->session->data['token'] . $url . '&page=' . $this->vars['page'] . $filter, 'SSL');
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->data['astickers'] = $this->model_catalog_astickers->getAStickersAll();
		
		$this->load->model('catalog/category');
		
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);
		
		$this->data['positions'] = $this->positions;
		
		$this->data['product_id'] = '';
		
		$this->data['settings'] = $this->getSettings();
		
		$this->data['settings']['class'] = '.image';
		
		$this->data['request_url'] = HTTP_CATALOG . 'index.php?route=module/astickers/getAStickers';
		
		if (file_exists (DIR_CATALOG . 'view/theme/' . $this->config->get('config_template') . '/template/module/astickers.tpl')) {
			$this->data['astickers_tpl'] = DIR_CATALOG . 'view/theme/' . $this->config->get('config_template') . '/template/module/astickers.tpl';
		} else {
			$this->data['astickers_tpl'] = DIR_CATALOG . 'view/theme/default/template/module/astickers.tpl';
		}
		
		$this->template = 'module/astickers/product_list.tpl';
		$this->children = array (
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
	}
	
	public function insert() {
		$this->load->model('catalog/astickers');
		
		$this->load->language('module/astickers');
		
		$this->document->setTitle($this->language->get('heading_title')); 
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			foreach ($this->positions as $position=>$value) {
				if (isset ($this->request->post['images'][$position]) && !$this->request->post['images'][$position]) {
					unset ($this->request->post['images'][$position]);
				}
			}
			
			$this->model_catalog_astickers->add($this->request->post);
			
			$this->session->data['success'] = $this->language->get('success_insert_asticker');
			
			$url = $this->getUrl();
			
			$this->redirect($this->url->link('module/astickers', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		
		$this->getForm();
	}
	
	public function update() {
		$this->load->model('catalog/astickers');
		
		$this->load->language('module/astickers');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
			foreach ($this->positions as $position=>$value) {
				if (isset ($this->request->post['images'][$position]) && !$this->request->post['images'][$position]) {
					unset ($this->request->post['images'][$position]);
				}
			}
			
			$this->model_catalog_astickers->edit($this->request->get['asticker_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('success_edit_asticker');
			
			$url = $this->getUrl();
			
			$this->redirect($this->url->link('module/astickers', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		
		$this->getForm();
	}
	
	public function delete() {
		$this->load->model('catalog/astickers');
		
		$this->load->language('module/astickers');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			if (isset ($this->request->post['selected']) && $this->request->post['selected']) {
				$total_products = 0;
				
				foreach ($this->request->post['selected'] as $asticker_id) {
					$products = $this->model_catalog_astickers->getProductsByAStickerId($asticker_id);
					
					if ($products) {
						$total_products += $products;
					}
				}
				
				if ($total_products) {
					$this->error['warning'] = sprintf ($this->language->get('error_astickers'), $total_products);
				} else {
					foreach ($this->request->post['selected'] as $asticker_id) {
						$this->model_catalog_astickers->delete((int) $asticker_id);
					}
					
					$this->session->data['success'] = $this->language->get('success_delete_astickers');
					
					$url = $this->getUrl();
					
					$this->redirect($this->url->link('module/astickers', 'token=' . $this->session->data['token'] . $url, 'SSL'));
				}
			} else {
				$this->error['warning'] = $this->language->get('error_selected_astickers');
			}
		}
		
		$this->getList();
	}
	
	public function settings() {
		$this->data['settings'] = $this->getSettings();
		
		$this->load->language('module/astickers');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			if (!$this->request->post['astickers_settings']['class']) {
				$this->request->post['astickers_settings']['class'] = '.image';
			}
			
			if (!$this->request->post['astickers_settings']['class_main_image']) {
				$this->request->post['astickers_settings']['class_main_image'] = '.fancybox';
			}
			
			if (!$this->request->post['astickers_settings']['class_tabs']) {
				$this->request->post['astickers_settings']['class_tabs'] = '.htabs';
			}
			
			$this->request->post['astickers_settings']['min_width'] = abs ((int) $this->request->post['astickers_settings']['min_width']);
			$this->request->post['astickers_settings']['min_height'] = abs ((int) $this->request->post['astickers_settings']['min_height']);
			
			if (!$this->request->post['astickers_settings']['min_width']) {
				$this->request->post['astickers_settings']['min_width'] = 40;
			}
			
			if (!$this->request->post['astickers_settings']['min_height']) {
				$this->request->post['astickers_settings']['min_height'] = 40;
			}
			
			$this->request->post['astickers_settings']['width'] = abs ((int) $this->request->post['astickers_settings']['width']);
			$this->request->post['astickers_settings']['height'] = abs ((int) $this->request->post['astickers_settings']['height']);
			
			if (!$this->request->post['astickers_settings']['width']) {
				$this->request->post['astickers_settings']['width'] = 40;
			}
			
			if (!$this->request->post['astickers_settings']['height']) {
				$this->request->post['astickers_settings']['height'] = 40;
			}
			
			$this->request->post['astickers_settings']['z_index'] = (int) $this->request->post['astickers_settings']['z_index'];
			$this->request->post['astickers_settings']['days_new'] = (int) $this->request->post['astickers_settings']['days_new'];
			
			$this->load->model('setting/setting');
			
			$this->model_setting_setting->editSetting('astickers', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('success_edit_settings');
			
			$this->redirect($this->url->link('module/astickers', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['column_image'] = $this->language->get('column_image');
		
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_systems'] = $this->language->get('tab_systems');
		$this->data['tab_range'] = $this->language->get('tab_range');
		
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
		foreach ($this->systems as $language) {
			$this->data['entry_' . $language] = $this->language->get('entry_' . $language);
		}
		
		foreach ($this->data['settings'] as $language=>$value) {
			$this->data['entry_' . $language] = $this->language->get('entry_' . $language);
		}
		
		foreach ($this->positions as $language=>$value) {
			$this->data['text_' . $language] = $this->language->get('text_' . $language);
		}
		
		if (isset ($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		$this->data['breadcrumbs'] = array (
			array (
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
			),
			array (
				'text'      => $this->language->get('text_module'),
				'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			),
			array (
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('module/astickers', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			),
			array (
				'text'      => $this->language->get('button_settings'),
				'href'      => $this->url->link('module/astickers/settings', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			)
		);
		
		$this->data['action'] = $this->url->link('module/astickers/settings', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('module/astickers', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['modules'] = array ();
		
		if (isset ($this->request->post['astickers_module'])) {
			$this->data['modules'] = $this->request->post['astickers_module'];
		} else if ($this->config->get('astickers_module')) { 
			$this->data['modules'] = $this->config->get('astickers_module');
		}
		
		$this->load->model('tool/image');
		
		foreach ($this->data['settings']['quantity'] as $key=>$value) {
			if ($value['image'] && file_exists (DIR_IMAGE . $value['image'])) {
				$this->data['settings']['quantity'][$key]['thumb'] = $this->model_tool_image->resize($value['image'], 100, 100);
			} else {
				$this->data['settings']['quantity'][$key]['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
			}
		}
		
		$this->data['special_thumb'] = $this->model_tool_image->resize($this->data['settings']['special_image'], 100, 100);
		$this->data['new_thumb'] = $this->model_tool_image->resize($this->data['settings']['new_image'], 100, 100);
		
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		$this->data['token'] = $this->session->data['token'];
		$this->data['effects'] = array ('', 'bounce', 'fadeIn', 'fold', 'highlight', 'pulsate', 'shake', 'slide');
		$this->data['positions'] = $this->positions;
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->template = 'module/astickers/settings.tpl';
		$this->children = array (
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
	}
	
	private function getList() {
		$url = $this->getUrl();
		
		$this->getVars();
		
		$this->data['breadcrumbs'] = array (
			array (
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'text'      => $this->language->get('text_home'),
				'separator' => FALSE
			),
			array (
				'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
				'text'      => $this->language->get('text_module'),
				'separator' => ' :: '
			),
			array (
				'href'      => $this->url->link('module/astickers', 'token=' . $this->session->data['token'], 'SSL'),
				'text'      => $this->language->get('heading_title'),
				'separator' => ' :: '
			)
		);
		
		$this->data['insert'] = $this->url->link('module/astickers/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('module/astickers/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['products'] = $this->url->link('module/astickers/getProducts', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['settings'] = $this->url->link('module/astickers/settings', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['astickers'] = array ();
		
		$data = array (
			'sort'  => $this->vars['sort'],
			'order' => $this->vars['order'],
			'start' => ($this->vars['page'] - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$this->load->model('tool/image');
		
		$astickers_total = $this->model_catalog_astickers->getTotalAStickers($data);
		
		$results = $this->model_catalog_astickers->getAStickers($data);
		
		foreach ($results as $result) {
			$this->data['astickers'][] = array (
				'selected'    => isset ($this->request->post['selected']) && in_array ($result['asticker_id'], $this->request->post['selected']),
				'asticker_id' => $result['asticker_id'],
				'name'        => $result['name'],
				'sort_order'  => $result['sort_order'],
				'images'      => $this->getImages($result['images']),
				'edit'        => $this->url->link('module/astickers/update', 'token=' . $this->session->data['token'] . '&asticker_id=' . $result['asticker_id'] . $url, 'SSL')
			);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		
		$this->data['column_asticker_name'] = $this->language->get('column_asticker_name');
		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');
		
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_settings'] = $this->language->get('button_settings');
		$this->data['button_products'] = $this->language->get('button_products');
		
		$this->data['token'] = $this->session->data['token'];
		
		if (isset ($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset ($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$url = '';
		
		if ($this->vars['order'] == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		
		$url .= $this->getUrl(array ('page'));
		
		$this->data['sort_name'] = $this->url->link('module/astickers', 'token=' . $this->session->data['token'] . '&sort=ast.name' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('module/astickers', 'token=' . $this->session->data['token'] . '&sort=ast.sort_order' . $url, 'SSL');
		
		$url = $this->getUrl(array ('sort', 'order'));
		
		$pagination = new Pagination();
		$pagination->total = $astickers_total;
		$pagination->page = $this->vars['page'];
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/astickers', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		
		$this->data['pagination'] = $pagination->render();
		
		$this->data['sort'] = $this->vars['sort'];
		$this->data['order'] = $this->vars['order'];
		
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', (int) $this->config->get('config_image_product_width'), (int) $this->config->get('config_image_product_height'));
		
		$this->data['positions'] = $this->positions;
		
		$this->template = 'module/astickers/list.tpl';
		$this->children = array (
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
	}
	
	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
		if (isset ($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset ($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}
		
		if (isset ($this->error['sort_order'])) {
			$this->data['error_sort_order'] = $this->error['sort_order'];
		} else {
			$this->data['error_sort_order'] = '';
		}
		
		$url = $this->getUrl();
		
		$this->data['breadcrumbs'] = array (
			array (
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'text'      => $this->language->get('text_home'),
				'separator' => FALSE
			),
			array (
				'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'] . $url, 'SSL'),
				'text'      => $this->language->get('text_module'),
				'separator' => ' :: '
			),
			array (
				'href'      => $this->url->link('module/astickers', 'token=' . $this->session->data['token'] . $url, 'SSL'),
				'text'      => $this->language->get('heading_title'),
				'separator' => ' :: '
			),
			array (
				'href'      => $this->url->link('module/astickers', 'token=' . $this->session->data['token'] . $url, 'SSL'),
				'text'      => (isset ($this->request->get['asticker_id'])) ? $this->language->get('text_edit') : $this->language->get('button_insert'),
				'separator' => ' :: '
			)
		);
		
		if (isset ($this->request->get['asticker_id'])) {
			$this->data['action'] = $this->url->link('module/astickers/update', 'token=' . $this->session->data['token'] . '&asticker_id=' . $this->request->get['asticker_id'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('module/astickers/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('module/astickers', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('tool/image');
		
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		
		$this->data['positions'] = $this->positions;
		
		if (isset ($this->request->get['asticker_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
			$asticker = $this->model_catalog_astickers->getAStickerById($this->request->get['asticker_id']);
		}
		
		if (isset ($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} else if (isset ($asticker)) {
			$this->data['name'] = $asticker['name'];
		} else {
			$this->data['name'] = '';
		}
		
		if (isset ($this->request->post['images'])) {
			$this->data['images'] = $this->getImages($this->request->post['images']);
		} else if (isset ($asticker['images'])) {
			$this->data['images'] = $this->getImages($asticker['images']);
		} else {
			$this->data['images'] = $this->getImages();
		}
		
		if (isset ($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} else if (isset ($asticker['sort_order'])) {
			$this->data['sort_order'] = $asticker['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}
		
		$this->template = 'module/astickers/form.tpl';
		$this->children = array (
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
	}
	
	private function getImages($images = '') {
		$this->load->model('tool/image');
		
		if ($images) {
			if (!is_array ($images)) {
				$images = unserialize ($images);
			}
		} else {
			$images = $this->positions;
		}
		
		foreach ($this->positions as $position=>$value) {
			if (isset ($images[$position]) && $images[$position] && file_exists (DIR_IMAGE . $images[$position])) {
				$images['thumb_' . $position] = $this->model_tool_image->resize($images[$position], 100, 100);
			} else {
				$images['thumb_' . $position] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
				
				$images[$position] = '';
			}
		}
		
		return $images;
	}
	
	private function getUrl($vars = array ()) {
		if (!$vars) {
			$vars = array ('sort', 'order', 'page');
		}
		
		$url = '';
		
		foreach ($vars as $var) {
			if (isset ($this->request->get[$var])) {
				$url .= '&' . $var . '=' . $this->request->get[$var];
			}
		}
		
		return $url;
	}
	
	private function getVars() {
		$vars = array ('sort' => 'ast.name', 'order' => 'ASC', 'page' => 1);
		
		foreach ($vars as $var=>$value) {
			if (isset ($this->request->get[$var])) {
				$this->vars[$var] = $this->request->get[$var];
			} else {
				$this->vars[$var] = $value;
			}
		}
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
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/astickers')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		return (!$this->error) ? TRUE : FALSE;
	}
	
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'module/astickers')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((strlen (utf8_decode ($this->request->post['name'])) < 3) || (strlen (utf8_decode ($this->request->post['name'])) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			if (!isset ($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_required_data');
			}
			return FALSE;
		}
	}
	
	public function install() {
		$fields = array ('asticker_id' => array ('status' => FALSE, 'type' => 'int(11)', 'default' => '0'), 'asticker_date_start' => array ('status' => FALSE, 'type' => 'date', 'default' => '0000-00-00'), 'asticker_date_end' => array ('status' => FALSE, 'type' => 'date', 'default' => '0000-00-00'));
		
		$columns = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product`")->rows;
		
		foreach ($columns as $column) {
			if (isset ($fields[$column['Field']])) {
				$fields[$column['Field']]['status'] = TRUE;
			}
		}
		
		foreach ($fields as $field=>$data) {
			if (!$data['status']) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD `" . $field . "` " . $data['type'] . " NOT NULL DEFAULT '" . $data['default'] . "'");
			}
		}
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "astickers` (`asticker_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, `name` varchar(64) COLLATE utf8_general_ci NOT NULL DEFAULT '', `images` text COLLATE utf8_general_ci NOT NULL, `sort_order` int(3) NOT NULL DEFAULT '0') ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1");
		
		$values = array (array ('name' => 'Уголок Лучшая цена низ-справа', 'images' => array ('br' => 'data/astickers/best_price_bottom_right.png')), array ('name' => 'Уголок Лучшая цена верх-слева', 'images' => array ('tl' => 'data/astickers/best_price_top_left.png')), array ('name' => 'Уголок Лидер низ-справа', 'images' => array ('br' => 'data/astickers/lider_bottom_right.png')), array ('name' => 'Уголок Лидер верх-слева', 'images' => array ('tl' => 'data/astickers/lider_top_left.png')), array ('name' => 'Уголок Новинка низ-справа', 'images' => array ('br' => 'data/astickers/new_bottom_right.png')), array ('name' => 'Уголок Новинка верх-слева', 'images' => array ('tl' => 'data/astickers/new_top_left.png')), array ('name' => 'Уголок Подарок низ-справа', 'images' => array ('br' => 'data/astickers/present_bottom_right.png')), array ('name' => 'Уголок Подарок верх-слева', 'images' => array ('tl' => 'data/astickers/present_top_left.png')), array ('name' => 'Уголок Цена снижена низ-справа', 'images' => array ('br' => 'data/astickers/price_down_bottom_right.png')), array ('name' => 'Уголок Цена снижена верх-слева', 'images' => array ('tl' => 'data/astickers/price_down_top_left.png')), array ('name' => 'Уголок Скоро в продаже низ-справа', 'images' => array ('br' => 'data/astickers/soon_bottom_right.png')), array ('name' => 'Уголок Скоро в продаже верх-слева', 'images' => array ('tl' => 'data/astickers/soon_top_left.png')), array ('name' => 'Уголок Акция низ-справа', 'images' => array ('br' => 'data/astickers/special_bottom_right.png')), array ('name' => 'Уголок Акция верх-слева', 'images' => array ('tl' => 'data/astickers/special_top_left.png')), array ('name' => 'Скидка 10 процентов верх-центр', 'images' => array ('tc' => 'data/astickers/10words.png')), array ('name' => 'Скидка 20 процентов центр-слева', 'images' => array ('cl' => 'data/astickers/20words.png')), array ('name' => 'Скидка 30 процентов центр-справа', 'images' => array ('cr' => 'data/astickers/30words.png')), array ('name' => 'Скидка 40 процентов низ-центр', 'images' => array ('bc' => 'data/astickers/40words.png')), array ('name' => 'Уголок Скидка 10 процентов низ-справа', 'images' => array ('br' => 'data/astickers/discount_10_bottom_right.png')), array ('name' => 'Лента Скидка 10 процентов верх-слева', 'images' => array ('tl' => 'data/astickers/discount_10_top_left.png')), array ('name' => 'Уголок Скидка 10 процентов верх-слева', 'images' => array ('tl' => 'data/astickers/discount_10_top_left_1.png')), array ('name' => 'Уголок Скидка 20 процентов низ-справа', 'images' => array ('br' => 'data/astickers/discount_20_bottom_right.png')), array ('name' => 'Лента Скидка 20 процентов верх-слева', 'images' => array ('tl' => 'data/astickers/discount_20_top_left.png')), array ('name' => 'Уголок Скидка 20 процентов верх-слева', 'images' => array ('tl' => 'data/astickers/discount_20_top_left_1.png')), array ('name' => 'Уголок Скидка 30 процентов низ-справа', 'images' => array ('br' => 'data/astickers/discount_30_bottom_right.png')), array ('name' => 'Лента Скидка 30 процентов низ-справа', 'images' => array ('br' => 'data/astickers/discount_30_bottom_right_1.png')), array ('name' => 'Лента Скидка 30 процентов верх-слева', 'images' => array ('tl' => 'data/astickers/discount_30_top_left.png')), array ('name' => 'Уголок Скидка 30 процентов верх-слева', 'images' => array ('tl' => 'data/astickers/discount_30_top_left_1.png')), array ('name' => 'Уголок Скидка 40 процентов низ-справа', 'images' => array ('br' => 'data/astickers/discount_40_bottom_right.png')), array ('name' => 'Лента Скидка 40 процентов верх-слева', 'images' => array ('tl' => 'data/astickers/discount_40_top_left.png')), array ('name' => 'Уголок Скидка 40 процентов верх-слева', 'images' => array ('tl' => 'data/astickers/discount_40_top_left_1.png')), array ('name' => 'Лента Новинка верх-слева', 'images' => array ('tl' => 'data/astickers/new_top_left_1.png')), array ('name' => 'Звезда Распродажа центр-центр', 'images' => array ('cc' => 'data/astickers/sale.png')), array ('name' => 'Бирка Распродажа верх-справа', 'images' => array ('tr' => 'data/astickers/sale_1.png')), array ('name' => 'Распродажа центр-справа', 'images' => array ('cr' => 'data/astickers/sale_2.png')), array ('name' => 'Лента Распродажа низ-справа', 'images' => array ('br' => 'data/astickers/sale_bottom_right.png')), array ('name' => 'Лента Распродажа низ-справа', 'images' => array ('br' => 'data/astickers/sale_bottom_right_1.png')), array ('name' => 'Лента Распродажа верх-слева', 'images' => array ('tl' => 'data/astickers/sale_top_left.png')), array ('name' => 'Хит центр-центр', 'images' => array ('cc' => 'data/astickers/hit.png')), array ('name' => 'Акция верх-центр', 'images' => array ('tc' => 'data/astickers/special.png')), array ('name' => 'Новинка центр-слева', 'images' => array ('cl' => 'data/astickers/new.png')));
		
		$id = 1;
		
		foreach ($values as $value) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "astickers` (`asticker_id`, `name`, `images`, `sort_order`) VALUES ('" . $id . "', '" . $value['name'] . "', '" . serialize ($value['images']) . "', '0') ON DUPLICATE KEY UPDATE `asticker_id` = `asticker_id`");
			
			$id++;
		}
	}
}
?>