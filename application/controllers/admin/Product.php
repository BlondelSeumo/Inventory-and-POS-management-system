<?php

/**
 * Author: Amirul Momenin
 * Desc:Product Controller
 *
 */
class Product extends CI_Controller
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
    function index($start = 0)
    {
        $limit = 10;
        $data['product'] = $this->Product_model->get_limit_product($limit, $start);
        // pagination
        $config['base_url'] = site_url('admin/product/index');
        $config['total_rows'] = $this->Product_model->get_count_product();
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

        $data['_view'] = 'admin/product/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Save product
     *
     * @param $id -
     *            primary key to update
     *            
     */
    function save($id = - 1)
    {
        $file_picture = "";

        $created_at = "";
        $updated_at = "";

        if ($id <= 0) {
            $created_at = date("Y-m-d H:i:s");
        } else if ($id > 0) {
            $updated_at = date("Y-m-d H:i:s");
        }

        $params = array(
            'users_id' => html_escape($this->session->userdata['id']),
            'product_name' => html_escape($this->input->post('product_name')),
            'category_id' => html_escape($this->input->post('category_id')),
            'sub_category_id' => html_escape($this->input->post('sub_category_id')),
            'buying_price' => html_escape($this->input->post('buying_price')),
            'selling_price' => html_escape($this->input->post('selling_price')),
            'brand' => html_escape($this->input->post('brand')),
            'specification' => html_escape($this->input->post('specification')),
            'purchaseType' => html_escape($this->input->post('purchaseType')),
            'assetType' => html_escape($this->input->post('assetType')),
            'serial_number' => html_escape($this->input->post('serial_number')),
            'barcodeNumber' => html_escape($this->input->post('barcodeNumber')),
            'description' => html_escape($this->input->post('description')),
            'weight_per_product' => html_escape($this->input->post('weight_per_product')),
            'size_per_product' =>html_escape($this->input->post('size_per_product')),
            'file_picture' => html_escape($file_picture),
            'created_at' => html_escape($created_at),
            'updated_at' => html_escape($updated_at),
            'status' => html_escape($this->input->post('status'))
        );

        $config['upload_path'] = "./public/uploads/images/product";
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
                    $file_picture = "uploads/images/product/" . $_FILES['file_picture']['name'];
                    $params['file_picture'] = $file_picture;
                }
            } else {
                unset($params['file_picture']);
            }
        }
        $data['id'] = $id;
        if ($id > 0) {
            unset($params['created_at']);
        }
        if ($id <= 0) {
            unset($params['updated_at']);
        }
        // update
        if (isset($id) && $id > 0) {
            $data['product'] = $this->Product_model->get_product($id);
            if (isset($_POST) && count($_POST) > 0) {
                $this->Product_model->update_product($id, $params);
                redirect('admin/product/index');
            } else {
                $data['_view'] = 'admin/product/form';
                $this->load->view('layouts/admin/body', $data);
            }
        } // save
        else {
            if (isset($_POST) && count($_POST) > 0) {
                $product_id = $this->Product_model->add_product($params);
                redirect('admin/product/index');
            } else {
                $data['product'] = $this->Product_model->get_product(0);
                $data['_view'] = 'admin/product/form';
                $this->load->view('layouts/admin/body', $data);
            }
        }
    }

    /**
     * Details product
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function details($id)
    {
        $data['product'] = $this->Product_model->get_product($id);
        $data['id'] = $id;
        $data['_view'] = 'admin/product/details';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Deleting product
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function remove($id)
    {
        $product = $this->Product_model->get_product($id);

        // check if the product exists before trying to delete it
        if (isset($product['id'])) {
            $this->Product_model->delete_product($id);
            redirect('admin/product/index');
        } else
            show_error('The product you are trying to delete does not exist.');
    }
	
	/**
     * get_sub_category
     *
     * @param $category_id -
     *           category_id of sub_category
     */	
	function get_sub_category($category_id)
	{
		$result = $this->db->get_where('sub_category', array('category_id' => $category_id))->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        echo json_encode($result);
	}

    /**
     * Search product
     *
     * @param $start -
     *            Starting of product table's index to get query
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
        $this->db->or_like('users_id', $key, 'both');
        $this->db->or_like('product_name', $key, 'both');
        $this->db->or_like('category_id', $key, 'both');
        $this->db->or_like('sub_category_id', $key, 'both');
        $this->db->or_like('buying_price', $key, 'both');
        $this->db->or_like('selling_price', $key, 'both');
        $this->db->or_like('brand', $key, 'both');
        $this->db->or_like('specification', $key, 'both');
        $this->db->or_like('purchaseType', $key, 'both');
        $this->db->or_like('assetType', $key, 'both');
        $this->db->or_like('serial_number', $key, 'both');
        $this->db->or_like('barcodeNumber', $key, 'both');
        $this->db->or_like('description', $key, 'both');
        $this->db->or_like('weight_per_product', $key, 'both');
        $this->db->or_like('size_per_product', $key, 'both');
        $this->db->or_like('file_picture', $key, 'both');
        $this->db->or_like('created_at', $key, 'both');
        $this->db->or_like('updated_at', $key, 'both');
        $this->db->or_like('status', $key, 'both');

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);
        $data['product'] = $this->db->get('product')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }

        // pagination
        $config['base_url'] = site_url('admin/product/search');
        $this->db->reset_query();
        $this->db->like('id', $key, 'both');
        $this->db->or_like('users_id', $key, 'both');
        $this->db->or_like('product_name', $key, 'both');
        $this->db->or_like('category_id', $key, 'both');
        $this->db->or_like('sub_category_id', $key, 'both');
        $this->db->or_like('buying_price', $key, 'both');
        $this->db->or_like('selling_price', $key, 'both');
        $this->db->or_like('brand', $key, 'both');
        $this->db->or_like('specification', $key, 'both');
        $this->db->or_like('purchaseType', $key, 'both');
        $this->db->or_like('assetType', $key, 'both');
        $this->db->or_like('serial_number', $key, 'both');
        $this->db->or_like('barcodeNumber', $key, 'both');
        $this->db->or_like('description', $key, 'both');
        $this->db->or_like('weight_per_product', $key, 'both');
        $this->db->or_like('size_per_product', $key, 'both');
        $this->db->or_like('file_picture', $key, 'both');
        $this->db->or_like('created_at', $key, 'both');
        $this->db->or_like('updated_at', $key, 'both');
        $this->db->or_like('status', $key, 'both');

        $config['total_rows'] = $this->db->from("product")->count_all_results();
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
        $data['_view'] = 'admin/product/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Export product
     *
     * @param $export_type -
     *            CSV or PDF type
     */
    function export($export_type = 'CSV')
    {
        if ($export_type == 'CSV') {
            // file name
            $filename = 'product_' . date('Ymd') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            // get data
            $productData = $this->Product_model->get_all_product();
            // file creation
            $file = fopen('php://output', 'w');
            $header = array(
                "Id",
                "Users Id",
                "Product Name",
                "Category Id",
                "Sub Category Id",
                "Buying Price",
                "Selling Price",
                "Brand",
                "Specification",
                "PurchaseType",
                "AssetType",
                "Serial Number",
                "BarcodeNumber",
                "Description",
                "Weight Per Product",
                "Size Per Product",
                "File Picture",
                "Created At",
                "Updated At",
                "Status"
            );
            fputcsv($file, $header);
            foreach ($productData as $key => $line) {
                fputcsv($file, $line);
            }
            fclose($file);
            exit();
        } else if ($export_type == 'Pdf') {
            $product = $this->db->get('product')->result_array();
            // get the HTML
            ob_start();
            include (APPPATH . 'views/admin/product/print_template.php');
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
//End of Product controller