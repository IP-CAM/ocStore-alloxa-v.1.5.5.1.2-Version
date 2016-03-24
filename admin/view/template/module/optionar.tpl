<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
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
                <div class="vtabs">
                    <?php $module_row = 1; ?>
                    <?php foreach ($modules as $module) { ?>
                    <a href="#tab-module-<?php echo $module_row; ?>" id="module-<?php echo $module_row; ?>"><?php echo isset($module['title']) ? $module['title'] : ''; ?>&nbsp;<img src="view/image/delete.png" alt="" onclick="$('.vtabs a:first').trigger('click'); $('#module-<?php echo $module_row; ?>').remove(); $('#tab-module-<?php echo $module_row; ?>').remove(); return false;" /></a>
                    <?php $module_row++; ?>
                    <?php } ?>
                    <span id="module-add" onclick="addModule();" style="cursor: pointer;"><?php echo $add_template; ?>&nbsp;<img src="view/image/add.png" /></span>
                </div>
                <?php $module_row = 1; ?>
                <?php foreach ($modules as $module) { ?>
                <div id="tab-module-<?php echo $module_row; ?>" class="vtabs-content">
                    <table class="form">
                        <tr>
                            <td><div style="background: #EFEFEF;border-radius: 3px;border: 1px solid #DDDDDD;color: #000;padding: 0 10px;width: 98%;"><?php echo $name_template; ?> <input type="text" name="settings_optionar[<?php echo $module_row; ?>][title]" id="title-<?php echo $module_row; ?>" value="<?php echo isset($module['title']) ? $module['title'] : ''; ?>" style="width: 80%;" /><input type="hidden" name="settings_optionar[<?php echo $module_row; ?>][template_id]" value="<?php echo $module_row; ?>" /></div></td>
                        </tr>
                        <tr>
                            <td>
                                <table class="list">
                                    <thead>
                                    <tr>
                                        <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input.ch<?php echo $module_row; ?>').attr('checked', this.checked);" /></td>
                                        <td class="left"><?php echo $option_name; ?></td>
                                        <td class="left"><?php echo $option_type; ?></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($options as $option) { ?>
                                    <tr <?php if (isset($option['values']) && !empty($option['values'])) { ?>class="option-with-value"<?php } ?>>
                                        <td style="text-align: center;">
                                            <?php if (isset($module['selected'][$option['option_id']]) && (($module['selected'][$option['option_id']]) == ($option['option_id']))) { ?>
                                            <input type="checkbox" name="settings_optionar[<?php echo $module_row; ?>][selected][<?php echo $option['option_id']; ?>]" value="<?php echo $option['option_id']; ?>" checked="checked" class="ch<?php echo $module_row; ?>" />
                                            <?php } else { ?>
                                            <input type="checkbox" name="settings_optionar[<?php echo $module_row; ?>][selected][<?php echo $option['option_id']; ?>]" value="<?php echo $option['option_id']; ?>" class="ch<?php echo $module_row; ?>" />
                                            <?php } ?>
                                        </td>
                                        <td class="left"><?php echo $option['name']; ?></td>
                                        <td class="left">
                                            <?php if ($option['type'] == 'select') { ?>
                                                <?php echo $text_selects; ?>
                                            <?php } elseif ($option['type'] == 'radio') { ?>
                                                <?php echo $text_radio; ?>
                                            <?php } elseif ($option['type'] == 'checkbox') { ?>
                                                <?php echo $text_checkbox; ?>
                                            <?php } elseif ($option['type'] == 'image') { ?>
                                                <?php echo $text_image; ?>
                                            <?php } elseif ($option['type'] == 'text') { ?>
                                                <?php echo $text_text; ?>
                                            <?php } elseif ($option['type'] == 'textarea') { ?>
                                                <?php echo $text_textarea; ?>
                                            <?php } elseif ($option['type'] == 'file') { ?>
                                                <?php echo $text_file; ?>
                                            <?php } elseif ($option['type'] == 'date') { ?>
                                                <?php echo $text_date; ?>
                                            <?php } elseif ($option['type'] == 'time') { ?>
                                                <?php echo $text_time; ?>
                                            <?php } elseif ($option['type'] == 'datetime') { ?>
                                                <?php echo $text_datetime; ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php if (isset($option['values']) && !empty($option['values'])) { ?>
                                        <?php $counter = 0 ?>
                                        <?php foreach ($option['values'] as $option_value) { ?>
                                            <?php $counter++ ?>
                                            <tr <?php if ($counter != count($option['values'])) { ?>class="option-value"<?php } else { ?>class="option-value final"<?php } ?>>
                                                <td style="text-align: center;">
                                                    <?php if (isset($module['selected_values'][$option['option_id']][$option_value['option_value_id']]) && ($module['selected_values'][$option['option_id']][$option_value['option_value_id']] == $option_value['option_value_id'])) { ?>
                                                    <input type="checkbox" name="settings_optionar[<?php echo $module_row; ?>][selected_values][<?php echo $option['option_id']; ?>][<?php echo $option_value['option_value_id']; ?>]" value="<?php echo $option_value['option_value_id']; ?>" checked="checked" class="ch<?php echo $module_row; ?>" />
                                                    <?php } else { ?>
                                                    <input type="checkbox" name="settings_optionar[<?php echo $module_row; ?>][selected_values][<?php echo $option['option_id']; ?>][<?php echo $option_value['option_value_id']; ?>]" value="<?php echo $option_value['option_value_id']; ?>" class="ch<?php echo $module_row; ?>" />
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo 'Значение опции - <strong>' . $option['name'] . '</strong>' ?></td>
                                                <td><?php echo '--> ' . $option_value['name'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php $module_row++; ?>
                <?php } ?>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    var module_row = <?php echo $module_row; ?>;

    function addModule() {
        html  = '<div id="tab-module-' + module_row + '" class="vtabs-content">';
        html += '      <table class="form">';
        html += '        <tr>';
        html += '          <td><div style="background: #EFEFEF;border-radius: 3px;border: 1px solid #DDDDDD;color: #000;padding: 0 10px;width: 98%;"><?php echo $name_template; ?> <input name="settings_optionar[' + module_row + '][title]" id="title-' + module_row + '" style="width: 80%;"></input><input type="hidden" name="settings_optionar[' + module_row + '][template_id]" value="' + module_row + '" /></div></td>';
        html += '        </tr>';
        html += '        <tr>';
        html += '          <td>';
        html += '              <table class="list">';
        html += '                <thead>';
        html += '                  <tr>';
        html += '                    <td width="1" style="text-align: center;"><input type="checkbox" onclick="$(\'input.ch' + module_row + '\').attr(\'checked\', this.checked);"  /></td>';
        html += '                    <td class="left"><?php echo $option_name; ?></td>';
        html += '                    <td class="left"><?php echo $option_type; ?></td>';
        html += '                  </tr>';
        html += '                </thead>';
        html += '                <tbody>';
    <?php foreach ($options as $option) { ?>
            html += '                  <tr <?php if (isset($option['values']) && !empty($option['values'])) { ?>class="option-with-value"<?php } ?>>';
            html += '                    <td style="text-align: center;"><input type="checkbox" name="settings_optionar[' + module_row + '][selected][<?php echo $option['option_id']; ?>]" value="<?php echo $option['option_id']; ?>" class="ch' + module_row + '" /></td>';
            html += '                    <td class="left"><?php echo $option['name']; ?></td>';
            html += '                    <td class="left"><?php echo $option['type']; ?></td>';
            html += '                  </tr>';
            <?php if (isset($option['values']) && !empty($option['values'])) { ?>
                <?php $counter = 0 ?>
                <?php foreach ($option['values'] as $option_value) { ?>
                    <?php $counter++ ?>
                    html += '<tr <?php if ($counter != count($option['values'])) { ?>class="option-value"<?php } else { ?>class="option-value final"<?php } ?>>';
                    html += '<td style="text-align: center;">';
                            <?php if (isset($module['selected_values'][$option['option_id']][$option_value['option_value_id']]) && ($module['selected_values'][$option['option_id']][$option_value['option_value_id']] == $option_value['option_value_id'])) { ?>
                        html += '<input type="checkbox" name="settings_optionar[<?php echo $module_row; ?>][selected_values][<?php echo $option['option_id']; ?>][<?php echo $option_value['option_value_id']; ?>]" value="<?php echo $option_value['option_value_id']; ?>" checked="checked" class="ch<?php echo $module_row; ?>" />';
                                <?php } else { ?>
                        html += '<input type="checkbox" name="settings_optionar[<?php echo $module_row; ?>][selected_values][<?php echo $option['option_id']; ?>][<?php echo $option_value['option_value_id']; ?>]" value="<?php echo $option_value['option_value_id']; ?>" class="ch<?php echo $module_row; ?>" />';
                                <?php } ?>
                    html += '</td>';
                    html += '<td><?php echo 'Значение опции - <strong>' . $option['name'] . '</strong>' ?></td>';
                    html += '<td><?php echo '--> ' . $option_value['name'] ?></td>';
                    html += '</tr>';
                <?php } ?>
            <?php } ?>
        <?php } ?>
        html += '                </tbody>';
        html += '               </table>';
        html += '           </td>';
        html += '         </tr>';
        html += '      </table>';
        html += '</div>';

        $('#form').append(html);

        $('#module-add').before('<a href="#tab-module-' + module_row + '" id="module-' + module_row + '"><?php echo $tab_template; ?> ' + module_row + '&nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'.vtabs a:first\').trigger(\'click\'); $(\'#module-' + module_row + '\').remove(); $(\'#tab-module-' + module_row + '\').remove(); return false;" /></a>');

        $('.vtabs a').tabs();

        $('#module-' + module_row).trigger('click');

        module_row++;
    }

    $('.vtabs a').tabs();

    setInterval (function () {
        $('.breadcrumb + .success').fadeOut('slow');
    }, 5000);
    //--></script>
<?php echo $footer; ?>