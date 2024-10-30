jQuery(document).ready(function($) {

    setTimeout(function(){
        $('#contact-team-member-bubble').addClass('load');
    }, 1000);

    $('#contact-team-member-bubble a.go').on('click', function(e){
        if($(this).parents('#contact-team-member-bubble').hasClass('gravity'))
        {
            e.preventDefault();

            $('#contact-team-member-bubble').toggleClass('gravity-active');

            return false;
        }
    });

    $('#contact-team-member-bubble .gravity-form').on('click', function(){
        var $form = $(this);
        if($(this).find('.gforms_confirmation_message').length > 0)
        {
            $form.addClass('hide');
        }
    });

    $('#contact-team-member-bubble .gravity-form .close-gravity').on('click', function(){
        $('#contact-team-member-bubble').removeClass('gravity-active');
    });

    $('#contact-team-member-bubble').on('mouseenter', function(){
       $(this).removeClass('notification-style');
    });

}); /* end of as page load scripts */
