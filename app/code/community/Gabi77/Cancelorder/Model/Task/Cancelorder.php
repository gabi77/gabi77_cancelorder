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

/**
 *
 */
class Gabi77_Cancelorder_Model_Task_Cancelorder
{
  /**
  * Run cancel order auto
  **/
  public function run() {

    $helper = self::helper();
    if($helper->enableCancelOrder() == 0 ) {
      return '';
    }
    $time = $helper->timeCancelOrder();
    $datetime = date('Y-m-d H:i:s', time() - ($time * 60));
    $collection = Mage::getModel('sales/order')->getCollection()
        ->addFieldToFilter('created_at', array('lteq' => $datetime))
        ->addFieldToFilter('state', array('in' => Mage_Sales_Model_Order::STATE_PENDING_PAYMENT))
        ->setOrder('created_at', 'DESC');

    if ($collection->getSize() > 0) {
        foreach ($collection->getData() as $value) {
          self::orderTreatment($value['entity_id']);
        }
    } else {
      return "not orderTreatment";
    }
  }

  public function helper() {
    $_helper = Mage::helper('gabi77_cancelorder');
    return $_helper;
  }

  protected function orderTreatment($id) {

    try {
      $order = Mage::getModel('sales/order')->load($id);
      $order->setState(Mage_Sales_Model_Order::STATE_CANCELED);
      $order->setStatus(Mage_Sales_Model_Order::STATE_CANCELED);
      $order->addStatusHistoryComment('System changed auto status order for '.Mage_Sales_Model_Order::STATE_PENDING_PAYMENT.' by '.Mage_Sales_Model_Order::STATE_CANCELED);
      $order->save();
    } catch (Exception $e) {

      continue;
    }
    unset($order);
    return "orderTreatment is ok";
  }
}
