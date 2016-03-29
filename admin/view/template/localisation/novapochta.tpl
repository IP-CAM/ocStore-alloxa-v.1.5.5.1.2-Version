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
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/log.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons" id="button-L">
		<a href="<?php echo $clear; ?>" class="button"><?php echo $button_clear; ?></a>
		</div>
    </div>
    <div class="content">
        <table class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $column_text; ?></td>
              <td class="right" style="width:70px"><?php echo $column_date; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($reports) { ?>
            <?php foreach ($reports as $report) { ?>
            <tr>
              <td class="left"><?php echo $report['text']; ?></td>
              <td class="right"><?php echo $report['date']; ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
    </div>
  </div>
</div>
<?php echo $footer; ?>