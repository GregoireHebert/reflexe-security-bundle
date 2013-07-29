<?php
namespace Reflexe\Bundle\SecurityBundle\Tests\Entity;

use PHPUnit_Framework_TestCase;
use Reflexe\Bundle\SecurityBundle\Entity\ExternalRole;

/**
 * Tests
 * @package Reflexe\Bundle\SecurityBundle\Tests\Entity
 * @author Grégoire Hébert <gregoirehebert@reflexece.com>
 */
class ExternalRoleTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests the Id accessor
     */
    public function testGetId()
    {
        $ExternalRole = new ExternalRole("ROLE_USER", "Namespace");
        $ExternalRole->setId(2);

        $this->assertEquals(2, $ExternalRole->getId());
    }

    /**
     * Tests the Namespace accessor
     */
    public function testGetNamespace()
    {
        $ExternalRole = new ExternalRole("ROLE_USER", "Namespace");
        $ExternalRole->setNamespace("Namespace");

        $this->assertEquals("Namespace", $ExternalRole->getNamespace());
    }

    /**
     * Tests the Bundle accessor
     */
    public function testGetBundle()
    {
        $ExternalRole = new ExternalRole("ROLE_USER", "Namespace");
        $ExternalRole->setBundle("Bundle");

        $this->assertEquals("Bundle", $ExternalRole->getBundle());
    }

    /**
     * Tests the Controller accessor
     */
    public function testGetController()
    {
        $ExternalRole = new ExternalRole("ROLE_USER", "Namespace");
        $ExternalRole->setController("Controller");

        $this->assertEquals("Controller", $ExternalRole->getController());
    }

    /**
     * Tests the Action accessor
     */
    public function testGetAction()
    {
        $ExternalRole = new ExternalRole("ROLE_USER", "Namespace");
        $ExternalRole->setAction("index");

        $this->assertEquals("index", $ExternalRole->getAction());
    }

    /**
     * Tests the Role accessor
     */
    public function testGetRole()
    {
        $ExternalRole = new ExternalRole("ROLE_USER", "Namespace");

        $this->assertEquals("ROLE_USER", $ExternalRole->getRole());
    }

    /**
     * Tests the controller
     */
    public function testController()
    {
        $ExternalRole = new ExternalRole("ROLE_USER", "Namespace", "Bundle", "Controller", "index");

        $this->assertEquals("ROLE_USER", $ExternalRole->getRole());
        $this->assertEquals("index", $ExternalRole->getAction());
        $this->assertEquals("Controller", $ExternalRole->getController());
        $this->assertEquals("Bundle", $ExternalRole->getBundle());
        $this->assertEquals("Namespace", $ExternalRole->getNamespace());
    }
}