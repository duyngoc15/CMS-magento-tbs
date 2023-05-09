<?php
namespace Snapvendor\Sales\Setup;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Sales\Setup\SalesSetupFactory;
class UpgradeData implements UpgradeDataInterface{
    private $saleSetupFactory;

    public function __construct(SalesSetupFactory $saleSetupFactory)
    {
        $this->saleSetupFactory = $saleSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if(version_compare($context->getVersion(),"1.0.1","<"))
        {
            $salesSetup = $this->saleSetupFactory->create(['setup'=>$setup]);
            $salesSetup->addAttribute('order','custom_order_attribute',[
                'type' => 'text',
                'label' => 'Grand Oder',
                'visible' => true,
                'required' => false,
                'grid' => true,
                'is_used_in_grid' => true,
                'is_html_allowed_on_front' => false,
                'visible_on_front' => true
            ]);
        }
    }
}
