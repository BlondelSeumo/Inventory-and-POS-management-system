<?php

/**
 * Author: Amirul Momenin
 * Desc:Product Model
 */
class Product_model extends CI_Model
{

    protected $product = 'product';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Get product by id
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function get_product($id)
    {
        $result = $this->db->get_where('product', array(
            'id' => $id
        ))->row_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get all product
     */
    function get_all_product()
    {
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('product')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get limit product
     *
     * @param $limit -
     *            limit of query , $start - start of db table index to get query
     *            
     */
    function get_limit_product($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('product')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Count product rows
     */
    function get_count_product()
    {
        $result = $this->db->from("product")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * function to add new product
     *
     * @param $params -
     *            data set to add record
     *            
     */
    function add_product($params)
    {
        $this->db->insert('product', $params);
        $id = $this->db->insert_id();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $id;
    }

    /**
     * function to update product
     *
     * @param $id -
     *            primary key to update record,$params - data set to add record
     *            
     */
    function update_product($id, $params)
    {
        $this->db->where('id', $id);
        $status = $this->db->update('product', $params);
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }

    /**
     * function to delete product
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function delete_product($id)
    {
        $status = $this->db->delete('product', array(
            'id' => $id
        ));
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }
}
