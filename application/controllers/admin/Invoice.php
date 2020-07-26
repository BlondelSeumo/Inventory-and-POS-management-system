<?php

/**
 * Author: Amirul Momenin
 * Desc:Invoice Controller
 *
 */
class Invoice extends CI_Controller
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
        $this->load->model('Invoice_model');
        if (! $this->session->userdata('validated')) {
            redirect('admin/login/index');
        }
    }

    /**
     * Index Page for this controller.
     *
     * @param $start -
     *            Starting of invoice table's index to get query
     *            
     */
    function index($start = 0)
    {
        $limit = 10;
        $data['invoice'] = $this->Invoice_model->get_limit_invoice($limit, $start);
        // pagination
        $config['base_url'] = site_url('admin/invoice/index');
        $config['total_rows'] = $this->Invoice_model->get_count_invoice();
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

        $data['_view'] = 'admin/invoice/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Save invoice
     *
     * @param $id -
     *            primary key to update
     *            
     */
    function save($id = - 1)
    {
        // products
        $this->db->reset_query();
        $this->load->model('Product_model');
        $data['product'] = $this->Product_model->get_all_product();

        // customers
        $this->db->reset_query();
        $this->load->model('Customers_model');
        $data['customers_all'] = $this->Customers_model->get_all_customers();

        // item_purchase
        $this->db->reset_query();
        $data['item_invoice'] = $this->db->get_where('item_invoice', array(
            'invoice_id' => $id
        ))->result_array();

        /**
         * **************save customer***************************
         */
        $customers_id = $this->input->post('track_customers_id');
        $params = array(
            'email' => html_escape($this->input->post('email')),
            'address' => html_escape($this->input->post('address')),
            'city' => html_escape($this->input->post('city')),
            'state' => html_escape($this->input->post('state')),
            'zip' => html_escape($this->input->post('zip')),
            'phone_no' => html_escape($this->input->post('phone_no'))
        );
        $data['id'] = $id;
        // update
        if (isset($customers_id) && $customers_id > 0) {
            if (isset($_POST) && count($_POST) > 0) {
                unset($params['customers_id']);
                $this->Customers_model->update_customers($customers_id, $params);
            }
        } // save
        else {
            $params['customer_name'] = $this->input->post('customers_id');
            if (isset($_POST) && count($_POST) > 0) {
                $customers_id = $this->Customers_model->add_customers($params);
            }
        }
        /**
         * **************End of save customer***************************
         */

        $params = array(
            'invoice_no' => $this->get_invoice_no($id),
            'customers_id' => $customers_id,
            'date_of_invoice' => $this->input->post('date_of_invoice'),
            'users_id' => $this->session->userdata['id'],
            'description' => $this->input->post('description'),
            'internal_notes' => $this->input->post('internal_notes'),
            'total_cost' => $this->input->post('total_cost'),
            'amount_paid' => $this->input->post('amount_paid')
        );
        $data['id'] = $id;
        // update
        if (isset($id) && $id > 0) {
            $data['invoice'] = $this->Invoice_model->get_invoice($id);
            // customrs
            $this->load->model('Customers_model');
            $data['customers'] = $this->Customers_model->get_customers($data['invoice']['customers_id']);
            if (isset($_POST) && count($_POST) > 0) {
                $this->Invoice_model->update_invoice($id, $params);
                // save item_invoice
                $this->save_item_invoice($id);
                redirect('admin/invoice/index');
            } else {
                $data['_view'] = 'admin/invoice/form';
                $this->load->view('layouts/admin/body', $data);
            }
        } // save
        else {
            if (isset($_POST) && count($_POST) > 0) {
                $invoice_id = $this->Invoice_model->add_invoice($params);
                // save item_invoice
                $this->save_item_invoice($invoice_id);
                redirect('admin/invoice/index');
            } else {
                $data['invoice'] = $this->Invoice_model->get_invoice(0);
                // customrs
                $this->load->model('Customers_model');
                $data['customers'] = $this->Customers_model->get_customers(0);
                $data['_view'] = 'admin/invoice/form';
                $this->load->view('layouts/admin/body', $data);
            }
        }
    }

    /**
     * item_invoice
     *
     * @param $id -
     *            invoice id to delete & save of item_invoice
     *            
     */
    function save_item_invoice($id)
    {
        // //////////save item////////////
        // delete item_invoice
        $this->db->reset_query();
        $status = $this->db->delete('item_invoice', array(
            'invoice_id' => $id
        ));
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        // save item invoice
        $this->db->reset_query();
        $this->load->model('Item_invoice_model');
        for ($i = 0; $i < count($this->input->post('product_id')); $i ++) {
            echo $this->input->post('product_id[' . $i . ']') . "<br>";
            $params = array(
                'invoice_id' => $id,
                'product_id' => $this->input->post('product_id[' . $i . ']'),
                'item_cost' => $this->input->post('item_cost[' . $i . ']'),
                'item_quantity' => $this->input->post('item_quantity[' . $i . ']'),
                'item_total' => $this->input->post('item_total[' . $i . ']')
            );
            $this->Item_invoice_model->add_item_invoice($params);
        }
    }

    /**
     * Details invoice
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function details($id)
    {
        $data['invoice'] = $this->Invoice_model->get_invoice($id);
        $data['id'] = $id;
        $data['_view'] = 'admin/invoice/details';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Deleting invoice
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function remove($id)
    {
        $invoice = $this->Invoice_model->get_invoice($id);

        // check if the purchase exists before trying to delete it
        if (isset($invoice['id'])) {
            $this->Invoice_model->delete_invoice($id);
            // delete item_purchase
            $this->db->reset_query();
            $status = $this->db->delete('item_invoice', array(
                'invoice_id' => $id
            ));
            redirect('admin/invoice/index');
        } else
            show_error('The purchase you are trying to delete does not exist.');
    }

    /**
     * Search invoice
     *
     * @param $start -
     *            Starting of invoice table's index to get query
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
        $this->db->or_like('invoice_no', $key, 'both');
        $this->db->or_like('customers_id', $key, 'both');
        $this->db->or_like('date_of_invoice', $key, 'both');
        $this->db->or_like('users_id', $key, 'both');
        $this->db->or_like('description', $key, 'both');
        $this->db->or_like('internal_notes', $key, 'both');
        $this->db->or_like('total_cost', $key, 'both');
        $this->db->or_like('amount_paid', $key, 'both');

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);
        $data['invoice'] = $this->db->get('invoice')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }

        // pagination
        $config['base_url'] = site_url('admin/invoice/search');
        $this->db->reset_query();
        $this->db->like('id', $key, 'both');
        $this->db->or_like('invoice_no', $key, 'both');
        $this->db->or_like('customers_id', $key, 'both');
        $this->db->or_like('date_of_invoice', $key, 'both');
        $this->db->or_like('users_id', $key, 'both');
        $this->db->or_like('description', $key, 'both');
        $this->db->or_like('internal_notes', $key, 'both');
        $this->db->or_like('total_cost', $key, 'both');
        $this->db->or_like('amount_paid', $key, 'both');

        $config['total_rows'] = $this->db->from("invoice")->count_all_results();
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
        $data['_view'] = 'admin/invoice/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * product json data
     *
     * @param $product_id-product id
     */
    function product($product_id)
    {
        // products
        $this->db->reset_query();
        $this->load->model('Product_model');
        $product = $this->Product_model->get_product($product_id);
        echo json_encode($product);
    }

    /**
     * customers json data
     *
     * @param $customers_id-customers id
     */
    function customer_detail($customers_id = 0)
    {
        $this->db->reset_query();
        $this->load->model('Customers_model');
        $customers = $this->Customers_model->get_customers($customers_id);
        echo json_encode($customers);
    }

    /**
     * Export invoice
     *
     * @param $export_type -
     *            CSV or PDF type
     */
    function export($export_type = 'CSV')
    {
        if ($export_type == 'CSV') {
            // file name
            $filename = 'invoice_' . date('Ymd') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            // get data
            $invoiceData = $this->Invoice_model->get_all_invoice();
            // file creation
            $file = fopen('php://output', 'w');
            $header = array(
                "Id",
                "Invoice No",
                "Customers Id",
                "Date Of Invoice",
                "Users Id",
                "Description",
                "Internal Notes",
                "Total Cost",
                "Amount Paid"
            );
            fputcsv($file, $header);
            foreach ($invoiceData as $key => $line) {
                fputcsv($file, $line);
            }
            fclose($file);
            exit();
        } else if ($export_type == 'Pdf') {
            $invoice = $this->db->get('invoice')->result_array();
            // get the HTML
            ob_start();
            include (APPPATH . 'views/admin/invoice/print_template.php');
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

    /**
     * download
     *
     * @param $id -
     *            primary key to retrive record
     *            
     */
    function download($id)
    {
        $this->db->reset_query();
        $this->load->model('Invoice_model');
        $invoice = $this->Invoice_model->get_invoice($id);

        $this->db->reset_query();
        $this->load->model('Company_model');
        $company = $this->Company_model->get_all_company();

        $this->db->reset_query();
        $this->load->model('Customers_model');
        $customers = $this->Customers_model->get_customers($invoice['customers_id']);

        // get the HTML
        ob_start();
        include (APPPATH . 'views/admin/invoice/invoice_template.php');
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

    /**
     * get_invoice_no
     *
     * @param $id -
     *            primary key to retrive record
     *            
     */
    function get_invoice_no($id = - 1)
    {
        $invoice_no = "";
        if ($id > 0) {
            $this->db->reset_query();
            $result = $this->Invoice_model->get_invoice($id);
            $invoice_no = $result['invoice_no'];
        } else {
            $this->db->reset_query();
            $this->db->select_max('id');
            $result = $this->db->get('invoice')->result_array();
            $db_error = $this->db->error();
            if (! empty($db_error['code'])) {
                echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
                exit();
            }
            $id = $result[0]['id'];
            if ($id > 0) {
                $result = $this->Invoice_model->get_invoice($id);
                $invoice_no = $result['invoice_no'];
            }
        }
        if (empty($invoice_no)) {
            return date("Ym") . "-01";
        }
        $arr = explode("-", $invoice_no);
        $no = $arr[1];

        if (is_numeric((int) $no)) {
            $no = $no + 1;
        } else {
            $no = 1;
        }
        if ($no < 10) {
            $no = "0" . $no;
        }
        $invoice_no = date("Ym") . "-" . $no;

        return $invoice_no;
    }
}
//End of Invoice controller