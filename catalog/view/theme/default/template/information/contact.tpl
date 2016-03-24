<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php /* ?><form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <h2><?php echo $text_location; ?></h2>
    <div class="contact-info">
      <div class="content"><div class="left"><b><?php echo $text_address; ?></b><br />
        <?php echo $store; ?><br />
        <?php echo $address; ?></div>
      <div class="right">
        <?php if ($telephone) { ?>
        <b><?php echo $text_telephone; ?></b><br />
        <?php echo $telephone; ?><br />
        <br />
        <?php } ?>
        <?php if ($fax) { ?>
        <b><?php echo $text_fax; ?></b><br />
        <?php echo $fax; ?>
        <?php } ?>
      </div>
    </div>
    </div>
    <h2><?php echo $text_contact; ?></h2>
    <div class="content">
    <b><?php echo $entry_name; ?></b><br />
    <input type="text" name="name" value="<?php echo $name; ?>" />
    <br />
    <?php if ($error_name) { ?>
    <span class="error"><?php echo $error_name; ?></span>
    <?php } ?>
    <br />
    <b><?php echo $entry_email; ?></b><br />
    <input type="text" name="email" value="<?php echo $email; ?>" />
    <br />
    <?php if ($error_email) { ?>
    <span class="error"><?php echo $error_email; ?></span>
    <?php } ?>
    <br />
    <b><?php echo $entry_enquiry; ?></b><br />
    <textarea name="enquiry" cols="40" rows="10" style="width: 99%;"><?php echo $enquiry; ?></textarea>
    <br />
    <?php if ($error_enquiry) { ?>
    <span class="error"><?php echo $error_enquiry; ?></span>
    <?php } ?>
    <br />
    <b><?php echo $entry_captcha; ?></b><br />
    <input type="text" name="captcha" value="<?php echo $captcha; ?>" />
    <br />
    <img src="index.php?route=information/contact/captcha" alt="" />
    <?php if ($error_captcha) { ?>
    <span class="error"><?php echo $error_captcha; ?></span>
    <?php } ?>
    </div>
  </form><?php */ ?>
  <div id="view">
    <table style="width: 100%;" border="0">
        <thead>
            <tr>
            <td valign="top" width="480">
                <h2>Call-центр</h2>
                <p>(044) 599-75-75<br />(093) 500-00-19<br />(096) 833-33-83&nbsp;</p>
                <p>По вопросам рекламы и сотрудничества:</p>
                <p>pr@alloxa.com</p>
            </td>
            <td>
                <h2>График работы Call-центра</h2>
                <table border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                        <td><strong>Пн. - Пт.</strong>&nbsp;&nbsp;&nbsp;</td>
                            <td>C 09:00 до 20:00&nbsp;</td>
                        </tr>
                        <tr>
                            <td><strong>Сб.</strong></td>
                            <td>C 10:00 до 16:00</td>
                        </tr>
                    </tbody>
                </table>
            </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div itemscope itemtype="http://schema.org/Organization">
                        <p><span style="font-size: 1.5em;" itemprop="name">Интернет-магазин электроники “Аллоха”</span></p>
                        <h2>Наш адрес:</h2>
                        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                            <p><span itemprop="addressLocality">г.Киев,</span>
                            <span itemprop="streetAddress">Бехтеревский переулок 13, офис 5, 2 этаж</span></p>
                        </div>
                        <h2>Телефоны:</h2>
                        <span itemprop="telephone">+38(044) 599-75-75</span><br />
                        <span itemprop="telephone">+38(093) 500-00-19</span><br />
                        <span itemprop="telephone">+38(096) 833-33-83</span><br />

                        <p><span style="font-size: 1.5em;"><br />Сервисный центр</span>&nbsp;</p>
                        <p>г.Киев, Бехтеревский переулок 13, офис 1 <br /> <br /> <span itemprop="telephone">+38(044) 361 52 51</span><br /> <br /> График работы:</p>
                    </div>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td><strong>Пн-Пт:</strong>&nbsp; &nbsp;</td>
                                <td>С 11:00 до 19:00&nbsp;</td>
                            </tr>
                            <tr>
                                <td><strong>Суббота:</strong></td>
                                <td>Уточнять</td>
                            </tr>
                            <tr>
                                <td><strong>Воскресенье: &nbsp;</strong></td>
                                <td>Выходной</td>
                            </tr>
                        </tbody>
                    </table>
                <p>&nbsp;</p>
                </td>
                <td>
                    <p><iframe src="https://maps.google.com.ua/maps?f=q&amp;source=s_q&amp;hl=ru&amp;geocode=&amp;q=%D0%B1%D0%B5%D1%85%D1%82%D0%B5%D1%80%D0%B5%D0%B2%D1%81%D0%BA%D0%B8%D0%B9+%D0%BF%D0%B5%D1%80%D0%B5%D1%83%D0%BB%D0%BE%D0%BA+13&amp;aq=&amp;sll=48.33599,31.18287&amp;sspn=7.975973,14.128418&amp;ie=UTF8&amp;hq=&amp;hnear=%D0%91%D0%B5%D1%85%D1%82%D0%B5%D1%80%D0%B5%D0%B2%D1%81%D0%BA%D0%B8%D0%B9+%D0%BF%D0%B5%D1%80.,+13,+%D0%9A%D0%B8%D0%B5%D0%B2,+%D0%B3%D0%BE%D1%80%D0%BE%D0%B4+%D0%9A%D0%B8%D0%B5%D0%B2&amp;t=m&amp;z=14&amp;ll=50.457967,30.495332&amp;output=embed" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" width="480" height="450"></iframe></p>
                </td>
            </tr>
        </tbody>
    </table>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>