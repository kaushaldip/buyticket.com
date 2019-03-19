<h1>Select the country for rss</h1>
<form action="<?=site_url('rss_action') ?>" method="post" target="_blank">
    <select name="country">
        <?php foreach($country as $c): ?>
        <option value="<?=$c->country ?>"><?=$c->country ?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit"/>
</form>