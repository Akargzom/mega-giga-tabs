window.addEventListener('DOMContentLoaded', function () {
    'use strict';
    (function() {
        tinymce.PluginManager.add('true_mce_button', function( editor, url ) { 
            editor.addButton('true_mce_button', { 
                text: '[tabz!!!]', 
                title: 'Вставить шорткод [tabz]', 
                icon: false,
                onclick: function() {
                    editor.insertContent('[tabz title=""]');
                }
            });
        });
    })();
});