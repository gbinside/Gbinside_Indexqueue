<?php
/**
 * Created by PhpStorm.
 * User: Roberto
 * Date: 02/02/14
 * Time: 17.30
 */

class Gbinside_Indexqueue_Model_Object extends Varien_Object
{
    public function isObjectNew()
    {
        return $this->getIsObjectNew() ? true : false;
    }
} 