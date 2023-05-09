<?php

namespace Snapvendor\Customer\Observer;
use Magento\Customer\Block\Widget\Name;
use Magento\Framework\Event\ObserverInterface;

class CustomerLogin implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();
        $customer->setData('middlename','Mid');
        $customer->save();
    }
}
