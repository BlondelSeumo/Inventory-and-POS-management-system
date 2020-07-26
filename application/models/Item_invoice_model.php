<?php

/**
 * Author: Amirul Momenin
 * Desc:Item_invoice Model
 */
class Item_invoice_model extends CI_Model
{

    protected $item_invoice = 'item_invoice';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Get item_invoice by id
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function get_item_invoice($id)
    {
        $result = $this->db->get_where('item_invoice', array(
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
     * Get all item_invoice
     */
    function get_all_item_invoice()
    {
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('item_invoice')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get limit item_invoice
     *
     * @param $limit -
     *            limit of query , $start - start of db table index to get query
     *            
     */
    function get_limit_item_invoice($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('item_invoice')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Count item_invoice rows
     */
    function get_count_item_invoice()
    {
        $result = $this->db->from("item_invoice")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * function to add new item_invoice
     *
     * @param $params -
     *            data set to add record
     *            
     */
    function add_item_invoice($params)
    {
        $this->db->insert('item_invoice', $params);
        $id = $this->db->insert_id();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $id;
    }

    /**
     * function to update item_invoice
     *
     * @param $id -
     *            primary key to update record,$params - data set to add record
     *            
     */
    function update_item_invoice($id, $params)
    {
        $this->db->where('id', $id);
        $status = $this->db->update('item_invoice', $params);
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }

    /**
     * function to delete item_invoice
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function delete_item_invoice($id)
    {
        $status = $this->db->delete('item_invoice', array(
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
