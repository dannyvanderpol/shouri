<?php

define("ROUTES",
[
    // By default inform the user that th URI is wrong
    ["DEFAULT",         "ControllerApplication",    "showWrongUri",         0],

    // Landing page (website root)
    ["",                "ControllerApplication",    "showLandingPage",      1],

    // All API calls go here
    ["api",             "ControllerApplication",    "processApiCall",       0],

    // Configuration
    ["configuration",   "ControllerConfiguration",  "showConfiguration",    0],

    // Dashboard
    ["dashboard",       "ControllerDashboard",      "showDashboard",        2],

    // Log in
    ["log-in",          "ControllerSession",        "showLogIn",            1],

    // Test URIs, only work when accessed from localhost
    ["test/modals",     "ControllerTest",           "showTestModals",       0]
]);
