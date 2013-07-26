<?php
namespace Reflexe\Bundle\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Represent a Role that any User MUST have.
 * A Role is a string and Namespace definition, and optional Bundle, Controller, Action definition.
 *
 * @package Reflexe\Bundle\SecurityBundle\Entity
 * @author Grégoire Hébert <gregoirehebert@reflexece.com>
 *
 * @ORM\Entity(repositoryClass="Reflexe\Bundle\SecurityBundle\Entity\ExternalRolesManager")
 */
class ExternalRole implements RoleInterface
{
    /**
     * action definition
     * @var string
     * @ORM\Column(type="string")
     */
    private $action;

    /**
     * bundle definition
     * @var string
     * @ORM\Column(type="string")
     */
    private $bundle;

    /**
     * controller definition
     * @var string
     * @ORM\Column(type="string")
     */
    private $controller;

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * namespace definition
     * @var string
     * @ORM\Column(type="string")
     */
    private $namespace;

    /**
     * role definition
     * @var string
     * @ORM\Column(type="string")
     */
    private $role;

    /**
     * Constructor
     *
     * @param string $role
     * @param string $namespace
     * @param string $bundle
     * @param string $controller
     * @param string $action
     */
    public function __construct($role, $namespace, $bundle = "", $controller = "", $action = "")
    {
        $this->role = $role;
        $this->namespace = $namespace;
        $this->bundle = $bundle;
        $this->controller = $controller;
        $this->action = $action;
    }

    /**
     * Returns the Action
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Return the Bundle
     * @return string
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * Return the Controller
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Returns the Id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the Namespace
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Return the Role
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Sets the Action
     * @param string $action
     */
    public function setAction($action = "")
    {
        $this->action = $action;
    }

    /**
     * Sets the Bundle
     * @param string $bundle
     */
    public function setBundle($bundle = "")
    {
        $this->bundle = $bundle;
    }

    /**
     * Sets the Controller
     * @param string $controller
     */
    public function setController($controller = "")
    {
        $this->controller = $controller;
    }

    /**
     * Sets the Namespace
     * @param $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * Set the Role
     * @param $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }
}