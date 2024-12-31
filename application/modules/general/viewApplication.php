<?php use framework as F;

/* View for all pages */

class ViewApplication extends F\ViewPage
{
    public function __construct($pageName, $pageData)
    {
        $subTitle = (isset($pageData["sub_title"]) ? " - " . $pageData["sub_title"] : "");

        $this->pageData = $pageData;
        $this->pageTitle = PAGE_TITLE . $subTitle;
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
        $output .= "<div class=\"{CONTAINER} main-content\">\n";
        $output .= $this->getContentFromPageFile($this->pageFile);
        $output .= "</div>\n";
        $output .= $this->getContentFromPageFile("viewFooter.php");
        $output .= "</body>\n";
        return $output;
    }
}
