<?php
/**
* @package Mambo
* @author Mambo Foundation Inc see README.php
* @copyright Mambo Foundation Inc.
* See COPYRIGHT.php for copyright notices and details.
* @license GNU/GPL Version 2, see LICENSE.php
* Mambo is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; version 2 of the License.
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$_MAMBOTS->registerFunction( 'onInitEditor', 'botNoEditorInit' );
$_MAMBOTS->registerFunction( 'onGetEditorContents', 'botNoEditorGetContents' );
$_MAMBOTS->registerFunction( 'onEditorArea', 'botNoEditorEditorArea' );

/**
* No WYSIWYG Editor - javascript initialisation
*/
function botNoEditorInit() {
	return <<<EOD
<script type="text/javascript">
	function insertAtCursor(myField, myValue) {
		if (document.selection) {
			// IE support
			myField.focus();
			sel = document.selection.createRange();
			sel.text = myValue;
		} else if (myField.selectionStart || myField.selectionStart == '0') {
			// MOZILLA/NETSCAPE support
			var startPos = myField.selectionStart;
			var endPos = myField.selectionEnd;
			myField.value = myField.value.substring(0, startPos)
				+ myValue
				+ myField.value.substring(endPos, myField.value.length);
		} else {
			myField.value += myValue;
		}
	}
</script>
EOD;
}
/**
* No WYSIWYG Editor - copy editor contents to form field
* @param string The name of the editor area
* @param string The name of the form field
*/
function botNoEditorGetContents( $editorArea, $hiddenField ) {
	return <<<EOD
EOD;
}
/**
* No WYSIWYG Editor - display the editor
* @param string The name of the editor area
* @param string The content of the field
* @param string The name of the form field
* @param string The width of the editor area
* @param string The height of the editor area
* @param int The number of columns for the editor area
* @param int The number of rows for the editor area
*/
function botNoEditorEditorArea( $name, $content, $hiddenField, $width, $height, $col, $row ) {
	global $mosConfig_live_site, $_MAMBOTS;

	$results = $_MAMBOTS->trigger( 'onCustomEditorButton' );
	$buttons = array();
	foreach ($results as $result) {
	    $buttons[] = '<img src="'.$mosConfig_live_site.'/mambots/editors-xtd/'.$result[0].'" onclick="insertAtCursor( document.adminForm.'.$hiddenField.', \''.$result[1].'\' )" />';
	}
	$buttons = implode( "", $buttons );

	return <<<EOD
<textarea name="$hiddenField" id="$hiddenField" cols="$col" rows="$row" style="width:$width;height:$height;">$content</textarea>
<br />$buttons
EOD;
}
?>