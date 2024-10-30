jQuery(document).ready(function($){

    var $plugin_section = $('.contact-member-team-settings');

    if($plugin_section.length == 0)
        return;

    /* MESSAGES */

    // ADD MESSAGE
    $('.ctm-add-message').on('click', function(){
        $clone = $(this).parent().find('.ctm-form-group').first().clone();
        $clone.find('input, textarea').val('');
        $clone.insertBefore($(this));
        calculate_index();
    });

    // REMOVE MESSAGE
    $('.ctm-remove-message').on('click', function(){
        if($(this).parent().siblings('.ctm-form-group').length > 0)
            $(this).parent().remove();
        else
            $(this).parent().find('input, textarea').val('');

        calculate_index();
    });

    // TOOLS

    function calculate_index()
    {
        $plugin_section.find('.form-table tr').each(function(){
            var count = 0;
            $(this).find('.ctm-form-group.multiple').each(function() {
                $(this).data('index', count);
                var option_name = $(this).data('option-name');

                $(this).find('.field').each(function(){
                    $(this).attr('name', option_name + '[' + count + ']');
                });
                count++;
            });
        });
    }
});