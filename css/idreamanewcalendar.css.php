<?php
/* Copyright ©  2019-2025 Frédéric FRANCE     <frederic.france@free.fr>
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
 */

/**
 * \file    idreamanewcalendar/css/idreamanewcalendar.css.php
 * \ingroup idreamanewcalendar
 * \brief   CSS file for module IDreamANewCalendar.
 */

$defines = [
	'NOREQUIRESOC',
	'NOCSRFCHECK',
	'NOTOKENRENEWAL',
	'NOLOGIN',
	'NOREQUIREHTML',
	'NOREQUIREAJAX',
];

session_cache_limiter('public');
// false or '' = keep cache instruction added by server
// 'public'  = remove cache instruction added by server and if no cache-control added later,
// a default cache delay (10800) will be added by PHP.

// Load Dolibarr environment
include '../config.php';

require_once DOL_DOCUMENT_ROOT . '/core/lib/functions2.lib.php';

// Load user to have $user->conf loaded (not done by default here because of NOLOGIN constant defined) and load permission if we need to use them in CSS
/*if (empty($user->id) && ! empty($_SESSION['dol_login'])) {
	$user->fetch('',$_SESSION['dol_login']);
	user->getrights();
}*/


// Define css type
header('Content-type: text/css');
header('Cache-Control: max-age=10800, public, must-revalidate');

?>
.tooltip-inner {
	max-width:240px;
	padding:3px 8px;
	color:#000;
	text-align:left;
	text-decoration:none;
	background-color:rgb(235,235,235);
	border-radius:5px
}

/** pour gagner un peu de place en haut */
#id-right {
	padding-top: 0px;
	padding-bottom: 0px;
}
/**  custom bootstrap - start */
.btn {
  border-radius: 25px;
  border-color: #ddd;
}

.btn:hover {
  border: solid 1px #bbb;
  background-color: #fff;
}

.btn:active {
  background-color: #f9f9f9;
  border: solid 1px #bbb;
  outline: none;
}

.btn:disabled {
  background-color: #f9f9f9;
  border: solid 1px #ddd;
  color: #bbb;
}

.btn:focus:active, .btn:focus, .btn:active {
  outline: none;
}

.open > .dropdown-toggle.btn-default {
  background-color: #fff;
}

/** custom fontawesome - end */

.calendar-icon {
  width: 14px;
  height: 14px;
}

#lnb {
  position: absolute;
  width: 200px;
  top: 49px;
  bottom: 0;
  border-right: 1px solid #d5d5d5;
  padding: 12px 10px;
  background: #fafafa;
}

#lnb label {
  margin-bottom: 0;
  cursor: pointer;
}

.lnb-new-schedule {
  padding-bottom: 12px;
  border-bottom: 1px solid #e5e5e5;
}

.lnb-new-schedule-btn {
  height: 100%;
  font-size: 12px;
  background-color: #ff6618;
  color: #ffffff;
  border: 0;
  border-radius: 25px;
  padding: 10px 20px;
  font-weight: bold;
}

.lnb-new-schedule-btn:hover {
  height: 100%;
  font-size: 12px;
  background-color: #e55b15;
  color: #ffffff;
  border: 0;
  border-radius: 25px;
  padding: 10px 20px;
  font-weight: bold;
}

.lnb-new-schedule-btn:active {
  height: 100%;
  font-size: 12px;
  background-color: #d95614;
  color: #ffffff;
  border: 0;
  border-radius: 25px;
  padding: 10px 20px;
  font-weight: bold;
}

.lnb-calendars > div {
  padding: 12px 16px;
  border-bottom: 1px solid #e5e5e5;
  font-weight: normal;
}

.lnb-calendars-d1 {
  padding-left: 8px;
}

.lnb-calendars-d1 label {
  font-weight: normal;
}

.lnb-calendars-item {
  min-height: 12px;
  line-height: 14px;
  padding: 6px 0;
}

.lnb-footer {
  color: #999;
  font-size: 11px;
  position: absolute;
  bottom: 12px;
  padding-left: 16px;
}


#dropdownMenu-calendarType {
  padding: 0 8px 0 11px;
}

#calendarTypeName {
  min-width: 62px;
  display: inline-block;
  text-align: left;
  line-height: 30px;
}

.move-today {
  padding: 0 16px;
  line-height: 30px;
}

.move-day {
  padding: 8px;
  font-size: 0;
}

.search-clear {
  padding: 0 8px;
  display: inline-block;
  line-height: 30px;
  vertical-align: middle;
}

.search-all {
  padding: 0px;
  display: inline-block;
  line-height: 30px;
  vertical-align: middle;
}
.search-users {
  padding: 0px;
  display: inline-block;
  line-height: 30px;
  vertical-align: middle;
}
.search-customers {
  padding: 0 8px;
  display: inline-block;
  line-height: 30px;
  vertical-align: middle;
}
.search-states {
  padding: 0 8px;
  display: inline-block;
  line-height: 30px;
  vertical-align: middle;
}
.search-actioncode {
  padding: 0 8px;
  display: inline-block;
  line-height: 30px;
  vertical-align: middle;
}
.search-projects {
  padding: 0 8px;
  display: inline-block;
  line-height: 30px;
  vertical-align: middle;
}

#renderRange {
  padding-left: 12px;
  font-size: 18px;
  vertical-align: middle;
}

.dropdown-menu-title .calendar-icon {
  margin-right: 8px;
}

.calendar-bar {
  width: 16px;
  height: 16px;
  margin-right: 5px;
  display: inline-block;
  border: 1px solid #eee;
  vertical-align: middle;
}

.calendar-name {
	font-size: 12px;
	font-weight: bold;
	vertical-align: middle;
}

.schedule-time {
	color: #005aff;
}

/** custom fontawesome */
.fa {
	width: 10px;
	height: 10px;
	margin-right: 2px;
}

.weekday-grid-more-schedules {
  float: right;
  margin-top: 4px;
  margin-right: 6px;
  height: 18px;
  line-height: 17px;
  padding: 0 5px;
  border-radius: 3px;
  border: 1px solid #ddd;
  font-size: 10px;
  text-align: center;
  color: #000;
}

.calendar-icon {
  width: 14px;
  height: 14px;
  display: inline-block;
  vertical-align: middle;
}

.calendar-font-icon {
  font-family: 'tui-calendar-font-icon';
  font-size: 10px;
  font-weight: normal;
}

.img-bi {
  background: url('../img/img-bi.png') no-repeat;
  width: 215px;
  height: 16px;
}
