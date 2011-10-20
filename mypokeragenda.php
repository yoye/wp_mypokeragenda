<?php
/*
Plugin Name: Mypokeragenda
Plugin URI: 
Description: Allow you to use www.mypokeragenda.com API into your blog
Version: 1.0
Author: Yoann Aparici
Author URI: http://yoann.aparici.fr
*/

require_once __DIR__.'/lib/MyPokerAgendaPlugin.php';
require_once __DIR__.'/lib/MyPokerAgendaAdmin.php';
require_once __DIR__.'/lib/MyPokerAgendaTemplate.php';
require_once __DIR__.'/lib/MyPokerAgendaParser.php';
require_once __DIR__.'/lib/MyPokerAgendaQuery.php';
require_once __DIR__.'/lib/MyPokerAgendaFormException.php';
require_once __DIR__.'/lib/vendor/twig/lib/Twig/Autoloader.php';

//// Twig init
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader, array(
  'cache' => false,
));
$twig->addFilter('trans', new Twig_Filter_Function('__'));

// Plugin init
$mpaPlugin = new MyPokerAgenda($twig);

add_action('plugins_loaded', array($mpaPlugin, 'init'));