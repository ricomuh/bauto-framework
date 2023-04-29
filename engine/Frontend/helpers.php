<?php

if (!function_exists('google_fonts')) {
    /**
     * Create a new google fonts instance.
     *
     * @param array $fonts
     * @return GoogleFonts
     */
    function google_fonts($fonts = [])
    {
        return new Engine\Frontend\GoogleFonts($fonts);
    }
}

if (!function_exists('tailwind')) {
    /**
     * Create a new tailwind instance.
     *
     * @return Tailwind
     */
    function tailwind()
    {
        return new Engine\Frontend\Tailwind();
    }
}

if (!function_exists('bootstrap')) {
    /**
     * Create a new bootstrap instance.
     *
     * @return Bootstrap
     */
    function bootstrap()
    {
        return new Engine\Frontend\Bootstrap();
    }
}
