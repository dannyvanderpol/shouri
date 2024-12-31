<?php use framework as F;

/* View for all pages */

class ViewApplication extends F\ViewPage
{
    public function __construct($pageName)
    {
        $this->pageTitle = PAGE_TITLE;
        $this->pageFile = "view{$pageName}.php";
        $this->styleSheets = [
            "application/styles/bootstrap.css"
        ];
    }
}