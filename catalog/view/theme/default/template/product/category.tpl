<?php echo $header; ?>
<div class="cat">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
</div>
<?php if (!$categories || ($categories && !$show_categories)) { ?><?php echo $column_left; ?><?php } ?>

<?php echo $column_right; ?>

<div id="content" class="<?php if (!$categories || ($categories && !$show_categories)) { ?><?php echo 'cat'; ?><?php } ?>"><?php echo $content_top; ?>
  <?php if ($categories && $show_categories) { ?>
  <div class="category-list">
    <?php if (count($categories) <= 5) { ?>
    <ul>
      <?php foreach ($categories as $category) { ?>
      <li><a href="<?php echo $category['href']; ?>"><img src="<?php echo $category['thumb']; ?>"><span><?php echo $category['name']; ?></a></span></li>
      <?php } ?>
    </ul>
    <?php } else { ?>
    <?php for ($i = 0; $i < count($categories);) { ?>
    <ul>
      <?php $j = $i + ceil(count($categories) / 4); ?>
      <?php for (; $i < $j; $i++) { ?>
      <?php if (isset($categories[$i])) { ?>
      <li><a href="<?php echo $categories[$i]['href']; ?>"><img src="<?php echo $categories[$i]['thumb']; ?>"><span><?php echo $categories[$i]['name']; ?></span></a></li>
      <?php } ?>
      <?php } ?>
    </ul>
    <?php } ?>
    <?php } ?>
  </div>
  <?php } ?>
  <?php if (!$categories || ($categories && !$show_categories)) { ?>
  <?php if (isset($parent_lines) && !empty($parent_lines)) { ?>
    <div class="category-lines">
      <?php foreach ($parent_lines as $parent_line) { ?>
        <?php if ($parent_line['line'] && $parent_line['line_on']) { ?>
          <div class="category-line <?php echo $parent_line['is_it'] ? 'is_it' : ''; ?>">
            <a href="<?php echo $parent_line['href']; ?>" title="<?php echo $parent_line['name']; ?>"><?php echo $parent_line['name']; ?></a>
          </div>
        <?php } ?>
      <?php } ?>
    </div>
  <?php } ?>
  <?php if (isset($lines) && !empty($lines)) { ?>
    <div class="category-lines">
      <?php foreach ($lines as $line) { ?>
        <?php if ($line['line'] && $line['line_on']) { ?>
          <div class="category-line <?php echo $line['is_it'] ? 'is_it' : ''; ?>">
            <a href="<?php echo $line['href']; ?>" title="<?php echo $line['name']; ?>"><?php echo $line['name']; ?></a>
          </div>
        <?php } ?>
      <?php } ?>
    </div>
  <?php } ?>
  <?php if ($line_true) { ?>
    <div class="category-lines">
      <?php foreach ($categories as $category) { ?>
        <?php if ($category['line'] && $category['line_on']) { ?>
          <div class="category-line <?php echo $category['is_it'] ? 'is_it' : ''; ?>">
            <a href="<?php echo $category['href']; ?>" title="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></a>
          </div>
        <?php } ?>
      <?php } ?>
    </div>
  <?php } ?>
  <?php if ($products) { ?>
      <div id="notification"></div>
    <div class="compare-category" <?php if (!$compare_products) { ?>style="display:none;"<?php } ?>>
        ВЫБРАНО ДЛЯ СРАВНЕНИЯ:
        <div class="compare-category-products">
          <?php if ($compare_products) { ?>
            <?php foreach ($compare_products as $compare_product) { ?>
              <div class="compare-product" data-product-id="<?php echo $compare_product['product_id']; ?>">
                <a href="<?php echo $compare_product['href']; ?>" title="<?php echo $compare_product['name']; ?>" ><img src="<?php echo $compare_product['image']; ?>" alt="<?php echo $compare_product['name']; ?>" /></a>
                <a class="text-link" href="<?php echo $compare_product['href']; ?>" title="<?php echo $compare_product['name']; ?>" ><?php echo $compare_product['name']; ?></a>
                <div class="compare-product-remove" onclick="removeOne($(this));">X</div>
              </div>
            <?php } ?>
          <?php } ?>
        </div>
        <div class="compare-links">
          <button onclick="removeAll();">Очистить</button>
          <a href="<?php echo $compare_link; ?>" title="К сравнению">К сравнению</a>
        </div>
    </div>
  <div class="product-filter">
    <div class="display"><b><?php echo $text_display; ?></b> <?php echo $text_list; ?> <b>/</b> <a onclick="display('grid');"><?php echo $text_grid; ?></a></div>
    <!-- <div class="limit"><b><?php echo $text_limit; ?></b>
      <select onchange="location = this.value;">
        <?php foreach ($limits as $limits) { ?>
        <?php if ($limits['value'] == $limit) { ?>
        <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div> -->
  <!-- <div class="product-compare"><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></div> -->
    <div class="sort"><b><?php echo $text_sort; ?></b>
      <select onchange="location = this.value;">
        <?php foreach ($sorts as $sorts) { ?>
        <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
        <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="product-list">
    <?php foreach ($products as $product) { ?>
    <div>
      <?php if ($product['thumb']) { ?>
      <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
      <?php } ?>
      <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
      <div class="description"><?php echo $product['description']; ?></div>
      <div class="model">Код товара: <?php echo $product['model']; ?></div>
      <?php if ($product['price']) { ?>
      <div class="price">
        <?php if (!$product['special']) { ?>

        <?php echo $product['price']; ?>
        <?php } else { ?>
        <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
        <?php } ?>
        <?php if ($product['tax']) { ?>
        <br />
        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
        <?php } ?>
      </div>
      <?php } ?>
      <?php if ($product['rating']) { ?>
      <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
      <?php } ?>
      <div class="cart">
        <input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" />
      </div>
      <!-- <div class="wishlist"><a onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $button_wishlist; ?></a></div> -->
      <div class="compare"><a onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?></a></div>
    </div>
    <?php } ?>
  </div>
  <div class="pagination"><?php echo $pagination; ?></div>
  <?php } ?>
  <?php } ?>
  <?php if ($thumb || $description) { ?>
  <div class="category-info">
    <?php if ($thumb) { ?>
    <div class="image"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" /></div>
    <?php } ?>
    <?php if ($description) { ?>
    <?php echo $description; ?>
    <?php } ?>
  </div>
  <?php } ?>
  <?php if (!$categories && !$products) { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <?php } ?>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
function display(view) {
  if (view == 'list') {
    $('.product-grid').attr('class', 'product-list');
    
    $('.product-list > div').each(function(index, element) {
      html  = '<div class="right">';
      html += '  <div class="cart">' + $(element).find('.cart').html() + '</div>';
      // html += '  <div class="wishlist">' + $(element).find('.wishlist').html() + '</div>';
      html += '  <div class="compare">' + $(element).find('.compare').html() + '</div>';
      html += '</div>';     
      
      html += '<div class="left">';
      
      var image = $(element).find('.image').html();
      
      if (image != null) { 
        html += '<div class="image">' + image + '</div>';
      }

      var model = $(element).find('.model').html();

      if (model != null) {
        html += '<div class="model">' + model + '</div>';
      }
      
      var price = $(element).find('.price').html();
      
      if (price != null) {
        html += '<div class="price">' + price  + '</div>';
      }
          
      html += '  <div class="name">' + $(element).find('.name').html() + '</div>';
      html += '  <div class="description">' + $(element).find('.description').html() + '</div>';
      
      var rating = $(element).find('.rating').html();
      
      if (rating != null) {
        html += '<div class="rating">' + rating + '</div>';
      }
        
      html += '</div>';
            
      $(element).html(html);
    });   
    
    $('.display').html('<b><?php echo $text_display; ?></b> <?php echo $text_list; ?> <b>/</b> <a onclick="display(\'grid\');"><?php echo $text_grid; ?></a>');
    
    $.totalStorage('display', 'list'); 
  } else {
    $('.product-list').attr('class', 'product-grid');
    
    $('.product-grid > div').each(function(index, element) {
      html = '';
      
      var image = $(element).find('.image').html();
      
      if (image != null) {
        html += '<div class="image">' + image + '</div>';
      }
      
      html += '<div class="name">' + $(element).find('.name').html() + '</div>';
      html += '<div class="description">' + $(element).find('.description').html() + '</div>';

      var model = $(element).find('.model').html();

      if (model != null) {
        html += '<div class="model">' + model + '</div>';
      }
      
      var price = $(element).find('.price').html();
      
      if (price != null) {
        html += '<div class="price">' + price  + '</div>';
      }
      
      var rating = $(element).find('.rating').html();
      
      if (rating != null) {
        html += '<div class="rating">' + rating + '</div>';
      }
            
      html += '<div class="cart">' + $(element).find('.cart').html() + '</div>';
      // html += '<div class="wishlist">' + $(element).find('.wishlist').html() + '</div>';
      html += '<div class="compare">' + $(element).find('.compare').html() + '</div>';
      
      $(element).html(html);
    }); 
          
    $('.display').html('<b><?php echo $text_display; ?></b> <a onclick="display(\'list\');"><?php echo $text_list; ?></a> <b>/</b> <?php echo $text_grid; ?>');
    
    $.totalStorage('display', 'grid');
  }
}

view = $.totalStorage('display');

if (view) {
  display(view);
} else {
  display('grid');
}

function removeOne(el) {
  var product_id = el.parent('.compare-product').data('product-id');
  $.ajax({
    url: 'index.php?route=product/compare/remove',
    type: 'post',
    data: 'product_id=' + product_id,
    dataType: 'json',
    success: function(json) {
      if (el.parent('.compare-product').siblings('.compare-product').length > 0) {
        el.parent().remove(); 
      } else {
        el.parents('.compare-category-products').children('.compare_product').remove();
        el.parents('.compare-category').hide();  
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
      jQuery('.compare-category-products > div').remove();
      jQuery('.compare-category').hide();
      jQuery('.compare-product').hide();
    }
  });
}
//--></script> 
<?php echo $footer; ?>