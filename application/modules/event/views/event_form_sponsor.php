<div align="center" class="error">
    <?php 
        if($this->session->flashdata('message')){
            echo "<div class='message'>".$this->session->flashdata('message')."</div>";
        }   
    ?>
</div>
<form method="post" enctype="multipart/form-data" action="" id="event_form" class="for_form box">
    <h1>Event Information &raquo; Location Information &raquo; Organizer Information &raquo; <span class="current_form">Sponsor Information</span> </h1>
    <fieldset class="for_inputs box_content">
        <div class="for_inputs">            
            <table id="sponsorTable" border="0" cellpadding="0" cellspacing="0" width="100%" class="table_rows_add">  
                <tr>    
                    <td width="1"></td>
                    <td width="401"></td>
                </tr>                  
                <tr>
                    <td align="right"><input type="checkbox" name="chk"/></td>
                    <td>
                        <p>          
                            <label>Sponsor Name:</label>
                            <input type="text" name="sponsor_name[]" id="event_form_sponsor_name[]" />
                        </p>
                        <p>   
                            <label>Sponsor Logo:</label>                                                            
                            <input type="file" name="sponsor_logo[]" id="event_form_sponsor_logo[]" />
                        </p>                       
                    </td>
                </tr>
            </table>
            <p>
                <input type="button" value="Add Row" class="add_celeb submit_small" onclick="addRow('sponsorTable')" style="font-size:11px;" />
                <input type="button" value="Delete Row" class="add_celeb submit_small" onclick="deleteRow('sponsorTable')" style="font-size:11px;" />                     
            </p>
        </div>        
    </fieldset>
    <fieldset>
        <br clear="all" />
        <p style="text-align: center; float: right;">
            <input type="submit" name="post_event" value="Complete" class="submit" />
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