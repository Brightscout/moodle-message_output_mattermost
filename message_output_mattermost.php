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
 * @package   message_mattermost
 * @copyright 2020, Hrishav Kumar <hrishav.kumar@brightscout.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/message/output/lib.php');

class message_output_mattermost extends message_output {

    public function __construct() {
        $this->manager = new message_mattermost\manager();
    }

    /**
     * Processes the message and sends a notification via slack
     *
     * @param stdClass $eventdata the event data submitted by the message sender plus $eventdata->savedmessageid
     * @return true if ok, false if error
     */
    public function send_message($eventdata) {
        global $CFG;

        // Skip any messaging of suspended and deleted users.
        if (($eventdata->userto->auth === 'nologin') || $eventdata->userto->suspended || $eventdata->userto->deleted) {
            return true;
        }

        if (!empty($CFG->noemailever)) {
            // Hidden setting for development sites, set in config.php if needed.
            debugging('$CFG->noemailever is active, no slack message sent.', DEBUG_MINIMAL);
            return true;
        }

        return $this->manager->send_message($eventdata->fullmessage, $eventdata->userto->email);
    }

    /**
     * Creates necessary fields in the messaging config form.
     *
     * @param array $preferences An object of user preferences
     */
    public function config_form($preferences) {
        global $USER;
        if (!$this->is_system_configured()) {
            return get_string('notconfigured', 'message_mattermost');
        } else {
            return $this->manager->config_form($preferences, $USER->id);
        }
    }

    /**
     * Parses the submitted form data and saves it into preferences array.
     *
     * @param stdClass $form preferences form class
     * @param array $preferences preferences array
     */
    public function process_form($form, &$preferences) {
        // This is handled by the callback in mattermostconnect.php.
        return true;
    }

    /**
     * Loads the config data from database to put on the form during initial form display.
     * There is no real form for this, so these are here primarily for documentation purposes.
     *
     * @param object $preferences preferences object
     * @param int $userid the user id
     */
    public function load_data(&$preferences, $userid) {
        $preferences->mattermost_notification = get_user_preferences('message_processor_mattermost_notification', '', $userid);
    }

    /**
     * Tests whether the Mattermost settings have been configured
     * @return boolean true if Mattermost is configured
     */
    public function is_system_configured() {
        return (!empty(get_config('message_mattermost', 'serverurl')) && !empty(get_config('message_mattermost', 'secret')));
    }

    /**
     * Tests whether the Mattermost settings have been configured on user level
     * @param  object $user the user object, defaults to $USER.
     * @return bool has the user made all the necessary settings
     * in their profile to allow this plugin to be used.
     */
    public function is_user_configured($user = null) {
        global $USER;

        if ($user === null) {
            $user = $USER;
        }
        return ($this->manager->is_notification_enabled($user->id));
    }
}
