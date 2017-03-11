<?php

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

    public function loadConfiguration()
    {
        $this->validateConfig($this->defaults);

        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('propertyAccessorBuilder'))
            ->setClass(PropertyAccessorBuilder::class)
            ->addSetup($this->config['magicCall'] ? 'enableMagicCall' : 'disableMagicCall')
            ->addSetup($this->config['throwExceptionOnInvalidIndex'] ? 'enableExceptionOnInvalidIndex' : 'disableExceptionOnInvalidIndex');

        $builder->addDefinition($this->prefix('propertyAccessor'))
            ->setClass(PropertyAccessorInterface::class)
            ->setFactory(sprintf('@%s::getPropertyAccessor', PropertyAccessorBuilder::class));
    }
}
