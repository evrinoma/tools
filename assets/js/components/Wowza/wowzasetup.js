$(document).ready(function () {

    $(".liveWowza").each(function () {
        var $settings = $(this).find('.settings');
        if ($settings.length) {
            var http = $settings.attr('http') || null;
            $settings.removeAttr('http');
            var stream = $settings.attr('stream') || null;
            $settings.removeAttr('stream');
            var startplay = parseInt($settings.attr('startplay'), 10) || 0;
            startplay = (startplay) ? true : false;
            $settings.removeAttr('startplay');
            var faidIn = $settings.attr('faidIn') || 3000;
            $settings.removeAttr('faidIn');
            var wowzaLive = $settings.attr('id') || null;
            $settings.removeClass('settings');
            if (wowzaLive != null) {
                $.get(http + stream + "/playlist.m3u8", function () {
                    $.getWowzaPlayer(wowzaLive, http, stream, startplay);
                    $.showWowzaPlayer($settings, faidIn);
                });
            }
        }
    });
});

$.getWowzaPlayer = function (wowzaLive, http, stream, startplay) {
    //"license": "PLAY1-aZwaP-Dhhhw-9xeUz-8VHbb-npuEc"//
    WowzaPlayer.create(wowzaLive,
        {
            "license": "PLAY1-aZwaP-Dhhhw-9xeUz-8VHbb-npuEc",
            "title": "",
            "description": "",
            "sourceURL": http + stream + "/playlist.m3u8",
            "autoPlay": startplay,
            "volume": "75",
            "mute": true,
            "loop": false,
            "audioOnly": false,
            "uiShowQuickRewind": false,
            "uiQuickRewindSeconds": "30"
        }
    );
}

$.showWowzaPlayer = function ($settings, fadeIn) {
    var identity = $settings.parents('td').attr('identity');
    var $actions = $settings.parents('tr').find("td.actions[identity^='" + identity + "']");
    var $liveCamera = $settings.parents('tr').find("td.camera[identity^='" + identity + "']");
    if ($liveCamera.length) {
        $liveCamera.each(function () {
            var $cameraTd = $(this);
            var $nameDiv = $cameraTd.find(".name");
            var $liveWowzaDiv = $cameraTd.find(".liveWowza");
            var $wowza = $cameraTd.find('.wowzaplayer');
            if ($wowza.length) {
                if ($liveWowzaDiv.length) {
                    var width = $liveWowzaDiv.attr('width');
                    var height = $liveWowzaDiv.attr('height');
                    if (width !== undefined && height !== undefined) {
                        $wowza.css('width', width + 'px');
                        $wowza.css('height', height + 'px');
                    }
                }
                if ($nameDiv.length) {
                    $nameDiv.fadeIn(fadeIn);
                }
                if ($liveWowzaDiv.length) {
                    $liveWowzaDiv.fadeIn(fadeIn);
                }
            }
        })
    }
    if ($actions.length) {
        $actions.each(function () {
            var $actionsTd = $(this);
            var $actionsDiv = $actionsTd.find(".livecontrol-actions");
            if ($actionsDiv.length) {
                $actionsDiv.fadeIn(fadeIn);
            }
        });
    }
}
