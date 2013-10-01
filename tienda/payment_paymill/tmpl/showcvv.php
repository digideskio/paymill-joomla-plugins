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
?>

<div class="showcvv" style="margin: 10px">
    <h2><?php echo JText::_('COM_TIENDA_CVV_HEADER'); ?></h2>
    <?php echo JText::_('COM_TIENDA_CVV_GENERAL_DESCRIPTION'); ?>
    
    <div class="cvv_back" style="margin: 10px">
        <h3 class="cvv_header"><?php echo JText::_('COM_TIENDA_CVV_BACK_HEADER'); ?></h3>
        <img src="plugins/tienda/payment_authorizedotnet/images/cvv_back.png" />
        <br/>
        <?php echo JText::_('COM_TIENDA_CVV_BACK_DESCRIPTION'); ?>
    </div>
    
    <div class="cvv_front" style="margin: 10px">
        <h3 class="cvv_header"><?php echo JText::_('COM_TIENDA_CVV_FRONT_HEADER'); ?></h3>
        <img src="plugins/tienda/payment_authorizedotnet/images/cvv_front.png" />
        <br/>
        <?php echo JText::_('COM_TIENDA_CVV_FRONT_DESCRIPTION'); ?>
    </div>
</div>

