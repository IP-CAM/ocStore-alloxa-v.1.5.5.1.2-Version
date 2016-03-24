<?php echo $header; ?>
<style type="text/css">
    #XDdonate {
        text-align: center;
        padding: 8px;
        background: rgb(206, 230, 235);
        margin: 5px;
        border: dashed 2px rgb(2, 9, 92);
        border-radius: 8px;
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
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table id="module" class="list">
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
              <td class="left"><select name="XDCategoryGroups_module[<?php echo $module_row; ?>][layout_id]">
                  <?php foreach ($layouts as $layout) { ?>
                  <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                  <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
              <td class="left"><select name="XDCategoryGroups_module[<?php echo $module_row; ?>][position]">
                  <?php if ($module['position'] == 'content_top') { ?>
                  <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
                  <?php } else { ?>
                  <option value="content_top"><?php echo $text_content_top; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'content_bottom') { ?>
                  <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
                  <?php } else { ?>
                  <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'column_left') { ?>
                  <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                  <?php } else { ?>
                  <option value="column_left"><?php echo $text_column_left; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'column_right') { ?>
                  <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                  <?php } else { ?>
                  <option value="column_right"><?php echo $text_column_right; ?></option>
                  <?php } ?>
                </select></td>
              <td class="left"><select name="XDCategoryGroups_module[<?php echo $module_row; ?>][status]">
                  <?php if ($module['status']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
              <td class="right"><input type="text" name="XDCategoryGroups_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
              <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
            </tr>
          </tbody>
          <?php $module_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="4">
              </td>
              <td class="left"><a onclick="xdAddModule()" class="button"><?php echo $button_add_module; ?></a></td>
            </tr>
          </tfoot>
        </table>
        <!-- GENERAL SETTINGS -->
        <table class="list">
            <thead>
                <tr>
                    <td class="left" colspan="2"><?php echo $XD_settings_title; ?></td>
                </tr>
            </thead>
            <tbody>
                <?php //print_r($XDSetting); ?>
                <tr>
                    <td class="left">Category Limit: </td>
                    <td class="left"><input type="text" name="XDCategoryGroupsSetting[categoryLimit]" value="<?php echo $XDSetting['categoryLimit'] ?>"/>    <i>Default: 5</i></td>
                </tr>
                <tr>
                    <td class="left">Image Sizes: </td>
                    <td class="left">
                        Width : <input id="imageWidth" type="text" name="XDCategoryGroupsSetting[customImageWidth]" value="<?php echo (isset($XDSetting['customImageWidth']) ? $XDSetting['customImageWidth'] : '');?>"/><i> Automatic Aspect Ratio Constraints  / Default width 250px</i>
                        <!--Height : <input id="imageHeight" type="text" name="XDCategoryGroupsSetting[height]" value="<?php echo $XDSetting['height'] ?>"/>-->
                    </td>
                </tr>
                <!--<tr>
                    <td class="left">Constrain Proportions: </td>
                    <td class="left">
                         <select id="constrainProportions" name="XDCategoryGroupsSetting[constrainProp]">
                            <?php
                            if($constrainProp == 'no') {
                                echo '<option selected="selected" value="no">No</option>';
                            } else {
                                echo '<option value="no">No</option>';
                            }
                            
                            $constrainProp = $XDSetting['constrainProp'];
                            if($constrainProp == 'yes') {
                                echo '<option selected="selected" value="yes">Yes</option>';
                            } else {
                                echo '<option value="yes">Yes</option>';
                            }
                            
                            ?>
                        </select>
                    </td>
                </tr>-->
                <tr>
                    <td class="left">Show Image: </td>
                    <td class="left">
                        <select name="XDCategoryGroupsSetting[showImage]">
                            <?php
                            $showImage = $XDSetting['showImage'];
                            if($showImage == 'yes') {
                                echo '<option selected="selected" value="yes">Yes</option>';
                            } else {
                                echo '<option value="yes">Yes</option>';
                            }
                            
                            if($showImage == 'no') {
                                echo '<option selected="selected" value="no">No</option>';
                            } else {
                                echo '<option value="no">No</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="left">Title Position: </td>
                    <td class="left">
                        <select name="XDCategoryGroupsSetting[titlePosition]">
                            <?php
                            $positionValue = $XDSetting['titlePosition'];
                            if($positionValue == 'aboveImage') {
                                echo '<option selected="selected" value="aboveImage">Above Image</option>';
                            } else {
                                echo '<option value="aboveImage">Above Image</option>';
                            }
                            
                            if($positionValue == 'belowImage') {
                                echo '<option selected="selected" value="belowImage">Below Image</option>';
                            } else {
                                echo '<option value="belowImage">Below Image</option>';
                            }
                            ?>
                            
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="left">Image and Title Links: </td>
                    <td class="left">
                        <select name="XDCategoryGroupsSetting[titleLinks]">
                            <?php
                            $titleLinks = $XDSetting['titleLinks'];
                            if($titleLinks == 'active') {
                                echo '<option selected="selected" value="active">Active</option>';
                            } else {
                                echo '<option value="active">Active</option>';
                            }
                            
                            if($titleLinks == 'inactive') {
                                echo '<option selected="selected" value="inactive">Inactive</option>';
                            } else {
                                echo '<option value="inactive">Inactive</option>';
                            }
                            ?>
                            
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="left">Custom Block Sizes: </td>
                    <td class="left">
                        <select id="CatGroupPadd" name="XDCategoryGroupsSetting[blockPadding]">
                            <?php
                            $blockPadding = $XDSetting['blockPadding'];
                            
                            if($blockPadding == 'inactive') {
                                echo '<option selected="selected" value="inactive">Inactive</option>';
                            } else {
                                echo '<option value="inactive">Inactive</option>';
                            }
                            
                            if($blockPadding == 'active') {
                                echo '<option selected="selected" value="active">Active</option>';
                                $sectionVisible = '';
                            } else {
                                echo '<option value="active">Active</option>';
                                $sectionVisible = 'style="display:none;"';
                            }
                            ?>
                            
                        </select>
                        <div id="paddingInfo" <?php echo $sectionVisible; ?>>
                            <label>Left Padding:</label><input type="text" name="XDCategoryGroupsSetting[blockPaddingLeft]"  value="<?php echo $XDSetting['blockPaddingLeft'] ?>"/></br>
                            <label>Right Padding:</label><input type="text" name="XDCategoryGroupsSetting[blockPaddingRight]"  value="<?php echo $XDSetting['blockPaddingRight'] ?>"/></br>
                            <label>Block Height:</label><input type="text" name="XDCategoryGroupsSetting[blockHeight]"  value="<?php echo $XDSetting['blockHeight'] ?>"/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="left">Custom CSS: </td>
                    <td class="left"><textarea name="XDCategoryGroupsSetting[customCSSCode]" rows="20" cols="100" ><?php echo (isset($XDSetting['customCSSCode']) ? $XDSetting['customCSSCode'] : ''); ?></textarea></td>
                </tr>
            </tbody>
            <tfooter>
                
            </tfooter>
        </table>
        <!-- BLOCk SECTION -->
        <table id="CatBlocks" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $XD_image; ?></td>
              <td class="left"><?php echo $XD_category; ?></td>
              <td></td>
            </tr>
          </thead>
          <?php $block_row = 0; ?>
           <?php foreach ($blocks as $block) { ?>
                <tbody id="module-row<?php echo $block_row; ?>">
                    <tr>
                        <td class="left">
                        <div class="image">
                        <?php 
                        $previewClass = '';
                        if($block['image'] != '') { 
                        $imgURL = str_replace('/admin','',HTTP_SERVER);
                        ?>
                        <img src="<?php echo $imgURL.'image/'.$block['image'] ?>" alt id="thumb<?php echo $block_row; ?>" width="100px"/>
                        <?php } else { ?>
                        <img src="<?php echo $imgURL.'image/cache/no_image-100x100.jpg'; ?>" alt id="thumb<?php echo $block_row; ?>" <?php echo $previewClass; ?>/>
                        <?php } ?>
                        <input type="hidden" name="XDCategoryGroupsBlocks[<?php echo $block_row; ?>][image]" id="image<?php echo $block_row; ?>" value="<?php echo $block['image'] ?>"/>
                        <br>
                        <a onclick="image_upload('image<?php echo $block_row; ?>','thumb<?php echo $block_row; ?>');">Browse files</a>
                        </div>
                    </td>
                    <td class="left"><select name="XDCategoryGroupsBlocks[<?php echo $block_row; ?>][category]">
                        <?php foreach ($categories as $category) { ?>
                            <?php if ($category['category_id'] == $block['category']) { ?>
                                <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name'] ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name'] ?></option>
                            <?php } ?>
                        <?php } ?>
                        </select></td>
                    <td class="left"><a onclick="$('#module-row<?php echo $block_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
                    </tr>
            </tbody>
            <?php $block_row++; ?>
           <?php } ?>
          <tfoot>
            <tr>
              <td colspan="2"></td>
              <td class="left"><a onclick="addCategoryBlock();" class="button"><?php echo $button_add_module; ?></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
        <table style="width:100%">
            <tr>
                    <td colspan="2">
                        <div id="XDdonate">
                            Thanks for downloading my extention. A lot of time and effort goes into developing this module and making sure new versions appear regularly and making sure the bugs gets fixed.</br>
                            Please consider making a donation to keep me going. Thanks!<br>
                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="cmd" value="_s-xclick">
                            <input type="hidden" name="hosted_button_id" value="L7QQCQ7X35ZVQ">
                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                            </form>
                        </div>
                    </td>
                </tr>
        </table>
    </div>
  </div>
</div>
<script type="text/javascript">
var module_row = '';
var block_row = '';

module_row = <?php echo $module_row; ?>;
block_row = <?php echo $block_row; ?>;

function xdAddModule(){
        html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><select name="XDCategoryGroups_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="XDCategoryGroups_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="XDCategoryGroups_module[' + module_row + '][status]">';
        html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
        html += '      <option value="0"><?php echo $text_disabled; ?></option>';
        html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="XDCategoryGroups_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}
                      
function addCategoryBlock() {	
	html  = '<tbody id="module-row' + block_row + '">';
	html += '  <tr>';
        html += '    <td class="left">';
	html += '      <div class="image">';
	html += '       <img src="http://localhost/ShopODPLocal/image/cache/no_image-100x100.jpg" alt id="thumb' + block_row + '"/>';
	html += '       <input type="hidden" name="XDCategoryGroupsBlocks[' + block_row + '][image]" id="image' + block_row + '"/>';
	html += '       <br>'; 
	html += '       <a onclick="image_upload(\'image' + block_row + '\', \'thumb' + block_row + '\');">Browse files</a>';
	html += '       </div>';
	html += '    </td>';
	html += '    <td class="left"><select name="XDCategoryGroupsBlocks[' + block_row + '][category]">';
	<?php foreach ($categories as $category) { ?>
	html += '      <option value="<?php echo $category['category_id']; ?>"><?php echo addslashes($category['name']) ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + block_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#CatBlocks tfoot').before(html);
	
	block_row++;
}

function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent(jQuery('#' + field).attr('value')),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
                                                $(this).parent().find('img').show();
					}
				});
			}
		},	
		bgiframe: false,
		width: 700,
		height: 400,
		resizable: false,
		modal: false
	});
            
};

$('#CatGroupPadd').change(function(){
    $('#paddingInfo').toggle();
})

jQuery('#constrainProportions').change(function(){
            currVal = $(this).val();
            Owidth = $('#imageWidth').val();
            Oheight = $('#imageHeight').val();
            if(currVal == 'yes'){
                alert('yes');
                $('#imageHeight').attr('readonly','readonly');
                //Nheight = (Owidth / Oheight);
                //alert(Nheight);
            } else {
                alert('no');
                $('#imageHeight').removeAttr('readonly');    
            }
        });
</script> 
<?php echo $footer; ?>