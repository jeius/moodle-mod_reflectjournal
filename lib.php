<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Library of interface functions and constants for the Reflection Journal module.
 *
 * Thin bridge to core only: business logic belongs in namespaced classes under
 * classes/ (see docs/architecture.md).
 *
 * @package    mod_reflectjournal
 * @copyright  2026 Jeius
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Adds a Reflection Journal instance.
 *
 * @param stdClass $data The form data from mod_form.
 * @param moodleform|null $mform The form instance.
 * @return int New instance id.
 */
function reflectjournal_add_instance(stdClass $data, ?moodleform $mform = null): int {
    global $DB;

    $record = new stdClass();
    $record->course = $data->course;
    $record->name = $data->name;
    $record->intro = $data->intro;
    $record->introformat = $data->introformat;
    $record->timemodified = time();

    return $DB->insert_record('reflectjournal', $record);
}

/**
 * Updates a Reflection Journal instance.
 *
 * @param stdClass $data The form data from mod_form (carries the instance id).
 * @param moodleform|null $mform The form instance.
 * @return bool True on success.
 */
function reflectjournal_update_instance(stdClass $data, ?moodleform $mform = null): bool {
    global $DB;

    $record = new stdClass();
    $record->id = $data->instance;
    $record->course = $data->course;
    $record->name = $data->name;
    $record->intro = $data->intro;
    $record->introformat = $data->introformat;
    $record->timemodified = time();

    return $DB->update_record('reflectjournal', $record);
}

/**
 * Deletes a Reflection Journal instance.
 *
 * @param int $id The instance id.
 * @return bool True on success.
 */
function reflectjournal_delete_instance(int $id): bool {
    global $DB;

    if (!$DB->get_record('reflectjournal', ['id' => $id])) {
        return false;
    }

    // Entry data removal grows here with the data model (M2+); core removes
    // the course module, grades, calendar and completion state for us.
    $DB->delete_records('reflectjournal', ['id' => $id]);

    return true;
}

/**
 * Declares the core features this module supports.
 *
 * @param string $feature FEATURE_xx constant.
 * @return bool|string|null True if supported, null if unknown.
 */
function reflectjournal_supports(string $feature) {
    switch ($feature) {
        case FEATURE_MOD_INTRO:
            return true;
        default:
            return null;
    }
}
