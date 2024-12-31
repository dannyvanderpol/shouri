<?php use framework as F;

/* View for all pages */

class ViewApplication extends F\ViewPage
{
    public function __construct($pageName)
    {
        $this->pageTitle = PAGE_TITLE;
        $this->pageFile = "view{$pageName}.php";
        $this->styleSheets = [
            "application/styles/bootstrap.css",
            "application/styles/shouri.css",
            "application/styles/color-theme.css"
        ];
    }

    public function generateBody()
    {
        $output = "<body>\n";
        $output .= $this->getContentFromPageFile("viewHeader.php");
        $output .= "<div class=\"{CONTAINER}\">\n";
        $output .= $this->getContentFromPageFile($this->pageFile);
        $output .= "</div>\n";
        $output .= "</body>\n";
        return $output;
    }
}
