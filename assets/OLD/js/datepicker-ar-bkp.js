/* Arabic Translation for jQuery UI date picker plugin. */
/* Khaled Al Horani -- koko.dw@gmail.com */
/* خالد الحوراني -- koko.dw@gmail.com */
/* NOTE: monthNames are the original months names and they are the Arabic names, not the new months name فبراير - يناير and there isn't any Arabic roots for these months */
/*
(function($) {
        $.datepicker.regional['ar'] = {
                renderer: $.datepicker.defaultRenderer,
                monthNames: ['كانون الثاني', 'شباط', 'آذار', 'نيسان', 'آذار', 'حزيران',
                'تموز', 'آب', 'أيلول',  'تشرين الأول', 'تشرين الثاني', 'كانون الأول'],
                monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'],
                dayNames: ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'],
                dayNamesShort: ['سبت', 'أحد', 'اثنين', 'ثلاثاء', 'أربعاء', 'خميس', 'جمعة'],
                dayNamesMin: ['سبت', 'أحد', 'اثنين', 'ثلاثاء', 'أربعاء', 'خميس', 'جمعة'],
                dateFormat: 'dd/mm/yyyy',
                firstDay: 0,
                prevText: '&#x3c;السابق', prevStatus: '',
                prevJumpText: '&#x3c;&#x3c;', prevJumpStatus: '',
                nextText: 'التالي&#x3e;', nextStatus: '',
                nextJumpText: '&#x3e;&#x3e;', nextJumpStatus: '',
                currentText: 'اليوم', currentStatus: '',
                todayText: 'اليوم', todayStatus: '',
                clearText: '-', clearStatus: '',
                closeText: 'إغلاق', closeStatus: '',
                yearStatus: '', monthStatus: '',
                weekText: 'أسبوع', weekStatus: '',
                dayStatus: 'DD d MM',
                defaultStatus: '',
                isRTL: true,
                
        };
        $.extend($.datepicker.defaults, $.datepicker.regional['ar']);
})(jQuery);
*/

/* Arabic Translation for jQuery UI date picker plugin. */
/* Khaled Al Horani -- koko.dw@gmail.com */
/* خالد الحوراني -- koko.dw@gmail.com */
/* NOTE: monthNames are the original months names and they are the Arabic names, not the new months name فبراير - يناير and there isn't any Arabic roots for these months */
jQuery(function($){
	$.datepicker.regional['ar'] = {
		closeText: 'إغلاق',
		prevText: 'prev',// '&#x3c;السابق',
		nextText: 'next',// 'التالي&#x3e;',
		currentText: 'اليوم',
		monthNames: ['كانون الثاني', 'شباط', 'آذار', 'نيسان', 'آذار', 'حزيران',
		'تموز', 'آب', 'أيلول',	'تشرين الأول', 'تشرين الثاني', 'كانون الأول'],
		monthNamesShort: ['كانون الثاني', 'شباط', 'آذار', 'نيسان', 'آذار', 'حزيران',
		'تموز', 'آب', 'أيلول',	'تشرين الأول', 'تشرين الثاني', 'كانون الأول'],
		dayNames: ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'],
		dayNamesShort: ['سبت', 'أحد', 'اثنين', 'ثلاثاء', 'أربعاء', 'خميس', 'جمعة'],
		dayNamesMin: ['سبت', 'أحد', 'اثنين', 'ثلاثاء', 'أربعاء', 'خميس', 'جمعة'],
		weekHeader: 'أسبوع',
		dateFormat: 'dd/mm/yy',
		firstDay: 6,
  		isRTL: true,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['ar']);
});
