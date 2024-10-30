<?php

/**
 * Class ContactTeamMember
 * -----------------------
 */

class ContactTeamMember extends ContactTeamMemberCore {

    public function __construct() {

    }

    public static function plugin_activation()
    {

    }

    public static function plugin_deactivation()
    {

    }

    public static function init()
    {
        self::load_textdomain();
        self::frontend_hooks();
    }

    private function load_textdomain()
    {
        do_action(self::get_plugin_slug() . '_load_textdomain');

        // Set filter for plugin's languages directory
        $sglang_dir =  CTM_FILE_PATH . 'languages';
        $sglang_dir = apply_filters( self::get_plugin_slug() . '_languages_directory', $sglang_dir );

        $locale = apply_filters( 'plugin_locale', get_locale(), self::get_locale_slug() );

        load_textdomain( self::get_locale_slug(),  $sglang_dir . "/$locale.mo" );
    }

    private function frontend_hooks()
    {
        do_action(self::get_plugin_slug() . '_frontend_hooks');

        add_action('wp_enqueue_scripts', array('ContactTeamMember', 'register_styles'), 11 );
        add_action('wp_enqueue_scripts', array('ContactTeamMember', 'register_scripts'), 12 );
        add_action('wp_footer', array('ContactTeamMember', 'wp_footer_add_ctm_bubble'), 10 );
    }

    public static function  register_styles() {

        $front_handle = self::get_plugin_slug() . '_front_css';

        wp_register_style( $front_handle, CTM_URL_STYLES . '/screen.css', false, '1.0.0' );
        wp_enqueue_style( $front_handle );

    }

    public static function  register_scripts($hook) {

        $front_handle = self::get_plugin_slug() . '_front_js';
        wp_enqueue_script( $front_handle, CTM_URL_SCRIPTS . '/front.js', array('jquery'));

    }

    public static function  wp_footer_add_ctm_bubble($hook) {

        $gravity_id = self::get_option('gravity_form');
        $notification = self::get_option('notification');
        $avatar = self::get_option('avatar');
        $message = self::get_option('message');
        $link = self::get_option('link') . apply_filters(self::get_plugin_slug() . '_url_track_param', '?ref=' . self::get_plugin_slug());

        $rand_keys = array_rand($message, 1);
        $message = $message[$rand_keys];

        $class = (!empty($gravity_id))?" gravity":"";
        $class .= ($notification == 1)?" notification-style":"";

        ?>
        <div id="contact-team-member-bubble" class="<?php echo $class; ?>">
            <div class="inner-content cf">
                <?php if(!empty($message)): ?>
                <a class="bubble go" href="<?php echo $link; ?>">
                    <span class="in"><?php echo $message; ?></span>
                    <?php if(!empty($gravity_id)): ?>
                        <div class="gravity-indication"><?php _e('Click to open form!', self::get_locale_slug()); ?></div>
                    <?php endif; ?>
                </a>
                <?php endif; ?>
                <?php if(!empty($gravity_id)): ?>
                <div class="gravity-form">
                    <?php echo do_shortcode('[gravityform ajax="true" id="' . $gravity_id . '" title="false" description="false"]')?>
                    <div class="close-gravity"><?php _e('Close', self::get_locale_slug()); ?></div>
                </div>
                <?php endif; ?>
                <?php if(!empty($avatar)): ?>
                <div class="bubble-thumbnail">
                    <a class="go" href="<?php echo $link; ?>">
                        <img src="<?php echo $avatar; ?>">
                    </a>
                    <?php if($notification == 1): ?>
                    <div class="notification">1</div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            </div>
        </div>
        <?php

    }
}