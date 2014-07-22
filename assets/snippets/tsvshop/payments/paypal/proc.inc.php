<form method="post" action= "https://www.paypal.com/cgi-bin/webscr" id="buynow">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="[+shop.finish.bemail+]">
<input type="hidden" name="item_name" value="[+shop.finish.item_name+]">
<input type="hidden" name="item_number" value="[+shop.finish.item_number+]">
<input type="hidden" name="amount" value="[+shop.finish.amount+]">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="custom" value="[+shop.finish.custom+]">
<input type="hidden" name="invoice" value="[+shop.finish.invoice+]">
<input type="hidden" name="amount" value="[+shop.finish.amount+]">
<input type="hidden" name="currency_code" value="[+shop.finish.currency_code+]">
<input type="hidden" name="return" value="[(site_url)][~87~]">
<input type="hidden" name="notify_url" value="[(site_url)][~87~]">
<input type="hidden" name="cancel_return" value="[(site_url)][~89~]">
</form>
<a href="#" class="redbutton_small" title="Payment" onclick="document.forms['buynow'].submit(); return false;">Payment</a>