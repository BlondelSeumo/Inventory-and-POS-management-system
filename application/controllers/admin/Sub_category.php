<?php

/**
 * Author: Amirul Momenin
 * Desc:Sub_category Controller
 *
 */
class Sub_category extends CI_Controller
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
        $this->load->model('Sub_category_model');
        if (! $this->session->userdata('validated')) {
            redirect('admin/login/index');
        }
    }

    /**
     * Index Page for this controller.
     *
     * @param $start -
     *            Starting of sub_category table's index to get query
     *            
     */
    function index($start = 0)
    {
        $limit = 10;
        $data['sub_category'] = $this->Sub_category_model->get_limit_sub_category($limit, $start);
        // pagination
        $config['base_url'] = site_url('admin/sub_category/index');
        $config['total_rows'] = $this->Sub_category_model->get_count_sub_category();
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

        $data['_view'] = 'admin/sub_category/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Save sub_category
     *
     * @param $id -
     *            primary key to update
     *            
     */
    function save($id = - 1)
    {
        $created_at = "";
        $updated_at = "";

        if ($id <= 0) {
            $created_at = date("Y-m-d H:i:s");
        } else if ($id > 0) {
            $updated_at = date("Y-m-d H:i:s");
        }

        $params = array(
            'category_id' => html_escape($this->input->post('category_id')),
            'name' => html_escape($this->input->post('name')),
            'description' => html_escape($this->input->post('description')),
            'status' => html_escape($this->input->post('status')),
            'created_at' => html_escape($created_at),
            'updated_at' => html_escape($updated_at)
        );

        if ($id > 0) {
            unset($params['created_at']);
        }
        if ($id <= 0) {
            unset($params['updated_at']);
        }
        $data['id'] = $id;
        // update
        if (isset($id) && $id > 0) {
            $data['sub_category'] = $this->Sub_category_model->get_sub_category($id);
            if (isset($_POST) && count($_POST) > 0) {
                $this->Sub_category_model->update_sub_category($id, $params);
                redirect('admin/sub_category/index');
            } else {
                $data['_view'] = 'admin/sub_category/form';
                $this->load->view('layouts/admin/body', $data);
            }
        } // save
        else {
            if (isset($_POST) && count($_POST) > 0) {
                $sub_category_id = $this->Sub_category_model->add_sub_category($params);
                redirect('admin/sub_category/index');
            } else {
                $data['sub_category'] = $this->Sub_category_model->get_sub_category(0);
                $data['_view'] = 'admin/sub_category/form';
                $this->load->view('layouts/admin/body', $data);
            }
        }
    }

    /**
     * Details sub_category
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function details($id)
    {
        $data['sub_category'] = $this->Sub_category_model->get_sub_category($id);
        $data['id'] = $id;
        $data['_view'] = 'admin/sub_category/details';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Deleting sub_category
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function remove($id)
    {
        $sub_category = $this->Sub_category_model->get_sub_category($id);

        // check if the sub_category exists before trying to delete it
        if (isset($sub_category['id'])) {
            $this->Sub_category_model->delete_sub_category($id);
            redirect('admin/sub_category/index');
        } else
            show_error('The sub_category you are trying to delete does not exist.');
    }

    /**
     * Search sub_category
     *
     * @param $start -
     *            Starting of sub_category table's index to get query
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
        $this->db->or_like('category_id', $key, 'both');
        $this->db->or_like('name', $key, 'both');
        $this->db->or_like('description', $key, 'both');
        $this->db->or_like('status', $key, 'both');
        $this->db->or_like('created_at', $key, 'both');
        $this->db->or_like('updated_at', $key, 'both');

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);
        $data['sub_category'] = $this->db->get('sub_category')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }

        // pagination
        $config['base_url'] = site_url('admin/sub_category/search');
        $this->db->reset_query();
        $this->db->like('id', $key, 'both');
        $this->db->or_like('category_id', $key, 'both');
        $this->db->or_like('name', $key, 'both');
        $this->db->or_like('description', $key, 'both');
        $this->db->or_like('status', $key, 'both');
        $this->db->or_like('created_at', $key, 'both');
        $this->db->or_like('updated_at', $key, 'both');

        $config['total_rows'] = $this->db->from("sub_category")->count_all_results();
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
        $data['_view'] = 'admin/sub_category/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Export sub_category
     *
     * @param $export_type -
     *            CSV or PDF type
     */
    function export($export_type = 'CSV')
    {
        if ($export_type == 'CSV') {
            // file name
            $filename = 'sub_category_' . date('Ymd') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            // get data
            $sub_categoryData = $this->Sub_category_model->get_all_sub_category();
            // file creation
            $file = fopen('php://output', 'w');
            $header = array(
                "Id",
                "Category Id",
                "Name",
                "Description",
                "Status",
                "Created At",
                "Updated At"
            );
            fputcsv($file, $header);
            foreach ($sub_categoryData as $key => $line) {
                fputcsv($file, $line);
            }
            fclose($file);
            exit();
        } else if ($export_type == 'Pdf') {
            $sub_category = $this->db->get('sub_category')->result_array();
            // get the HTML
            ob_start();
            include (APPPATH . 'views/admin/sub_category/print_template.php');
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
//End of Sub_category controller