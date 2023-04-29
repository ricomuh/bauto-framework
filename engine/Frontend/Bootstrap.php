<?php

namespace Engine\Frontend;

class Bootstrap
{
    protected $cdn = 'https://cdn.jsdelivr.net/npm/bootstrap@5';

    /**
     * Bootstrap renderHtml.
     * 
     * @return string
     */
    public function renderHtml()
    {
        $html = '';

        $html .= '<link rel="stylesheet" href="' . $this->cdn . '/dist/css/bootstrap.min.css">';

        return $html;
    }

    /**
     * Bootstrap renderCss.
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->renderHtml();
    }

    /**
     * Bootstrap renderJs.
     * 
     * @return string
     */
    public function renderJs()
    {
        $html = '';

        $html .= '<script src="' . $this->cdn . '/dist/js/bootstrap.bundle.min.js"></script>';

        return $html;
    }
}
