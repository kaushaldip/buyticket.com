<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-bordered">
    <thead>
        <tr class="ticket_table_head">
            <th><?=$this->lang->line('attendee')?></th>
            <th><?=$this->lang->line('order_by')?></th>
            <th><?=$this->lang->line('ticket_number')?></th>
        </tr>
    </thead>
    <tbody>
    <?php if($attendees):?>
    <?php foreach($attendees as $at):?>
        <tr>
            <td><?=$at->attendee?></td>
            <td><?=$at->email?></td>
            <td><?=$at->barcode?></td>
        </tr>
    <?php endforeach;?>
    <?php endif;?>
    </tbody>
</table>