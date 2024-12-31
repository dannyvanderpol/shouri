<?php

require_once("routes.php");
require_once("templateValues.php");

define("PAGE_TITLE",        "Shouri");
define("DEFAULT_COLOR",     "#0066aa");
define("STYLES_PATH",       "application/styles/");

define("SEARCH_PATHS", [
    "application/modules"
]);

date_default_timezone_set("Europe/Amsterdam");
