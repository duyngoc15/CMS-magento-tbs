<?php

namespace Snapvendor\Customer\Setup;

use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{

    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    protected $attributeSetFactory;

    /**
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }


    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        /** @var $attributeSet AttributeSet */
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        // The telephone is the attribute code
        // The types are supported as: datetime, decimal, int, text, varchar
        // The sort order will be position this attribute will be displayed
        // We add this attribute before the Email field so I set it to 79
        $customerSetup->addAttribute(Customer::ENTITY, 'telephone', [
            'type' => 'text',
            'label' => 'Customer Mobile',
            'input' => 'text',
            'required' => false,
            'visible' => true,
            'user_defined' => true,
            'sort_order' => 79,
            'position' => 79,
            'system' => 0,
            'is_used_in_grid' => true,
            'is_visible_in_grid' => true,
            'is_html_allowed_on_front' => false,
            'visible_on_front' => true
        ]);

        $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'telephone')
        ->addData([
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroupId,
            'used_in_forms' => ['adminhtml_customer', 'customer_account_edit'],
        ]);

        $attribute->save();
    }
}


// namespace Snapvendor\Customer\Setup;

// use Magento\Customer\Api\CustomerMetadataInterface;
// use Magento\Eav\Setup\EavSetup;
// use Magento\Eav\Model\Config as EavConfig;
// use Magento\Eav\Setup\EavSetupFactory;
// use Magento\Framework\Setup\InstallDataInterface;
// use Magento\Framework\Setup\ModuleContextInterface;
// use Magento\Framework\Setup\ModuleDataSetupInterface;
// use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
// use Magento\Customer\Model\Customer;

// class InstallData implements InstallDataInterface
// {
//     private $eavSetupFactory;
//     /**
//      * @var EavConfig
//      */
//     private $eavConfig;

//     public function __construct(EavSetupFactory $eavSetupFactory, EavConfig $eavConfig)
//     {
//         $this->eavSetupFactory = $eavSetupFactory;
//         $this->eavConfig = $eavConfig;
//     }

//     public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
//     {
//         $eavsetup = $this->eavSetupFactory->create(['setup' => $setup]);
//         $eavsetup->addAttribute(Customer::ENTITY, 'telephone', [
//             'type' => 'text',
//             'label' => 'Telephone',
//             'input' => 'text',
//             'required' => false,
//             'visible' => true,
//             'user_defined' => true,
//             'sort_order' => 79,
//             'position' => 79,
//             'system' => 0,
//             'is_used_in_grid' => true,
//             'is_visible_in_grid' => true,
//             'is_html_allowed_on_front' => false,
//             'visible_on_front' => true
//         ]);
//         $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'telephone');
//         $attribute->setData('used_in_forms', [
//             'adminhtml_customer',
//             'customer_account_create',
//             'customer_account_edit'
//         ]);
//         $attribute->save($attribute);
//     }
// }
