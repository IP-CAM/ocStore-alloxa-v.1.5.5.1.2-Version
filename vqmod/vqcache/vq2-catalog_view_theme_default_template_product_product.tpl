<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content" class="product"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>

  <div class="product-info">
  <h1><?php echo $heading_title; ?></h1>
  <div id="notification"></div>
  <div class="compare-product-text" <?php if (!$compare_products) { ?>style="display:none;"<?php } ?>>
    <div class="compare-product-text-inside" style="text-align:center;width: 290px;">
      <?php if ($compare_products && count($compare_products) > 0) { ?>
        В списке товаров для сравнения <span class="count-compare"><?php echo count($compare_products); ?></span> шт.
      <?php } ?>
    </div>
    <?php if ($compare_current_product) { ?>
      <div class="compare-current-product" style="text-align:center;width: 290px;">
        <div class="compare-current-product-text">Данный товар в сравнении</div> <div class="compare-product-remove" onclick="removeOne($(this));">X</div>
      </div>
    <?php } ?>
    <div class="compare-links product" style="text-align:center;width: 290px;">
      <button onclick="removeAll();">Очистить</button>
      <a href="<?php echo $compare_link; ?>" title="К сравнению">К сравнению</a>
    </div>
    <div style="clear:both;"></div>
  </div>
    <?php if (($thumb || $images) && !$hide_image) { ?>
    <div class="left">
    
      <?php if ($thumb) { ?>
      <div class="image"><a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a></div>
      <?php } ?>
      <?php if ($images) { ?>
      <div class="image-additional">
        <?php foreach ($images as $image) { ?>
        <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
        <?php } ?>
      </div>
      <?php } ?>
    </div>
    <?php } ?>
    <div class="right">
      <?php if (!empty($delivery_text) && !empty($payment_text) && !empty($guarantee_text)) { ?>
        <div class="add-product-block">
          <div class="deliver-block">
            <img style="width: 39px;" src="/catalog/view/image/delivery.png" /> <span>Доставка</span> <a target="_blank" title="Доставка" href="/delivery">подробнее</a>
            <div><?php echo $delivery_text; ?></div>
          </div>
          <div class="deliver-block">
            <img style="width: 35px;" src="/catalog/view/image/payment.png" /> <span>Оплата</span> <a target="_blank" title="Оплата" href="/delivery">подробнее</a>
            <div><?php echo $payment_text; ?></div>
          </div>
          <div class="deliver-block">
            <img style="width: 35px;" src="/catalog/view/image/guarantee.png" /> <span>Гарантия</span>
            <div><?php echo $guarantee_text; ?></div>
          </div>
        </div>
      <?php } ?>
      <div class="description">
        <div class="top_pr">
          <div class="code-card">
            КОД ТОВАРА: <?php echo $model; ?>
          </div>
          <div class="compare">
            <a onclick="addToCompare('<?php echo $product_id; ?>');">сравнить</a>
          </div>
        </div>
        <div class="pr_title">
          <p><?php echo $heading_title; ?></p>
        </div>
        
       <!--  <?php if ($manufacturer) { ?>
        <span><?php echo $text_manufacturer; ?></span> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a><br />
        <?php } ?>
        <span><?php echo $text_model; ?></span> <?php echo $model; ?><br /> -->

			<?php if ($newfield1) { ?><span><?php echo $entry_newfield1; ?>:</span> <?php echo $newfield1; ?><br /><?php } ?>
			<?php if ($newfield2) { ?><span><?php echo $entry_newfield2; ?>:</span> <?php echo $newfield2; ?><br /><?php } ?>
			<?php if ($newfield3) { ?><span><?php echo $entry_newfield3; ?>:</span> <?php echo $newfield3; ?><br /><?php } ?>
			
            
    <!--     <?php if ($reward) { ?>
        <span><?php echo $text_reward; ?></span> <?php echo $reward; ?><br />
        <?php } ?> -->
      <?php if ($color || $memory) { ?>
        <div class="other-block">
          <?php if ($color && $colors) { ?>
            <div class="other-color-block">
              <div class="other-color-title">По цвету</div>
              <a title="<?php echo $heading_title; ?>" class="other-color current" style="background-color: <?php echo $color; ?>;"></a>
              <?php foreach ($colors as $one_color) { ?>
                <a href="<?php echo $one_color['href']; ?>" title="<?php echo $one_color['name']; ?>" class="other-color" style="background-color: <?php echo $one_color['color']; ?>;"></a>
              <?php } ?>
            </div>
          <?php } ?>
          <?php if ($memory && $memories) { ?>
            <div class="other-memory-block">
              <div class="other-memory-title">По памяти</div>
              <a title="<?php echo $heading_title; ?>" class="other-memory current"><?php echo $memory; ?> Gb</a>
              <?php foreach ($memories as $one_memory) { ?>
                <a href="<?php echo $one_memory['href']; ?>" title="<?php echo $one_memory['name']; ?>" class="other-memory"><?php echo $one_memory['memory']; ?> Gb</a>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
      <div class="order_block">
      <?php if ($price) { ?>
      <div class="price"><?php echo $text_price; ?>
        <?php if (!$special) { ?>
        <?php echo $price; ?>
        <?php } else { ?>
        <span class="price-old"><?php echo $price; ?></span> <span class="price-new"><?php echo $special; ?></span>
        <?php } ?>
        <!-- <br />
        <?php if ($tax) { ?>
        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span><br />
        <?php } ?>
        <?php if ($points) { ?>
        <span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span><br />
        <?php } ?> -->
        <?php if ($discounts) { ?>
        <br />
        <div class="discount">
          <?php foreach ($discounts as $discount) { ?>
          <?php echo sprintf($text_discount, $discount['quantity'], $discount['price']); ?><br />
          <?php } ?>
        </div>
        <?php } ?>



      </div>
      <div class="fast_order">
        <?php echo $catapulta; ?>
      </div>
      <?php } ?>
      <div class="gar_buy">
      <?php if ($options) { ?>
      <div class="options">
        <?php foreach ($options as $option) { ?>
        <?php if (!$option['required']) continue; ?>
        <?php if ($option['type'] == 'select') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php /* if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } */ ?>
          <b><?php echo $option['name']; ?>:</b>
          <select name="option[<?php echo $option['product_option_id']; ?>]">
            <!-- <option value=""><?php echo $text_select; ?></option> -->
            <?php foreach ($option['option_value'] as $option_value) { ?>
            <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
            </option>
            <?php } ?>
          </select>
        </div>
        <?php } ?>
        <?php if ($option['type'] == 'radio') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php /* if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } */  ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
          </label>
          <br />
          <?php } ?>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'checkbox') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php /* if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } */ ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
          </label>
          <br />
          <?php } ?>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'image') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php /* if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } */ ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <table class="option-image">
            <?php foreach ($option['option_value'] as $option_value) { ?>
            <tr>
              <td style="width: 1px;"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" /></td>
              <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /></label></td>
              <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                  <?php if ($option_value['price']) { ?>
                  (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                  <?php } ?>
                </label></td>
            </tr>
            <?php } ?>
          </table>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'text') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php /* if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } */ ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'textarea') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php /* if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } */ ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'file') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php /* if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } */ ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="button" value="<?php echo $button_upload; ?>" id="button-option-<?php echo $option['product_option_id']; ?>" class="button">
          <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'date') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php /* if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } */ ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'datetime') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php /* if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } */ ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'time') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php /* if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } */ ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
        </div>
        <br />
        <?php } ?>
        <?php } ?>
      </div>
      <?php } ?>

      <div class="cart">
        <div>
          <div class="q_pr">
            <p><?php echo $text_qty; ?></p>
            <input type="text" maxlength="2" name="quantity" size="2" value="<?php echo $minimum; ?>" />
            <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
          </div>
          <input type="button" value="<?php echo $button_cart; ?>" id="button-cart" class="button" />
          <!-- <span>&nbsp;&nbsp;<?php echo $text_or; ?>&nbsp;&nbsp;</span> -->
          <!-- <span class="links"><a onclick="addToWishList('<?php echo $product_id; ?>');"><?php echo $button_wishlist; ?></a><br />
            <a onclick="addToCompare('<?php echo $product_id; ?>');"><?php echo $button_compare; ?></a></span> -->
        </div>
        <?php if ($minimum > 1) { ?>
        <div class="minimum"><?php echo $text_minimum; ?></div>
        <?php } ?>
      </div>
      </div>
      </div>
      <div class="info_pr">
        <p class="nal"><?php echo $stock; ?></p>
      </div>
      <?php if ($short_description) { ?>
        <div class="short_description">
          <table class="about-item" cellpadding="0" cellspacing="0">
            <tbody>
              <?php foreach ($short_description as $attribute) { ?>
                <tr>
                  <td class="label"><?php echo $attribute['name']; ?> </td><td><?php echo $attribute['text']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      <?php } ?>
     

    </div>

     <!--  <?php if ($review_status) { ?>
      <div class="review">
        <div><img src="catalog/view/theme/default/image/stars-<?php echo $rating; ?>.png" alt="<?php echo $reviews; ?>" />&nbsp;&nbsp;<a onclick="$('a[href=\'#tab-review\']').trigger('click');"><?php echo $reviews; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('a[href=\'#tab-review\']').trigger('click');"><?php echo $text_write; ?></a></div>
        <div class="share">
			<div class="share42init" data-image="<?php echo $thumb; ?>"></div>
			<script type="text/javascript" src="catalog/view/javascript/jquery/share42/share42.js"></script> 
        </div>
      </div>
      <?php } ?> -->
    </div>
  </div>

  <script>
  $(document).ready(function() {
    $('td').each(function (i) {
      var my = $(this).html()
      if(my == 'есть'){
        $(this).addClass('yes')
        $(this).html('')
      }
      if(my == 'нет'){
        $(this).addClass('no')
        $(this).html('')
      }
    });
  });
  </script>        
  
  <?php /* if ($products) { ?>
  <div id="tab-related" class="">
    <div class="box-product">
      <?php foreach ($products as $product) { ?>
      <div>
        <?php if ($product['thumb']) { ?>
        <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($product['rating']) { ?>
        <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
        <?php } ?>
        <a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button"><?php echo $button_cart; ?></a></div>
      <?php } ?>
    </div>
  </div>
  <?php } */ ?>

  <div id="tabs" class="htabs"><?php if (!empty($description)) { ?><a href="#tab-description"><?php echo $tab_description; ?></a><?php } ?>
    <?php if ($attribute_groups) { ?>
    <a href="#tab-attribute"><?php echo $tab_attribute; ?></a>
    <?php } ?>
    <?php if ($review_status) { ?>
    <a href="#tab-review"><?php echo $tab_review; ?></a>
    <?php } ?>
   <!--  <?php if ($products) { ?>
    <a href="#tab-related"><?php echo $tab_related; ?> (<?php echo count($products); ?>)</a>
    <?php } ?> -->
  </div>
  <?php if (!empty($description)) { ?><div id="tab-description" class="tab-content"><?php echo $description; ?></div><?php } ?>
  <?php if ($attribute_groups) { ?>
  <div id="tab-attribute" class="tab-content">
    <table class="attribute">
      <?php foreach ($attribute_groups as $attribute_group) { ?>
      <thead>
        <tr>
          <td colspan="2"><?php echo $attribute_group['name']; ?></td>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
        <tr>
          <td><?php echo $attribute['name']; ?></td>
          <td><?php echo $attribute['text']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php } ?>
    </table>
  </div>
  <?php } ?>
  <?php if ($review_status) { ?>
  <div id="tab-review" class="tab-content">
    <div id="review"></div>
    <h2 id="review-title"><?php echo $text_write; ?></h2>
    <b><?php echo $entry_name; ?></b><br />
    <input type="text" name="name" value="" />
    <br />
    <br />
    <b><?php echo $entry_review; ?></b>
    <textarea name="text" cols="40" rows="8" style="width: 98%;"></textarea>
    <span style="font-size: 11px;"><?php echo $text_note; ?></span><br />
    <br />
    <b><?php echo $entry_rating; ?></b> <span><?php echo $entry_bad; ?></span>&nbsp;
    <input type="radio" name="rating" value="1" />
    &nbsp;
    <input type="radio" name="rating" value="2" />
    &nbsp;
    <input type="radio" name="rating" value="3" />
    &nbsp;
    <input type="radio" name="rating" value="4" />
    &nbsp;
    <input type="radio" name="rating" value="5" />
    &nbsp;<span><?php echo $entry_good; ?></span><br />
    <br />
    <b><?php echo $entry_captcha; ?></b><br />
    <input type="text" name="captcha" value="" />
    <br />
    <img src="index.php?route=product/product/captcha" alt="" id="captcha" /><br />
    <br />
  </div>
  <?php } ?>


  
 <!--  <?php if ($tags) { ?>
  <div class="tags"><b><?php echo $text_tags; ?></b>
    <?php for ($i = 0; $i < count($tags); $i++) { ?>
    <?php if ($i < (count($tags) - 1)) { ?>
    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
    <?php } else { ?>
    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
    <?php } ?>
    <?php } ?>
  </div>
  <?php } ?> -->
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		overlayClose: true,
		opacity: 0.5,
		rel: "colorbox"
	});
});
//--></script> 
<script type="text/javascript"><!--
$('#button-cart').bind('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
			
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}
			} 
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
					
				$('.success').fadeIn('slow');
					
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
});
//--></script>
<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
	action: 'index.php?route=product/product/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/default/image/loading.gif" class="loading" style="padding-left: 5px;" />');
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', true);
	},
	onComplete: function(file, json) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', false);
		
		$('.error').remove();
		
		if (json['success']) {
			alert(json['success']);
			
			$('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json['file']);
		}
		
		if (json['error']) {
			$('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json['error'] + '</span>');
		}
		
		$('.loading').remove();	
	}
});
//--></script>
<?php } ?>
<?php } ?>
<?php } ?>
<script type="text/javascript"><!--
$('#review .pagination a').live('click', function() {
	$('#review').fadeOut('slow');
		
	$('#review').load(this.href);
	
	$('#review').fadeIn('slow');
	
	return false;
});			

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').bind('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-review').attr('disabled', true);
			$('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-review').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data['error']) {
				$('#review-title').after('<div class="warning">' + data['error'] + '</div>');
			}
			
			if (data['success']) {
				$('#review-title').after('<div class="success">' + data['success'] + '</div>');
								
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	if ($.browser.msie && $.browser.version == 6) {
		$('.date, .datetime, .time').bgIframe();
	}

	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
	$('.datetime').datetimepicker({
		dateFormat: 'yy-mm-dd',
		timeFormat: 'h:m'
	});
	$('.time').timepicker({timeFormat: 'h:m'});
});
function removeOne(el) {
  var product_id = $('input[name="product_id"]').val();
  var count_compare = parseInt($('.count-compare').text());
  $.ajax({
    url: 'index.php?route=product/compare/remove',
    type: 'post',
    data: 'product_id=' + product_id,
    dataType: 'json',
    success: function(json) {
      if (count_compare > 1) {
        $('.count-compare').text(count_compare - 1);
        $('.compare-current-product').remove();
      } else {
        jQuery('.compare-product-text > div').remove();
        jQuery('.compare-product-text').hide();
      }
    }
  });
}
function removeAll() {
  $.ajax({
    url: 'index.php?route=product/compare/removeAll',
    type: 'post',
    dataType: 'json',
    success: function(json) {
      jQuery('.compare-product-text > div').remove();
      jQuery('.compare-product-text').hide();
    }
  });
}
//--></script> 
<?php echo $footer; ?>