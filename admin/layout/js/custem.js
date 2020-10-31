$(function (){
    'use strict';


    $("select").selectBoxIt();

    $('[placeholder]').focus( function (){

        $(this).attr('data-text', $(this).attr('placeholder'));

        $(this).attr('placholder', '');

    }).blur(function (){
        $(this).attr('placeholder', $(this).attr('data-text'));
    });

    $('.confirm').click(function(){
        return confirm('Are you sure?');
    });
});
