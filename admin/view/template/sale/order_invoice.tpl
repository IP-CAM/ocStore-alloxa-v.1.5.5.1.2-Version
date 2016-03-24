<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" />
<!-------- begin ----------->
<style media='print' type='text/css'>
.noprint {display: none;}
body {background:#FFF; color:#000;}
}
</style>
<!-------- end ----------->
</head>
<body>
<!-------- begin ----------->
<span class="noprint">
<a href='javascript:window.print(); void 0;'> <img src="/image/data/icon/print.png"/ title="Print"></a>
</span>
<!-------- end ----------->
<?php foreach ($orders as $order) { ?>
<div style="page-break-after: always;">
  <h1><?php echo "Товарный Чек"; ?></h1> <!--в этой строке---->
  <table class="store">
    <tr>
      <td><b><?php echo $order['store_owner']; ?></b><br />  <!--в этой строке---->
        <?php echo $order['store_address']; ?><br />
        <?php echo $text_telephone; ?> <?php echo $order['store_telephone']; ?><br />
        <?php if ($order['store_fax']) { ?>
        <?php echo $text_fax; ?> <?php echo $order['store_fax']; ?><br />
        <?php } ?>
        <?php echo $order['store_email']; ?><br />
        <?php echo $order['store_url']; ?></td>
      <td align="right" valign="top"><table>
          <tr>
            <td><b><?php echo "Дата:"; ?></b></td>     <!--в этой строке---->
            <td><?php echo $order['date_added']; ?></td>
          </tr>
          <?php if ($order['invoice_no']) { ?>
          <tr>
            <td><b><?php echo "Номер:"; ?></b></td>     <!--в этой строке---->
            <td><?php echo $order['invoice_no']; ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td><b><?php echo $text_order_id; ?></b></td>
            <td><?php echo $order['order_id']; ?></td>
          </tr>
          <tr>
            <td><b><?php echo "Способ оплаты"; ?></b></td>  <!--в этой строке---->
            <td><?php echo $order['payment_method']; ?></td>
          </tr>
          <?php if ($order['shipping_method']) { ?>
          <tr>
            <td><b><?php echo "Способ доставки"; ?></b></td>  <!--в этой строке---->
            <td><?php echo $order['shipping_method']; ?></td>
          </tr>
          <?php } ?>
        </table></td>
    </tr>
  </table>
  <table class="address">
    <tr class="heading">
      <td width="50%"><b><?php echo "Адрес оплаты"; ?></b></td>   <!--в этой строке---->
      <td width="50%"><b><?php echo "Адрес доставки"; ?></b></td>  <!--в этой строке---->
    </tr>
    <tr>
      <td><?php echo $order['payment_address']; ?><br/>
        <?php echo $order['email']; ?><br/>
        <?php echo $order['telephone']; ?>
        <?php if ($order['payment_company_id']) { ?>
        <br/>
        <br/>
        <?php echo $text_company_id; ?> <?php echo $order['payment_company_id']; ?>
        <?php } ?>
        <?php if ($order['payment_tax_id']) { ?>
        <br/>
        <?php echo $text_tax_id; ?> <?php echo $order['payment_tax_id']; ?>
        <?php } ?></td>
      <td><?php echo $order['shipping_address']; ?></td>
    </tr>
  </table>
  <table class="product">
    <tr class="heading">
      <td><b><?php echo $column_product; ?></b></td>
      <td><b><?php echo $column_model; ?></b></td>
      <td align="right"><b><?php echo "Количество"; ?></b></td>    <!--в этой строке---->
      <td align="right"><b><?php echo "Цена за единицу"; ?></b></td>  <!--в этой строке---->
      <td align="right"><b><?php echo "Всего"; ?></b></td>     <!--в этой строке---->
    </tr>
    <?php foreach ($order['product'] as $product) { ?>
    <tr>
      <td><?php echo $product['name']; ?>
        <?php foreach ($product['option'] as $option) { ?>
        <br />
        &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
        <?php } ?></td>
      <td><?php echo $product['model']; ?></td>
      <td align="right"><?php echo $product['quantity']; ?></td>
      <td align="right"><?php echo $product['price']; ?></td>
      <td align="right"><?php echo $product['total']; ?></td>
    </tr>
    <?php } ?>
    <?php foreach ($order['voucher'] as $voucher) { ?>
    <tr>
      <td align="left"><?php echo $voucher['description']; ?></td>
      <td align="left"></td>
      <td align="right">1</td>
      <td align="right"><?php echo $voucher['amount']; ?></td>
      <td align="right"><?php echo $voucher['amount']; ?></td>
    </tr>
    <?php } ?>
    <?php foreach ($order['total'] as $total) { ?>
    <tr>
      <td align="right" colspan="4"><b><?php echo $total['title']; ?>:</b></td>
      <td align="right"><?php echo $total['text']; ?></td>
    </tr>
    <?php } ?>
  </table>
  <?php if ($order['comment']) { ?>
  <table class="comment">
    <tr class="heading">
      <td><b><?php echo $column_comment; ?></b></td>
    </tr>
    <tr>
      <td><?php echo $order['comment']; ?></td>
    </tr>
  </table>
  <?php } ?>

  <!-------- begin ----------->
   <br/><br/><br/><b> &nbsp;&nbsp;&nbsp;&nbsp;Продавець: _________________</b><br/><br/><br/>
  <!-------- end ----------->
</div>

 <!-------- begin ----------->
  <h1><?php echo "ГАРАНТіЙНиЙ ТАЛОН"; ?></h1>
  <table class="store">
    <tr>
       <td><b><?php echo $order['store_owner']; ?></b> &nbsp;&nbsp;<?php echo $order['store_address']; ?><br />
	   <b><?php echo "Дата продажу:"; ?></b>
              <?php echo $order['date_added']; ?>
       </td>
     </tr>
  </table>

  <table class="product">
    <tr class="heading">
      <td><b><?php echo $column_product; ?></b></td>
      <td><b><?php echo $column_model; ?></b></td>
      <td align="center"><b><?php echo "Серійний номер виробу"; ?></b></td>
      <td align="center"><b><?php echo "Гарантійний термін експлуатації"; ?></b></td>
    </tr>
    <?php foreach ($order['product'] as $product) { ?>
    <tr>
      <td><?php echo $product['name']; ?>
        <?php foreach ($product['option'] as $option) { ?>
        <br />
        &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
        <?php } ?></td>
      <td><?php echo $product['model']; ?></td>
      <td><?php echo " "; ?></td>
      <td align="center"><?php echo "12 місяців"; ?></td>
    </tr>
    <?php } ?>
  </table>

<br/><br/>
 Протягом гарантійного терміну експлуатації, споживач має право на безоплатне гарантійне обслуговування, а в разі 
виявлення недоліків - на безоплатний ремонт чи заміну товару згідно з вимогами Закону України "Про захист прав споживачів"
та Порядку гарантійного ремонту (обслуговування) або гарантійної заміни технічно складних побутових товарів, затвердженого постановою
Кабінету Міністрів України від 11 квітня 2002р. №506.

<br/>
<br/><b><div align="center">Умови гарантії</div></b>

<p>1. Гарантійне обслуговування здійснюється тільки за наявності заповненого гарантійного талону, з вказаним серійним номером
виробу, дата продажу, гарантійного терміну, підпису продавця.</p>
<p>2. На гарантійне обслуговування вироби приймаються тільки за наявності оригінальної упаковки і в повному комплекті.</p>

<p><b>&nbsp;&nbsp;Вироби не підлягають гарантійному обслуговуванню в наступних випадках:</b></p>
<p>1. Порушення користувачем правил (умов) експлуатації виробу;</p>
<p>2. Якщо вироб має механічні пошкодження, а також дефекти складових частин, відсутність частин або вузлів, пошкодження електричних контактів,
з"єднань;</p>
<p>3. Наявності термічного пошкодження виробу або його складових частин;</p>
<p>4. Якщо вироб має наявеість стороннього втручання, спроби ремонту в неуповноваженному сервісному центрі або самостійно;</p>
<p>5. У разі пошкоджень, викликаних влучанням в середину виробу сторонніх речей, речовин, рідин, комах.</p>

<p><b><div align="center">Гарантія не розповсюджується на витратні матеріали, що мають обмежений термін користування.</div></b></p>

<br/>
<p>У разі виникнення технічних проблем ви маєто звернутись до Сервісного центру за адресою в місті Харкові:</p>
<br/>
<br/><br/><br/><b> &nbsp;&nbsp;&nbsp;&nbsp;Продавець: _________________</b>
<br/><br/><br/><b> &nbsp;&nbsp;&nbsp;&nbsp;Споживач: _________________ (ознайомлен)</b>
<!-------- end ----------->
<?php } ?>
</body>
</html>