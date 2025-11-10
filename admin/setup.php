<?php
/* Copyright (C) 2004-2017  Laurent Destailleur     <eldy@users.sourceforge.net>
 * Copyright (C) 2019-2023  Frédéric FRANCE         <frederic.france@free.fr>
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
 * \file    idreamanewcalendar/admin/setup.php
 * \ingroup idreamanewcalendar
 * \brief   IDreamANewCalendar setup page.
 */

// Load Dolibarr environment
include '../config.php';

// Libraries
require_once DOL_DOCUMENT_ROOT . "/core/lib/admin.lib.php";
require_once '../lib/idreamanewcalendar.lib.php';
//require_once "../class/myclass.class.php";

// Translations
$langs->loadLangs(["admin", "idreamanewcalendar@idreamanewcalendar"]);

// Access control
if (!$user->admin) {
	accessforbidden();
}

// Parameters
$action = GETPOST('action', 'alpha');
$backtopage = GETPOST('backtopage', 'alpha');

$arrayofparameters = [
	'IDREAMANEWCALENDAR_LIGTHNESS_SWAP' => [
		'css' => 'minwidth500',
		'enabled' => 1,
	],
];

// Paramètres ON/OFF est rajouté au paramètre
$modules = [
	'IDREAMANEWCALENDAR_DONT_SHOW_AUTO_EVENTS' => 'IDreamANewCalendarDontShowAutoEvents',
	// tweak dolibarr
	'CHECKLASTVERSION_EXTERNALMODULE' => 'CHECKLASTVERSION_EXTERNALMODULE',
];
if ((int) DOL_VERSION > 17) {
	// tweak dolibarr
	$modules = array_merge(
		$modules,
		[
			'MAIN_ENABLE_AJAX_TOOLTIP' => 'MAIN_ENABLE_AJAX_TOOLTIP',
		]
	);
}



/*
 * Actions
 */

foreach ($modules as $const => $desc) {
	if ($action == 'activate_' . strtolower($const)) {
		dolibarr_set_const($db, $const, "1", 'chaine', 0, '', $conf->entity);
	}
	if ($action == 'disable_' . strtolower($const)) {
		dolibarr_del_const($db, $const, $conf->entity);
		//header("Location: ".$_SERVER["PHP_SELF"]);
		//exit;
	}
}
if ($action == 'update') {
	$error = 0;
	$db->begin();
	foreach ($arrayofparameters as $key => $val) {
		$result = dolibarr_set_const($db, $key, GETPOST($key, 'alpha'), 'chaine', 0, '', $conf->entity);
		if ($result < 0) {
			$error++;
			break;
		}
	}
	if (!$error) {
		$db->commit();
		setEventMessages($langs->trans("SetupSaved"), null, 'mesgs');
	} else {
		$db->rollback();
		setEventMessages($langs->trans("SetupNotSaved"), null, 'errors');
	}
}



/*
 * View
 */

$page_name = "IDreamANewCalendarSetup";
llxHeader('', $langs->trans($page_name));

// Subheader
$linkback = '<a href="' . ($backtopage ? $backtopage : DOL_URL_ROOT . '/admin/modules.php?restore_lastsearch_values=1') . '">';
$linkback .= $langs->trans("BackToModuleList") . '</a>';

print load_fiche_titre($langs->trans($page_name), $linkback, 'title_setup');

// Configuration header
$head = idreamanewcalendarAdminPrepareHead();
print dol_get_fiche_head($head, 'settings', $langs->trans("Action"), -1, "action");

// Setup page goes here
echo '<span class="opacitymedium">' . $langs->trans("IDreamANewCalendarSetupPage") . '</span><br><br>';


if ($action == 'edit') {
	print '<form method="POST" action="' . $_SERVER["PHP_SELF"] . '">';
	print '<input type="hidden" name="token" value="' . $_SESSION['newtoken'] . '">';
	print '<input type="hidden" name="action" value="update">';

	print '<table class="noborder" width="100%">';
	print '<tr class="liste_titre"><td class="titlefield">' . $langs->trans("Parameter") . '</td>';
	print '<td>' . $langs->trans("Value") . '</td>';
	print '</tr>';

	foreach ($arrayofparameters as $key => $val) {
		print '<tr class="oddeven"><td>';
		$tooltiphelp = (($langs->trans($key . 'Tooltip') != $key . 'Tooltip') ? $langs->trans($key . 'Tooltip') : '');
		print $form->textwithpicto($langs->trans($key), $tooltiphelp);
		print '</td><td><input name="' . $key . '"  class="flat ' . (empty($val['css']) ? 'minwidth200' : $val['css']) . '" value="' . ($conf->global->$key ?? '') . '"></td></tr>';
	}
	print '</table>';

	print '<br><div class="center">';
	print '<input class="button" type="submit" value="' . $langs->trans("Save") . '">';
	print '</div>';

	print '</form>';
	print '<br>';
} else {
	if (!empty($arrayofparameters)) {
		print '<table class="noborder centpercent">';
		print '<tr class="liste_titre">';
		print '<td class="titlefield">' . $langs->trans("Parameter") . '</td>';
		print '<td>' . $langs->trans("Value") . '</td>';
		print '</tr>';

		foreach ($arrayofparameters as $key => $val) {
			print '<tr class="oddeven"><td>';
			$tooltiphelp = (($langs->trans($key . 'Tooltip') != $key . 'Tooltip') ? $langs->trans($key . 'Tooltip') : '');
			print $form->textwithpicto($langs->trans($key), $tooltiphelp);
			print '</td><td>' . ($conf->global->$key ?? '') . '</td></tr>';
		}

		print '</table>';

		print '<div class="tabsAction">';
		print '<a class="butAction" href="' . $_SERVER["PHP_SELF"] . '?action=edit">' . $langs->trans("Modify") . '</a>';
		print '</div>';
	} else {
		print '<br>' . $langs->trans("NothingToSetup");
	}
	print '<div class="tabsAction">';
	print '<a class="butAction" href="' . $_SERVER["PHP_SELF"] . '?action=edit">' . $langs->trans("Modify") . '</a>';
	print '</div>';

	print '<table class="noborder" width="100%">';
	print '<tr class="liste_titre">';
	print '<td>' . $langs->trans("Paramètres Divers") . '</td>';
	print '<td align="center" width="100">' . $langs->trans("Action") . '</td>';
	print "</tr>\n";
	// Modules
	foreach ($modules as $constant => $desc) {
		print '<tr class="oddeven">';
		print '<td>' . $langs->trans($desc) . '</td>';
		print '<td align="center" width="100">';
		$value = $conf->global->$constant ?? 0;
		if ($value == 0) {
			print '<a href="' . $_SERVER['PHP_SELF'] . '?action=activate_' . strtolower($constant) . '&amp;token=' . $_SESSION['newtoken'] . '">';
			print img_picto($langs->trans("Disabled"), 'switch_off');
			print '</a>';
		} elseif ($value == 1) {
			print '<a href="' . $_SERVER['PHP_SELF'] . '?action=disable_' . strtolower($constant) . '&amp;token=' . $_SESSION['newtoken'] . '">';
			print img_picto($langs->trans("Enabled"), 'switch_on');
			print '</a>';
		}
		print "</td>";
		print '</tr>';
	}
	print '</table>' . PHP_EOL;
	print '<br>' . PHP_EOL;
}

// Page end
print dol_get_fiche_end();

llxFooter();
$db->close();
