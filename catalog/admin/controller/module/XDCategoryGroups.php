<?php
class ControllerModuleXDCategoryGroups extends Controller {
    private $error = array();
    
    public function index() {
        $this->load->language('module/XDCategoryGroups');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');
        $this->load->model('catalog/category');
        
        //VALUE ASSIGNMENT
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['error_warning'] = '';
        $this->data['XD_settings_title'] = $this->language->get('XD_settings_title');
        $this->data['text_image_manager'] = 'Upload Media';
        $this->data['XD_title'] = $this->language->get('XD_title');
        $this->data['XD_image'] = $this->language->get('XD_image');
        $this->data['XD_category'] = $this->language->get('XD_category');
        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['token'] = $this->session->data['token'];
        
        $this->data['action'] = $this->url->link('module/account', 'token=' . $this->session->data['token'], 'SSL');
		
        $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        
        //BREADCRUMBS
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
                'href'      => $this->url->link('module/google_talk', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => ' :: '
        );
        
             
        //LAYOUT OPTIONS

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_content_top'] = $this->language->get('text_content_top');
        $this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
        $this->data['text_column_left'] = $this->language->get('text_column_left');
        $this->data['text_column_right'] = $this->language->get('text_column_right');

        $this->data['entry_code'] = $this->language->get('entry_code');
        $this->data['entry_layout'] = $this->language->get('entry_layout');
        $this->data['entry_position'] = $this->language->get('entry_position');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_add_module'] = $this->language->get('button_add_module');
        $this->data['button_remove'] = $this->language->get('button_remove');     
        
        $results = $this->model_catalog_category->getCategories(0);

        
        //print_r($results);
        
        foreach ($results as $result) {

                $this->data['categories'][] = array(
                        'category_id' => $result['category_id'],
                        'name'        => $result['name']
                );
        }
        
        //SAVE OR GET LAYOUT OPTIONS
        $this->data['modules'] = array();		
        if (isset($this->request->post['XDCategoryGroups_module'])) {
                $this->data['modules'] = $this->request->post['XDCategoryGroups_module'];
        } elseif ($this->config->get('XDCategoryGroups_module')) { 
                $this->data['modules'] = $this->config->get('XDCategoryGroups_module');
        }
        
        //SAVE OR GET BLOCKS
        $this->data['blocks'] = array();		
        if (isset($this->request->post['XDCategoryGroupsBlocks'])) {
                $this->data['blocks'] = $this->request->post['XDCategoryGroupsBlocks'];
        } elseif ($this->config->get('XDCategoryGroupsBlocks')) { 
                $this->data['blocks'] = $this->config->get('XDCategoryGroupsBlocks');
        }
        
        //SAVE OR GET SETTINGS
        //SET DEFAULTS
        $this->data['XDSetting'] = array();
        $this->data['XDSetting']['categoryLimit'] = '5'; 
        $this->data['XDSetting']['blockHeight'] = '0'; 
        $this->data['XDSetting']['titlePosition'] = 'belowImage'; 		
        $this->data['XDSetting']['titleLinks'] = 'inactive';
        $this->data['XDSetting']['customCSSCode'] = '';
        $this->data['XDSetting']['blockPadding'] = '';
        $this->data['XDSetting']['blockPaddingLeft'] = '';
        $this->data['XDSetting']['blockPaddingRight'] = '';
        $this->data['XDSetting']['blockHeight'] = '';
        
        if (isset($this->request->post['XDCategoryGroupsSetting'])) {
                $this->data['XDSetting'] = $this->request->post['XDCategoryGroupsSetting'];
        } elseif ($this->config->get('XDCategoryGroupsSetting')) { 
                $this->data['XDSetting'] = $this->config->get('XDCategoryGroupsSetting');
        }
        
        $this->load->model('design/layout');
        $this->data['layouts'] = $this->model_design_layout->getLayouts();

        $this->template = 'module/XDCategoryGroups.tpl';
        $this->children = array(
                'common/header',
                'common/footer'
        );

        $this->response->setOutput($this->render());
    }
    
    private function validate() {
            if (!$this->user->hasPermission('modify', 'module/XDCategoryGroups')) {
                    $this->error['warning'] = $this->language->get('error_permission');
            }

            if (!$this->error) {
                    return true;
            } else {
                    return false;
            }	
    }
}
?>
