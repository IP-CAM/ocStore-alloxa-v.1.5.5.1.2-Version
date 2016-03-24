<?php 
class ControllerInformationInformationCategory extends Controller {
	public function index() {  
    	$this->language->load('information/information_category');
		
		$this->load->model('catalog/information_category');
		$this->load->model('tool/image');
		
		$this->data['breadcrumbs'] = array();
		
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	);
		
		if (isset($this->request->get['information_category_id'])) {
			$information_category_id = (int)$this->request->get['information_category_id'];
		} else {
			$information_category_id = 0;
		}

		$this->data['information_categories'] = array();

		$information_categories = $this->model_catalog_information_category->getInformationCategories();

		foreach ($information_categories as $information_category) {
			$this->data['information_categories'][] = array(
				'information_category_id' => $information_category['information_category_id'],
				'title'					  => $information_category['title'],
				'href'					  => $this->url->link('information/information_category', 'information_category_id=' . $information_category['information_category_id'])
			);
		}

		$this->data['text_empty_category'] = $this->language->get('text_empty_category');

		$this->data['text_all'] = $this->language->get('text_all');

		$this->data['href_all'] = $this->url->link('information/information_category');

		$information_total = $this->model_catalog_information_category->getTotalInformations($information_category_id);
		$information_category_info = $this->model_catalog_information_category->getInformationCategory($information_category_id);

		if ($information_category_info) {
			if ($information_category_info['seo_title']) {
				$this->document->setTitle($information_category_info['seo_title']);
			} else {
				$this->document->setTitle($information_category_info['title']);
			}
			$this->document->setDescription($information_category_info['meta_description']);
			$this->document->setKeywords($information_category_info['meta_keyword']);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('news_seo_h1'),
				'href'      => $this->url->link('information/information_category'),
				'separator' => $this->language->get('text_separator')
			);
			
      		$this->data['breadcrumbs'][] = array(
        		'text'      => $information_category_info['title'],
				'href'      => $this->url->link('information/information_category', 'information_category_id=' .  $information_category_id),
        		'separator' => $this->language->get('text_separator')
      		);		
						
			if ($information_category_info['seo_h1']) {
				$this->data['heading_title'] = $information_category_info['seo_h1'];
			} else {
				$this->data['heading_title'] = $information_category_info['title'];
			}
      		
      		$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/information_category.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/information/information_category.tpl';
			} else {
				$this->template = 'default/template/information/information_category.tpl';
			}

			$this->data['informations'] = array();

			$informations = $this->model_catalog_information_category->getInformations($information_category_id);

			foreach ($informations as $information) {
				if ($information['image']) {
					$image = $this->model_tool_image->resize($information['image'], 320, 210);
				} else {
					$image = $this->model_tool_image->resize('no_image.jpg', 320, 210);
				}

				$this->data['informations'][] = array(
					'information_id'  => $information['information_id'],
					'thumb'       => $image,
					'title'       => $information['title'],
					'href'        => $this->url->link('information/information', 'information_category_id=' . $information_category_id . '&information_id=' . $information['information_id'])
				);
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
						
	  		$this->response->setOutput($this->render());
    	} elseif ($information_total) {
			$this->document->setTitle($this->language->get('news_seo_title'));
			$this->document->setDescription($this->language->get('news_meta_description'));

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('news_seo_h1'),
				'href'      => $this->url->link('information/information_category'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['heading_title'] = $this->language->get('news_seo_h1');

			$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/information_category.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/information/information_category.tpl';
			} else {
				$this->template = 'default/template/information/information_category.tpl';
			}

			$this->data['informations'] = array();

			$informations = $this->model_catalog_information_category->getInformations();

			foreach ($informations as $information) {
				if ($information['image']) {
					$image = $this->model_tool_image->resize($information['image'], 320, 210);
				} else {
					$image = $this->model_tool_image->resize('no_image.jpg', 320, 210);
				}

				$this->data['informations'][] = array(
					'information_id'  => $information['information_id'],
					'thumb'       => $image,
					'title'       => $information['title'],
					'href'        => $this->url->link('information/information', 'information_category_id=' . $information['category_id'] . '&information_id=' . $information['information_id'])
				);
			}

			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);

			$this->response->setOutput($this->render());
		} else {
      		$this->data['breadcrumbs'][] = array(
        		'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('information/information_category', 'information_category_id=' . $information_category_id),
        		'separator' => $this->language->get('text_separator')
      		);
				
	  		$this->document->setTitle($this->language->get('text_error'));
			
      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
					
	  		$this->response->setOutput($this->render());
    	}
  	}
}
?>