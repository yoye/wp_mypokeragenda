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

// Plugin init
$mpaPlugin = new MyPokerAgenda();

add_action('plugins_loaded', array($mpaPlugin, 'init'));