<?php
namespace Reflexe\Bundle\SecurityBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Repository to get any needed roles for a route from the namespace to the action.
 * @package Reflexe\SecurityBundle\Entity
 * @author Grégoire Hébert <gregoirehebert@reflexece.com>
 *
 */
class ExternalRolesManager extends EntityRepository
{
    /**
     * Find every ExternalRole matching the route from the namespace to the action
     * @param $request_controllerAttribute
     * @return array
     */
    public function findAllByRoute($request_controllerAttribute)
    {

        preg_match('/(.*?)(\\\Bundle)?\\\(.*?)Bundle\\\Controller\\\(.*?)Controller::(.*?)Action/', $request_controllerAttribute, $requestControllerExtraction);

        $namespace  = $requestControllerExtraction[1];
        $bundle     = $requestControllerExtraction[3];
        $controller = $requestControllerExtraction[4];
        $action     = $requestControllerExtraction[5];

        $roles = $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM ReflexeSecurityBundle:ExternalRole p
                 WHERE (p.namespace = :namespace
                 AND p.bundle = :empty
                 AND p.controller = :empty
                 AND p.action = :empty)
                 OR
                 (p.namespace = :namespace
                 AND p.bundle = :bundle
                 AND p.controller = :empty
                 AND p.action = :empty)
                 OR
                 (p.namespace = :namespace
                 AND p.bundle = :bundle
                 AND p.controller = :controller
                 AND p.action = :empty)
                 OR
                 (p.namespace = :namespace
                 AND p.bundle = :bundle
                 AND p.controller = :controller
                 AND p.action = :action)
                 ORDER BY p.role ASC'
            )->setParameters([
                'empty'     =>  "",
                'namespace' =>  $namespace,
                'bundle'    =>  $bundle,
                'controller'=>  $controller,
                'action'    =>  $action
            ])->getResult();

        return $roles;
    }

}