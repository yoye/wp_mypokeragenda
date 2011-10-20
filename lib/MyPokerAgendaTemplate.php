<?php

class MyPokerAgendaTemplate
{

    /**
     *
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * __construct
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
        add_shortcode('mypokeragenda', array($this, 'renderTag'));
    }

    /**
     * Render tag "mypokeragenda" that show table with tournaments
     * 
     * @param array $atts
     * @return string
     */
    public function renderTag($atts)
    {
        $attributes = shortcode_atts(array(
            'id' => null,
            ), $atts);

        if (!$attributes['id']) {
            return '';
        }

        $query = new MyPokerAgendaQuery();

        $row = $query->findOneById($attributes['id']);

        switch ($row->type) {
            case 'casino' :
                $url = sprintf('http://www.mypokeragenda.com/casino/tournois/wordpress/%s?limit=%s', $row->remote_id, $row->max);
                break;
            case 'room' :
                $url = sprintf('http://www.mypokeragenda.com/room-poker/tournois/wordpress/%s?limit=%s', $row->remote_id, $row->max);
                break;
            case 'serie' :
                $url = sprintf('http://www.mypokeragenda.com/serie/tournois/wordpress/%s?limit=%s', $row->remote_id, $row->max);
                break;
        }

        $html = @file_get_contents($url);

        return sprintf('<div class="mypokeragenda-wrapper">%s</div>', $html);
    }

    /**
     * Render twig template
     * 
     * @param string $name
     * @param array $context
     * @return string
     */
    public function render($name, array $context = array())
    {
        return $this->twig->render($name, $context);
    }

}