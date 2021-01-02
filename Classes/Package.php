<?php
declare(strict_types=1);

namespace Shel\Flow\DebugBar;

use Neos\Flow\Core\Bootstrap;
use Neos\Flow\Package\Package as BasePackage;
use Neos\Flow\Persistence\Doctrine\EntityManagerFactory;
use Shel\Flow\DebugBar\Debug\FlowDebugBar;

/**
 * The Flow Package
 */
class Package extends BasePackage
{
    /**
     * Invokes custom PHP code directly after the package manager has been initialized.
     *
     * @param Bootstrap $bootstrap The current bootstrap
     * @return void
     */
    public function boot(Bootstrap $bootstrap)
    {
        $dispatcher = $bootstrap->getSignalSlotDispatcher();
        $dispatcher->connect(
            EntityManagerFactory::class,
            'afterDoctrineEntityManagerCreation',
            FlowDebugBar::class,
            'addDoctrineCollector'
        );
    }
}
