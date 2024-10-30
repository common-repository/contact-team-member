<?php

/**
 * Class ContactTeamMemberCore
 * -----------------------
 */

class ContactTeamMemberCore {

    private static $plugin_slug = 'ctm';
    private static $locale_slug = 'ctm';

    public function __construct() {

    }

    protected function get_plugin_slug()
    {
        return self::$plugin_slug;
    }

    protected function get_locale_slug()
    {
        return self::$locale_slug;
    }

    protected function get_option($option)
    {
        $option_value = ContactTeamMemberAdmin::get_options($option);
        return $option_value;
    }
}