<?php
namespace Snapvendor\Customer\Setup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
     /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    protected $attributeSetFactory;
    public function __construct(CustomerSetupFactory $customerSetupFactory, AttributeSetFactory $attributeSetFactory)
    {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
         /** @var CustomerSetup $customerSetup */
         $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

         $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
         $attributeSetId = $customerEntity->getDefaultAttributeSetId();

         /** @var $attributeSet AttributeSet */
         $attributeSet = $this->attributeSetFactory->create();
         $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
        if(version_compare($context->getVersion(),'1.0.2','<')){
            $customerSetup->addAttribute(Customer::ENTITY, 'company', [
                'type' => 'text',
                'label' => 'Company',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'sort_order' => 81,
                'position' => 81,
                'system' => 0,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_html_allowed_on_front' => false,
                'visible_on_front' => true
            ]);

            $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'company')
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_customer', 'customer_account_edit'],
            ]);
            $attribute->save();
        }
    }
}
