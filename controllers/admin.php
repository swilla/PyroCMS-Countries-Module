<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Countries module
 * @author Steve Williamson
 * @link http://appsygna.com/
 */
class Admin extends Admin_Controller {

    /**
     * The current active section
     * @access protected
     * @var string
     */
     protected $section = 'countries';

    private $validation_rules = array(
        array(
            'field' => 'code',
            'label' => 'lang:countries.code',
            'rules' => 'trim|required|max_length[10]'
        ),
        array(
            'field' => 'country',
            'label' => 'lang:countries.country',
            'rules' => 'trim|required|max_length[250]'
        )

    );

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('country_m'));
        $this->lang->load(array('countries'));

        $this->load->library(array('form_validation'));

        $this->form_validation->set_rules($this->validation_rules);
    }

    public function index()
    {
        $base_where = array();

        $base_where = $this->input->post('f_keywords') ? $base_where + array('keywords' => $this->input->post('f_keywords')) : $base_where;

        $countries = $this->country_m->search($base_where);

        $pagination = create_pagination('admin/countries/index', count($countries));

        $countries = array_slice($countries, $pagination['current_page'], $pagination['per_page']);

        if ($this->input->is_ajax_request()) $this->template->set_layout(FALSE);

        $this->template
            ->title($this->module_details['name'])
            ->set('pagination', $pagination)
            ->set('countries', $countries)
            ->append_js('admin/filter.js');

        $this->input->is_ajax_request() ? $this->template->build('admin/tables/countries', $this->data) : $this->template->build('admin/index', $this->data);

    }

    public function create()
    {
        // Got validation?
        if ($this->form_validation->run())
        {
            // Insert the page
            $id = $this->country_m->insert(array(
                'code' 	=> $this->input->post('code'),
                'country' => $this->input->post('country'),
                'created_on'	=> time(),
                'modified_on'	=> time(),
            ));

            // Success or fail?
            $id > 0
                ? $this->session->set_flashdata('success', lang('countries.create_success'))
                : $this->session->set_flashdata('notice', lang('countries.create_error'));

            redirect('admin/countries');
        }

        // Loop through each validation rule
        foreach($this->validation_rules as $rule)
        {
            $country->{$rule['field']} = set_value($rule['field']);
        }

         // Assign data for display
        $this->load->vars(array(
            'country' => &$country
        ));

        $this->template
            ->set('country', $country)
            ->title($this->module_details['name'], lang('countries.create_title'))
            ->build('admin/form', $this->data);
    }

    public function edit($id = 0)
    {
        empty($id) AND redirect('admin/countries');

        if (!$country = $this->country_m->get($id))
        {
            $this->session->set_flashdata('error', lang('countries.not_found_error'));
            redirect('admin/countries/create');
        }

                // Give validation a try, who knows, it just might work!
        if ($this->form_validation->run())
        {
            // Run the update code with the POST data
            $this->country_m->update($id, array(
                'code' 	=> $this->input->post('code'),
                'country' => $this->input->post('country'),
                'created_on'	=> time(),
                'modified_on'	=> time(),
            ));

            $this->session->set_flashdata('success', sprintf(lang('countries.edit_success'), $this->input->post('country')));

            redirect('admin/countries');
        }

                // Loop through each validation rule
        foreach($this->validation_rules as $rule)
        {
            if($this->input->post($rule['field']))
            {
                $country->{$rule['field']} = set_value($rule['field']);
            }
        }

        $this->template
            ->title($this->module_details['name'], sprintf(lang('countries.edit_title'), $country->country))
            ->set('country', $country)
            ->build('admin/form', $this->data);
    }

    public function delete($id = 0)
    {
        $ids = ($id) ? array($id) : $this->input->post('action_to');

        foreach ($ids as $id)
        {
            if ($id !== 1)
            {
                $deleted_ids = $this->country_m->delete($id);
            }

            else
            {
                $this->session->set_flashdata('error', lang('countries.delete_error'));
            }
        }

        // Some pages have been deleted
        if ( ! empty($deleted_ids))
        {
            // Only deleting one page
            if (count($deleted_ids) == 1)
            {
                $this->session->set_flashdata('success', sprintf(lang('countries.delete_success'), $deleted_ids[0]));
            }
            else // Deleting multiple pages
            {
                $this->session->set_flashdata('success', sprintf(lang('countries.mass_delete_success'), count($deleted_ids)));
            }
        }

        else // For some reason, none of them were deleted
        {
            $this->session->set_flashdata('notice', lang('countries.delete_none_notice'));
        }

        redirect('admin/countries');
    }
}
