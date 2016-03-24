<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<meta name=viewport content="width=device-width, initial-scale=1">
<title><?php echo $title; if (isset($_GET['page'])) { echo " - ". ((int) $_GET['page'])." ".$text_page;} ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; if (isset($_GET['page'])) { echo " - ". ((int) $_GET['page'])." ".$text_page;} ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<meta property="og:title" content="<?php echo $title; if (isset($_GET['page'])) { echo " - ". ((int) $_GET['page'])." ".$text_page;} ?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo $og_url; ?>" />
<?php if ($og_image) { ?>
<meta property="og:image" content="<?php echo $og_image; ?>" />
<?php } else { ?>
<meta property="og:image" content="<?php echo $logo; ?>" />
<?php } ?>
<meta property="og:site_name" content="<?php echo $name; ?>" />
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/normalize.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/stylesheet.css" />
<link rel="stylesheet" href="catalog/view/theme/default/stylesheet/default.css">   
    <link rel="stylesheet" href="catalog/view/theme/default/stylesheet/slick.css">   
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>

<link href="//fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet" type="text/css">
<link href="//fonts.googleapis.com/css?family=Pontano+Sans:400" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/font-awesome.css" />
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/flexslider-2.2/flexslider.css" />

<!-- <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/dr-stylesheet.css" /> -->
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/dr-stylesheet-flexslider.css" />

<![if (!IE)|(gte IE 9)]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/dr-responsive.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/dr-responsive-flexslider.css" />
<![endif]>

<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<script src="catalog/view/javascript/slick.js"></script> 
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>
<?php if ($_SERVER['REQUEST_URI'] == '/credit' || $_SERVER['REQUEST_URI'] == '/checkout/') { ?>
<script type="text/javascript" src="catalog/view/javascript/credit.js"></script>
<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<!--[if IE 7]> 
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->
<?php if ($stores) { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
<?php foreach ($stores as $store) { ?>
$('body').prepend('<iframe src="<?php echo $store; ?>" style="display: none;"></iframe>');
<?php } ?>
});
//--></script>
<?php } ?>
<?php echo $google_analytics; ?>
</head>
<body>
<div id="container">
<div id="header">
  <div class="top-info"></div>
  <div class="top-container">
      <nav class="top">
          <ul>
              <li>
                  <a href="/services" class="menu1277">Сервисный центр</a>
              </li>
              <li>
                  <a href="/aktsii" class="menu531">Акции</a>
              </li>
              <li>
                  <a href="/blog" class="menu671">Новости</a>
              </li>
              <li>
                  <a href="/credit" class="menu1299">Кредит</a>
              </li>
              <li>
                  <a href="/delivery" class="menu335">Доставка</a>
              </li>
              <li>
                  <a href="/contacts" class="menu337">Контакты</a>
              </li>
          </ul>

          <span></span>
      </nav>
      <!-- <div id="search">
        <div class="button-search">Искать</div>
        <input type="text" name="search" placeholder="<?php echo $text_search; ?>" value="<?php echo $search; ?>" />
      </div> -->
      <div class="search">
          <div class="burger-menu"></div>
          <div class="search-bar">
              <form id="form_search">

                <input type="text" name="search" placeholder="<?php echo $text_search; ?>" value="<?php echo $search; ?>" />
                <div class="button-search">Искать</div>
                <!-- <input type="submit" value="Искать" /> -->
                  <!-- <input type="text" name="s" value="" id="search" autocomplete="off" />
                  <input type="submit" value="Искать" /> -->
              </form>
          </div>
      </div>
  </div>
  <?php if ($logo) { ?>
  <div class="logo">
      <!-- <img src="images/logo.jpg" width="295" height="64" /> -->
      <?php if ($home == $og_url) { ?>
      <img src="catalog/view/theme/default/images/logo.jpg" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" />
      <?php } else { ?>
      <a href="<?php echo $home; ?>"><img src="catalog/view/theme/default/images/logo.jpg" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a>
      <?php } ?>
  </div>
   <?php } ?>
<div id="top"></div>
<!--   <?php if ($logo) { ?>
  <div id="logo">
  <?php if ($home == $og_url) { ?>
  <img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" />
  <?php } else { ?>
  <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a>
  <?php } ?>
  </div>
  <?php } ?> -->
 <!--  <?php echo $language; ?>
  <?php echo $currency; ?>
   -->
  <div class="phone">
      <div class="time">
          <div class="arrow"> </div>
          <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td>Пн. - Пт. &nbsp;</td>
                  <td><strong>C 09:00 до 19:00</strong></td>
              </tr>
              <tr>
                  <td>Сб.&nbsp;</td>
                  <td><strong>C 10:00 до 16:00</strong></td>
              </tr>
          </table>
      </div>
      <p><strong>(044) 599-75-75</strong><br /><strong>(093) 500-00-19</strong><br /><strong>(096) 833-33-83</strong></p>
  </div>
  <div class="cart" id="cart"onclick="window.location='/index.php?route=checkout/cart' ">
      <div class="container">
          <p><span class="strong">В корзине </span></p>
          <?php echo $cart; ?>
          <!-- <p class="small"><span class="unitscounter">0</span> <span class="goods"> товаров</span></p> -->
      </div>
  </div>

 <div id="welcome">
<!--   <div class="login welcome">
      <p><span class="userInfoSwitcher" onclick="window.location='/auth/'"><span class="strong">Личный кабинет</span></span></p>
      <p class="small">Добро пожаловать (<?php echo $text_logged; ?>)</p>
  </div> -->
    <?php if (!$logged) { ?>
    <div class="login welcome">
        <p><span class="userInfoSwitcher" onclick="window.location='/index.php?route=account/login'"><span class="strong">Личный кабинет</span></span></p>
        <p class="small">Добро пожаловать (<a href="/index.php?route=account/login">Войти</a>)</p>
    </div>
    <?php } else { ?>
    <?php echo $text_logged; ?>
    <?php } ?>
  </div>
  

 <!--  <div class="cart" id="cart">
      <div class="container">
          <p><span class="strong">В корзине </span></p>
          <p class="small"><span class="unitscounter">0</span> <span class="goods"> товаров</span></p>
      </div>
  </div> -->

  <!-- <div class="links"><a href="<?php echo $home; ?>"><?php echo $text_home; ?></a><a href="<?php echo $wishlist; ?>" id="wishlist-total"><?php echo $text_wishlist; ?></a><a href="<?php echo $shopping_cart; ?>"><?php echo $text_shopping_cart; ?></a><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></div>
</div>-->
<nav class="menu-main">
  <div id="menu">
<?php if ($categories) { ?>
  <ul>
    <?php foreach ($categories as $category) { ?>
        <?php if (($category['line'] && $category['line_on']) || !$category['line']) { ?>
            <li><?php if ($category['active']) { ?>
            <a href="<?php echo $category['href']; ?>" class="active"><?php echo $category['name']; ?></a>
            <?php } else { ?>
            <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
            <?php } ?>

              <?php if ($category['children']) { ?>
              <div>
                <?php for ($i = 0; $i < count($category['children']);) { ?>
                  <ul>
                    <?php $j = $i + ceil(count($category['children']) / 5); ?>
                    <?php for (; $i < $j; $i++) { ?>
                      <?php if (isset($category['children'][$i])) { ?>
                        <?php if (($category['children'][$i]['line'] && $category['children'][$i]['line_on']) || !$category['children'][$i]['line']) { ?>
                            <li>
                              <a style="font-size: 14px;" href="<?php echo $category['children'][$i]['href']; ?>"><?php echo $category['children'][$i]['name']; ?></a>
                              <?php if ($category['children'][$i]['children']) { ?>
                                <div>
                                  <ul>
                                    <?php for ($k = 0; $k < count($category['children'][$i]['children']); $k++) { ?>
                                      <?php if (($category['children'][$i]['children'][$k]['line'] && $category['children'][$i]['children'][$k]['line_on']) || !$category['children'][$i]['children'][$k]['line']) { ?>
                                      <li><a style="font-size: 12px;" href="<?php echo $category['children'][$i]['children'][$k]['href']; ?>">•&nbsp;<?php echo $category['children'][$i]['children'][$k]['name']; ?></a></li>
                                      <?php } ?>
                                    <?php } ?>
                                  </ul>
                                </div>
                              <?php } ?>
                            </li>
                        <?php } ?>
                      <?php } ?>
                    <?php } ?>
                  </ul>
                <?php } ?>
              </div>
              <?php } ?>
            </li>
        <?php } ?>
    <?php } ?>
  </ul>
  <span></span>
  </div>
</nav>
<?php } ?> 

<?php if ($categories) { ?>
<div id="topmenu" class="wrapper clearafter">
<div id="menu" class="clearafter">
  <ul class="menuclear">
    <?php foreach ($categories as $category) { ?>
    <?php if (($category['line'] && $category['line_on']) || !$category['line']) { ?>
    <li class="menuclear"><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
      <?php if ($category['children']) { ?>
      <span class="children-open"></span>
      <div>
        <?php for ($i = 0; $i < count($category['children']);) { ?>
        <ul>
          <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
          <?php for (; $i < $j; $i++) { ?>
          <?php if (isset($category['children'][$i])) { ?>
          <?php if (($category['children'][$i]['line'] && $category['children'][$i]['line_on']) || !$category['children'][$i]['line']) { ?>
          <li><a href="<?php echo $category['children'][$i]['href']; ?>"><?php echo $category['children'][$i]['name']; ?></a></li>
          <?php } ?>
          <?php } ?>
          <?php } ?>
        </ul>
        <?php } ?>
      </div>
      <?php } ?>
    </li>
    <?php } ?>
    <?php } ?>
  </ul>
  <a id="mainmenu-toggle" href="#" >Каталог</a>
  <div class="clearbreak"> </div>
</div>
<div class="clearbreak"> </div>
</div>
<div class="clearafter"> </div>
<?php } ?>
<script type="text/javascript">
<!--
$(document).ready(function() {
      var pull    = $("#menu #mainmenu-toggle"),
        menu    = $("#menu>ul.menuclear"),
        menuHeight  = menu.height();

      $(pull).on('click', function(e) {
        e.preventDefault();
        menu.slideToggle();
        jQuery(this).toggleClass('opened');
      });

      $(window).resize(function(){
            var w = $(window).width();
            if(w > 920 && menu.is(':hidden')) {
              menu.removeAttr('style');
            }
        });
      jQuery('.burger-menu').click(function() {
        jQuery(this).toggleClass('open');
        jQuery('.top-container nav.top').slideToggle();
      });
      jQuery(window).scroll(function() {
        // if (jQuery('.top-container nav.top').is(':visible')) {
        //   jQuery('.burger-menu').toggleClass('open');
        //   jQuery('.top-container nav.top').slideToggle();
        // }
      });
      jQuery('#topmenu #menu > ul > li').click(function() {
        if (jQuery(this).siblings('div').length > 0) {
          jQuery(this).siblings('div').slideToggle();
        }
      });
      jQuery('#topmenu #menu > ul > li > .children-open').click(function() {
        if (jQuery(this).siblings('div').length > 0) {
          jQuery(this).siblings('div').slideToggle(300);
          jQuery(this).toggleClass('opened');
          if (jQuery(this).parent().hasClass('hauto')) {
            setTimeout(function() {
              jQuery(this).parent().toggleClass('hauto');
            }, 300);
          } else {
            jQuery(this).parent().toggleClass('hauto');
          }
        }
      });
});
-->
</script> 
</div>
