<?php

/**
 * Author: Amirul Momenin
 * Desc:Item_purchase Model
 */
class Item_purchase_model extends CI_Model
{

    protected $item_purchase = 'item_purchase';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Get item_purchase by id
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function get_item_purchase($id)
    {
        $result = $this->db->get_where('item_purchase', array(
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
     * Get all item_purchase
     */
    function get_all_item_purchase()
    {
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('item_purchase')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get limit item_purchase
     *
     * @param $limit -
     *            limit of query , $start - start of db table index to get query
     *            
     */
    function get_limit_item_purchase($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('item_purchase')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Count item_purchase rows
     */
    function get_count_item_purchase()
    {
        $result = $this->db->from("item_purchase")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * function to add new item_purchase
     *
     * @param $params -
     *            data set to add record
     *            
     */
    function add_item_purchase($params)
    {
        $this->db->insert('item_purchase', $params);
        $id = $this->db->insert_id();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $id;
    }

    /**
     * function to update item_purchase
     *
     * @param $id -
     *            primary key to update record,$params - data set to add record
     *            
     */
    function update_item_purchase($id, $params)
    {
        $this->db->where('id', $id);
        $status = $this->db->update('item_purchase', $params);
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }

    /**
     * function to delete item_purchase
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function delete_item_purchase($id)
    {
        $status = $this->db->delete('item_purchase', array(
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
