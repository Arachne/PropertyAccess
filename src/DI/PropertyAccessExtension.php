<?php

/**
 * This file is part of the Arachne
 *
 * Copyright (c) Jáchym Toušek (enumag@gmail.com)
 *
 * For the full copyright and license information, please view the file license.md that was distributed with this source code.
 */

namespace Arachne\PropertyAccess\DI;

use Nette\DI\CompilerExtension;

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
            ->setClass('Symfony\Component\PropertyAccess\PropertyAccessorBuilder')
            ->addSetup($this->config['magicCall'] ? 'enableMagicCall' : 'disableMagicCall')
            ->addSetup($this->config['throwExceptionOnInvalidIndex'] ? 'enableExceptionOnInvalidIndex' : 'disableExceptionOnInvalidIndex');

        $builder->addDefinition($this->prefix('propertyAccessor'))
            ->setClass('Symfony\Component\PropertyAccess\PropertyAccessorInterface')
            ->setFactory('@Symfony\Component\PropertyAccess\PropertyAccessorBuilder::getPropertyAccessor');
    }
}
