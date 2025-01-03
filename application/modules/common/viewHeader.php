<header class="{CONTAINER} clearfix theme-bg">
<div class="float-start">
<img class="logo-img mx-2" src="{LINK_ROOT}application/images/shouri-white.png" />
<span class="logo-text">{PAGE_TITLE}</span>
</div>
<?php use framework as F;

if (F\arrayGet($this->pageData, "is_logged_in", false))
{
    // Show user menu
    echo "<div class=\"dropdown float-end mt-2 me-5\">\n";
    echo "<span class=\"cursor-pointer fs-5\" data-bs-toggle=\"dropdown\">{ICON_USER}</span>\n";
    echo "<ul class=\"dropdown-menu\">\n";
    // TODO: link to my account page
    // echo "<li><a class=\"dropdown-item theme-hover no-link-color\" href=\"{LINK_ROOT}my-account\" {LNK_SHOW_LOADER}>My account</a></li>\n";
    // Form for log out
    echo "<li><form action=\"{LINK_ROOT}api\" method=\"post\">\n";
    echo "<input type=\"hidden\" name=\"on_success\" value=\"\" />\n";
    echo "<input type=\"hidden\" name=\"on_failure\" value=\"{REQUEST_URI}\" />\n";
    echo "<input type=\"hidden\" name=\"title\" value=\"Log out\" />\n";
    echo "<button class=\"dropdown-item theme-hover\" type=\"submit\" name=\"action\" value=\"log_out\" {BTN_SHOW_LOADER}>Log out</button>\n";
    echo "</form></li>\n";
    echo "</ul>\n";
    echo "</div>\n";
}

?>
</header>
