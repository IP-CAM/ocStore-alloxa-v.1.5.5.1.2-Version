<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <div class="categories-select">
    <a href="<?php echo $href_all; ?>" title="<?php echo $text_all; ?>"><?php echo $text_all; ?></a>
    <?php if ($information_categories) { ?>
      <?php foreach ($information_categories as $information_category) { ?>
        <a href="<?php echo $information_category['href']; ?>" title="<?php echo $information_category['title']; ?>"><?php echo $information_category['title']; ?></a>
      <?php } ?>
    <?php } ?>
  </div>
  <?php if (!empty($informations)) { ?>
  <?php foreach ($informations as $information) { ?>
    <div class="category-information">
      <a class="category-information-image" href="<?php echo $information['href']; ?>" title="<?php echo $information['title']; ?>"><img src="<?php echo $information['thumb']; ?>" alt="<?php echo $information['title']; ?>" /></a>
      <a class="category-information-title" href="<?php echo $information['href']; ?>" title="<?php echo $information['title']; ?>"><?php echo $information['title']; ?></a>
    </div>
  <?php } ?>
  <?php } else { ?>
    <?php echo $text_empty_category; ?>
  <?php } ?>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>