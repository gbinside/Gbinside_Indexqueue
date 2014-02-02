<?php
/**
 * Created by PhpStorm.
 * User: Roberto
 * Date: 02/02/14
 * Time: 15.17
 */

class Gbinside_Indexqueue_Model_Worker extends Lilmuckers_Queue_Model_Worker_Abstract
{
    /**
     * This task ended properly
     * $task->success();
     *
     * This task needs to be repeated
     * $task->retry();
     *
     * This task errored and we should drop it from the queue for later examination
     * $task->hold();
     *
     * This worker is taking a long time, we should extend the time we're allowed to use it
     * $task->touch();
     *
     * @param Lilmuckers_Queue_Model_Queue_Task $task
     */

    public function indexQueue(Lilmuckers_Queue_Model_Queue_Task $task)
    {
        Mage::log(__METHOD__, null, 'indexqueue.log', true);

        $indexer = Mage::getModel('index/indexer');
        $indexer->isQueueWorkerWorking = 1;
        if ($task->getAllowTableChanges()) {
            $indexer->allowTableChanges();
        } else {
            $indexer->disallowTableChanges();
        }
        try {
#            $class = $task->getClass();
 #           Mage::log(__METHOD__.' ===> ' .$class, null, 'indexqueue.log', true);
            $vo = Mage::getModel('gbindexq/object');
            $vo->setData($task->getEntity());
            $vo->setIsObjectNew( $task->getIsObjectNew() );
            $indexer->processEntityAction($vo, $task->getEntityType(), $task->getEventType());
            $task->success();
        } catch (Exception $e) {
            echo $e->getMessage();
            $task->hold();
        }
    }
} 