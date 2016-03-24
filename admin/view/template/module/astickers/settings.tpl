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
  <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
  <div class="buttons">
   <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
   <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
  </div>
 </div>
 <div class="content">
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
   <div id="tabs" class="htabs">
    <a href="#tab-general"><?php echo $tab_general; ?></a>
    <a href="#tab-systems"><?php echo $tab_systems; ?></a>
   </div>
   <div id="tab-general">
   <table class="form">
    <tbody>
     <tr>
      <td class="left" style="width:30%;"><?php echo $entry_class; ?></td>
      <td class="left"><input name="astickers_settings[class]" type="text" value="<?php echo $settings['class']; ?>" /></td>
     </tr>
     <tr>
      <td class="left"><?php echo $entry_class_main_image; ?></td>
      <td class="left"><input name="astickers_settings[class_main_image]" type="text" value="<?php echo $settings['class_main_image']; ?>" /></td>
     </tr>
     <tr>
      <td class="left"><?php echo $entry_class_tabs; ?></td>
      <td class="left"><input name="astickers_settings[class_tabs]" type="text" value="<?php echo $settings['class_tabs']; ?>" /></td>
     </tr>
     <tr>
      <td class="left"><?php echo $entry_min_width; ?></td>
      <td class="left"><input name="astickers_settings[min_width]" type="text" value="<?php echo $settings['min_width']; ?>" size="3" /></td>
     </tr>
     <tr>
      <td class="left"><?php echo $entry_min_height; ?></td>
      <td class="left"><input name="astickers_settings[min_height]" type="text" value="<?php echo $settings['min_height']; ?>" size="3" /></td>
     </tr>
     <tr>
      <td class="left"><?php echo $entry_z_index; ?></td>
      <td class="left"><input name="astickers_settings[z_index]" type="text" value="<?php echo $settings['z_index']; ?>" size="3" /></td>
     </tr>
     <tr>
      <td class="left"><?php echo $entry_hide_hover; ?></td>
      <td class="left">
       <select name="astickers_settings[hide_hover]">
        <?php if ($settings['hide_hover']) { ?>
        <option value="0"><?php echo $text_no; ?></option>
        <option value="1" selected="selected"><?php echo $text_yes; ?></option>
        <?php } else { ?>
        <option value="0" selected="selected"><?php echo $text_no; ?></option>
        <option value="1"><?php echo $text_yes; ?></option>
        <?php } ?>
       </select>
      </td>
     </tr>
     <tr>
      <td class="left"><?php echo $entry_show_effect; ?></td>
      <td class="left">
       <select name="astickers_settings[show_effect]">
        <?php foreach ($effects as $effect) { ?>
        <?php if ($settings['show_effect'] && ($settings['show_effect'] == $effect)) { ?>
        <option value="<?php echo $effect; ?>" selected="selected"><?php echo $effect; ?></option>
        <?php } else { ?>
        <option value="<?php echo $effect; ?>"><?php echo $effect; ?></option>
        <?php } ?>
        <?php } ?>
       </select>
      </td>
     </tr>
    </tbody>
   </table>
   <table class="list" id="module">
    <thead>
     <tr>
      <td class="left"><?php echo $entry_layout; ?></td>
      <td class="left"><?php echo $entry_position; ?></td>
      <td class="left"><?php echo $entry_status; ?></td>
      <td class="right"><?php echo $entry_sort_order; ?></td>
      <td></td>
     </tr>
    </thead>
    <?php $module_row = 0; ?>
    <?php foreach ($modules as $module) { ?>
    <tbody id="module-row<?php echo $module_row; ?>">
     <tr>
      <td class="left">
       <select name="astickers_module[<?php echo $module_row; ?>][layout_id]">
        <?php foreach ($layouts as $layout) { ?>
        <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
        <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
        <?php } ?>
        <?php } ?>
       </select>
      </td>
      <td class="left">
       <select name="astickers_module[<?php echo $module_row; ?>][position]">
        <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
       </select>
      </td>
      <td class="left">
       <select name="astickers_module[<?php echo $module_row; ?>][status]">
        <?php if ($module['status']) { ?>
        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
        <option value="0"><?php echo $text_disabled; ?></option>
        <?php } else { ?>
        <option value="1"><?php echo $text_enabled; ?></option>
        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
        <?php } ?>
       </select>
      </td>
      <td class="right"><input type="text" name="astickers_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
      <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
     </tr>
    </tbody>
    <?php $module_row++; ?>
    <?php } ?>
    <tfoot>
     <tr>
      <td colspan="4"></td>
      <td class="left"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
     </tr>
    </tfoot>
   </table>
   </div>
   
   
   <div id="tab-systems">
   <table class="form">
    <tbody>
     <tr>
      <td class="left" colspan="2" style="background:#EFEFEF; border-top:1px dotted #CCC;"><b><?php echo $entry_special; ?></b></td>
     <tr>
      <td class="left" style="width:30%;"><?php echo $entry_status; ?></td>
      <td class="left">
       <select name="astickers_settings[special_status]">
        <?php if ($settings['special_status']) { ?>
        <option value="0"><?php echo $text_disabled; ?></option>
        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
        <?php } else { ?>
        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
        <option value="1"><?php echo $text_enabled; ?></option>
        <?php } ?>
       </select>
      </td>
     </tr>
     <tr>
      <td class="left"><?php echo $entry_position; ?></td>
      <td class="left">
       <select name="astickers_settings[special_position]">
        <?php foreach ($positions as $position=>$value) { ?>
        <?php if ($settings['special_position'] == $position) { ?>
        <option value="<?php echo $position; ?>" selected="selected"><?php echo ${'text_' . $position}; ?></option>
        <?php } else { ?>
        <option value="<?php echo $position; ?>"><?php echo ${'text_' . $position}; ?></option>
        <?php } ?>
        <?php } ?>
       </select>
      </td>
     </tr>
     <tr>
      <td class="left"><?php echo $column_image; ?></td>
      <td class="left"><input id="special_image" type="hidden" name="astickers_settings[special_image]" value="<?php echo $settings['special_image']; ?>" /><a onclick="image_upload('special_image', 'special_thumb');" title="<?php echo $text_browse; ?>"><img id="special_thumb" src="<?php echo $special_thumb; ?>" /></a><br /><a onclick="$('#special_thumb').attr('src', '<?php echo $no_image; ?>'); $('#special_image').attr('value', '');"><?php echo $text_clear; ?></a></td>
     </tr>
     <tr>
      <td class="left" colspan="2" style="background:#EFEFEF;"><b><?php echo $entry_new; ?></b></td>
     <tr>
     <tr>
      <td class="left"><?php echo $entry_status; ?></td>
      <td class="left">
       <select name="astickers_settings[new_status]">
        <?php if ($settings['new_status']) { ?>
        <option value="0"><?php echo $text_disabled; ?></option>
        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
        <?php } else { ?>
        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
        <option value="1"><?php echo $text_enabled; ?></option>
        <?php } ?>
       </select>
      </td>
     </tr>
     <tr>
      <td class="left"><?php echo $entry_position; ?></td>
      <td class="left">
       <select name="astickers_settings[new_position]">
        <?php foreach ($positions as $position=>$value) { ?>
        <?php if ($settings['new_position'] == $position) { ?>
        <option value="<?php echo $position; ?>" selected="selected"><?php echo ${'text_' . $position}; ?></option>
        <?php } else { ?>
        <option value="<?php echo $position; ?>"><?php echo ${'text_' . $position}; ?></option>
        <?php } ?>
        <?php } ?>
       </select>
      </td>
     </tr>
     <tr>
      <td class="left"><?php echo $column_image; ?></td>
      <td class="left"><input id="new_image" type="hidden" name="astickers_settings[new_image]" value="<?php echo $settings['new_image']; ?>" /><a onclick="image_upload('new_image', 'new_thumb');" title="<?php echo $text_browse; ?>"><img id="new_thumb" src="<?php echo $new_thumb; ?>" /></a><br /><a onclick="$('#new_thumb').attr('src', '<?php echo $no_image; ?>'); $('#new_image').attr('value', '');"><?php echo $text_clear; ?></a>
      </td>
     </tr>
     <tr>
      <td class="left"><?php echo $entry_days_new; ?></td>
      <td class="left"><input name="astickers_settings[days_new]" type="text" value="<?php echo $settings['days_new']; ?>" size="3" /></td>
     </tr>
     <tr>
      <td class="left" colspan="2" style="background:#EFEFEF;"><b><?php echo $entry_manufacturer; ?></b></td>
     <tr>
     <tr>
      <td class="left"><?php echo $entry_status; ?></td>
      <td class="left">
       <select name="astickers_settings[manufacturer_status]">
        <?php if ($settings['manufacturer_status']) { ?>
        <option value="0"><?php echo $text_disabled; ?></option>
        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
        <?php } else { ?>
        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
        <option value="1"><?php echo $text_enabled; ?></option>
        <?php } ?>
       </select>
      </td>
     </tr>
     <tr>
      <td class="left"><?php echo $entry_position; ?></td>
      <td class="left">
       <select name="astickers_settings[manufacturer_position]">
        <?php foreach ($positions as $position=>$value) { ?>
        <?php if ($settings['manufacturer_position'] == $position) { ?>
        <option value="<?php echo $position; ?>" selected="selected"><?php echo ${'text_' . $position}; ?></option>
        <?php } else { ?>
        <option value="<?php echo $position; ?>"><?php echo ${'text_' . $position}; ?></option>
        <?php } ?>
        <?php } ?>
       </select>
      </td>
     </tr>
     <tr>
      <td class="left"><?php echo $entry_width; ?></td>
      <td class="left"><input name="astickers_settings[width]" type="text" value="<?php echo $settings['width']; ?>" size="3" /></td>
     </tr>
     <tr>
      <td class="left"><?php echo $entry_height; ?></td>
      <td class="left"><input name="astickers_settings[height]" type="text" value="<?php echo $settings['height']; ?>" size="3" /></td>
     </tr>
     <tr>
      <td class="left" colspan="2" style="background:#EFEFEF;"><b><?php echo $entry_quantity; ?></b></td>
     <tr>
     <tr>
      <td class="left"><?php echo $entry_status; ?></td>
      <td class="left">
       <select name="astickers_settings[quantity_status]">
        <?php if ($settings['quantity_status']) { ?>
        <option value="0"><?php echo $text_disabled; ?></option>
        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
        <?php } else { ?>
        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
        <option value="1"><?php echo $text_enabled; ?></option>
        <?php } ?>
       </select>
      </td>
     </tr>
     <tr>
      <td class="left"><?php echo $entry_position; ?></td>
      <td class="left">
       <select name="astickers_settings[quantity_position]">
        <?php foreach ($positions as $position=>$value) { ?>
        <?php if ($settings['quantity_position'] == $position) { ?>
        <option value="<?php echo $position; ?>" selected="selected"><?php echo ${'text_' . $position}; ?></option>
        <?php } else { ?>
        <option value="<?php echo $position; ?>"><?php echo ${'text_' . $position}; ?></option>
        <?php } ?>
        <?php } ?>
       </select>
      </td>
     </tr>
     <tr>
      <td class="left"></td>
      <td class="left">
       <div id="quantity_tabs" class="htabs">
        <a href="#tab-empty">&nbsp;</a>
        <a href="#tab-range"><?php echo $tab_range; ?></a>
       </div>
       <div id="tab-empty"></div>
       <div id="tab-range">
        <table class="list" id="quantity" style="width:auto;">
         <thead>
          <tr>
           <td class="center"></td>
           <td class="center">Min</td>
           <td class="center">Max</td>
           <td class="center"><?php echo $column_image; ?></td>
          </tr>
         </thead>
         <?php $quantity_row = 0; ?>
         <?php foreach ($settings['quantity'] as $param) { ?>
         <tbody id="quantity-row<?php echo $quantity_row; ?>">
          <tr>
           <td class="center" width="1"><a onclick="$('#quantity-row<?php echo $quantity_row; ?>').remove();"><img src="view/image/delete.png" /></a></td>
           <td class="left"><input type="text" name="astickers_settings[quantity][<?php echo $quantity_row; ?>][min]" value="<?php echo $param['min']; ?>" size="5" /></td>
           <td class="left"><input type="text" name="astickers_settings[quantity][<?php echo $quantity_row; ?>][max]" value="<?php echo $param['max']; ?>" size="5" /></td>
           <td class="center"><input id="image<?php echo $quantity_row; ?>" type="hidden" name="astickers_settings[quantity][<?php echo $quantity_row; ?>][image]" value="<?php echo $param['image']; ?>" /><a onclick="image_upload('image<?php echo $quantity_row; ?>', 'thumb<?php echo $quantity_row; ?>');" title="<?php echo $text_browse; ?>"><img id="thumb<?php echo $quantity_row; ?>" src="<?php echo $param['thumb']; ?>" /></a><br /><a onclick="$('#thumb<?php echo $quantity_row; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image<?php echo $quantity_row; ?>').attr('value', '');"><?php echo $text_clear; ?></a></td>
          </tr>
         </tbody>
         <?php $quantity_row++; ?>
         <?php } ?>
         <tfoot>
          <tr>
           <td class="center"><a onclick="addQuantity();"><img src="view/image/add.png" /></a></td>
           <td colspan="3"></td>
          </tr>
         </tfoot>
        </table>
       </div>
      </td>
     </tr>
    </tbody>
   </table>
   </div>
  </form>
 </div>
</div>
<script type="text/javascript"><!--
var quantity_row = <?php echo $quantity_row; ?>;

function addQuantity() {
	html  = '         <tbody id="quantity-row' + quantity_row + '">';
	html += '          <tr>';
	html += '           <td class="center" width="1"><a onclick="$(\'#quantity-row' + quantity_row + '\').remove();"><img src="view/image/delete.png" /></a></td>';
	html += '           <td class="left"><input type="text" name="astickers_settings[quantity][' + quantity_row + '][min]" value="" size="5" /></td>';
	html += '           <td class="left"><input type="text" name="astickers_settings[quantity][' + quantity_row + '][max]" value="" size="5" /></td>';
	html += '           <td class="center"><input id="image' + quantity_row + '" type="hidden" name="astickers_settings[quantity][' + quantity_row + '][image]" value="" /><a onclick="image_upload(\'image' + quantity_row + '\', \'thumb' + quantity_row + '\');" title="<?php echo $text_browse; ?>"><img id="thumb' + quantity_row + '" src="<?php echo $no_image; ?>" /></a><br /><a onclick="$(\'#thumb' + quantity_row + '\').attr(\'src\', \'<?php echo $no_image; ?>\'); $(\'#image' + quantity_row + '\').attr(\'value\', \'\');"><?php echo $text_clear; ?></a></td>';
	html += '          </tr>';
	html += '         </tbody>';
	
	$('#quantity tfoot').before(html);
	
	quantity_row++;
}
//--></script>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {
	html  = '    <tbody id="module-row' + module_row + '">';
	html += '     <tr>';
	html += '      <td class="left"><select name="astickers_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '       <option value="<?php echo $layout["layout_id"]; ?>"><?php echo $layout["name"]; ?></option>';
	<?php } ?>
	html += '      </select></td>';
	html += '      <td class="left"><select name="astickers_module[' + module_row + '][position]">';
	html += '       <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      </select></td>';
	html += '      <td class="left"><select name="astickers_module[' + module_row + '][status]">';
	html += '       <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
	html += '       <option value="0"><?php echo $text_disabled; ?></option>';
	html += '      </select></td>';
	html += '      <td class="right"><input type="text" name="astickers_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '      <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '     </tr>';
	html += '    </tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}
//--></script>
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
<script type="text/javascript"><!--
$('#tabs a').tabs();
$('#quantity_tabs a').tabs();
//--></script>
<?php echo $footer; ?>