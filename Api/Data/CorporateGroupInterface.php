<?php
/**
 * @author      Francisco Espinosa <paco_espinosa.21@outlook.com>
 * @copyright   Copyright © Concentrix. All rights reserved. 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Concentrix\CorporateGroup\Api\Data;

/**
 * Corporate Group entity interface for API handling.
 *
 */
interface CorporateGroupInterface
{
    /**
     * @return string
     */
    public function getInternalCode();

    /**
     * @param string $internalCode
     * @return void
     */
    public function setInternalCode($internalCode);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return void
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     * @return void
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getTelephone();

    /**
     * @param string $telephone
     * @return void
     */
    public function setTelephone($telephone);
}