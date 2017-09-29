<?php

namespace Tests\Integration;

use Arachne\Codeception\Module\NetteDIModule;
use Codeception\Test\Unit;
use Symfony\Component\PropertyAccess\PropertyAccessorBuilder;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class PropertyAccessorExtensionTest extends Unit
{
    /**
     * @var NetteDIModule
     */
    protected $tester;

    public function testDefaultConfiguration(): void
    {
        $this->tester->useConfigFiles(['config/default.neon']);

        $builder = $this->tester->grabService(PropertyAccessorBuilder::class);
        $this->assertInstanceOf(PropertyAccessorBuilder::class, $builder);
        $this->assertFalse($builder->isMagicCallEnabled());
        $this->assertFalse($builder->isExceptionOnInvalidIndexEnabled());

        $accessor = $this->tester->grabService(PropertyAccessorInterface::class);
        $this->assertInstanceOf(PropertyAccessorInterface::class, $accessor);
        $this->assertAttributeSame(false, 'magicCall', $accessor);
        $this->assertAttributeSame(true, 'ignoreInvalidIndices', $accessor);
    }

    public function testCustomConfiguration(): void
    {
        $this->tester->useConfigFiles(['config/custom.neon']);

        $builder = $this->tester->grabService(PropertyAccessorBuilder::class);
        $this->assertInstanceOf(PropertyAccessorBuilder::class, $builder);
        $this->assertTrue($builder->isMagicCallEnabled());
        $this->assertTrue($builder->isExceptionOnInvalidIndexEnabled());

        $accessor = $this->tester->grabService(PropertyAccessorInterface::class);
        $this->assertInstanceOf(PropertyAccessorInterface::class, $accessor);
        $this->assertAttributeSame(true, 'magicCall', $accessor);
        $this->assertAttributeSame(false, 'ignoreInvalidIndices', $accessor);
    }
}
