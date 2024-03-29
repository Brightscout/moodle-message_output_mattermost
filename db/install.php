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
 * Mattermost message processor installation code.
 *
 * @package   message_mattermost
 * @copyright 2021 Brightscout <hello@brightscout.com>
 * @author    2021 Hrishav Kumar <hrishav.kumar@brightscout.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Install the Mattermost message processor
 */
function xmldb_message_mattermost_install() {
    global $DB;
    $result = true;
    $provider = new stdClass();
    $provider->name  = 'mattermost';
    $DB->insert_record('message_processors', $provider);
    return $result;
}
