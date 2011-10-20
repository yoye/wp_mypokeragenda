<?php

require_once(ABSPATH.'wp-admin/includes/upgrade.php');

class MyPokerAgendaQuery
{
    protected $tableName;
    
    /**
     *
     * @var wpdb
     */
    protected $wpdb;
    
    public function __construct()
    {
        global $wpdb;
        
        $this->wpdb = $wpdb;

        $this->tableName = $wpdb->prefix.'mypokeragenda';
    }
    
    /**
     * Create table for plugin
     */
    public function createTable()
    {
        $sql = "CREATE TABLE $this->tableName (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) DEFAULT '' NOT NULL,
            type VARCHAR(255) DEFAULT '' NOT NULL,
            max VARCHAR(255) DEFAULT '' NOT NULL,
            columns TEXT DEFAULT '' NOT NULL,
            remote_id VARCHAR(255) DEFAULT '' NOT NULL,
            UNIQUE KEY id (id)
        );";

        dbDelta($sql);
    }
    
    /**
     * Insert a row in plugin table
     * 
     * @param array $params
     */
    public function insertRow(array $params = array())
    {
        if (isset($params['columns']) && is_array($params['columns'])) {
            $params['columns'] = implode(',', $params['columns']);
        }
        
        return $this->wpdb->insert($this->tableName, $params);
    }
    
    /**
     * Find a row
     * 
     * @param int $id
     * @return stdClass
     */
    public function findOneById($id)
    {
        return $this->wpdb->get_row("SELECT * FROM $this->tableName WHERE id = $id");
    }
    
    /**
     * Get all rows from plugin table
     */
    public function getAll()
    {
        return $this->wpdb->get_results("SELECT * FROM $this->tableName");
    }
}