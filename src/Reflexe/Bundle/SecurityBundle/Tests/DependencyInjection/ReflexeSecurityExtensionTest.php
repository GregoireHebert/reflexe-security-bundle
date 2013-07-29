<?php
namespace Reflexe\Bundle\SecurityBundle\Tests\DependencyInjection;

use PHPUnit_Framework_TestCase;
use Reflexe\Bundle\SecurityBundle\DependencyInjection\ReflexeSecurityExtension;

/**
 * Tests the D.I.
 * @package Reflexe\Bundle\SecurityBundle\Tests\DependencyInjection
 * @author Grégoire Hébert <gregoirehebert@reflexece.com>
 */
class SecurityExtensionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Symfony\Component\DependencyInjection\ContainerBuilder
     */
    private $container;

    /**
     * Tests loading
     */
    public function testLoad()
    {
        $this->container->expects($this->atLeastOnce())->method('addResource');
        $this->container->expects($this->any())->method('setParameter');
        $reflexeSecurityExtension = new ReflexeSecurityExtension();
        $reflexeSecurityExtension->load([], $this->container);
    }

    /**
     * Tests the alias getter
     */
    public function testGetAlias()
    {
        $relexeSecurityExtension = new ReflexeSecurityExtension([], $this->container);

        $this->assertEquals("ReflexeSecurityBundle", $relexeSecurityExtension->getAlias());
    }

    /**
     * Define a ContainerBuilder
     */
    public function setUp()
    {
        $containerBuilder = $this->getMockBuilder("Symfony\Component\DependencyInjection\ContainerBuilder");
        $containerBuilder->disableOriginalConstructor();
        $this->container = $containerBuilder->getMock();
    }
}