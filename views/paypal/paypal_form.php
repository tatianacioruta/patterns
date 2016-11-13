<div style="text-align: center;margin-top: 10px;">
    <h3><strong>Admin rights for 10 day(s)</strong></h3><br>
    <h3><strong>Price $<?= $price?></strong></h3><br>

<form id="paypal_form" method="post"  target="_blank" action="https://www.sandbox.paypal.com/cgi-bin/webscr" name="paypal_form">
    <input type="hidden" name="rm" value="2">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="quantity" value="1">
    <input type="hidden" name="business" value="tany_com@gmail.com">
    <input type="hidden" name="cancel_return" value="<?=  _URL_PATH . 'paypal/cancel' ?>">
    <input type="hidden" name="item_name" value="Admin rights for <?=$offer?> day(s)">
    <input type="hidden" name="item_number" value="Request Nr-2">
    <input type="hidden" name="amount" value="<?=$price?>">
    <div class="">
        <div>
                <input id="pay" type="submit" name="pp_submit" value="PAY" style="padding-left: 20px;padding-right: 20px;" class="btn">
        </div>
    </div>
</form>
</div>