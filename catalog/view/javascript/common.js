$(document).ready(function() {

	// jQuery('#menu > ul > li > div').css('display', 'block');
	// jQuery('.menu-main #menu > ul > li > div > ul').each(function() {
	// 	var max = 0;
	// 	var c = 0;
	// 	var i = 0;
	// 	var th = jQuery(this);
	// 	var l = th.children('li').length % 5;
	// 	if (l > 0) {
	// 		l = 5 - l;
	// 		for (var k = 0; k < l; k++) {
	// 			th.append('<li></li>');
	// 		}
	// 	} 
	// 	th.children('li').each(function() {
	// 		c++;
	// 		console.log(jQuery(this).height());
	// 		if (max == 0 || jQuery(this).height() > max) {
	// 			max = jQuery(this).height();
	// 		}
	// 		if (c == 5) {
	// 			for (var j = 1; j <= 5; j++) {
	// 				th.children('li:nth-child(' + (i * 5 + j) + ')').height(max);
	// 			}
	// 			i++;
	// 			c = 0;
	// 			max = 0;
	// 		}
	// 	});
	// });
	// jQuery('#menu > ul > li > div').css('display', '');
	jQuery('#menu > ul > li > div').css('visibility', 'visible');

	jQuery('#form_search > input[name="search"]').keyup(function() {
		if (jQuery(this).val().length > 0) {
		$.ajax({
			url: 'index.php?route=product/search/autocomplete',
			type: 'post',
			data: 'search_word=' + jQuery(this).val(),
			dataType: 'json',
			success: function(json) {
				jQuery('.autocomplete-wrapper').remove();
				var html = '<div class="autocomplete-wrapper">'
				if (json.total > 0) {
					jQuery.each(json.all, function() {
						html += '<div class="autocomplete-product">';
						html += '<img src="' + this.thumb + '" alt="' + this.name + '" />';
						html += '<div class="right-product-part">';
						html += '<a href="' + this.href + '" title="' + this.name + '">' + this.name + '</a>';
						html += '<div class="right-product-part-price">';
						if (!this.special) {
							html += this.price;
						} else {
							html += this.special;
						}
						html += '</div>';
						html += '</div>';
						html += '</div>';
					});
				} else {
					html += '<div class="no-results">По вашему запросу ничего не найдено. Попробуйте уточнить свой запрос.</div>';
				}
				if (json.total > 5) {
					html += '<div class="search-results"><a href="' + json.search_address + '" title="Показать все результаты (' + json.total + ')">Показать все результаты (' + json.total + ')</a></div>';
				} 
				html += '</div>';
				jQuery('.button-search').after(html);
			}
		});
		} else {
			jQuery('.autocomplete-wrapper').remove();
		}
	});

	/* Search */
	$('.button-search').bind('click', function() {
		url = $('base').attr('href') + 'index.php?route=product/search';
				 
		var search = $('input[name=\'search\']').attr('value');
		
		if (search) {
			url += '&search=' + encodeURIComponent(search);
		}
		
		location = url;
	});
	
	$('#header input[name=\'search\']').bind('keydown', function(e) {
		if (e.keyCode == 13) {
			url = $('base').attr('href') + 'index.php?route=product/search';
			 
			var search = $('input[name=\'search\']').attr('value');
			
			if (search) {
				url += '&search=' + encodeURIComponent(search);
			}
			
			location = url;
		}
	});
	
	/* Ajax Cart */
	$('#cart > .heading a').live('click', function() {
		$('#cart').addClass('active');
		
		$('#cart').load('index.php?route=module/cart #cart > *');
		
		$('#cart').live('mouseleave', function() {
			$(this).removeClass('active');
		});
	});
	
	/* Mega Menu */
	$('#menu ul > li > a + div').each(function(index, element) {
		// IE6 & IE7 Fixes
		if ($.browser.msie && ($.browser.version == 7 || $.browser.version == 6)) {
			var category = $(element).find('a');
			var columns = $(element).find('ul').length;
			
			$(element).css('width', (columns * 143) + 'px');
			$(element).find('ul').css('float', 'left');
		}		
		
		var menu = $('#menu').offset();
		var dropdown = $(this).parent().offset();
		
		i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());
		
		if (i > 0) {
			$(this).css('margin-left', '-' + (i + 5) + 'px');
		}
	});

	// IE6 & IE7 Fixes
	if ($.browser.msie) {
		if ($.browser.version <= 6) {
			$('#column-left + #column-right + #content, #column-left + #content').css('margin-left', '195px');
			
			$('#column-right + #content').css('margin-right', '195px');
		
			$('.box-category ul li a.active + ul').css('display', 'block');	
		}
		
		if ($.browser.version <= 7) {
			$('#menu > ul > li').bind('mouseover', function() {
				$(this).addClass('active');
			});
				
			$('#menu > ul > li').bind('mouseout', function() {
				$(this).removeClass('active');
			});	
		}
	}
	
	$('.success img, .warning img, .attention img, .information img').live('click', function() {
		$(this).parent().fadeOut('slow', function() {
			$(this).remove();
		});
	});	
});

function getURLVar(key) {
	var value = [];
	
	var query = String(document.location).split('?');
	
	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');
			
			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}
		
		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
} 

function addToCart(product_id, quantity) {
	quantity = typeof(quantity) != 'undefined' ? quantity : 1;

	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: 'product_id=' + product_id + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				$('.success').fadeIn('slow');
				
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}
function addToWishList(product_id) {
	$.ajax({
		url: 'index.php?route=account/wishlist/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
						
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				$('.success').fadeIn('slow');
				
				$('#wishlist-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}	
		}
	});
}

function addToCompare(product_id) { 
	$.ajax({
		url: 'index.php?route=product/compare/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
						
			if (json['success']) {
				$('#notification').html('<div class="success">Товар добавлен в сравнение<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				setTimeout(function() {
					$('.success').fadeOut('slow');
				}, 2000);

				if ($('.compare-category').length > 0 && json['compare'].length > 0) {
					var html = '';
					$.each(json['compare'], function() {
						html += '<div class="compare-product" data-product-id="' + this.product_id + '">';
			            html += '<a href="' + this.href + '" title="' + this.name + '" ><img src="' + this.image + '" alt="' + this.name + '" /></a>';
			            html += '<a class="text-link" href="' + this.href + '" title="' + this.name + '" >' + this.name + '</a>';
			            html += '<div class="compare-product-remove" onclick="removeOne($(this));">X</div>';
			            html += '</div>';
					});
					$('.compare-category').show();
					$('.compare-category-products').html(html);
				} else if ($('.compare-product-text').length > 0 && json['compare'].length > 0) {
					console.log(json['compare']);
					var html = '';
					html += '<div class="compare-product-text-inside" style="text-align:center;width: 290px;">В списке товаров для сравнения <span class="count-compare">' + json['compare'].length + '</span> шт.</div>';
					$('.compare-product-text').show();
					html += '<div class="compare-current-product" style="text-align:center;width: 290px;">';
        			html += '<div class="compare-current-product-text">Данный товар в сравнении</div> <div class="compare-product-remove" onclick="removeOne($(this));">X</div>';
      				html += '</div>';
      				html += '<div class="compare-links product" style="text-align:center;width: 290px;float:right;">';
				    html += '<button onclick="removeAll();">Очистить</button>';
				    html += '<a href="/compare-products/" title="К сравнению">К сравнению</a>';
				    html += '</div>';
				    html += '<div style="clear:both;"></div>';
					$('.compare-product-text').html(html);
				}
				
				$('#compare-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}