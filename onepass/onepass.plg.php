<?php defined('FLATBOARD') or die('Flatboard Community.');
/**
 * editor
 *
 * @author 		Simon L.
 * @copyright	(c) 2019
 * @license		http://opensource.org/licenses/MIT
 * @package		FlatBoard
 * @version		1.0
 * @update		2019-01-22
 */	  
            	
/**
 * On pré-installe les paramètres par défauts.
**/
function onepass_install() {
  $plugin = "onepass";
  if (flatDB::isValidEntry('plugin', $plugin)) {
    return;
  }
  $data[$plugin.'state'] = false;
  flatDB::saveEntry('plugin', $plugin, $data);
}
/**
 *  Admin
**/
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
/**
 *  JavaScript en pied de page
**/
function onepass_footerJS(){
  global $out;
  $plugin = 'onepass';
  $data = flatDB::readEntry('plugin', $plugin);
  if ($data[$plugin.'state'] && $out['self']=='auth'){
    return '	<script src="' .HTML_PLUGIN_DIR . $plugin . DS . 'onepass.js"></script>'.PHP_EOL;
  }
}