jQuery(document).ready(function($) {

    tinymce.create('tinymce.plugins.wpse72394_plugin1', {
        init : function(ed, url) {
                // Register command for when button is clicked
                ed.addCommand('wpse72394_insert_shortcode1', function() {
                    selected = tinyMCE.activeEditor.selection.getContent();

                    if( selected ){
                        //If text is selected when button is clicked
                        //Wrap shortcode around it.
                        content =  '[inplayer_protectedcontent1]'+selected+'[/inplayer_protectedcontent1]';
                    }else{
                        content =  '[inplayer_protectedcontent1]';
                    }

                    tinymce.execCommand('mceInsertContent', false, content);
                });

            // Register buttons - trigger above command when clicked
            ed.addButton('wpse72394_button1', {title : 'Wrap Content With Package 2', cmd : 'wpse72394_insert_shortcode1', image: url + '/../img/icon2.png' });
        },   
    });

    // Register our TinyMCE plugin
    // first parameter is the button ID1
    // second parameter must match the first parameter of the tinymce.create() function above
    tinymce.PluginManager.add('wpse72394_button1', tinymce.plugins.wpse72394_plugin1);
});