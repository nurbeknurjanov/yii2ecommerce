<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

?>

<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="fake@sakuracommerce.com">
    <input type="hidden" name="item_name" value="hat">
    <input type="hidden" name="item_number" value="123">
    <input type="hidden" name="amount" value="15.00">
    <input type="hidden" name="email" value="fake@sakuracommerce.com">
    <input type="image" name="submit"
           src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
           alt="PayPal - The safer, easier way to pay online">
</form>