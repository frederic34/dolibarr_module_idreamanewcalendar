<?php
/* Copyright © 2019-2020  Frédéric FRANCE         <frederic.france@free.fr>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Library javascript to enable Browser notifications
 */

/**
 * \file    idreamanewcalendar/js/idreamanewcalendar.js.php
 * \ingroup idreamanewcalendar
 * \brief   JavaScript file for module IDreamANewCalendar.
 */

$defines = [
	'NOREQUIREUSER',
	'NOREQUIREDB',
	'NOREQUIRESOC',
	'NOREQUIRETRAN',
	'NOCSRFCHECK',
	'NOTOKENRENEWAL',
	'NOLOGIN',
	'NOREQUIREMENU',
	'NOREQUIREHTML',
	'NOREQUIREAJAX',
];

// Load Dolibarr environment
include '../config.php';

// Define js type
header('Content-Type: application/javascript');
// Important: Following code is to cache this file to avoid page request by browser at each Dolibarr page access.
// You can use CTRL+F5 to refresh your browser cache.
if (empty($dolibarr_nocache)) {
	header('Cache-Control: max-age=3600, public, must-revalidate');
} else {
	header('Cache-Control: no-cache');
}
?>

/* Javascript library of module IDreamANewCalendar */
