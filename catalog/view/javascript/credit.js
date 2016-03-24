var paid_must_pers = 0;
var komis_once = 0.00;
var komis_month= 0.025;
var insurance= 0.0095;
var product_price = 0;
var paid_must_val = product_price*paid_must_pers;
var max_kredit_sum = 50000;
	
$(document).ready(function(){	
	recalculate();
	
	$('#btn_recalc').click(function(){
		recalculate();
	});

	$('#credit_paid').keyup(function(event) {
		if(event.keyCode == 13) {
			recalculate();
		}
	});
	
	$('#id_bank').change(function(){
		recalculate();
	});

	$("#credit_paid").change(function(){
		recalculate();
	});
	
	$('input[name=name]').change(function(){
		$('#credit_firstname').val($(this).val());
	});
	
	$('input[name=last_name]').change(function(){
		$('#credit_lastname').val($(this).val());
	});

	$(".el-phone").mask("+38(099)999-99-99");
	$.mask.definitions['m'] = "[01]";
	$.mask.definitions['n'] = "[012]";
	$.mask.definitions['d'] = "[0123]";
	$(".el-input-date").mask("d9.m9.9999");	
	$('input[name=inn]').mask("9999999999");
		
});



function getPaidValue(el)
{
	var val1=el.val();
	var val2=val1.replace(/\,/, ".");
    var ex  = /(^\d\d*\.?\d*$)/;
    if (!ex.test(val2) || parseFloat(val2)>=product_price ||  parseFloat(val2)<paid_must_val) {
		el.val(paid_must_val.toFixed(2));
    } else {
    	el.val(parseFloat(val2).toFixed(2));
	}
	return parseFloat(el.val()).toFixed(2);
}

var credit_term_items = '';

function recalculate()
{
	var id_bank = $('#id_bank option:selected').val();	
	product_price = parseFloat($('#credit_total').val());
	komis_once = $('#komis_once'+id_bank).val();
	komis_month = $('#komis_month'+id_bank).val();
	insurance = $('#insurance'+id_bank).val();	
	facility_period = $('#facility_period'+id_bank).val();
	limit_month_start = parseInt($('#limit_month_start'+id_bank).val());
	limit_month_end = parseInt($('#limit_month_end'+id_bank).val());

    $('#credit_term > option').show();
	$('#credit_term').prepend(credit_term_items);
	$('#credit_term > option').each(function(i, item){			
		if(!(parseInt($(this).val()) >= limit_month_start && parseInt($(this).val()) <= limit_month_end)){
            credit_term_items += $(this).html();
            $(this).remove();
        }
	});
	
	$('#bank_info').attr('href', '/credit/'+id_bank);	
	
	var paid = getPaidValue($('#credit_paid'));
	var term = $('#credit_term option:selected').val();
	// сумма кредита
	var credit_sum = product_price - paid;
	
	// Льготная сумма
	var facility_sum = (credit_sum/term)*facility_period;
	
	// ежемесячная коммисия	
	var komis_month_val=((credit_sum - facility_sum)+credit_sum*insurance*term+credit_sum*komis_once)*komis_month;
	
	// разовая коммисия делится на весь период
	var komis_once_val=credit_sum*komis_once/term;
	
	// страхование
	var insurance_val=credit_sum*insurance;
	
	// ежемесячная оплата + страхование + часть разовой коммисии
	var topaybody_val=credit_sum/term+insurance_val+komis_once_val;
	
	// предыдущее + ежемесячная коммисия
	var topay_val=topaybody_val+komis_month_val;
	
	$('input[name=komis_month]').val(komis_month_val.toFixed(2));
	$('input[name=komis_once]').val(komis_once_val.toFixed(2));
	$('input[name=insurance]').val(insurance_val.toFixed(2));
	
	$('input[name=topaybody]').val(topaybody_val.toFixed(2));
	$('input[name=topay]').val(topay_val.toFixed(2));
}



function checkDate(month,day,year) {
   result=true;
   leap = 0;
   if ((year % 4 == 0) || (year % 100 == 0) || (year % 400 == 0)) {
      leap = 1;
   }
   if ((month == 1) && (leap == 1) && (day > 29)) {
      result=false;
   }
   if ((month == 1) && (leap != 1) && (day > 28)) {
      result=false;
   }
   if (((month==3) || (month==5) || (month==8) || (month==10)) && (day==31)) {
		result=false;
   }
   return result;
}


