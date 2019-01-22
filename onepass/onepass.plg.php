<?php
defined('FLATBOARD') or die('Flatboard Community.');
function onepass_install() {
  $plugin = "onepass";
  if (flatDB::isValidEntry('plugin', $plugin)) {
    return;
  }
  $data[$plugin.'state'] = false;
  flatDB::saveEntry('plugin', $plugin, $data);
}

function onepass_config() {
  global $lang, $token;
  $plugin = 'onepass';
  $out = '';
  if (!empty($_POST) && CSRF::check($token)) {
    $data[$plugin.'state'] = isset($_POST['state'])? $_POST['state'] : '';
    flatDB::saveEntry('plugin', $plugin, $data);
    $out .= Plugin::redirectMsg($lang['data_save'],'config.php' . DS . 'plugin' . DS . $plugin, $lang['plugin'].'&nbsp;<b>' .$lang[$plugin.'name']. '</b>');
  } else {
    if (flatDB::isValidEntry('plugin', $plugin)) {
      $data = flatDB::readEntry('plugin', $plugin);
      $out .= HTMLForm::form('config.php'.DS.'plugin'.DS.$plugin,
      HTMLForm::checkBox('state', $data[$plugin.'state']).
      HTMLForm::simple_submit());
     }
   }
   return $out;
}

function onepass_footerJS(){
  $plugin = 'onepass';
  $data = flatDB::readEntry('plugin', $plugin);
  if ($data[$plugin.'state']&&basename($_SERVER["REQUEST_URI"], ".php")=="auth"){
    return "<script src='".HTML_PLUGIN_DIR . $plugin . DS . "onepass.js"."'></script>";
  }
}