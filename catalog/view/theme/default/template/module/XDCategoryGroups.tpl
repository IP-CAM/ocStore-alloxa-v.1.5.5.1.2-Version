<style type="text/css">
    <?php echo $XDcustomCSSCode; ?>
    .customSizes {
        padding-left:<?php echo $XDPaddingLeft; ?>px;
        padding-right:<?php echo $XDPaddingRight; ?>px;
        height:<?php echo $XDBlockHeight; ?>px;
    }
</style>
<div class="box">
      <?php 
      foreach($categories as $category) {
      
        // ADD CONDITIONAL INFO FOR SIZING
      
       if($XDAutoPadding == 'active'){
            $spacingClass = 'customSizes';
       } else {
            $spacingClass = 'autoSpacing';
       }
      
        ?>
        <div class="XDCategoryGroupsBlocks <?php echo $spacingClass; ?>">
            <?php 

            if($XDposition == 'aboveImage') {
                if($XDtitleLinks == 'active'){
                ?><h2><a href="<?php echo $category['parent_url']; ?>"><?php echo $category['name']; ?></a></h2><?php
                } else {
                ?><h2><?php echo $category['name']; ?></h2><?php
                }
            } 
            
            if($XDshowImage == 'yes') {
                if($XDtitleLinks == 'active'){
                  ?><a href="<?php echo $category['parent_url']; ?>"><img src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>"/></a><?php
                } else {
                  ?><img class="categoryGroupImg" src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>"/><?php
                }
            }

            if($XDposition == 'belowImage') {
                if($XDtitleLinks == 'active'){
                    ?><h2><a href="<?php echo $category['parent_url']; ?>"><?php echo $category['name']; ?></a></h2><?php
                } else {
                    ?><h2><?php echo $category['name']; ?></h2><?php
                }
            } ?>
            <ul>
            <?php foreach($category['children'] as $childElement){
                echo '<li><a href="'.$childElement['url'].'">'.$childElement['name'].'</a></li>';
            } ?>
            </ul>
            </div>
        <?php
      }
      ?>
</div>
