<?php

define("ROUTES",
[
    // By default inform the user that th URI is wrong
    ["DEFAULT", "ControllerApplication",    "showWrongUri",     0],

    // Landing page (website root)
    ["",        "ControllerApplication",    "showLandingPage",  1]
]);
