<?php echo $header; ?>
<div id="content">
  <style>
	.vtabs {
	width: 210px;
	}
	.vtabs a {
	text-align: left;
	padding: 3px 31px;
	width: 147px;
	background: #EFEFEF;
	line-height: 20px;
	vertical-align: center;
	}
	.vtabs a.selected {
	padding: 3px;
	width: 204px;
	}
	.vtabs a.selected span{
	padding: 4px 4px 0px 4px;
	}
	.vtabs span {
	text-align: left;
	padding: 0 4px;
	width: 140px;
	vertical-align: center;
	background: none;
	border: none;
	float: left;
	clear: none;
	margin: 0;
	font-weight: normal;
	}
	.vtabs i {
	display: none;
	font-weight: normal;
	font-style: normal;
	text-align: center;
	font-size: 20px;
	width: 20px;
	height: 20px;
	padding: 3px;
	float: left;
	}
	.vtabs-content { 
	margin-left: 215px;
	}
	.del{
	background: #FFD1D1;
	color: #E17B7B;
	border: 1px solid #F8ACAC;
	}
	.save{
	background: #EAF7D9;
	color: #87B052;
	border: 1px solid #BBDF8D;
	}
	.del:hover{
	-webkit-box-shadow: 0px 0px 10px 2px #FFD1D1;
	-moz-box-shadow: 0px 0px 10px 2px #FFD1D1;
	box-shadow: 0px 0px 10px 2px #FFD1D1;
	}
	.save:hover,#module-add:hover,#category-add a:hover{
	-webkit-box-shadow: 0px 0px 10px 2px #DAF4B8;
	-moz-box-shadow: 0px 0px 10px 2px #DAF4B8;
	box-shadow: 0px 0px 10px 2px #DAF4B8;
	}
	.selected > .del,.selected > .save{
	display: block;
	}
	.list {
	margin-bottom: 0px;
	}
	table.form > tbody > tr > td {
	border: none;
	}
	#module-add, #category-add a{
	text-align: center;
	font-size: 16px;
	width: 200px;
	height: 20px;
	line-height: 20px;
	float: left;
	background: #EAF7D9;
	color: #87B052;
	border: 1px solid #BBDF8D;
	padding: 3px;
	cursor: pointer;
	text-decoration: none;
	}
	
  </style>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
	  <div id="form">
        <div class="vtabs">
          <?php $module_row = 1; ?>
          <?php foreach ($modules as $module) { ?>
          <a href="#tab-module-<?php echo $module_row; ?>" id="module-<?php echo $module_row; ?>"><i title="удалить" class="del" onclick="$('.vtabs a:first').trigger('click'); $('#module-<?php echo $module_row; ?>').remove(); $('#tab-module-<?php echo $module_row; ?>').remove(); del('<?php echo $module['template_id']; ?>'); return false;">&#10006;</i><span><?php echo isset($module['title']) ? $module['title'] : ''; ?></span><i title="сохранить" class="save" onclick="save('<?php echo $module['template_id']; ?>');">&#10004;</i></a>
          <?php $module_row++; ?>
          <?php } ?>
          <div id="module-add" onclick="addModule();" style="cursor: pointer;"><?php echo $add_template; ?></div> 
		</div>
        <?php $module_row = 1; ?>
        <?php foreach ($modules as $module) { ?>
        <div id="tab-module-<?php echo $module_row; ?>" class="vtabs-content">
		<form method="post" enctype="multipart/form-data" id="form-<?php echo $module['template_id']; ?>">
        <table class="form">
          <tr>
            <td>
                <table class="list">
                    <tr>
                      <td><?php echo $name_template; ?></td>
                      <td class="left" style="width: 80%;"><input style="width: 99%;" type="text" name="settings[title]" id="title-<?php echo $module['template_id']; ?>" value="<?php echo isset($module['title']) ? $module['title'] : ''; ?>" /><input type="hidden" name="settings[template_id]" value="<?php echo $module['template_id']; ?>" /></td>
                    </tr><!--
                    <tr>
                      <td>Привязать шаблон к категориям:</td>
                      <td id="category-add" class="left" style="width: 80%;"><a onclick="loadCategory(<?php echo $module['template_id']; ?>);">Выбрать категории</a></td>
                    </tr>-->
				</table>
			</td>
          </tr>
          <tr>
		    <td>
                <table class="list">
                  <thead>
                    <tr>
                      <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input.ch<?php echo $module['template_id']; ?>').attr('checked', this.checked);" /></td>
                      <td class="left"><?php echo $attribute_name; ?></td>
					  <td class="left"><?php echo $attribute_value; ?></td>
                      <td class="left"><?php echo $attribute_group; ?></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($attributes as $attribute) { ?>
                    <tr>
                      <td style="text-align: center;">
						<?php if (isset($module['selected'][$attribute['attribute_id']]) && (($module['selected'][$attribute['attribute_id']]) == ($attribute['attribute_id']))) { ?>
                        <input type="checkbox" name="settings[selected][<?php echo $attribute['attribute_id']; ?>]" value="<?php echo $attribute['attribute_id']; ?>" checked="checked" class="ch<?php echo $module['template_id']; ?>" />
                        <?php } else { ?>
                        <input type="checkbox" name="settings[selected][<?php echo $attribute['attribute_id']; ?>]" value="<?php echo $attribute['attribute_id']; ?>" class="ch<?php echo $module['template_id']; ?>" />
                        <?php } ?>
					  </td>
                      <td class="left"><?php echo $attribute['name']; ?></td>
                      <td class="left">
					  <?php foreach ($languages as $language) { ?>
					  <img style="margin: 12px 5px;" src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" align="top" />
					  <textarea name="settings[attribute_description][<?php echo $attribute['attribute_id']; ?>][<?php echo $language['language_id']; ?>]" cols="30" rows="2"><?php echo isset($module['attribute_description'][$attribute['attribute_id']][$language['language_id']]) ? $module['attribute_description'][$attribute['attribute_id']][$language['language_id']] : ''; ?></textarea>
					  <?php } ?>
					  </td>
                      <td class="left"><?php echo $attribute['attribute_group']; ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
			</td>
          </tr>
        </table>
		</form>
        </div>
        <?php $module_row++; ?>
        <?php } ?>
	  </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;
var setting_row = <?php echo $setting_row; ?>;

function addModule() {
	<?php if ($this->user->hasPermission('modify', 'module/attributic')) { ?>

	html  = '<div id="tab-module-' + module_row + '" class="vtabs-content">';
	html += '<form method="post" enctype="multipart/form-data" id="form-' + setting_row + '">';
	html += '      <table class="form">';
	html += '        <tr>';
	html += '          <td>';
	html += '            <table class="list">';
	html += '               <tr>';
	html += '                    <td><?php echo $name_template; ?></td>';
	html += '                    <td class="left" style="width: 80%;"><input style="width: 99%;" type="text" name="settings[title]" id="title-' + setting_row + '" value="<?php echo $tab_template; ?> ' + setting_row + '" /><input type="hidden" name="settings[template_id]" value="' + setting_row + '" /></td>';
	html += '        		</tr>';/*
	html += '       	    <tr>';
	html += '         			 <td>Привязать шаблон к категориям:</td>';
	html += '                    <td id="category-add" class="left" style="width: 80%;"><a onclick="loadCategory(' + setting_row + ');">Выбрать категории</a></td>';
	html += '        		</tr>';*/
	html += '            </table>';
	html += '          </td>';
	html += '        </tr>';
	html += '        <tr>';
	html += '          <td>';
	html += '              <table class="list">';
	html += '                <thead>';
	html += '                  <tr>';
	html += '                    <td width="1" style="text-align: center;"><input type="checkbox" onclick="$(\'input.ch' + setting_row + '\').attr(\'checked\', this.checked);"  /></td>';
	html += '                    <td class="left"><?php echo $attribute_name; ?></td>';
	html += '                    <td class="left"><?php echo $attribute_value; ?></td>';
	html += '                    <td class="left"><?php echo $attribute_group; ?></td>';
	html += '                  </tr>';
	html += '                </thead>';
	html += '                <tbody>';
                               <?php foreach ($attributes as $attribute) { ?>
	html += '                  <tr>';
	html += '                    <td style="text-align: center;"><input type="checkbox" name="settings[selected][<?php echo $attribute['attribute_id']; ?>]" value="<?php echo $attribute['attribute_id']; ?>" class="ch' + setting_row + '" /></td>';
	html += '                    <td class="left"><?php echo $attribute['name']; ?></td>';
	html += '                    <td class="left">';
                                   <?php foreach ($languages as $language) { ?>
	html += '                      <img style="margin: 12px 5px;" src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" align="top" />';
	html += '                      <textarea name="settings[attribute_description][<?php echo $attribute['attribute_id']; ?>][<?php echo $language['language_id']; ?>]" cols="30" rows="2"></textarea>';
                                   <?php } ?>
	html += '                    </td>';
	html += '                    <td class="left"><?php echo $attribute['attribute_group']; ?></td>';
	html += '                  </tr>';
                               <?php } ?>
	html += '                </tbody>';
	html += '               </table>';
	html += '           </td>';
	html += '         </tr>';
	html += '      </table>';
	html += '</form>';
	html += '</div>';

	$('#form').append(html);

	$('#module-add').before('<a href="#tab-module-' + module_row + '" id="module-' + module_row + '"><i title="удалить" class="del" onclick="$(\'.vtabs a:first\').trigger(\'click\'); $(\'#module-' + module_row + '\').remove(); $(\'#tab-module-' + module_row + '\').remove(); del(' + setting_row + '); return false;">&#10006;</i><span><?php echo $tab_template; ?> ' + setting_row + '</span><i title="сохранить" class="save" onclick="save(' + setting_row + ');">&#10004;</i></a>');

	<?php } ?>

	$('.vtabs a').tabs();

	$('#module-' + module_row).trigger('click');

	module_row++;

	var sform = $('#form-' + setting_row).serialize();

	$.ajax({
		url: 'index.php?route=module/attributic/addTemplate&token=<?php echo $this->session->data['token']; ?>',
		type: 'post',
		dataType: 'json',
		data: sform,
		success: function(json) {
			if (json['error']) {
				$('#tab-module-1').trigger('click');

				$('#tab-module-1 form').effect('highlight', {color: '#F8ACAC'}, 3000);

				$('#tab-module-1 form tr:first-child .list').before('<div class="warning">' + json['error'] + '</div>');
			}
			
			if (json['success']) {
				$('.vtabs-content:last-child form').effect('highlight', {color: '#BBDF8D'}, 3000);

				//$('.vtabs-content:last-child form tr:first-child .list').before('<div class="success">' + json['success'] + '</div>');
			}
		}
	});

	setting_row++;
}

$('.vtabs a').tabs();

function save(template_id) {
	var sform = $('#form-' + template_id).serialize();

	$.ajax({
		url: 'index.php?route=module/attributic/saveTemplate&token=<?php echo $this->session->data['token']; ?>',
		type: 'post',
		dataType: 'json',
		data: sform,
		success: function(json) {
			if (json['error']) {
				$('#form-' + template_id).effect('highlight', {color: '#F8ACAC'}, 3000);

				$('#form-' + template_id + ' tr:first-child .list').before('<div class="warning">' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#form-' + template_id).effect('highlight', {color: '#BBDF8D'}, 3000);

				//$('#form-' + template_id + ' tr:first-child .list').before('<div class="success">' + json['success'] + '</div>');
			}
		}
	});
}

function del(template_id) {
	$.ajax({
		url: 'index.php?route=module/attributic/deleteTemplate&token=<?php echo $this->session->data['token']; ?>',
		type: 'post',
		dataType: 'json',
		data: 'template_id=' + template_id,
		success: function(json) {
			if (json['error']) {
				$('#form-' + template_id).effect('highlight', {color: '#F8ACAC'}, 3000);

				$('#form-' + template_id + ' tr:first-child .list').before('<div class="warning">' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#tab-module-1 tr:first-child .list').before('<div class="success">' + json['success'] + '</div>');
			}
		}
	});
}

function loadCategory(template_id) {
	$.ajax({
		url: 'index.php?route=module/attributic/loadCategories&token=<?php echo $this->session->data['token']; ?>',
		type: 'post',
		dataType: 'json',
		data: 'template_id=' + template_id,
		success: function(json) {
			if (json['error']) {
				$('#form-' + template_id).effect('highlight', {color: '#F8ACAC'}, 3000);

				$('#form-' + template_id + ' tr:first-child .list').before('<div class="warning">' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#tab-module-1 tr:first-child .list').before('<div class="success">' + json['success'] + '</div>');
			}
		}
	});
}

setInterval (function () {
    $('.success').fadeOut('slow');
}, 3000);
//--></script>
<?php echo $footer; ?>