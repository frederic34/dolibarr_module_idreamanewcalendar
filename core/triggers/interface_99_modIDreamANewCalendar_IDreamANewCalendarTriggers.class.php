<?php
/* Copyright (C) 2019-2021  Frédéric FRANCE <frederic.france@free.fr>
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
 * \file    core/triggers/interface_99_modIDreamANewCalendar_IDreamANewCalendarTriggers.class.php
 * \ingroup idreamanewcalendar
 * \brief   Example trigger.
 *
 * Put detailed description here.
 *
 * \remarks You can create other triggers by copying this one.
 * - File name should be either:
 *      - interface_99_modIDreamANewCalendar_MyTrigger.class.php
 *      - interface_99_all_MyTrigger.class.php
 * - The file must stay in core/triggers
 * - The class name must be InterfaceMytrigger
 * - The constructor method must be named InterfaceMytrigger
 * - The name property name must be MyTrigger
 */

require_once DOL_DOCUMENT_ROOT . '/core/triggers/dolibarrtriggers.class.php';


/**
 *  Class of triggers for IDreamANewCalendar module
 */
class InterfaceIDreamANewCalendarTriggers extends DolibarrTriggers
{
	/**
	 * Constructor
	 *
	 * @param DoliDB $db Database handler
	 */
	public function __construct($db)
	{
		$this->db = $db;

		$this->name = preg_replace('/^Interface/i', '', get_class($this));
		$this->family = "agenda";
		$this->description = "IDreamANewCalendar triggers.";
		// 'development', 'experimental', 'dolibarr' or version
		$this->version = 'development';
		$this->picto = 'idreamanewcalendar@idreamanewcalendar';
	}

	/**
	 * Function called when a Dolibarrr business event is done.
	 * All functions "runTrigger" are triggered if file
	 * is inside directory core/triggers
	 *
	 * @param string        $action     Event action code
	 * @param CommonObject  $object     Object
	 * @param User          $user       Object user
	 * @param Translate     $langs      Object langs
	 * @param Conf          $conf       Object conf
	 * @return int                      <0 if KO, 0 if no triggered ran, >0 if OK
	 */
	public function runTrigger($action, $object, User $user, Translate $langs, Conf $conf)
	{
		if (empty($conf->idreamanewcalendar->enabled)) {
			// If module is not enabled, we do nothing
			return 0;
		}

		// For example : COMPANY_CREATE => public function companyCreate($action, $object, User $user, Translate $langs, Conf $conf)
		$methodName = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower($action)))));
		$callback = [$this, $methodName];
		if (is_callable($callback)) {
			dol_syslog("Trigger '" . $this->name . "' for action '$action' launched by " . __FILE__ . ". id=" . $object->id, LOG_INFO);
			return call_user_func($callback, $action, $object, $user, $langs, $conf);
		};
		return 0;
	}

	/**
	 * Trigger ACTION_DELETE
	 * @param string        $action     Event action code
	 * @param ActionComm  $object     Object
	 * @param User          $user       Object user
	 * @param Translate     $langs      Object langs
	 * @param Conf          $conf       Object conf
	 * @return int                      <0 if KO, 0 if no triggered ran, >0 if OK
	 */
	public function actionDelete($action, ActionComm $object, User $user, Translate $langs, Conf $conf)
	{
		if ($object->oldcopy->id > 0) {
			$now = dol_now();
			// store id of deleted action to be able to find them later
			$sql = 'INSERT INTO ' . MAIN_DB_PREFIX . 'actioncomm_deleted (fk_actioncomm) VALUES (' . $object->oldcopy->id . ')';
			dol_syslog("tui calendar add deleted event: " . $sql, LOG_DEBUG);
			$this->db->query($sql);
			// delete one day old
			$sql = 'DELETE FROM ' . MAIN_DB_PREFIX . 'actioncomm_deleted WHERE tms<"' . $this->db->idate(($now - (60 * 60 * 24))) . '"';
			dol_syslog("tui calendar remoev old deleted event: " . $sql, LOG_DEBUG);
			$this->db->query($sql);
		}
		return 0;
	}
}
