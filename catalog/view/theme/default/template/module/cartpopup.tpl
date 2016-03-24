 <div id="cartpopup" class="well">
    <h4>ТОВАР БЫЛ УСПЕШНО ДОБАВЛЕН В КОРЗИНУ!</h4>
    <div class="cart"></div>
    <button class="btn btn-default prod_pop" style="float: left" onclick="$('#cartpopup').popup('hide')"><?php echo $text_continue_shopping; ?></button>
   <button class="btn btn-default order_pop" style="float: right" onclick="location='/index.php?route=checkout/checkout'"><?php echo $text_view_cart_n_checkout; ?></button>&nbsp;
   
  </div>

<script type="text/javascript">
//<![CDATA[

function declination(s) {
	var words = ['<?php echo $text_product_5; ?>', '<?php echo $text_product_1; ?>', '<?php echo $text_product_2; ?>'];
	var index = s % 100;
	if (index >=11 && index <= 14) { 
		index = 0; 
	} else { 
		index = (index %= 10) < 5 ? (index > 2 ? 2 : index): 0; 
	}
	return(words[index]);
}
$(document).ready(function () {
    $('#cartpopup').popup();
});
//]]> 
</script>