import tabberObj from './tabber-minimized.js';

$(document).ready(function () {
    $('.moduleheader').click(function () {
        var paneName = $(this).attr('pane');
        if (paneName !== undefined) {
            toggleInfoPane(paneName);
        }
    });
});

function toggleInfoPane(pane) {
    var style = document.getElementById(pane).style;
    if (style.display == 'none' || style.display == '') {
        style.display = 'block';
    } else {
        style.display = 'none';
    }
}

function showhide_upgrades() {
    var upgradesonly = document.getElementById('show_upgradable_only').checked;
    var module_re = /^module_([a-z0-9_]+)$/;   // regex to match a module element id
    var cat_re = /^category_([a-zA-Z0-9_]+)$/; // regex to match a category element id
    var elements = document.getElementById('modulelist').getElementsByTagName('li');
    // loop through all modules, check if there is an upgrade_<module> radio box
    for (i = 0; i < elements.length; i++) {
        if (match = elements[i].id.match(module_re)) {
            if (!document.getElementById('upgrade_' + match[1])) {
                // not upgradable
                document.getElementById('module_' + match[1]).style.display = upgradesonly ? 'none' : 'block';
            }
        }
    }
    // hide category headings that don't have any visible modules
    var elements = document.getElementById('modulelist').getElementsByTagName('div');
    // loop through category items
    for (i = 0; i < elements.length; i++) {
        if (elements[i].id.match(cat_re)) {
            var subelements = elements[i].getElementsByTagName('li');
            var display = false;
            for (j = 0; j < subelements.length; j++) {
                // loop through children <li>'s, find names that are module element id's
                if (subelements[j].id.match(module_re) && subelements[j].style.display != 'none') {
                    // if at least one is visible, we're displaying this element
                    display = true;
                    break; // no need to go further
                }
            }
            document.getElementById(elements[i].id).style.display = display ? 'block' : 'none';
        }
    }
}

var box;

function process_module_actions(actions) {
    urlStr = "config.php?type=&amp;display=modules&amp;extdisplay=process&amp;quietmode=1";
    for (var i in actions) {
        urlStr += "&amp;moduleaction[" + i + "]=" + actions[i];
    }
    box = $('<div></div>')
        .html('<iframe frameBorder="0" src="' + urlStr + '"></iframe>')
        .dialog({
            title: 'Status',
            resizable: false,
            modal: true,
            height: "auto",
            width: '400px',
            close: function (e) {
                close_module_actions(true);
                $(e.target).dialog("destroy").remove();
            }
        });

}

function close_module_actions(goback) {
    box.dialog("destroy").remove();
    if (goback) {
        location.href += "?display=modules";
    }
}