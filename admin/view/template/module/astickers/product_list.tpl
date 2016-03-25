<?php echo $header; ?>
<style type="text/css">
.selected td {
	background:#E4EEF7 !important;
}
.name {
	font-size:13px;
	font-weight:bold;
}
</style>
<div id="content">
 <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
 </div>
 <?php if ($error_warning) { ?>
 <div class="warning"><?php echo $error_warning; ?></div>
 <?php } ?>
 <?php if ($success) { ?>
 <div class="success"><?php echo $success; ?></div>
 <script type="text/javascript">$('.success').fadeOut(7000);</script>
 <?php } ?>
 <div class="box">
  <div class="heading">
   <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
   <div class="buttons"><a onclick="location = '<?php echo $cancel; ?>'" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <table class="list">
     <thead>
      <tr>
       <td class="left"><?php echo $column_name; ?></td>
       <td class="left"><?php echo $column_categories; ?></td>
       <td class="left"><?php echo $column_asticker_name; ?></td>
       <td class="left"><?php echo $column_date_start; ?></td>
       <td class="left"><?php echo $column_date_end; ?></td>
      </tr>
     </thead>
     <tbody>
      <tr class="filter">
       <td class="left"><input name="filter_keyword" type="text" value="<?php echo $filter_keyword; ?>" size="100" /></td>
       <td class="left">
        <form id="form_fc_id">
         <div class="scrollbox">
          <?php $class = 'odd'; ?>
          <?php foreach ($categories as $category) { ?>
          <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
          <div class="<?php echo $class; ?>">
           <?php if (in_array ($category['category_id'], $filter_category_id)) { ?>
           <input type="checkbox" name="fc_id[]" value="<?php echo $category['category_id']; ?>" checked="checked" /> <?php echo $category['name']; ?>
           <?php } else { ?>
           <input type="checkbox" name="fc_id[]" value="<?php echo $category['category_id']; ?>" /> <?php echo $category['name']; ?>
           <?php } ?>
          </div>
          <?php } ?>
         </div>
        </form>
       </td>
       <td class="left">
        <form id="form_a_id">
         <div class="scrollbox">
          <?php $class = 'odd'; ?>
          <?php foreach ($astickers as $asticker) { ?>
          <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
          <div class="<?php echo $class; ?>">
           <?php if (in_array ($asticker['asticker_id'], $filter_asticker_id)) { ?>
           <input type="checkbox" name="fa_id[]" value="<?php echo $asticker['asticker_id']; ?>" checked="checked" /> <?php echo $asticker['name']; ?>
           <?php } else { ?>
           <input type="checkbox" name="fa_id[]" value="<?php echo $asticker['asticker_id']; ?>" /> <?php echo $asticker['name']; ?>
           <?php } ?>
          </div>
          <?php } ?>
         </div>
        </form>
       </td>
       <td class="left"><input name="filter_asticker_date_start" class="date" type="text" value="<?php echo $filter_asticker_date_start; ?>" /></td>
       <td class="left"><input name="filter_asticker_date_end" class="date" type="text" value="<?php echo $filter_asticker_date_end; ?>" /></td>
      </tr>
     </tbody>
     <tfoot>
      <tr>
       <td class="center" colspan="5"><a class="button" onclick="filter();"><?php echo $button_filter; ?></a></td>
      </tr>
     </tfoot>
    </table>
   <?php if ($products) { ?>
   <form id="form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div class="pagination" style="margin-bottom:20px;"><?php echo $pagination; ?></div>
    <table class="list" id="products">
     <thead>
      <tr>
       <td class="left" colspan="3"></td>
       <td class="left">
        <select name="asticker_id">
         <option value="0"><?php echo $text_none; ?></option>
         <?php foreach ($astickers as $asticker) { ?>
         <?php if ($asticker['asticker_id'] == $asticker_id) { ?>
         <option value="<?php echo $asticker['asticker_id']; ?>" selected="selected"><?php echo $asticker['name']; ?></option>
         <?php } else { ?>
         <option value="<?php echo $asticker['asticker_id']; ?>"><?php echo $asticker['name']; ?></option>
         <?php } ?>
         <?php } ?>
        </select>
       </td>
       <td class="center"><input name="asticker_date_start" class="date" type="text" value="<?php echo $asticker_date_start; ?>" /></td>
       <td class="center"><input name="asticker_date_end" class="date" type="text" value="<?php echo $asticker_date_end; ?>" /></td>
       <td class="center" colspan="3"><a class="button" onclick="$('#form').submit();"><?php echo $text_edit; ?></a></td>
      </tr>
     </thead>
     <thead>
      <tr>
       <td class="center" width="1"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
       <td class="center" width="1"><a href="<?php echo $sort_image; ?>" class="<?php echo ($sort == 'p.image') ? strtolower($order) : ''; ?>"><?php echo $column_image; ?></a></td>
       <td class="left"><a href="<?php echo $sort_product_name; ?>" class="<?php echo ($sort == 'pd.name') ? strtolower($order) : ''; ?>"><?php echo $column_name; ?></a></td>
       <td class="left"><a href="<?php echo $sort_name; ?>" class="<?php echo ($sort == 'ast.name') ? strtolower($order) : ''; ?>"><?php echo $column_asticker_name; ?></a></td>
       <td class="center" width="10%"><a href="<?php echo $sort_date_start; ?>" class="<?php echo ($sort == 'p.asticker_date_start') ? strtolower($order) : ''; ?>"><?php echo $column_date_start; ?></a></td>
       <td class="center" width="10%"><a href="<?php echo $sort_date_end; ?>" class="<?php echo ($sort == 'p.asticker_date_end') ? strtolower($order) : ''; ?>"><?php echo $column_date_end; ?></a></td>
       <td class="center" width="10%"><a href="<?php echo $sort_price; ?>" class="<?php echo ($sort == 'p.price') ? strtolower($order) : ''; ?>"><?php echo $column_price; ?></a></td>
       <td class="center" width="10%"><a href="<?php echo $sort_date_available; ?>" class="<?php echo ($sort == 'p.date_available') ? strtolower($order) : ''; ?>"><?php echo $column_date_available; ?></a></td>
       <td class="center" width="10%"><a href="<?php echo $sort_sort_order; ?>" class="<?php echo ($sort == 'p.sort_order') ? strtolower($order) : ''; ?>"><?php echo $column_sort_order; ?></a></td>
      </tr>
     </thead>
     <tbody>
      <?php foreach ($products as $product) { ?>
      <?php $class = ($product['selected']) ? 'selected' : ''; ?>
      <tr class="<?php echo $class; ?>">
       <td class="center">
        <?php if ($product['selected']) { ?>
        <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" checked="checked" />
        <?php } else { ?>
        <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" />
        <?php } ?>
       </td>
       <td class="center">
        <div class="image">
         <a href="<?php echo $product['href']; ?>" target="_blank"><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['image']; ?>" /></a>
        </div>
       </td>
       <td class="left name"><?php echo $product['name']; ?></td>
       <td class="left name"><?php echo $product['asticker_name']; ?></td>
       <td class="center"><?php echo $product['asticker_date_start']; ?></td>
       <td class="center"><?php echo $product['asticker_date_end']; ?></td>
       <td class="center"><?php echo $product['price']; ?></td>
       <td class="center"><?php echo $product['date_available']; ?></td>
       <td class="center"><?php echo $product['sort_order']; ?></td>
      </tr>
      <?php } ?>
     </tbody>
    </table>
    <div class="pagination"><?php echo $pagination; ?></div>
   </form>
   <?php } else { ?>
   <div class="attention" align="center"><?php echo $text_no_results; ?></div>
   <?php } ?>
  </div>
 </div>
</div>
<?php include ($astickers_tpl); ?>
<script type="text/javascript"><!--
$('.date').datepicker({dateFormat: 'yy-mm-dd'});

$('input[name=\'filter_keyword\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'filter_keyword\']').val(ui.item.label);
		
		return false;
	}
});

$(function() {
	$('#products tbody input[type="checkbox"]').click(function() {
		if ($(this).attr('checked')) {
			$(this).parent('td').parent('tr').addClass('selected');
		} else {
			$(this).parent('td').parent('tr').removeClass('selected');
		}
	});
	
	$('#products thead input[type="checkbox"]').click(function() {
		if ($(this).attr('checked')) {
			$('#products tbody tr').addClass('selected');
		} else {
			$('#products tbody tr').removeClass('selected');
		}
	});
});
//--></script>

<script type="text/javascript"><!--
function filter() {
	var url = '';
	
	filter_keyword = $('input[name=\'filter_keyword\']').val();
	
	if (filter_keyword) {
		url += '&filter_keyword=' + filter_keyword;
	}
	
	fc_id = $('#form_fc_id').serialize();
	
	if (fc_id) {
		url += '&' + fc_id;
	}
	
	a_id = $('#form_a_id').serialize();
	
	if (a_id) {
		url += '&' + a_id;
	}
	
	filter_asticker_date_start = $('input[name=\'filter_asticker_date_start\']').val();
	
	if (filter_asticker_date_start) {
		url += '&filter_asticker_date_start=' + filter_asticker_date_start;
	}
	
	filter_asticker_date_end = $('input[name=\'filter_asticker_date_end\']').val();
	
	if (filter_asticker_date_end) {
		url += '&filter_asticker_date_end=' + filter_asticker_date_end;
	}
	
	location = 'index.php?route=module/astickers/getProducts&token=<?php echo $token; ?>' + url;
}
//--></script>
<script type="text/javascript">
 $(document).ready(function() {
//  $('.scrollbox').resizable();
  $(".scrollbox")
          .wrap('<div/>')
          .css({'overflow':'hidden'})
          .parent()
          .css({'display':'inline-block',
                  'overflow':'hidden',
                  'height':function(){return $('.scrollbox',this).height();},
                  'width':  function(){return $('.scrollbox',this).width();},
                  'paddingBottom':'12px',
                  'paddingRight':'12px'

                 }).resizable()
          .find('.scrollbox')
          .css({overflow:'auto',
                            width:'100%',
                            height:'100%'});
 });
</script>
<?php echo $footer; ?>