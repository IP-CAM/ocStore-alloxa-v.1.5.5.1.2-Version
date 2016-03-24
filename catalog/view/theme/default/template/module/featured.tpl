<!-- <div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
    <div class="box-product">
      <?php foreach ($products as $product) { ?>
      <div>
        <?php if ($product['thumb']) { ?>
        <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($product['rating']) { ?>
        <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
        <?php } ?>
        <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
      </div>
      <?php } ?>
    </div>
  </div>
</div> -->

<div class="top-sale-container">
    <div class="title-box">
        <p style="font-size: 20px; margin: 0;">Специальные предложения</p>
    </div>
    <div class="products-main" id="carousel<?php echo $module; ?>">
        <ul class="products jcarousel-skin-opencart">
          <?php foreach ($products as $product) { ?>
          <!-- <li>
            <?php if ($product['thumb']) { ?>
            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
            <?php } ?>
            <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
            <?php if ($product['price']) { ?>
            <div class="price">
              <?php if (!$product['special']) { ?>
              <?php echo $product['price']; ?>
              <?php } else { ?>
              <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
              <?php } ?>
            </div>
            <?php } ?>
            <?php if ($product['rating']) { ?>
            <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
            <?php } ?>
            <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
          </li> -->
          
            <li style="text-align: left;">
                <a href="<?php echo $product['href']; ?>" class="avatar">
                    <!-- <div class="tag-prod">
                        <span>Хит продаж</span>
                    </div> -->
                    <?php if ($product['thumb']) { ?>
                    <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />
                    <?php } ?>
                </a>
                <a href="<?php echo $product['href']; ?>" class="title"><?php echo $product['name']; ?></a>
                <div class="code-list"> Код товара:  <?php echo $product['model']; ?></div>
                <p class="desc"></p>
                <div class="prise-box">
                    <div class="prise"><?php echo $product['price']; ?>
                        <span class="hrn"></span>
                        <div class="usd">  $308</div>
                    </div>
                    <div class="buy-box">
                      <div class="cart">
                        <input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" />
                      </div>
                        <!-- <button class="buy buyList" value="8231" rel="8231">Купить</button> -->
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
<script type="text/javascript"><!--
$('#carousel<?php echo $module; ?> ul').jcarousel({
  vertical: false,
  auto: 4, 
  wrap: 'circular',
  visible: <?php echo $limit; ?>,
  scroll: true
});
$(document).ready(function() {
  var cont_carousel = $('.products.jcarousel-list');
  var mw = cont_carousel.parent().outerWidth();
  var ew = cont_carousel.children('li').outerWidth();
  var q = Math.round(mw / ew);
  var aw = 0;
  var m = 0;
  for (var i = q; i > 0; i--) {
    if (i == 1) {
      aw = ew;
      m = (mw - aw) / 2;
      cont_carousel.children('li').css('margin-right', m); 
      cont_carousel.children('li').css('margin-left', m); 
      break;
    } else {
      aw = ((i - 1) * (ew + 9)) + ew;
      if (aw <= mw) {
        m = (mw - (i * ew)) / (i - 1);
        cont_carousel.children('li').css('margin-right', m);
        break;
      }
    }
  }
  // cont_carousel.css('left', 0);
  // cont_carousel.css('width', ew + m * 2);
  //$('#carousel<?php echo $module; ?> ul').jcarousel('reload');
  $(window).resize(function () {
    var cont_carousel = $('.products.jcarousel-list');
    var mw = cont_carousel.parent().outerWidth();
    var ew = cont_carousel.children('li').outerWidth();
    var q = Math.round(mw / ew);
    var aw = 0;
    var m = 0;
    for (var i = q; i > 0; i--) {
      if (i == 1) {
        aw = ew;
        m = (mw - aw) / 2;
        cont_carousel.children('li').css('margin-right', m); 
        cont_carousel.children('li').css('margin-left', m); 
        break;
      } else {
        aw = ((i - 1) * (ew + 9)) + ew;
        if (aw <= mw) {
          m = (mw - (i * ew)) / (i - 1);
          cont_carousel.children('li').css('margin-left', 0);
          cont_carousel.children('li').css('margin-right', m);
          break;
        }
      }
    }
  });
});
//--></script>
<!-- <div class="vidgets">
    <div class="vidget-vk">
        <div id="vk_groups"> </div>
        <script type="text/javascript">
VK.Widgets.Group("vk_groups", {mode: 0, width: "960px", height: "300", color1: 'FFFFFF', color2: '2B587A', color3: '5B7FA6'}, 30217338);
        </script>
    </div>
</div> -->
<div class="page_text">
<h2>Интернет-магазин электроники в Украине</h2>
<p>Во-первых &ndash; прогресс. Smart phone &ndash; это &laquo;умный телефон&raquo;. Да, многие модели даже поумней своих владельцев. Но это не удивительно. С конца 90-х смартфоны начали обретать рациональный, рыночный смысл, потихоньку уходили из разряда &laquo;диковинок&raquo; электроники. И на сегодняшний день магазины электроники в Украине, это магазины где можно легко заблудиться в модельном ряде. <strong>Интернет магазин </strong>электроники в Украине поможет модернизироваться. Огромное количество приложений в предлагаемой продукции для работы и игр добавят яркости и комфортности Вашей жизни.</p>
<p>Планшеты не отстают. После 2002 года, когда Microsoft продемонстрировала публике Microsoft Tablet PC &ndash; это было начало прорыва в мире компьютеров. Теперь маркеты электроники на перебой предлагают последние новинки удобного девайса. Вам остается только сделать правильный выбор. А выбирать есть с чего! Интернет-магазин планшетов предлагает выбрать устройство для работы, для учебы, для игр или для всего вместе взятого. Это практически компьютер размером с досточку. Хоть фрукты и овощи на нем режь. Хотя, не стоит, разве что очень уж салат хочется.</p>
<p>У нас на сайте есть бытовая электроника, цифровая электроника. Наш магазин бытовой электроники это в первую очередь гарантия качества. Доступная &nbsp;современная электроника в Киеве по выгодным ценам, не все магазины электроники в Киеве имеют такое качество обслуживание как у нас.</p>
<h2>Аллоха - супермаркет электроники в Украине - только низкие цены!</h2>
<p>Почти у всех людей есть мобильный телефон. Из этих людей почти у всех не просто мобильный, а смартфон. О чем это говорит? Движение вперед, господа, тот самый прогресс. Спросите владельца обычного телефона, хочет ли он смартфон? Он скажет: &laquo;Нет, я хочу айфон!&raquo; Но такой девайс не каждому по карману, чего не скажешь про &laquo;умные телефоны&raquo; без яблока. Доступных моделей множество, но где их найти? Интернет магазин смартфонов в Киеве, Украине поможет выбрать то, что подходит именно вам.</p>
<p>Да, одно цепляется за другое. Наверняка, у многих Ваших друзей есть планшет. Это вполне рационально, ведь он способен заменить персональный компьютер, электронную книгу, аудио- и видеоплеер. Смартфоны также обладают рядом подобных функций, но здесь уже совсем другой уровень. Интернет магазин планшетов &laquo;Alloxa&raquo; в Киеве поможет Вам почувствовать этот уровень за доступную цену. И, снова таки, мы сделаем это честно. Интернет магазин электроники в Киеве должен предлагать клиенту нечто большое, чем просто продукцию. Мы предлагаем партнерство. В наших рыночных отношениях с покупателем все 50 на 50. Переплатить за планшеты в интернет &ndash; магазине можно где угодно, только не у нас. Почему? Честный подход. Закажи его в &laquo;Alloxa&raquo;.</p>
<h2>Интернет магазин смартфонов в Киеве - Аллоха</h2>
<p>Да, мы не единственный интернет магазин техники и электроники в Киеве, Харькове, Донецке, Запорожье, Луганске, Днепропетровске, но Вы зашли на наш сайт. Что это значит? Вы ищете где купить качественный аппарат недорого в Украине от современного производителя. Вы знаете, нигде. Да, оригинальное качество обычно стоит дорого, так что рассчитывайте свои силы. Помните, цена всегда соотносится с качеством и скупой платит дважды. Наш интернет магазин смартфонов не берет двойную цену. Мы предлагаем надежную оригинальную продукцию по ее реальной стоимости. Вы не уверены? Можете сравнить цены с другими магазинами. В Киеве и других регионах Вы не купите дешевле, чем он стоит. Иначе это подделка. Определитесь чего вы хотите, думайте рационально. Мы поможем выбрать то, что хотелось бы именно вам по цене их качества, без накруток.</p>
Шагайте в ногу со временем с супермаркетом электроники &laquo;Alloxa&raquo;!
</div>
