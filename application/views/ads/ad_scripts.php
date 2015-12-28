<script>
	$(document).ready(function(){
		$("#report_container").height($(window).height() - 179);
		$("#navigation").height($(window).height() - 333);
		$("#nav_container").height($(window).height() - 370);
		
		load_post_board();
		
		var number_of_visits = $("#number_of_visits").val();
		
		
		$("#tutorial_dialog").dialog({
			autoOpen:false,
			width: 500,
			height: 500,
			title: "AdSync Tutorial",
			draggable: false,
			resizable: false,
			modal: true,
		});
		
		$(window).unload(function(){
			return 'Are you sure ?';
		});
		
		if(number_of_visits < 1){
			tutorial_open();
		}
		
		//AD SUBMISSION DIALOG
        $( "#ad_submission_dialog").dialog({
			autoOpen: false,
			height: 750,
			width: 750,
			modal: true,
			buttons: 
				[
					{
						id: "back_btn",
						text: "Back",
						click: function(){
							$("#instructions_container").show();
							$("#post_form_container").hide();
							$('.ui-dialog-buttonpane').find('button:eq(2)').css('visibility','hidden');
							$('.ui-dialog-buttonpane').find('button:eq(1)').css('visibility','visible');
							$('.ui-dialog-buttonpane').find('button:eq(0)').css('visibility','hidden');
						}
					},
					{
						id: "next_btn",
						text: "Next",
						click: function(){
							var id = $("#post_id").val();
							$("#instructions_container").hide();
							$("#post_form_container").show();
							$('.ui-dialog-buttonpane').find('button:eq(2)').css('visibility','visible');
							$('.ui-dialog-buttonpane').find('button:eq(1)').css('visibility','hidden');
							$('.ui-dialog-buttonpane').find('button:eq(0)').css('visibility','visible');
							
						}
					},
					{
						id: "submit_ad_post",
						text: "Submit",
						click: function(){
							var dataString = $("#ad_submission_form").serialize();
							console.log(dataString);
							var is_valid = true;
							
							var phone_number = $('#post_phone_number').val();
							var cleaned_phone = phone_number.replace(/\D/g,'');
							var post_link = $("#post_link").val();
							var post_title = $("#post_title").val();
							var post_content = $("#post_content").val();
							console.log(cleaned_phone);
							if(post_link==''){
								is_valid = false;
								alert("Please fill in the link field.");
							}else if(post_title==''){
								is_valid = false;
								alert("Please fill in the title field.");
							}else if(post_content==''){
								is_valid = false;
								alert("Please fill in the content field.");
							}else if(cleaned_phone.length != 10){
								is_valid = false;
								alert("Phone number not valid.");
							}
							if(is_valid){
								//AJAX
								if(!(report_ajax_call===undefined)){
									report_ajax_call.abort();
								}
								report_ajax_call = $.ajax({
									url: "<?=base_url("index.php/ads/update_post") ?>",
									type: "POST",
									data: dataString,
									cache: false,
									statusCode: {
										200: function(response){
											$('.ui-dialog-buttonpane').find('button:eq(0)').css('visibility','hidden');
											$('.ui-dialog-buttonpane').find('button:eq(1)').css('visibility','hidden');
											$("#ajax_container").html(response);
											refresh_ad_spots();
											
											$('#submit_ad_post').hide();
										},
										404: function(){
											alert('Page not found');
										},
										500: function(response){
											alert("500 error! "+response);
										}
									}
								});//END AJAX
							}
						},
					},
					{
						text: "Close",
						click: function(){
							$("#ajax_container").show();
							$("#post_form_container").hide();
							$('.ui-dialog-buttonpane').find('button:eq(2)').css('visibility','hidden');
							$('.ui-dialog-buttonpane').find('button:eq(1)').css('visibility','visible');
							
							$( this ).dialog( "close" );
							
							load_post_board();
						}
					},
				],//end of buttons
				open: function(){
					$('#submit_ad_post').show();
				},//end open function
				close: function( event, ui){
					var dataString = $("#ad_request_form").serialize();
					console.log(dataString);
					//AJAX
					if(!(report_ajax_call===undefined)){
						report_ajax_call.abort();
					}
					report_ajax_call = $.ajax({
						
						url: "<?=base_url("index.php/ads/delete_post") ?>",
						type: "POST",
						data: dataString,
						cache: false,
						statusCode: {
							200: function(){
								console.log("deleted");
							},
							404: function(){
								alert('Page not found');
							},
							500: function(response){
								alert("500 error! "+response);
							}
						}
					});//END AJAX
				}
        });//end ad submission dialog
		
		$("#ad_request_dialog").dialog({
			autoOpen: false,
			height: 580,
			width: 750,
			modal: true,
			buttons: 
				[
					{
						text: "Submit",
						click: function(){
							var dataString = $("#create_ad_request_form").serialize();
							var $this = $(this);
							var valid = check_ad_request();
							
							if(valid){
								$(":button:contains('Submit')").prop("disabled", true).addClass("ui-state-disabled");
								$(":button:contains('Close')").prop("disabled", true).addClass("ui-state-disabled");
							
								$("#form_loading_icon").show();
								//AJAX
								if(!(report_ajax_call===undefined)){
									report_ajax_call.abort();
								}
								report_ajax_call = $.ajax({
									
									url: "<?=base_url("index.php/ads/create_ad_request") ?>",
									type: "POST",
									data: dataString,
									cache: false,
									statusCode: {
										200: function(){
											alert("Ad Request created. Please wait while the ads are updated.");
											
											$.ajax({
												
												url: "<?=base_url("index.php/public_functions/refresh_post_board") ?>",
												type: "POST",
												cache: false,
												statusCode: {
													200: function(){
														alert("Ads refreshed.");
														$this.dialog( "close" );
														
														$("#form_loading_icon").hide();
														$('#create_ad_request_form').find("input[type=text], textarea").val("");
														$('#create_ad_request_form').find("select").val("Select");
														
														$(":button:contains('Submit')").removeAttr("disabled").removeClass("ui-state-disabled");
														$(":button:contains('Close')").removeAttr("disabled").removeClass("ui-state-disabled");
														load_ad_requests();
													},
													404: function(){
														alert('Page not found');
													},
													500: function(response){
														alert("500 error! "+response);
													}
												}
											});//END AJAX
										},
										404: function(){
											alert('Page not found');
										},
										500: function(response){
											alert("500 error! "+response);
										}
									}
								});//END AJAX
							}
						},
					},
					{
						text: "Close",
						click: function(){
							$( this ).dialog( "close" );
						}
					},
				],//end of buttons
				open: function(){
				},//end open function
				close: function( event, ui){
				}
		});
		
		//AD VERIFICATION DIALOG
        $( "#ad_verification_dialog").dialog({
			autoOpen: false,
			height: 580,
			width: 750,
			modal: true,
			buttons: 
				[
					{
						text: "Submit",
						click: function() 
						{
							var $this = $(this);
							var is_valid = true;
							var form = $('#post_verification_form');
								
							if(is_valid){
								form.submit();
							}
							
							setTimeout(function(){
								$this.dialog( "close" );
								load_post_verification_page();
							},3000);
						},
					},
					{
						text: "Close",
						click: function() 
						{
							$( this ).dialog( "close" );
						}
					},
				],//end of buttons
				open: function()
				{
				},//end open function
				close: function( event, ui)
				{
				}
        });//end ad verification dialog
		
		//POST RENEWAL DIALOG
        $( "#post_renewal_dialog").dialog({
			autoOpen: false,
			height: 350,
			width: 500,
			modal: true,
			buttons: 
				[
					{
						text: "Submit",
						click: function() 
						{
							$(":button:contains('Submit')").prop("disabled", true).addClass("ui-state-disabled");
							$(":button:contains('Close')").prop("disabled", true).addClass("ui-state-disabled");
								
							var $this = $(this);
							var dataString = $("#renewal_form").serialize();
							
							//AJAX
							if(!(report_ajax_call===undefined)){
								report_ajax_call.abort();
							}
							report_ajax_call = $.ajax({
								
								url: "<?=base_url("index.php/ads/renew_post") ?>",
								type: "POST",
								data: dataString,
								cache: false,
								statusCode: {
									200: function(){
										alert("Post Renewed. Post will be re-verified in the next 24 hours.");
										$this.dialog( "close" );
										load_renewals();
										
										$(":button:contains('Submit')").removeAttr("disabled").removeClass("ui-state-disabled");
										$(":button:contains('Close')").removeAttr("disabled").removeClass("ui-state-disabled");
									},
									404: function(){
										alert('Page not found');
									},
									500: function(response){
										alert("500 error! "+response);
									}
								}
							});//END AJAX
						},
					},
					{
						text: "Close",
						click: function() 
						{
							$( this ).dialog( "close" );
						}
					},
				],//end of buttons
				open: function()
				{
				},//end open function
				close: function( event, ui ) 
				{
				}
        });//end post renewal dialog
		
		//SETTLE BALANCE DIALOG
        $( "#settle_balance_dialog").dialog({
			autoOpen: false,
			height: 500,
			width: 550,
			modal: true,
			buttons: 
				[
					{
						text: "Submit",
						click: function() 
						{
							var $this = $(this);
							var is_valid = true;
							var form = $('#settle_balance_form');
							var amount = $("#amount_paid").val();
							
							if(amount=='' || isNaN(amount)){
								is_valid = false;
								alert("Please enter a valid amount.");
							}else if($('#payment_screenshot').get(0).files.length === 0){
								is_valid = false;
								alert("Please attach the screenshot of the payment.");
							}
							if(is_valid){
								form.submit();
								
								setTimeout(function(){
									$this.dialog( "close" );
									load_manage_money_page();
								},2000);
							}
							
						},
					},
					{
						text: "Close",
						click: function() 
						{
							$( this ).dialog( "close" );
						}
					},
				],//end of buttons
				open: function()
				{
				},//end open function
				close: function( event, ui) 
				{
				}
        });//end ad submission dialog
		
	});//ready

	var report_ajax_call;
	
	function delete_request(id){
		var r = confirm("Are you sure you want to delete this ad request?");
		if(r==true){
		//AJAX
			if(!(report_ajax_call===undefined))
			{
				report_ajax_call.abort();
			}
			report_ajax_call = $.ajax({
				
				url: "<?=base_url("index.php/ads/delete_ad_request") ?>",
				type: "POST",
				data: {id:id},
				cache: false,
				statusCode: {
					200: function(response){
						alert("Ad Request deleted.");
						refresh_ad_spots();
						load_ad_requests();
					},
					404: function(){
						alert('Page not found');
					},
					500: function(response){
						alert("500 error! "+response);
					}
				}
			});//END AJAX
		}
	}
	
	function edit_request(id){
		// $("#name_info_"+id).hide();
		// $("#category_info_"+id).hide();
		// $("#sub_info_"+id).hide();
		// $("#price_info_"+id).hide();
		
		// $("#name_edit_"+id).show();
		// $("#category_edit_"+id).show();
		// $("#sub_edit_"+id).show();
		// $("#price_edit_"+id).show();
		$("#edit_info_"+id).hide();
		$("#save_edit_"+id).show();
		$(".non_editable_"+id).hide();
		$(".editable_"+id).show();
	}
	
	function edit_user(id){
		$("#edit_info_"+id).hide();
		$("#save_edit_"+id).show();
		$(".non_editable_"+id).hide();
		$(".editable_"+id).show();
	}
	
	function edit_user_information(){
		$("#edit_information_btn").hide();
		$("#save_information_btn").show();
		
		$(".info").hide();
		$(".input").show();
	}
	
	function filter_user_live_ads(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		var user_id = $("#selected_user").val();
		console.log(user_id);
		$.ajax({
			url: "<?=base_url("index.php/ads/load_filtered_live_ads") ?>",
			type: "POST",
			data: {user_id:user_id},
			cache: false,
			statusCode: {
				200: function(response){
					$("#live_ads_container").html(response);
					$("#refresh_icon").show();
					$("#loading_icon").hide();
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function filter_user_post_history(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		var user_id = $("#selected_user").val();
		console.log(user_id);
		$.ajax({
			url: "<?=base_url("index.php/ads/load_filtered_post_history") ?>",
			type: "POST",
			data: {user_id:user_id},
			cache: false,
			statusCode: {
				200: function(response){
					$("#post_container").html(response);
					$("#refresh_icon").show();
					$("#loading_icon").hide();
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function filter_user_referrals(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		var user_id = $("#selected_user").val();
		console.log(user_id);
		$.ajax({
			url: "<?=base_url("index.php/ads/load_filtered_referrals") ?>",
			type: "POST",
			data: {user_id:user_id},
			cache: false,
			statusCode: {
				200: function(response){
					$("#referral_container").html(response);
					$("#refresh_icon").show();
					$("#loading_icon").hide();
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function filter_user_renewals(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		var user_id = $("#selected_user").val();
		console.log(user_id);
		$.ajax({
			url: "<?=base_url("index.php/ads/load_filtered_renewals") ?>",
			type: "POST",
			data: {user_id:user_id},
			cache: false,
			statusCode: {
				200: function(response){
					$("#renewal_container").html(response);
					$("#refresh_icon").show();
					$("#loading_icon").hide();
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function generate_code(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		
		var dataString = $("#generate_code_form").serialize();
		console.log(dataString);
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/generate_code") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			statusCode: {
				200: function(response){
					$("#generate_code_btn").hide();
					$("#code_box").html(response);
					$("#code_box").show();
					$("#refresh_btn").show();
					$("#referral_id").prop("readonly", true);
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function load_account_info(){
		$("#loading_icon").show();
		$("#refresh_icon").hide();
		var this_div = $("#report_container");
		var dataString;
		
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/load_account_info") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			context: this_div,
			statusCode: {
				200: function(response){
					this_div.html(response);
					update_balance();
					change_nav_box('#account_info_box');
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function load_ad_requests(){
		$("#loading_icon").show();
		$("#refresh_icon").hide();
		var this_div = $("#report_container");
		var dataString;
		
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/load_ad_requests") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			context: this_div,
			statusCode: {
				200: function(response){
					this_div.html(response);
					update_balance();
					change_nav_box('#create_ad_request_box');
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function check_ad_request(){
		var client = $("#client_id").val();
		var market_id = $("#market_id").val();
		var category_name = $("#category_name").val();
		var sub_category = $("#sub_category").val();
		var content_description = $("#content_description").val();
		var price = $("#price").val();
		var minimum_live_ads = $("#minimum_live_ads").val();
		var is_valid = true;
		
		var stripped_price = price.replace(/\D/g,'');

		console.log("clientid= "+client+" marketid= "+market_id+" subcategory= "+sub_category+" price= "+stripped_price);
		
		if(client=="Select"){
			alert("Please input a client");
			is_valid = false;
		}else if(market_id=="Select"){
			alert("Please input a market");
			is_valid = false;
		}else if(category_name=="Select"){
			alert("Please input a category");
			is_valid = false;
		}else if(sub_category==""){
			alert("Please input a sub-category");
			is_valid = false;
		}else if(content_description==""){
			alert("Please input description of the content.");
			is_valid = false;
		}else if(stripped_price==""){
			alert("Please input a valid price");
			is_valid = false;
		}else if(minimum_live_ads=="" || isNaN(minimum_live_ads)){
			alert("Please input a valid minimum number of ads");
			is_valid = false;
		}
		
		if(is_valid){
			return true;
		}
	}
	
	function load_accounts_page(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		var this_div = $("#report_container");
		var dataString;
		
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/load_accounts_page") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			context: this_div,
			statusCode: {
				200: function(response){
					this_div.html(response);
					update_balance();
					change_nav_box('#accounts_box');
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function load_faq(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		var this_div = $("#report_container");
		var dataString;
		
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/load_faq") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			context: this_div,
			statusCode: {
				200: function(response){
					this_div.html(response);
					update_balance();
					change_nav_box('#faq_box');
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function load_generate_code_page(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		var this_div = $("#report_container");
		var dataString;
		
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/load_generate_code_page") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			context: this_div,
			statusCode: {
				200: function(response){
					this_div.html(response);
					update_balance();
					change_nav_box('#generate_code_box');
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function load_live_ads(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		var this_div = $("#report_container");
		var dataString;
		
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/load_live_ads") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			context: this_div,
			statusCode: {
				200: function(response){
					this_div.html(response);
					update_balance();
					change_nav_box('#live_ads_box');
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function load_manage_money_page(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		var this_div = $("#report_container");
		var dataString;
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/load_manage_money_page") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			context: this_div,
			statusCode: {
				200: function(response){
					this_div.html(response);
					update_balance();
					change_nav_box('#manage_money_box');
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function load_money_report(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		var this_div = $("#report_container");
		var dataString;
		
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/load_money_report") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			context: this_div,
			statusCode: {
				200: function(response){
					this_div.html(response);
					update_balance();
					change_nav_box('#money_box');
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function load_post_board(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		var this_div = $("#report_container");
		var dataString;
		
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/load_post_board") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			context: this_div,
			statusCode: {
				200: function(response){
					this_div.html(response);
					update_balance();
					change_nav_box('#post_board_box');
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function load_post_history(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		var this_div = $("#report_container");
		var dataString;
		
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/load_post_history") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			context: this_div,
			statusCode: {
				200: function(response){
					this_div.html(response);
					update_balance();
					change_nav_box('#post_history_box');
					$("#loading_icon").hide();
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function load_post_verification_page(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		var this_div = $("#report_container");
		var dataString;
		
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/load_post_verification_page") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			context: this_div,
			statusCode: {
				200: function(response){
					this_div.html(response);
					update_balance();
					change_nav_box('#verify_posts_box');
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function load_referrals(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		var this_div = $("#report_container");
		var dataString;
		
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/load_referrals") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			context: this_div,
			statusCode: {
				200: function(response){
					this_div.html(response);
					update_balance();
					change_nav_box('#referrals_box');
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function load_renewals(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		var this_div = $("#report_container");
		var dataString;
		
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/load_renewals") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			context: this_div,
			statusCode: {
				200: function(response){
					this_div.html(response);
					update_balance();
					change_nav_box('#renewals_box');
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function load_user_transactions(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		var this_div = $("#transactions_container");
		var dataString = $("#user_form").serialize();
		var user_id = $("#user_id").val();
		
		
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/load_user_transactions") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			context: this_div,
			statusCode: {
				200: function(response){
					console.log(dataString);
					this_div.html(response);
					$("#user_id").val();
					$("#settle_btn").show();
					update_balance();
					get_balance();
					if(user_id==0){
						$("#settle_btn").hide();
					}
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function get_balance(){
		var id = $("#user_id").val();
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/get_balance") ?>",
			type: "POST",
			data: {id:id},
			cache: false,
			statusCode: {
				200: function(response){
					$("#balance").html(response);
					$("#balance_input").val(response);
					$("#loading_icon").hide();
					$("#refresh_icon").show();
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function open_ad_request_dialog(){
		$("#ad_request_dialog").dialog( "open" );
	}
	
	function open_verification_dialog(post_id){
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/open_post_verification_dialog") ?>",
			type: "POST",
			data: {post_id:post_id},
			cache: false,
			statusCode: {
				200: function(response){
					//OPEN AD SUBMISSION DIALOG
					$("#ad_verification_dialog").dialog( "open" );
					
					//LOAD DIALOG WITH VIEW FROM SERVER
					$("#verification_ajax_container").html(response);
					
					//START TIMER
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
		
	}
	
	function referrer_selected(){
		var referrer = $("#referral_id").val();
		if(referrer=="Select"){
			$("#generate_code_btn").hide();
		}else{
			console.log(referrer)
			$("#generate_code_btn").show();
		}
	}
	
	function refresh_ad_spots(){
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/public_functions/refresh_post_board") ?>",
			type: "POST",
			cache: false,
			statusCode: {
				200: function(){
					$("#refresh_icon").show();
					$("#loading_icon").hide();
					alert("Ads Refreshed");
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function renew_post(post_id){
		$( "#post_renewal_dialog").dialog( "open" );
		$("#renewal_post_id").val(post_id);
	}
	
	function reserve_ad_request(id){
		
		//RESERVE AD REQUEST--REMOVE FROM LIST
		//AJAX
		if(!(report_ajax_call===undefined)){
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/reserve_ad_request") ?>",
			type: "POST",
			data: {id:id},
			cache: false,
			statusCode: {
				200: function(response){
					//OPEN AD SUBMISSION DIALOG
					$("#ad_submission_dialog").dialog( "open" );
					
					//LOAD DIALOG WITH VIEW FROM SERVER
					$("#ajax_container").html(response);
					
					//START TIMER
					setTimeout(
						function(){
							$("#ad_submission_dialog").dialog( "close" );
						},600000);
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
		
		$('.ui-dialog-buttonpane').find('button:first').css('visibility','hidden');
		$('.ui-dialog-buttonpane').find('button:eq(2)').css('visibility','hidden');
		// $('.ui-button-text:contains(Back)').hide();
		
		
		
	}
	
	function reset_password(user_id){
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/reset_password") ?>",
			type: "POST",
			data: {user_id:user_id},
			cache: false,
			statusCode: {
				200: function(){
					alert("We just sent an email that you can use to reset your password.");
					},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function save_request(id){
		$("#save_edit_"+id).hide();
		$("#loading_icon_"+id).show();
		var dataString = $("#ad_request_form_"+id).serialize();
		console.log(dataString);
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/edit_ad_request") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			statusCode: {
				200: function(){
					load_ad_requests();
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function save_user(id){
		$("#save_edit_"+id).hide();
		$("#loading_icon_"+id).show();
		var dataString = $("#user_form_"+id).serialize();
		console.log(dataString);
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/edit_user") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			statusCode: {
				200: function(){
					load_accounts_page();
					$("#loading_icon_"+id).hide();
					$("#edit_info_"+id).show();
					$(".editable_"+id).hide();
					$(".non_editable_"+id).show();
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function save_user_information(user_id){
		$("#save_information_btn").hide();
		$("#loading_icon").show();
		
		var dataString = $("#account_info_form").serialize();
		
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/save_user_information") ?>",
			type: "POST",
			data: dataString,
			cache: false,
			statusCode: {
				200: function(response){
					$("#report_container").html(response);
					},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
		
	}
	
	function send_code(id){
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/send_code") ?>",
			type: "POST",
			data: {id:id},
			cache: false,
			statusCode: {
				200: function(response){
					$("#report_container").html(response);
					},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function settle_balance(){
		var dataString = $("#user_form").serialize();
		var is_valid = true;
		var user_id = $("#user_id").val();
		var balance = $('#balance_input').val();
		if(user_id == "All Users")
		{
			is_valid = false;
			alert("Please select a user.");
		}
		else if(balance == 0)
		{
			is_valid = false;
			alert("User has no balance.");
		}
		if(is_valid == true)
		{
			//AJAX
			if(!(report_ajax_call===undefined))
			{
				report_ajax_call.abort();
			}
			report_ajax_call = $.ajax({
				
				url: "<?=base_url("index.php/ads/settle_balance") ?>",
				type: "POST",
				data: dataString,
				cache: false,
				statusCode: {
					200: function(response){
						$("#settle_balance_dialog").dialog( "open" );
						$("#settle_balance_ajax_container").html(response);
						update_balance();
					},
					404: function(){
						alert('Page not found');
					},
					500: function(response){
						alert("500 error! "+response);
					}
				}
			});//END AJAX
		}
		
	}
	
	function show_answer(id){
		if(id == 1)
		{
			if($("#site_explanation_answer").is(':visible'))
			{
				$("#site_explanation_answer").hide();
			}
			else
			{
				$("#site_explanation_answer").show();
			}
		}
		else if(id == 2)
		{
			if($("#ad_post_answer").is(':visible'))
			{
				$("#ad_post_answer").hide();
			}
			else
			{
				$("#ad_post_answer").show();
			}
		}
		else if(id == 3)
		{
			if($("#money_answer").is(':visible'))
			{
				$("#money_answer").hide();
			}
			else
			{
				$("#money_answer").show();
			}
		}
		else if(id == 4)
		{
			if($("#ad_type_answer").is(':visible'))
			{
				$("#ad_type_answer").hide();
			}
			else
			{
				$("#ad_type_answer").show();
			}
		}
		else if(id == 5)
		{
			if($("#terms_of_use_answer").is(':visible'))
			{
				$("#terms_of_use_answer").hide();
			}
			else
			{
				$("#terms_of_use_answer").show();
			}
		}
		else if(id == 6)
		{
			if($("#ads_deleted_answer").is(':visible'))
			{
				$("#ads_deleted_answer").hide();
			}
			else
			{
				$("#ads_deleted_answer").show();
			}
		}
		else if(id == 7)
		{
			if($("#ad_renewal_answer").is(':visible'))
			{
				$("#ad_renewal_answer").hide();
			}
			else
			{
				$("#ad_renewal_answer").show();
			}
		}
		else if(id == 8)
		{
			if($("#google_wallet_answer").is(':visible'))
			{
				$("#google_wallet_answer").hide();
			}
			else
			{
				$("#google_wallet_answer").show();
			}
		}
		else if(id == 9)
		{
			if($("#ghosting_answer").is(':visible'))
			{
				$("#ghosting_answer").hide();
			}
			else
			{
				$("#ghosting_answer").show();
			}
		}
		else if(id == 10)
		{
			if($("#limit_answer").is(':visible'))
			{
				$("#limit_answer").hide();
			}
			else
			{
				$("#limit_answer").show();
			}
		}
		else if(id == 11)
		{
			if($("#gmail_answer").is(':visible'))
			{
				$("#gmail_answer").hide();
			}
			else
			{
				$("#gmail_answer").show();
			}
		}
	}

	function tutorial_back_btn(){
		if($("#slide_2").is(":visible")){
			$("#slide_2").hide();
			$("#slide_1").show();
			$("#tutorial_back_btn").hide();
		}else if($("#slide_3").is(":visible")){
			$("#slide_3").hide();
			$("#slide_2").show();
		}else if($("#slide_4").is(":visible")){
			$("#slide_4").hide();
			$("#slide_3").show();
		}else if($("#slide_5").is(":visible")){
			$("#slide_5").hide();
			$("#slide_4").show();
		}else if($("#slide_6").is(":visible")){
			$("#slide_6").hide();
			$("#slide_5").show();
			$("#tutorial_next_btn").show();
			$("#tutorial_close_btn").hide();
		}
	}
	
	function tutorial_close_btn(){
		$("#tutorial_dialog").dialog("close");
	}
	
	function tutorial_next_btn(){
		if($("#slide_1").is(":visible")){
			$("#slide_1").hide();
			$("#slide_2").show();
			$("#tutorial_back_btn").show();
		}else if($("#slide_2").is(":visible")){
			$("#slide_2").hide();
			$("#slide_3").show();
		}else if($("#slide_3").is(":visible")){
			$("#slide_3").hide();
			$("#slide_4").show();
		}else if($("#slide_4").is(":visible")){
			$("#slide_4").hide();
			$("#slide_5").show();
		}else if($("#slide_5").is(":visible")){
			$("#slide_5").hide();
			$("#slide_6").show();
			$("#tutorial_next_btn").hide();
			$("#tutorial_close_btn").show();
		}
	}
	
	function tutorial_open(){
		$("#tutorial_dialog").dialog("open");
		$("#slide_6").hide();
		$("#slide_5").hide();
		$("#slide_4").hide();
		$("#slide_3").hide();
		$("#slide_2").hide();
		$("#tutorial_back_btn").hide();
		$("#tutorial_next_btn").show();
		$("#tutorial_close_btn").hide();
		$("#slide_1").show();
	}


	function update_balance(){
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/update_balance") ?>",
			type: "POST",
			cache: false,
			statusCode: {
				200: function(response){
					$("#user_balance").html("$"+response);
				},
				404: function(){
					alert('Page not found');
				},
				500: function(response){
					alert("500 error! "+response);
				}
			}
		});//END AJAX
	}
	
	function change_nav_box(box_id){
		//RETURN ALL NAV BOXES BACK TO NON-SELECTED STYLE
		$(".nav_box").removeClass("highlighted_nav_box");
		
		//RETURN ALL ICON IMAGES TO NON-SELECTED STYLE
		$("#post_board_nav_icon").attr("src",'<?=base_url('images/post_board_icon.png')?>');
		$("#post_history_nav_icon").attr("src",'<?=base_url('images/hour_glass.png')?>');
		$("#renewals_nav_icon").attr("src",'<?=base_url('images/renewals_icon.png')?>');
		$("#live_ads_nav_icon").attr("src",'<?=base_url('images/live_ads_icon.png')?>');
		$("#referrals_nav_icon").attr("src",'<?=base_url('images/referals_icon.png')?>');
		$("#money_nav_icon").attr("src",'<?=base_url('images/money_icon.png')?>');
		$("#faq_nav_icon").attr("src",'<?=base_url('images/question_mark.png')?>');
		$("#manage_money_nav_icon").attr("src",'<?=base_url('images/manage_money_icon.png')?>');
		$("#ad_requests_nav_icon").attr("src",'<?=base_url('images/ad_request_icon.png')?>');
		$("#verify_posts_nav_icon").attr("src",'<?=base_url('images/verify_posts_icon.png')?>');
		$("#generate_code_nav_icon").attr("src",'<?=base_url('images/code.png')?>');
		$("#account_info_nav_icon").attr("src",'<?=base_url('images/account_info.png')?>');
		$("#accounts_nav_icon").attr("src",'<?=base_url('images/accounts.png')?>');
		
		//CHANGE THE ICON IMAGE TO THE SELECTED STYLE IMAGE
		if(box_id == '#post_board_box'){
			$("#post_board_nav_icon").attr("src", '<?=base_url('images/post_board_icon_white.png')?>');
		}else if(box_id == '#post_history_box'){
			$("#post_history_nav_icon").attr("src", '<?=base_url('images/hour_glass_white.png')?>');
		}else if(box_id == '#renewals_box'){
			$("#renewals_nav_icon").attr("src", '<?=base_url('images/renewals_icon_white.png')?>');
		}else if(box_id == '#live_ads_box'){
			$("#live_ads_nav_icon").attr("src", '<?=base_url('images/live_ads_icon_white.png')?>');
		}else if(box_id == '#referrals_box'){
			$("#referrals_nav_icon").attr("src", '<?=base_url('images/referals_icon_white.png')?>');
		}else if(box_id == '#money_box'){
			$("#money_nav_icon").attr("src", '<?=base_url('images/money_icon_white.png')?>');
		}else if(box_id == '#faq_box'){
			$("#faq_nav_icon").attr("src", '<?=base_url('images/question_mark_white.png')?>');
		}else if(box_id == '#manage_money_box'){
			$("#manage_money_nav_icon").attr("src", '<?=base_url('images/manage_money_icon_white.png')?>');
		}else if(box_id == '#create_ad_request_box'){
			$("#ad_requests_nav_icon").attr("src", '<?=base_url('images/ad_request_icon_white.png')?>');
		}else if(box_id == '#verify_posts_box'){
			$("#verify_posts_nav_icon").attr("src", '<?=base_url('images/verify_posts_icon_white.png')?>');
		}else if(box_id == '#generate_code_box'){
			$("#generate_code_nav_icon").attr("src", '<?=base_url('images/white_code_icon.png')?>');
		}else if(box_id == '#account_info_box'){
			$("#account_info_nav_icon").attr("src", '<?=base_url('images/white_account_info.png')?>');
		}else if(box_id == '#accounts_box'){
			$("#accounts_nav_icon").attr("src", '<?=base_url('images/accounts_white.png')?>');
		}
		
		//CHANGE THE STYLE OF THE SELECTED BOX
		$(box_id).addClass("highlighted_nav_box");
		
	}

</script>