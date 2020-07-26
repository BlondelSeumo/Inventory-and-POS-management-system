<?php

/**
 * Author: Amirul Momenin
 * Desc:Users Controller
 *
 */
class Profile extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->library('Customlib');
        $this->load->helper(array(
            'cookie',
            'url'
        ));
        $this->load->database();
        $this->load->model('Users_model');
        if (! $this->session->userdata('validated')) {
            redirect('admin/login/index');
        }
    }

    /**
     * Index Page for this controller.
     */
    function index()
    {
        $limit = 10;
        $data['users'] = $this->Users_model->get_users($this->session->userdata['id']);
        $data['_view'] = 'admin/profile/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /*
     * Save users
     */
    function save($id = - 1)
    {
        // cointry
        $this->db->order_by('country', 'Asc');
        $result = $this->db->get('country')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        $data['country'] = $result;

        $file_picture = "";

        $params = array(
            'email' => html_escape($this->input->post('email')),
			'password' => html_escape($this->input->post('password')),
            'title' => html_escape($this->input->post('title')),
            'first_name' => html_escape($this->input->post('first_name')),
            'last_name' => html_escape($this->input->post('last_name')),
            'file_picture' => html_escape($file_picture),
            'phone_no' => html_escape($this->input->post('phone_no')),
            'dob' => html_escape($this->input->post('dob')),
            'company' => html_escape($this->input->post('company')),
            'address' => html_escape($this->input->post('address')),
            'city' => html_escape($this->input->post('city')),
            'state' => html_escape($this->input->post('state')),
            'zip' => html_escape($this->input->post('zip')),
            'country_id' => html_escape($this->input->post('country_id')),
            'updated_at' => date("Y-m-d H:i:s")
        );

        $config['upload_path'] = "./public/uploads/images/users";
        $config['allowed_types'] = "gif|jpg|png";
        $config['max_size'] = 100;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;
        $this->load->library('upload', $config);

        if (isset($_POST) && count($_POST) > 0) {
            if (strlen($_FILES['file_picture']['name']) > 0 && $_FILES['file_picture']['size'] > 0) {
                if (! $this->upload->do_upload('file_picture')) {
                    $error = array(
                        'error' => $this->upload->display_errors()
                    );
                } else {
                    $file_picture = "uploads/images/users/" . $_FILES['file_picture']['name'];
                    $params['file_picture'] = $file_picture;
                }
            } else {
                unset($params['file_picture']);
            }
        }
        $data['id'] = $id;
        // update
        if (isset($id) && $id > 0) {
            $data['users'] = $this->Users_model->get_users($id);
            if (isset($_POST) && count($_POST) > 0) {
                $this->Users_model->update_users($id, $params);
                redirect('admin/profile/index');
            } else {
                $data['_view'] = 'admin/profile/form';
                $this->load->view('layouts/admin/body', $data);
            }
        } // save
        else {
            if (isset($_POST) && count($_POST) > 0) {
                $users_id = $this->Users_model->add_users($params);
                redirect('admin/profile/index');
            } else {
                $data['users'] = $this->Users_model->get_users(0);
                $data['_view'] = 'admin/profile/form';
                $this->load->view('layouts/admin/body', $data);
            }
        }
    }
}
