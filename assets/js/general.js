/*event logo change start*/
$("#eventlogofile1").click(function () {
     $("#photoimg_1").trigger('click');
});

$('#photoimg_1').on('change', function(){  
    root_url = site_url.slice(0,-3); 
    $(".event_logo_holder").html('');
    $(".event_logo_holder").html('<img src='+root_url+'/assets/images/ajax_loader_small.gif>');
    $("#event_form").ajaxForm({
        target: '.event_logo_holder'
    }).submit();

});
/*event logo change end*/

/*for event_form.php and event_form_edit.php for date picket*/
$(function(){ 
    $(".datepicker" ).datetimepicker({
        dateFormat: "yy-mm-dd",
        timeFormat: "hh:mm tt"
    });
});

$(function(){ 
    $(".dateonlypicker" ).datepicker({
        dateFormat: "yy-mm-dd",
    });
});
/*for event_form.php and event_form_edit.php for date picket*/


/*for event_form.php and event_form_edit.php*/
function showFrequency(tperiod)
{
	if(tperiod=='Custom')
	{
	   $('#show_days').hide();
       $('#from_to_date').hide();
	   $('#show_never_end').hide();
	   $('#custom_date').show();
	} 
	else if(tperiod=='Daily')
	{
	   $('#show_days').hide();
	   $('#from_to_date').show();
	   $('#show_never_end').show();
	   $('#custom_date').hide();
      
	}
	else 
	{
	   $('#show_days').show();
       $('#from_to_date').show();
	   $('#show_never_end').show();
	   $('#custom_date').hide();
	}
}
/*for event_form.php and event_form_edit.php*/