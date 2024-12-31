"""
Container with test settings.
"""

import os


class TestSettings:

    root_path = os.path.abspath(os.path.join(os.path.dirname(__file__), "../../"))
    ini_filename = os.path.abspath(os.path.join(root_path, "../../shouri.ini"))
    uri = "http://localhost:8080/shouri/"

    # These credentials are only used for testing, make sure these are not used in live production servers
    sql_host =  "localhost"
    sql_database = "shouri_test"
    sql_user = "shouri_test"
    sql_password = "OnlyForTest!"

    admin_email = "admin@shouri.nl"
    admin_name = "Shouri Admin"
    admin_password = "Shouri"


if __name__ == "__main__":

    print(TestSettings.root_path)
    print(TestSettings.uri)
    print(TestSettings.ini_filename)
