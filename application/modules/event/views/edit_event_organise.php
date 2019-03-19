<div>
    <form >
        <label>orgainzer name<input type="text" name="organiser_name" value="<?=$edit_organiser->name ?>"/></label>
    <label>orgainzer image<input type="file" name="organiser_image"/></label>
    <img src="<?=$edit_organiser->logo ?>"/>
    <textarea name="organizer_description" id="event_form_organizer_description"><?=$edit_organiser->description ?></textarea>
    <input type="button" onclick="send_data()"/>
    </form>
</div>
<script>
function send_data(){
$.post("test.php", $("#testform").serialize());
}
</script>