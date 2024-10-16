function emoticonchooser(instance_name = '', this_instance = '') {
    var use_emoticon  = 'use_emoticon_'+instance_name;
    var toggle_emobar = 'toggle_emoticon_bar_'+instance_name;
    var drop_handler  = 'drop_handler_'+instance_name;

    const capturingRegex = /(?<area>nugget|quick)/; //all nuggets(\d+) and plugin adminnotes quicknote // NO QUOTES !!!!
    const found = instance_name.match(capturingRegex);
    const instance = (found !== null) ? instance_name : this_instance;

    plainTextArea = function(id, img) {
        // default case: no wysiwyg editor
        txtarea = document.getElementById(id);
        if (txtarea.selectionEnd) {
            lft = txtarea.value.substring(0, txtarea.selectionEnd);
            rgt = txtarea.value.substring(txtarea.selectionEnd);
            txtarea.value = lft + ' ' + img + ' ' + rgt;
        } else {
            txtarea.value  += ' ' + img + ' ';
        }

        // alert(obj);
        txtarea.focus();
    }

    window[toggle_emobar] = function () {
        el = document.getElementById('serendipity_emoticonchooser_'+instance_name+'');
        if (el.style.display == 'none') {
            el.style.display = 'inline-flex';
        } else {
            el.style.display = 'none';
        }
    }

    // NOT with tinyMCE though (tinyMCE is emojis only)
    window[use_emoticon] = function (img) {
        // uncovered since change to TinyMCE
        if (typeof(CKEDITOR) !== 'undefined') {
            var oEditor = CKEDITOR.instances[instance];
            oEditor.insertHtml(img);
        } else {
            plainTextArea(instance, img);
        }
    }

    if (window.jQuery && typeof(CKEDITOR) !== 'undefined') {
        jQuery(function ($) {
            window[drop_handler] = function (emo, target) {
                var rdata = CKEDITOR.instances[target].getSnapshot(); // this is equal to emo!!! while .getData() changes attributes order!!
                var rdata = rdata.replace(rdata.match(/<a href="javascript:use_emoticon_.*>.*<\/a>/g), emo); // [OK]
                CKEDITOR.instances[target].setData(rdata);
                return true;
            }
            // fake drag&drop
            var mouse_button = false;
            $('#serendipity_emoticonchooser_'+instance_name+'').find('img')
                .mousedown(function() {
                    mouse_button = true;
                })
                .mouseup(function() {
                    mouse_button = false;
                })
                .mouseout(function() {
                    if (mouse_button) {
                        window[drop_handler]($(this)[0].outerHTML, instance);
                        mouse_button = false;
                    }
                });
        });
    }
}
