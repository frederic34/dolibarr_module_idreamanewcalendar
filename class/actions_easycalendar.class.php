<?php
/* Copyright © 2019-2023  Frédéric FRANCE   <frederic.france@free.fr>
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

	/**
	 * Overloading the beforeAgendaPerUser function : replacing the parent's function with the one below
	 *
	 * @param   array           $parameters     Hook metadatas (context, etc...)
	 * @param   CommonObject    $object         The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param   string          $action         Current action (if set). Generally create or edit or null
	 * @param   HookManager     $hookmanager    Hook manager propagated to allow calling another hook
	 * @return  int                             < 0 on error, 0 on success, 1 to replace standard code
	 */
	public function beforeAgendaPerUser($parameters, &$object, &$action, $hookmanager)
	{
		global $conf, $user, $langs;

		$error = 0; // Error counter
		$langs->load('idreamanewcalendar@idreamanewcalendar');
		// var_dump($parameters);
		/* print_r($parameters); print_r($object); echo "action: " . $action; */
		if (in_array($parameters['currentcontext'], ['desactivated-agenda'])) {
			if (empty($conf->use_javascript_ajax)) {
				return 0;
			}
			$arrayofjs = [
				'/idreamanewcalendar/node_modules/frappe-gantt/dist/frappe-gantt.js',
			];
			$arrayofcss = [
				'/idreamanewcalendar/node_modules/frappe-gantt/dist/frappe-gantt.css',
				'/idreamanewcalendar/css/icons.css',
				'/idreamanewcalendar/css/idreamanewcalendar.css.php',
			];
			$socid = $parameters['socid'];
			$canedit = $parameters['canedit'];
			$status = $parameters['status'];
			$year = (int) $parameters['year'];
			$month = (int) $parameters['month'];
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

			llxHeader('', $langs->trans("Agenda"), '', '', 0, 0, $arrayofjs, $arrayofcss);

			$param = '';
			if ($actioncode || isset($_GET['search_actioncode']) || isset($_POST['search_actioncode'])) {
				if (is_array($actioncode)) {
					foreach ($actioncode as $str_action) {
						$param .= "&search_actioncode[]=" . urlencode($str_action);
					}
				} else {
					$param .= "&search_actioncode=" . urlencode($actioncode);
				}
			}
			if ($resourceid > 0) {
				$param .= "&search_resourceid=" . urlencode($resourceid);
			}
			if ($status || isset($_GET['status']) || isset($_POST['status'])) {
				$param .= "&search_status=" . urlencode($status);
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
			if ($action == 'show_day' || $action == 'show_week' || $action == 'show_month') {
				$param .= '&action=' . urlencode($action);
			}
			$param .= "&maxprint=" . urlencode($maxprint);

			$paramnoaction = preg_replace('/action=[a-z_]+/', '', $param);

			$head = calendars_prepare_head($paramnoaction);

			print dol_get_fiche_head($head, 'cardperuser', $langs->trans('Agenda'), 0, 'action');
			print '<div id="gantt" style="height: 800px;"></div>';
			print "<script>
			var tasks = [
				{
					id: 'Task 1',
					name: 'Redesign website',
					start: '2019-12-21',
					end: '2019-12-25',
					progress: 30,
					dependencies: null,
					custom_class: 'bar-milestone' // optional
				},
				{
					id: 'Task 2',
					name: 'Redesign backoffice',
					start: '2019-12-28',
					end: '2019-12-31',
					progress: 10,
					dependencies: 'Task 1',
					custom_class: 'bar-milestone' // optional
				}
			]
			var gantt = new Gantt('#gantt', tasks, {
				header_height: 50,
				column_width: 30,
				step: 24,
				view_modes: ['Quarter Day', 'Half Day', 'Day', 'Week', 'Month'],
				bar_height: 20,
				bar_corner_radius: 3,
				arrow_curve: 5,
				padding: 18,
				view_mode: 'Day',
				date_format: 'YYYY-MM-DD',
				custom_popup_html: null
			});
			</script>";

			print dol_get_fiche_end();
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
				'/idreamanewcalendar/js/moment.min.js',
				'/idreamanewcalendar/js/bootstrap.min.js',
				'https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.2.2/dist/latest/bootstrap-autocomplete.min.js',
				'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js',
				'https://uicdn.toast.com/tui.code-snippet/latest/tui-code-snippet.js',
				'https://uicdn.toast.com/tui.dom/v3.0.0/tui-dom.js',
				'https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js',
				'https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js',
				//'https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js',
				//'/idreamanewcalendar/node_modules/tui-code-snippet/dist/tui-code-snippet.min.js',
				//'/idreamanewcalendar/node_modules/tui-dom/dist/tui-dom.min.js',
				//'/idreamanewcalendar/node_modules/tui-time-picker/dist/tui-time-picker.min.js',
				//'/idreamanewcalendar/node_modules/tui-date-picker/dist/tui-date-picker.min.js',
				'/idreamanewcalendar/js/tui-calendar.min.js',
			];
			$arrayofcss = [
				'/idreamanewcalendar/css/bootstrap.min.css',
				'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.css',
				'/idreamanewcalendar/css/icons.css',
				'/idreamanewcalendar/css/idreamanewcalendar.css.php',
				// 'https://uicdn.toast.com/tui-calendar/latest/tui-calendar.css',
				'https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css',
				'https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css',
				'/idreamanewcalendar/css/tui-calendar.min.css',
				//'/idreamanewcalendar/node_modules/tui-time-picker/dist/tui-time-picker.css',
				//'/idreamanewcalendar/node_modules/tui-date-picker/dist/tui-date-picker.css',
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
			$MAXAGENDA = $conf->global->AGENDA_EXT_NB ?? 6;

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
							'offsettz' => (!empty($conf->global->$offsettz) ? $conf->global->$offsettz : 0),
							'color' => $conf->global->$color,
							'buggedfile' => (isset($conf->global->buggedfile) ? $conf->global->buggedfile : 0),
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
							'src' => $user->conf->$source,
							'name' => $user->conf->$name,
							'offsettz' => (!empty($user->conf->$offsettz) ? $user->conf->$offsettz : 0),
							'color' => $user->conf->$color,
							'buggedfile' => (isset($user->conf->buggedfile) ? $user->conf->buggedfile : 0),
						];
					}
				}
			}

			if (empty($action) || $action == 'show_month') {
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
			if ($action == 'show_week') {
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
			if ($action == 'show_day') {
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
			if ($action == 'show_day' || $action == 'show_week' || $action == 'show_month') {
				$param .= '&action=' . urlencode($action);
			}
			$param .= "&maxprint=" . urlencode($maxprint);

			// Show navigation bar
			if (empty($action) || $action == 'show_month') {
				$nav = '<a href="?year=' . $prev_year . '&amp;month=' . $prev_month . $param . '"><i class="fa fa-chevron-left"></i></a> &nbsp;' . PHP_EOL;
				$nav .= '<span id="month_name">' . dol_print_date(dol_mktime(0, 0, 0, $month, 1, $year), "%b %Y");
				$nav .= '</span>' . PHP_EOL;
				$nav .= " &nbsp; <a href=\"?year=" . $next_year . "&amp;month=" . $next_month . $param . '"><i class="fa fa-chevron-right"></i></a>' . PHP_EOL;
				$nav .= " &nbsp; (<a href=\"?year=" . $nowyear . "&amp;month=" . $nowmonth . $param . "\">" . $langs->trans("Today") . '</a>)';
				$picto = 'calendar';
			}
			if ($action == 'show_week') {
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
			if ($action == 'show_day') {
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
			if ($action == 'show_month' || $defaultview == 'show_month') {
				$viewmodedefault = 'month';
			} elseif ($action == 'show_week' || $defaultview == 'show_week') {
				$viewmodedefault = 'week';
			} elseif ($action == 'show_day' || $defaultview == 'show_day') {
				$viewmodedefault = 'day';
			}

			$paramnoaction = preg_replace('/action=[a-z_]+/', '', $param);

			$head = calendars_prepare_head($paramnoaction);

			//print '<form method="POST" id="searchFormList" class="listactionsfilter" action="'.$_SERVER["PHP_SELF"].'">'."\n";
			//if ($optioncss != '') print '<input type="hidden" name="optioncss" value="'.$optioncss.'">';
			//print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'">';

			print dol_get_fiche_head($head, 'idreamanewcalendar', $langs->trans('Agenda'), 0, 'action');
			//print $this->getPrintActionsFilter($form, $canedit, $status, $year, $month, $day, $showbirthday, 0, $filtert, 0, $pid, $socid, $action, $listofextcals, $actioncode, $usergroup, '', $resourceid);

			// Define the legend/list of calendard to show
			$s = '';
			$link = '';
			$showextcals = $listofextcals;

			// $s.="\n".'<!-- Div to calendars selectors -->'."\n";
			// $s.='<script type="text/javascript">' . "\n";
			// $s.='jQuery(document).ready(function () {' . "\n";
			// $s.='jQuery("#check_birthday").click(function() { console.log("Toggle birthday"); jQuery(".family_birthday").toggle(); });' . "\n";
			// $s.='jQuery(".family_birthday").toggle();' . "\n";
			// if ($action=="show_week" || $action=="show_month" || empty($action)) {
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
			// $reshook = $hookmanager->executeHooks('addCalendarChoice', $parameters2, $objectnull, $action);
			// if (empty($reshook)) {
			//     $s.= $hookmanager->resPrint;
			// } elseif ($reshook > 1) {
			//     $s = $hookmanager->resPrint;
			// }
			//print load_fiche_titre($s, $link.' &nbsp; &nbsp; '.$nav, '', 0, 0, 'tablelistofcalendars');

			// https://www.w3schools.com/howto/howto_js_dropdown.asp
			$preselectedeventtypes = explode(',', $conf->global->AGENDA_DEFAULT_FILTER_TYPE ?? '');
			$selecteds = [];
			foreach ($preselectedeventtypes as $type) {
				$selecteds[] = "'" . $type . "'";
			}
			$preselect = implode(',', $selecteds);
			print '
			<div id="menu">
				<span class="dropdown">
					<button id="dropdownMenu-calendarType" class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
						aria-haspopup="true" aria-expanded="true">
						<i id="calendarTypeIcon" class="calendar-icon ic_view_month" style="margin-right: 4px;"></i>
						<span id="calendarTypeName">Dropdown</span>&nbsp;
						<i class="calendar-icon tui-full-calendar-dropdown-arrow"></i>
					</button>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu-calendarType">
						<li role="presentation">
							<a class="dropdown-menu-title" role="menuitem" data-action="toggle-daily">
							<i class="calendar-icon ic_view_day"></i>' . $langs->trans('IDreamANewCalendarDaily') . '</a>
						</li>
						<li role="presentation">
							<a class="dropdown-menu-title" role="menuitem" data-action="toggle-weekly">
							<i class="calendar-icon ic_view_week"></i>' . $langs->trans('IDreamANewCalendarWeekly') . '</a>
						</li>
						<li role="presentation">
							<a class="dropdown-menu-title" role="menuitem" data-action="toggle-monthly">
							<i class="calendar-icon ic_view_month"></i>' . $langs->trans('IDreamANewCalendarMonthly') . '</a>
						</li>
						<li role="presentation">
							<a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks2">
							<i class="calendar-icon ic_view_week"></i>' . $langs->trans('IDreamANewCalendar2weeks') . '</a>
						</li>
						<li role="presentation">
							<a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks3">
							<i class="calendar-icon ic_view_week"></i>' . $langs->trans('IDreamANewCalendar3weeks') . '</a>
						</li>
						<li role="presentation" class="dropdown-divider"></li>
						<li role="presentation">
							<a role="menuitem" data-action="toggle-workweek">
							<input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-workweek" checked>
							<span class="checkbox-title"></span>' . $langs->trans('IDreamANewCalendarShowweekends') . '</a>
						</li>
						<li role="presentation">
							<a role="menuitem" data-action="toggle-start-day-1">
							<input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-start-day-1" checked>
							<span class="checkbox-title"></span>' . $langs->trans('IDreamANewCalendarStartWeekOnMonday') . '</a>
						</li>
						<li role="presentation">
							<a role="menuitem" data-action="toggle-narrow-weekend">
							<input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-narrow-weekend">
							<span class="checkbox-title"></span>' . $langs->trans('IDreamANewCalendarNarrowerThanWeekdays') . '</a>
						</li>
					</ul>
				</span>
				<span id="menu-navi">
					<button type="button" class="btn btn-default btn-sm move-today" data-action="move-today">' . $langs->trans('Today') . '</button>
					<button type="button" class="btn btn-default btn-sm move-day" data-action="move-prev">
						<i class="calendar-icon ic-arrow-line-left" data-action="move-prev"></i>
					</button>
					<button type="button" class="btn btn-default btn-sm move-day" data-action="move-next">
						<i class="calendar-icon ic-arrow-line-right" data-action="move-next"></i>
					</button>
				</span>
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
			if (!empty($conf->projet->enabled) && !empty($user->rights->projet->lire)) {
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
				<span id="renderRange" class="render-range"></span>
			</div>';
			// CALENDAR
			print '<div id="calendar" style="height: 800px;"></div>';
			// réactivation dropdown utilisateur
			print "<script>
				$( document ).ready(function() {
					// $(document).on('click', function(event) {
					//     if (!$(event.target).closest('#topmenu-login-dropdown').length) {
					//         //console.log('close login dropdown');
					//         // Hide the menus.
					//         $('#topmenu-login-dropdown').removeClass('open');
					//     }
					// });

					$('#topmenu-login-dropdown .dropdown-toggle').on('click', function(event) {
						//console.log('toggle login dropdown');
						event.preventDefault();
						$('#topmenu-login-dropdown').toggleClass('open');
					});

					// $('#topmenuloginmoreinfo-btn').on('click', function() {
					//     $('#topmenuloginmoreinfo').slideToggle();
					// });
			});

			var ScheduleList = [];
			var TimerList = [];
			var CalendarList = [];
			var actioncommCodesSelected = [" . $preselect . "]
			var searchAll = ''
			var userId = ''
			var customerId = ''
			var statesSelectedId = []
			var projectId = '" . GETPOST("projectid", "int", 3) . "';

			var SCHEDULE_CATEGORY = [
				'milestone',
				'task'
			];

			function ScheduleInfo() {
				this.id = null;
				this.calendarId = null;

				this.title = null;
				this.body = null;
				this.isAllDay = null;
				this.start = null;
				this.end = null;
				this.category = '';
				this.dueDateClass = '';

				this.color = null;
				this.bgColor = null;
				this.dragBgColor = null;
				this.borderColor = null;
				this.customStyle = '';

				this.isFocused = false;
				this.isPending = false;
				this.isVisible = true;
				this.isReadOnly = false;
				this.goingDuration = 0;
				this.comingDuration = 0;
				this.recurrenceRule = '';
				this.location = null;
				this.state = null,

				this.raw = {
					memo: '',
					hasToOrCc: false,
					hasRecurrenceRule: false,
					location: null,
					class: 'public', // or 'private'
					creator: {
						name: '',
						avatar: '',
						company: '',
						email: '',
						phone: ''
					}
				};
			}

			// (async () => {
			// 	const rawResponse = await fetch('" . dol_buildpath('idreamanewcalendar/core/ajax/events_ajax.php', 1) . "?action=test', {
			// 		method: 'POST',
			// 		headers: {
			// 			'Accept': 'application/json',
			// 			'Content-Type': 'application/json'
			// 		},
			// 		body: JSON.stringify({a: 1, b: 'Textual content'})
			// 	});
			// 	const content = await rawResponse.json();

			// 	console.log('test await');
			// 	console.log(content);
			// })();

			async function generateScheduleList(calendar, renderStart, renderEnd, onlylast) {
				let startDate = new Date(renderStart._date)
				let endDate = new Date(renderEnd._date)
				let offset = new Date()
				statesSelected = []
				$('.statesAutoComplete :selected').each(function(i, value) {
					statesSelected[i] = value.id
				})
				$('.actioncodeAutoComplete :selected').each(function(i, value) {
					actioncommCodesSelected[i] = value.id
				})
				let options = {
					calendarId: calendar.id,
					calendarName: calendar.name,
					startDate: startDate.toISOString().split('T')[0],
					endDate: endDate.toISOString().split('T')[0],
					offset: offset.getTimezoneOffset(),
					onlylast: onlylast,
					search_user: userId,
					search_all: searchAll,
					search_socid: customerId,
					search_states: statesSelected.join(','),
					search_actioncode: actioncommCodesSelected.join(',')
				}
				console.log(options)
				let res = await fetch('" . dol_buildpath('idreamanewcalendar/core/ajax/events_ajax.php', 1) . "?action=getevents', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json; charset=utf-8'
					},
					body: JSON.stringify(options)
				});
				let response = await res.text();
				// ajouter un test si json invalide
				return JSON.parse(response);
			}

			async function generateDeletedList(calendar, renderStart, renderEnd) {
				var startDate = new Date(renderStart._date);
				var endDate = new Date(renderEnd._date);
				var res = await fetch('" . dol_buildpath('idreamanewcalendar/core/ajax/events_ajax.php', 1) . "?action=getdeletedevents&calendarId=' + calendar.id + '&calendarName=' + calendar.name, {
					headers: {\"Content-Type\": \"application/json; charset=utf-8\"}
				});
				var response = await res.text();
				// ajouter un test si json invalide
				return JSON.parse(response);
			}

			async function generateSchedule(viewName, renderStart, renderEnd) {
				ScheduleList = [];
				CalendarList.forEach(function(mycalendar) {
					generateScheduleList(mycalendar, renderStart, renderEnd, 0).then(result => {
						//console.log(result)
						result.forEach(function(event) {
							// console.log(event)
							var schedule = new ScheduleInfo()

							schedule.id = event.id
							schedule.calendarId = event.calendarId
							schedule.title = event.title
							schedule.body = event.body
							schedule.attendees = ''
							schedule.start = event.start
							schedule.end = event.end
							schedule.isAllDay = event.isAllDay
							schedule.goingDuration = event.goingDuration
							schedule.comingDuration = event.comingDuration
							schedule.isReadOnly = event.isReadOnly
							schedule.isPrivate = false
							schedule.isVisible = true
							schedule.category = 'time'
							schedule.recurrenceRule = ''
							// busy or free
							schedule.state = event.state || ''
							schedule.color = event.color || '#ffffff'
							schedule.bgColor = event.bgColor || mycalendar.bgColor
							schedule.dragBgColor = event.dragBgColor || mycalendar.dragBgColor
							//schedule.borderColor = event.borderColor || mycalendar.borderColor
							schedule.borderColor = mycalendar.borderColor
							schedule.location = event.location
							schedule.raw.location = event.raw.location
							schedule.attendees = event.attendees
							// console.log(schedule)
							ScheduleList.push(schedule)
						});
						cal.clear();
						cal.createSchedules(ScheduleList);
					});
				});
			};

			function CalendarInfo() {
				this.id = null
				this.name = null
				this.checked = true
				this.color = null
				this.bgColor = null
				this.borderColor = null
				this.dragBgColor = null
				this.needToBeReloaded = false
			}

			function addCalendar(calendar) {
				CalendarList.push(calendar)
				var timer = setInterval(function() {
					// on ne récupère que les récents evt sauf si on doit recharger
					if (calendar.needToBeReloaded) {
						ScheduleList.forEach(function(schedule) {
							idToDelete = findSchedule(schedule.id, schedule.calendarId)
							if (schedule.calendarId == '1' && idToDelete !== false) {
								// DELETE Schedule on screen
								// console.log('deleting : ' + schedule.id)
								cal.deleteSchedule(schedule.id, schedule.calendarId, false);
								// il faut aussi le retirer de la liste
								ScheduleList = ScheduleList.filter(function(value, index, arr) {
									return index != idToDelete
								});
							}
						});
					}
					generateScheduleList(calendar, cal.getDateRangeStart(), cal.getDateRangeEnd(), (calendar.needToBeReloaded ? 0 : 1)).then(result => {
						//console.log(result)
						result.forEach(function(event) {
							// on retire les tooltips pour pas qu'ils restent bloqués
							$('.classfortooltip, .classforcustomtooltip').tooltip('hide');
							if (findSchedule(event.id, event.calendarId) !== false) {
								// UPDATE Schedule on screen
								// console.log('updating : ' + event.id)
								cal.updateSchedule(event.id, event.calendarId, {
									title: event.title,
									start: event.start,
									end: event.end,
									isAllDay: event.isAllDay,
									category: 'time',
									location: event.location
								});
							} else {
								// CREATE Schedule on screen
								// console.log('adding : ' + event.id)
								var schedule = new ScheduleInfo();
								schedule.id = event.id;
								schedule.calendarId = event.calendarId;
								schedule.title = event.title;
								schedule.isReadOnly = event.isReadOnly;
								schedule.isPrivate = false;
								schedule.body = event.body;
								schedule.start = event.start;
								schedule.end = event.end;
								schedule.isAllDay = event.isAllDay;
								schedule.color = event.color || '#ffffff',
								schedule.bgColor = event.bgColor || calendar.bgColor,
								schedule.dragBgColor = event.dragBgColor || calendar.dragBgColor,
								schedule.borderColor = calendar.borderColor,
								schedule.category = 'time';
								schedule.location = event.location;
								schedule.attendees = event.attendees;
								cal.createSchedules([schedule]);
								ScheduleList.push(schedule);
							}
						});
					});
					calendar.needToBeReloaded = false
					if (calendar.id == '1') {
						// console.log('debug')
						generateDeletedList(calendar, cal.getDateRangeStart(), cal.getDateRangeEnd()).then(result => {
							//console.log(result);
							result.forEach(function(event) {
								if (findSchedule(event.id, event.calendarId) !== false) {
									// DELETE Schedule on screen
									cal.deleteSchedule(event.id, event.calendarId, false);
								}
							});
						});
					}
				}, calendar.refresh);
				TimerList.push(timer);
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

			function findSchedule(id, calendarId) {
				var idfound

				ScheduleList.forEach(function(schedule, key) {
					///console.log(id, schedule)
					if (schedule.id === id && schedule.calendarId === calendarId) {
						idfound = key
					}
				});

				return idfound || false;
			}

			function hexToRGBA(hex) {
				var radix = 16;
				var r = parseInt(hex.slice(1, 3), radix),
					g = parseInt(hex.slice(3, 5), radix),
					b = parseInt(hex.slice(5, 7), radix),
					a = parseInt(hex.slice(7, 9), radix) / 255 || 1;
				var rgba = 'rgba(' + r + ', ' + g + ', ' + b + ', ' + a + ')';

				return rgba;
			}

			(function() {
				var calendar;
				var id = 0;

				calendar = new CalendarInfo();
				id += 1;
				calendar.id = String(id);
				calendar.name = '" . $langs->trans("LocalAgenda") . "';
				calendar.color = '#ffffff';
				calendar.bgColor = '#0c5fff';
				calendar.dragBgColor = '#8e5fff';
				calendar.borderColor = '#9e5fff';
				calendar.refresh = 5000;
				addCalendar(calendar);

				calendar = new CalendarInfo();
				id += 1;
				calendar.id = String(id);
				calendar.name = '" . $langs->trans("IDreamANewCalendarBirthdayEvents") . "';
				calendar.color = '#ffffff';
				calendar.bgColor = '#00a9ff';
				calendar.dragBgColor = '#00a9ff';
				calendar.borderColor = '#00a9ff';
				calendar.refresh = 60000;
				addCalendar(calendar);
				";
			foreach ($listofextcals as $key => $value) {
				print "calendar = new CalendarInfo();\n";
				print "id += 1;\n";
				print "calendar.id = String(id);\n";
				print "calendar.name = '" . $value['name'] . "';\n";
				print "calendar.color = '#ffffff';\n";
				print "calendar.bgColor = '#" . $value['color'] . "';\n";
				print "calendar.dragBgColor = '#" . $value['color'] . "';\n";
				print "calendar.borderColor = '#" . $value['color'] . "';\n";
				print "calendar.refresh = 120000;\n";
				print "addCalendar(calendar);\n";
			}
			print "    })();

		(function(window, Calendar) {
			//var Calendar = tui.Calendar;

			var useCreationPopup = false;
			var useDetailPopup = true;
			var useNarrowWeekEnd = false;
			var useStartDayOfWeek = 1;
			var datePicker, selectedCalendar;

			var cal = new Calendar('#calendar', {
				timezone: {
					zones: [
						{
							timezoneName: 'Europe/Paris',
							displayLabel: 'Paris',
							tooltip: 'Paris'
						}
					],
				},
				usageStatistics: false,
				defaultView: '" . $viewmodedefault . "',
				useCreationPopup: useCreationPopup,
				useDetailPopup: useDetailPopup,
				taskView: false,    // Can be also ['milestone', 'task']
				//scheduleView: true,  // Can be also ['allday', 'time']
				calendars: CalendarList,
				template: {
					monthDayname: function(dayname) {
					  return '<span class=\"calendar-week-dayname-name\">' + dayname.label + '</span>';
					},
					milestone: function(schedule) {
						return '<span class=\"calendar-font-icon ic-milestone-b\"></span> <span style=\"background-color: ' + schedule.bgColor + '\">' + schedule.title + '</span>';
					},
					allday: function(schedule) {
						return getTimeTemplate(schedule);
					},
					time: function(schedule) {
						return getTimeTemplate(schedule);
					},
					alldayTitle: function() {
						return '" . $langs->trans('IDreamANewCalendarAllDay') . "';
					},
					monthGridHeaderExceed: function(hiddenSchedules) {
						return '<span class=\"weekday-grid-more-schedules\">+' + hiddenSchedules + '</span>';
					},
					monthGridFooter: function() {
						return '';
					},
					monthGridFooterExceed: function(hiddenSchedules) {
						return '';
					},
					weekGridFooterExceed: function(hiddenSchedules) {
						return '+' + hiddenSchedules;
					},
					titlePlaceholder: function() {
						return '" . $langs->trans('IDreamANewCalendarSubject') . "';
					},
					popupIsAllDay: function() {
						return '" . $langs->trans('IDreamANewCalendarAllDay') . "';
					},
					popupStateFree: function() {
						return '" . $langs->trans('IDreamANewCalendarFree') . "';
					},
					popupStateBusy: function() {
						return '" . $langs->trans('IDreamANewCalendarBusy') . "';
					},
					popupEdit: function() {
						return '" . $langs->trans('IDreamANewCalendarEdit') . "';
					},
					popupDelete: function() {
						return '" . $langs->trans('IDreamANewCalendarDelete') . "';
					},
					popupSave: function() {
						return '" . $langs->trans('IDreamANewCalendarSave') . "';
					},
					popupUpdate: function() {
						return '" . $langs->trans('IDreamANewCalendarUpdate') . "';
					},
					popupDetailUser: function(schedule) {
						return ' ' + (schedule.attendees || []).join(' ');
					},
					popupDetailBody: function(schedule) {
						return ' ' + schedule.body;
					},
					popupDetailLocation: function(schedule) {
						return ' ' + schedule.location;
					}
				},
				month: {
					daynames: ['" . $langs->trans('SundayMin') . "', '" . $langs->trans('MondayMin') . "', '" . $langs->trans('TuesdayMin') . "', '" . $langs->trans('WednesdayMin') . "', '" . $langs->trans('ThursdayMin') . "', '" . $langs->trans('FridayMin') . "', '" . $langs->trans('SaturdayMin') . "'],
					startDayOfWeek: useStartDayOfWeek,
					narrowWeekend: useNarrowWeekEnd
				},
				week: {
					daynames: ['" . $langs->trans('SundayMin') . "', '" . $langs->trans('MondayMin') . "', '" . $langs->trans('TuesdayMin') . "', '" . $langs->trans('WednesdayMin') . "', '" . $langs->trans('ThursdayMin') . "', '" . $langs->trans('FridayMin') . "', '" . $langs->trans('SaturdayMin') . "'],
					startDayOfWeek: useStartDayOfWeek,
					hourStart: 4,
					hourEnd: 24,
					narrowWeekend: useNarrowWeekEnd
				}
			});

			// event handlers
			cal.on({
				'clickMore': function(event) {
					console.log('clickMore', event);
				},
				'clickSchedule': function(event) {
					console.log('clickSchedule', event);
				},
				'clickDayname': function(date) {
					console.log('clickDayname', date);
				},
				'beforeCreateSchedule': function(event) {
					console.log('beforeCreateSchedule', event);
					// var offset = new Date();
					// $.ajax({
					// 	url: '" . dol_buildpath('idreamanewcalendar/core/ajax/events_ajax.php', 1) . "?action=postevent',
					// 	dataType: 'json',
					// 	//contentType: 'application/json',
					//  	type:'post',
					// 	data: {
					// 		event: JSON.stringify(event),
					// 		offset: offset.getTimezoneOffset()
					// 	},
					//  	success: function(response, status) {
					// 		event.id = response.id;
					// 		saveNewSchedule(event);
					// 	},
					// 	error: function(response, status, e) {
					// 		console.log('error beforeCreateSchedule');
					// 	}
					// });

					// clear guide element
					event.guide.clearGuideElement();
					startDate = new Date(event.start._date);
					endDate = new Date(event.end._date);
					$(location).prop('href', '" . dol_buildpath('comm/action/card.php', 2) . "?action=create&aphour=' + startDate.getHours() + '&apmin=' + startDate.getMinutes() + '&apyear=' + startDate.getFullYear() + '&apmonth=' + (startDate.getMonth() + 1) + '&apday=' + startDate.getDate() + '&p2hour=' +endDate.getHours() + '&p2min=' + endDate.getMinutes() + '&p2year=' + endDate.getFullYear() + '&p2month=' + (endDate.getMonth() + 1) + '&p2day=' + endDate.getDate());
				},
				'beforeUpdateSchedule': function(event) {
					console.log('beforeUpdateSchedule', event);
					if (event.schedule.calendarId == 1 && event.triggerEventName == 'click') {
						$(location).prop('href', '" . dol_buildpath('comm/action/card.php', 2) . "?id=' + event.schedule.id);
					} else {
						var schedule = event.schedule;
						var startTime = event.start;
						var endTime = event.end;
						var offset = new Date();
						$.ajax({
							url: '" . dol_buildpath('idreamanewcalendar/core/ajax/events_ajax.php', 1) . "?action=putevent',
							dataType: 'json',
							//contentType: 'application/json',
							type:'post',
							data: {
								schedule: JSON.stringify(schedule),
								start: JSON.stringify(startTime),
								end: JSON.stringify(endTime),
								offset: offset.getTimezoneOffset()
							},
							success: function(response, status) {
								console.log('success');
							},
							error: function(response, status, e) {
								console.log('error');
							}
						});
						$('.classfortooltip, .classforcustomtooltip').tooltip('hide');
						cal.updateSchedule(schedule.id, schedule.calendarId, {
							start: startTime,
							end: endTime
						});
					}
				},
				'beforeDeleteSchedule': function(event) {
					console.log('beforeDeleteSchedule', event);
					var schedule = event.schedule;
					$.ajax({
						url: '" . dol_buildpath('idreamanewcalendar/core/ajax/events_ajax.php', 1) . "?action=deleteevent',
						dataType: 'json',
						type:'post',
						data: {
							schedule: JSON.stringify(schedule),
						}
					});
					$('.classfortooltip, .classforcustomtooltip').tooltip('hide');
					cal.deleteSchedule(schedule.id, schedule.calendarId);
				},
				'afterRenderSchedule': function(event) {
					var schedule = event.schedule;
					//var element = cal.getElement(schedule.id, schedule.calendarId);
					//console.log('afterRenderSchedule', element);
					// On réactive les tooltips (bootstrap)
					//$('.dropdown-toggle').dropdown();
					$('.classfortooltip, .classforcustomtooltip').tooltip({
						html: true,
						delay: { 'show': 250, 'hide': 100 },
						container: 'body',
						placement: 'auto'
					});
				},
				'clickTimezonesCollapseBtn': function(timezonesCollapsed) {
					console.log('timezonesCollapsed', timezonesCollapsed);
					if (timezonesCollapsed) {
						cal.setTheme({
							'week.daygridLeft.width': '77px',
							'week.timegridLeft.width': '77px'
						});
					} else {
						cal.setTheme({
							'week.daygridLeft.width': '60px',
							'week.timegridLeft.width': '60px'
						});
					}
					return true;
				}
			});

			/**
			 * Get time template for time and all-day
			 * @param {Schedule} schedule - schedule
			 * @returns {string}
			 */
			function getTimeTemplate(schedule) {
				var html = [];
				//console.log('getTimeTemplate' + schedule.id);
				var start = moment(schedule.start.toUTCString());
				var viewName = cal.getViewName();
				if (!schedule.isAllDay) {
					html.push('<strong>' + start.format('HH:mm') + '</strong> ');
				}
				if (schedule.isPrivate) {
					html.push('<span class=\"calendar-font-icon ic-lock-b\"></span>');
					html.push(' Private');
				} else {
					if (schedule.isReadOnly) {
						html.push('<span class=\"calendar-font-icon ic-readonly-b\"></span>');
					} else if (schedule.recurrenceRule) {
						html.push('<span class=\"calendar-font-icon ic-repeat-b\"></span>');
					}
					if (schedule.attendees.length && (viewName == 'day' || viewName == 'week')) {
						html.push('<span> ' + (schedule.attendees || []).join(' ') + '</span>');
					}
					html.push(' ' + schedule.title + ' : ' + schedule.id + '-' + schedule.calendarId);
					if (schedule.location && (viewName == 'day' || viewName == 'week')) {
						html.push('<br><span class=\"calendar-font-icon ic-location-b\"> ' + schedule.location + '</span>');
					}
				}
				return html.join('');
			}


			/**
			 * A listener for click the menu
			 * @param {Event} e - click event
			 */
			function onClickMenu(e) {
				var target = $(e.target).closest('a[role=\"menuitem\"]')[0];
				var action = getDataAction(target);
				var options = cal.getOptions();
				var viewName = '';

				//console.log(target);
				//console.log(action);
				switch (action) {
					case 'toggle-daily':
						viewName = 'day';
						break;
					case 'toggle-weekly':
						viewName = 'week';
						break;
					case 'toggle-monthly':
						options.month.visibleWeeksCount = 0;
						viewName = 'month';
						break;
					case 'toggle-weeks2':
						options.month.visibleWeeksCount = 2;
						viewName = 'month';
						break;
					case 'toggle-weeks3':
						options.month.visibleWeeksCount = 3;
						viewName = 'month';
						break;
					case 'toggle-narrow-weekend':
						options.month.narrowWeekend = !options.month.narrowWeekend;
						options.week.narrowWeekend = !options.week.narrowWeekend;
						viewName = cal.getViewName();
						target.querySelector('input').checked = options.month.narrowWeekend;
						break;
					case 'toggle-start-day-1':
						options.month.startDayOfWeek = !options.month.startDayOfWeek;
						options.week.startDayOfWeek = !options.week.startDayOfWeek;
						viewName = cal.getViewName();
						target.querySelector('input').checked = options.month.startDayOfWeek;
						break;
					case 'toggle-workweek':
						options.month.workweek = !options.month.workweek;
						options.week.workweek = !options.week.workweek;
						viewName = cal.getViewName();

						target.querySelector('input').checked = !options.month.workweek;
						break;
					default:
						break;
				}

				cal.setOptions(options, true);
				cal.changeView(viewName, true);

				setDropdownCalendarType();
				setRenderRangeText();
				setSchedules();
			}

			function onClickNavi(e) {
				var action = getDataAction(e.target);
				console.log('onClickNavi');

				switch (action) {
					case 'move-prev':
						cal.prev();
						break;
					case 'move-next':
						cal.next();
						break;
					case 'move-today':
						cal.today();
						break;
					default:
						return;
				}

				setRenderRangeText();
				setSchedules();
			}

			function onNewSchedule() {
				var title = $('#new-schedule-title').val();
				var location = $('#new-schedule-location').val();
				var isAllDay = document.getElementById('new-schedule-allday').checked;
				var start = datePicker.getStartDate();
				var end = datePicker.getEndDate();
				var calendar = selectedCalendar ? selectedCalendar : CalendarList[0];

				if (!title) {
					return;
				}
				// créer et récupérer l'id
				cal.createSchedules([{
					//id: 10000000,
					calendarId: calendar.id,
					title: title,
					body: body,
					isAllDay: isAllDay,
					start: start,
					end: end,
					category: isAllDay ? 'allday' : 'time',
					dueDateClass: '',
					color: calendar.color,
					bgColor: calendar.bgColor,
					dragBgColor: calendar.bgColor,
					borderColor: calendar.borderColor,
					raw: {
						location: location
					},
					state: 'Busy'
				}]);

				$('#modal-new-schedule').modal('hide');
			}

			function onChangeNewScheduleCalendar(e) {
				var target = $(e.target).closest('a[role=\"menuitem\"]')[0];
				var calendarId = getDataAction(target);
				changeNewScheduleCalendar(calendarId);
			}

			function changeNewScheduleCalendar(calendarId) {
				var calendarNameElement = document.getElementById('calendarName');
				var calendar = findCalendar(calendarId);
				var html = [];

				html.push('<span class=\"calendar-bar\" style=\"background-color: ' + calendar.bgColor + '; border-color:' + calendar.borderColor + ';\"></span>');
				html.push('<span class=\"calendar-name\">' + calendar.name + '</span>');

				calendarNameElement.innerHTML = html.join('');
				//console.log('selectedCalendar' + calendar);
				selectedCalendar = calendar;
			}

			function createNewSchedule(event) {
				var start = event.start ? new Date(event.start.getTime()) : new Date();
				var end = event.end ? new Date(event.end.getTime()) : moment().add(1, 'hours').toDate();

				if (useCreationPopup) {
					cal.openCreationPopup({
						start: start,
						end: end
					});
				}
			}

			function saveNewSchedule(scheduleData) {
				var calendar = scheduleData.calendar || findCalendar(scheduleData.calendarId);
				var schedule = {
					// mettre ici l'd qu'on aura récupéré avec ajax
					id: scheduleData.id,
					title: scheduleData.title,
					body: scheduleData.body,
					isAllDay: scheduleData.isAllDay,
					start: scheduleData.start,
					end: scheduleData.end,
					category: scheduleData.isAllDay ? 'allday' : 'time',
					dueDateClass: '',
					color: calendar.color,
					bgColor: calendar.bgColor,
					dragBgColor: calendar.bgColor,
					borderColor: calendar.borderColor,
					location: scheduleData.location,
					raw: {
					//    class: scheduleData.raw['class']
					},
					state: scheduleData.state
				};
				if (calendar) {
					schedule.calendarId = calendar.id;
					schedule.color = calendar.color;
					schedule.bgColor = calendar.bgColor;
					schedule.dragBgColor = calendar.dragBgColor;
					schedule.borderColor = calendar.borderColor;
				}
				//cal.createSchedules([schedule]);

				refreshScheduleVisibility();
			}

			function onChangeCalendars(e) {
				var calendarId = e.target.value;
				var checked = e.target.checked;
				var viewAll = document.querySelector('.lnb-calendars-item input');
				var calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarList input'));
				var allCheckedCalendars = true;

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

			function refreshScheduleVisibility() {
				var calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarList input'));

				CalendarList.forEach(function(calendar) {
					cal.toggleSchedules(calendar.id, !calendar.checked, false);
					// if (!calendar.checked) {
					//     console.log('clearing timer for calendar ' + calendar.id);
					//     clearInterval(calendar.timer);
					// } else {
					//     console.log('activate timer for calendar ' + calendar.id);
					//     calendar.timer = setInterval(function() {
					//         console.log('updating calendar ' + calendar.id);
					//     }, 5000);
					// }
				});

				cal.render(true);

				calendarElements.forEach(function(input) {
					var span = input.nextElementSibling;
					span.style.backgroundColor = input.checked ? span.style.borderColor : 'transparent';
				});
			}

			function setDropdownCalendarType() {
				var calendarTypeName = document.getElementById('calendarTypeName');
				var calendarTypeIcon = document.getElementById('calendarTypeIcon');
				var options = cal.getOptions();
				var type = cal.getViewName();
				var iconClassName;

				if (type === 'day') {
					type = '" . $langs->trans('IDreamANewCalendarDaily') . "';
					iconClassName = 'calendar-icon ic_view_day';
				} else if (type === 'week') {
					type = '" . $langs->trans('IDreamANewCalendarWeekly') . "';
					iconClassName = 'calendar-icon ic_view_week';
				} else if (options.month.visibleWeeksCount === 2) {
					type = '" . $langs->trans('IDreamANewCalendar2weeks') . "';
					iconClassName = 'calendar-icon ic_view_week';
				} else if (options.month.visibleWeeksCount === 3) {
					type = '" . $langs->trans('IDreamANewCalendar3weeks') . "';
					iconClassName = 'calendar-icon ic_view_week';
				} else {
					type = '" . $langs->trans('IDreamANewCalendarMonthly') . "';
					iconClassName = 'calendar-icon ic_view_month';
				}
				calendarTypeName.innerHTML = type;
				calendarTypeIcon.className = iconClassName;
			}

			function setRenderRangeText() {
				var renderRange = document.getElementById('renderRange');
				var options = cal.getOptions();
				var viewName = cal.getViewName();
				var html = [];
				if (viewName === 'day') {
					html.push(moment(cal.getDate().getTime()).format('YYYY.MM.DD'));
				} else if (viewName === 'month' &&
					(!options.month.visibleWeeksCount || options.month.visibleWeeksCount > 4)) {
					html.push(moment(cal.getDate().getTime()).format('YYYY.MM'));
				} else {
					html.push(moment(cal.getDateRangeStart().getTime()).format('YYYY.MM.DD'));
					html.push(' ~ ');
					html.push(moment(cal.getDateRangeEnd().getTime()).format(' MM.DD'));
				}
				renderRange.innerHTML = html.join('');
			}

			function setSchedules() {
				//ScheduleList = [];
				cal.clear();
				generateSchedule(cal.getViewName(), cal.getDateRangeStart(), cal.getDateRangeEnd()).then(result => {
					//console.log(result);
					console.log(ScheduleList);
					cal.createSchedules(ScheduleList);
					refreshScheduleVisibility();
				});
			}

			function setEventListener() {
				$('#menu-navi').on('click', onClickNavi);
				$('.dropdown-menu a[role=\"menuitem\"]').on('click', onClickMenu);
				$('#lnb-calendars').on('change', onChangeCalendars);

				$('#btn-save-schedule').on('click', onNewSchedule);
				// $('#btn-new-schedule').on('click', createNewSchedule);

				$('#dropdownMenu-calendars-list').on('click', onChangeNewScheduleCalendar);
				// https://bootstrap-autocomplete.readthedocs.io/en/latest/

				$('.usersAutoComplete').autoComplete({
					resolverSettings: {
						url: '" . dol_buildpath('idreamanewcalendar/core/ajax/events_ajax.php', 1) . "?action=getdolusers'
					},
					minLength: 3
				})
				$('.search-all').on('keyup change', function(e) {
					// do stuff!
					searchAll = $('.searchAll').val()
					console.log(searchAll)
					CalendarList.forEach(function (calendar) {
						if (calendar.id == 1) {
							calendar.needToBeReloaded = true
						}
					})
				})
				$('#clear-search-user').on('click', function () {
					console.log('clear userid')
					userId = ''
					$('.usersAutoComplete').val('')
					// reset calendarId 1
					CalendarList.forEach(function (calendar) {
						if (calendar.id == 1) {
							calendar.needToBeReloaded = true
						}
					})
				});
				$('.usersAutoComplete').on('autocomplete.select', function (evt, item) {
					console.log(item)
					userId = item.id
					// reset calendarId 1
					CalendarList.forEach(function (calendar) {
						if (calendar.id == 1) {
							calendar.needToBeReloaded = true
						}
					})
				})
				";

			if (!empty($conf->societe->enabled) && $user->rights->societe->lire) {
				print "$('.customersAutoComplete').autoComplete({
							resolverSettings: {
								url: '" . dol_buildpath('idreamanewcalendar/core/ajax/events_ajax.php', 1) . "?action=getcustomers'
							},
							minLength: 3
						})
						$('.customersAutoComplete').on('autocomplete.select', function (evt, item) {
							console.log(item)
							customerId = item.id
							// reset calendarId 1
							CalendarList.forEach(function (calendar) {
								if (calendar.id == 1) {
									calendar.needToBeReloaded = true
								}
							})
						})
						";
			}
			if (!empty($conf->projet->enabled) && $user->rights->projet->lire) {
				print "$('.projectsAutoComplete').autoComplete({
							resolverSettings: {
								url: '" . dol_buildpath('idreamanewcalendar/core/ajax/events_ajax.php', 1) . "?action=getprojects'
							},
							minLength: 3
						})
						$('.projectsAutoComplete').on('autocomplete.select', function (evt, item) {
							$('#project_id').val(item.value);
						})
						";
			}
			print "
			$.ajax({
				type: 'GET',
				url: '" . dol_buildpath('idreamanewcalendar/core/ajax/events_ajax.php', 1) . "?action=gettypeactions',
				data: {},
				success: function (response) {
					$('.actioncodeAutoComplete').html = '';
					$.each(response, function(index, value) {
						$('.actioncodeAutoComplete').append('<option id=\"' + value.code + '\" ' + (value.selected ? 'selected':'') + '>' + value.label + '</option>')
					});
					$('.actioncodeAutoComplete').selectpicker('refresh');
				},
				error: function () {
					//console.log('There was an error!')
				}
			});
			$.ajax({
				type: 'GET',
				url: '" . dol_buildpath('idreamanewcalendar/core/ajax/events_ajax.php', 1) . "?action=getstates',
				data: {},
				success: function (response) {
					$('.statesAutoComplete').html = '';
					$.each(response, function(index, value) {
						$('.statesAutoComplete').append('<option id=\"' + value.id + '\" ' + (value.selected ? 'selected':'') + '>' + value.label + '</option>')
					});
					$('.statesAutoComplete').selectpicker('refresh');
				},
				error: function () {
					//console.log('There was an error!')
				}
			});
			$('.statesAutoComplete').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
				// reset calendarId 1
				CalendarList.forEach(function (calendar) {
					if (calendar.id == '1') {
						calendar.needToBeReloaded = true
					}
				})
				//console.log(CalendarList, this.selectedOptions, clickedIndex, isSelected, previousValue)
			})
			$('.actioncodeAutoComplete').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
				// reset calendarId 1
				actioncommCodesSelected = []
				CalendarList.forEach(function (calendar) {
					if (calendar.id == '1') {
						calendar.needToBeReloaded = true
					}
				})
				//console.log(CalendarList, this.selectedOptions, clickedIndex, isSelected, previousValue)
			})
			window.addEventListener('resize', resizeThrottled);
			}

			function getDataAction(target) {
				return target.dataset ? target.dataset.action : target.getAttribute('data-action');
			}

			resizeThrottled = tui.util.throttle(function() {
				cal.render();
			}, 50);

			window.cal = cal;

			setDropdownCalendarType();
			setRenderRangeText();
			setSchedules();
			setEventListener();
		})(window, tui.Calendar);

		// set calendars
		(function() {
			var calendarList = document.getElementById('calendarList');
			var html = [];
			CalendarList.forEach(function(calendar) {
				html.push('<div class=\"lnb-calendars-item\"><label>' +
					'<input type=\"checkbox\" class=\"tui-full-calendar-checkbox-round\" value=\"' + calendar.id + '\" checked>' +
					'<span style=\"border-color: ' + calendar.borderColor + '; background-color: ' + calendar.borderColor + ';\"></span>' +
					'<span>' + calendar.name + '</span>' +
					'</label></div>'
				);
			});
			calendarList.innerHTML = html.join('\\n');
		})();

		</script>";

			print dol_get_fiche_end();
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
		$html .= '<input type="hidden" name="action" value="' . $action . '">';
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

		if ($canedit && $action == 'show_peruser') {
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
	public function doMassActions($parameters, &$object, &$action, $hookmanager)
	{
		global $conf, $user, $langs;

		$error = 0; // Error counter

		/* print_r($parameters); print_r($object); echo "action: " . $action; */
		if (in_array($parameters['currentcontext'], ['somecontext1', 'somecontext2'])) {
			// do something only for the context 'somecontext1' or 'somecontext2'
			foreach ($parameters['toselect'] as $objectid) {
				// Do action on each object id
			}
		}

		if (!$error) {
			$this->results = [
				'myreturn' => 999,
			];
			$this->resprints = 'A text to show';
			return 0; // or return 1 to replace standard code
		} else {
			$this->errors[] = 'Error message';
			return -1;
		}
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

		//var_dump($parameters);
		//var_dump($object);
		//var_dump($hookmanager);
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
							<input class="tui-full-calendar-checkbox-square" type="checkbox" value="all" checked>
							<span></span>
							<strong>' . $langs->trans('IDreamANewCalendarViewAll') . '</strong>
						</label>
					</div>
				</div>
				<div id="calendarList" class="lnb-calendars-d1">
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
