$( document ).ready(function() {
var is_paid_view;
var paid_or_not;
var video_p;
video_p = $('#video_p').val();

inplayer.ready(function() { 

	inplayer.instances.subscribe(function(action, instance) { 
		if (action == 'user_updated' || action =='pw_updated') {
			// console.log(instance.paywall.is_paid);
			is_paid_view = instance.paywall.is_paid;
			if(is_paid_view === false) {
				paid_or_not = 'notpaid';
			}
			else {
				paid_or_not = 'paid';
			}
		}
		console.log(paid_or_not);

		// jQuery.post(
		// 	// see tip #1 for how we declare global javascript variables
		// 	inplayerAjax.ajaxurl,
		// 	{
		// 		// here we declare the parameters to send along with the request
		// 		// this means the following action hooks will be fired:
		// 		// wp_ajax_nopriv_myajax-submit and wp_ajax_myajax-submit
		// 		action : 'myajax-submit',

		// 		// other parameters can be added along with "action"
		// 		is_paid_view : is_paid_view
		// 	},
		// 	function( response ) {
		// 		alert('SHABAN NEPLATENO');
		// 		// $('#inv_wp_wrap_'+video_p+'').append(response);
		// 		// console.log( response );
		// 	}
		// );

		// var data = {
		// 	'action': 'is_paid',
		// 	'is_paid_view': ajax_object.is_paid_view
		// }
		console.log(is_paid_view);
		jQuery.ajax({
		    type: "POST",
		    url: 'http://inplayer.com/wp-admin/admin-ajax.php', // our PHP handler file
		    data: { action: 'myajax-submit', paid_or_not: paid_or_not },
		    complete: function (response) {
		    		console.log('the ajax is succ')
		        	$('#inv_wp_wrap_'+video_p+'').append(response);
					// console.log('Not Paid content.'); 
		            // console.log(response);									                                   
		        }
		});
	}); 
	
});


});



// $( document ).ready(function() {

// 	// $('*[id*=inv_badge_]:visible').each(function() {
// 	//     $(this).function({
// 		var $ovp = $('#video_p');
// 		var video_p;
// 		video_p = $ovp.val();

// 		var $testChange = $('div#inv_badge_'+video_p+' input#inv_p');
// 		var inv_p;
// 		inv_p = $testChange.val();
		
		// var i = 1;

		// function updateChange() {
		//     console.log('Changed to ' + $testChange.val() + '');
		// }

		// $testChange.on('change', updateChange);

		// var check_for_paid = setInterval(function() {
		//     if($testChange.trigger('change')) {
		    	
		// 	    	if($testChange.val() == '1'){
		// 	    		if($('#inv_wp_wrap_'+video_p+'').html().length == 0) {
		// 	    		inv_p = '1';
		// 	    		console.log('Paid: '+inv_p+' '+video_p);
		// 	        jQuery.ajax({
		// 	            type: "POST",
		// 	            url: "/wp-admin/admin-ajax.php", // our PHP handler file
		// 	            data: { action: 'getContent', inv_p: inv_p, video_p: video_p },
		// 	            success: function (results) {
		// 	                if(results !== '0'){
		// 	                	$('#inv_wp_wrap_'+video_p+'').append(results);
		// 						console.log('Not Paid content.'); 
		// 	                    console.log(results);									                                   
		// 	                }
		// 	                else{
		// 	                	$('#inv_wp_wrap_'+video_p+'').append(results);
		// 	                    console.log("Paid content");
		// 	                    console.log(results);
		// 	                }
		// 	            }
		// 	        });
		// 	        }
		// 	        else {
		// 	        	// $('#inv_wp_wrap_'+video_p+'').empty()
		// 	        	// clearInterval(check_for_paid);
		// 	        }
		//     	}
		//     	else {
		//     		$('#inv_wp_wrap_'+video_p+'').empty();
		//     	}
		//     	// clearInterval(check_for_paid);
		// 	}
		// 	console.log("value changed" +$testChange.val());
		// }, 1000);

		// updateChange();
	 //    });
	// });

	// var $message = $('#message');
	// function doStuff() {
	// 	var $testChange = $('#inv_p');
	// 	// var i = 1;

	// 	function updateChange() {
	// 	    console.log('Changed to ' + $testChange.val() + '');
	// 	}

	// 	$testChange.on('change', updateChange);

	// 	var check_for_paid = setInterval(function() {
	// 	    if($testChange.trigger('change')) {
	// 	    	clearInterval(check_for_paid);
	// 		}
	// 		console.log("value changed" +$testChange.val());
	// 	}, 5000);

	// 	updateChange();
	// }	





	// 	$('#inv_badge_5070wptest1111').bind("DOMSubtreeModified",function(e){
	// 	console.log($("#inv_badge_5070wptest1111").attr("class"));
	//     //console.log('mi mrda nesto mi mrda');
	// });

// var default_value = $( "#inv_p" );

// var changed_value = default_value.val(1);
// var target = document.querySelector('#inv_badge_5070wptest1111 #inv_p');
// // var target1 = document.querySelector('#inv_badge_5070wptest1111 #inv_p');
// // Create an observer instance
// var observer = new MutationObserver(function( mutations ) {
// 	mutations.forEach(function( mutation ) {
//     var newNodes = mutation.target; // DOM NodeList
//    	console.log(newNodes.value);
//    	// console.log(mutation.attributeName);
// 	if( newNodes.value == 1 ) { // If there are new nodes added
// 		observer.disconnect();
// 		console.log('disconnects');
// 	    if(target) {
// 	    console.log('target');
// 		}
// 	    else if(target1) {
// 	    	console.log('target1');
// 	    }
	    
// 	 //    if(target.value == '1') {
// 	 //    	observer.disconnect();
// 	 //    	delete observer;
// 	 //    	console.log('disconnects');
// 		// // var data = {
// 		// // 	'action': 'my_action',
// 		// // 	'whatever': ajax_object.we_value      // We pass php values differently!
// 		// // };
// 		// // // We can also pass the url value separately from ajaxurl for front end AJAX implementations
// 		// // jQuery.post(ajax_object.ajax_url, data, function(response) {
// 		// // 	alert('Got this from the server: ' + response);
// 		// // });
// 		// }
// 		// else {
// 		// 			//
// 		// 			console.log('connected');
// 		// 			// observer.connect();
// 		// 		}
// 	}
// 	else {
// 		console.log('connected');
// 		}

// 	});
// });

// // Configuration of the observer:
// var config = { attributes: true, childList: false, characterData: false, attributeOldValue: true, attributeFilter: ['value']  };

// // Pass in the target node, as well as the observer options
// observer.observe(target, config);
// // observer.observe(target1, config);
// // Later, you can stop observing

// 
// });