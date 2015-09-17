var $ = jQuery;
$( document ).ready(function() {

	var $ = jQuery;
	$(function(){
	$('a[title]').tooltip();
	});


	 var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
                $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-primary').addClass('btn-default');
            $item.addClass('btn-primary');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;
            var videoid = $( "#videoids" ).val();
            var ovps = $( "#ovps" ).val();
        	var apps = $( "#apps" ).val();

        	//var videoidshortcode = document.getElementById("videoid1");
        	//var ovpshortcode = document.getElementById("ovp1");
        	//var appshortcode = document.getElementById("app1");
        	$('#videoid1').html(videoid);
        	$('#ovp1').html(ovps);
        	$('#app1').html(apps);

        	var shortcodetodbtmp = $( "#shortcodetodb" ).html();
        	var shortcodetodb = shortcodetodbtmp.toString();
        	var shortcodetodb1 = shortcodetodb.toString();
        	


        	console.log(shortcodetodb);

        	console.log(videoid);
        	console.log(ovps);
        	console.log(apps);

        $(".form-group").removeClass("has-error");
        for(var i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid)
            nextStepWizard.removeAttr('disabled').trigger('click');
    });
        	

    $('div.setup-panel div a.btn-primary').trigger('click');
    var scope = '';
		jQuery(function(){
			var $ = jQuery;

			$(".inp-tag-holder").click(function(event){
				if($(event.target).hasClass("remove"))
					$(event.target).parent().remove();
			})

			function addTag(){
				var tag = $(".premium_tags", scope).val();
				if(tag == "")
					return;

				$(".inp-tag-holder", scope).append("<div class='tag'><div class='text'>" + tag + "</div><div class='remove'></div>" 
					+ "<input type='hidden' name='inplayer[tags][]' value='" + tag  + "'>" 
					+ "</div>"
			);
				$(".premium_tags", scope).val("");
				$(".premium_tags", scope).focus();
			}
			$(".inp-tag-entry .add_tag").click(function(){
				addTag();
			});

			$(".inp-tag-entry .premium_tags").keypress(function(event){
				if(event.which == 13){
					addTag();
					event.stopPropagation();
					return false;
				}
			});
								  	                                                                                        									
			$(".premium_tags").suggest("admin-ajax.php?action=ajax-tag-search&tax=post_tag", {minchars:1,multiple:true,multipleSep:""});

		});
        $("a#copyshortcode").zclip({
           path:"http://localhost/wordpress/wp-content/plugins/inplayer/assets/js/ZeroClipboard.swf",
           copy:function(){return $("input#shortcodebox").val();}
        });
        //$(function () {
        	$('#table').dataTable({"pageLength": 5});

        	
    /*$( '#table' ).searchable({
        striped: true,
        oddRow: { 'background-color': '#f5f5f5' },
        evenRow: { 'background-color': '#fff' },
        searchType: 'fuzzy'
    });
    
    $( '#searchable-container' ).searchable({
        searchField: '#container-search',
        selector: '.row',
        childSelector: '.col-xs-4',
        show: function( elem ) {
            elem.slideDown(100);
        },
        hide: function( elem ) {
            elem.slideUp( 100 );
        }
    })*/
//});
 $('.collapse').on('show.bs.collapse', function() {
        var id = $(this).attr('id');
        $('a[href="#' + id + '"]').closest('.panel-heading').addClass('active-faq');
        $('a[href="#' + id + '"] .panel-title span').html('<i class="glyphicon glyphicon-minus"></i>');
    });
    $('.collapse').on('hide.bs.collapse', function() {
        var id = $(this).attr('id');
        $('a[href="#' + id + '"]').closest('.panel-heading').removeClass('active-faq');
        $('a[href="#' + id + '"] .panel-title span').html('<i class="glyphicon glyphicon-plus"></i>');
    });
});