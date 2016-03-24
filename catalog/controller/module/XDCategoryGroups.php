<?php
class ControllerModuleXDCategoryGroups extends Controller {	
	protected function index() {
            $this->language->load('module/XDCategoryGroups');
            $this->load->model('catalog/category');
            $this->load->model('tool/image');
            
            //$this->data['heading_title'] = $this->language->get('heading_title');
            
            if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/XDCategoryGroups.css')) {
                    $this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/XDCategoryGroups.css');
            } else {
                    $this->document->addStyle('catalog/view/theme/default/stylesheet/XDCategoryGroups.css');
            }
            
            $categories = $this->config->get('XDCategoryGroupsBlocks');
            
            $XDSettings = $this->config->get('XDCategoryGroupsSetting');
            
            $this->data['XDposition'] = $XDSettings['titlePosition'];
            $this->data['XDtitleLinks'] = $XDSettings['titleLinks'];
            $this->data['XDshowImage'] = $XDSettings['showImage'];
            $this->data['XDAutoPadding'] = $XDSettings['blockPadding'];
            $this->data['XDPaddingLeft'] = $XDSettings['blockPaddingLeft'];
            $this->data['XDPaddingRight'] = $XDSettings['blockPaddingRight'];
            $this->data['XDBlockHeight'] = $XDSettings['blockHeight'];
            $this->data['XDcustomCSSCode'] = (isset($XDSettings['customCSSCode']) ? $XDSettings['customCSSCode'] : '');

            if(!isset($XDSettings['customImageWidth']) || $XDSettings['customImageWidth'] == ''){
                $XDSettings['customImageWidth'] = 250;
            }
            
//            if($XDSettings['height'] == ''){
//                $XDSettings['height'] = 125;
//            }
            
            $subCatLimit = $XDSettings['categoryLimit'];
            
            $cat = array();
            $count = 1;
            foreach($categories as $category){
                $currentCategory = $this->model_catalog_category->getCategory($category['category']);

                $cat[$count]['name'] = $currentCategory['name'];
                $cat[$count]['parent_url'] = $this->constructPath($category['category']);
                if($category['image'] == ''){
                    $cat[$count]['image'] = 'http://www.placehold.it/270x80';
                } else {
                    //$cat[$count]['image'] = HTTPS_SERVER.'image/'.$category['image'];
                    $image = $this->model_tool_image->resize($category['image'], $XDSettings['customImageWidth'], $XDSettings['customImageWidth']);
                    $cat[$count]['image'] = $image;
                }
                
                $cat[$count]['category'] = $category['category'];
                $CategoryChildren = array();
                $Children = $this->model_catalog_category->getCategories($category['category']);
                $Children = array_slice($Children, 0, $subCatLimit);
                foreach($Children as $child){
                    $CategoryChildren[] = array(
                        'category_id' => $child['category_id'],
                        'name'        => $child['name'],
                        'url'         => $this->constructPath($category['category'], $child['category_id'])
                    );
                }
                $cat[$count]['children'] = $CategoryChildren;
                
                $count++;
            }
            
            $this->data['categories'] = $cat;
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/XDCategoryGroups.tpl')) {
                    $this->template = $this->config->get('config_template') . '/template/module/XDCategoryGroups.tpl';
            } else {
                    $this->template = 'default/template/module/XDCategoryGroups.tpl';
            }
            
            $this->render();
        }
        
        protected function constructPath($categoryID,$subCategoryID = '') {
            if($subCategoryID != ''){
                $new_path = $categoryID . '_' . $subCategoryID;
            } else {
                $new_path = $categoryID;
            }
                 
            //$categoryhome = array();
		//$category_id = array_shift($this->path);
		
		//$results = $this->model_catalog_category->getCategories($parent_id);
                
                $categoryURL = $this->url->link('product/category', 'path=' . $new_path);
		
		return $categoryURL;
        }
}
?>