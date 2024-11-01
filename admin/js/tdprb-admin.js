(function( $ ) {
	'use strict';
	$(function() {

		if( jQuery('.tdprb-color-field' ).length ){
			$('.tdprb-color-field').wpColorPicker();
		}
		var editorElement = $('#inline_css');
		
		if (editorElement.length) {
			var settings = JSON.parse(tdprbajax.settings || '{}');
			// Initialize the CodeMirror editor
			var editor = wp.codeEditor.initialize(editorElement, settings);
			var formattedCSS = formatCSS(editor.codemirror.getValue());
			editor.codemirror.setValue(formattedCSS)
			// Define the formatCSS function
			function formatCSS(cssCode) {
				return cssCode
					.replace(/;\s*/g, ';\n')
					.replace(/{\s*/g, '{\n')
					.replace(/}\s*/g, '\n}\n')
					.replace(/(\s{2,})/g, ' ')
					.trim();
			}
		}

		$( document ).on( 'click','#tdprb-access-token-action', function(e){
			e.preventDefault();
			var is_activated = $(this).data('activate');
			if( is_activated == '1' ){
				var access_token = jQuery.trim(jQuery("#tdprb-api-key").val());
				if (access_token.length === 0) {
					jQuery("#tdprb-access-token-notify").html('<p class="tdprb-fail">*Please enter access token</p>');
					return;
				}
				$.ajax({ 
					type: 'post',
					url: tdprbajax.ajaxurl,
					data: {
						action: 'tdprb_token_save', 
						token: access_token,
						nonce: tdprbajax.nonce 
					},
					beforeSend: function() {
						jQuery("#tdprb-access-token-action").attr( 'disabled', 'disabled' );
						jQuery("#tdprb-access-token-action").html('Processing...');
					},
					success: function(data) {
						if (data.status) {
							window.location.reload();
						} else {
							jQuery("#tdprb-access-token-notify").html('<p class="tdprb-fail">' + data.message + '</p>');
							jQuery("#tdprb-access-token-action").attr( 'disabled', false );
							jQuery("#tdprb-access-token-action").html('Activate');
						}
					},
					error: function(xhr, status, error) {
						jQuery("#tdprb-access-token-notify").html('<p class="tdprb-fail">An error occurred: ' + error + '</p>');
						jQuery("#tdprb-access-token-action").attr( 'disabled', false );
						jQuery("#tdprb-access-token-action").html('Activate');
					}
				});
			}else {
				// Deactivation logic
				$.ajax({
					type: 'post',
					url: tdprbajax.ajaxurl,
					data: {
						action: 'tdprb_token_deactivate',
						nonce: tdprbajax.nonce
					},
					beforeSend: function() {
						jQuery("#tdprb-access-token-action").attr( 'disabled', 'disabled' );
						jQuery("#tdprb-access-token-action").html('Processing...');
					},
					success: function(data) {
						if (data.status) {
							window.location.reload();
						} else {
							jQuery("#tdprb-access-token-notify").html('<p class="tdprb-fail">' + data.message + '</p>');
						}
					},
					error: function(xhr, status, error) {
						jQuery("#tdprb-access-token-notify").html('<p class="tdprb-fail">An error occurred: ' + error + '</p>');
					}
				});
			}
		});
		$( document ).on('click','.tdprb-copy-input-field', function() {
			var $tempInput = $('<input>');
			$('body').append($tempInput);
			$tempInput.val($(this).val()).select();
			document.execCommand('copy');
			$tempInput.remove();

			// Display notification
			var $notify = $('#copy-notify');
			$notify.show();
			setTimeout(function() {
				$notify.hide();
			}, 2000);
		});

		//sub item click event
		$(".tdprb-sub-items-label").click(function(e){
			e.preventDefault();
			//$(this).parents('label').next().find(".tdprb-options-slide-wrap").toggleClass('expanded');
			var $toggleItem = jQuery(this).parents('.tdprb-main-item-wrap').find('.tdprb-options-slide-wrap');
			if ($toggleItem.hasClass('expanded')) {
				// Slide up: Reduce height dynamically
				$toggleItem.removeClass('expanded').css('max-height', $toggleItem[0].scrollHeight + 'px');
				
				// Trigger reflow before applying max-height 0 to ensure animation
				setTimeout(function() {
				  $toggleItem.css('max-height', '0');
				}, 10);
		  
				// Optionally hide after the transition
				setTimeout(function() {
				  $toggleItem.css('display', 'none');
				}, 500); // Matches the transition duration
			  } else {
				// Slide down: Set display and max-height dynamically
				$toggleItem.css('display', 'block');
				var targetHeight = $toggleItem[0].scrollHeight + 'px';
				
				// Trigger reflow to reset max-height for the animation
				$toggleItem.css('max-height', '0');
		  
				setTimeout(function() {
				  $toggleItem.addClass('expanded').css('max-height', targetHeight);
				}, 10); // Small delay to ensure the transition triggers
			  }
		});

		$('.tdprb-shape-click').on('click', function(e) {
			e.preventDefault();
			const $this = $(this);
			const $checkbox = $this.find('input[type=checkbox]');
			const isChecked = !$checkbox.prop('checked');
			
			// Toggle the checkbox state and the active class
			$checkbox.prop('checked', isChecked);
			$this.toggleClass('tdprb-box-shadow', isChecked);
		
			// Get all checkboxes and the "all check" checkbox in the same container
			const $container = $this.closest('.tdprb-options-wrap');
			const $allCheckboxes = $container.find('.tdprb-shape-click input[type=checkbox]');
			const $allCheck = $container.find('.tdprb-all-check input[type=checkbox]');
			
			// Determine if all checkboxes are checked
			const allChecked = $allCheckboxes.length === $allCheckboxes.filter(':checked').length;
			
			// Update the "all check" checkbox state and active class
			$allCheck.prop('checked', allChecked);
			$container.find('.tdprb-all-check').toggleClass('tdprb-box-shadow', allChecked);

			if($allCheckboxes.filter(':checked').length == 0){
				$($allCheckboxes[0]).prop('checked', true);
				$($allCheckboxes[0]).parents('label').addClass('tdprb-box-shadow');
			}
			
		});

		$('.tdprb-notshape-click').on('click', function(e) {
			e.preventDefault();
			const $this = $(this);
			const $checkbox = $this.find('input[type=checkbox]');
			const isChecked = !$checkbox.prop('checked');
			
			// Toggle the checkbox state and the active class
			$checkbox.prop('checked', isChecked);
			$this.toggleClass('tdprb-option-active', isChecked);
		
			// Get all checkboxes and the "all check" checkbox in the same container
			const $container = $this.closest('.tdprb-options-wrap');
			const $allCheckboxes = $container.find('.tdprb-shape-click input[type=checkbox]');
			const $allCheck = $container.find('.tdprb-all-check input[type=checkbox]');
			
			// Determine if all checkboxes are checked
			const allChecked = $allCheckboxes.length === $allCheckboxes.filter(':checked').length;
			
			// Update the "all check" checkbox state and active class
			$allCheck.prop('checked', allChecked);
			$container.find('.tdprb-all-check').toggleClass('tdprb-option-active', allChecked);

			if($allCheckboxes.filter(':checked').length == 0){
				$($allCheckboxes[0]).prop('checked', true);
				$($allCheckboxes[0]).parents('label').addClass('tdprb-option-active');
			}
			
		});
		
		$('.tdprb-shape-all-check').on('click', function(e) {
			e.preventDefault();
			
			// Find the checkbox within the clicked element
			const $checkbox = $(this).find('input[type=checkbox]');
			
			// Toggle the checkbox state
			const isChecked = !$checkbox.is(':checked');
			$checkbox.prop('checked', isChecked);
			
			// Toggle the 'tdprb-option-active' class based on the checkbox state
			$(this).toggleClass('tdprb-box-shadow', isChecked);
			
			// Find all other checkboxes within the same container
			var $checkboxes = $(this).closest('.tdprb-options-wrap').find('input[type="checkbox"]');
			
			// Update the state of all checkboxes except the clicked one
			$checkboxes.prop('checked', isChecked);
			
			// Add or remove the 'tdprb-option-active' class based on the checkbox state
			if (isChecked) {
				$checkboxes.parents('label').addClass('tdprb-box-shadow');
			} else {
				$checkboxes.parents('label').removeClass('tdprb-box-shadow');
				$($checkboxes[1]).prop('checked', true);
				$($checkboxes[1]).parents('label').addClass('tdprb-box-shadow');
			}
		})

		$('.tdprb-not-shape-all-check').on('click', function(e) {
			e.preventDefault();
			
			// Find the checkbox within the clicked element
			const $checkbox = $(this).find('input[type=checkbox]');
			
			// Toggle the checkbox state
			const isChecked = !$checkbox.is(':checked');
			$checkbox.prop('checked', isChecked);
			
			// Toggle the 'tdprb-option-active' class based on the checkbox state
			$(this).toggleClass('tdprb-option-active', isChecked);
			
			// Find all other checkboxes within the same container
			var $checkboxes = $(this).closest('.tdprb-options-wrap').find('input[type="checkbox"]');
			
			// Update the state of all checkboxes except the clicked one
			$checkboxes.prop('checked', isChecked);
			
			// Add or remove the 'tdprb-option-active' class based on the checkbox state
			if (isChecked) {
				$checkboxes.parents('label').addClass('tdprb-option-active');
			} else {
				$checkboxes.parents('label').removeClass('tdprb-option-active');
				$($checkboxes[1]).prop('checked', true);
				$($checkboxes[1]).parents('label').addClass('tdprb-option-active');
			}
		});

		$('.tdprb-show-view').on('click', function(e) {
			const $showViews = $('.tdprb-show-view');
			const $gridListViews = $('.tdprb-grid-list-view input[type="radio"]');
			
			const allChecked = $showViews.length === $showViews.filter(':checked').length;
			const $checkedShowViews = $showViews.filter(':checked');
		
			// Iterate through checked show views
			$checkedShowViews.each(function(index, el) {
				const isGridView = $(el).attr('id') === 'show_grid_view';
				const isListView = $(el).attr('id') === 'show_list_view';
		
				$gridListViews.each(function(index, ele) {
					const isDefaultGridView = $(ele).attr('id') === 'Default-show-grid-view';
					const isDefaultListView = $(ele).attr('id') === 'Default-show-list-view';
		
					if ((isGridView && isDefaultGridView) || (isListView && isDefaultListView)) {
						$(ele).prop('checked', true);
					}
				});
			});
		
			const $viewMainWrap = $(this).parents('.tdprb-view-main-wrap');
			const $gridListContainer = $viewMainWrap.find('.tdprb-grid-list-view');
			
			if (allChecked) {
				$gridListContainer.removeClass('tdprb-d-none');
			} else {
				$gridListContainer.addClass('tdprb-d-none');
			}
		
			if ($checkedShowViews.length === 0) {
				$('#show_grid_view, #Default-show-grid-view').prop('checked', true);
			}
		});
		
		$('.tdprb-grid-list-view input[type="radio"]').on('click', function() {
			const isGridView = $(this).attr('id') === 'Default-show-grid-view';
			const targetId = isGridView ? '#show_grid_view' : '#show_list_view';
		
			$(targetId).prop('checked', true);
		});
		
		$('.tdprb-show-view-customization').on('click', function(e) {
			
			const $customizationContainer = $(this).parent().find('.tdprb-show-view-customization');
			const $viewCustomizations = $customizationContainer.find('.tdprb-view-customization');
		
			const allChecked = $viewCustomizations.length === $viewCustomizations.filter(':checked').length;
		
			if ($viewCustomizations.filter(':checked').length === 0) {
				$viewCustomizations.eq(0).prop('checked', true);
			}
			
		});

		$('#current-page-selector').on('keydown', function(e) {
			if (e.keyCode === 13) { // Enter key
				e.preventDefault();
				var page = $(this).val();
				var maxPage = $('.total_pages').data('total_pages');
				if (page < 1 || page > maxPage) {
					return;
				}
				var url = new URL(window.location.href);
				url.searchParams.set('paged', page);
				window.location.href = url.href;
			}
		});


		var typingTimer;
		var doneTypingInterval = 1000; // Time in milliseconds to detect "done typing"

		// Store previous values
		var previousMinPrice = '';
		var previousMaxPrice = '';
	  
		function findNearestValidStep(minPrice, maxPrice, step) {
		  var range = maxPrice - minPrice;
		  var validStep = step;
	  
		  if (step <= 0) return 1; // Minimum step should be positive
	  
		  // Calculate the nearest valid step
		  while (range % validStep !== 0 && validStep > 0) {
			validStep--;
		  }
	  
		  return validStep;
		}
	  
		// Validate Price Min and Price Max on input change
		$('#price_min, #price_max').on('input', function() {
		  var priceMin = parseFloat($('#price_min').val());
		  var priceMax = parseFloat($('#price_max').val());
	  
		  // Validate inputs
		  if (priceMin >= priceMax) {
			alert('Min price must be less than max price.');
			$('#price_min').val(previousMinPrice);
			$('#price_max').val(previousMaxPrice);
			$('#price_stepper').prop('disabled', true); // Disable stepper input
			return;
		  } else {
			$('#price_stepper').prop('disabled', false); // Enable stepper input if valid
		  }
		  
		  // Store the valid values
		  previousMinPrice = priceMin;
		  previousMaxPrice = priceMax;

		  // If step value is invalid, show the alert for nearest valid step
		  $('#price_stepper').trigger('input');
		});
	  
		// Validate Price Stepper on input change with a debounce for "done typing"
		$('#price_stepper').on('input', function() {
		  clearTimeout(typingTimer);
		  typingTimer = setTimeout(function() {
			var priceMin = parseFloat($('#price_min').val());
			var priceMax = parseFloat($('#price_max').val());
			var step = parseFloat($('#price_stepper').val());
	  
			// Validate min/max prices first
			if (priceMin >= priceMax) {
			  alert('Min price must be less than max price.');
			  return;
			}
	  
			var nearestValidStep = findNearestValidStep(priceMin, priceMax, step);
	  
			if (step !== nearestValidStep) {
				$('.tdprb-error-message').html('<p>The nearest valid step is ' + nearestValidStep + '.</p>');
				
			  	$('#price_stepper').val(nearestValidStep);
				setTimeout(function(){
					$('.tdprb-error-message').html('<p></p>');
				},1000);
			}
		  }, doneTypingInterval);
		});
	});
})( jQuery );