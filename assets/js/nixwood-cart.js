jQuery(document).ready(function () {
	var quanity = jQuery('.quantity');
	var additional_page_count = jQuery('#summary-price_more_page');
	var one_page_price = jQuery('#summary-price_one_page');
	var total_price = jQuery('#summary-price_total');
	var value = 0;

    function plus() {
        if(jQuery('#checkbox_more_page').is(":checked")){    
            value = quanity.attr('value');
            additional_page_count.css('display', 'block');
            jQuery('#minus').css('pointer-events', '');
            value++;
            //console.log(value);
            quanity.attr('value',value);
            jQuery('#pages_num').text(value);

            var updated_price = value * additional_page_count.data('price');
            additional_page_count.text("$" + updated_price);

            //update_total(updated_price);

            var total = one_page_price.text();
            updated_total = parseInt(updated_price) + parseInt(total);
            total_price.text(updated_total);
            } 
        }

        function minus() {
            if(jQuery('#checkbox_more_page').is(":checked")){
          
            value = jQuery('.quantity').attr('value');
            additional_page_count.css('display', 'block');
				value -= 1;
				if (value == 0 || value <1) {
			 	value = 0;

                additional_page_count.css('display', 'none');
                jQuery('#minus').css('pointer-events', 'none')
            } else {
                jQuery('#minus').css('pointer-events', '')
            };
            quanity.attr('value',value);
            jQuery('#pages_num').text(value);


            var updated_price = value * additional_page_count.data('price');
            additional_page_count.text("$" + updated_price);


            var total = one_page_price.text();
            updated_total = parseInt(updated_price) + parseInt(total);
            total_price.text(updated_total);
            }
        }
        
        // click on minus
    jQuery('.minus').on('click', minus);

        // click on plus
    jQuery('.plus').on('click', plus);

    jQuery('#checkbox_more_page').change(function() {
           
        if(this.checked) {
        	//console.log(jQuery(this));
        	jQuery(this).closest('.check-block').find('.quantity').attr('disabled', false)
            var quanity = jQuery('.quantity'),
                one_page_price = jQuery('#summary-price_one_page'),
                additional_page_count  = jQuery('#summary-price_more_page'),
                total_price = jQuery('#summary-price_total');

            // change value dirrectly in input
            quanity.on("input", function () {
               if (this.value > 0) {
                   additional_page_count.text("$" + this.value * additional_page_count.data('price'));
                   var price = parseInt(one_page_price.text()) + parseInt(this.value * additional_page_count.data('price'));
                   total_price.text(price);
               }
            });

        } else {
        	jQuery(this).closest('.check-block').find('.quantity').attr('disabled', true);
            jQuery('#pages_num').text(0);
            jQuery('#summary-price_more_page').text("$0");

            jQuery('#summary-price_total').text(jQuery('#summary-price_one_page').text());
            jQuery('.quantity').attr('value', 0);
            value = 0;
        }
    });

    //AJAX submit form
    jQuery('.btn-red').on('click', function (e) {
        e.preventDefault();
        jQuery.ajax({
            type: "post",
            url: ajaxParams.ajaxurl,
            data: {
                'action': ajaxParams.action,
                'security': ajaxParams.nonce,
                'total': jQuery('#summary-price_total').text()
            },
            success: function (response) {
                console.log("Total: "+ response.data)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    })
});
