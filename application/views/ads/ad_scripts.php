<script>
	$(document).ready(function()
	{
		$("#report_container").height($(window).height() - 179);
		$("#navigation").height($(window).height() - 333);
		$("#nav_container").height($(window).height() - 370);
		
		load_post_board();
		
		//AD SUBMISSION DIALOG
        $( "#ad_submission_dialog").dialog(
        {
			autoOpen: false,
			height: 750,
			width: 750,
			modal: true,
			buttons: 
				[
					{
						id: "submit_ad_post",
						text: "Submit",
						click: function() 
						{
							var dataString = $("#ad_submission_form").serialize();
							var is_valid = true;
							
							var post_link = $("#post_link").val();
							var post_title = $("#post_title").val();
							var post_content = $("#post_content").val();
							
							if(post_link == '' || post_title == '' || post_content == '')
							{
								is_valid = false;
								alert("Please fill out the information.");
							}
							if(is_valid)
							{
								//AJAX
								if(!(report_ajax_call===undefined))
								{
									report_ajax_call.abort();
								}
								report_ajax_call = $.ajax({
									
									url: "<?=base_url("index.php/ads/update_post") ?>",
									type: "POST",
									data: dataString,
									cache: false,
									statusCode: {
										200: function(response){
											$("#ajax_container").html(response);
											load_post_board();
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
						click: function() 
						{
							$( this ).dialog( "close" );
						}
					},
				],//end of buttons
				open: function()
				{
					$('#submit_ad_post').show();
				},//end open function
				close: function( event, ui) 
				{
					var dataString = $("#ad_submission_form").serialize();
					//AJAX
					if(!(report_ajax_call===undefined))
					{
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
		
		//AD VERIFICATION DIALOG
        $( "#ad_verification_dialog").dialog(
        {
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
							var form = $("#post_verification_form");
							//console.log(dataString);
							var post_result = $("post_result").val();
							var result_notes = $("result_notes").val();
							var is_valid = true;
							
							if(post_result=="Select")
							{
								is_valid = false;
								alert("Please select a status");
							}
							if(is_valid)
							{
								form.submit();
								$( this ).dialog( "close" );
								setTimeout(function()
								{
									load_post_verification_page();
								},3000);
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
        });//end ad verification dialog
		
		//POST RENEWAL DIALOG
        $( "#post_renewal_dialog").dialog(
        {
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
							var dataString = $("#renewal_form").serialize();
							
							//AJAX
							if(!(report_ajax_call===undefined))
							{
								report_ajax_call.abort();
							}
							report_ajax_call = $.ajax({
								
								url: "<?=base_url("index.php/ads/renew_post") ?>",
								type: "POST",
								data: dataString,
								cache: false,
								statusCode: {
									200: function(){
										setTimeout(function()
										{
											// $( this ).dialog( "close" );
											load_renewals();
										},3000);
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
        $( "#settle_balance_dialog").dialog(
        {
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
							var dataString = $("#settle_balance_form").serialize();
							console.log(dataString);
							//AJAX
							if(!(report_ajax_call===undefined))
							{
								report_ajax_call.abort();
							}
							report_ajax_call = $.ajax({
								
								url: "<?=base_url("index.php/ads/submit_payment") ?>",
								type: "POST",
								data: dataString,
								cache: false,
								statusCode: {
									200: function(){
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
				close: function( event, ui) 
				{
				}
        });//end ad submission dialog
		
	});//ready

	var report_ajax_call;
	
	function generate_code()
	{
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		$("#generate_code_btn").hide();
		
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
					$("#code_box").html(response);
					$("#code_box").show();
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
	
	function load_ad_request_form()
	{
		$("#loading_icon").show();
		var this_div = $("#report_container");
		var dataString;
		
		//AJAX
		if(!(report_ajax_call===undefined))
		{
			report_ajax_call.abort();
		}
		report_ajax_call = $.ajax({
			
			url: "<?=base_url("index.php/ads/load_ad_request_form") ?>",
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
	
	function load_faq()
	{
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
	
	function load_generate_code_page()
	{
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
	
	function load_live_ads()
	{
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
	
	function load_manage_money_page()
	{
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
	
	function load_money_report()
	{
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
	
	function load_post_board()
	{
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
	
	function load_post_history()
	{
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
	
	function load_post_verification_page()
	{
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
	
	function load_referrals()
	{
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
	
	function load_renewals()
	{
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
	
	function load_user_transactions()
	{
		$("#refresh_icon").hide();
		$("#loading_icon").show();
		var this_div = $("#transactions_container");
		var dataString = $("#user_form").serialize();
		
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
					update_balance();
					get_balance();
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
	
	function get_balance()
	{
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
	
	function open_verification_dialog(post_id)
	{
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
	
	function renew_post(post_id)
	{
		$( "#post_renewal_dialog").dialog( "open" );
		$("#renewal_post_id").val(post_id);
	}
	
	function reserve_ad_request(id)
	{
		
		//RESERVE AD REQUEST--REMOVE FROM LIST
		//AJAX
		if(!(report_ajax_call===undefined))
		{
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
						function()
						{
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
		
		
	}
	
	function settle_balance()
	{
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
	
	function show_answer(id)
	{
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
	
	function submit_ad_request()
	{
		var client = $("#client_id").val();
		var market_id = $("#market_id").val();
		var category_name = $("#category_name").val();
		var sub_category = $("#sub_category").val();
		var content_description = $("#content_description").val();
		var price = $("#price").val();
		var minimum_live_ads = $("#minimum_live_ads").val();
		var is_valid = true;
		
		var stripped_price = price.replace(/\D/g,'');
		
		if(client=="")
		{
			alert("Please input a client");
			is_valid = false;
		}
		else if(market_id=="")
		{
			alert("Please input a market");
			is_valid = false;
		}
		else if(category_name=="")
		{
			alert("Please input a category");
			is_valid = false;
		}
		else if(sub_category=="")
		{
			alert("Please input a sub-category");
			is_valid = false;
		}
		else if(content_description=="")
		{
			alert("Please input description of the content.");
			is_valid = false;
		}
		else if(stripped_price=="")
		{
			alert("Please input a valid price");
			is_valid = false;
		}
		else if(minimum_live_ads=="" || isNaN(minimum_live_ads))
		{
			alert("Please input a valid minimum number of ads");
			is_valid = false;
		}
		if(is_valid)
		{
			var dataString = $("#create_ad_request_form").serialize();
			
			//AJAX
			if(!(report_ajax_call===undefined))
			{
				report_ajax_call.abort();
			}
			report_ajax_call = $.ajax({
				
				url: "<?=base_url("index.php/ads/create_ad_request") ?>",
				type: "POST",
				data: dataString,
				cache: false,
				statusCode: {
					200: function(response){
						load_ad_request_form();
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
	
	function update_balance()
	{
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
	
	function change_nav_box(box_id)
	{
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
		
		
		//CHANGE THE ICON IMAGE TO THE SELECTED STYLE IMAGE
		if(box_id == '#post_board_box')
		{
			$("#post_board_nav_icon").attr("src", '<?=base_url('images/post_board_icon_white.png')?>');
		}
		else if(box_id == '#post_history_box')
		{
			$("#post_history_nav_icon").attr("src", '<?=base_url('images/hour_glass_white.png')?>');
		}
		else if(box_id == '#renewals_box')
		{
			$("#renewals_nav_icon").attr("src", '<?=base_url('images/renewals_icon_white.png')?>');
		}
		else if(box_id == '#live_ads_box')
		{
			$("#live_ads_nav_icon").attr("src", '<?=base_url('images/live_ads_icon_white.png')?>');
		}
		else if(box_id == '#referrals_box')
		{
			$("#referrals_nav_icon").attr("src", '<?=base_url('images/referals_icon_white.png')?>');
		}
		else if(box_id == '#money_box')
		{
			$("#money_nav_icon").attr("src", '<?=base_url('images/money_icon_white.png')?>');
		}
		else if(box_id == '#faq_box')
		{
			$("#faq_nav_icon").attr("src", '<?=base_url('images/question_mark_white.png')?>');
		}
		else if(box_id == '#manage_money_box')
		{
			$("#manage_money_nav_icon").attr("src", '<?=base_url('images/manage_money_icon_white.png')?>');
		}
		else if(box_id == '#create_ad_request_box')
		{
			$("#ad_requests_nav_icon").attr("src", '<?=base_url('images/ad_request_icon_white.png')?>');
		}
		else if(box_id == '#verify_posts_box')
		{
			$("#verify_posts_nav_icon").attr("src", '<?=base_url('images/verify_posts_icon_white.png')?>');
		}
		
		//CHANGE THE STYLE OF THE SELECTED BOX
		$(box_id).addClass("highlighted_nav_box");
		
	}
	
</script>