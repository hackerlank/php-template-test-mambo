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

/**
* AWSTATS BROWSERS DATABASE
* If you want to add a Browser to extend AWStats database detection capabilities,
* you must add an entry in BrowsersSearchIDOrder and in BrowsersHashIDLib.
*/

$osSearchOrder = array (
"windows nt 6\.0",
"windows nt 5\.2",
"windows nt 5\.1",
"windows nt 5\.0",
"winnt4\.0",
"winnt",
"windows 98",
"windows 95",
"win98",
"win95",
"mac os x",
"debian",
"freebsd",
"linux",
"ppc",
"beos",
"sunos",
"apachebench",
"aix",
"irix",
"osf",
"hp-ux",
"netbsd",
"bsdi",
"openbsd",
"gnu",
"unix"
);

$osAlias = array (
"windows nt 6\.0"=>"Windows Longhorn",
"windows nt 5\.2"=>"Windows 2003",
"windows nt 5\.0"=>"Windows 2000",
"windows nt 5\.1"=>"Windows XP",
"winnt"=>"Windows NT",
"winnt 4\.0"=>"Windows NT",
"windows 98"=>"Windows 98",
"win98"=>"Windows 98",
"windows 95"=>"Windows 95",
"win95"=>"Windows 95",
"sunos"=>"Sun Solaris",
"freebsd"=>"FreeBSD",
"ppc"=>"Macintosh",
"mac os x"=>"Mac OS X",
"linux"=>"Linux",
"debian"=>"Debian",
"beos"=>"BeOS",
"winnt4\.0"=>"Windows NT 4.0",
"apachebench"=>"ApacheBench",
"aix"=>"AIX",
"irix"=>"Irix",
"osf"=>"DEC OSF",
"hp-ux"=>"HP-UX",
"netbsd"=>"NetBSD",
"bsdi"=>"BSDi",
"openbsd"=>"OpenBSD",
"gnu"=>"GNU/Linux",
"unix"=>"Unknown Unix system"
);
?>