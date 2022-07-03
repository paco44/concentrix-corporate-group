<?php
/**
 * @author      Francisco Espinosa <paco_espinosa.21@outlook.com>
 * @copyright   Copyright © Concentrix. All rights reserved. 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Concentrix\CorporateGroup\Model\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Concentrix\CorporateGroup\Model\ResourceModel\CorporateGroup\CollectionFactory;

/**
 * Class Options
 */
class Options extends AbstractSource
{

    /**
     * @var CollectionFactory
     */
    protected $_corporateGroupCollectionFactory;

    /**
     * Options constructor
     * 
     * @param CollectionFactory $corporateGroupCollectionFactory
     */
    public function __construct(
        CollectionFactory $corporateGroupCollectionFactory
    ) {
        $this->_corporateGroupCollectionFactory = $corporateGroupCollectionFactory;
    }

    /**
     * @param Retreive all corporate group options
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options = [
            ['label'=>__('Select an option'),'value'=>'']
        ];

        $corporateGroupsCollection = $this->_corporateGroupCollectionFactory->create();
        $corporateGroupsCollection
            ->addFieldToSelect('internal_code')
            ->addFieldToSelect('name');

        foreach($corporateGroupsCollection as $corporateGroup)
        {
            array_push($this->_options, ['label'=>__($corporateGroup->getName()),'value'=>$corporateGroup->getInternalCode()]);
        }
        
        return $this->_options;
    }
}
