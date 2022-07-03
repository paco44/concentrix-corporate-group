<?php
/**
 * @author      Francisco Espinosa <paco_espinosa.21@outlook.com>
 * @copyright   Copyright © Concentrix. All rights reserved. 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Concentrix\CorporateGroup\Model;

use Magento\Framework\Model\AbstractModel;
use Concentrix\CorporateGroup\Api\Data\CorporateGroupInterface;

/**
 * Class CorporateGroup
 */
class CorporateGroup extends AbstractModel implements CorporateGroupInterface
{
    /**
     * Corporate Group Entity Constant
     */
    const ENTITY_ID         = 'entity_id';
    const INTERNAL_CODE     = 'internal_code';
    const NAME              = 'name';
    const EMAIL             = 'email';
    const TELEPHONE         = 'telephone';

	 /**
     * Initialize CorporateGroup Model
     *
     * @return void
     */
	public function _construct()
    {
		$this->_init("Concentrix\CorporateGroup\Model\ResourceModel\CorporateGroup");
	}

    /**
     * @return string
     */
    public function getInternalCode()
    {
        return $this->_getData(self::INTERNAL_CODE);
    }

    /**
     * @param string $internalCode
     * @return void
     */
    public function setInternalCode($internalCode)
    {
        $this->setData(self::INTERNAL_CODE, $internalCode);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_getData(self::NAME);
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_getData(self::EMAIL);
    }

    /**
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->setData(self::EMAIL, $email);
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->_getData(self::TELEPHONE);
    }

    /**
     * @param string $telephone
     * @return void
     */
    public function setTelephone($telephone)
    {
        $this->setData(self::TELEPHONE, $telephone);
    }
}
