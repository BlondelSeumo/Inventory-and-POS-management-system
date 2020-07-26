<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Author:  Amirul Momenin
 * Desc:Landing Page
 */
class Homecontroller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->helper(array(
            'cookie',
            'url'
        ));
        $this->load->database();
        if (! $this->session->userdata('validated')) {
            redirect('admin/login/index');
        }
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        // total customers
        $this->load->model('Customers_model');
        $data['total_customers'] = $this->Customers_model->get_count_customers();
        // total suppliers
        $this->load->model('Supplier_model');
        $data['total_supplier'] = $this->Supplier_model->get_count_supplier();
		// sum purchase
        $this->db->select_sum('total_cost');
        $result = $this->db->get('purchase')->result_array();
		$data['purchase_total_cost'] = $result[0]['total_cost'];
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }	
		// sum invoice
        $this->db->select_sum('total_cost');
        $result = $this->db->get('invoice')->result_array();
		$data['invoice_total_cost'] = $result[0]['total_cost'];
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }	

        $data['_view'] = 'admin_homepage';
        $this->load->view('layouts/admin/body', $data);
    }
}
