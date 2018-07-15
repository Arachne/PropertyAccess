<?php

declare(strict_types=1);

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
        self::assertInstanceOf(PropertyAccessorBuilder::class, $builder);
        self::assertFalse($builder->isMagicCallEnabled());
        self::assertFalse($builder->isExceptionOnInvalidIndexEnabled());

        $accessor = $this->tester->grabService(PropertyAccessorInterface::class);
        self::assertInstanceOf(PropertyAccessorInterface::class, $accessor);
        self::assertAttributeSame(false, 'magicCall', $accessor);
        self::assertAttributeSame(true, 'ignoreInvalidIndices', $accessor);
    }

    public function testCustomConfiguration(): void
    {
        $this->tester->useConfigFiles(['config/custom.neon']);

        $builder = $this->tester->grabService(PropertyAccessorBuilder::class);
        self::assertInstanceOf(PropertyAccessorBuilder::class, $builder);
        self::assertTrue($builder->isMagicCallEnabled());
        self::assertTrue($builder->isExceptionOnInvalidIndexEnabled());

        $accessor = $this->tester->grabService(PropertyAccessorInterface::class);
        self::assertInstanceOf(PropertyAccessorInterface::class, $accessor);
        self::assertAttributeSame(true, 'magicCall', $accessor);
        self::assertAttributeSame(false, 'ignoreInvalidIndices', $accessor);
    }
}
