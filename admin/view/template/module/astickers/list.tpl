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
   <div class="buttons">
    <a class="button" onclick="location = '<?php echo $insert; ?>'"><span><?php echo $button_insert; ?></span></a>
    <a class="button" onclick="$('form').submit();"><span><?php echo $button_delete; ?></span></a>
    <a class="button" onclick="location = '<?php echo $cancel; ?>'"><span><?php echo $button_cancel; ?></span></a>
   </div>
   <div class="buttons" style="margin-right:45px;">
    <a class="button" onclick="location = '<?php echo $products; ?>'"><span><?php echo $button_products; ?></span></a>
    <a class="button" onclick="location = '<?php echo $settings; ?>'"><span><?php echo $button_settings; ?></span></a>
   </div>
  </div>
  <div class="content">
   <?php if ($astickers) { ?>
   <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
    <table class="list" id="astickers">
     <thead>
      <tr>
       <td class="center" width="1"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
       <td class="center" width="1"><?php echo $column_image; ?></td>
       <td class="left"><a href="<?php echo $sort_name; ?>" class="<?php echo ($sort == 'ast.name') ? strtolower($order) : ''; ?>"><?php echo $column_asticker_name; ?></a></td>
       <td class="center" width="20%"><a href="<?php echo $sort_sort_order; ?>" class="<?php echo ($sort == 'ast.sort_order') ? strtolower($order) : ''; ?>"><?php echo $column_sort_order; ?></a></td>
       <td class="center" width="10%"><?php echo $column_action; ?></td>
      </tr>
     </thead>
     <tbody>
      <?php foreach ($astickers as $asticker) { ?>
      <tr class="<?php echo ($asticker['selected']) ? 'selected' : ''; ?>">
       <td class="center">
        <?php if ($asticker['selected']) { ?>
        <input type="checkbox" name="selected[]" value="<?php echo $asticker['asticker_id']; ?>" checked="checked" />
        <?php } else { ?>
        <input type="checkbox" name="selected[]" value="<?php echo $asticker['asticker_id']; ?>" />
        <?php } ?>
       </td>
       <td class="center">
        <div style="position:relative;">
         <?php foreach ($positions as $position=>$value) { ?>
         <?php if ($asticker['images'][$position]) { ?>
         <div style="position:absolute; width:100%; height:98%; background:url(<?php echo HTTP_IMAGE . $asticker['images'][$position]; ?>) <?php echo $value; ?> no-repeat;"></div>
         <?php } ?>
         <?php } ?>
         <img src="<?php echo $no_image; ?>" alt="<?php echo $no_image; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" />
        </div>
       </td>
       <td class="left name"><?php echo $asticker['name']; ?></td>
       <td class="center"><?php echo $asticker['sort_order']; ?></td>
       <td class="center">[<a href="<?php echo $asticker['edit']; ?>"><?php echo $text_edit; ?></a>]
       </td>
      </tr>
      <?php } ?>
     </tbody>
    </table>
   </form>
   <div class="pagination"><?php echo $pagination; ?></div>
   <?php } else { ?>
   <div class="attention" align="center"><?php echo $text_no_results; ?></div>
   <?php } ?>
  </div>
 </div>
</div>
<script type="text/javascript"><!--
$(function() {
	$('#astickers tbody input[type="checkbox"]').click(function() {
		if ($(this).attr('checked')) {
			$(this).parent('td').parent('tr').addClass('selected');
		} else {
			$(this).parent('td').parent('tr').removeClass('selected');
		}
	});
	
	$('#astickers thead input[type="checkbox"]').click(function() {
		if ($(this).attr('checked')) {
			$('#astickers tbody tr').addClass('selected');
		} else {
			$('#astickers tbody tr').removeClass('selected');
		}
	});
});
//--></script>
<?php echo $footer; ?>