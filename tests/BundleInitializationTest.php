<?php

namespace Links\Bundle\SpidBundle\Tests;

use Links\Bundle\SpidBundle\SpidBundle;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Nyholm\BundleTest\TestKernel;
use Links\Bundle\SpidBundle\Service;
use Symfony\Component\HttpKernel\KernelInterface;

class BundleInitializationTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }

    protected static function createKernel(array $options = []): KernelInterface
    {
        /**
         * @var TestKernel $kernel
         */
        $kernel = parent::createKernel($options);
        $kernel->addTestBundle(SpidBundle::class);
        $kernel->handleOptions($options);

        return $kernel;
    }

    public function testInitBundle(): void
    {
        // Boot the kernel.
        $kernel = self::bootKernel();

        // Get the container
        $container = $kernel->getContainer();

        // Or for FrameworkBundle@^5.3.6 to access private services without the PublicCompilerPass
        // $container = self::getContainer();

        // Test if your services exists
        $this->assertTrue($container->has('acme.foo'));
        $service = $container->get('acme.foo');
        $this->assertInstanceOf(Foo::class, $service);
    }

    public function testBundleWithDifferentConfiguration(): void
    {
        // Boot the kernel with a config closure, the handleOptions call in createKernel is important for that to work
        $kernel = self::bootKernel(['config' => static function (TestKernel $kernel) {
            // Add some other bundles we depend on
            $kernel->addTestBundle(OtherBundle::class);

            // Add some configuration
            $kernel->addTestConfig(__DIR__ . '/config.yml');
        }]);

    }
}
