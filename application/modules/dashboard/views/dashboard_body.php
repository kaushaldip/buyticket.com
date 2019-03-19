<style>
ul.mws-summary li span{width: 150px !important;}
ul.mws-summary li span.little{font-size:12px; width: 180px !important; white-space: normal; padding: 6px 0;}
ul.mws-summary li font{}
</style>
<div class="breadcum clearfix">
    <div class="breadcum_inside">
        <a href="<?=site_url(ADMIN_DASHBOARD_PATH);?>">Dashboard</a>
         
    </div>
    <?php if($this->session->flashdata('error')){
		echo "<div class='mws-form-message error' style='border: 1px solid;'>".$this->session->flashdata('error')."</div>";
		}
    ?>   
</div>
<style>
span#specific_date_span{display: none;}
ul.filter li{display: inline-block;}
</style>

<?php /*
<!--filter
<div class="mws-panel grid_8">	
    <div class="mws-panel-body">
    <form action="" method="get">
    	<div class="mws-panel-content" class="main_filter">
            <ul class="filter">
                <li><input type="radio" name="filter"  class="filter_option " id="filter_daily" value="daily"   <?php if($this->input->get('filter')=='daily'){echo "checked='checked'"; } ?>/><label for="filter_daily">Daily</label></li>
                <li><input type="radio" name="filter" class="filter_option" id="filter_weekly" value="weekly" <?php if($this->input->get('filter')=='weekly'){echo "checked='checked'"; } ?>/><label for="filter_weekly">Weekly</label></li>
                <li><input type="radio" name="filter" class="filter_option" id="filter_monthly" value="monthly" <?php if($this->input->get('filter')=='monthly'){echo "checked='checked'"; } ?>/><label for="filter_monthly">Monthly</label></li>
                <li><input type="radio" name="filter" class="filter_option" id="filter_yearly" value="yearly" <?php if($this->input->get('filter')=='yearly'){echo "checked='checked'"; } ?>/><label for="filter_yearly">Yearly</label></li>
                <li><input type="radio" name="filter" class="filter_option" id="filter_specific" value="specific" <?php if($this->input->get('filter')=='specific'){echo "checked='checked'"; } ?>/><label for="filter_specific">Specific Date</label></li>
                <li><input type="submit" class="mws-button orange" value="Filter" /></li>
                <li><a href="<?=site_url(ADMIN_DASHBOARD_PATH);?>" class="mws-button blue" style="text-decoration: none;">Reset</a></li>
            </ul>
            <span id="specific_date_span">
                <input name="start_date" value="" class="mws-textinput mws-datepicker" />
                <input name="end_date" value="" class="mws-textinput mws-datepicker" />
            </span>
        </div>
     </form>
    </div>
</div>
-->
*/?>

<div class="mws-panel grid_4 mws-collapsible">
    <div class="mws-panel-header">
    	<span class="mws-i-24 i-books-2">Events Summary</span>
        <div class="mws-collapse-button mws-inset"><span></span></div>
    </div>
    <div class="mws-panel-body">
        <ul class="mws-summary">
            <li>
                <span><?=$this->admin_dashboard->dash_total_events();?></span> Created Events.
            </li>
            <li>
                <span><?=$this->admin_dashboard->dash_total_events('1');?> / <?=$this->admin_dashboard->dash_total_events('2');?></span> Created Public Events / Private Events.
            </li>                    
            <li>
                <span><?=$this->admin_dashboard->dash_total_ticket_sold();?></span> Total Sold Tickets.
            </li>
        </ul>    
    </div>                 
</div>


<div class="mws-panel grid_4 mws-collapsible">
    <div class="mws-panel-header">
    	<span class="mws-i-24 i-books-2">Attendees Summary</span>
        <div class="mws-collapse-button mws-inset"><span></span></div>
    </div>
    <div class="mws-panel-body">
        <ul class="mws-summary">
            <li>
                <span><?=$this->admin_dashboard->dash_total_attendees();?></span> Total Attendees.
            </li>
            <li>
                <span><?=$this->admin_dashboard->dash_total_attendees('paid');?></span> Total Paid 
            </li>
            <li>
                <span><?=$this->admin_dashboard->dash_total_attendees('free');?></span> Total Free 
            </li>
                        
        </ul>    
    </div>                 
</div>

<div class="mws-panel grid_4 mws-collapsible">
    <div class="mws-panel-header">
    	<span class="mws-i-24 i-books-2">Users Summary</span>
        <div class="mws-collapse-button mws-inset"><span></span></div>
    </div>
    <div class="mws-panel-body">
        <ul class="mws-summary">
            <li title="Total number of Registered Users">
                <span><?=$this->admin_dashboard->dash_total_users();?></span> Total Registered Users.
            </li>
            <li title="Total number of Users who created events">
                <span><?=$this->admin_dashboard->dash_total_organizer();?></span> Total Organizers.
            </li>
            <li title="Total number of Users who registered to the Affiliate Program">
                <span><?=$this->admin_dashboard->dash_total_affiliate_users();?></span> Total Affiliate Users
            </li>
            <li>
                <span><?=$this->admin_dashboard->dash_total_affilate_referer();?></span> Total Affiliated Event Referrals.
            </li>           
        </ul>    
    </div>                 
</div>


<div class="mws-panel grid_4 mws-collapsible">
    <div class="mws-panel-header">
    	<span class="mws-i-24 i-books-2">Revenue Summary</span>
        <div class="mws-collapse-button mws-inset"><span></span></div>
    </div>
    <div class="mws-panel-body">
        <ul class="mws-summary">
            <li>
                <span class="little"><?="USD ".$this->admin_dashboard->dash_total_revenue();?> </span> <font>Total Revenue.</font>
            </li>            
            <li>
                <span class="little"><?="USD ".$this->admin_dashboard->dash_total_referral_paid();?> paid out of <?="USD ".$this->admin_dashboard->dash_total_referral_payment();?></span> <font>Total Payments to Affiliate (Referral Pay).</font>
            </li>
            <li>
                <span class="little"><?="USD ".$this->admin_dashboard->dash_total_event_affiliate_paid();?> paid out of <?="USD ".$this->admin_dashboard->dash_total_event_affiliate_payment();?></span> <font>Total Payments to Affiliate (Event Affiliate Pay).</font>
            </li>
            <li>
                <span class="little"><?="USD ".$this->admin_dashboard->dash_total_webfee();?></span> <font>Total Web Fee.</font>
            </li>
            <li>
                <span class="little"><?="USD ".($this->admin_dashboard->dash_total_webfee() - $this->admin_dashboard->dash_total_referral_payment()) ;?></span> <font>Total net Profit.</font>
            </li>
        </ul>    
    </div>                 
</div>