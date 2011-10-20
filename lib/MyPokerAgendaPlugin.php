<?php

class MyPokerAgenda
{

    protected $twig;

    /**
     * __construct
     */
    public function __construct($twig)
    {
        $this->twig = $twig;
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