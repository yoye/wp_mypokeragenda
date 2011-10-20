<?php

class MyPokerAgenda
{
    /**
     * __construct
     */
    public function __construct()
    {
        if (!get_option('mypokeragenda_install', false)) {
            $this->install();
        }
    }

    /**
     * Init
     */
    public function init()
    {
        $template = new MyPokerAgendaTemplate($this->twig);
        $admin = new MyPokerAgendaAdmin($template);
    }

    /**
     * Install plugin: create table
     */
    private function install()
    {
        $query = new MyPokerAgendaQuery();
        $query->createTable();

        update_option('mypokeragenda_install', true);
    }

}