<?php
/**
* @package Mambo
* @subpackage Weblinks
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

class HTML_weblinks {

	function showWeblinks( $option, &$rows, &$lists, &$search, &$pageNav ) {
		global $my;

		mosCommonHTML::loadOverlib();
		?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>
			<?php echo T_('Web Link Manager'); ?>
			</th>
			<td>
			<?php echo T_('Filter:'); ?>
			</td>
			<td>
			<input type="text" name="search" value="<?php echo $search;?>" class="text_area" onChange="document.adminForm.submit();" />
			</td>
			<td width="right">
			<?php echo $lists['catid'];?>
			</td>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="5">
			#
			</th>
			<th width="20">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" />
			</th>
			<th class="title">
			<?php echo T_('Title'); ?>
			</th>
			<th width="5%">
			<?php echo T_('Published'); ?>
			</th>
			<th width="5%">
			<?php echo T_('Approved'); ?>
			</th>
			<th colspan="2" width="5%">
			<?php echo T_('Reorder'); ?>
			</th>
			<th width="25%" align="left">
			<?php echo T_('Category'); ?>
			</th>
			<th width="5%">
			<?php echo T_('Hits'); ?>
			</th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];

			$link 	= 'index2.php?option=com_weblinks&task=editA&hidemainmenu=1&id='. $row->id;

			$task 	= $row->published ? 'unpublish' : 'publish';
			$img 	= $row->published ? 'publish_g.png' : 'publish_x.png';
			$alt 	= $row->published ? 'Published' : 'Unpublished';

			$checked 	= mosCommonHTML::CheckedOutProcessing( $row, $i );

			$row->cat_link 	= 'index2.php?option=com_categories&section=com_weblinks&task=editA&hidemainmenu=1&id='. $row->catid;
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td>
				<?php echo $checked; ?>
				</td>
				<td>
				<?php
				if ( $row->checked_out && ( $row->checked_out != $my->id ) ) {
					echo stripslashes($row->title);
				} else {
					?>
					<a href="<?php echo $link; ?>" title="<?php echo T_('Edit Weblinks'); ?>">
					<?php echo stripslashes($row->title); ?>
					</a>
					<?php
				}
				?>
				</td>
				<td align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
				<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
				</a>
				</td>
				<?php
				if ( $row->approved ) {
					?>
					<td align="center">
					<img src="images/tick.png">
					</td>
					<?php
				} else {
					?>
					<td align="center">
					</td>
					<?php
				}
				?>
				<td>
				<?php echo $pageNav->orderUpIcon( $i, ($row->catid == @$rows[$i-1]->catid) ); ?>
				</td>
      			<td>
				<?php echo $pageNav->orderDownIcon( $i, $n, ($row->catid == @$rows[$i+1]->catid) ); ?>
				</td>
				<td>
				<a href="<?php echo $row->cat_link; ?>" title="<?php echo T_('Edit Category'); ?>">
				<?php echo $row->category; ?>
				</a>
				</td>
				<td align="center">
				<?php echo $row->hits; ?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</table>
		<?php echo $pageNav->getListFooter(); ?>
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0">
		</form>
		<?php
	}

	/**
	* Writes the edit form for new and existing record
	*
	* A new record is defined when <var>$row</var> is passed with the <var>id</var>
	* property set to 0.
	* @param mosWeblink The weblink object
	* @param array An array of select lists
	* @param object Parameters
	* @param string The option
	*/
	function editWeblink( &$row, &$lists, &$params, $option ) {
		mosMakeHtmlSafe( $row, ENT_QUOTES, 'description' );
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			// do field validation
			if (form.title.value == ""){
				alert( "<?php echo T_('Weblink item must have a title'); ?>" );
			} else if (form.catid.value == "0"){
				alert( "<?php echo T_('You must select a category.'); ?>" );
			} else if (form.url.value == ""){
				alert( "<?php echo T_('You must have a url.'); ?>" );
			} else {
				submitform( pressbutton );
			}
		}
		</script>
		<form action="index2.php" method="post" name="adminForm" id="adminForm">
		<table class="adminheading">
		<tr>
			<th>
			<?php echo T_('Web Link:'); ?>
			<small>
			<?php echo $row->id ? T_('Edit') : T_('New');?>
			</small>
			</th>
		</tr>
		</table>

		<table width="100%">
		<tr>
			<td width="60%" valign="top">
				<table class="adminform">
				<tr>
					<th colspan="2">
					<?php echo T_('Details'); ?>
					</th>
				</tr>
				<tr>
					<td width="20%" align="right">
					<?php echo T_('Name:'); ?>
					</td>
					<td width="80%">
					<input class="text_area" type="text" name="title" size="50" maxlength="250" value="<?php echo stripslashes($row->title);?>" />
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<?php echo T_('Category:'); ?>
					</td>
					<td>
					<?php echo $lists['catid']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<?php echo T_('URL:'); ?>
					</td>
					<td>
					<input class="text_area" type="text" name="url" value="<?php echo $row->url; ?>" size="50" maxlength="250" />
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<?php echo T_('Description:'); ?>
					</td>
					<td>
					<textarea class="text_area" cols="50" rows="5" name="description" style="width:500px" width="500"><?php echo $row->description; ?></textarea>
					</td>
				</tr>

				<tr>
					<td valign="top" align="right">
					<?php echo T_('Ordering:'); ?>
					</td>
					<td>
					<?php echo $lists['ordering']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<?php echo T_('Approved:'); ?>
					</td>
					<td>
					<?php echo $lists['approved']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					<?php echo T_('Published:'); ?>
					</td>
					<td>
					<?php echo $lists['published']; ?>
					</td>
				</tr>
				</table>
			</td>
			<td width="40%" valign="top">
				<table class="adminform">
				<tr>
					<th colspan="1">
					<?php echo T_('Parameters'); ?>
					</th>
				</tr>
				<tr>
					<td>
					<?php echo $params->render();?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>

		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		</form>
		<script type="text/javascript" src="<?php echo mamboCore::get('mosConfig_live_site');?>/includes/js/prototype/prototype.js"></script>
		<script type="text/javascript" src="<?php echo mamboCore::get('mosConfig_live_site');?>/includes/js/tooltip/tooltip.js"></script>
		<?php
	}
}
?>