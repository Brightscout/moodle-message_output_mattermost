<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Mattermost connection handler
 * @package   message_mattermost
 * @copyright 2020, Hrishav Kumar <hrishav.kumar@brightscout.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot.'/lib/filelib.php');

$action = optional_param('action', 'setwebhook', PARAM_TEXT);

$PAGE->set_url(new moodle_url('/message/output/mattermost/mattermostconnect.php'));
$PAGE->set_context(context_system::instance());

require_login();

$mattermostmanager = new message_mattermost\manager();

require_sesskey();
$pref = optional_param('pref', 0, PARAM_INT);
$userid = optional_param('userid', 0, PARAM_INT);

$message = $mattermostmanager->update_preference($pref);
redirect(new moodle_url('/message/notificationpreferences.php', ['userid' => $userid]), $message);
