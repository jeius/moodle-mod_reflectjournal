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
 * Baseline tests: the plugin is installed and its plumbing resolves.
 *
 * @package    mod_reflectjournal
 * @category   test
 * @copyright  2026 Jeius
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_reflectjournal;

/**
 * Baseline tests class.
 *
 * @package    mod_reflectjournal
 * @category   test
 * @copyright  2026 Jeius
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class reflectjournal_base_test extends \advanced_testcase {
    /**
     * The plugin is installed with a recorded version.
     */
    public function test_plugin_is_installed(): void {
        $this->resetAfterTest();
        $this->assertNotEmpty((int) get_config('mod_reflectjournal', 'version'));
    }

    /**
     * The display name resolves through the String API (lang file sanity).
     */
    public function test_pluginname_string_resolves(): void {
        $this->resetAfterTest();
        $this->assertSame('Reflection Journal', get_string('pluginname', 'mod_reflectjournal'));
    }

    /**
     * The instance table exists per db/install.xml.
     */
    public function test_instance_table_exists(): void {
        global $DB;
        $this->resetAfterTest();
        $this->assertTrue($DB->get_manager()->table_exists('reflectjournal'));
    }
}
