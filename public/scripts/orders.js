	// Vars dealing with the lookup menu. 
	var active_lookup_menu_item;
	var all_orders_fallback;
	var flag_filter;
	var currently_selected;
	
	var current_order;
	var current_status;
	
	// Vars dealing with the details menu 
	
	var active_details_tab;
	
jQuery(document).ready(function(){

	active_lookup_menu_item = jQuery("#allorders-link");
	all_orders_fallback;
	flag_filter = ''
	  
// EVERYTHING HERE DEALS WITH POPULATING ORDERS TABLE -------------------------------------------------------------------------------------------------------------------------  

  jQuery("#order-lookup-box").on('input',function(){
	lookup_value = getLookupValue(this);
	lookup_method = getLookupValue(jQuery("#lookup-meth"));
	lookup_limit = getLookupValue(jQuery("#lookup-lim"));
	url = "/orders/lookup/value/" + lookup_value +"/method/"+lookup_method+"/limit/"+lookup_limit+"/flag/"+flag_filter;
	getOrders(url);
  });

   jQuery("#lookup-meth").on('change',function(){
	lookup_value = getLookupValue(jQuery("#order-lookup-box"));
	lookup_method = getLookupValue(this);
	lookup_limit = getLookupValue(jQuery("#lookup-lim"));
	url = "/orders/lookup/value/" + lookup_value +"/method/"+lookup_method+"/limit/"+lookup_limit+"/flag/"+flag_filter;
	getOrders(url);
  });
  
   jQuery("#lookup-lim").on('change',function(){
	lookup_value = getLookupValue(jQuery("#order-lookup-box"));
	lookup_method = getLookupValue(jQuery("#lookup-meth"));
	lookup_limit = getLookupValue(this);
	url = "/orders/lookup/value/" + lookup_value +"/method/"+lookup_method+"/limit/"+lookup_limit+"/flag/"+flag_filter;
	getOrders(url);
  });
				//
				//	Method to pull No matches. -------------------------------------------------------------------------------------------------------------
				//	
				//
				//  
				
   jQuery("#nomatch-link").on('click',function(){
	flag_filter = "nm"
	url = getLookupURL(flag_filter);
	getOrders(url);
	setActivelookupItem(this);	
	});
				//
				//	Method to pull All orders. -------------------------------------------------------------------------------------------------------------
				//	
				//
				//  
   jQuery("#allorders-link").on('click',function(){
	flag_filter = '';
	url = getLookupURL(flag_filter);
	getOrders(url);
	setActivelookupItem(this);	
	});  
				//
				//	Method to pull Decline orders. -------------------------------------------------------------------------------------------------------------
				//	
				//
				//  
   jQuery("#decline-link").on('click',function(){
	flag_filter = 'dc';
	url = getLookupURL(flag_filter);
	getOrders(url);
	setActivelookupItem(this);	
	});

				//
				//	Method to pull Decline Confirmations. -------------------------------------------------------------------------------------------------------------
				//	
				//
				//  
   jQuery("#confirmations-link").on('click',function(){
	flag_filter = 'c';
	url = getLookupURL(flag_filter);
	getOrders(url);
	setActivelookupItem(this);	
	});   
	  
	
});


				//
				//
				//	Method to generate URL for the order lookup links. 
				//
				//

function getLookupURL(flag_filter_local) {
	lookup_value = getLookupValue(jQuery("#order-lookup-box"));
	lookup_method = getLookupValue(jQuery("#lookup-meth"));
	lookup_limit = getLookupValue(jQuery("#lookup-lim"));
	url = "/orders/lookup/value/" + lookup_value +"/method/"+lookup_method+"/limit/"+lookup_limit+"/flag/"+flag_filter_local;
	return url;		
}

function getLookupValue(element) { 
	return jQuery(element).val()
}

function getOrders(url){
        //url += 'isAjax/1';
        //url = url.replace("checkout/cart","ajaxcart/checkout_cart");
        //jQuery('#ajax_loader'+id).show();
        try {
            jQuery.ajax( {
                url : url,
                //dataType : 'json',
                success : function(data) {
					//alert("came back");
                    setOrdersTable(data);   
					        
                }
            });
        } catch (e) {
        }
    }
	
	
function setOrdersTable(data){
		if(data.status == 'ERROR'){
            //alert(data.message);
			
        }else{
                jQuery('.orders-table tbody').html(data);
				
            if(jQuery('.header .links')){
                jQuery('.header .links').replaceWith(data.toplink);
            }
            //jQuery.fancybox.close();
        }
    }
						  //
						  // 	This will change the active menu item in order lookup menu. 
						  //
						  //
						  //
function setActivelookupItem(element) {

	jQuery(active_lookup_menu_item).removeClass("active");
	active_lookup_menu_item = element;	
	jQuery(active_lookup_menu_item).addClass("active");
}






	
// EVERYTHING HERE DEALS WITH PULLING SINGLE  ORDER ----------------------------------------------------------------------------------------------------------------------------------------

jQuery(document).ready(function(){
  
  jQuery(".orders-table tbody").on('mouseenter',"tr",
  	function(){
  		jQuery(this).addClass("row-over");
  	});
   
  jQuery(".orders-table tbody").on('mouseleave',"tr", 
  	function(){
	  jQuery(this).removeClass("row-over");
  	});
 
  jQuery(".orders-table tbody").on('click',"tr",function() { 
  	  tr_id = jQuery(this).attr("id");
	  url = "/orders/get-details/number/" + tr_id;
	  jQuery(currently_selected).removeClass("row-active");
	  currently_selected = this;
	  jQuery(currently_selected).addClass("row-active");
	  updateActiveDetailsMenu(jQuery(".detail-menu .first"));
	  getOrderSummary(url);
  });
  
});	


function getOrderSummary(url){
        //url += 'isAjax/1';
        //url = url.replace("checkout/cart","ajaxcart/checkout_cart");
        //jQuery('#ajax_loader'+id).show();
		try {
            jQuery.ajax( {
                url : url,
                dataType : 'json',
                success : function(data) {
				
                    setOrderSummary(data);   
					        
                }
            });
        } catch (e) {
			
        }
    }
	
	
function setOrderSummary(data){
		if(data.status == 'ERROR'){
			//alert(data.message);			
		}else{
			 current_order = data.number;
			 current_status = data.status;
			 jQuery('.detail-content').html(data.html);
			 jQuery('.order_details span.order_details_order_number').html(current_order);
			 jQuery('.order_details_order_status').html(current_status);
		 
		}
	}
//	THIS SECTION WILL HANDLE CLICK ON THE ORDER NUMBER TOP OF DETAILS BOX ---------------------------------------------------------------------------------------------------------------------------------------------
jQuery(document).ready(function(){
			
	jQuery(document).on('click','.order_details .order_details_order_number',function() {
		var url = "/orders/view-original/order/"+current_order;
		getOriginal(url);
	});
	
});

function getOriginal(url){
		try {
            jQuery.ajax( {
                url : url,
                dataType : 'json',
                success : function(data) {
                    openOriginal(data);   
					        
                }
            });
        } catch (e) {
        }
    } 


				//
				//
				//			THIS METHOD WILL OPEN NEW WINDOW WITH ORIGINAL ORDER
				//
				//


function openOriginal(data){
		if(data.status == 'ERROR'){
			//alert(data.message);			
		}else{
			
			var w = window.open('', 'Original Order', "height=900,width=600");
			w.document.body.innerHTML = data.html;		 
		}
	}

	
//	THIS SECTION WILL DEAL WITH ACTIONS TAKEN IN SUMMARY BOX  ---------------------------------------------------------------------------------------------------------------------------------------------
jQuery(document).ready(function(){ 

	jQuery(document).on('click','.quick-actions-wrapper .quick-action-button',function() {
		changeStatusRequest(jQuery(this).attr("flag"));		
	}); 
	
	jQuery(document).on('click','.summary-items-box .more-items',function() {
		var url = "/orders/get-items/order/"+current_order;
		var items_tab = jQuery("li#items-menu-item");
		console.debug(items_tab);
		updateActiveDetailsMenu(items_tab);
		getTabContent(url);
	});
});


				//
				//
				//			THIS METHOD WILL SEND AJAX REQUEST TO CHANGE ORDER STATUS 
				//
				//

function changeStatusRequest(status){
		url = "/status/set/status/"+status+"/order/"+current_order
		try {
            jQuery.ajax( {
                url : url,
                dataType : 'json',
                success : function(data) {
                    setOrderStatus(data);   
					        
                }
            });
        } catch (e) {
        }
    } 


				//
				//
				//			THIS METHOD WILL DEAL WITH STATUS CHANGE. 
				//
				//


function setOrderStatus(data){
		if(data.status == 'ERROR'){
			//alert(data.message);			
		}else{
			 current_status = data.status;
			 updateDetails();
			 url = getLookupURL(flag_filter);
			 getOrders(url);		 
		}
	}

// THIS SECTION WILL DEAL WITH SWITCHING BETWEEN ORDER DETAILS TABS ----------------------------------------------------------------------------------------------------------------------------------------------
jQuery(document).ready(function(){ 
			//
			//
			//		THIS METHOD WILL RENDER STATUS CONTENT 
			//
			//

	jQuery(".detail-menu #status-menu-item").on('click', function(){
		var	url = "/orders/get-status/order/"+current_order;
		getTabContent(url);	
	});
	
			//
			//
			//		THIS METHOD WILL RENDER THE STUMMARY CONTENT
			//
			//
	jQuery(".detail-menu #summary-menu-item").on('click', function() {
		var url = "/orders/get-details/number/"+current_order;
		getOrderSummary(url);	
	});
	
	
			//
			//
			//		THIS METHOD WILL RENDER THE NOTES TAB CONTENT
			//
			//
	jQuery(".detail-menu #notes-menu-item").on('click', function() {
		var url = "/orders/get-notes/order/"+current_order;
		getTabContent(url);
	
	});
	
			//
			//
			//		THIS METHOD WILL RENDER THE SHIPPING TAB CONTENT
			//
			//
	jQuery(".detail-menu #shipping-menu-item").on('click', function() {
		var url = "/orders/get-shipping/order/"+current_order;
		getTabContent(url);
	
	});	 	
			//
			//
			//		THIS METHOD WILL RENDER ITEMS TAB CONTENT
			//
			//
	
//	jQuery(".detail-menu #items-menu-item").on('click', function() {
//		var url = "/orders/get-items/order/"+current_order;
//		getTabContent(url);
	
//	});	 	
	
			//
			//
			//		THIS METHOD WILL RENDER THE EMAIL ACTIONS SUBMENU CONTENT 
			//
			//
	
	jQuery(".detail-menu li").on('click',"#email-actions-menu-item", function() {
		var url = "/orders/get-email-actions/order/"+current_order;
		getTabContent(url);
	
	
	});
	
			//
			//
			//		THIS METHOD WILL RENDER THE ALL ITEMS SUBMENU CONTENT
			//
			//			
	
	jQuery(".detail-menu li").on('click',"#all-items-menu-item", function() {
		var url = "/orders/get-items/order/"+current_order;
		getTabContent(url);
	
	
	});
	
			//
			//
			//		THIS METHOD WILL RENDER ADD NEW ITEM SUBMENU CONTENT
			//
			//
	
	jQuery(".detail-menu li").on('click',"#add-item-menu-item", function() {
		var url = "/orders/get-add-item/order/"+current_order;
		getTabContent(url);
	
	
	});	
	
			//
			//
			//  	THIS METHOD WILL RENDER IP CHECK SUBMENU CONTENT
			//
			//		
	jQuery(".detail-menu li").on('click',"#ip-chech-menu-item", function() {
		var url = "/orders/check-ip/order/"+current_order;
		getIpCheckContent(url);
	
	
	});		
			//
			//
			//		THIS METHOD WILL RENDER ADD DROP SHIP ITEM SUBMENU CONTENT
			//
			//	
	
	
	jQuery(".detail-menu li").on('click',"#drop-ship-item-menu-item", function() {
		var url = "/orders/get-drop-ship/order/"+current_order;
		getTabContent(url);
	
	
	});	
			//
			//
			//		THIS METHOD TAKES CARE OF UPDATING TABS ON CLICK.
			//
			//
	
	
	
	jQuery(".detail-menu li").on('click', function() {
			updateActiveDetailsMenu(this);
	});
	
	
	


});
			//
			//
			//		THIS METHOD WILL RENDER THE IP CHECK CONTENT. 
			//
			//

function getIpCheckContent(url) {
		
		try {
            jQuery.ajax( {
                url : url,
                dataType : 'html',
                success : function(data) {
                   jQuery(".detail-content").html(data);
				   
				   setTimeout(initializeCheck(), 2000);  
					        
                }
            });
        } catch (e) {
        }	
}

	
			//
			//
			//		THIS METHOD MAKES THE AJAX CALL TO PULL THE CONTENT OF THE TAB
			//
			//	

function getTabContent(url){
		try {
            jQuery.ajax( {
                url : url,
                dataType : 'json',
                success : function(data) {
                    setTabContent(data);   
					        
                }
            });
        } catch (e) {
        }
    }

			//
			//
			//		THIS METHOD WILL SET THE TAB CONTENT TO WHATEVER WAS RETURNED FROM AJAX CALL.
			//
			//

function setTabContent(data){
		if(data.status == 'ERROR'){
			//alert(data.message);			
		}else{
			 	jQuery(".detail-content").html(data.html);

			 }
	}

			//
			//
			//		THIS METHOD SETS THE ACTIVE ELEMENT OF DETAILS MENU.
			//
			//

function updateActiveDetailsMenu(element) {
	jQuery(active_details_tab).removeClass("active");
	active_details_tab = element;
	jQuery(active_details_tab).addClass("active");
}





// 	THIS SECTION WILL DEAL WITH SHOWING SUBMENUS FOR DETAILS TABS ----------------------------------------------------------------------------------------------------------------------------------------------
jQuery(document).ready(function(){ 
	jQuery(document).on("mouseover","#actions-menu-item",function() {
		jQuery(".sub-menu", this).show();
		
	});
	
	jQuery(document).on("mouseout","#actions-menu-item",function() {
		jQuery(".sub-menu", this).hide();
		
	});

	jQuery(document).on("mouseover","#items-menu-item",function() {
		jQuery(".sub-menu", this).show();
	});
	
	jQuery(document).on("mouseout","#items-menu-item",function() {
		jQuery(".sub-menu", this).hide();
		
	});	

	jQuery(document).on("mouseover","#fraud-menu-item",function() {
		jQuery(".sub-menu", this).show();
	});
	
	jQuery(document).on("mouseout","#fraud-menu-item",function() {
		jQuery(".sub-menu", this).hide();
		
	});	
	
});




// THIS SECTION WILL DEAL WITH ACTIONS TAKEN IN STATUS TAB ----------------------------------------------------------------------------------------------------------------------------------------------

jQuery(document).ready(function(){ 

	jQuery(document).on('click','.status-actions-wrapper .status-action-button',function() {
		var send_email = jQuery('.status-email-check #email-status').is(':checked');
		var send_text = jQuery('.status-sms-check #sms-status').is(':checked');
		changeStatusRequestTab(jQuery(this).attr("flag"),send_email,send_text);
		
		
	})
});


				//
				//
				//			THIS METHOD WILL SEND AJAX REQUEST TO CHANGE ORDER STATUS 
				//
				//

function changeStatusRequestTab(status,email,sms){
		url = "/status/set/status/"+status+"/order/"+current_order+"/email/"+email+"/sms/"+sms;
		try {
            jQuery.ajax( {
                url : url,
                dataType : 'json',
                success : function(data) {
                    setOrderStatusTab(data);   
					        
                }
            });
        } catch (e) {
        }
    } 


				//
				//
				//			THIS METHOD WILL DEAL WITH STATUS CHANGE. 
				//
				//


function setOrderStatusTab(data){
		if(data.status == 'ERROR'){
			//alert(data.message);			
		}else{
		  if(data.error == true) {
		  	alert(data.msg);
		  }
			 current_status = data.status;
			 updateDetails();
			 url = getLookupURL(flag_filter);
			 getOrders(url);
			 url = "/orders/get-status/order/"+current_order;
			 getTabContent(url);		 
		}
	}
// THIS SECTION WILL DEAL WITH ALL THE ACTIONS TAKEN IN NOTES TAB ----------------------------------------------------------------------------------------------------------------------------------------------
jQuery(document).ready(function(){ 

	jQuery(document).on('click','.note-submit-box-wrapper #note-submit',function() {
		var note = jQuery(".note-submit-box-wrapper #note-text").val();
		
		addNote(note);
		
	})
});

				//
				//
				//			THIS METHOD WILL MAKE THE AJAX CALL TO INSERT THE NOTE
				//
				//



function addNote(note){
		url = "/notes/add/note/"+note+"/order/"+current_order
		try {
            jQuery.ajax( {
                url : url,
                dataType : 'json',
                success : function(data) {
                    refreshNotes(data);   
					        
                }
            });
        } catch (e) {
        }
    } 


				//
				//
				//			THIS METHOD WILL DEAL WITH NOTE CHANGE. 
				//
				//


function refreshNotes(data){
		if(data.status == 'ERROR'){
			//alert(data.message);			
		}else{
			 var url = "/orders/get-notes/order/"+current_order;
			 getTabContent(url);		 
		}
	}
// THIS SECTION WILL DEAL WITH ALL THE ACTIONS TAKE IN SHIPPING TAB -----------------------------------------------------------------------------------------------------------------------------------------------------
jQuery(document).ready(function(){ 

						//
						//
						//		THIS FUNCTION TAKES CARE OF ADDING QUOTE
						//
						//

	jQuery(document).on('click','.detail-content #add-quote-button',function() {
		
		var amount = jQuery("#shipping-price").val()
		var type = jQuery("#shipping-select").val()
		var url = "/shipping/add-quote/order/"+current_order+"/type/"+type+"/amount/"+amount;
		addShippingQuote(url);	
	});
						//
						//
						//		THIS METHOD TAKES CARE OF REMOVING QUOTE
						//
						//
	
	jQuery(document).on('click','.quote-row #remove-quote',function() {
		
		var id = jQuery("span", this).html();
		var url = "/shipping/remove-quote/id/"+id;
		addShippingQuote(url);	
	});
	
						//
						//
						//		THIS METHOD SETS THE QUOTE TO BE ACTIVE
						//
						//
	jQuery(document).on('click','.quote-row #set-active-quote',function() {
		
		var id = jQuery("span", this).html();
		var url = "/shipping/activate-quote/id/"+id;
		addShippingQuote(url);	
	});

						// 
						//
						//		THIS METHOD WILL MAKE THE AJAX CALL TO INSERT SHIPPING QUOTE
						//
						//
						
function addShippingQuote(url){
		try {
            jQuery.ajax( {
                url : url,
                dataType : 'json',
                success : function(data) {
                    refreshQuotes(data);   
					        
                }
            });
        } catch (e) {
        }
    }
						//
						//
						//		THIS METHOD WILL UPDATE THE QUOTES TAB. 
						//
						//
						
function refreshQuotes(data){
		if(data.status == 'ERROR'){
			//alert(data.message);			
		}else{
			 var url = "/orders/get-shipping/order/"+current_order;
			 getTabContent(url);		 
		}
	}
 		
});



// THIS SECTION WILL DEAL WITH ACTIONS TAKEN IN ITEMS TAB ----------------------------------------------------------------------------------------------------------------------------------------------

jQuery(document).ready(function(){

	jQuery(document).on('click','.items-action-box #submit-item-action',function() {
		 						
								//
								//
								//		This will change item status to no stock 
								//
								//
								
								
		if(jQuery("#item-action-select").val() == 2) {
			// we're doing no stocks first
			var all_selected = jQuery(".items-list-box input:checked");
			var items = generateNoStockUrl(all_selected);
			setItemStatus("/items/set-no-stock/", items);
		}
		
								//
								//
								//		This will change item status to Back Order
								//
								//
		
		if(jQuery("#item-action-select").val() == 3) {
			var all_selected = jQuery(".items-list-box input:checked");
			var items = generateBackOrder(all_selected);
			setItemStatus("/items/set-back-order/", items);
		}
								//
								//
								//		This will change status to Removed
								//
								//
								
		if(jQuery("#item-action-select").val() == 4) {
			var all_selected = jQuery(".items-list-box input:checked");
			var items = generateBackOrder(all_selected);
			setItemStatus("/items/set-removed/", items);
								
								//
								//
								//		This will reset status of the item. 
								//
								//
		}		
		if(jQuery("#item-action-select").val() == 7) {
			var all_selected = jQuery(".items-list-box input:checked");
			var items = generateBackOrder(all_selected);
			setItemStatus("/items/remove-status/", items);
		}				
	});

});

function setItemStatus(url, items_array){
		try {
            jQuery.ajax( {
                url : url,
				data : {'items[]' : items_array },
                dataType : 'json',
                success : function(data) {
                  	var url = "/orders/get-items/order/"+current_order;
						getTabContent(url);           
                }
            });
        } catch (e) {
        }
    }

function generateBackOrder(all_selected) {
	var items = new Array();
	jQuery(all_selected).each(function(index, element) {
       items.push(jQuery(element).attr("id"));
    });
	return items;
}


function generateNoStockUrl(all_selected) {
	var items = new Array();
	jQuery(all_selected).each(function(index, element) {
       items.push(jQuery(element).attr("id"));
    });
	return items;
}



// THIS SECTION WILL DEAL WITH ACTIONS TAKEN IN ADD ITEM TAB ---------------------------------------------------------------------------------------------------------------------------------------------
jQuery(document).ready(function(){

	jQuery(document).on('change','.add-item-box #item-type-select',function() {
		 						
								//
								//
								//		This will show or hide the no stock items. 
								//
								//
								
		if(jQuery(this).val() == 1) {
			jQuery('.replace-item-box').show();
		} else if (jQuery(this).val() == 0) {
			jQuery('.replace-item-box').hide();	
		}
	});
								//
								//
								// 		This method will deal with add item button click
								//
								//
								
	jQuery(document).on('click','.add-item-box #add-item-button',function() {
		if(jQuery('.add-item-box #item-type-select').val() == 0) {
			var data = getItemNew();
			addNewItem(data);
		} else if(jQuery('.add-item-box #item-type-select').val() == 1) {
			var data = getItemReplace();
			addNewItem(data);
		}
		
	});

});


function getItemNew() {
	var name = jQuery(".add-item-box #item-name").val();
	var price = jQuery(".add-item-box #item-price").val();
	var qty = jQuery(".add-item-box #item-qty").val();
	var status = 5; 
	return { 	name: name,
				price: price,
				qty : qty, 
				status : 5,
				order : current_order };
}

function getItemReplace() {
	var name = jQuery(".add-item-box #item-name").val();
	var price = jQuery(".add-item-box #item-price").val();
	var qty = jQuery(".add-item-box #item-qty").val();
	var other_item = jQuery('input[name="replaced"]:checked').val();
	return { 	name: name,
				price: price,
				qty : qty, 
				status : 6,
				other_item : other_item,
				order : current_order };
}

function addNewItem(item_array){
		var url = "/items/add/"
		try {
            jQuery.ajax( {
                url : url,
				data : { data : item_array },
                dataType : 'json',
                success : function(data) {
                  	var url = "/orders/get-items/order/"+current_order;
						getTabContent(url); 
						         
                }
            });
        } catch (e) {
        }
    }

// THIS SECTION WILL DEAL WITH ALL THE ACTIONS TAKEN IN DROP SHIP TAB ----------------------------------------------------------------------------------------------------------------------------------------------
jQuery(document).ready(function(){
	
							// THIS SHOWS AND HIDES DETAILS FOR DROP SHIP PER ITEM
	
	jQuery(document).on("change", ".drop-ship-item input", function() {
		if(jQuery(this).is(":checked")) { 
			jQuery(this).siblings(".drop-ship-item-details").show();
		} else { 
			jQuery(this).siblings(".drop-ship-item-details").hide();
		}
	});
	
							// THIS HAPPENS WHEN WE PROCEED WITH DROP SHIP
	
	jQuery(document).on("click","#submit-drop-ship", function () {
		var drop_ship_items = jQuery('.drop-ship-item input:checked');
		//console.debug(drop_ship_items);
		//console.debug(generateDropShipItems(drop_ship_items));
		var encoded_items = generateDropShipItems(drop_ship_items);
		dropShipItems(encoded_items);
		console.debug(encoded_items);
	});

});

							// AJAX CALL TO MAKE THE DROP SHIP 

function dropShipItems(my_items){
		var url = "/items/drop-ship/"
		try {
            jQuery.ajax( {
                url : url,
				data : {'items' : my_items },
                dataType : 'json',
                success : function(data) {
                  	var url = "/orders/get-items/order/"+current_order;
						getTabContent(url);           
                }
            });
        } catch (e) {
        }
}

							// THIS CONVERTS THE HTML FIELDS INTO JAVASCRIPT OBJECTS FOR AJAX CALL

function generateDropShipItems(elements) { 
	var items = new Array();
	jQuery(elements).each(function(index, element) {
	   var single_item = {
			id : jQuery(element).val(),
			qty : jQuery(element).siblings(".drop-ship-item-details").children('#drop-ship-item-qty').val(),
			vendor : jQuery(element).siblings(".drop-ship-item-details").children('.drop-ship-vendor').val(),
			name: jQuery(element).siblings(".drop-ship-item-details").children('.drop-ship-item-name').val(),
			order: current_order
	   }
       items.push(single_item);
    });
	return items;

}

// THIS SECTION WILL DEAL WITH ALL THE ACTIONS TAKEN IN EMAIL ACTIONS TAB ----------------------------------------------------------------------------------------------------------------------------------------------
jQuery(document).ready(function(){
	
	jQuery(document).on("click",".email-actions-box .email-action-button", function() {
		var type = jQuery(this).attr("flag");
		sendEmail(type);
	});



});

function sendEmail(type){
		var url = "/email-actions/"
		try {
            jQuery.ajax( {
                url : url,
				data : {'type' : type, 'order' : current_order },
                dataType : 'json',
                success : function(data) {
                  	//var url = "/orders/get-items/order/"+current_order;
						//getTabContent(url);           
                }
            });
        } catch (e) {
        }
}


// THIS SECTION WILL DEAL WITH ALL THE HELPER METHODS ----------------------------------------------------------------------------------------------------------------------------------------------



			//
			//
			//		UpdateDetails will deal with updating order status and number after ruturn from AJAX call. 
			//
			//


function updateDetails() { 
	jQuery(".order_details_order_number").text(current_order);
	jQuery(".order_details_order_status").text(current_status); 
}