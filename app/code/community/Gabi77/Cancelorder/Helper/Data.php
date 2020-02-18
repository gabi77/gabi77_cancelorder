<?php
/**
 * Gabi77_Cancelorder
 *
 * @category    Gabi77
 * @package     Gabi77_Cancelorder
 * @copyright   Copyright (c) 2020 Gabi77
 * @author      Gabriel Janez (http://www.gabi77.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Gabi77_Cancelorder_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function enableCancelOrder() {

        $result = Mage::getStoreConfig('gabi77_cancelorder/general/enabled', Mage::app()->getStore());
        return  $result;
    }

    /**
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function timeCancelOrder() {

        $result = Mage::getStoreConfig('gabi77_cancelorder/general/time', Mage::app()->getStore());
        return  $result;
    }

}
