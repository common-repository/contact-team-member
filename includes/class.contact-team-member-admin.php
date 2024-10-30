<?php

/**
 * Class ContactTeamMemberAdmin
 * -----------------------
 */

class ContactTeamMemberAdmin extends ContactTeamMemberCore {

    public function __construct() {

    }

    public static function init()
    {
        self::hooks();
    }

    private function hooks()
    {
        add_action('admin_init', array('ContactTeamMemberAdmin', 'settings_fields'), 5 );
        add_action('admin_menu', array('ContactTeamMemberAdmin', 'settings'));
        add_action('admin_enqueue_scripts', array('ContactTeamMemberAdmin', 'admin_styles'), 11 );
        add_action('admin_enqueue_scripts', array('ContactTeamMemberAdmin', 'admin_scripts'), 12 );

    }

    public static function  admin_styles() {

        $admin_handle = self::get_plugin_slug() . '_admin_css';

        wp_register_style( $admin_handle, CTM_URL_STYLES . '/admin.css', false, '1.0.0' );
        wp_enqueue_style( $admin_handle );

    }

    public static function  admin_scripts($hook) {

        $admin_handle = self::get_plugin_slug() . '_admin_js';
        wp_enqueue_script( $admin_handle, CTM_URL_SCRIPTS . '/admin.js', array('jquery'));

        $translation_array = array();
        wp_localize_script( $admin_handle, 'alert_message', $translation_array );

    }

    public static function settings()
    {
        add_options_page( __('Contact Team Member', self::get_locale_slug()), __('Contact Team Member', self::get_locale_slug()), 'manage_options', self::settings_slug(), array('ContactTeamMemberAdmin', 'settings_page'));
    }

    public static function settings_page()
    {

        $action = self::get_plugin_slug() . '-update-settings';
        $nonce = wp_create_nonce( $action );

        ?>
        <div class="wrap contact-member-team-settings">
            <h2><?php _e('Contact Team Member - Settings', self::get_locale_slug()); ?></h2>
            <form method="post" action="options.php">
                <?php

                settings_fields( self::settings_slug() );
                do_settings_sections( self::settings_slug() );

                ?>
                <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save changes', self::get_locale_slug()); ?>"></p>
            </form>
        </div>


        <div class="clear"></div>
        <?php
    }

    public static function settings_fields() {

        // SECTION - SETTINGS

        add_settings_section(
            self::settings_slug('_'),
            __('Main settings', self::get_locale_slug()),
            array('ContactTeamMemberAdmin', 'settings_section'),
            self::settings_slug()
        );

        // Option : Message

        add_settings_field(
            self::settings_slug('_') . '_message',
            __( 'Message(s)', self::get_locale_slug() ),
            array('ContactTeamMemberAdmin', 'settings_fields_message'),
            self::settings_slug(),
            self::settings_slug('_')
        );
        register_setting( self::settings_slug(), self::settings_slug('_') . '_message' );

        // Option : Avatar

        add_settings_field(
            self::settings_slug('_') . '_avatar',
            __( 'Avatar', self::get_locale_slug() ),
            array('ContactTeamMemberAdmin', 'settings_fields_avatar'),
            self::settings_slug(),
            self::settings_slug('_')
        );
        register_setting( self::settings_slug(), self::settings_slug('_') . '_avatar' );

        // Option : Link

        add_settings_field(
            self::settings_slug('_') . '_link',
            __( 'Link (internal or external)', self::get_locale_slug() ),
            array('ContactTeamMemberAdmin', 'settings_fields_link'),
            self::settings_slug(),
            self::settings_slug('_')
        );
        register_setting( self::settings_slug(), self::settings_slug('_') . '_link' );

        // Option : Notification

        add_settings_field(
            self::settings_slug('_') . '_notification',
            __( 'Notification style', self::get_locale_slug() ),
            array('ContactTeamMemberAdmin', 'settings_fields_notification'),
            self::settings_slug(),
            self::settings_slug('_')
        );
        register_setting( self::settings_slug(), self::settings_slug('_') . '_notification' );

        // Option : Gravity form

        add_settings_field(
            self::settings_slug('_') . '_gravity_form',
            __( 'Gravity form (ID)', self::get_locale_slug() ),
            array('ContactTeamMemberAdmin', 'settings_fields_gravity_form'),
            self::settings_slug(),
            self::settings_slug('_')
        );
        register_setting( self::settings_slug(), self::settings_slug('_') . '_gravity_form' );
    }

    public static function settings_section() {
    }


    public static function settings_fields_message()
    {
        $messages = self::get_options('message');

        if(count($messages) == 0 || !is_array($messages))
            $messages = array("");

        $count = 0;

        foreach ($messages as $message):
        ?>
            <div class="<?php echo self::get_plugin_slug(); ?>-form-group multiple" data-option-name="<?php echo self::settings_slug('_'); ?>_message">
                <textarea class="field" data-field-name="" name="<?php echo self::settings_slug('_'); ?>_message[<?php echo $count; ?>]" type="text"><?php echo $message; ?></textarea>
                <a class="<?php echo self::get_plugin_slug(); ?>-remove-message action-tool"><?php _e('Remove', self::get_locale_slug()); ?></a>
            </div>
        <?php
            $count++;
        endforeach;
        ?>
        <a class="<?php echo self::get_plugin_slug(); ?>-add-message button"><?php _e('Add a new message', self::get_locale_slug()); ?></a>
        <p><small><?php _e('You can insert html tags in your content, if you enter several messages, they will be displayed randomly.', self::get_locale_slug()); ?></small></p>
        <?php
    }

    public static function settings_fields_avatar()
    {
        echo '<input name="' . self::settings_slug('_') . '_avatar' . '" id="'. self::settings_slug('_') . '_avatar' . '" type="text" value="'.self::get_options('avatar').'">';
        ?>
        <p><small><?php _e('Give the link to the picture display, you can add it to the media library to retrieve the link. The image must be square and the dimensions must be at least 150x150px.', self::get_locale_slug()); ?></small></p>
        <?php
    }

    public static function settings_fields_link()
    {
        echo '<input name="' . self::settings_slug('_') . '_link' . '" id="'. self::settings_slug('_') . '_link' . '" type="text" value="'.self::get_options('link').'" placeholder="http://example.com">';
        ?>
        <p><small><?php _e('You can fill an external or internal link as desired.', self::get_locale_slug()); ?></small></p>
        <?php
    }

    public static function settings_fields_notification()
    {
        $checked = "";
        $value = self::get_options('notification');
        if($value == 1 || $value == "1")
            $checked = "checked";

        echo '<input name="' . self::settings_slug('_') . '_notification' . '" id="'. self::settings_slug('_') . '_notification' . '" type="checkbox" value="1" ' . $checked . '>';
        ?>
        <p><small><?php _e('Bring up the message as a notification bubble requiring action to display the message.', self::get_locale_slug()); ?></small></p>
        <?php
    }


    public static function settings_fields_gravity_form()
    {
        echo '<input name="' . self::settings_slug('_') . '_gravity_form' . '" id="'. self::settings_slug('_') . '_gravity_form' . '" type="text" value="'.self::get_options('gravity_form').'" placeholder="0">';
        ?>
        <p><small><?php _e('Specify the form id to point to click on the bubble.', self::get_locale_slug()); ?></small></p>
        <?php
    }

    public static function get_options($option_name)
    {
        return get_option(self::settings_slug('_') . '_' . $option_name);
    }

    private function settings_slug($separator = '-')
    {
        if($separator == '-') return apply_filters( self::get_plugin_slug() . '_admin_settings_slug',  self::get_plugin_slug() . '-settings');
        else return apply_filters( self::get_plugin_slug() . '_admin_settings_slug_underscore',  self::get_plugin_slug() . '_settings');
    }
}