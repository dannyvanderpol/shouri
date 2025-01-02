"""
Test for creating the configuration.
"""

import os

from unit_tests.lib.create_configuration import create_configuration
from unit_tests.lib.database import Database
from unit_tests.lib.test_settings import TestSettings
from unit_tests.lib.test_suite_base import TestSuiteBase


class TestConfiguration(TestSuiteBase):

    def _clear_database(self):
        Database.clear_all(True)

    def _clear_config_file(self):
        if os.path.isfile(TestSettings.config_filename):
            os.remove(TestSettings.config_filename)

    def test_no_config(self):
        self._clear_database()
        self._clear_config_file()
        web_page = self.get_web_page()
        self.fail_if(" - Configuration" not in web_page.page_title,
                     f"Invalid web page: {web_page.page_title}")

    def test_create_configuration(self):
        self._clear_database()
        self._clear_config_file()
        result = create_configuration()
        self.fail_if(not result["result"], f"Could not create configuration: {result["message"]}")
        web_page = self.get_web_page()
        self.fail_if(" - Configuration" in web_page.page_title,
                     f"Configuration not created, invalid web page: {web_page.page_title}")


    def test_create_again(self):
        # Create configuration while there is already a configuration
        result = create_configuration()
        self.fail_if(result["result"], "A configuration was created while there was already one")

    def test_missing_config_file(self):
        self._clear_config_file()
        result = create_configuration()
        self.fail_if(not result["result"], f"Could not create configuration: {result["message"]}")
        # Check if only one admin exist
        users = Database.get_records_from_table("user")
        self.fail_if(len(users) != 1, f"Invalid number of user records: {len(users)}, expected 1")

    def test_missing_user(self):
        Database.truncate_table("user")
        result = create_configuration()
        self.fail_if(not result["result"], f"Could not create configuration: {result["message"]}")


if __name__ == "__main__":

    TestConfiguration().run()
