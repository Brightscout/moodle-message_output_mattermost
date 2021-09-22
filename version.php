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
 * Mattermost message plugin version information.
 *
 * @package   message_mattermost
 * @copyright 2021 Brightscout <hello@brightscout.com>
 * @author    2021 Hrishav Kumar <hrishav.kumar@brightscout.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version  = 2021091900;  // The current module version (Date: YYYYMMDDXX).
$plugin->requires = 2016111500; // Moodle version.

$plugin->component = 'message_mattermost';

$plugin->release  = '1.0.0 (Build - 2021071900)';
$plugin->maturity  = MATURITY_BETA;
