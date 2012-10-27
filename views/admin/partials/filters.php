<fieldset id="filters">

    <legend><?php echo lang('global:filters'); ?></legend>

    <?php echo form_open('admin/countries'); ?>

    <?php echo form_hidden('f_module', $module_details['slug']); ?>
    <ul>
        <li><label for="f_keywords"><?php echo lang('countries.keywords');?></label></li>
        <li><?php echo form_input('f_keywords'); ?></li>
        <li><?php echo anchor(current_url(), lang('buttons.cancel'), 'class="cancel"'); ?></li>
    </ul>
    <?php echo form_close(); ?>
</fieldset>
