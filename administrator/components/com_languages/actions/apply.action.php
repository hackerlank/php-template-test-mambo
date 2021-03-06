<?php
/**
* @package Mambo
* @subpackage Languages
* @author Mambo Foundation Inc see README.php
* @copyright Mambo Foundation Inc.
* See COPYRIGHT.php for copyright notices and details.
* @license GNU/GPL Version 2, see LICENSE.php
* Mambo is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; version 2 of the License.
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
class applyAction extends Action
{
    function execute(&$controller, &$request)
    {
        
        $domain     = $_POST['domain'];
        $textdomain = $_POST['textdomain'];
        $lang       = $_POST['lang'];

        
        $catalog = new PHPGettext_catalog($domain, $textdomain);
        $catalog->setproperty('mode', 'po');
        $catalog->setproperty('lang', $lang);
        $catalog->load();

        $catalog->setComments($_POST['comments']);
        $catalog->setHeaders($_POST['headers']);        
        $plural_forms = $catalog->headers['Plural-Forms'];
        preg_match('/nplurals[\s]*[=]{1}[\s]*([\d]+);[\s]*plural[\s]*[=]{1}[\s]*(.*);/', $plural_forms, $matches);
        $is_plural = $matches[1] > 1;
        foreach ($_POST as $key => $value) {
  //          if (preg_match('/^([a-z]+)[_]?([0-9]+)?_([0-9]+)$/', $key, $matches))  {
	         if (preg_match('/^([a-z]+[_]?[a-z]+?)[_]?([0-9]+)?_([0-9]+)$/', $key, $matches))  {
                switch ($matches[1])
                {
                    case 'msgid':
                    $messages[$matches[3]]['msgid'] = $value;
                    break;
                    case 'msgid_plural':
                        if ($is_plural){
                            $messages[$matches[3]]['msgid_plural'] = $value;
                        }
                    break;
                    case 'msgstr':
                    if (!empty($messages[$matches[3]]['msgid_plural'])) {
                        if ($matches[2] != '') {
                            $messages[$matches[3]]['msgstr'][$matches[2]] =  stripslashes($value);
                        } else {
                            $messages[$matches[3]]['msgstr'][0] =  stripslashes($value);
                            $messages[$matches[3]]['msgstr'][1] =  '';
                        }
                    } else {
                        $messages[$matches[3]]['msgstr'] =  stripslashes($value);
                    }
                    break;
                    case 'fuzzy':
                    $messages[$matches[3]]['fuzzy'] = $value == 'true' ? true : false;
                    break;
                }
            }
        }
        foreach ($messages as $index => $arr) {
            if (strcmp($catalog->strings[$index]->msgid, $arr['msgid']) == 0) {
                $catalog->strings[$index]->setmsgstr($arr['msgstr']);
                $catalog->strings[$index]->msgid_plural = isset($arr['msgid_plural'])?$arr['msgid_plural']:null;;
                $catalog->strings[$index]->setfuzzy($arr['fuzzy']);
            }
        }
        $catalog->save();        
        if ($request->get('act') == 'catalogs') {
            $request->set('domain', $domain);
        }
        $controller->view('edit');
    }
}
?>