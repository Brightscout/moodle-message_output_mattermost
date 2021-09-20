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
 * Mattermost message plugin settings.
 *
 * @package   message_mattermost
 * @copyright 2021 Brightscout <hello@brightscout.com>
 * @author    2021 Hrishav Kumar <hrishav.kumar@brightscout.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext('message_mattermost/serverurl', get_string('serverurl', 'message_mattermost'),
        get_string('configserverurl', 'message_mattermost'), '', PARAM_TEXT));
    $settings->add(new admin_setting_configtext('message_mattermost/secret', get_string('secret', 'message_mattermost'),
        get_string('configsecret', 'message_mattermost'), '', PARAM_TEXT));
    $settings->add(new admin_setting_configcheckbox(
        'message_mattermost/defaultnotificationstate',
        get_string('defaultnotificationstate', 'message_mattermost'),
        get_string('defaultnotificationstate_desc', 'message_mattermost'),
        1
    ));
}
