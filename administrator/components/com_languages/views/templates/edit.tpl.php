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

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); ?>
	<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
	    var form = document.adminForm;
	    if (pressbutton == 'cancel') {
	        submitform( pressbutton );
	        return;
	    }

	    // do field validation
	    if (form.name.value == "") {
	        alert( "<?php echo T_('You must provide a Language Name.') ?>" );
	    } else if (form.id.value == "") {
	        alert( "<?php echo T_('You must provide a Language Identifier.') ?>" );
	    } else if (form.locale.value == "") {
	        alert( "<?php echo T_('You must provide a locale.') ?>" );
	    } else if (form.encoding.value == "") {
	        alert( "<?php echo T_('You must provide a character encoding.') ?>" );
	    } else if (form.dateformat.value == "") {
	        alert( "<?php echo T_('You must provide a date format.') ?>" );
	    }  else {
	        submitform( pressbutton );
	    }
	}
	</script>
<?php 
$tabs = new mosTabs(1);
mosCommonHTML::loadOverlib();
mosCommonHTML::loadCalendar();
?>	
<table class="adminheading">
	<tr>
		<th class="langmanager">
		<?php echo T_('New Language') ?>
		</th>
		<td style="white-space: nowrap;text-align:right">
		<?php echo mosCurrentDate();?>   			
        </td>
	</tr>
</table>
<?php $tabs->startPane('language-pane'); $tabs->startTab(T_('Details'), 'details');?>
	<table class="adminform">
		<tr>
			<td style="width:200px"><?php echo T_('Language Identifier') ?></td>
			<td>
				<input type="text" name="id" maxlength="100" class="inputbox" disabled="disabled" style="width:180px" value="<?php echo $language['id'] ?>" />
				<?php echo mosToolTip( T_('The identifier for this language. This is used for naming the language xml file and translations directory.') ); ?>
			</td>
		</tr>
		<tr>
			<td style="width:200px"><?php echo T_('Language Name') ?></td>
			<td>
				<input type="text" name="name" maxlength="100" class="inputbox" style="width:180px" value="<?php echo $language['name'] ?>" />
				<?php echo mosToolTip( T_('The official name for this language') ); ?>
			</td>
		</tr>
		<tr>
			<td><?php echo T_('Locale') ?></td>
			<td>
				<input type="text" name="locale" maxlength="100" class="inputbox" style="width:180px" value="<?php echo $language['locale'] ?>" />
				<?php echo mosToolTip( T_('The locale list for this language. \nLocale names must be comma separated.') ); ?>
			</td>
		</tr>
		<tr>
			<td><?php echo T_('Encoding') ?></td>
			<td>
				<input type="text" name="encoding"  maxlength="100" class="inputbox" style="width:180px" value="<?php echo $language['encoding'] ?>" />				
				<?php echo mosToolTip( T_('The character encoding for this language. Ex. utf-8') ); ?>
			</td>
		</tr>
		<tr>
			<td><?php echo T_('Direction') ?></td>
			<td>
				<select	 name="direction" class="inputbox" style="width:185px">
				<option value="ltr"><?php echo T_('Left-to-Right') ?></option>				
				<option value="rtl"><?php echo T_('Right-to-Left') ?></option>
				</select>			
				<?php echo mosToolTip( T_('Text direction.') ); ?>
			</td>
		</tr>
		<tr>
			<td><?php echo T_('Date Format') ?></td>
			<td>
				<input type="text" name="dateformat" maxlength="100" class="inputbox" style="width:180px" value="<?php echo $language['dateformat'] ?>" />
				<?php echo mosToolTip( T_('Date format for strftime().') ); ?>
			</td>
		</tr>
		<tr>
			<td><?php echo T_('Plural forms') ?></td>
			<td>
				<input type="text" name="plural-forms"  maxlength="100" class="inputbox" style="width:180px" value="<?php echo $language['plural-forms'] ?>" /></label>				
				<?php echo mosToolTip( T_('Plural forms for gettext.') ); ?>
			</td>
		</tr>
	</table>
	<?php $tabs->endTab(); 
	
	
	$tabs->endPane(); ?>