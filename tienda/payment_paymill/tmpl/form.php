<?php
/**
 * --------------------------------------------------------------------------------
 * Payment Plugin - Paymill
 * --------------------------------------------------------------------------------
 * @package     Joomla!_2.5x_And_3.0X
 * @subpackage  Tienda
 * @author      Techjoomla <support@techjoomla.com>
 * @copyright   Copyright (c) 2010 - 2015 Techjoomla . All rights reserved.
 * @license     GNU/GPL license: http://www.techjoomla.com/copyleft/gpl.html
 * @link        http://techjoomla.com
 * --------------------------------------------------------------------------------
 * */

defined('_JEXEC') or die('Restricted access');

JModel::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_tienda/models');
JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_tienda/tables');
Tienda::load('TiendaHelperCarts', 'helpers.carts');
Tienda::load('TiendaHelperCurrency', 'helpers.currency');
Tienda::load('TiendaHelperBase', 'helpers._base');
$items = TiendaHelperCarts::getProductsInfo();
$orderTable = JTable::getInstance('Orders', 'TiendaTable');

foreach ($items as $item)
{
$orderTable->addItem($item);
}

$items = $orderTable->getItems();
$orderTable->calculateTotals();
$amount = $orderTable->order_total;
$currency = TiendaHelperCurrency::getCurrentCurrency();
$currency = TiendaHelperCurrency::load($currency);
$currency_code = $currency->currency_code;
$jsonarr = json_encode($this->code_arr);
$urlme = JURI::ROOT() . 'plugins/tienda/payment_paymill/payment_paymill/images/ajax_loader.gif';
?>
<style>
#opc-payment-button
{
		display:none;
}
.error
{			padding : 5px;
			margin : 5px;
			background-color: #F2DEDE;
			border-color: #EED3D7;
			color: #B94A48;
}
</style>
<?php
if ($this->params->get('sandbox', '0') == '0')
{
	$t = 'true';
}
else
{
	$t = 'false';
}
?>


	<div class="paymill-payment-errors"></div>
	<!-- display from layout-->
	<div id="loadder" style="display:none;text-align:center;"><img src="<?php echo $urlme; ?>"/></div>
    <div class="akeeba-bootstrap">
						<div id="field">
						<div class="control-group">
								<label class="control-label"><?php echo JText::_('NAME');?></label>
								<div class="controls"><input class="paymill-card-holdername" name="cardholder" type="text" size="20" 
								value="<?php echo !empty($vars->prepop['x_card_holder']) ? ($vars->prepop['x_card_holder']) : '' ?>" />
								</div>
                        </div>
                        <div class="control-group">
							<label class="control-label"><?php echo JText::_('PAYMENT_TYPE');?></label>
								<div class="controls">
									<select id="payment_type" name="payment_mode" onchange="ChangeDropdowns(this.value);">
										<option value="cc" selected="true"><?php echo JText::_('FRONTEND_CREDITCARD');?></option>
										<option value="dc"><?php echo JText::_('DEBIT_CARD');?></option>
								</select>
						</div>
						</div>
                        <div id="cc">
							<div class="control-group">
									<label class="control-label"><?php echo JText::_('CREDIT_CARD_NUMBER');?></label>
									<div class="controls"><input class="paymill-card-number" name="cardnum" type="text" maxlength="16" value="" />
									</div>
							</div>


							<div class="control-group">
									<label class="control-label"><?php echo JText::_('EXPIRY');?></label>
								   <div class="controls"> <input class="paymill-card-expiry-month" name="month" type="text" size="2" maxlength="2" style="width:20px;"/>/
									<input class="paymill-card-expiry-year" name="year" type="text" size="4"  maxlength="4" style="margin-left: 0px;width:50px;"/>
									&nbsp;<?php echo JText::_('FRONTEND_CREDITCARD_LABEL_CVC');?><input class="paymill-card-cvc" name="cardexp"
									type="text" maxlength="4" size="4" value="" style="width:65px;"/>
									</div>
							</div>
                        </div>
                        <div id="bank" style="display:none;">

									 <div class="control-group">
											<label class="control-label"><?php echo JText::_('FRONTEND_DIRECTDEBIT_LABEL_NUMBER');?></label>
											<div class="controls"> <input class="paymill-debit-number" name="accnum" maxlength="10" type="text" size="20" value="" /></div>
									</div>
									 <div class="control-group">
											<label class="control-label"><?php echo JText::_('FRONTEND_DIRECTDEBIT_LABEL_BANKCODE');?></label>
											<div class="controls">  <input class="paymill-debit-bank" name="banknum" maxlength="8" type="text" size="20" value="" /></div>
									</div>

									<div class="control-group">
												<label class="control-label"><?php echo JText::_('COUNTRY');?></label>
												<div class="controls"><input class="paymill-debit-country" name="country" type="text" size="20" value="" /></div>
									</div>
                        </div>
                        </div>
								<input type="hidden" name="token12"  id="token12"  value="" />
								<input class="paymill-card-amount" type="hidden" size="10" value="<?php echo $amount;?>" />
								<input class="paymill-card-currency" type="hidden" size="10" value="<?php echo $currency_code;?>" />
						</div>
			   <div class="form-actions"> <input id="paymill_button" class="btn btn-primary" onclick="submitme();" type="button"
			   value="<?php echo  JText::_('CONTINUE');?>"/></div>

   </div>

