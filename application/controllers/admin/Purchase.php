<?php

/**
 * Author: Amirul Momenin
 * Desc:Purchase Controller
 *
 */
class Purchase extends CI_Controller
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
        $this->load->model('Purchase_model');
        if (! $this->session->userdata('validated')) {
            redirect('admin/login/index');
        }
    }

    /**
     * Index Page for this controller.
     *
     * @param $start -
     *            Starting of purchase table's index to get query
     *            
     */
    function index($start = 0)
    {
        $limit = 10;
        $data['purchase'] = $this->Purchase_model->get_limit_purchase($limit, $start);
        // pagination
        $config['base_url'] = site_url('admin/purchase/index');
        $config['total_rows'] = $this->Purchase_model->get_count_purchase();
        $config['per_page'] = 10;
        // Bootstrap 4 Pagination fix
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
        $config['next_tag_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();

        $data['_view'] = 'admin/purchase/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Save purchase
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

        // supplier
        $this->db->reset_query();
        $this->load->model('Supplier_model');
        $data['supplier_all'] = $this->Supplier_model->get_all_supplier();

        // item_purchase
        $this->db->reset_query();
        $data['item_purchase'] = $this->db->get_where('item_purchase', array(
            'purchase_id' => $id
        ))->result_array();
        /**
         * **************save supplier***************************
         */
        $supplier_id = $this->input->post('track_supplier_id');
        $params = array(
            'supplier_name' => $this->input->post('supplier_name'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'city' => $this->input->post('city'),
            'state' => $this->input->post('state'),
            'zip' => $this->input->post('zip'),
            'phone_no' => $this->input->post('phone_no')
        );

        // update
        if (isset($supplier_id) && $supplier_id > 0) {
            if (isset($_POST) && count($_POST) > 0) {
                unset($params['supplier_id']);
                $this->Supplier_model->update_supplier($supplier_id, $params);
            }
        } // save
        else {
            $params['company'] = $this->input->post('supplier_id');
            if (isset($_POST) && count($_POST) > 0) {
                $supplier_id = $this->Supplier_model->add_supplier($params);
            }
        }
        /**
         * **************End of save customer***************************
         */

        $params = array(
            'purchase_no' => html_escape($this->get_purchase_no($id)),
            'supplier_id' => html_escape($supplier_id),
            'date_of_purchase' => html_escape($this->input->post('date_of_purchase')),
            'users_id' => html_escape($this->session->userdata['id']),
            'description' => html_escape($this->input->post('description')),
            'internal_notes' => html_escape($this->input->post('internal_notes')),
            'total_cost' => html_escape($this->input->post('total_cost')),
            'amount_paid' => html_escape($this->input->post('amount_paid'))
        );

        $data['id'] = $id;
        // update
        if (isset($id) && $id > 0) {
            $data['purchase'] = $this->Purchase_model->get_purchase($id);
            // supplier
            $this->load->model('Supplier_model');
            $data['supplier'] = $this->Supplier_model->get_supplier($data['purchase']['supplier_id']);
            if (isset($_POST) && count($_POST) > 0) {
                $this->Purchase_model->update_purchase($id, $params);
                // save item_purchase
                $this->save_item_purchase($id);
                redirect('admin/purchase/index');
            } else {
                $data['_view'] = 'admin/purchase/form';
                $this->load->view('layouts/admin/body', $data);
            }
        } // save
        else {
            if (isset($_POST) && count($_POST) > 0) {
                $id = $this->Purchase_model->add_purchase($params);
                // save item_purchase
                $this->save_item_purchase($id);
                redirect('admin/purchase/index');
            } else {
                $data['purchase'] = $this->Purchase_model->get_purchase(0);
                // supplier
                $this->load->model('Supplier_model');
                $data['supplier'] = $this->Supplier_model->get_supplier(0);
                $data['_view'] = 'admin/purchase/form';
                $this->load->view('layouts/admin/body', $data);
            }
        }
    }

    /**
     * item_purchase
     *
     * @param $id -
     *            purchase id to delete & save of item_purchase
     *            
     */
    function save_item_purchase($id)
    {
        // //////////save item////////////
        // delete item_purchase
        $this->db->reset_query();
        $status = $this->db->delete('item_purchase', array(
            'purchase_id' => $id
        ));
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        // save item purchase
        $this->db->reset_query();
        $this->load->model('Item_purchase_model');
        for ($i = 0; $i < count($this->input->post('product_id')); $i ++) {
            echo $this->input->post('product_id[' . $i . ']') . "<br>";
            $params = array(
                'purchase_id' => $id,
                'product_id' => $this->input->post('product_id[' . $i . ']'),
                'item_cost' => $this->input->post('item_cost[' . $i . ']'),
                'item_quantity' => $this->input->post('item_quantity[' . $i . ']'),
                'item_total' => $this->input->post('item_total[' . $i . ']')
            );
            $this->Item_purchase_model->add_item_purchase($params);
        }
    }

    /**
     * Details purchase
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function details($id)
    {
        $data['purchase'] = $this->Purchase_model->get_purchase($id);
        $data['id'] = $id;
        $data['_view'] = 'admin/purchase/details';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Deleting purchase
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function remove($id)
    {
        $purchase = $this->Purchase_model->get_purchase($id);

        // check if the purchase exists before trying to delete it
        if (isset($purchase['id'])) {
            $this->Purchase_model->delete_purchase($id);
            // delete item_purchase
            $this->db->reset_query();
            $status = $this->db->delete('item_purchase', array(
                'purchase_id' => $id
            ));
            redirect('admin/purchase/index');
        } else
            show_error('The purchase you are trying to delete does not exist.');
    }

    /**
     * Search purchase
     *
     * @param $start -
     *            Starting of purchase table's index to get query
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
        $this->db->or_like('purchase_no', $key, 'both');
        $this->db->or_like('supplier_id', $key, 'both');
        $this->db->or_like('date_of_purchase', $key, 'both');
        $this->db->or_like('users_id', $key, 'both');
        $this->db->or_like('description', $key, 'both');
        $this->db->or_like('internal_notes', $key, 'both');
        $this->db->or_like('total_cost', $key, 'both');
        $this->db->or_like('amount_paid', $key, 'both');

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);
        $data['purchase'] = $this->db->get('purchase')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }

        // pagination
        $config['base_url'] = site_url('admin/purchase/search');
        $this->db->reset_query();
        $this->db->like('id', $key, 'both');
        $this->db->or_like('purchase_no', $key, 'both');
        $this->db->or_like('supplier_id', $key, 'both');
        $this->db->or_like('date_of_purchase', $key, 'both');
        $this->db->or_like('users_id', $key, 'both');
        $this->db->or_like('description', $key, 'both');
        $this->db->or_like('internal_notes', $key, 'both');
        $this->db->or_like('total_cost', $key, 'both');
        $this->db->or_like('amount_paid', $key, 'both');

        $config['total_rows'] = $this->db->from("purchase")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        $config['per_page'] = 10;
        // Bootstrap 4 Pagination fix
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
        $config['next_tag_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();

        $data['key'] = $key;
        $data['_view'] = 'admin/purchase/index';
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
     * supplier json data
     *
     * @param $supplier_id-supplier id
     */
    function supplier_detail($supplier_id = 0)
    {
        $this->db->reset_query();
        $this->load->model('Supplier_model');
        $supplier = $this->Supplier_model->get_supplier($supplier_id);
        echo json_encode($supplier);
    }

    /**
     * Export purchase
     *
     * @param $export_type -
     *            CSV or PDF type
     */
    function export($export_type = 'CSV')
    {
        if ($export_type == 'CSV') {
            // file name
            $filename = 'purchase_' . date('Ymd') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            // get data
            $purchaseData = $this->Purchase_model->get_all_purchase();
            // file creation
            $file = fopen('php://output', 'w');
            $header = array(
                "Id",
                "Purchase No",
                "Supplier Id",
                "Date Of Purchase",
                "Users Id",
                "Description",
                "Internal Notes",
                "Total Cost",
                "Amount Paid"
            );
            fputcsv($file, $header);
            foreach ($purchaseData as $key => $line) {
                fputcsv($file, $line);
            }
            fclose($file);
            exit();
        } else if ($export_type == 'Pdf') {
            $purchase = $this->db->get('purchase')->result_array();
            // get the HTML
            ob_start();
            include (APPPATH . 'views/admin/purchase/print_template.php');
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
        $this->load->model('Purchase_model');
        $purchase = $this->Purchase_model->get_purchase($id);

        $this->db->reset_query();
        $this->load->model('Company_model');
        $company = $this->Company_model->get_all_company();

        $this->db->reset_query();
        $this->load->model('Supplier_model');
        $supplier = $this->Supplier_model->get_supplier($purchase['supplier_id']);

        // get the HTML
        ob_start();
        include (APPPATH . 'views/admin/purchase/purchase_template.php');
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
     * get_purchase_no
     *
     * @param $id -
     *            primary key to retrive record
     *            
     */
    function get_purchase_no($id = - 1)
    {
        $purchase_no = "";
        if ($id > 0) {
            $this->db->reset_query();
            $result = $this->Purchase_model->get_purchase($id);
            $purchase_no = $result['purchase_no'];
        } else {
            $this->db->reset_query();
            $this->db->select_max('id');
            $result = $this->db->get('purchase')->result_array();
            $db_error = $this->db->error();
            if (! empty($db_error['code'])) {
                echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
                exit();
            }
            $id = $result[0]['id'];
            if ($id > 0) {
                $result = $this->Purchase_model->get_purchase($id);
                $purchase_no = $result['purchase_no'];
            }
        }
        if (empty($purchase_no)) {
            return date("Ym") . "-01";
        }
        $arr = explode("-", $purchase_no);
        $no = $arr[1];

        if (is_numeric((int) $no)) {
            $no = $no + 1;
        } else {
            $no = 1;
        }
        if ($no < 10) {
            $no = "0" . $no;
        }
        $purchase_no = date("Ym") . "-" . $no;

        return $purchase_no;
    }
}
//End of Purchase controller