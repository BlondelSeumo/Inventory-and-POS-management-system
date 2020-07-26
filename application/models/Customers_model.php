<?php

/**
 * Author: Amirul Momenin
 * Desc:Customers Model
 */
class Customers_model extends CI_Model
{

    protected $customers = 'customers';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Get customers by id
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function get_customers($id)
    {
        $result = $this->db->get_where('customers', array(
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
     * Get all customers
     */
    function get_all_customers()
    {
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('customers')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get limit customers
     *
     * @param $limit -
     *            limit of query , $start - start of db table index to get query
     *            
     */
    function get_limit_customers($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('customers')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Count customers rows
     */
    function get_count_customers()
    {
        $result = $this->db->from("customers")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * function to add new customers
     *
     * @param $params -
     *            data set to add record
     *            
     */
    function add_customers($params)
    {
        $this->db->insert('customers', $params);
        $id = $this->db->insert_id();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $id;
    }

    /**
     * function to update customers
     *
     * @param $id -
     *            primary key to update record,$params - data set to add record
     *            
     */
    function update_customers($id, $params)
    {
        $this->db->where('id', $id);
        $status = $this->db->update('customers', $params);
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }

    /**
     * function to delete customers
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function delete_customers($id)
    {
        $status = $this->db->delete('customers', array(
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
