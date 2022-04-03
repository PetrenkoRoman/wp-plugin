<?php
$basic_price = apply_filters('basic_price', 199);
$extra_page_price = apply_filters('extra_page_price', 0);
?>
<section class="payment" id="payment">
    <div class="container">
        <div class="flex-wrap">
            <div class="card card-list" id="card-list">
                <h2 class="title">Your card</h2>
                <div class="checkbox">
                    <input type="checkbox" class="checkbox__input" id="checkbox_one_page" disabled checked="checked">
                    <label for="checkbox_one_page" class="checkbox__label">Project name: Okirobo <br><span class="subtitle">One page (Base)</span></label>
                </div>


                <div class="check-block">
                    <div class="checkbox">
                        <input type="checkbox" class="checkbox__input" id="checkbox_more_page">
                        <label for="checkbox_more_page" class="checkbox__label">Add more pages <br><span class="subtitle">Number of additional pages</span></label>
                    </div>

                    <div class="quantity-block">
                        <span class="minus" id="minus">-</span>
                        <input disabled="true" class="quantity" type="text" size="3" min="0" step="0" max="0" value="0" />
                        <span class="plus" id="plus">+</span>
                    </div>
                </div>
                <a href="#" class="btn btn-grey">Back to project</a>
            </div>

            <div class="card card-summary" id="card-summary">
                <h2 class="title">Order summary</h2>
                <div class="summary-block">
                    <p class="summary-text">One page (Base)</p>
                    <p class="summary-price">$<span id="summary-price_one_page"><?php echo $basic_price;?></span></p>
                </div>
                <div class="summary-block">
	                <p class="summary-text"><span id="pages_num">0</span> additional pages</p>
                    <p class="summary-price" id="summary-price_more_page" data-price="100" >$<?php echo $extra_page_price;?></p>
                </div>
                <div class="total-block">
                    <h3 class="total-text">Total</h3>
	                <p class="total-price">Us $<span id="summary-price_total"><?php echo $basic_price + $extra_page_price;?></span></p>
                </div>
                <a href="#" class="btn btn-red">Pay</a>
                <a href="#" class="btn btn-grey">Back to project</a>
            </div>
        </div>
    </div>
</section>