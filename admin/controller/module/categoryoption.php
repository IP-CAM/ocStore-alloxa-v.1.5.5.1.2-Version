<?php
class ControllerModuleCategoryOption extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/categoryoption');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');

    $this->data['action'] = $this->url->link('module/categoryoption', 'token=' . $this->session->data['token'], 'SSL');		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

    $this->data['tab_general'] = $this->language->get('tab_general');    
    $this->data['tab_help'] = $this->language->get('tab_help'); 
    $this->data['tab_langs'] = $this->language->get('tab_langs');
    $this->data['text_enabled'] = $this->language->get('text_enabled');    
    $this->data['text_disabled'] = $this->language->get('text_disabled');     
     
    
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
		  if (isset($this->request->post['activate']) && $this->request->post['activate'] ==1) {
  		  $this->db->query("CREATE TABLE `".DB_PREFIX."option_to_category` ( `option_id` int(11) unsigned NOT NULL default 0, `category_id` int(11) unsigned NOT NULL default 0, PRIMARY KEY (`option_id`, category_id), KEY `category_id` (`category_id`), KEY `option_id` (`option_id`) ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
  		  $this->db->query("ALTER TABLE `".DB_PREFIX."option` add column `add_all_values` int(11) unsigned NOT NULL default 0");
  		    $this->redirect($this->url->link('module/categoryoption', 'token=' . $this->session->data['token'], 'SSL'));
		  } else {
		    if ($this->validate()) {
    			$this->model_setting_setting->editSetting('categoryoption', $this->request->post);		
    			$this->session->data['success'] = $this->language->get('text_success');
    		  $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
    		}  
		  }
		}

		$check = $this->db->query("SHOW TABLES LIKE  '%".DB_PREFIX."option_to_category%'");		

	 if ($check->num_rows) {		
  		$this->data['heading_title'] = $this->language->get('heading_title');
		 $this->data['button_apply'] = $this->language->get('button_apply');
		 $this->data['button_save'] = $this->language->get('button_save');
  		$this->data['button_cancel'] = $this->language->get('button_cancel');
      $this->data['entry_status']= $this->language->get('entry_status');
      $this->data['text_notice']    = $this->language->get("text_notice");
      $this->data['text_error']    = $this->language->get("text_error");
          $this->data['entry_delete_empty'] = $this->language->get('entry_delete_empty');
      
  		if (isset($this->request->post['categoryoption_status'])) {
  			$this->data['categoryoption_status'] = $this->request->post['categoryoption_status'];
  		} elseif ($this->config->get('categoryoption_status')) { 
  			$this->data['categoryoption_status'] = $this->config->get('categoryoption_status');
  		}		
  		if (isset($this->request->post['categoryoption_delete_empty'])) {
  			$this->data['categoryoption_delete_empty'] = $this->request->post['categoryoption_delete_empty'];
  		} elseif ($this->config->get('categoryoption_delete_empty')) { 
  			$this->data['categoryoption_delete_empty'] = $this->config->get('categoryoption_delete_empty');
  		}		  		

		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
  		  		
  		  		
    		$this->data['breadcrumbs'] = array();
  
     		$this->data['breadcrumbs'][] = array(
         		'text'      => $this->language->get('text_home'),
         		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
        		'separator' => false
     		);
  
     		$this->data['breadcrumbs'][] = array(
         		'text'      => $this->language->get('text_module'),
         		'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
        		'separator' => ' :: '
     		);
  		
     		$this->data['breadcrumbs'][] = array(
         		'text'      => $this->language->get('heading_title'),
         		'href'      => $this->url->link('module/categoryoption', 'token=' . $this->session->data['token'], 'SSL'),
        		'separator' => ' :: '
     		);
    
    		if (isset($this->error['warning'])) {
    			$this->data['error_warning'] = $this->error['warning'];
    		} else {
    			$this->data['error_warning'] = '';
    		}    
    		
    		$this->load->model('localisation/order_status');
    
    		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();    		
    
    		$this->template = 'module/categoryoption/categoryoption.tpl';
    		$this->children = array(
    			'common/header',
    			'common/footer'
    		);
    				
    		$this->response->setOutput($this->render());
    } else {
    
    		$this->template = 'module/categoryoption/activate.tpl';
    		$this->children = array(
    			'common/header',
    			'common/footer'
    		);
    				
    		$this->response->setOutput($this->render());
      
      
    }
    		
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/categoryoption')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
    			
  		if ($this->error && !isset($this->error['warning'])) {
  			$this->error['warning'] = $this->language->get('error_warning');
  		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	public function install() {
		@mail('support@webnet.bg', 'WebNet Bulk Options to products installed', HTTP_CATALOG . ' - ' . $this->config->get('config_name') . "\r\n" . 'version - ' . VERSION . "\r\n" . 'IP - ' . $this->request->server['REMOTE_ADDR'], 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n" . 'From: ' . $this->config->get('config_owner') . ' <' . $this->config->get('config_email') . '>' . "\r\n");
	}		
}
?>