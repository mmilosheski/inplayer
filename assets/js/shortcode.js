jQuery(document).ready(function($) {

    tinymce.create('tinymce.plugins.wpse72394_plugin', {
        init : function(ed, url) {
               /**
               * Inserts shortcode content
               */
               ed.addButton( 'inplayer_protectedcontent', {
                    text: 'Add Package1',
                    title : 'Add Package1',
                    icon : 'icon inpalyer-icon',
                    cmd: 'button_green_cmd1'
               });

               ed.addCommand( 'button_green_cmd1', function() {
                selected = tinyMCE.activeEditor.selection.getContent();

                    if( selected ){
                        //If text is selected when button is clicked
                        //Wrap shortcode around it.
                        content =  '[inplayer_protectedcontent ovp_video_id=&quot;5070wptest1111&quot; packagename=&quot;Package1&quot; period=&quot;1&quot; tarrif_option_id=&quot;week&quot; price=&quot;10&quot; is_recurrent=&quot;0&quot;]'+selected+'[/inplayer_protectedcontent]';
                        //content =  '[inplayer_protectedcontent /*"'+a.data.publisherid+'" "'+a.data.postid+'" "'+a.data.sourceurl+'" "'+a.data.ovp+'" "'+a.data.ovppostid+'"*/]'+selected+'[/inplayer_protectedcontent]';
                    }else{
                        content =  '[inplayer_protectedcontent ovp_video_id=&quot;5070wptest1111&quot; packagename=&quot;Package1&quot; period=&quot;1&quot; tarrif_option_id=&quot;week&quot; price=&quot;10&quot; is_recurrent=&quot;0&quot;][/inplayer_protectedcontent]';
                    }

                    tinymce.execCommand('mceInsertContent', false, content);

               });
               /**
               * Adds HTML tag to selected content
               */
               ed.addButton( 'inplayer_protectedcontent', {
                    text: 'Add Package2',
                    title : 'Add Package2',
                    icon : 'icon inpalyer-icon',
                    cmd: 'button_green_cmd'
               });
               ed.addCommand( 'button_green_cmd', function() {
                    selected = tinyMCE.activeEditor.selection.getContent();

                    if( selected ){
                        //If text is selected when button is clicked
                        //Wrap shortcode around it.
                        content =  '[inplayer_protectedcontent ovp_video_id=&quot;5070wptest1112&quot; packagename=&quot;Package2&quot; period=&quot;2&quot; tarrif_option_id=&quot;week&quot; price=&quot;15&quot; is_recurrent=&quot;0&quot;]' +
                                selected +
                                '[/inplayer_protectedcontent]';
                        //content =  '[inplayer_protectedcontent /*"'+a.data.publisherid+'" "'+a.data.postid+'" "'+a.data.sourceurl+'" "'+a.data.ovp+'" "'+a.data.ovppostid+'"*/]'+selected+'[/inplayer_protectedcontent]';
                    }else{
                        content =  '[inplayer_protectedcontent ovp_video_id=&quot;5070wptest1112&quot; packagename=&quot;Package2&quot; period=&quot;2&quot; tarrif_option_id=&quot;week&quot; price=&quot;15&quot; is_recurrent=&quot;0&quot;][/inplayer_protectedcontent]';
                    }

                    tinymce.execCommand('mceInsertContent', false, content);
               });
                ed.addButton('custom_mce_button', {
                text: 'Add Custom Package',
                title: 'Add Custom Package',
                icon: 'icon inpalyer-icon',
                onclick: function() {
                    ed.windowManager.open({
                        title: 'Add Custom Package & Tarrif',
                        body: [{
                        type: 'textbox',
                        name: 'packagename',
                        label: 'Package Name',
                        value: ''
                    }, {
                        type: 'textbox',
                        name: 'ovp_video_id',
                        label: 'OVP ID',
                        value: ''
                    }, {
                        type: 'textbox',
                        name: 'period',
                        label: 'Tarrif Duration',
                        value: ''
                    }, {
                        type: 'listbox',
                        name: 'tarrif_option_id',
                        label: 'Tarrif Period',
                        values: [{
                            text: 'Minutes',
                            value: 'minutes'
                        }, {
                            text: 'Hours',
                            value: 'hours'
                        }, {
                            text: 'Days',
                            value: 'days'
                        }, {
                            text: 'Weeks',
                            value: 'week'
                        }, {
                            text: 'Months',
                            value: 'month'
                        }, {
                            text: 'Unlimited Only',
                            value: 'unlimited'
                        }]
                    }, {
                        type: 'textbox',
                        name: 'price',
                        label: 'Tarrif Price',
                        value: ''
                    }, {
                        type: 'listbox',
                        name: 'is_recurrent',
                        label: 'Recurrent Tarrif',
                        values: [{
                            text: 'Yes',
                            value: '1'
                        }, {
                            text: 'No',
                            value: '0'
                        }]
                    }],
                        onsubmit: function(e) {
                            selected = tinyMCE.activeEditor.selection.getContent();

                            if( selected ){
                            //If text is selected when button is clicked
                            //Wrap shortcode around it.
                                    
                            ed.insertContent(
                                '[inplayer_protectedcontent ovp_video_id=&quot;' + 
                                e.data.ovp_video_id + 
                                '&quot; packagename=&quot;' +
                                e.data.packagename +
                                '&quot; period=&quot;' +
                                e.data.period +
                                '&quot; tarrif_option_id=&quot;' +
                                e.data.tarrif_option_id +
                                '&quot; price=&quot;' +
                                e.data.price +
                                '&quot; is_recurrent=&quot;' +
                                e.data.is_recurrent +
                                '&quot;]' +
                                selected +
                                '[/inplayer_protectedcontent]'
                            );
                            } else{
                                content =  '[inplayer_protectedcontent ovp_video_id=&quot;' + 
                                e.data.ovp_video_id + 
                                '&quot; packagename=&quot;' +
                                e.data.packagename +
                                '&quot; tarrif_option_id=&quot;' +
                                e.data.tarrif_option_id +
                                '&quot; price=&quot;' +
                                e.data.price +
                                '&quot; is_recurrent=&quot;' +
                                e.data.is_recurrent +
                                '&quot;][/inplayer_protectedcontent]';
                            }
                        }
                    });
                }
        });
          },
          createControl : function(n, cm) {
               return null;
          },  
    });

    // Register our TinyMCE plugin
    // first parameter is the button ID1
    // second parameter must match the first parameter of the tinymce.create() function above
    tinymce.PluginManager.add('wpse72394_button', tinymce.plugins.wpse72394_plugin);
});