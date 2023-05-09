<?php

namespace Snapvendor\Catalog\Setup;
use Magento\Framework\Setup\{
    ModuleContextInterface,
    ModuleDataSetupInterface,
    InstallDataInterface
};

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory) {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'desc_attribute', [
            'type'     => 'text',
            'label'    => 'Description',
            'input'    => 'textarea',
            'source'   => '',
            'sort_order' => 30,
            'visible'  => true,
            'default'  => '0',
            'required' => false,
            'is_html_allowed_on_front',
            'global'   => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group'    => 'Custom Category Tab',
          
        ]);
        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'thumb_attribute', [
            'type'     => 'varchar',
            'label'    => 'Category Thumbnail Image',
            'input'    => 'image',
            'source'   => '',
            'sort_order' => 40,
            'visible'  => true,
            'default'  => '0',
            'required' => false,
            'global'   => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'backend' => '\Magento\Catalog\Model\Category\Attribute\Backend\Image',
            'group'    => 'Custom Category Tab',
        ]);
    }
}