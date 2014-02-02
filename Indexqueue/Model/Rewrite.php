<?php
/**
 * Created by PhpStorm.
 * User: Roberto
 * Date: 02/02/14
 * Time: 15.13
 */

class Gbinside_Indexqueue_Model_Rewrite extends Mage_Index_Model_Indexer {

    public $isQueueWorkerWorking;

    public function processEntityAction(Varien_Object $entity, $entityType, $eventType)
    {
        if (isset($this->isQueueWorkerWorking)) {
            return parent::processEntityAction($entity, $entityType, $eventType);
        }

        Mage::log(__METHOD__.' '.$entityType.' '.$eventType, null, 'indexqueue.log', true);
        $queue = Mage::helper('lilqueue')->getQueue('index_queue');

        $data = array(
            'entity'=> $entity->getData(),
            'entity_type'=>$entityType,
            'event_type'=>$eventType,
            'allow_table_changes' => $this->_allowTableChanges,
            'is_object_new' => method_exists ($entity, 'isObjectNew') ? $entity->isObjectNew() : false,
        );

        $task = Mage::helper('lilqueue')->createTask('indexQueue', $data);
        $queue->addTask($task);

        return $this;

        //
    }

} 