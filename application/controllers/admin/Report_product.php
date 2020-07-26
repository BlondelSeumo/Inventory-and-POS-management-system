<?php

/**
 * Author: Amirul Momenin
 * Desc:Report_product Controller
 *
 */
class Report_product extends CI_Controller
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
        $this->load->model('Product_model');
        if (! $this->session->userdata('validated')) {
            redirect('admin/login/index');
        }
    }

    /**
     * Index Page for this controller.
     *
     * @param $start -
     *            Starting of product table's index to get query
     *            
     */
    function index()
    {
        $data['product'] = $this->Product_model->get_product(0);
        $data['_view'] = 'admin/report/product/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * get_sub_category
     *
     * @param $category_id -
     *            category_id of sub_category
     */
    function get_sub_category($category_id)
    {
        $result = $this->db->get_where('sub_category', array(
            'category_id' => $category_id
        ))->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        echo json_encode($result);
    }

    /**
     * get_product
     *
     * @param $category_id -
     *            id of sub_category
     * @param $sub_category_id -
     *            id of sub_category_id
     */
    function get_product($category_id, $sub_category_id)
    {
        $this->db->where('category_id', $category_id);
        $this->db->where('sub_category_id', $sub_category_id);
        $result = $this->db->get('product')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        echo json_encode($result);
    }

    /**
     * report product
     *
     * @param $start -
     *            Starting of product table's index to get query
     */
    function report($start = 0)
    {
        $data['product'] = $this->Product_model->get_product(0);

        // ////************purchase****************///////
        // purchase item_quantity
        $this->load->database();
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $this->db->where("purchase.date_of_purchase BETWEEN '" . $this->input->post('date_from') . "' AND '" . $this->input->post('date_to') . "'");
        }
        $this->db->where('product_id', $this->input->post('product_id'));
        $this->db->select_sum('item_quantity');
        $this->db->from('item_purchase');
        $this->db->join('purchase', 'item_purchase.purchase_id = purchase.id');
        $res = $this->db->get()->result_array();
        $data['purchase_item_quantity'] = $res[0]['item_quantity'];
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        // purchase item_total
        $this->load->database();
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $this->db->where("purchase.date_of_purchase BETWEEN '" . $this->input->post('date_from') . "' AND '" . $this->input->post('date_to') . "'");
        }
        $this->db->where('product_id', $this->input->post('product_id'));
        $this->db->select_sum('item_total');
        $this->db->from('item_purchase');
        $this->db->join('purchase', 'item_purchase.purchase_id = purchase.id');
        $res = $this->db->get()->result_array();
        $data['purchase_item_total'] = $res[0]['item_total'];
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        // ////************invoice****************///////
        // invoice item_quantity
        $this->load->database();
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $this->db->where("date_of_invoice BETWEEN '" . $this->input->post('date_from') . "' AND '" . $this->input->post('date_to') . "'");
        }
        $this->db->where('product_id', $this->input->post('product_id'));
        $this->db->select_sum('item_quantity');
        $this->db->from('item_invoice');
        $this->db->join('invoice', 'item_invoice.invoice_id = invoice.id');
        $res = $this->db->get()->result_array();
        $data['invoice_item_quantity'] = $res[0]['item_quantity'];
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        // invoice item_total
        $this->load->database();
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $this->db->where("date_of_invoice BETWEEN '" . $this->input->post('date_from') . "' AND '" . $this->input->post('date_to') . "'");
        }
        $this->db->where('product_id', $this->input->post('product_id'));
        $this->db->select_sum('item_total');
        $this->db->from('item_invoice');
        $this->db->join('invoice', 'item_invoice.invoice_id = invoice.id');
        $res = $this->db->get()->result_array();
        $data['invoice_item_total'] = $res[0]['item_total'];
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }

        // $data['key'] = $key;
        $data['_view'] = 'admin/report/product/index';
        $this->load->view('layouts/admin/body', $data);
    }
}
//End of Report_product controller