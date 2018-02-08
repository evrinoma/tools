import menu from './menu.js';
import "jquery-ui/ui/widgets/autocomplete";
import "jquery-ui/ui/widgets/draggable";
import "jquery-ui/ui/widgets/button";
import "jquery-ui/ui/widgets/menu";

$(document).ready(function () {

    //new skin - work in progres!
    //   $('.rnav > ul').menu();
    //   $('.radioset').buttonset();
    $('.menubar').show().menubar();
    //logout button
    $('.logout').click(function () {
        url = window.location.pathname;
        $.get(url + '?logout=true', function () {
            $.cookie('PHPSESSID', null);
            window.location = url;
        });

    });

    //pluck icons out of the markup - no need for js to add them (for buttons)
    $('input[type=submit],input[type=button], button, input[type=reset]').each(function () {
        var prim = (typeof $(this).data('button-icon-primary') == 'undefined')
            ? ''
            : ($(this).data('button-icon-primary'));
        var sec = (typeof $(this).data('button-icon-secondary') == 'undefined')
            ? ''
            : ($(this).data('button-icon-secondary'));
        var txt = (typeof $(this).data('button-text') == 'undefined')
            ? 'true'
            : ($(this).data('button-text'));
        var txt = (txt == 'true') ? true : false;
        $(this).button({icons: {primary: prim, secondary: sec}, text: txt}).addClass("ui-state-default");
    });

    /*
        //show menu on hover
        //this is far from perfect, and will hopefully be depreciated soon
        $('.module_menu_button').hover(
            function(){
                $(this).click()
            },
            function(){

            });

        //show reload button if neede
        if (fpbx.conf.reload_needed) {
            toggle_reload_button('show');
        }

        //show main menu if neede
        if (fpbx.conf.menu) {
            $(".menubar").show();
        }else{
            $(".menubar").hide();
        }

        //style all sortables as menu's
        $('.sortable').menu().find('input[type="checkbox"]').click(function(event) {
            event.stopPropagation();
        });

        //Links are disabled in menu for now. Final release will remove that
        $('.ui-menu-item').click(function(){
            go = $(this).find('a').attr('href');
            if(go && !$(this).find('a').hasClass('ui-state-disabled')) {
                document.location.href = go;
            }
        })

        //reload
        $('#button_reload').click(function(){
            if (fpbx.conf.RELOADCONFIRM == 'true') {
                fpbx_reload_confirm();
            } else {
                fpbx_reload();
            }

        });

        //logo icon
        $('#SITE_BRAND_IMAGE_TANGO_LEFT').click(function(){
            window.open($(this).data('site_brand_image_ite_link_left'),'_newtab');
        });

        //shortcut keys
        //show modules
        $(document).bind('keydown', 'meta+shift+a', function(){
            $('#modules_button').trigger('click');
        });

        //submit button
        $(document).bind('keydown', 'ctrl+shift+s', function(){
            $('input[type=submit][name=Submit]').click();
        });

        //reload
        $(document).bind('keydown', 'ctrl+shift+a', function(){
            fpbx_reload();
        });

        //logout button
        $('#user_logout').click(function(){
            url = window.location.pathname;
            $.get(url + '?logout=true', function(){
                $.cookie('PHPSESSID', null);
                window.location = url;
            });

        });



        //ajax spinner
        $(document).ajaxStart(function(){
            $('#ajax_spinner').show()
        });

        $(document).ajaxStop(function(){
            $('#ajax_spinner').hide()
        });
        */
});