<?php

class MyPokerAgendaAdmin
{

    protected $template;
    protected $slug;

    public function __construct(MyPokerAgendaTemplate $template)
    {
        $this->template = $template;
        $this->slug = 'my-poker-agenda/lib/Admin.class.php';

        add_action('admin_menu', array($this, 'renderMenu'));
        add_action('admin_print_styles', array($this, 'loadStyle'));
        add_action('admin_print_scripts', array($this, 'loadScript'));
    }

    /**
     * Load admin page scripts
     */
    public function loadScript()
    {
        wp_enqueue_script('suggest');
        wp_enqueue_script('ui-autocomplete', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js', array('jquery'), false, true);
    }

    /**
     * Load admin page styles
     */
    public function loadStyle()
    {
        wp_enqueue_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css');
    }

    /**
     * Return menu
     * 
     * @return string
     */
    public function renderMenu()
    {
        add_options_page('My Poker Agenda', 'Mypokeragenda', 'manage_options', $this->slug, array($this, 'renderPage'));
    }

    /**
     * Render Admin Page
     */
    public function renderPage()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        $query = new MyPokerAgendaQuery();
        $rows = $query->getAll();

        if (isset($_POST['agenda'])) {
            try {
                $post = $this->cleanPost($_POST['agenda']);
                $results = $query->insertRow($post);

                // Redirect if insert is effective
                if ($results) {
                    wp_redirect(get_option('siteurl').'/wp-admin/options-general.php?page='.$this->slug);
                    exit();
                }
            } catch (MyPokerAgendaFormException $e) {
                require_once(ABSPATH . 'wp-admin/admin-header.php');
            }
        }
        
        $parser = new MyPokerAgendaParser();
        $action = get_option('siteurl').'/wp-admin/options-general.php?page='.$this->slug.'&noheader=true';
        
        include __DIR__.'/../templates/admin.php';
    }

    /**
     * 
     * 
     * @param array $post 
     */
    protected function cleanPost(array $post)
    {
        $errors = array();
        
        // Selection error
        if (!isset($post['remote_id']) || $post['remote_id'] === '') {
            $post['remote_id'] = '';
            $errors['name'] = 'required';
        }

        if (!isset($post['type']) || $post['type'] === '') {
            $post['type'] = '';
            $errors['name'] = 'required';
        }

        if (!isset($post['max']) || $post['max'] === '' || !is_numeric($post['max'])) {
            $post['max'] = 10;
        }

        // Description 
        if (!isset($post['name']) || $post['name'] === '') {
            $post['name'] = sprintf('%s - max: %s', isset($post['search']) ? $post['search'] : '', $post['max']);
        }
        
        // Columns
        if (isset($post['columns'])) {
            if (!is_array($post['columns'])) {
                $errors['columns'] = 'invalid';
            } else {
                foreach ($post['columns'] as $value) {
                    if (!in_array($value, array('logo', 'date', 'label', 'buyin', 'detail'))) {
                        $errors['columns'] = 'invalid';
                    }
                }
            }
        }
        
        if (!empty($errors)) {
            $e = new MyPokerAgendaFormException();
            $e->setErrors($errors);

            throw $e;
        }
        
        foreach ($post as $key => $value) {
            if (!in_array($key, array('name', 'type', 'max', 'remote_id', 'columns'))) {
                unset($post[$key]);
            }
        }

        return $post;
    }

}