<?php
	$file = "admin/model/catalog/product.php";
	$text = "getProducts(";	
	$pos = FindText($file, $text, 1);
	if ($pos != 'yes') {
	
		$text = '
	public function getMaxModel() {		
		$query = $this->db->query("SELECT max(product_id) FROM " . DB_PREFIX . "product");			
		return $query->row;
	} /*suppler*/';
	
		Insert($file, $pos, $text);		
	}
	
	$file = "admin/controller/catalog/product.php";
	$text = "this->data['token'] = ";	
	$pos = FindText($file, $text, 2);
	
	if ($pos != 'yes') {	
		$text = ' else {
			$row = $this->model_catalog_product->getMaxModel();
			$max_model = $row["max(product_id)"];
			$next_code = $max_model + 1;
			$next_code = $next_code."-";
		} /*suppler*/';
	
		Insert($file, $pos, $text);		
	}	
	$text = "this->data['model'] = ''";
	$pos = FindText($file, $text, 1);
	if ($pos != 'yes') {
		$rep = 'this->data["model"] = $next_code; /*suppler*/';
		Replace($file, $pos, $text, $rep);
	}

	$file = "admin/controller/common/header.php";
	$text = "this->data['text_module'] = ";	
	$pos = FindText($file, $text, 1);
	
	if ($pos != 'yes') {	
		$text = ' 
		$this->data["text_suppler"] = $this->language->get("text_suppler");  /*suppler*/'
		 ;
	
		Insert($file, $pos, $text);		
	}
	$text = "this->data['module'] = ";	
	$pos = FindText($file, $text, 1);
	
	if ($pos != 'yes') {	
		$text = ' 
		$this->data["suppler"] = $this->url->link("catalog/suppler", "token=" . $this->session->data["token"], "SSL");  /*suppler*/'
;
	
		Insert($file, $pos, $text);		
	}

	$file = "admin/controller/report/product_purchased.php";
	$text = "url = ''";	
	$pos = FindText($file, $text, 1);
	
	if ($pos != 'yes') {	
		$text = ' 
		if (isset($this->request->get["filter_model"])) {
			$filter_model = $this->request->get["filter_model"];
		} else {
			$filter_model = "0";
		} /*suppler*/'
		 ;
	
		Insert($file, $pos, $text);		
	}
	$text = "this->data['breadcrumbs'] = array()";	
	$pos = FindText($file, $text, 1);
	
	if ($pos != 'yes') {	
		$text = ' 
		if (isset($this->request->get["filter_model"])) {
			$url .= "&filter_model =" . $this->request->get["filter_model"];
		}  /*suppler*/'
		;
	
		Insert($file, $pos, $text);		
	}
	$text = "'start'";	
	$pos = FindText($file, $text, 1);
	
	if ($pos != 'yes') {	
		$text = ' 
			"filter_model"           => $filter_model, /*suppler*/'
		;
	
		Insert($file, $pos, $text);		
	}
	$text = "this->data['button_filter'] = ";	
	$pos = FindText($file, $text, 1);
	
	if ($pos != 'yes') {	
		$text = ' 
		$this->data["entry_supp"] = $this->language->get("entry_supp");
		$this->data["text_total"] = $this->language->get("text_total"); /*suppler*/'
		;
		Insert($file, $pos, $text);		
	}	
	$text = "pagination = new Pagination()";	
	$pos = FindText($file, $text, 1);
	
	if ($pos != 'yes') {	
		$text = ' 
		if (isset($this->request->get["filter_model"])) {
			$url .= "&filter_model =" . $this->request->get["filter_model"];
		} /*suppler*/'
		;
	
		Insert($file, $pos, $text);		
	}

	$file = "admin/controller/sale/order.php";
	$text = "'store_email'";	
	$pos = FindText($file, $text, 1);
	
	if ($pos != 'yes') {	
		$text = ' 
					"store_owner"	     => $this->config->get("config_owner"), /*suppler*/'
		 ;
	
		Insert($file, $pos, $text);		
	}

	$file = "admin/language/english/common/header.php";
	$text = "['text_module']";	
	$pos = FindText($file, $text, 1);
	
	if ($pos != 'yes') {	
		$text = ' 
	$_["text_suppler"]                	   = "Suppliers"; /*suppler*/'
		 ;
	
		Insert($file, $pos, $text);		
	}
	
	$file = "admin/language/english/report/product_purchased.php";
	$text = "_['entry_status']";	
	$pos = FindText($file, $text, 1);
	
	if ($pos != 'yes') {	
		$text = ' 
	$_["text_total"]        = "Total:";
	$_["entry_supp"]        = "Supplier ID:"; /*suppler*/'
		 ;
	
		Insert($file, $pos, $text);		
	}
	$text = "'Model';";
	$pos = FindText($file, $text, 1);
	if ($pos != 'yes') {
		$rep = '
		"Product code"; /*suppler*/';
		Replace($file, $pos, $text, $rep);
	}
	
	$file = "admin/language/russian/catalog/product.php";
	$text = "'Модель';";	
	$pos = FindText($file, $text, 1);
	if ($pos != 'yes') {
		$rep = '"Код товара"; /*suppler*/';
		Replace($file, $pos, $text, $rep);
	}
	$text = "'Модель:';";
	$pos = FindText($file, $text, 1);
	if ($pos != 'yes') {
		$rep = '"Код товара:"; /*suppler*/';
		Replace($file, $pos, $text, $rep);
	}
	
	$file = "admin/language/russian/common/header.php";
	$text = "['text_module']";	
	$pos = FindText($file, $text, 1);
	
	if ($pos != 'yes') {	
		$text = ' 
	$_["text_suppler"]                	   = "Поставщики"; /*suppler*/'
	
		 ;
	
		Insert($file, $pos, $text);		
	}

	$file = "admin/language/russian/report/product_purchased.php";
	$text = "_['entry_status']";	
	$pos = FindText($file, $text, 1);
	
	if ($pos != 'yes') {	
		$text = ' 
	$_["text_total"]        = "Всего:";
	$_["entry_supp"]        = "Код поставщика:"; /*suppler*/'
		 ;
	
		Insert($file, $pos, $text);		
	}
	$text = "'Модель';";
	$pos = FindText($file, $text, 1);
	if ($pos != 'yes') {
		$rep = '"Код товара"; /*suppler*/';
		Replace($file, $pos, $text, $rep);
	}
	
	$file = "admin/model/report/product.php";
	$text = "GROUP BY op.model ORDER BY total DESC";	
	$pos = FindText($file, $text, 1);
	
	if ($pos != 'yes') {	
		$text = ' 
	if (!empty($data["filter_model"])) {
			$sql .=" AND op.model LIKE  ' . "'%-" . '" . $data' . '["filter_model"] .' . '"' . "'" . '";'  ."		
		} /*suppler*/"
		 ;
	
		Insert($file, $pos, $text);		
	}
	
	$file = "admin/view/template/report/product_purchased.tpl";
	$text = 'td style="text-align:';	
	$pos = FindText($file, $text, 1);
	
	if ($pos != 'yes') {	
		$text = ' 
		<td><?php echo $entry_supp; ?>
	    <input type="text" name="filter_model" value="0" id="data_model" size="3" /></td>  <!--*suppler*-->'
		 ;
	
		Insert($file, $pos, $text);		
	}
	$text = '<?php if ($products) { ?>';
	$pos = FindText($file, $text, 1);
	if ($pos != 'yes') {
		$rep = '<?php $summa = 0.0; if ($products) { ?>  <!--*suppler*-->';
		Replace($file, $pos, $text, $rep);
	}
	$text = '<td class="right">' . '<?php echo $product' . "['total']" . '; ?></td>';
	$pos = FindText($file, $text, 1);
	if ($pos != 'yes') {
		$rep = '<td class="right"><?php echo $product["total"]; $s = $product["total"]; $s = trim(preg_replace ("/[^0-9,.]/","",$s)); $s = preg_replace("| +|", "", $s); $summa = $summa+(float)str_replace(",",".",$s); ?></td>  <!--*suppler*-->';
		Replace($file, $pos, $text, $rep);
	}
	$text = '<?php } else { ?>';
	$pos = FindText($file, $text, 2);
	if ($pos != 'yes') {
		$text = '		
          <tr>		
            <td colspan="4" class="right"><b><?php echo $text_total."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $summa; ?></b> </td>             
          </tr> <!--*suppler*-->';
		Insert($file, $pos, $text);
	}
	$text = 'location = url';
	$pos = FindText($file, $text, 1);
	if ($pos != 'yes') {
		$text = "
		var filter_model = $('input[name=\'filter_model\']').attr('value');	
	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	} /*suppler*/";
		Insert($file, $pos, $text);
	}
	
	$file = "admin/view/template/common/header.tpl";
	$text = '<li><a href="<?php echo $download; ?>">';	
	$pos = FindText($file, $text, 1);
	
	if ($pos != 'yes') {	
		$text = ' 
		<li><a href="<?php echo $suppler; ?>"><?php echo $text_suppler; ?></a></li> <!--*suppler*-->'
;
	
		Insert($file, $pos, $text);		
	}
	echo " MODULE SUCCESSFULLY INSTALLED";  
	/********************************************************************/
	
	function Replace($file, $pos, $text, $rep) {
		$body = file_get_contents($file);
		$h1 = substr($body, 0, $pos);
		$h2 = substr($body, $pos+1);
		$h2 = str_replace($text, $rep , $h2);
		$body = $h1.$h2;
		$e = @file_put_contents($file, $body);
	}
	
	function Insert($file, $pos, $text) {		
		$body = file_get_contents($file);
		$h1 = substr($body, 0, $pos);
		$h2 = substr($body, $pos+1);
		$body = $h1.$text.$h2;
		$e = @file_put_contents($file, $body);
	}
	
	function FindText($file, $text, $n) {
		$body = file_get_contents($file);
		$p = 0;
		for ($i=1; $i<=$n; $i++) {
			$pos = stripos($body, $text, $p);
			if (!$pos) return "yes";			
			$p = $pos + 2;			
		}
		$h = substr($body, $pos-40, 80);
		if (substr_count($h, "*suppler*")) return "yes";
		
		for ($i=0; $i<60; $i++) {
			$s = substr($body, $pos-$i, 1);			
			if ($s == "}" or $s == ";" or $s == "," or $s == ">") break;
		}
		$pos = $pos - $i + 1;		
		
		return $pos;
	}

?>