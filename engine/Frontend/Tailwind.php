<?php

namespace Engine\Frontend;

class Tailwind
{
    protected $cdn = 'https://cdn.tailwindcss.com';

    /**
     * Tailwind renderHtml.
     * 
     * @return string
     */
    public function renderHtml()
    {
        $html = '';

        $html .= '<link rel="stylesheet" href="' . $this->cdn . '">';

        return $html;
    }

    /**
     * Tailwind renderCss.
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->renderHtml();
    }
}
