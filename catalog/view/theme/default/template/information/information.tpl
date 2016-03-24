<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content" class="information-page"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1 <?php echo $is_news ? 'class="information-title"' : ''; ?>><?php echo $heading_title; ?></h1>
  <div class="information-description">
    <?php echo $description; ?>
    <?php if ($is_news) { ?><div style="color: #999;"><?php echo $date_added; ?></div><?php } ?>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>