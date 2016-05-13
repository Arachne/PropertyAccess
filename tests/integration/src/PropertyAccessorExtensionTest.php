<?php

namespace Tests\Integration;

use Arachne\Bootstrap\Configurator;
use Codeception\Test\Unit;
use Symfony\Component\PropertyAccess\PropertyAccessorBuilder;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class PropertyAccessorExtensionTest extends Unit
{
    public function testDefaultConfiguration()
    {
        $container = $this->createContainer('default.neon');

        $builder = $container->getByType(PropertyAccessorBuilder::class);
        $this->assertInstanceOf(PropertyAccessorBuilder::class, $builder);
        $this->assertFalse($builder->isMagicCallEnabled());
        $this->assertFalse($builder->isExceptionOnInvalidIndexEnabled());

        $accessor = $container->getByType(PropertyAccessorInterface::class);
        $this->assertInstanceOf(PropertyAccessorInterface::class, $accessor);
        $this->assertAttributeSame(false, 'magicCall', $accessor);
        $this->assertAttributeSame(true, 'ignoreInvalidIndices', $accessor);
    }

    public function testCustomConfiguration()
    {
        $container = $this->createContainer('custom.neon');

        $builder = $container->getByType(PropertyAccessorBuilder::class);
        $this->assertInstanceOf(PropertyAccessorBuilder::class, $builder);
        $this->assertTrue($builder->isMagicCallEnabled());
        $this->assertTrue($builder->isExceptionOnInvalidIndexEnabled());

        $accessor = $container->getByType(PropertyAccessorInterface::class);
        $this->assertInstanceOf(PropertyAccessorInterface::class, $accessor);
        $this->assertAttributeSame(true, 'magicCall', $accessor);
        $this->assertAttributeSame(false, 'ignoreInvalidIndices', $accessor);
    }

    private function createContainer($file)
    {
        $config = new Configurator();
        $config->setTempDirectory(TEMP_DIR);
        $config->addConfig(__DIR__ . '/../config/' . $file);
        return $config->createContainer();
    }
}
