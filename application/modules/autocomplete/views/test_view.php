<html lang="en">
           <head>
                       <title>test</title>
                <script src="<?php echo base_url();?>assets/js/jquery-1.6.2.js" type="text/javascript"/>
                <script src="<?php echo base_url();?>assets/js/jquery.ui.position.js" type="text/javascript"/>
                <script src="<?php echo base_url();?>assets/js/jquery.ui.autocomplete.js" type="text/javascript"/>            
<script  type="text/javascript">
                $(function() {
           $("#login_nik").live("keypress", function() {
                      var nik = ($("#login_nik").val());
                      var availableTags;
                      $.ajax({
                                 type: "POST",
                                 url: "http://yourlocalsite/index.php/test/getListNIK4LoginAutoComplete",
                                 data: "nik="+nik,
                                 async: false,
                                 dataType: 'json',
                                 success: function(data) {
                                            availableTags = data;
                                 }
                      });          

                      $( "#login_nik" ).autocomplete({
                                 source: availableTags
                      });
           });
           
});
            </script>
</head>
           <body>
        

<?php echo form_input(array('name' => 'nik', 'size' => '20', 
'value' => set_value('nik'), 'id'=>'login_nik')); ?>
        </body>
</html>      