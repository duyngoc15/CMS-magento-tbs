<?php
namespace Snapvendor\Sales\Observer;
use Magento\Framework\Event\Observer;

class SetOderAttr implements \Magento\Framework\Event\ObserverInterface{

    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $grandTotal = $order->getGrandTotal();
        if ($grandTotal > 200){
            $order->setData('custom_order_attribute','Yes');
        }
        else{
            $order->setData('custom_order_attribute','No');
        }
        $order->save();
    }
}
