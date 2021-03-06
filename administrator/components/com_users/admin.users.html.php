<?php
/**
* @package Mambo
* @subpackage Users
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

class HTML_users {

	function showUsers( &$rows, $pageNav, $search, $option, $lists ) {
		global $mosConfig_offset;
		?>
		<form action="index2.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<th class="user">
			<?php echo T_('User Manager'); ?>
			</th>
			<td>
			<?php echo T_('Filter:'); ?>
			</td>
			<td>
			<input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
			</td>
			<td width="right">
			<?php echo $lists['type'];?>
			</td>
			<td width="right">
			<?php echo $lists['logged'];?>
			</td>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="2%" class="title">
			#
			</th>
			<th width="3%" class="title">
			<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows); ?>);" />
			</th>
			<th class="title">
			<?php echo T_('Name'); ?>
			</th>
			<th width="5%" class="title" nowrap="nowrap">
			<?php echo T_('Logged In'); ?>
			</th>
			<th width="5%" class="title">
			<?php echo T_('Enabled'); ?>
			</th>
			<th width="15%" class="title" >
			<?php echo T_('UserID'); ?>
			</th>
			<th width="15%" class="title">
			<?php echo T_('Group'); ?>
			</th>
			<th width="15%" class="title">
			<?php echo T_('E-Mail'); ?>
			</th>
			<th width="10%" class="title">
			<?php echo T_('Last Visit'); ?>
			</th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	=& $rows[$i];

			$img 	= $row->block ? 'publish_x.png' : 'tick.png';
			$task 	= $row->block ? 'unblock' : 'block';
			$alt 	= $row->block ? 'Enabled' : 'Blocked';
			$link 	= 'index2.php?option=com_users&amp;task=editA&amp;id='. $row->id. '&amp;hidemainmenu=1';
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $i+1+$pageNav->limitstart;?>
				</td>
				<td>
				<?php echo mosHTML::idBox( $i, $row->id ); ?>
				</td>
				<td>
				<a href="<?php echo $link; ?>">
				<?php echo $row->name; ?>
				</a>
				</td>
				<td align="center">
				<?php echo $row->loggedin ? '<img src="images/tick.png" width="12" height="12" border="0" alt="" />': ''; ?>
				</td>
				<td>
				<a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
				<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
				</a>
				</td>
				<td>
				<?php echo $row->username; ?>
				</td>
				<td>
				<?php echo $row->groupname; ?>
				</td>
				<td>
				<a href="mailto:<?php echo $row->email; ?>">
				<?php echo $row->email; ?>
				</a>
				</td>
				<td nowrap="nowrap">
				<?php echo mosFormatDate( $row->lastvisitDate, "%Y-%m-%d %H:%M:%S" ); ?>
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
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
		<?php
	}

	function edituser( &$row, &$contact, &$lists, $option, $uid ) {
		global $my, $acl;
		global $mosConfig_live_site;
		$tabs =& new mosTabs( 0 );

		$canBlockUser = $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'user properties', 'block_user' );
		$canEmailEvents = $acl->acl_check( 'workflow', 'email_events', 'users', $acl->get_group_name( $row->gid, 'ARO' ) );
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
			var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

			// do field validation
			if (trim(form.name.value) == "") {
				alert( "<?php echo T_('You must provide a name.'); ?>" );
			} else if (form.username.value == "") {
				alert( "<?php echo T_('You must provide a user login name.'); ?>" );
			} else if (r.exec(form.username.value) || form.username.value.length < 3) {
				alert( "<?php echo T_('Your login name contains invalid characters or is too short.'); ?>" );
			} else if (trim(form.email.value) == "") {
				alert( "<?php echo T_('You must provide an email address.'); ?>" );
			} else if (form.gid.value == "") {
				alert( "<?php echo T_('You must assign user to a group.'); ?>" );
			} else if (trim(form.password.value) != "" && form.password.value != form.password2.value){
				alert( "<?php echo T_('Passwords do not match.'); ?>" );
			} else if (form.gid.value == "29") {
				alert( "<?php echo T_('Please Select another group as `Public Frontend` is not a selectable option'); ?>" );
			} else if (form.gid.value == "30") {
				alert( "<?php echo T_('Please Select another group as `Public Backend` is not a selectable option'); ?>" );
			} else {
				submitform( pressbutton );
			}
		}

		function gotocontact( id ) {
			var form = document.adminForm;
			form.contact_id.value = id;
			submitform( 'contact' );
		}
		</script>
		<form action="index2.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<th class="user">
			<?php echo T_('User:'); ?> <small><?php echo $row->id ? T_('Edit') : T_('Add');?></small>
			</th>
		</tr>
		</table>

		<table width="100%">
		<tr>
			<td width="60%" valign="top">
				<table class="adminform">
				<tr>
					<th colspan="2">
					<?php echo T_('User Details'); ?>
					</th>
				</tr>
				<tr>
					<td width="100">
					<?php echo T_('Name:'); ?>
					</td>
					<td width="85%">
					<input type="text" name="name" class="inputbox" size="40" value="<?php echo $row->name; ?>" />
					</td>
				</tr>
				<tr>
					<td>
					<?php echo T_('Username:'); ?>
					</td>
					<td>
					<input type="text" name="username" class="inputbox" size="40" value="<?php echo $row->username; ?>" />
					</td>
				<tr>
					<td>
					<?php echo T_('Email:'); ?>
					</td>
					<td>
					<input class="inputbox" type="text" name="email" size="40" value="<?php echo $row->email; ?>" />
					</td>
				</tr>
				<tr>
					<td>
					<?php echo T_('New Password:'); ?>
					</td>
					<td>
					<input class="inputbox" type="password" name="password" size="40" value="" />
					</td>
				</tr>
				<tr>
					<td>
					<?php echo T_('Verify Password:'); ?>
					</td>
					<td>
					<input class="inputbox" type="password" name="password2" size="40" value="" />
					</td>
				</tr>
				<tr>
					<td valign="top">
					<?php echo T_('Group:'); ?>
					</td>
					<td>
					<?php echo $lists['gid']; ?>
					</td>
				</tr>
				<?php
				if ($canBlockUser) {
					?>
					<tr>
						<td>
						<?php echo T_('Block User'); ?>
						</td>
						<td>
						<?php echo $lists['block']; ?>
						</td>
					</tr>
					<?php
				}
				if ($canEmailEvents) {
					?>
					<tr>
						<td>
						<?php echo T_('Receive Submission Emails'); ?>
						</td>
						<td>
						<?php echo $lists['sendEmail']; ?>
						</td>
					</tr>
					<?php
				}
				if( $uid ) {
					?>
					<tr>
						<td>
						<?php echo T_('Register Date'); ?>
						</td>
						<td>
						<?php echo $row->registerDate;?>
						</td>
					</tr>
				<tr>
					<td>
					<?php echo T_('Last Visit Date'); ?>
					</td>
					<td>
					<?php echo $row->lastvisitDate;?>
					</td>
				</tr>
					<?php
				}
				?>
				<tr>
					<td colspan="2">&nbsp;

					</td>
				</tr>
				</table>
			</td>
			<td width="40%" valign="top">
			<?php
			if ( !$contact ) {
				?>
				<table class="adminform">
				<tr>
					<th>
					<?php echo T_('Contact Information'); ?>
					</th>
				</tr>
				<tr>
					<td>
					<br />
					<?php echo T_('No Contact details linked to this User:'); ?>
					<br />
					<?php echo T_('See "Components -> Contact -> Manage Contacts" for details.'); ?>
					<br /><br />
					</td>
				</tr>
				</table>
				<?php
			} else {
				?>
				<table class="adminform">
				<tr>
					<th colspan="2">
					<?php echo T_('Contact Information'); ?>
					</th>
				</tr>
				<tr>
					<td width="15%">
					<?php echo T_('Name:'); ?>
					</td>
					<td>
					<strong>
					<?php echo $contact[0]->name;?>
					</strong>
					</td>
				</tr>
				<tr>
					<td>
					<?php echo T_('Position:'); ?>
					</td>
					<td >
					<strong>
					<?php echo $contact[0]->con_position;?>
					</strong>
					</td>
				</tr>
				<tr>
					<td>
					<?php echo T_('Telephone:'); ?>
					</td>
					<td >
					<strong>
					<?php echo $contact[0]->telephone;?>
					</strong>
					</td>
				</tr>
				<tr>
					<td>
					<?php echo T_('Fax:'); ?>
					</td>
					<td >
					<strong>
					<?php echo $contact[0]->fax;?>
					</strong>
					</td>
				</tr>
				<tr>
					<td></td>
					<td >
					<strong>
					<?php echo $contact[0]->misc;?>
					</strong>
					</td>
				</tr>
				<?php
				if ($contact[0]->image) {
					?>
					<tr>
						<td></td>
						<td valign="top">
						<img src="<?php echo $mosConfig_live_site;?>/images/stories/<?php echo $contact[0]->image; ?>" align="middle" alt="<?php echo T_('Contact'); ?>" />
						</td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan="2">
					<br /><br />
					<input class="button" type="button" value="<?php echo T_('Change Contact Details'); ?>" onclick="javascript: gotocontact( '<?php echo $contact[0]->id; ?>' )">
					<i>
					<br />
					'<?php echo T_('Components -> Contact -> Manage Contacts'); ?>'.
					</i>
					</td>
				</tr>
				</table>
				<?php
			}
			?>
			</td>
		</tr>
		</table>

		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="contact_id" value="" />
		<?php
		if (!$canEmailEvents) {
			?>
			<input type="hidden" name="sendEmail" value="0" />
			<?php
		}
		?>
		</form>
		<?php
	}
}
?>