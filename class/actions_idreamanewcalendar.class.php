<?php
/* Copyright © 2019-2025  Frédéric FRANCE   <frederic.france@free.fr>
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
 * \file    idreamanewcalendar/class/actions_idreamanewcalendar.class.php
 * \ingroup idreamanewcalendar
 * \brief   IDreamANewCalendar hook overload.
 *
 * Put detailed description here.
 */

/**
 * Class ActionsIDreamANewCalendar
 */
class ActionsIDreamANewCalendar
{
	/**
	 * @var DoliDB Database handler.
	 */
	public $db;

	/**
	 * @var string Error code (or message)
	 */
	public $error = '';

	/**
	 * @var array Errors
	 */
	public $errors = [];

	/**
	 * @var array Hook results. Propagated to $hookmanager->resArray for later reuse
	 */
	public $results = [];

	/**
	 * @var string String displayed by executeHook() immediately after return
	 */
	public $resprints;

	/**
	 * Constructor
	 *
	 *  @param      DoliDB      $db      Database handler
	 */
	public function __construct($db)
	{
		$this->db = $db;
	}

	/**
	 * Execute action
	 *
	 * @param   array           $parameters Array of parameters
	 * @param   CommonObject    $object The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param   string          $action 'add', 'update', 'view'
	 * @return  int                     <0 if KO,
	 *                                  =0 if OK but we want to process standard actions too,
	 *                                  >0 if OK and we want to replace standard actions.
	 */
	public function getNomUrl($parameters, &$object, &$action)
	{
		//global $db, $langs, $conf, $user;
		$this->resprints = '';
		return 0;
	}

	/**
	 * Overloading the doActions function : replacing the parent's function with the one below
	 *
	 * @param   array           $parameters     Hook metadatas (context, etc...)
	 * @param   CommonObject    $object         The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param   string          $action         Current action (if set). Generally create or edit or null
	 * @param   HookManager     $hookmanager    Hook manager propagated to allow calling another hook
	 * @return  int                             < 0 on error, 0 on success, 1 to replace standard code
	 */
	public function doActions($parameters, &$object, &$action, $hookmanager)
	{
		//global $conf, $user, $langs;

		$error = 0; // Error counter
		//var_dump($parameters);
		/* print_r($parameters); print_r($object); echo "action: " . $action; */
		if (in_array($parameters['currentcontext'], ['actioncard', 'somecontext2'])) {
			// do something only for the context 'somecontext1' or 'somecontext2'
			// Do what you want here...
			// You can for example call global vars like $fieldstosearchall to overwrite them, or update database depending on $action and $_POST values.
			//print '<div id="idreamanewcalendar" style="height: 800px;"></div>';
			//setEventMessage('action card');
			return 0;
		}
		if (in_array($parameters['currentcontext'], ['agenda', 'somecontext2'])) {
			// do something only for the context 'somecontext1' or 'somecontext2'
			// Do what you want here...
			// You can for example call global vars like $fieldstosearchall to overwrite them, or update database depending on $action and $_POST values.
			//print '<div id="idreamanewcalendar" style="height: 800px;"></div>';
			//setEventMessage('agenda card');
			return 0;
		}

		if (!$error) {
			$this->results = ['myreturn' => 999];
			$this->resprints = 'A text to show';
			return 0; // or return 1 to replace standard code
		} else {
			$this->errors[] = 'Error message';
			return -1;
		}
	}

	// /**
	//  * Overloading the beforeAgendaPerUser function : replacing the parent's function with the one below
	//  *
	//  * @param   array           $parameters     Hook metadatas (context, etc...)
	//  * @param   CommonObject    $object         The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	//  * @param   string          $action         Current action (if set). Generally create or edit or null
	//  * @param   HookManager     $hookmanager    Hook manager propagated to allow calling another hook
	//  * @return  int                             < 0 on error, 0 on success, 1 to replace standard code
	//  */
	// public function beforeAgendaPerUser($parameters, &$object, &$action, $hookmanager)
	// {
	// 	global $conf, $user, $langs;

	// 	$error = 0; // Error counter
	// 	$langs->load('idreamanewcalendar@idreamanewcalendar');
	// 	// var_dump($parameters);
	// 	/* print_r($parameters); print_r($object); echo "action: " . $action; */
	// 	if (in_array($parameters['currentcontext'], ['desactivated-agenda'])) {
	// 		if (empty($conf->use_javascript_ajax)) {
	// 			return 0;
	// 		}
	// 		$arrayofjs = [
	// 			'/idreamanewcalendar/node_modules/frappe-gantt/dist/frappe-gantt.js',
	// 		];
	// 		$arrayofcss = [
	// 			'/idreamanewcalendar/node_modules/frappe-gantt/dist/frappe-gantt.css',
	// 			'/idreamanewcalendar/css/icons.css',
	// 			'/idreamanewcalendar/css/idreamanewcalendar.css.php',
	// 		];
	// 		$socid = $parameters['socid'];
	// 		$canedit = $parameters['canedit'];
	// 		$status = $parameters['status'];
	// 		$year = (int) $parameters['year'];
	// 		$month = (int) $parameters['month'];
	// 		$day = (int) $parameters['day'];
	// 		$type = $parameters['type'];
	// 		$maxprint = $parameters['maxprint'];
	// 		$filter = $parameters['filter'];
	// 		$filtert = $parameters['filtert'];
	// 		$showbirthday = $parameters['showbirthday'];
	// 		$actioncode = $parameters['actioncode'];
	// 		$pid = $parameters['pid'];
	// 		$usergroup = $parameters['usergroup'];
	// 		$resourceid = $parameters['resourceid'];

	// 		llxHeader('', $langs->trans("Agenda"), '', '', 0, 0, $arrayofjs, $arrayofcss);

	// 		$param = '';
	// 		if ($actioncode || isset($_GET['search_actioncode']) || isset($_POST['search_actioncode'])) {
	// 			if (is_array($actioncode)) {
	// 				foreach ($actioncode as $str_action) {
	// 					$param .= "&search_actioncode[]=" . urlencode($str_action);
	// 				}
	// 			} else {
	// 				$param .= "&search_actioncode=" . urlencode($actioncode);
	// 			}
	// 		}
	// 		if ($resourceid > 0) {
	// 			$param .= "&search_resourceid=" . urlencode($resourceid);
	// 		}
	// 		if ($status || isset($_GET['status']) || isset($_POST['status'])) {
	// 			$param .= "&search_status=" . urlencode($status);
	// 		}
	// 		if ($filter) {
	// 			$param .= "&search_filter=" . urlencode($filter);
	// 		}
	// 		if ($filtert) {
	// 			$param .= "&search_filtert=" . urlencode($filtert);
	// 		}
	// 		if ($usergroup) {
	// 			$param .= "&search_usergroup=" . urlencode($usergroup);
	// 		}
	// 		if ($socid) {
	// 			$param .= "&search_socid=" . urlencode($socid);
	// 		}
	// 		if ($showbirthday) {
	// 			$param .= "&search_showbirthday=1";
	// 		}
	// 		if ($pid) {
	// 			$param .= "&search_projectid=" . urlencode($pid);
	// 		}
	// 		if ($type) {
	// 			$param .= "&search_type=" . urlencode($type);
	// 		}
	// 		if ($action == 'show_day' || $action == 'show_week' || $action == 'show_month') {
	// 			$param .= '&action=' . urlencode($action);
	// 		}
	// 		$param .= "&maxprint=" . urlencode($maxprint);

	// 		$paramnoaction = preg_replace('/action=[a-z_]+/', '', $param);

	// 		$head = calendars_prepare_head($paramnoaction);

	// 		print dol_get_fiche_head($head, 'cardperuser', $langs->trans('Agenda'), 0, 'action');
	// 		print '<div id="gantt" style="height: 800px;"></div>';
	// 		print "<script>
	// 		var tasks = [
	// 			{
	// 				id: 'Task 1',
	// 				name: 'Redesign website',
	// 				start: '2019-12-21',
	// 				end: '2019-12-25',
	// 				progress: 30,
	// 				dependencies: null,
	// 				custom_class: 'bar-milestone' // optional
	// 			},
	// 			{
	// 				id: 'Task 2',
	// 				name: 'Redesign backoffice',
	// 				start: '2019-12-28',
	// 				end: '2019-12-31',
	// 				progress: 10,
	// 				dependencies: 'Task 1',
	// 				custom_class: 'bar-milestone' // optional
	// 			}
	// 		]
	// 		var gantt = new Gantt('#gantt', tasks, {
	// 			header_height: 50,
	// 			column_width: 30,
	// 			step: 24,
	// 			view_modes: ['Quarter Day', 'Half Day', 'Day', 'Week', 'Month'],
	// 			bar_height: 20,
	// 			bar_corner_radius: 3,
	// 			arrow_curve: 5,
	// 			padding: 18,
	// 			view_mode: 'Day',
	// 			date_format: 'YYYY-MM-DD',
	// 			custom_popup_html: null
	// 		});
	// 		</script>";

	// 		print dol_get_fiche_end();
	// 		// End of page
	// 		llxFooter();
	// 		$this->db->close();
	// 		// we stop here, we don't want dolibarr calendar
	// 		exit;
	// 		return 0;
	// 	}

	// 	return 0; // or return 1 to replace standard code
	// }

	/**
	 * Overloading the beforeAgenda function : replacing the parent's function with the one below
	 *
	 * @param   array           $parameters     Hook metadatas (context, etc...)
	 * @param   CommonObject    $object         The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param   string          $action         Current action (if set). Generally create or edit or null
	 * @param   HookManager     $hookmanager    Hook manager propagated to allow calling another hook
	 * @return  int                             < 0 on error, 0 on success, 1 to replace standard code
	 */
	public function beforeAgenda($parameters, &$object, &$action, $hookmanager)
	{
		global $conf, $user, $langs;

		$langs->load('idreamanewcalendar@idreamanewcalendar');
		$langs->load("companies");

		if (in_array($parameters['currentcontext'], ['agenda'])) {
			if (empty($conf->use_javascript_ajax)) {
				return 0;
			}
			$arrayofjs = [
				'/idreamanewcalendar/lib/event-calendar/event-calendar.min.js',
			];
			$arrayofcss = [
				'/idreamanewcalendar/lib/event-calendar/event-calendar.min.css',
				'/idreamanewcalendar/css/idreamanewcalendar.css.php'
			];
			llxHeader('', $langs->trans("Agenda"), '', '', 0, 0, $arrayofjs, $arrayofcss);

			// $form = new Form($this->db);
			// $companystatic = new Societe($this->db);
			// $contactstatic = new Contact($this->db);

			$now = dol_now();
			$nowarray = dol_getdate($now);
			$nowyear = $nowarray['year'];
			$nowmonth = $nowarray['mon'];
			$nowday = $nowarray['mday'];
			$mode = GETPOST('mode', 'alpha');
			$defaultview = getDolGlobalString('AGENDA_DEFAULT_VIEW', 'show_month');	// default for app
			$defaultview = getDolUserString('AGENDA_DEFAULT_VIEW', $defaultview);	// default for user
			if (empty($mode) && !GETPOSTISSET('mode')) {
				$mode = $defaultview;
			}

			$socid = $parameters['socid'];
			$canedit = $parameters['canedit'];
			$status = $parameters['status'];
			$year = $parameters['year'];
			$month = $parameters['month'];
			$day = (int) $parameters['day'];
			$type = $parameters['type'];
			$maxprint = $parameters['maxprint'];
			$filter = $parameters['filter'];
			$filtert = $parameters['filtert'];
			$showbirthday = $parameters['showbirthday'];
			$actioncode = $parameters['actioncode'];
			$pid = $parameters['pid'];
			$usergroup = $parameters['usergroup'];
			$resourceid = $parameters['resourceid'];

			$listofextcals = [];
			$MAXAGENDA = getDolGlobalInt('AGENDA_EXT_NB', 6);

			// Define list of external calendars (global admin setup)
			if (empty($conf->global->AGENDA_DISABLE_EXT)) {
				$i = 0;
				while ($i < $MAXAGENDA) {
					$i++;
					$source = 'AGENDA_EXT_SRC' . $i;
					$name = 'AGENDA_EXT_NAME' . $i;
					$offsettz = 'AGENDA_EXT_OFFSETTZ' . $i;
					$color = 'AGENDA_EXT_COLOR' . $i;
					$buggedfile = 'AGENDA_EXT_BUGGEDFILE' . $i;
					if (!empty($conf->global->$source) && !empty($conf->global->$name)) {
						// Note: $conf->global->buggedfile can be empty
						// or 'uselocalandtznodaylight' or 'uselocalandtzdaylight'
						$listofextcals[] = [
							'src' => $conf->global->$source,
							'name' => $conf->global->$name,
							'offsettz' => getDolGlobalInt($offsettz),
							'color' => getDolGlobalString($color),
							'buggedfile' => getDolGlobalInt($buggedfile),
						];
					}
				}
			}
			// Define list of external calendars (user setup)
			if (empty($user->conf->AGENDA_DISABLE_EXT)) {
				$i = 0;
				while ($i < $MAXAGENDA) {
					$i++;
					$source = 'AGENDA_EXT_SRC_' . $user->id . '_' . $i;
					$name = 'AGENDA_EXT_NAME_' . $user->id . '_' . $i;
					$offsettz = 'AGENDA_EXT_OFFSETTZ_' . $user->id . '_' . $i;
					$color = 'AGENDA_EXT_COLOR_' . $user->id . '_' . $i;
					$enabled = 'AGENDA_EXT_ENABLED_' . $user->id . '_' . $i;
					$buggedfile = 'AGENDA_EXT_BUGGEDFILE_' . $user->id . '_' . $i;
					if (!empty($user->conf->$source) && !empty($user->conf->$name)) {
						// Note: $conf->global->buggedfile can be empty or 'uselocalandtznodaylight' or 'uselocalandtzdaylight'
						$listofextcals[] = [
							'src' => getDolUserString($source),
							'name' => $user->conf->$name,
							'offsettz' => (!empty($user->conf->$offsettz) ? $user->conf->$offsettz : 0),
							'color' => getDolUserString($color),
							'buggedfile' => (isset($user->conf->$buggedfile) ? $user->conf->$buggedfile : 0),
						];
					}
				}
			}

			if (empty($mode) || $mode == 'show_month') {
				$prev = dol_get_prev_month($month, $year);
				$prev_year  = $prev['year'];
				$prev_month = $prev['month'];
				$next = dol_get_next_month($month, $year);
				$next_year  = $next['year'];
				$next_month = $next['month'];
				// Nb of days in previous month
				$max_day_in_prev_month = date("t", dol_mktime(0, 0, 0, $prev_month, 1, $prev_year));
				// Nb of days in next month
				$max_day_in_month = date("t", dol_mktime(0, 0, 0, $month, 1, $year));
				// tmpday is a negative or null cursor to know how many days before the 1st to show on month view (if tmpday=0, 1st is monday)
				// date('w') is 0 for sunday
				$tmpday = -date("w", dol_mktime(12, 0, 0, $month, 1, $year, true)) + 2;
				$tmpday += ((isset($conf->global->MAIN_START_WEEK) ? $conf->global->MAIN_START_WEEK : 1) - 1);
				if ($tmpday >= 1) {
					// If tmpday is 0 we start with sunday, if -6, we start with monday of previous week.
					$tmpday -= 7;
				}
				// Define firstdaytoshow and lastdaytoshow (warning: lastdaytoshow is last second to show + 1)
				$firstdaytoshow = dol_mktime(0, 0, 0, $prev_month, $max_day_in_prev_month + $tmpday, $prev_year);
				$next_day = 7 - ($max_day_in_month + 1 - $tmpday) % 7;
				if ($next_day < 6) {
					$next_day += 7;
				}
				$lastdaytoshow = dol_mktime(0, 0, 0, $next_month, $next_day, $next_year);
			}
			if ($mode == 'show_week') {
				$prev = dol_get_first_day_week($day, $month, $year);
				$prev_year = $prev['prev_year'];
				$prev_month = $prev['prev_month'];
				$prev_day = $prev['prev_day'];
				$first_day = $prev['first_day'];
				$first_month = $prev['first_month'];
				$first_year = $prev['first_year'];

				$week = $prev['week'];

				$next = dol_get_next_week($first_day, $week, $first_month, $first_year);
				$next_year  = $next['year'];
				$next_month = $next['month'];
				$next_day   = $next['day'];

				// Define firstdaytoshow and lastdaytoshow (warning: lastdaytoshow is last second to show + 1)
				$firstdaytoshow = dol_mktime(0, 0, 0, $first_month, $first_day, $first_year);
				$lastdaytoshow = dol_time_plus_duree($firstdaytoshow, 7, 'd');

				$max_day_in_month = date("t", dol_mktime(0, 0, 0, $month, 1, $year));

				$tmpday = $first_day;
			}
			if ($mode == 'show_day') {
				$prev = dol_get_prev_day($day, $month, $year);
				$prev_year  = $prev['year'];
				$prev_month = $prev['month'];
				$prev_day   = $prev['day'];
				$next = dol_get_next_day($day, $month, $year);
				$next_year  = $next['year'];
				$next_month = $next['month'];
				$next_day   = $next['day'];

				// Define firstdaytoshow and lastdaytoshow (warning: lastdaytoshow is last second to show + 1)
				$firstdaytoshow = dol_mktime(0, 0, 0, $prev_month, $prev_day, $prev_year);
				$lastdaytoshow = dol_mktime(0, 0, 0, $next_month, $next_day, $next_year);
			}
			//print 'xx'.$prev_year.'-'.$prev_month.'-'.$prev_day;
			//print 'xx'.$next_year.'-'.$next_month.'-'.$next_day;
			//print dol_print_date($firstdaytoshow,'day');
			//print dol_print_date($lastdaytoshow,'day');

			$title = $langs->trans("DoneAndToDoActions");
			if ($status == 'done') {
				$title = $langs->trans("DoneActions");
			}
			if ($status == 'todo') {
				$title = $langs->trans("ToDoActions");
			}

			$param = '';
			if ($actioncode || isset($_GET['search_actioncode']) || isset($_POST['search_actioncode'])) {
				if (is_array($actioncode)) {
					foreach ($actioncode as $str_action) {
						$param .= "&search_actioncode[]=" . urlencode($str_action);
					}
				} else {
					$param .= '&search_actioncode=' . urlencode($actioncode);
				}
			}
			if ($resourceid > 0) {
				$param .= "&search_resourceid=" . urlencode($resourceid);
			}
			if ($status || isset($_GET['status']) || isset($_POST['status'])) {
				$param .= '&search_status=' . urlencode($status);
			}
			if ($filter) {
				$param .= "&search_filter=" . urlencode($filter);
			}
			if ($filtert) {
				$param .= "&search_filtert=" . urlencode($filtert);
			}
			if ($usergroup) {
				$param .= "&search_usergroup=" . urlencode($usergroup);
			}
			if ($socid) {
				$param .= "&search_socid=" . urlencode($socid);
			}
			if ($showbirthday) {
				$param .= "&search_showbirthday=1";
			}
			if ($pid) {
				$param .= "&search_projectid=" . urlencode($pid);
			}
			if ($type) {
				$param .= "&search_type=" . urlencode($type);
			}
			if ($mode == 'show_day' || $mode == 'show_week' || $mode == 'show_month') {
				$param .= '&mode=' . urlencode($mode);
			}
			$param .= "&maxprint=" . urlencode($maxprint);

			// Show navigation bar
			if (empty($mode) || $mode == 'show_month') {
				$nav = '<a href="?year=' . $prev_year . '&amp;month=' . $prev_month . $param . '"><i class="fa fa-chevron-left"></i></a> &nbsp;' . PHP_EOL;
				$nav .= '<span id="month_name">' . dol_print_date(dol_mktime(0, 0, 0, $month, 1, $year), "%b %Y");
				$nav .= '</span>' . PHP_EOL;
				$nav .= " &nbsp; <a href=\"?year=" . $next_year . "&amp;month=" . $next_month . $param . '"><i class="fa fa-chevron-right"></i></a>' . PHP_EOL;
				$nav .= " &nbsp; (<a href=\"?year=" . $nowyear . "&amp;month=" . $nowmonth . $param . "\">" . $langs->trans("Today") . '</a>)';
				$picto = 'calendar';
			}
			if ($mode == 'show_week') {
				$nav = "<a href=\"?year=" . $prev_year . "&amp;month=" . $prev_month . "&amp;day=" . $prev_day . $param . "\"><i class=\"fa fa-chevron-left\" title=\"" . dol_escape_htmltag($langs->trans("Previous")) . "\"></i></a> &nbsp;\n";
				$nav .= "<span id=\"month_name\">" . dol_print_date(dol_mktime(0, 0, 0, $first_month, $first_day, $first_year), "%Y") . ", " . $langs->trans("Week") . " " . $week;
				$nav .= "</span>\n";
				$nav .= " &nbsp; ";
				$nav .= "<a href=\"?year=" . $next_year . "&amp;month=" . $next_month . "&amp;day=" . $next_day . $param . "\">";
				$nav .= '<i class="fa fa-chevron-right" title="' . dol_escape_htmltag($langs->trans("Next")) . '"></i>';
				$nav .= '</a>' . PHP_EOL;
				$nav .= " &nbsp; (<a href=\"?year=" . $nowyear . "&amp;month=" . $nowmonth . "&amp;day=" . $nowday . $param . "\">" . $langs->trans("Today") . "</a>)";
				$picto = 'calendarweek';
			}
			if ($mode == 'show_day') {
				$nav = "<a href=\"?year=" . $prev_year . "&amp;month=" . $prev_month . "&amp;day=" . $prev_day . $param . "\"><i class=\"fa fa-chevron-left\"></i></a> &nbsp;\n";
				$nav .= " <span id=\"month_name\">" . dol_print_date(dol_mktime(0, 0, 0, $month, $day, $year), "daytextshort");
				$nav .= " </span>\n";
				$nav .= " &nbsp; <a href=\"?year=" . $next_year . "&amp;month=" . $next_month . "&amp;day=" . $next_day . $param . "\"><i class=\"fa fa-chevron-right\"></i></a>\n";
				$nav .= " &nbsp; (<a href=\"?year=" . $nowyear . "&amp;month=" . $nowmonth . "&amp;day=" . $nowday . $param . "\">" . $langs->trans("Today") . "</a>)";
				$picto = 'calendarday';
			}

			// Must be after the nav definition
			$param .= '&year=' . $year . '&month=' . $month . ($day ? '&day=' . $day : '');
			//print 'x'.$param;

			$defaultview = (empty($conf->global->AGENDA_DEFAULT_VIEW) ? 'show_month' : $conf->global->AGENDA_DEFAULT_VIEW);
			$defaultview = (empty($user->conf->AGENDA_DEFAULT_VIEW) ? $defaultview : $user->conf->AGENDA_DEFAULT_VIEW);
			// if (empty($mode) && !GETPOSTISSET('mode')) {
			// 	$mode = $defaultview;
			// }
			// if ($mode == 'default') {	// When action is default, we want a calendar view and not the list
			// 	$mode = (($defaultview != 'show_list') ? $defaultview : 'show_month');
			// }
			// $defaultview = 'month';
			// dayGridMonth timeGridWeek timeGridDay listWeek resourceTimeGridWeek resourceTimelineWeek
			if ($mode == 'show_day') {
				$ecview = 'timeGridDay';
			} elseif ($mode == 'show_month') {
				$ecview = 'dayGridMonth';
			} elseif ($mode == 'show_week') {
				$ecview = 'timeGridWeek';
			} else {
				$ecview = 'listWeek';
			}
			$firstday = getDolGlobalInt('MAIN_START_WEEK', 1);

			$paramnoaction = preg_replace('/action=[a-z_]+/', '', $param);

			$head = calendars_prepare_head($paramnoaction);

			//print '<form method="POST" id="searchFormList" class="listactionsfilter" action="'.$_SERVER["PHP_SELF"].'">'."\n";
			//if ($optioncss != '') print '<input type="hidden" name="optioncss" value="'.$optioncss.'">';
			//print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'">';

			print dol_get_fiche_head($head, 'idreamanewcalendar', $langs->trans('Agenda'), 0, 'action');
			//print $this->getPrintActionsFilter($form, $canedit, $status, $year, $month, $day, $showbirthday, 0, $filtert, 0, $pid, $socid, $mode, $listofextcals, $actioncode, $usergroup, '', $resourceid);

			// Define the legend/list of calendard to show
			$s = '';
			$link = '';
			$showextcals = $listofextcals;

			// $s.="\n".'<!-- Div to calendars selectors -->'."\n";
			// $s.='<script type="text/javascript">' . "\n";
			// $s.='jQuery(document).ready(function () {' . "\n";
			// $s.='jQuery("#check_birthday").click(function() { console.log("Toggle birthday"); jQuery(".family_birthday").toggle(); });' . "\n";
			// $s.='jQuery(".family_birthday").toggle();' . "\n";
			// if ($mode=="show_week" || $mode=="show_month" || empty($mode)) {
			//     // Code to enable drag and drop
			//     $s.='jQuery( "div.sortable" ).sortable({connectWith: ".sortable", placeholder: "ui-state-highlight", items: "div.movable", receive: function( event, ui ) {'."\n";
			//     // Code to submit form
			//     $s.='console.log("submit form to record new event");'."\n";
			//     //$s.='console.log(event.target);';
			//     $s.='var newval = jQuery(event.target).closest("div.dayevent").attr("id");'."\n";
			//     $s.='console.log("found parent div.dayevent with id = "+newval);'."\n";
			//     $s.='var frm=jQuery("#searchFormList");'."\n";
			//     $s.='var newurl = ui.item.find("a.cal_event").attr("href");'."\n";
			//     $s.='console.log(newurl);'."\n";
			//     $s.='frm.attr("action", newurl).children("#newdate").val(newval);frm.submit();}'."\n";
			//     $s.='});'."\n";
			// }
			// $s.='});' . "\n";
			// $s.='</script>' . "\n";

			// // Local calendar
			// $s.='<div class="nowrap clear inline-block minheight20"><input type="checkbox" id="check_mytasks" name="check_mytasks" checked disabled> ' . $langs->trans("LocalAgenda").' &nbsp; </div>';

			// // External calendars
			// if (is_array($showextcals) && count($showextcals) > 0) {
			//     $s.='<script type="text/javascript">' . "\n";
			//     $s.='jQuery(document).ready(function () {
			//             jQuery("table input[name^=\"check_ext\"]").click(function() {
			//                 var name = $(this).attr("name");
			//                 jQuery(".family_ext" + name.replace("check_ext", "")).toggle();
			//             });
			//         });' . "\n";
			//     $s.='</script>' . "\n";

			//     foreach ($showextcals as $val) {
			//         $htmlname = md5($val['name']);
			//         $s.='<div class="nowrap inline-block"><input type="checkbox" id="check_ext' . $htmlname . '" name="check_ext' . $htmlname . '" checked> ' . $val['name'] . ' &nbsp; </div>';
			//     }
			// }

			// // Birthdays
			// $s .= '<div class="nowrap inline-block"><input type="checkbox" id="check_birthday" name="check_birthday"> '.$langs->trans("AgendaShowBirthdayEvents").' &nbsp; </div>';

			// // Calendars from hooks
			// $parameters2 = array();
			// $objectnull=null;
			// $reshook = $hookmanager->executeHooks('addCalendarChoice', $parameters2, $objectnull, $mode);
			// if (empty($reshook)) {
			//     $s.= $hookmanager->resPrint;
			// } elseif ($reshook > 1) {
			//     $s = $hookmanager->resPrint;
			// }
			//print load_fiche_titre($s, $link.' &nbsp; &nbsp; '.$nav, '', 0, 0, 'tablelistofcalendars');

			$preselectedeventtypes = explode(',', getDolGlobalString('AGENDA_DEFAULT_FILTER_TYPE'));
			$selecteds = [];
			foreach ($preselectedeventtypes as $type) {
				$selecteds[] = "'" . $type . "'";
			}
			$preselect = implode(',', $selecteds);


			print '
			<div id="menu">
				<span id="search-all" class="search-all">
					<input class="form-control searchAll" type="text" placeholder="' . $langs->trans('Divers') . '" autocomplete="off">
				</span>
				<span id="search-users" class="search-users">
					<input class="form-control usersAutoComplete" type="text" placeholder="' . $langs->trans('User') . '" autocomplete="off">
				</span>
				<span id="clear-search-user" class="search-clear">
					<button type="button" class="btn btn-default btn-sm search-clear" data-action="clear-search-user">
						<i class="calendar-icon ic-arrow-cancel" data-action="clear-search-user"></i>
					</button>
				</span>';

			if (!empty($conf->societe->enabled) && !empty($user->rights->societe->lire)) {
				print '<span id="search-customers" class="search-customers">';
				print '    <input class="form-control customersAutoComplete" type="text" placeholder="' . $langs->trans('ThirdParty') . '" autocomplete="off">';
				print '</span>';
				print '<span id="search-states" class="search-states">';
				print '    <select class="statesAutoComplete" multiple type="text" title="' . $langs->trans('StateShort') . '"></select>';
				print '</span>';
			}
			if (isModEnabled('projet') && !empty($user->rights->projet->lire)) {
				print '<span id="search-projects" class="search-projects">';
				print '    <input class="form-control projectsAutoComplete" type="text" placeholder="' . $langs->trans("Project") . '" autocomplete="off">';
				print '    <input id="project_id" name="project_id" type="hidden">';
				print '</span>';
			}
			// select types events
			print '
				<span id="search-actioncode" class="search-actioncode">
					<select class="actioncodeAutoComplete" multiple type="text" title="' . $langs->trans('ActionType') . '"></select>
				</span>
			</div>';
			// CALENDAR
			print '<div id="ec" style="height: 800px;"></div>';
			?>
			<div class="row">
				<div id="ec" class="col"></div>
			</div>
			<script>
				const token = '<?php echo newToken(); ?>';
				const buttonText = {
					today: '<?php echo dol_escape_js($langs->transnoentities('Today')); ?>',
					dayGridMonth: '<?php echo dol_escape_js($langs->transnoentities('ViewCal')); ?>',
					timeGridWeek: '<?php echo dol_escape_js($langs->transnoentities('ViewWeek')); ?>',
					timeGridDay: '<?php echo dol_escape_js($langs->transnoentities('ViewDay')); ?>',
					listWeek: '<?php echo dol_escape_js($langs->transnoentities('ListWeek')); ?>',
					close: '<?php echo dol_escape_js($langs->transnoentities('Close')); ?>',
					prev: '<?php echo dol_escape_js($langs->transnoentities("Previous")); ?>',
					next: '<?php echo dol_escape_js($langs->transnoentities("Next")); ?>',
				}
				let CalendarList = [];
				async function generateCalendarList() {
					try {
						const res = await fetch('<?php echo dol_buildpath('/idreamanewcalendar/core/ajax/ajax_events.php', 1); ?>?action=getcalendars', {
							headers: {
								 "Content-Type": "application/json; charset=utf-8"
							}
						});
						if (!res.ok) {
							throw new Error(`Erreur HTTP : ${res.status}`);
						}
						const response = await res.text();
						// check json response
						try {
							return JSON.parse(response);
						} catch (e) {
							throw new Error("La réponse n'est pas un JSON valide.");
						}
					} catch (error) {
						console.error("Erreur lors de la récupération des calendriers :", error);
						throw error; // Propager l'erreur pour une gestion ultérieure
					}
				}
				async function afficherCalendriers() {
					try {
						var html = [];
						const calendarSelectList = document.getElementById('calendarSelectList');
						const calendars = await generateCalendarList();
						calendars.forEach(function(calendar) {
							console.log(calendar);
							CalendarList.push(calendar);
							html.push('<div class=\"lnb-calendars-item\"><label>' +
								'<input type=\"checkbox\" class=\"ec-calendar-checkbox-round\" value=\"' + calendar.calendarId + '\" checked>' +
								'<span style=\"border-color: ' + calendar.color + '; background-color: ' + calendar.color + ';\"></span>' +
								'<span>' + calendar.name + '</span>' +
								'</label></div>'
							);
						});
						calendarSelectList.innerHTML = html.join('\n');
					} catch (error) {
						console.error("Impossible de récupérer les calendriers :", error);
					}
				}
				afficherCalendriers();
				setEventListener();
				const ec = EventCalendar.create(document.getElementById('ec'), {
					view: '<?php echo $ecview; ?>',
					firstDay: <?php echo $firstday; ?>,
					headerToolbar: {
						start: 'prev,next today',
						center: 'title',
						end: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
					},
					buttonText: {
						...buttonText
					},
					resources: [{
							id: 1,
							title: 'Dolibarr'
						},
						{
							id: 2,
							title: 'Birthdays'
						}
					],
					scrollTime: '09:00:00',
					eventSources: [{
							events: function(fetchInfo, successCallback, failureCallback) {
								$.ajax({
									method: 'GET',
									url: '<?php echo dol_buildpath('/idreamanewcalendar/core/ajax/ajax_events.php', 1); ?>',
									dataType: 'json',
									data: {
										start: fetchInfo.start.getTime(),
										// startStr: fetchInfo.startStr,
										end: fetchInfo.end.getTime(),
										// endStr: fetchInfo.endStr,
										action: 'getevents',
										resourceId: 1,
										token: token
									},
									success: function(response) {
										// normalize entries
										successCallback(response);
									}
								});
							}
						},
						{
							events: function(fetchInfo, successCallback, failureCallback) {
								$.ajax({
									method: 'GET',
									url: '<?php echo dol_buildpath('/idreamanewcalendar/core/ajax/ajax_events.php', 1); ?>',
									dataType: 'json',
									data: {
										start: fetchInfo.start.getTime(),
										// startStr: fetchInfo.startStr,
										end: fetchInfo.end.getTime(),
										// endStr: fetchInfo.endStr,
										action: 'getevents',
										resourceId: 2,
										token: token
									},
									success: function(response) {
										// normalize entries
										successCallback(response);
									}
								});
							}
						}
					],
					views: {
						timeGridWeek: {
							pointer: true,
							slotMinTime: '08:00',
							slotMaxTime: '22:00'
						},
						resourceTimeGridWeek: {
							pointer: true
						},
						resourceTimelineWeek: {
							slotDuration: '00:15',
							slotLabelInterval: '01:00',
							slotMinTime: '09:00',
							slotMaxTime: '21:00',
							slotWidth: 16,
							resources: [{
									id: 1,
									title: 'Resource A'
								},
								{
									id: 2,
									title: 'Resource B'
								},
								{
									id: 3,
									title: 'Resource C'
								},
								{
									id: 9,
									title: 'Resource I',
									children: [{
											id: 10,
											title: 'Resource J'
										},
										{
											id: 11,
											title: 'Resource K'
										},
										{
											id: 12,
											title: 'Resource L',
											children: [{
													id: 13,
													title: 'Resource M'
												},
												{
													id: 14,
													title: 'Resource N'
												}
											]
										}
									]
								}
							]
						}
					},
					dayMaxEvents: true,
					nowIndicator: true,
					selectable: true,
					eventResizeStart: function(info) {
						console.log('eventResizeStart');
					},
					eventResizeStop: function(info) {
						console.log('eventResizeStop');
					},
					eventResize: function(info) {
						console.log('eventResize');
						console.log(info);
					},
					eventDragStart: function(info) {
						console.log('eventDragStart');
					},
					eventDragStop: function(info) {
						console.log('eventDragStop');
					},
					eventDrop: function(info) {
						console.log('eventDrop');
						console.log(info);
					}
				});
				function setEventListener() {
					$('#lnb-calendars').on('change', onChangeCalendars);
				}
				function onChangeCalendars(e) {
					var calendarId = e.target.value;
					var checked = e.target.checked;
					var viewAll = document.querySelector('.lnb-calendars-item input');
					var calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarSelectList input'));
					var allCheckedCalendars = true;
					console.log(calendarId);
					if (calendarId === 'all') {
						allCheckedCalendars = checked;

						calendarElements.forEach(function(input) {
							var span = input.parentNode;
							input.checked = checked;
							span.style.backgroundColor = checked ? span.style.borderColor : 'transparent';
						});

						CalendarList.forEach(function(calendar) {
							calendar.checked = checked;
							//calendar.timer = ...
						});
					} else {
						findCalendar(calendarId).checked = checked;

						allCheckedCalendars = calendarElements.every(function(input) {
							return input.checked;
						});

						if (allCheckedCalendars) {
							viewAll.checked = true;
						} else {
							viewAll.checked = false;
							//clearInterval(calendar.timer);
						}
					}

					refreshScheduleVisibility();
				}
				function findCalendar(id) {
					var found;
					CalendarList.forEach(function(calendar) {
						if (calendar.id === id) {
							found = calendar;
						}
					});

					return found || CalendarList[0];
				}
				function refreshScheduleVisibility() {
					var calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarSelectList input'));

					//CalendarList.forEach(function(calendar) {
						//cal.toggleSchedules(calendar.id, !calendar.checked, false);
						// if (!calendar.checked) {
						//     console.log('clearing timer for calendar ' + calendar.id);
						//     clearInterval(calendar.timer);
						// } else {
						//     console.log('activate timer for calendar ' + calendar.id);
						//     calendar.timer = setInterval(function() {
						//         console.log('updating calendar ' + calendar.id);
						//     }, 5000);
						// }
					//});

					//cal.render(true);

					calendarElements.forEach(function(input) {
						var span = input.nextElementSibling;
						span.style.backgroundColor = input.checked ? span.style.borderColor : 'transparent';
					});
				}
			</script>
			<?php
			//print dol_get_fiche_end();
			// End of page
			llxFooter();
			$this->db->close();
			// we stop here, we don't want dolibarr calendar
			exit;
			return 0;
		}

		return 0; // or return 1 to replace standard code
	}

	/**
	 * Show filter form in agenda view
	 *
	 * @param   Object          $form           Form object
	 * @param   int             $canedit        Can edit filter fields
	 * @param   int             $status         Status
	 * @param   int             $year           Year
	 * @param   int             $month          Month
	 * @param   int             $day            Day
	 * @param   int             $showbirthday   Show birthday
	 * @param   string          $filtera        Filter on create by user
	 * @param   string          $filtert        Filter on assigned to user
	 * @param   string          $filterd        Filter of done by user
	 * @param   int             $pid            Product id
	 * @param   int             $socid          Third party id
	 * @param   string          $action         Action string
	 * @param   array           $showextcals    Array with list of external calendars (used to show links to select calendar), or -1 to show no legend
	 * @param   string|array    $actioncode     Preselected value(s) of actioncode for filter on event type
	 * @param   int             $usergroupid    Id of group to filter on users
	 * @param   string          $excludetype    A type to exclude ('systemauto', 'system', '')
	 * @param   int             $resourceid     Preselected value of resource for filter on resource
	 * @return  string                          html
	 */
	private function getPrintActionsFilter($form, $canedit, $status, $year, $month, $day, $showbirthday, $filtera, $filtert, $filterd, $pid, $socid, $action, $showextcals = [], $actioncode = '', $usergroupid = '', $excludetype = '', $resourceid = 0)
	{
		global $conf, $user, $langs, $db, $hookmanager;
		global $begin_h, $end_h, $begin_d, $end_d;

		$langs->load("companies");

		include_once DOL_DOCUMENT_ROOT . '/core/class/html.formactions.class.php';
		$formactions = new FormActions($db);

		// Filters
		//print '<form name="listactionsfilter" class="listactionsfilter" action="' . $_SERVER["PHP_SELF"] . '" method="get">';
		$html = '<input type="hidden" name="token" value="' . $_SESSION['newtoken'] . '">';
		$html .= '<input type="hidden" name="year" value="' . $year . '">';
		$html .= '<input type="hidden" name="month" value="' . $month . '">';
		$html .= '<input type="hidden" name="day" value="' . $day . '">';
		$html .= '<input type="hidden" name="action" value="' . $mode . '">';
		$html .= '<input type="hidden" name="search_showbirthday" value="' . $showbirthday . '">';

		$html .= '<div class="fichecenter">';

		if ($conf->browser->layout == 'phone') {
			$html .= '<div class="fichehalfleft">';
		} else {
			$html .= '<table class="nobordernopadding" width="100%"><tr><td class="borderright">';
		}

		$html .= '<table class="nobordernopadding centpercent">';

		if ($canedit) {
			$html .= '<tr>';
			$html .= '<td class="nowrap" style="padding-bottom: 2px; padding-right: 4px;">';
			$html .= $langs->trans("ActionsToDoBy") . ' &nbsp; ';
			$html .= '</td><td style="padding-bottom: 2px; padding-right: 4px;">';
			$html .= $form->select_dolusers($filtert, 'search_filtert', 1, '', !$canedit, '', '', 0, 0, 0, '', 0, '', 'maxwidth300');
			if (empty($conf->dol_optimize_smallscreen)) {
				$html .= ' &nbsp; ' . $langs->trans("or") . ' ' . $langs->trans("ToUserOfGroup") . ' &nbsp; ';
			}
			$html .= $form->select_dolgroups($usergroupid, 'usergroup', 1, '', !$canedit);
			$html .= '</td></tr>';

			if ($conf->resource->enabled) {
				include_once DOL_DOCUMENT_ROOT . '/resource/class/html.formresource.class.php';
				$formresource = new FormResource($db);

				// Resource
				$html .= '<tr>';
				$html .= '<td class="nowrap" style="padding-bottom: 2px; padding-right: 4px;">';
				$html .= $langs->trans("Resource");
				$html .= ' &nbsp;</td><td class="nowrap maxwidthonsmartphone" style="padding-bottom: 2px; padding-right: 4px;">';
				$html .= $formresource->select_resource_list($resourceid, "search_resourceid", '', 1, 0, 0, null, '', 2);
				$html .= '</td></tr>';
			}

			// Type
			$html .= '<tr>';
			$html .= '<td class="nowrap" style="padding-bottom: 2px; padding-right: 4px;">';
			$html .= $langs->trans("Type");
			$html .= ' &nbsp;</td><td class="nowrap" style="padding-bottom: 2px; padding-right: 4px;">';
			$multiselect = 0;
			if (!empty($conf->global->MAIN_ENABLE_MULTISELECT_TYPE)) {
				// We use an option here because it adds bugs when used on agenda page "peruser" and "list"
				$multiselect = (!empty($conf->global->AGENDA_USE_EVENT_TYPE));
			}
			$html .=  $formactions->select_type_actions($actioncode, "search_actioncode", $excludetype, (empty($conf->global->AGENDA_USE_EVENT_TYPE) ? 1 : -1), 0, $multiselect, 1);
			$html .=  '</td></tr>';
		}

		// if (! empty($conf->societe->enabled) && $user->rights->societe->lire) {
		//     $html .= '<tr>';
		//     $html .= '<td class="nowrap" style="padding-bottom: 2px; padding-right: 4px;">';
		//     $html .= $langs->trans("ThirdParty").' &nbsp; ';
		//     $html .= '</td><td class="nowrap" style="padding-bottom: 2px;">';
		//     $html .= $form->select_company($socid, 'search_socid', '', 'SelectThirdParty', 0, 0, null, 0);
		//     $html .= '</td></tr>';
		// }

		if (!empty($conf->projet->enabled) && $user->rights->projet->lire) {
			require_once DOL_DOCUMENT_ROOT . '/core/class/html.formprojet.class.php';
			$formproject = new FormProjets($db);

			$html .= '<tr>';
			$html .= '<td class="nowrap" style="padding-bottom: 2px;">';
			$html .= $langs->trans("Project") . ' &nbsp; ';
			$html .= '</td><td class="nowrap" style="padding-bottom: 2px;">';
			$html .= $formproject->select_projects($socid ? $socid : -1, $pid, 'search_projectid', 0, 0, 1, 0, 0, 0, 0, '', 1, 0, 'maxwidth500');
			$html .= '</td></tr>';
		}

		if ($canedit && !preg_match('/list/', $_SERVER["PHP_SELF"])) {
			// Status
			$html .= '<tr>';
			$html .= '<td class="nowrap" style="padding-bottom: 2px; padding-right: 4px;">';
			$html .= $langs->trans("Status");
			$html .= ' &nbsp;</td><td class="nowrap" style="padding-bottom: 2px; padding-right: 4px;">';
			$html .= $this->formSelectStatusAction('formaction', $status, 1, 'search_status', 1, 2, 'minwidth100', 1, 1);
			$html .= '</td></tr>';
		}

		if ($canedit && $mode == 'show_peruser') {
			// Filter on hours
			$html .= '<tr>';
			$html .= '<td class="nowrap" style="padding-bottom: 2px; padding-right: 4px;">' . $langs->trans("VisibleTimeRange") . '</td>';
			$html .= "<td class='nowrap'>";
			$html .= '<div class="ui-grid-a"><div class="ui-block-a">';
			$html .= '<input type="number" class="short" name="begin_h" value="' . $begin_h . '" min="0" max="23">';
			if (empty($conf->dol_use_jmobile)) {
				$html .= ' - ';
			} else {
				$html .= '</div><div class="ui-block-b">';
			}
			$html .= '<input type="number" class="short" name="end_h" value="' . $end_h . '" min="1" max="24">';
			if (empty($conf->dol_use_jmobile)) {
				$html .= ' ' . $langs->trans("H");
			}
			$html .= '</div></div>';
			$html .= '</td></tr>';

			// Filter on days
			$html .= '<tr>';
			$html .= '<td class="nowrap">' . $langs->trans("VisibleDaysRange") . '</td>';
			$html .= "<td class='nowrap'>";
			$html .= '<div class="ui-grid-a"><div class="ui-block-a">';
			$html .= '<input type="number" class="short" name="begin_d" value="' . $begin_d . '" min="1" max="7">';
			if (empty($conf->dol_use_jmobile)) {
				$html .= ' - ';
			} else {
				$html .= '</div><div class="ui-block-b">';
			}
			$html .= '<input type="number" class="short" name="end_d" value="' . $end_d . '" min="1" max="7">';
			$html .= '</div></div>';
			$html .= '</td></tr>';
		}

		// Hooks
		$parameters = [
			'canedit' => $canedit,
			'pid' => $pid,
			'socid' => $socid,
		];
		$reshook = $hookmanager->executeHooks('searchAgendaFrom', $parameters, $object, $action); // Note that $action and $object may have been

		$html .= '</table>';

		if ($conf->browser->layout == 'phone') {
			$html .= '</div>';
		} else {
			$html .= '</td>';
		}

		if ($conf->browser->layout == 'phone') {
			$html .= '<div class="fichehalfright">';
		} else {
			$html .= '<td align="center" valign="middle" class="nowrap">';
		}

		$html .= '<table class="centpercent"><tr><td align="center">';
		$html .= '<div class="formleftzone">';
		$html .= '<input type="submit" class="button" style="min-width:120px" name="refresh" value="' . $langs->trans("Refresh") . '">';
		$html .= '</div>';
		$html .= '</td></tr>';
		$html .= '</table>';

		if ($conf->browser->layout == 'phone') {
			$html .= '</div>';
		} else {
			$html .= '</td></tr></table>';
		}

		$html .= '</div>';  // Close fichecenter
		$html .= '<div style="clear:both"></div>';

		//$html .= '</form>';
		return $html;
	}

	/**
	 *  Show list of action status
	 *
	 *  @param  string  $formname       Name of form where select is included
	 *  @param  string  $selected       Preselected value (-1..100)
	 *  @param  int     $canedit        1=can edit, 0=read only
	 *  @param  string  $htmlname       Name of html prefix for html fields (selectX and valX)
	 *  @param  integer $showempty      Show an empty line if select is used
	 *  @param  integer $onlyselect     0=Standard, 1=Hide percent of completion and force usage of a select list, 2=Same than 1 and add "Incomplete (Todo+Running)
	 *  @param  string  $morecss        More css on select field
	 *  @param  int     $nooutput       1 return in string, 0 direct output
	 *  @return void
	 */
	public function formSelectStatusAction($formname, $selected, $canedit = 1, $htmlname = 'complete', $showempty = 0, $onlyselect = 0, $morecss = 'maxwidth100', $nooutput = 0)
	{
		// phpcs:enable
		global $langs, $conf;

		$listofstatus = [
			'-1' => $langs->trans("ActionNotApplicable"),
			'0' => $langs->trans("ActionsToDoShort"),
			'50' => $langs->trans("ActionRunningShort"),
			'100' => $langs->trans("ActionDoneShort")
		];
		$out = '';
		// +ActionUncomplete

		if (!empty($conf->use_javascript_ajax)) {
			$out .= "\n";
			$out .= "<script type=\"text/javascript\">
				var htmlname = '" . $htmlname . "';

				$(document).ready(function () {
					select_status();

					$('#select' + htmlname).change(function() {
						select_status();
					});
					// FIXME use another method for update combobox
					//$('#val' + htmlname).change(function() {
						//select_status();
					//});
				});

				function select_status() {
					var defaultvalue = $('#select' + htmlname).val();
					var percentage = $('input[name=percentage]');
					var selected = '" . (isset($selected) ? $selected : '') . "';
					var value = (selected>0?selected:(defaultvalue>=0?defaultvalue:''));

					percentage.val(value);

					if (defaultvalue == -1) {
						percentage.prop('disabled', true);
						$('.hideifna').hide();
					}
					else if (defaultvalue == 0) {
						percentage.val(0);
						percentage.removeAttr('disabled'); /* Not disabled, we want to change it to higher value */
						$('.hideifna').show();
					}
					else if (defaultvalue == 100) {
						percentage.val(100);
						percentage.prop('disabled', true);
						$('.hideifna').show();
					}
					else {
						if (defaultvalue == 50 && (percentage.val() == 0 || percentage.val() == 100)) { percentage.val(50) };
						percentage.removeAttr('disabled');
						$('.hideifna').show();
					}
				}
				</script>\n";
		}
		if (!empty($conf->use_javascript_ajax) || $onlyselect) {
			//var_dump($selected);
			if ($selected == 'done') {
				$selected = '100';
			}
			$out .= '<select ' . ($canedit ? '' : 'disabled ') . 'name="' . $htmlname . '" id="select' . $htmlname . '" class="flat' . ($morecss ? ' ' . $morecss : '') . '">';
			if ($showempty) {
				$out .= '<option value=""' . ($selected == '' ? ' selected' : '') . '></option>';
			}
			foreach ($listofstatus as $key => $val) {
				$out .= '<option value="' . $key . '"' . (($selected == $key && strlen($selected) == strlen($key)) || (($selected > 0 && $selected < 100) && $key == '50') ? ' selected' : '') . '>' . $val . '</option>';
				if ($key == '50' && $onlyselect == 2) {
					$out .= '<option value="todo"' . ($selected == 'todo' ? ' selected' : '') . '>';
					$out .= $langs->trans("ActionUncomplete") . ' (' . $langs->trans("ActionsToDoShort") . "+" . $langs->trans("ActionRunningShort") . ')</option>';
				}
			}
			$out .= '</select>';
			if ($selected == 0 || $selected == 100) {
				$canedit = 0;
			}

			if (empty($onlyselect)) {
				$out .= ' <input type="text" id="val' . $htmlname . '" name="percentage" class="flat hideifna" value="' . ($selected >= 0 ? $selected : '') . '" size="2"' . ($canedit && ($selected >= 0) ? '' : ' disabled') . '>';
				$out .= '<span class="hideonsmartphone hideifna">%</span>';
			}
		} else {
			$out .= ' <input type="text" id="val' . $htmlname . '" name="percentage" class="flat" value="' . ($selected >= 0 ? $selected : '') . '" size="2"' . ($canedit ? '' : ' disabled') . '>%';
		}
		if (!empty($nooutput)) {
			return $out;
		}
		print $out;
	}

	/**
	 * Overloading the doActions function : replacing the parent's function with the one below
	 *
	 * @param   array           $parameters     Hook metadatas (context, etc...)
	 * @param   CommonObject    $object         The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param   string          $action         Current action (if set). Generally create or edit or null
	 * @param   HookManager     $hookmanager    Hook manager propagated to allow calling another hook
	 * @return  int                             < 0 on error, 0 on success, 1 to replace standard code
	 */
	public function printLeftBlock($parameters, &$object, &$action, $hookmanager)
	{
		global $conf, $user, $langs;

		$error = 0; // Error counter
		$this->results = [];
		$this->resprints = '';
		$langs->load('commercial');

		//echo "action: " . $action;
		// calendar
		if (in_array($parameters['currentcontext'], ['agenda']) && basename($_SERVER['PHP_SELF']) == 'index.php') {
			// $this->resprints = '
			// <div class="vmenu lnb-new-schedule">
			// 	<button id="btn-new-schedule" type="button" class="btn btn-default btn-block lnb-new-schedule-btn" data-toggle="modal">
			// 	' . $langs->trans('AddAction') . '</button>
			// </div>';
			$this->resprints = '
			<div id="lnb-calendars" class="vmenu lnb-calendars">
				<div>
					<div class="lnb-calendars-item">
						<label>
							<input class="ec-calendar-checkbox-square" type="checkbox" value="all" checked>
							<span></span>
							<strong>' . $langs->trans('IDreamANewCalendarViewAll') . '</strong>
						</label>
					</div>
				</div>
				<div id="calendarSelectList" class="lnb-calendars-d1">
				</div>
			</div>';
		}
		// per user calendar
		if (in_array($parameters['currentcontext'], ['agenda']) && basename($_SERVER['PHP_SELF']) == 'per_user.php') {
			// nothing for the moment
		}
		if (!$error) {
			return 0; // or return 1 to replace standard code
		} else {
			$this->errors[] = 'Error message';
			return -1;
		}
	}


	/**
	 * Overloading the addMoreMassActions function : replacing the parent's function with the one below
	 *
	 * @param   array           $parameters     Hook metadatas (context, etc...)
	 * @param   CommonObject    $object         The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param   string          $action         Current action (if set). Generally create or edit or null
	 * @param   HookManager     $hookmanager    Hook manager propagated to allow calling another hook
	 * @return  int                             < 0 on error, 0 on success, 1 to replace standard code
	 */
	public function addMoreMassActions($parameters, &$object, &$action, $hookmanager)
	{
		global $conf, $user, $langs;

		$error = 0; // Error counter

		/* print_r($parameters); print_r($object); echo "action: " . $action; */
		// if (in_array($parameters['currentcontext'], array('somecontext1','somecontext2'))){
		//     // do something only for the context 'somecontext1' or 'somecontext2'
		//     $this->resprints = '<option value="0"'.($disabled?' disabled="disabled"':'').'>'.$langs->trans("IDreamANewCalendarMassAction").'</option>';
		// }

		if (!$error) {
			return 0; // or return 1 to replace standard code
		} else {
			$this->errors[] = 'Error message';
			return -1;
		}
	}
}
