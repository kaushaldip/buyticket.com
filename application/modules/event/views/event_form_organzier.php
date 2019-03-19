<div align="center" class="error">
    <?php 
        if($this->session->flashdata('message')){
            echo "<div class='message'>".$this->session->flashdata('message')."</div>";
        }   
    ?>
</div>
<form method="post" enctype="multipart/form-data" action="" id="event_form" class="for_form box">
    <h1>Event Information &raquo; Location Information &raquo; <span class="current_form">Organizer Information</span> &raquo; Sponsor Information </h1>
    <fieldset class="for_inputs box_content">        
        <div class="for_inputs">            
            <table id="organizerTable" border="0" cellpadding="0" cellspacing="0" width="100%" class="table_rows_add">  
                <tr>    
                    <td width="1"></td>
                    <td width="401"></td>
                </tr>                  
                <tr>
                    <td align="right" valign="top"><input type="checkbox" name="chk"/></td>
                    <td>
                        <p>                                 
                            <label>Organizer Name</label>                                          
                            <input type="text" name="organizer_name[]" id="event_form_organizer_name[]" value="<?php echo set_value('organizer_name[0]'); ?>" />
                                <?=form_error('organizer_name[]') ?>                               
                        </p>
                        <p>
                            <label>Organizer Logo</label>
                            <input type="file" name="organizer_logo[]" id="event_form_organizer_logo[]" />
                        </p>    
                        <p>
                            <label>Organizer Description</label>
                            <textarea name="organizer_description[]" id="event_form_organizer_description[]"><?php echo set_value('organizer_description[]'); ?></textarea>                            
                        </p>                   
                    </td>
                </tr>
            </table>       
            <p style="text-align: center;">                    
            <input type="button" value="Add Row" class="add_celeb submit_small" onclick="addRow('organizerTable')"  />
            <input type="button" value="Delete Row" class="add_celeb submit_small" onclick="deleteRow('organizerTable')" />                     
            </p>
            
        </div>
    </fieldset>
    <fieldset>
        <br clear="all" />
        <p style="text-align: center; float: right;">
            <input type="submit" name="post_event" value="Skip" class="submit" />
            &nbsp;&nbsp;
            <input type="submit" name="post_event" value="Save Organizer" class="submit" />
        </p>
    </fieldset>
</form>
<script type="text/javascript">	
function addRow(tableID) {

	var table = document.getElementById(tableID);
    
	var rowCount = table.rows.length;
    
	var row = table.insertRow(rowCount);

	var colCount = table.rows[0].cells.length;

	for(var i=0; i<colCount; i++) {

		var newcell	= row.insertCell(i);

		newcell.innerHTML = table.rows[1].cells[i].innerHTML;
		//alert(newcell.childNodes);
		switch(newcell.childNodes[0].type) {
			case "text":
					newcell.childNodes[0].value = "";
					break;
			case "file":
					newcell.childNodes[0].value = "";
					break;		
			case "checkbox":
					newcell.childNodes[0].checked = false;
					break;
			case "select-one":
					newcell.childNodes[0].selectedIndex = 0;
					break;
		}
	}
}

function deleteRow(tableID) {
	try {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;

	for(var i=0; i<rowCount; i++) {
		var row = table.rows[i];
		var chkbox = row.cells[0].childNodes[0];
		if(null != chkbox && true == chkbox.checked) {
			if(rowCount <= 2) {
				alert("Cannot delete all the rows.");
				break;
			}
			table.deleteRow(i);
			rowCount--;
			i--;
		}

	}
	}catch(e) {
		alert(e);
	}
}
</script>