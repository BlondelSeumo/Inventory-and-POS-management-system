<?php

/**
 * Author: Amirul Momenin
 * Desc:Supplier Controller
 *
 */
class Supplier extends CI_Controller
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
        $this->load->model('Supplier_model');
        if (! $this->session->userdata('validated')) {
            redirect('admin/login/index');
        }
    }

    /**
     * Index Page for this controller.
     *
     * @param $start -
     *            Starting of supplier table's index to get query
     *            
     */
    function index($start = 0)
    {
        $limit = 10;
        $data['supplier'] = $this->Supplier_model->get_limit_supplier($limit, $start);
        // pagination
        $config['base_url'] = site_url('admin/supplier/index');
        $config['total_rows'] = $this->Supplier_model->get_count_supplier();
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

        $data['_view'] = 'admin/supplier/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Save supplier
     *
     * @param $id -
     *            primary key to update
     *            
     */
    function save($id = - 1)
    {
        $params = array(
            'company' => html_escape($this->input->post('company')),
            'supplier_name' => html_escape($this->input->post('supplier_name')),
            'email' => html_escape($this->input->post('email')),
            'address' => html_escape($this->input->post('address')),
            'city' => html_escape($this->input->post('city')),
            'state' => html_escape($this->input->post('state')),
            'zip' => html_escape($this->input->post('zip')),
            'phone_no' => html_escape($this->input->post('phone_no'))
        );
        $data['id'] = $id;
        // update
        if (isset($id) && $id > 0) {
            $data['supplier'] = $this->Supplier_model->get_supplier($id);
            if (isset($_POST) && count($_POST) > 0) {
                $this->Supplier_model->update_supplier($id, $params);
                redirect('admin/supplier/index');
            } else {
                $data['_view'] = 'admin/supplier/form';
                $this->load->view('layouts/admin/body', $data);
            }
        } // save
        else {
            if (isset($_POST) && count($_POST) > 0) {
                $supplier_id = $this->Supplier_model->add_supplier($params);
                redirect('admin/supplier/index');
            } else {
                $data['supplier'] = $this->Supplier_model->get_supplier(0);
                $data['_view'] = 'admin/supplier/form';
                $this->load->view('layouts/admin/body', $data);
            }
        }
    }

    /**
     * Details supplier
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function details($id)
    {
        $data['supplier'] = $this->Supplier_model->get_supplier($id);
        $data['id'] = $id;
        $data['_view'] = 'admin/supplier/details';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Deleting supplier
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function remove($id)
    {
        $supplier = $this->Supplier_model->get_supplier($id);

        // check if the supplier exists before trying to delete it
        if (isset($supplier['id'])) {
            $this->Supplier_model->delete_supplier($id);
            redirect('admin/supplier/index');
        } else
            show_error('The supplier you are trying to delete does not exist.');
    }

    /**
     * Search supplier
     *
     * @param $start -
     *            Starting of supplier table's index to get query
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
        $this->db->or_like('company', $key, 'both');
        $this->db->or_like('supplier_name', $key, 'both');
        $this->db->or_like('email', $key, 'both');
        $this->db->or_like('address', $key, 'both');
        $this->db->or_like('city', $key, 'both');
        $this->db->or_like('state', $key, 'both');
        $this->db->or_like('zip', $key, 'both');
        $this->db->or_like('phone_no', $key, 'both');

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);
        $data['supplier'] = $this->db->get('supplier')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }

        // pagination
        $config['base_url'] = site_url('admin/supplier/search');
        $this->db->reset_query();
        $this->db->like('id', $key, 'both');
        $this->db->or_like('company', $key, 'both');
        $this->db->or_like('supplier_name', $key, 'both');
        $this->db->or_like('email', $key, 'both');
        $this->db->or_like('address', $key, 'both');
        $this->db->or_like('city', $key, 'both');
        $this->db->or_like('state', $key, 'both');
        $this->db->or_like('zip', $key, 'both');
        $this->db->or_like('phone_no', $key, 'both');

        $config['total_rows'] = $this->db->from("supplier")->count_all_results();
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
        $data['_view'] = 'admin/supplier/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Export supplier
     *
     * @param $export_type -
     *            CSV or PDF type
     */
    function export($export_type = 'CSV')
    {
        if ($export_type == 'CSV') {
            // file name
            $filename = 'supplier_' . date('Ymd') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            // get data
            $supplierData = $this->Supplier_model->get_all_supplier();
            // file creation
            $file = fopen('php://output', 'w');
            $header = array(
                "Id",
                "Company",
                "Supplier Name",
                "Email",
                "Address",
                "City",
                "State",
                "Zip",
                "Phone No"
            );
            fputcsv($file, $header);
            foreach ($supplierData as $key => $line) {
                fputcsv($file, $line);
            }
            fclose($file);
            exit();
        } else if ($export_type == 'Pdf') {
            $supplier = $this->db->get('supplier')->result_array();
            // get the HTML
            ob_start();
            include (APPPATH . 'views/admin/supplier/print_template.php');
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
//End of Supplier controller