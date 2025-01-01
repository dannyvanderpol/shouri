<?php use framework as F;

/* View for all pages */

class ViewApplication extends F\ViewPage
{
    public function __construct($pageName, $pageData)
    {
        $subTitle = F\arrayGet($pageData, "sub_title");
        if ($subTitle != null)
        {
            $subTitle = " - {$subTitle}";
        }

        $this->pageData = $pageData;
        $this->pageTitle = PAGE_TITLE . $subTitle;
        $this->pageFile = "view{$pageName}.php";
        $this->styleSheets = [
            "application/styles/bootstrap.min.css",
            "application/styles/shouri.css",
            "application/styles/color-theme.css"
        ];
        $this->javaScriptFiles = [
            "application/js/bootstrap.bundle.min.js",
            "application/js/modal.js"
        ];
    }

    public function generateBody()
    {
        $output = "<body>\n";
        $output .= $this->getContentFromPageFile("viewHeader.php");
        $output .= $this->getContentFromPageFile("viewModal.php");
        $output .= "<div class=\"{CONTAINER} main-content\">\n";
        $output .= $this->getContentFromPageFile($this->pageFile);
        $output .= "</div>\n";
        $output .= $this->getContentFromPageFile("viewFooter.php");
        $output .= "</body>\n";
        return $output;
    }
}
