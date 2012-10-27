<section class="title">
    <?php if ($this->method == 'create'): ?>
    <h4><?php echo lang('countries.create_title');?></h4>
    <?php else: ?>
    <h4><?php echo sprintf(lang('countires.edit_title'), $country->country);?></h4>
    <?php endif; ?>
</section>

<section class="item">
<?php echo form_open(uri_string(), 'class="crud"'); ?>
            <fieldset>
                <ul>
                    <li class="even">
                        <label for="code"><?php echo lang('countries.code');?> <span>*</span></label>
                        <div class="input"><?php echo form_input('code', $country->code, 'maxlength="10"'); ?></div>
                    </li>
                    <li>
                        <label for="country"><?php echo lang('countries.country');?> <span>*</span></label>
                        <div class="input"><?php echo form_input('country', $country->country, 'maxlength="250"'); ?></div>
                    </li>
                </ul>
            </fieldset>

    <div class="buttons float-right padding-top">
        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
    </div>

<?php echo form_close(); ?>
</section>
