<?php

namespace App\Core\Adapters;


/**
 * Adapter class to make the Metronic core lib compatible with the Laravel functions
 *
 * Class Util
 *
 * @package App\Core\Adapters
 */
class Bootstrap extends \App\Core\Bootstrap
{
    public static function run()
    {
        parent::run();

        if (isRTL()) {
            // RTL html attributes
            Theme::addHtmlAttribute('html', 'dir', 'rtl');
            Theme::addHtmlAttribute('html', 'direction', 'rtl');
            Theme::addHtmlAttribute('html', 'style', 'direction:rtl;');
        }
    }
}
