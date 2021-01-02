<?php
declare(strict_types=1);

namespace Shel\Flow\DebugBar\Debug;

use DebugBar\DebugBarException;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\ORM\EntityManager;

class DoctrineCollector extends \DebugBar\Bridge\DoctrineCollector
{
    /**
     * DoctrineCollector constructor.
     * @param $debugStackOrEntityManager
     * @throws DebugBarException
     */
    public function __construct($debugStackOrEntityManager)
    {
        if ($debugStackOrEntityManager instanceof EntityManager) {
            $debugStackOrEntityManager = $debugStackOrEntityManager->getConnection()->getConfiguration()->getSQLLogger();
        }
        if (!($debugStackOrEntityManager instanceof DebugStack || $debugStackOrEntityManager instanceof \t3n\Neos\Debug\Logging\DebugStack)) {
            throw new DebugBarException("'DoctrineCollector' requires an 'EntityManager' or 'DebugStack' object");
        }
        $this->debugStack = $debugStackOrEntityManager;
    }
}
