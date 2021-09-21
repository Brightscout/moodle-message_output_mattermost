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
 * Mattermost message unit tests.
 *
 * @package   message_mattermost
 * @copyright 2021 Brightscout <hello@brightscout.com>
 * @author    2021 Abhishek Verma <abhishek.verma@brightscout.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Tests for manager class
 *
 * @package   message_mattermost
 * @copyright 2021 Brightscout <hello@brightscout.com>
 * @author    2021 Abhishek Verma <abhishek.verma@brightscout.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class message_mattermost_manager_test extends advanced_testcase {

    /**
     * Create a test user and reset state once test is completed
     */
    public function create_test_user_and_reset_state() {
        // Reset state after test.
        $this->resetAfterTest(true);

        // Create a new test user.
        return $this->getDataGenerator()->create_user();
    }

    /**
     * Set plugin config properties for tests
     *
     * @param int $defaultnotificationstate - determines if plugin is enabled or disabled
     * 0 is considered as disabled and 1 as enabled
     */
    public function set_plugin_config($defaultnotificationstate = 1) {
        $config = get_config('message_mattermost');
        $config->defaultnotificationstate = $defaultnotificationstate;

        return $config;
    }

    /**
     * Function to test redirect_uri
     */
    public function test_redirect_uri() {
        $mattermostmanager = new message_mattermost\manager();
        $outputuri = $mattermostmanager->redirect_uri();

        // Verify redirect_uri.
        $expecteduri = 'https://www.example.com/moodle/'
        .'message/output/mattermost/mattermostconnect.php';
        $this->assertEquals($expecteduri, $outputuri);
    }

    /**
     * Function to test config_form when notificationstate is enabled
     */
    public function test_config_form_with_notificationstate_enabled() {
        $config = $this->set_plugin_config();
        $mattermostmanager = new message_mattermost\manager($config);

        // Create a new test user.
        $user = $this->create_test_user_and_reset_state();

        $outputconfigbutton = $mattermostmanager->config_form('', $user->id);
        $expectedconfigbutton = 'Disable Mattermost Notifications';

        $this->assertTrue(strpos($outputconfigbutton, $expectedconfigbutton) !== false);
    }

    /**
     * Function to test config_form when notificationstate is disabled
     */
    public function test_config_form_with_notificationstate_disabled() {
        $config = $this->set_plugin_config(0);
        $mattermostmanager = new message_mattermost\manager($config);

        // Create a new test user.
        $user = $this->create_test_user_and_reset_state();

        // Test configbutton when plugin is disabled.
        $outputconfigbutton = $mattermostmanager->config_form('', $user->id);
        $expectedconfigbutton = 'Enable Mattermost Notifications';

        $this->assertTrue(strpos($outputconfigbutton, $expectedconfigbutton) !== false);
    }

    /**
     * Function to test update_preference when notification preference is enabled
     */
    public function test_update_preference_with_notification_preference_enabled() {
        global $DB;
        $mattermostmanager = new message_mattermost\manager();

        // Create a new test user.
        $user = $this->create_test_user_and_reset_state();

        $mattermostmanager->update_preference(1, $user);
        $outputpreferences = $DB->get_record('user_preferences', array(
            'userid' => $user->id
        ));

        $this->assertTrue($outputpreferences->value == 1);
    }

    /**
     * Function to test update_preference when notification preference is disabled
     */
    public function test_update_preference_with_notification_preference_disabled() {
        global $DB;
        $mattermostmanager = new message_mattermost\manager();

        // Create a new test user.
        $user = $this->create_test_user_and_reset_state();

        $mattermostmanager->update_preference(0, $user);
        $outputpreferences = $DB->get_record('user_preferences', array(
            'userid' => $user->id
        ));

        $this->assertTrue($outputpreferences->value == 0);
    }

    /**
     * Function to test is_notification_enabled when notificationstate is enabled
     */
    public function test_is_notification_enabled() {
        $config = $this->set_plugin_config();
        $mattermostmanager = new message_mattermost\manager($config);

        global $USER;
        $outputvalue = $mattermostmanager->is_notification_enabled($USER->id);
        $this->assertTrue($outputvalue == true);
    }

    /**
     * Function to test is_notification_enabled when notificationstate is disabled
     */
    public function test_is_notification_disabled() {
        $config = $this->set_plugin_config(0);
        $mattermostmanager = new message_mattermost\manager($config);

        global $USER;
        $outputvalue = $mattermostmanager->is_notification_enabled($USER->id);
        $this->assertTrue($outputvalue == false);
    }
}
