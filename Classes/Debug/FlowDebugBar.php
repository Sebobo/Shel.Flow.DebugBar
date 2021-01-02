<?php
declare(strict_types=1);

namespace Shel\Flow\DebugBar\Debug;

use Doctrine\DBAL\Logging\DebugStack;
use DebugBar\DataCollector\ExceptionsCollector;
use DebugBar\DataCollector\MemoryCollector;
use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DataCollector\PhpInfoCollector;
use DebugBar\DataCollector\RequestDataCollector;
use DebugBar\DataCollector\TimeDataCollector;
use DebugBar\DebugBar;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Debug bar subclass which adds all included collectors
 */
class FlowDebugBar extends DebugBar
{
    protected static EntityManagerInterface $entityManager;

    public function __construct()
    {
        $this->addCollector(new PhpInfoCollector());
        $this->addCollector(new MessagesCollector());
        $this->addCollector(new RequestDataCollector());
        $this->addCollector(new TimeDataCollector());
        $this->addCollector(new MemoryCollector());
        $this->addCollector(new ExceptionsCollector());
    }

    public static function addDoctrineCollector($config, $entityManager): void
    {
        if (!$entityManager->getConnection()->getConfiguration()->getSQLLogger()) {
            $entityManager->getConnection()->getConfiguration()->setSQLLogger(new DebugStack());
        }
        self::$entityManager = $entityManager;
    }

    public function getCollectors(): array
    {
        if (!$this->hasCollector('doctrine')) {
            $debugStack = self::$entityManager->getConnection()->getConfiguration()->getSQLLogger();
            $this->addCollector(new DoctrineCollector($debugStack));
        }

        return parent::getCollectors();
    }
}
