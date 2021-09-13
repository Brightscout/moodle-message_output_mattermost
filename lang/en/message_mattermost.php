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
 * Strings for mattermost message plugin.
 *
 * @package   message_mattermost
 * @copyright 2021 Brightscout <hello@brightscout.com>
 * @author    2021 Hrishav Kumar <hrishav.kumar@brightscout.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['notconfigured'] = 'The Mattermost server hasn\'t been configured so Mattermost messages cannot be sent';
$string['pluginname'] = 'Mattermost';
$string['secret'] = 'Webhook secret';
$string['serverurl'] = 'Mattermost Server URL';
$string['defaultnotificationstate'] = 'Is mattermost notification enabled by default?';
$string['configserverurl'] = 'Mattermost server URL where notification will be sent.';
$string['configsecret'] = 'Mattermost notification plugin secret which is installed on the server above.';
$string['defaultnotification_desc'] = 'Default Mattermost notification state for a new moodle user';
