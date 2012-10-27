<section class="title">
    <h4><?php echo lang('countries.module_title'); ?></h4>
</section>

<section class="item">

<?php if ($countries) : ?>

<?php echo $this->load->view('admin/partials/filters'); ?>

    <?php echo form_open('admin/countries/delete');?>

        <div id="filter-stage">
        <?php echo $this->load->view('admin/tables/countries'); ?>
        </div>

        <div class="table_action_buttons">
            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
        </div>

    <?php echo form_close(); ?>

<?php else : ?>
    <div class="no_data"><?php echo lang('countries.no_countries'); ?></div>
<?php endif; ?>

</section>
