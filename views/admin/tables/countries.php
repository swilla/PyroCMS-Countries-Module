    <table>
        <thead>
            <tr>
                <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                <th><?php echo lang('countries.abv'); ?></th>
                <th><?php echo lang('countries.country'); ?></th>
                <th><?php echo lang('countries.modified_on'); ?></th>
                <th width="180"></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="7">
                    <div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
                </td>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach ($countries as $country) : ?>
                <tr>
                    <td><?php echo form_checkbox('action_to[]', $country->id); ?></td>
                    <td><?php echo $country->code; ?></td>
                    <td><?php echo $country->country; ?></td>
                    <td><?php echo format_date($country->modified_on); ?></td>
                    <td>
                        <?php echo anchor('admin/countries/edit/' . $country->id, lang('global:edit'), 'class="btn orange edit"'); ?>
                        <?php echo anchor('admin/countries/delete/' . $country->id, lang('global:delete'), array('class'=>'confirm btn red delete')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
