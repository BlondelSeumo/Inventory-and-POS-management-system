<?php

/**
 * Author: Amirul Momenin
 * Desc:Invoice Model
 */
class Invoice_model extends CI_Model
{

    protected $invoice = 'invoice';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Get invoice by id
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function get_invoice($id)
    {
        $result = $this->db->get_where('invoice', array(
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
     * Get all invoice
     */
    function get_all_invoice()
    {
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('invoice')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get limit invoice
     *
     * @param $limit -
     *            limit of query , $start - start of db table index to get query
     *            
     */
    function get_limit_invoice($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('invoice')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Count invoice rows
     */
    function get_count_invoice()
    {
        $result = $this->db->from("invoice")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * function to add new invoice
     *
     * @param $params -
     *            data set to add record
     *            
     */
    function add_invoice($params)
    {
        $this->db->insert('invoice', $params);
        $id = $this->db->insert_id();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $id;
    }

    /**
     * function to update invoice
     *
     * @param $id -
     *            primary key to update record,$params - data set to add record
     *            
     */
    function update_invoice($id, $params)
    {
        $this->db->where('id', $id);
        $status = $this->db->update('invoice', $params);
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }

    /**
     * function to delete invoice
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function delete_invoice($id)
    {
        $status = $this->db->delete('invoice', array(
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
