<?php echo $header; ?>
<div id="content">
 <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
 </div>
 <?php if ($error_warning) { ?>
 <div class="warning"><?php echo $error_warning; ?></div>
 <?php } ?>
 <div class="box">
  <div class="heading">
   <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
   <div class="buttons">
    <a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a>
    <a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a>
   </div>
  </div>
  <div class="content">
   <form id="form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <table class="form">
     <tr>
      <td><span class="required">*</span> <?php echo $entry_name; ?></td>
      <td>
       <input name="name" value="<?php echo $name; ?>" size="64" />
       <?php if ($error_name) { ?>
       <span class="error"><?php echo $error_name; ?></span>
       <?php } ?>
      </td>
     </tr>
     <tr>
      <td><?php echo $entry_image; ?></td>
      <td>
       <table class="list" style="width:auto;">
        <tr>
         <?php $i = 0; ?>
         <?php foreach ($positions as $position=>$value) { ?>
         <td class="center">
          <input name="images[<?php echo $position; ?>]" type="hidden" value="<?php echo $images[$position]; ?>" id="image_<?php echo $position; ?>" />
          <a onclick="image_upload('image_<?php echo $position; ?>', 'thumb_<?php echo $position; ?>');" title="<?php echo $text_browse; ?>"><img id="thumb_<?php echo $position; ?>" src="<?php echo $images['thumb_' . $position]; ?>" /></a><br />
          <a onclick="$('#thumb_<?php echo $position; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image_<?php echo $position; ?>').attr('value', '');"><?php echo $text_clear; ?></a>
         </td>
         <?php $i++; ?>
         <?php if ($i % 3 == 0) { ?>
         </tr><tr>
         <?php } ?>
         <?php } ?>
        </tr>
       </table>
      </td>
     </tr>
     <tr>
      <td><?php echo $entry_sort_order; ?></td>
      <td><input name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
     </tr>
    </table>
   </form>
  </div>
 </div>
</div>
<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>
<?php echo $footer; ?>