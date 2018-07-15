<?php

declare(strict_types=1);

namespace Arachne\PropertyAccess\DI;

use Nette\DI\CompilerExtension;
use Symfony\Component\PropertyAccess\PropertyAccessorBuilder;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class PropertyAccessExtension extends CompilerExtension
{
    /**
     * @var array
     */
    public $defaults = [
        'magicCall' => false,
        'throwExceptionOnInvalidIndex' => false,
    ];

    public function loadConfiguration(): void
    {
        $this->validateConfig($this->defaults);

        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('propertyAccessorBuilder'))
            ->setType(PropertyAccessorBuilder::class)
            ->addSetup((bool) $this->config['magicCall'] ? 'enableMagicCall' : 'disableMagicCall')
            ->addSetup((bool) $this->config['throwExceptionOnInvalidIndex'] ? 'enableExceptionOnInvalidIndex' : 'disableExceptionOnInvalidIndex');

        $builder->addDefinition($this->prefix('propertyAccessor'))
            ->setType(PropertyAccessorInterface::class)
            ->setFactory(sprintf('@%s::getPropertyAccessor', PropertyAccessorBuilder::class));
    }
}
