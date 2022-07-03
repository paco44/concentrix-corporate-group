<?php
/**
 * @author      Francisco Espinosa <paco_espinosa.21@outlook.com>
 * @copyright   Copyright © Concentrix. All rights reserved. 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace Concentrix\CorporateGroup\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Concentrix\CorporateGroup\Model\Source\Options;

/**
 * Class AddCustomerCorporateGroupAttribute
 */
class AddCustomerCorporateGroupAttribute implements DataPatchInterface, PatchVersionInterface
{

    /**
     * Attribute Code Constant
     */
    const CORPORATE_GROUṔ_ATTRIBUTE_CODE = 'concentrix_corporate_group_attr';

    /**
     * Attribute Label Constant
     */
    const CORPORATE_GROUṔ_ATTRIBUTE_LABEL = 'Corporate Group';

    /**
     * Patch Version Constant
     */
    const PATCH_VERSION = '1.0.0';

    /**
     * @var ModuleDataSetupInterface
     */
    private $_moduleDataSetup;

    /**
     * @var CustomerSetupFactory
     */
    private $_customerSetupFactory;

    /**
     * AddCustomerCorporateGroupAttribute constructor
     * 
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory     $customerSetupFactory
    ) {
        $this->_moduleDataSetup       = $moduleDataSetup;
        $this->_customerSetupFactory  = $customerSetupFactory;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->_moduleDataSetup->getConnection()->startSetup();

        //Add corporate group attribute to customer entity
        $customerSetup = $this->_customerSetupFactory->create(['setup' => $this->_moduleDataSetup]);
        $customerSetup->addAttribute(
            Customer::ENTITY,
            self::CORPORATE_GROUṔ_ATTRIBUTE_CODE,
            [
                'type'                  => 'text',
                'label'                 => self::CORPORATE_GROUṔ_ATTRIBUTE_LABEL,
                'input'                 => 'select',
                'source'                => Options::class,
                'required'              => false,
                'sort_order'            => 999,
                'visible'               => true,
                'is_used_in_grid'       => true,
                'is_visible_in_grid'    => true,
                'is_filterable_in_grid' => false,
                'is_searchable_in_grid' => true,
                'system'                => false
            ]
        );

        //Add corporate group attribute to admin forms
        $customerEntity = $customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);
        $attribute      = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, self::CORPORATE_GROUṔ_ATTRIBUTE_CODE);
        $attribute->addData([
            'used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout'
            ]
        ])->save();

        $this->_moduleDataSetup->getConnection()->endSetup();

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function getVersion()
    {
        return self::PATCH_VERSION;
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }
}
