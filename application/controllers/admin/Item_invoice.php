<?php

/**
 * Author: Amirul Momenin
 * Desc:Item_invoice Controller
 *
 */
class Item_invoice extends CI_Controller
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
        $this->load->model('Item_invoice_model');
        if (! $this->session->userdata('validated')) {
            redirect('admin/login/index');
        }
    }

    /**
     * Index Page for this controller.
     *
     * @param $start -
     *            Starting of item_invoice table's index to get query
     *            
     */
    function index($start = 0)
    {
        $limit = 10;
        $data['item_invoice'] = $this->Item_invoice_model->get_limit_item_invoice($limit, $start);
        // pagination
        $config['base_url'] = site_url('admin/item_invoice/index');
        $config['total_rows'] = $this->Item_invoice_model->get_count_item_invoice();
        $config['per_page'] = 10;
		// Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';	
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();

        $data['_view'] = 'admin/item_invoice/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Save item_invoice
     *
     * @param $id -
     *            primary key to update
     *            
     */
    function save($id = - 1)
    {
        $params = array(
            'invoice_id' => html_escape($this->input->post('invoice_id')),
            'product_id' => html_escape($this->input->post('product_id')),
            'item_cost' => html_escape($this->input->post('item_cost')),
            'item_quantity' => html_escape($this->input->post('item_quantity')),
            'item_total' => html_escape($this->input->post('item_total'))
        );
        $data['id'] = $id;
        // update
        if (isset($id) && $id > 0) {
            $data['item_invoice'] = $this->Item_invoice_model->get_item_invoice($id);
            if (isset($_POST) && count($_POST) > 0) {
                $this->Item_invoice_model->update_item_invoice($id, $params);
                redirect('admin/item_invoice/index');
            } else {
                $data['_view'] = 'admin/item_invoice/form';
                $this->load->view('layouts/admin/body', $data);
            }
        } // save
        else {
            if (isset($_POST) && count($_POST) > 0) {
                $item_invoice_id = $this->Item_invoice_model->add_item_invoice($params);
                redirect('admin/item_invoice/index');
            } else {
                $data['item_invoice'] = $this->Item_invoice_model->get_item_invoice(0);
                $data['_view'] = 'admin/item_invoice/form';
                $this->load->view('layouts/admin/body', $data);
            }
        }
    }

    /**
     * Details item_invoice
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function details($id)
    {
        $data['item_invoice'] = $this->Item_invoice_model->get_item_invoice($id);
        $data['id'] = $id;
        $data['_view'] = 'admin/item_invoice/details';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Deleting item_invoice
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function remove($id)
    {
        $item_invoice = $this->Item_invoice_model->get_item_invoice($id);

        // check if the item_invoice exists before trying to delete it
        if (isset($item_invoice['id'])) {
            $this->Item_invoice_model->delete_item_invoice($id);
            redirect('admin/item_invoice/index');
        } else
            show_error('The item_invoice you are trying to delete does not exist.');
    }

    /**
     * Search item_invoice
     *
     * @param $start -
     *            Starting of item_invoice table's index to get query
     */
    function search($start = 0)
    {
        if (! empty($this->input->post('key'))) {
            $key = $this->input->post('key');
            $_SESSION['key'] = $key;
        } else {
            $key = $_SESSION['key'];
        }

        $limit = 10;
        $this->db->like('id', $key, 'both');
        $this->db->or_like('invoice_id', $key, 'both');
        $this->db->or_like('product_id', $key, 'both');
        $this->db->or_like('item_cost', $key, 'both');
        $this->db->or_like('item_quantity', $key, 'both');
        $this->db->or_like('item_total', $key, 'both');

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);
        $data['item_invoice'] = $this->db->get('item_invoice')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }

        // pagination
        $config['base_url'] = site_url('admin/item_invoice/search');
        $this->db->reset_query();
        $this->db->like('id', $key, 'both');
        $this->db->or_like('invoice_id', $key, 'both');
        $this->db->or_like('product_id', $key, 'both');
        $this->db->or_like('item_cost', $key, 'both');
        $this->db->or_like('item_quantity', $key, 'both');
        $this->db->or_like('item_total', $key, 'both');

        $config['total_rows'] = $this->db->from("item_invoice")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        $config['per_page'] = 10;
		// Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();

        $data['key'] = $key;
        $data['_view'] = 'admin/item_invoice/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Export item_invoice
     *
     * @param $export_type -
     *            CSV or PDF type
     */
    function export($export_type = 'CSV')
    {
        if ($export_type == 'CSV') {
            // file name
            $filename = 'item_invoice_' . date('Ymd') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            // get data
            $item_invoiceData = $this->Item_invoice_model->get_all_item_invoice();
            // file creation
            $file = fopen('php://output', 'w');
            $header = array(
                "Id",
                "Invoice Id",
                "Product Id",
                "Item Cost",
                "Item Quantity",
                "Item Total"
            );
            fputcsv($file, $header);
            foreach ($item_invoiceData as $key => $line) {
                fputcsv($file, $line);
            }
            fclose($file);
            exit();
        } else if ($export_type == 'Pdf') {
            $item_invoice = $this->db->get('item_invoice')->result_array();
            // get the HTML
            ob_start();
            include (APPPATH . 'views/admin/item_invoice/print_template.php');
            $html = ob_get_clean();
            include (APPPATH . "third_party/mpdf60/mpdf.php");
            $mpdf = new mPDF('', 'A4');
            // $mpdf=new mPDF('c','A4','','',32,25,27,25,16,13);
            // $mpdf->mirrorMargins = true;
            $mpdf->SetDisplayMode('fullpage');
            // ==============================================================
            $mpdf->autoScriptToLang = true;
            $mpdf->baseScript = 1; // Use values in classes/ucdn.php 1 = LATIN
            $mpdf->autoVietnamese = true;
            $mpdf->autoArabic = true;
            $mpdf->autoLangToFont = true;
            $mpdf->setAutoBottomMargin = 'stretch';
            $stylesheet = file_get_contents(APPPATH . "third_party/mpdf60/lang2fonts.css");
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->WriteHTML($html);
            // $mpdf->AddPage();
            $mpdf->Output($filePath);
            $mpdf->Output();
            // $mpdf->Output( $filePath,'S');
            exit();
        }
    }
}
//End of Item_invoice controller