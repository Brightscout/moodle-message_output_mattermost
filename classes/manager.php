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
 * Mattermost message plugin manager.
 *
 * @package   message_mattermost
 * @copyright 2020, Hrishav Kumar <hrishav.kumar@brightscout.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace message_mattermost;

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot.'/message/output/lib.php');
require_once($CFG->dirroot.'/lib/filelib.php');

/**
 * Mattermot helper manager class
 *
 * @package   message_mattermost
 * @copyright 2020, Hrishav Kumar <hrishav.kumar@brightscout.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class manager {

    /**
     * Constructor. Loads all needed data.
     */
    public function __construct() {
        $this->config = get_config('message_mattermost');
    }

    /**
     * Send the message to Mattermost.
     * @param stdClass $eventdata the event data submitted by the message sender plus $eventdata->savedmessageid
     */
    public function send_message($eventdata) {
        $curl = new \curl();

        $options = [
            'CURLOPT_RETURNTRANSFER' => true,
            'CURLOPT_TIMEOUT' => 30,
            'CURLOPT_HTTPHEADER' => [
                'Content-Type: application/json',
            ],
        ];

        $payload = array(
            'email' => $eventdata->userto->email,
            'message' => $eventdata->fullmessage,
            'messageHTML' => $eventdata->fullmessagehtml,
            'subject' => $eventdata->subject,
        );
        $payload = json_encode($payload);

        $webhookurl = $this->config->serverurl;
        $webhookurl .= '/plugins/com.mattermost.moodle-notification/api/v1/notify?secret='.$this->config->secret;

        $curl->post($webhookurl, $payload, $options);
        $info = $curl->get_info();
        if (!empty($info['http_code']) && $info['http_code'] != 200) {
            debugging('Unexpected response from the Mattermost server, HTTP code:' . $info['http_code'], DEBUG_DEVELOPER);
            return false;
        }
        return true;
    }

    /**
     * Return the redirect URI to handle the callback for enable/disable mattermost notifications.
     * @return string The URI.
     */
    public function redirect_uri() {
        global $CFG;

        return $CFG->wwwroot.'/message/output/mattermost/mattermostconnect.php';
    }

    /**
     * Return the HTML for the user preferences form.
     * @param array $preferences An array of user preferences.
     * @param int $userid Moodle id of the user in question.
     * @return string The HTML for the form.
     */
    public function config_form ($preferences, $userid) {
        $checked = '';
        $text = 'Enable Mattermost Notifications';
        $pref = true;
        if ((bool)get_user_preferences('message_processor_mattermost_notification', true, $userid)) {
            $checked = 'checked="checked"';
            $text = 'Disable Mattermost Notifications';
            $pref = false;
        }

        $url = new \moodle_url($this->redirect_uri(), ['pref' => $pref, 'userid' => $userid,
        'sesskey' => sesskey()]);
        $configbutton = '<div align="left" style="display: flex;">
                        <a href="'.$url.'">
                           '.$text.'
                        </a>
                        </div>';
        return $configbutton;
    }

    /**
     * Update the user's mattermost notification preference.
     * @param bool $val The preference to set.
     */
    public function update_preference($val) {
        global $USER;
        if ($val == 1) {
            set_user_preference('message_processor_mattermost_notification', true, $USER->id);
        } else {
            set_user_preference('message_processor_mattermost_notification', false, $USER->id);
        }
    }

    /**
     * Check if mattermost notification is enabled/disabled for user.
     * @param int $userid The id of the user in question.
     * @return boolean Success.
     */
    public function is_notification_enabled($userid) {
        return get_user_preferences('message_processor_mattermost_notification', true, $userid) == 1;
    }
}
