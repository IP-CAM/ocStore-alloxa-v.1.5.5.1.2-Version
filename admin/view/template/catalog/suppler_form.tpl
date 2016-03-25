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
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
          <a onclick="$('#form').submit();" class="button"><?php echo $button_apply; ?></a>
          <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
          <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a><a href="#tab-data"><?php echo $tab_data; ?></a><a href="#tab-attribute"><?php echo $tab_attribute; ?></a><a href="#tab-option"><?php echo $tab_option; ?></a><a href="#tab-price"><?php echo $tab_price; ?></a><a href="#tab-action"><?php echo $tab_action; ?></a></div>
	  
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <table class="form">
            <tr>
              <td><span class="required">*</span><?php echo $entry_name; ?></td>
              <td><input type="text" name="name" value="<?php echo $supplers['name']; ?>" maxlength="64" size="32" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
				<td width="200"><span class="required">*</span><?php echo $entry_suppler_id; ?></td>
				<td><input type="text" name="suppler_id" value="<?php echo $supplers['suppler_id']; ?>" maxlength="2" size="4" />
				</td>				
				<td></td><td></td>
            </tr>
            <tr style=" background: #EEEEEE;">
			  <td><span class="required"></span> <?php echo $entry_rate; ?></td>
              <td><input type="text" name="rate" value="<?php echo $supplers['rate']; ?>" maxlength="13" size="12" /></td>
			  <td></td><td></td><td></td><td></td>
			</tr>
            <tr>	
			  <td><span class="required">*</span> <?php echo $entry_cod; ?><br /><br />
			  <span class="required"></span> <?php echo $entry_pars; ?></td>  
			  <td><input type="text" name="cod" value="<?php echo $supplers['cod']; ?>" maxlength="128" size="32" title = "e.g.  prod_code&gt;,&lt;/p"/>
			  <br/><br/><br/><input type="text" name="parss" value="<?php echo $supplers['parss']; ?>" maxlength="4" size="4" /></td>
			  <td width="200"><?php echo $entry_place; ?><br/><br/><br/><?php echo $entry_point; ?></td>
			 <td><input type="text" name="places" value="<?php echo $supplers['places']; ?>" maxlength="4" size="4" title = "1 - by default"/><br /><br /><br /><input type="text" name="points" value="<?php echo $supplers['points']; ?>" maxlength="64" size="32" title = "e.g. class=&quot;product_param&quot;&gt;"/></td>			
			  <td width="200"><span class="required"></span> <?php echo $entry_sku2; ?><br/><br/>
			  <?php echo $entry_stay; ?><br/><br/>
			  <?php echo $entry_joen; ?>
			  </td>  
			  <td><input type="text" name="sku2" value="<?php echo $supplers['sku2']; ?>" maxlength="9" size="12" /><br/><br/>
			  <?php if ($supplers['stay']) { ?>
                <input type="radio" name="stay" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="stay" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="stay" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="stay" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?>
				<br/><br/>
			  <?php if ($supplers['joen']) { ?>
                <input type="radio" name="joen" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="joen" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="joen" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="joen" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?>
			  </td>			 
			</tr>
			<tr style=" background: #EEEEEE;">
			  <td><span class="required">*</span> <?php echo $entry_item; ?><br/><br/>
			  <span class="required"></span> <?php echo $entry_pars; ?></td>
              <td><input type="text" name="item" value="<?php echo $supplers['item']; ?>" maxlength="128" size="32" title = "e.g. title&gt;,&lt;/tit"/>
			  <br/><br/><br/><input type="text" name="parsi" value="<?php echo $supplers['parsi']; ?>" maxlength="4" size="4"/></td>
			  <td width="200"><?php echo $entry_place; ?><br/><br/><br/><?php echo $entry_point; ?></td>
			 <td><input type="text" name="placei" value="<?php echo $supplers['placei']; ?>" maxlength="4" size="4" title = "1 - by default" /><br/><br/><br/><input type="text" name="pointi" value="<?php echo $supplers['pointi']; ?>" maxlength="64" size="32" title = "e.g. head"/></td>		
		     <td width="200">
				<span class="required"></span> <?php echo $entry_upname; ?></td>
			  <td>	
                <?php if ($supplers['upname']) { ?>
                <input type="radio" name="upname" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="upname" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="upname" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="upname" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>		
			 </tr>			 
			<tr>
			  <td>*<?php echo $entry_cat; ?><br/><br/>
			  <span class="required"></span> <?php echo $entry_pars; ?></td>
              <td><input type="text" name="cat" value="<?php echo $supplers['cat']; ?>" maxlength="128" size="32" title = "e.g. 'category=,&" /><br/><br/><br/><input type="text" name="parsc" value="<?php echo $supplers['parsc']; ?>" maxlength="4" size="4"/></td>
			  <td width="200"><?php echo $entry_place; ?><br/><br/><br/><?php echo $entry_point; ?></td>
			 <td><input type="text" name="placec" value="<?php echo $supplers['placec']; ?>" maxlength="4" size="4" title = "1 - by default" /><br/><br/><br/><input type="text" name="pointc" value="<?php echo $supplers['pointc']; ?>" maxlength="64" size="32" title = "e.g. function slot_go(value)" /></td>	  
              <td width="200"><span class="required"></span><br /><?php echo $entry_mycat; ?><br/><br/><br/><span class="required"></span> <?php echo $entry_parent; ?></td>
			  <td>
              <select name="my_cat">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($categories as $category) { ?>
                  <?php if($category['category_id'] == $my_cat) { ?>			
                  <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
				<br /><br />
                <?php if ($supplers['parent']) { ?>
                <input type="radio" name="parent" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="parent" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="parent" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="parent" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>		
			</tr>
			
			<tr style=" background: #EEEEEE;">
			  <td><span class="required"></span> <?php echo $entry_qu; ?></td>
              <td><input type="text" name="qu" value="<?php echo $supplers['qu']; ?>" maxlength="128" size="32" /></td>
			  <td width="200"><span class="required"></span> <?php echo $entry_minus; ?></td>
			  <td>			  			
                <?php if ($supplers['minus']) { ?>
                <input type="radio" name="minus" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="minus" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="minus" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="minus" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>				 			  
			  <td width="200"><span class="required"></span> <?php echo $entry_myqu; ?></td>
			  <td><input type="text" name="my_qu" value="<?php echo $supplers['my_qu']; ?>" maxlength="128" size="52" title = "e.g. 10-50=20,+=10,++=20,Нет=0,нет=0,Есть=5" /></td>	
            </tr>			
			<tr>
			  <td><span class="required">*</span> <?php echo $entry_price; ?><br/><br/>
			  <span class="required"></span> <?php echo $entry_pars; ?></td>
              <td><input type="text" name="price" value="<?php echo $supplers['price']; ?>" maxlength="128" size="32"  title = "e.g. &lt;/div&gt;&lt;div class=&quot;total-price&quot;&gt;,&lt;/" /><br/><br/><br/><input type="text" name="parsp" value="<?php echo $supplers['parsp']; ?>" maxlength="4" size="4"/></td>
			  <td width="200"><?php echo $entry_place; ?><br/><br/><br/><?php echo $entry_point; ?></td>
			  <td><input type="text" name="placep" value="<?php echo $supplers['placep']; ?>" maxlength="4" size="4" title = "1 - by default" /><br/><br/><br/><input type="text" name="pointp" value="<?php echo $supplers['pointp']; ?>" maxlength="64" size="32" title = "e.g. &lt;div class=&quot;product-description&quot;&gt;" /></td>			  
			  <td width="200"><span class="required"></span> <?php echo $entry_myprice;?><br/><br/><br/>
			  <span class="required"></span> <?php echo $entry_cheap; ?><br/><br/>
			  <span class="required"></span> <?php echo $entry_refer; ?></td>
			  <td>
			  <select name="my_price">
			      <?php if($my_price == 1) { ?>			
                  <option value="1" selected="selected"> <?php echo $text_myprice1; ?></option>
                  <?php } else { ?>
                  <option value="1"> <?php echo $text_myprice1; ?></option>
                  <?php } ?>
                  <?php if($my_price == 2) { ?>			
                  <option value="2" selected="selected"><?php echo $text_myprice2; ?></option>
                  <?php } else { ?>
                  <option value="2"><?php echo $text_myprice2; ?></option>
                  <?php } ?>
				  <?php if($my_price == 3) { ?>			
                  <option value="3" selected="selected"><?php echo $text_myprice3; ?></option>
                  <?php } else { ?>
                  <option value="3"><?php echo $text_myprice3; ?></option>
                  <?php } ?>
				  <?php if($my_price == 4) { ?>			
                  <option value="4" selected="selected"><?php echo $text_myprice4; ?></option>
                  <?php } else { ?>
                  <option value="4"><?php echo $text_myprice4; ?></option>
                  <?php } ?>
                </select>
				<br /><br /><br />                 
				 <select name="cheap">
				 <?php if($cheap == 0) { ?>		
                  <option value="0" selected="selected"> <?php echo $text_no; ?></option>
                  <?php } else { ?>
                  <option value="0"> <?php echo $text_no; ?></option>
                  <?php } ?>
			      <?php if($cheap == 1) { ?>		
                  <option value="1" selected="selected"> <?php echo $text_math1; ?></option>
                  <?php } else { ?>
                  <option value="1"> <?php echo $text_math1; ?></option>
                  <?php } ?>
                  <?php if($cheap == 2) { ?>		
                  <option value="2" selected="selected"><?php echo $text_math2; ?></option>
                  <?php } else { ?>
                  <option value="2"><?php echo $text_math2; ?></option>
                  <?php } ?>
				  <?php if($cheap == 3) { ?>		
                  <option value="3" selected="selected"><?php echo $text_math3; ?></option>
                  <?php } else { ?>
                  <option value="3"><?php echo $text_math3; ?></option>
                  <?php } ?>				  
                </select>
				   &nbsp;&nbsp;<?php echo $entry_onn;?>&nbsp;&nbsp;
				   <input type="text" name="onn" value="<?php echo $supplers['onn']; ?>" maxlength="12" size="4"/>
				 <br /><br />                
				 <select name="refer">
				 <?php if($refer == 0) { ?>		
                  <option value="0" selected="selected"> <?php echo $text_refer0; ?></option>
                  <?php } else { ?>
                  <option value="0"> <?php echo $text_refer0; ?></option>
                  <?php } ?>
			      <?php if($refer == 1) { ?>		
                  <option value="1" selected="selected"> <?php echo $text_refer1; ?></option>
                  <?php } else { ?>
                  <option value="1"> <?php echo $text_refer1; ?></option>
                  <?php } ?>				  
                </select>
				 &nbsp;&nbsp;<?php echo $entry_disc;?>&nbsp;&nbsp;
				 <input type="text" name="disc" value="<?php echo $supplers['disc']; ?>" maxlength="12" size="4"/>
			  </td>						
            </tr>	
			
			<tr style=" background: #EEEEEE;">
			  <td><span class="required"></span> <?php echo $entry_descrip; ?><br/><br/>
			  <span class="required"></span> <?php echo $entry_pars; ?></td>
              <td><input type="text" name="descrip" value="<?php echo $supplers['descrip']; ?>" maxlength="128" size="32" title = "e.g. &lt;div&gt;,&lt;/div&gt;,&lt;/div&gt;" /><br /><br/><br/><input type="text" name="parsd" value="<?php echo $supplers['parsd']; ?>" maxlength="4" size="4"/></td>
			  <td width="200"><?php echo $entry_place; ?><br /><br /><br /><?php echo $entry_point; ?></td>
			  <td><input type="text" name="placed" value="<?php echo $supplers['placed']; ?>" maxlength="4" size="4" title = "1 - by default"/><br/><br/><br/><input type="text" name="pointd" value="<?php echo $supplers['pointd']; ?>" maxlength="64" size="32" title = "e.g. &lt;div class=&quot;full-desc&quot;&gt;" /></td>			  
			  <td width="200"><span class="required"></span> <?php echo $entry_mydescrip; ?><br/><br/>
			  <span class="required"></span> <?php echo $entry_updte; ?></td>
			  <td><input type="text" name="my_descrip" value="<?php echo $supplers['my_descrip']; ?>" maxlength="512" size="52"  title = "e.g. Подрбности смотрите в разделе Характеристики"/>
			  <br/><br/>
				<select name="updte">
			      <?php if($updte == 1) { ?>			
                  <option value="1" selected="selected"> <?php echo $text_updte1; ?></option>
                  <?php } else { ?>
                  <option value="1"> <?php echo $text_updte1; ?></option>
                  <?php } ?>
                  <?php if($updte == 2) { ?>			
                  <option value="2" selected="selected"><?php echo $text_updte2; ?></option>
                  <?php } else { ?>
                  <option value="2"><?php echo $text_updte2; ?></option>
                  <?php } ?>
				  <?php if($updte == 3) { ?>			
                  <option value="3" selected="selected"><?php echo $text_updte3; ?></option>
                  <?php } else { ?>
                  <option value="3"><?php echo $text_updte3; ?></option>
                  <?php } ?>				  
                </select></td>					
            </tr>			
			<tr>
			  <td><span class="required"></span> <?php echo $entry_manuf; ?><br/><br/>
			  <span class="required"></span> <?php echo $entry_pars; ?></td>
              <td><input type="text" name="manuf" value="<?php echo $supplers['manuf']; ?>" maxlength="128" size="32" title = "e.g. + 'BREND: ,("/><br /><br/><br/><input type="text" name="parsm" value="<?php echo $supplers['parsm']; ?>" maxlength="4" size="4"/></td>
			  <td width="200"><?php echo $entry_place; ?><br/><br/><br/><?php echo $entry_point; ?></td>
			  <td><input type="text" name="placem" value="<?php echo $supplers['placem']; ?>" maxlength="4" size="4" title = "1 - by default" /><br/><br/><br/><input type="text" name="pointm" value="<?php echo $supplers['pointm']; ?>" maxlength="64" size="32" title = "e.g. &lt;script&gt; " /></td>			  
			  <td width="200"><span class="required"></span> <?php echo $entry_mymanuf; ?><br/><br/><span class="required"></span> <?php echo $entry_pmanuf; ?>
			  <br/><br/><?php echo $entry_umanuf; ?></td>			  
			  <td><select name="my_manuf">
                  <option value="0" selected="selected"><?php echo $text_none; ?></option>
                  <?php foreach ($manufacturers as $manufacturer) { ?>
                  <?php if ($manufacturer['manufacturer_id'] == $my_manuf) { ?>
                  <option value="<?php echo $manufacturer['manufacturer_id']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
				<br /><br />				
                <?php if ($supplers['pmanuf']) { ?>
                <input type="radio" name="pmanuf" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="pmanuf" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="pmanuf" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="pmanuf" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?>
				<br /><br />				
                <?php if ($supplers['umanuf']) { ?>
                <input type="radio" name="umanuf" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="umanuf" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="umanuf" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="umanuf" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>				
            </tr>
			
			<tr style=" background: #EEEEEE;">
			  <td><span class="required"></span> <?php echo $entry_pic_ext; ?><br/><br/>
			  <span class="required"></span> <?php echo $entry_pars; ?></td>
              <td><input type="text" name="pic_ext" value="<?php echo $supplers['pic_ext']; ?>" maxlength="128" size="32" title = "e.g. 12,13,18,14" /><br /><br/><br/><input type="text" name="parsk" value="<?php echo $supplers['parsk']; ?>" maxlength="4" size="4"/></td>
			  <td width="200"><span class="required"></span> <?php echo $entry_mymark; ?><br /><br /><br /><span class="required"></span> <?php echo $entry_warranty; ?></td>
			  <td><input type="text" name="my_mark" value="<?php echo $supplers['my_mark']; ?>" maxlength="128" size="32" title = "e.g. big-photo,alt=,alt=,alt=,alt" /><br  /><br /><br /><input type="text" name="warranty" value="<?php echo $supplers['warranty']; ?>" maxlength="128" size="32" title = "e.g. &lt;1,&gt;3,&gt;4,&gt;5,&gt;6"/></td>
				  
			  <td width="200"><span class="required"></span> <?php echo $entry_myphoto; ?><br /><br /><span class="required"></span> <?php echo $entry_newphoto; ?></td>
			  <td>
			  <input type="text" name="my_photo" value="<?php echo $supplers['my_photo']; ?>" maxlength="512" size="52" title = "e.g. http//:www.bla-bla-bla.com/pic-gallery/12345.jpg"/>	
				<br /><br />
                <select name="newphoto">
			      <?php if($newphoto == 1) { ?>			
                  <option value="1" selected="selected"> <?php echo $text_updte1; ?></option>
                  <?php } else { ?>
                  <option value="1"> <?php echo $text_updte1; ?></option>
                  <?php } ?>
                  <?php if($newphoto == 2) { ?>			
                  <option value="2" selected="selected"><?php echo $text_updte2; ?></option>
                  <?php } else { ?>
                  <option value="2"><?php echo $text_updte2; ?></option>
                  <?php } ?>
				  <?php if($newphoto == 3) { ?>			
                  <option value="3" selected="selected"><?php echo $text_updte3; ?></option>
                  <?php } else { ?>
                  <option value="3"><?php echo $text_updte3; ?></option>
                  <?php } ?>				  
                </select></td>		
			</tr>			
			<tr>
              <td><span class="required"></span><?php echo $entry_weight; ?></td>
              <td><input type="text" name="weight" value="<?php echo $supplers['weight']; ?>" maxlength="9" size="12" /></td>
			  <td></td><td></td><td></td><td></td>
            </tr>
			<tr style=" background: #EEEEEE;">
			  <td><span class="required"></span><?php echo $entry_fields; ?></td>
              <td>UPC:<input type="text" name="upc" value="<?php echo $supplers['upc']; ?>" size="2" />
                EAN:<input type="text" name="ean" value="<?php echo $supplers['ean']; ?>" size="2" />
                MPN:<input type="text" name="mpn" value="<?php echo $supplers['mpn']; ?>" size="2" /></td>
				<td></td><td></td><td></td><td></td>
			</tr>
			<tr>
			  <td><span class="required"></span> <?php echo $entry_ref; ?></td>
              <td><input type="text" name="ref" value="<?php echo $supplers['ref']; ?>" maxlength="9" size="12" /></td>	
			  <td></td><td></td><td></td><td></td>
			</tr> 
			<tr>
              <td><span class="required"></span><?php echo $entry_dimension; ?></td>
              <td>L:<input type="text" name="length" value="<?php echo $supplers['length']; ?>" size="2" />
                W:<input type="text" name="width" value="<?php echo $supplers['width']; ?>" size="2" />
                H:<input type="text" name="height" value="<?php echo $supplers['height']; ?>" size="2" /></td>			  		
			  
			  <td width="200" style=" background: #EEEEEE;" /><span class="required"></span> <?php echo $entry_addseo; ?></td>
              <td style=" background: #EEEEEE;" />
                <select name="addseo">
			      <?php if($addseo == 0) { ?>			
                  <option value="0" selected="selected"> <?php echo $entry_addseo0; ?></option>
                  <?php } else { ?>
                  <option value="0"> <?php echo $entry_addseo0; ?></option>
                  <?php } ?>
                  <?php if($addseo == 1) { ?>			
                  <option value="1" selected="selected"><?php echo $entry_addseo1; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $entry_addseo1; ?></option>
                  <?php } ?>
				  <?php if($addseo == 2) { ?>			
                  <option value="2" selected="selected"><?php echo $entry_addseo2; ?></option>
                  <?php } else { ?>
                  <option value="2"><?php echo $entry_addseo2; ?></option>
                  <?php } ?>				  
                </select></td>
			  <td width="200" style=" background: #EEEEEE;" /><span class="required"></span> <?php echo $entry_off; ?></td>
                 <td style=" background: #EEEEEE;" /><?php if ($supplers['off']) { ?>
                <input type="radio" name="off" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="off" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="off" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="off" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
            </tr>			
			<tr>
			   <td><span class="required"></span> <?php echo $entry_related; ?></td>
			  <td><input type="text" name="related" value="<?php echo $supplers['related']; ?>" maxlength="9" size="12" /></td>

			  <td width="200" style=" background: #EEEEEE;" /><span class="required"></span> <?php echo $entry_upattr; ?></td>
              <td style=" background: #EEEEEE;" />
                <select name="upattr">
			      <?php if($upattr == 0) { ?>			
                  <option value="0" selected="selected"> <?php echo $entry_upattr0; ?></option>
                  <?php } else { ?>
                  <option value="0"> <?php echo $entry_upattr0; ?></option>
                  <?php } ?>
                  <?php if($upattr == 1) { ?>			
                  <option value="1" selected="selected"><?php echo $entry_upattr1; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $entry_upattr1; ?></option>
                  <?php } ?>
				  <?php if($upattr == 2) { ?>			
                  <option value="2" selected="selected"><?php echo $entry_upattr2; ?></option>
                  <?php } else { ?>
                  <option value="2"><?php echo $entry_upattr2; ?></option>
                  <?php } ?>
				  <?php if($upattr == 3) { ?>			
                  <option value="3" selected="selected"> <?php echo $entry_upattr3; ?></option>
                  <?php } else { ?>
                  <option value="3"> <?php echo $entry_upattr3; ?></option>
                  <?php } ?>
				  <?php if($upattr == 4) { ?>			
                  <option value="4" selected="selected"> <?php echo $entry_upattr4; ?></option>
                  <?php } else { ?>
                  <option value="4"> <?php echo $entry_upattr4; ?></option>
                  <?php } ?>
                </select></td>
			<td width="200" style=" background: #EEEEEE;" /><span class="required"></span> <?php echo $entry_chcode; ?></td>
              <td style=" background: #EEEEEE;" /><?php if ($supplers['chcode']) { ?>
                <input type="radio" name="chcode" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="chcode" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="chcode" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="chcode" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>	
            </tr>
			
			<tr>
			  <td><span class="required"></span> <?php echo $entry_myplus; ?></td>
              <td><input type="text" name="myplus" value="<?php echo $supplers['myplus']; ?>" maxlength="9" size="12" /></td>
			  
			  <td width="200" style=" background: #EEEEEE;" /><span class="required"></span> <?php echo $entry_upopt; ?></td>
              <td style=" background: #EEEEEE;" />
			  <select name="upopt">
			      <?php if($upopt == 0) { ?>			
                  <option value="0" selected="selected"> <?php echo $entry_upopt0; ?></option>
                  <?php } else { ?>
                  <option value="0"> <?php echo $entry_upopt0; ?></option>
                  <?php } ?>
                  <?php if($upopt == 1) { ?>			
                  <option value="1" selected="selected"><?php echo $entry_upopt1; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $entry_upopt1; ?></option>
                  <?php } ?>
				  <?php if($upopt == 2) { ?>			
                  <option value="2" selected="selected"><?php echo $entry_upopt2; ?></option>
                  <?php } else { ?>
                  <option value="2"><?php echo $entry_upopt2; ?></option>
                  <?php } ?>				  
                </select></td>
			  <td width="200" style=" background: #EEEEEE;" /><span class="required"></span> <?php echo $entry_addopt; ?></td>
              <td style=" background: #EEEEEE;" /><?php if ($supplers['addopt']) { ?>
                <input type="radio" name="addopt" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="addopt" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="addopt" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="addopt" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
            </tr>
			
			<tr>
			  <td><span class="required"></span> <?php echo $entry_order; ?></td>
              <td><input type="text" name="sorder" value="<?php echo $supplers['sorder']; ?>" maxlength="9" size="12" /></td>
			  
			  <td width="200" style=" background: #EEEEEE;" /><span class="required"></span> <?php echo $entry_upurl; ?></td>
               <td style=" background: #EEEEEE;" />
                <select name="upurl">
			      <?php if($upurl == 0) { ?>			
                  <option value="0" selected="selected"> <?php echo $entry_upurl0; ?></option>
                  <?php } else { ?>
                  <option value="0"> <?php echo $entry_upurl0; ?></option>
                  <?php } ?>
                  <?php if($upurl == 1) { ?>			
                  <option value="1" selected="selected"><?php echo $entry_upurl1; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $entry_upurl1; ?></option>
                  <?php } ?>
				  <?php if($upurl == 2) { ?>			
                  <option value="2" selected="selected"><?php echo $entry_upurl2; ?></option>
                  <?php } else { ?>
                  <option value="2"><?php echo $entry_upurl2; ?></option>
                  <?php } ?>				  
                </select></td>  
			  <td width="200" style=" background: #EEEEEE;" /><span class="required"></span> <?php echo $entry_newurl; ?></td>
              <td style=" background: #EEEEEE;" />
			  <select name="newurl">
			      <?php if($newurl == 0) { ?>			
                  <option value="0" selected="selected"> <?php echo $entry_newurl0; ?></option>
                  <?php } else { ?>
                  <option value="0"> <?php echo $entry_newurl0; ?></option>
                  <?php } ?>
                  <?php if($newurl == 1) { ?>			
                  <option value="1" selected="selected"><?php echo $entry_newurl1; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $entry_newurl1; ?></option>
                  <?php } ?>				  			  
                </select></td>
			</tr>			
			<tr>
			  <td><span class="required"></span> <?php echo $entry_spec; ?></td>
              <td><input type="text" name="spec" value="<?php echo $supplers['spec']; ?>" maxlength="9" size="12" /></td>
				
			  <td width="200" style=" background: #EEEEEE;" /><span class="required"></span> <?php echo $entry_cprice; ?></td>
              <td style=" background: #EEEEEE;" /><?php if ($supplers['cprice']) { ?>
                <input type="radio" name="cprice" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="cprice" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="cprice" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="cprice" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
				<td width="200" style=" background: #EEEEEE;" /><span class="required"></span> <?php echo $entry_importseo; ?></td>
                <td style=" background: #EEEEEE;" /><?php if ($supplers['importseo']) { ?>
                <input type="radio" name="importseo" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="importseo" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="importseo" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="importseo" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?>				
				</td>
			</tr>							
			<tr>
			  <td><span class="required"></span> <?php echo $entry_ad; ?></td>
              <td><select name="ad">
				 <?php if($supplers['ad'] == 1) { ?>		
                  <option value="1" selected="selected"> <?php echo $text_ad1; ?></option>
                  <?php } else { ?>
                  <option value="1"> <?php echo $text_ad1; ?></option>
                  <?php } ?>
			      <?php if($supplers['ad'] == 0) { ?>		
                  <option value="0" selected="selected"> <?php echo $text_ad0; ?></option>
                  <?php } else { ?>
                  <option value="0"> <?php echo $text_ad0; ?></option>
                  <?php } ?>
				  <?php if($supplers['ad'] == 3) { ?>		
                  <option value="3" selected="selected"><?php echo $text_ad3; ?></option>
                  <?php } else { ?>
                  <option value="3"><?php echo $text_ad3; ?></option>
                  <?php } ?>
                  <?php if($supplers['ad'] == 2) { ?>		
                  <option value="2" selected="selected"><?php echo $text_ad2; ?></option>
                  <?php } else { ?>
                  <option value="2"><?php echo $text_ad2; ?></option>
                  <?php } ?>				  
				  <?php if($supplers['ad'] == 4) { ?>		
                  <option value="4" selected="selected"><?php echo $text_ad4; ?></option>
                  <?php } else { ?>
                  <option value="4"><?php echo $text_ad4; ?></option>
                  <?php } ?>				  
				  <?php if($supplers['ad'] == 5) { ?>		
                  <option value="5" selected="selected"> <?php echo $text_ad5; ?></option>
                  <?php } else { ?>
                  <option value="5"> <?php echo $text_ad5; ?></option>
                  <?php } ?>
				  <?php if($supplers['ad'] == 6) { ?>		
                  <option value="6" selected="selected"><?php echo $text_ad6; ?></option>
                  <?php } else { ?>
                  <option value="6"><?php echo $text_ad6; ?></option>
                  <?php } ?>
                  <?php if($supplers['ad'] == 7) { ?>		
                  <option value="7" selected="selected"><?php echo $text_ad7; ?></option>
                  <?php } else { ?>
                  <option value="7"><?php echo $text_ad7; ?></option>
                  <?php } ?>				  
				  <?php if($supplers['ad'] == 8) { ?>		
                  <option value="8" selected="selected"><?php echo $text_ad8; ?></option>
                  <?php } else { ?>
                  <option value="8"><?php echo $text_ad8; ?></option>
                  <?php } ?>
                </select></td>
	
			  <td width="200"><span class="required"></span> <?php echo $entry_set_status; ?></td>
			  <td>
			  <select name="status">
			      <?php if($supplers['status'] == 1) { ?>			
                  <option value="1" selected="selected"> <?php echo $text_status1; ?></option>
                  <?php } else { ?>
                  <option value="1"> <?php echo $text_status1; ?></option>
                  <?php } ?>
                  <?php if($supplers['status'] == 2) { ?>			
                  <option value="2" selected="selected"><?php echo $text_status2; ?></option>
                  <?php } else { ?>
                  <option value="2"><?php echo $text_status2; ?></option>
                  <?php } ?>
				  <?php if($supplers['status'] == 3) { ?>			
                  <option value="3" selected="selected"><?php echo $text_status3; ?></option>
                  <?php } else { ?>
                  <option value="3"><?php echo $text_status3; ?></option>
                  <?php } ?>
				  <?php if($supplers['status'] == 4) { ?>			
                  <option value="4" selected="selected"><?php echo $text_status4; ?></option>
                  <?php } else { ?>
                  <option value="4"><?php echo $text_status4; ?></option>
                  <?php } ?>
                </select></td>				
						
			  <td width="200"><span class="required"></span> <?php echo $entry_hide; ?></td>
              <td><?php if ($supplers['hide']) { ?>
                <input type="radio" name="hide" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="hide" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="hide" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="hide" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>	
            </tr>			
          </table>
		</div>		
		
        <div id="tab-data">
          <table class="form">
          
			<tbody>
			<tr>
			<td><span class="required">*</span><?php echo $entry_cat_ext; ?></td>
              <td><input type="text" name="cat_ext[]" value="" maxlength="128" size="30" /></td>			  		  
			  <td><span class="required">*</span><?php echo $entry_cat_int; ?></td>
              <td><select name="category_id[]">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($categories as $category) { ?>
                  <?php if($category['category_id'] == $category_id) { ?>			
                  <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
			  </tr> 
			  <tr>
			    <td><?php echo $entry_pic_int; ?></td>
                <td><input type="text" name="pic_int[]" value="" maxlength="80" size="30" /></td>
			    <td><?php echo $entry_cat_plus; ?></td>
                <td><input type="text" name="cat_plus[]" value="" maxlength="512" size="52" /></td>				
			  </tr>
			  
			  <tr style=" background: #EEEEEE;" />			  
			<td><span class="required">*</span><?php echo $entry_cat_ext; ?></td>
              <td><input type="text" name="cat_ext[]" value="" maxlength="128" size="30" /></td>
			  <td><span class="required">*</span><?php echo $entry_cat_int; ?></td>
              <td><select name="category_id[]">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($categories as $category) { ?>
                  <?php if($category['category_id'] == $category_id) { ?>			
                  <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
			  </tr> 
			  <tr style=" background: #EEEEEE;" />
			    <td><?php echo $entry_pic_int; ?></td>
                <td><input type="text" name="pic_int[]" value="" maxlength="80" size="30" /></td>
			    <td><?php echo $entry_cat_plus; ?></td>
                <td><input type="text" name="cat_plus[]" value="" maxlength="512" size="52" /></td>
			  </tr>
			
			  <tr>
			<td><span class="required">*</span><?php echo $entry_cat_ext; ?></td>
              <td><input type="text" name="cat_ext[]" value="" maxlength="128" size="30" /></td>
			  <td><span class="required">*</span><?php echo $entry_cat_int; ?></td>
              <td><select name="category_id[]">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($categories as $category) { ?>
                  <?php if($category['category_id'] == $category_id) { ?>			
                  <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
			  </tr> 
			  <tr>
			    <td><?php echo $entry_pic_int; ?></td>
                <td><input type="text" name="pic_int[]" value="" maxlength="80" size="30" /></td>
			    <td><?php echo $entry_cat_plus; ?></td>
                <td><input type="text" name="cat_plus[]" value="" maxlength="512" size="52" /></td>
			  </tr>
			
            <?php if (isset($suppler)) { $a = -3.14; $i = 0; $j = -1;?>
             <?php foreach ($suppler as $suppler) { $i=$i+1; $j = $j +1; if (pow ($a,$i) < 1) echo '<tr style=" background: #EEEEEE;" />';
			else echo '<tr>'; ?>
			            
		      <td><span class="required">*</span><?php echo $entry_cat_ext; ?></td>
              <td><input type="text" name="cat_ext[]" value="<?php echo $suppler['cat_ext']; ?>" maxlength="65" size="30" /></td>
			  <td><span class="required">*</span><?php echo $entry_cat_int; ?></td>
              <td><select name="category_id[]">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($categories as $category) { ?>
                  <?php if($category['category_id'] == $category_id[$j]) { ?>	
                  <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
			</tr> 
			<?php if (pow ($a,$i) < 1) echo '<tr style=" background: #EEEEEE;" />';
			else echo '<tr>'; ?>
			
			  <td><?php echo $entry_pic_int; ?></td>
              <td><input type="text" name="pic_int[]" value="<?php echo $suppler['pic_int']; ?>" maxlength="80" size="30" /></td>
			  <td><?php echo $entry_cat_plus; ?></td>
              <td><input type="text" name="cat_plus[]" value="<?php echo $suppler['cat_plus']; ?>" maxlength="512" size="52" />
			  </td>
			</tr>
			<?php } ?>
            <?php } else { ?>
            <tr>
              <?php $a = -5; $j = -1;
			  for ($i=1; $i<6; $i++) { $j = $j +1;
			  if (pow ($a,$i) < 0) 
			  echo '<tr style=" background: #EEEEEE;" />';
			  else echo '<tr>'; ?>
			            
		      <td><span class="required">*</span><?php echo $entry_cat_ext; ?></td>
              <td><input type="text" name="cat_ext[]" value="" maxlength="65" size="30" /></td>
			  <td><span class="required">*</span><?php echo $entry_cat_int; ?></td>
              <td><select name="category_id[]">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($categories as $category) { ?>
                  <?php if($category['category_id'] == $category_id[$j]) { ?>	
                  <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
			  </tr> 
			  <?php if (pow ($a,$i) < 0) echo '<tr style=" background: #EEEEEE;" />';
			  else echo '<tr>'; ?>
			
			  <td><?php echo $entry_pic_int; ?></td>
              <td><input type="text" name="pic_int[]" value="" maxlength="80" size="30" /></td>
			  <td><?php echo $entry_cat_plus; ?></td>
              <td><input type="text" name="cat_plus[]" value="" maxlength="512" size="52" /></td>
			  </tr>
			  <?php } ?>
              <?php } ?>
		    </tr>
           </tbody>
		  </table>          
        </div>
		
		<div id="tab-attribute">
          <table class="form">
            <tbody>
			<tr>
			  <td><span class="required"></span><?php echo $entry_attrib; ?></td>
              <td><input type="text" name="attr_ext[]" value="" maxlength="128" size="48" title = "e.g. &lt;div class=&quot;param&quot;&gt;,&lt;/div&gt;,&lt;td&gt;,&lt;/td&gt;" /></td>
			  <td width="150"><span class="required"></span> <?php echo $entry_point1; ?></td>
			  <td><input type="text" name="attr_point[]" value="" maxlength="64" size="32" title = "e.g. &lt;div class=&quot;attribute-block" /></td>
			  <td width="150"><span class="required"></span><?php echo $entry_attribute; ?></td>
              <td><select name="attribute_id[]">
                  <option value="0"><?php echo $text_left; ?></option>
                  <?php foreach ($attributes as $attribute) { ?>
                  <?php if($attribute['attribute_id'] == $attribute_id) { ?>			
                  <option value="<?php echo $attribute['attribute_id']; ?>" selected="selected"><?php echo $attribute['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $attribute['attribute_id']; ?>"><?php echo $attribute['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
			    <td width="150"><span class="required"></span><?php echo $entry_tags; ?></td>
				 <td>
				 <select name="tags[]">			      		
                  <option value="0" selected="selected"> <?php echo $text_no; ?></option>
				  <option value="1"><?php echo $text_yes; ?></option>                  
				</select></td>
			</tr>
			<tr style=" background: #EEEEEE;" />
			  <td><span class="required"></span><?php echo $entry_attrib; ?></td>
              <td><input type="text" name="attr_ext[]" value="" maxlength="128" size="48" title = "e.g. &lt;div class=&quot;param&quot;&gt;,&lt;/div&gt;,&lt;td&gt;,&lt;/t" /></td>
			  <td width="150"><span class="required"></span> <?php echo $entry_point1; ?></td>
			  <td><input type="text" name="attr_point[]" value="" maxlength="64" size="32" title = "e.g. &lt;div class=&quot;attribute-block" /></td>
			  <td width="150"><span class="required"></span><?php echo $entry_attribute; ?></td>
              <td><select name="attribute_id[]">
                  <option value="0"><?php echo $text_left; ?></option>
                  <?php foreach ($attributes as $attribute) { ?>
                  <?php if($attribute['attribute_id'] == $attribute_id) { ?>			
                  <option value="<?php echo $attribute['attribute_id']; ?>" selected="selected"><?php echo $attribute['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $attribute['attribute_id']; ?>"><?php echo $attribute['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
			    <td width="150"><span class="required"></span><?php echo $entry_tags; ?></td>
				 <td>
				 <select name="tags[]">			      		
                  <option value="0" selected="selected"> <?php echo $text_no; ?></option>
				  <option value="1"><?php echo $text_yes; ?></option>                  
				</select></td>
			</tr>
			<tr>
			  <td><span class="required"></span><?php echo $entry_attrib; ?></td>
              <td><input type="text" name="attr_ext[]" value="" maxlength="128" size="48" title = "e.g. 'attrib=,','" /></td>
			  <td width="150"><span class="required"></span> <?php echo $entry_point1; ?></td>
			  <td><input type="text" name="attr_point[]" value="" maxlength="64" size="32" title = "e.g. &lt;div class=&quot;attribute-block" /></td>
			  <td width="150"><span class="required"></span><?php echo $entry_attribute; ?></td>
              <td><select name="attribute_id[]">
                  <option value="0"><?php echo $text_left; ?></option>
                  <?php foreach ($attributes as $attribute) { ?>
                  <?php if($attribute['attribute_id'] == $attribute_id) { ?>			
                  <option value="<?php echo $attribute['attribute_id']; ?>" selected="selected"><?php echo $attribute['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $attribute['attribute_id']; ?>"><?php echo $attribute['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
			    <td width="150"><span class="required"></span><?php echo $entry_tags; ?></td>
				 <td>
				 <select name="tags[]">			      		
                  <option value="0" selected="selected"> <?php echo $text_no; ?></option>
				  <option value="1"><?php echo $text_yes; ?></option>                  
				</select></td>
			</tr>
			  
			 <?php if (isset($sa)) { $a = -3.14; $i = 0; $j = -1;?>
             <?php foreach ($sa as $sa) { $i=$i+1; $j = $j +1; if (pow ($a,$i) < 1) echo '<tr style=" background: #EEEEEE;" />';
			else echo '<tr>'; ?> 
			  <td><span class="required"></span><?php echo $entry_attrib; ?></td>
         	  <td><input type="text" name="attr_ext[]" value="<?php echo $sa['attr_ext']; ?>" maxlength="128" size="48"/></td>
			  <td width="150"><span class="required"></span> <?php echo $entry_point1; ?></td>
			  <td><input type="text" name="attr_point[]" value="<?php echo $sa['attr_point']; ?>" maxlength="64" size="32" /></td>
			  <td width="150"><span class="required"></span><?php echo $entry_attribute; ?></td>			  
              <td><select name="attribute_id[]">
                  <option value="0"><?php echo $text_left; ?></option>
                  <?php foreach ($attributes as $attibute) { ?>
                  <?php if($attibute['attribute_id'] == $attribute_id[$j]) { ?>			
                  <option value="<?php echo $attibute['attribute_id']; ?>" selected="selected"><?php echo $attibute['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $attibute['attribute_id']; ?>"><?php echo $attibute['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
				 <td width="150"><span class="required"></span><?php echo $entry_tags; ?></td>
				 <td>
				 <select name="tags[]">
			      <?php if($sa['tags'] == 0) { ?>			
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
				  <option value="1" ><?php echo $text_yes; ?></option>
                  <?php } else { ?>
                  <option value="1" selected="selected"><?php echo $text_yes;  ?></option>
				  <option value="0" ><?php echo $text_no; ?></option>
                  <?php } ?>                  
				</select></td>		  
				<?php } ?>
              <?php } ?>		    
            </tr>
            </tbody>
		  </table>          
        </div>

		<div id="tab-option">
          <table class="form">
            <tbody>
			<tr>
			  <td><span class="required"></span><?php echo $entry_option; ?></td>
              <td><select name="option_id[]">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($options as $opp) { ?>
                  <?php if($opp['option_id'] == $option_id) { ?>			
                  <option value="<?php echo $opp['option_id']; ?>" selected="selected"><?php echo $opp['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $opp['option_id']; ?>"><?php echo $opp['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
				<td><span class="required"></span><?php echo $entry_opt; ?></td>
				<td><input type="text" name="opt[]" value="" maxlength="4" size="4" /></td>
				<td><span class="required"></span><?php echo $entry_ko; ?></td>
				<td><input type="text" name="ko[]" value="" maxlength="4" size="4" /></td>
				<td><span class="required"></span><?php echo $entry_pr; ?></td>
				<td><input type="text" name="pr[]" value="" maxlength="4" size="4" /></td>
				<td><span class="required"></span><?php echo $entry_po; ?></td>
				<td><input type="text" name="po[]" value="" maxlength="4" size="4" /></td>
				<td><span class="required"></span><?php echo $entry_we; ?></td>
				<td><input type="text" name="we[]" value="" maxlength="4" size="4" /></td>				
				<td><span class="required"></span><?php echo $entry_option_required; ?></td>
				<td>
				 <select name="option_required[]">			      		
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
				  <option value="1"><?php echo $text_yes; ?></option>                  
				</select></td>
			</tr>
			  
			 <?php if (isset($op)) { $a = -3.14; $i = 0; $j = -1;?>
             <?php foreach ($op as $op) { $i=$i+1; $j = $j +1; if (pow ($a,$i) < 1) echo '<tr style=" background: #EEEEEE;" />';
			else echo '<tr>'; ?> 
			  <td><span class="required"></span><?php echo $entry_option; ?></td>
              <td><select name="option_id[]">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($options as $opp) { ?>
                  <?php if($opp['option_id'] == $option_id[$j]) { ?>			
                  <option value="<?php echo $opp['option_id']; ?>" selected="selected"><?php echo $opp['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $opp['option_id']; ?>"><?php echo $opp['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
				<td><span class="required"></span><?php echo $entry_opt; ?></td>
				<td><input type="text" name="opt[]" value="<?php echo $op['opt']; ?>" maxlength="4" size="4" /></td>
				<td><span class="required"></span><?php echo $entry_ko; ?></td>
				<td><input type="text" name="ko[]" value="<?php echo $op['ko']; ?>" maxlength="4" size="4" /></td>
				<td><span class="required"></span><?php echo $entry_pr; ?></td>
				<td><input type="text" name="pr[]" value="<?php echo $op['pr']; ?>" maxlength="4" size="4" /></td>
				<td><span class="required"></span><?php echo $entry_po; ?></td>
				<td><input type="text" name="po[]" value="<?php echo $op['po']; ?>" maxlength="4" size="4" /></td>
				<td><span class="required"></span><?php echo $entry_we; ?></td>
				<td><input type="text" name="we[]" value="<?php echo $op['we']; ?>" maxlength="4" size="4"/></td>
				<td><span class="required"></span><?php echo $entry_option_required; ?></td>
				<td>
				 <select name="option_required[]">			      		
                  <?php if($op['option_required'] == 0) { ?>			
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
				  <option value="1" ><?php echo $text_yes; ?></option>
                  <?php } else { ?>
                  <option value="1" selected="selected"><?php echo $text_yes;  ?></option>
				  <option value="0" ><?php echo $text_no; ?></option>
                  <?php } ?>               
				</select></td>
				<?php } ?>
              <?php } ?>		    
            </tr>
            </tbody>
		  </table>          
        </div>		
	
	<div id="tab-price">
          <table class="form">
            <tr>
              <td><span class="required"></span><?php echo $entry_site_nom; ?></td>
				<td><input type="text" name="nom[]" maxlength="4" size="4" /></td>
				<td><span class="required"></span><?php echo $entry_site_ident; ?></td>
				<td><input type="text" name="ident[]" maxlength="16" size="16" /></td>				
				<td><span class="required"></span><?php echo $entry_site_param; ?></td>
				<td><input type="text" name="param[]" maxlength="128" size="32" /></td>
				<td><span class="required"></span><?php echo $entry_site_point; ?></td>
				<td><input type="text" name="point[]" maxlength="64" size="32"/></td>									    
            </tr>
			
			<?php if (isset($site)) { $a = -3.14; $i = 0; $j = -1;?>
             <?php foreach ($site as $site) { $i=$i+1; $j = $j +1; if (pow ($a,$i) < 1) echo '<tr style=" background: #EEEEEE;" />';
			else echo '<tr>'; ?> 
			  <td><span class="required"></span><?php echo $entry_site_nom; ?></td>
				<td><input type="text" name="nom[]" value="<?php echo $site['nom']; ?>" maxlength="4" size="4" /></td>
				<td><span class="required"></span><?php echo $entry_site_ident; ?></td>
				<td><input type="text" name="ident[]" value="<?php echo $site['ident']; ?>" maxlength="16" size="16" /></td>				
				<td><span class="required"></span><?php echo $entry_site_param; ?></td>
				<td><input type="text" name="param[]" value="<?php echo $site['param']; ?>" maxlength="128" size="32" /></td>
				<td><span class="required"></span><?php echo $entry_site_point; ?></td>
				<td><input type="text" name="point[]" value="<?php echo $site['point']; ?>" maxlength="64" size="32"/></td>				
				<?php } ?>
              <?php } ?>		    
            </tr>			
		  </table>          
        </div>		
	</form>
	
	<form action="<?php echo $base; ?>" method="post" enctype="multipart/form-data" id="form1">
		<div id="tab-action">		
          <table class="form">
            <tbody>
			<tr>
			  <td><font color="#003a88"><center><strong><h1><?php echo $text_settings; ?></h1></strong></center></font></td><td></td><td></td><td></td>
			</tr>
			<tr style=" background: #EEEEEE;" />              
			  <td><span class="required"></span><strong> <?php echo $entry_actcat; ?></strong></td>
			  <td><select name="act_cat">
                   <option value="0"><?php echo $text_all; ?></option>
                   <?php foreach ($categories as $category) { ?>
                   <?php if($category['category_id'] == $act['act_cat']) { ?>			
                   <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                   <?php } else { ?>
                   <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                   <?php } ?>
                   <?php } ?>
                 </select></td>				
			  <td><span class="required"></span><strong> <?php echo $entry_actmanuf; ?></strong></td>
			  <td><select name="act_manuf">
                  <option value="0" selected="selected"><?php echo $text_all; ?></option>
                  <?php foreach ($manufacturers as $manufacturer) { ?>
                  <?php if ($manufacturer['manufacturer_id'] == $act['act_manuf']) { ?>
                  <option value="<?php echo $manufacturer['manufacturer_id']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
			</tr>
			<tr style=" background: #EEEEEE;" /> 
			  <td><strong><?php echo $entry_date_start; ?></strong></td>
              <td><input type="text" name="filter_date_start" value="<?php echo $act['filter_date_start']; ?>" id="date-start" size="12" /> <?php echo $entry_any; ?></td>
              <td><strong><?php echo $entry_date_end; ?></strong></td>
              <td><input type="text" name="filter_date_end" value="<?php echo $act['filter_date_end']; ?>" id="date-end" size="12" /> <?php echo $entry_any; ?></td>                      
			</tr>
			<tr style=" background: #EEEEEE;" />
			  <td><strong><?php echo $entry_cod_from; ?></strong></td>
              <td><input type="text" name="cod_from" value="<?php echo $act['cod_from']; ?>" maxlength="9" size="12" /> <?php echo $entry_any; ?></td>
			  <td><strong><?php echo $entry_cod_to; ?></strong></td>
              <td><input type="text" name="cod_to" value="<?php echo $act['cod_to']; ?>" maxlength="9" size="12" /> <?php echo $entry_any; ?></td>			  
			</tr>
			<tr style=" background: #EEEEEE;" />            
			  <td><strong><?php echo $entry_actmult; ?></strong></td>
              <td><input type="text" name="act_mult" value="<?php echo $act['act_mult']; ?>" maxlength="9" size="12" /></td>			  
			  <td><strong><?php echo $entry_all; ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;                
                <input type="radio" name="all" value="0" checked="checked" />                
                <?php echo $text_only; ?>                
                <input type="radio" name="all" value="1" />
                <?php echo $text_wse; ?>
              </td>
			  <td><strong><?php echo $entry_kol; ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;                
                <input type="radio" name="isno" value="1" />          
                <?php echo $text_ended; ?>
				<input type="radio" name="isno" value="0" checked="checked" />     
                <?php echo $text_dc; ?>
              </td>				
		  </tr>
		  <tr style=" background: #EEEEEE;" />            
			  <td><strong><?php echo $entry_attribut; ?></strong></td>
              <td><input type="text" name="act_attribut" value="<?php echo $act['act_attribut']; ?>" maxlength="64" size="52" /> <?php echo $entry_any; ?> </td>
			 <td><strong><?php echo $entry_noattribut; ?></strong></td>
              <td><input type="text" name="act_noattribut" value="<?php echo $act['act_noattribut']; ?>" maxlength="64" size="52" /> <?php echo $entry_any; ?> </td>
		  </tr>
		  <tr style=" background: #EEEEEE;" />            
			  <td></td>
              <td></td>
			  <td><strong><?php echo $entry_offproduct; ?></strong></td>
			  <td><select name="offproduct">
			      <?php if($offproduct == 0) { ?>			
                  <option value="0" selected="selected"> <?php echo $entry_offproduct0; ?></option>
                  <?php } else { ?>
                  <option value="0"> <?php echo $entry_offproduct0; ?></option>
                  <?php } ?>
                  <?php if($offproduct == 1) { ?>			
                  <option value="1" selected="selected"><?php echo $entry_offproduct1; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $entry_offproduct1; ?></option>
                  <?php } ?>
				  <?php if($offproduct == 2) { ?>			
                  <option value="2" selected="selected"><?php echo $entry_offproduct2; ?></option>
                  <?php } else { ?>
                  <option value="2"><?php echo $entry_offproduct2; ?></option>
                  <?php } ?>				  
                </select></td>
		  </tr>
		  <tr>
			 <td><font color="#003a88"><center><strong><h1><?php echo $text_act; ?></h1></strong></center></font></td>		  
			 <td>
			  <select name="command" onchange="var command = this[this.selectedIndex]; if (command['onclick']) command.onclick();">				  
                  <option value="0"> <?php echo $text_command0; ?></option>
                  <option value="1"> <?php echo $text_command1; ?></option>
                  <option value="2"><?php echo $text_command2; ?></option>                  		
                  <option value="3"><?php echo $text_command3; ?></option>
                  <option value="4"><?php echo $text_command4; ?></option>                  
                  <option value="5"><?php echo $text_command5; ?></option>
				  <option value="13"><?php echo $text_command13; ?></option>
                  <option value="6"><?php echo $text_command6; ?></option>
				  <option value="40"><?php echo $text_command40; ?></option>
                  <option value="33"><?php echo $text_command33; ?></option>
                  <option value="7"><?php echo $text_command7; ?></option> 
				  <option value="8"><?php echo $text_command8; ?></option>
				  <option value="22"><?php echo $text_command22; ?></option>
				  <option value="23"><?php echo $text_command23; ?></option>
				  <option value="9" style="color: #0AAB1D;"><?php echo $text_command9;?></option>
				  <option value="10"><?php echo $text_command10;?></option>
				  <option value="11" onclick='window.confirm("<?php echo $text_confirm; ?>");' style="color: #F42424;"><?php echo $text_command11;?></option>
				  <option value="12"><?php echo $text_command12; ?></option>
				  <option value="14"><?php echo $text_command14; ?></option>
				  <option value="15"><?php echo $text_command15; ?></option>
				  <option value="16"><?php echo $text_command16; ?></option>
				  <option value="17"><?php echo $text_command17; ?></option>
				  <option value="31"><?php echo $text_command31; ?></option>
				  <option value="32"><?php echo $text_command32; ?></option>
				  <option value="34"><?php echo $text_command34; ?></option>
				  <option value="18"><?php echo $text_command18; ?></option>
				  <option value="11" onclick='window.confirm("<?php echo $text_confirm; ?>");' style="color: #F42424;"><?php echo $text_command19;?></option>
				  <option value="20"><?php echo $text_command20; ?></option>
				  <option value="21"><?php echo $text_command21; ?></option>
				  <option value="24"><?php echo $text_command24; ?></option>
				  <option value="35"><?php echo $text_command35; ?></option>
				  <option value="36"><?php echo $text_command36; ?></option>
				  <option value="37"><?php echo $text_command37; ?></option>
				  <option value="25" style="color: #0A10B5;"><?php echo $text_command25; ?></option>
				  <option value="26" style="color: #0A10B5;"><?php echo $text_command26; ?></option>
				  <option value="38"><?php echo $text_command38; ?></option>
				  <option value="27"><?php echo $text_command27; ?></option>
				  <option value="39"><?php echo $text_command39; ?></option>
				  <option value="28"><?php echo $text_command28; ?></option>
				  <option value="29"><?php echo $text_command29; ?></option>
				  <option value="30"><?php echo $text_command30; ?></option>				  
                </select></td>
			  <td><span class="required"></span><strong> <?php echo $entry_zactcat; ?></strong></td>
			  <td><select name="zact_cat">
                   <option value="0"><?php echo $text_all; ?></option>
                   <?php foreach ($categories as $category) { ?>
                   <?php if($category['category_id'] == $act['zact_cat']) { ?>			
                   <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                   <?php } else { ?>
                   <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                   <?php } ?>
                   <?php } ?>
                 </select></td>	
		  </tr>
		  <tr>
		      <td></td><td></td>
			  <td><strong><?php echo $entry_find; ?></strong>
			  &nbsp;&nbsp;
              <input type="text" name="act_find" value="<?php echo $act['act_find']; ?>" maxlength="1024" size="40" /></td>			  
			  <td><strong><?php echo $entry_change; ?></strong>
			  &nbsp;&nbsp;
              <input type="text" name="act_change" value="<?php echo $act['act_change']; ?>" maxlength="1024" size="40" /> </td>
		  </tr>  
            </tbody>  
          </table>
		</div>	
		<div class="buttons"><a onclick="$('#form1').submit();" class="button"><?php echo $button_base; ?></a>		
	  </form>
	   
	  <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
 <script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	
	$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>  
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#languages a').tabs();
//--></script>
<?php echo $footer; ?>