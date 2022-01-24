jQuery(document).ready(function ($) {
    'use strict';
    if ($('#page_css').length && $('#page_css').val() && !$('head > style#riode_page_css').length) {
        $('<style></style>').attr('id', 'riode_page_css').appendTo('head').html($('#page_css').val().replace('/<script.*?\/script>/s', ''));
    }
    $('#page_css').on('input', function (e) {
        if (!$('head > style#riode_page_css').length) {
            $('<style></style>').attr('id', 'riode_page_css').appendTo('head');
        }
        $('style#riode_page_css').html($(this).val().replace('/<script.*?\/script>/s', ''));
    });
});