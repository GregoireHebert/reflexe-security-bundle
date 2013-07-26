<?php
namespace Reflexe\Bundle\SecurityBundle\Tests\Security\Authorization\Voter;

use PHPUnit_Framework_TestCase;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Reflexe\Bundle\SecurityBundle\Security\Authorization\Voter\ReflexeSecurityVoter;
use Reflexe\Bundle\SecurityBundle\Entity\ExternalRole;

/**
 * Tests the Class ReflexeSecurityVoter
 *
 * @author Grégoire Hébert <gregoirehebert@reflexece.com>
 */
class ReflexeSecurityVoterTest extends PHPUnit_Framework_TestCase
{
    public function testVoteForActionGrantedRoles()
    {
        $mockRepoBuilder = $this->getMockBuilder('Reflexe\Bundle\SecurityBundle\Entity\ExternalRolesManager', ['findAllByRoute']);
        $mockRepoBuilder->disableOriginalConstructor();
        $mockRepo = $mockRepoBuilder->getMock();
        $mockRepo->expects($this->once())->method('findAllByRoute')->will($this->returnValue($this->getActionRoles()));

        $request = $this->createMockedRequestWithControllerAttribute('Acme\Bundle\DemoBundle\Controller\WelcomeController::indexAction');

        $containerInterface = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $containerInterface->expects($this->any())->method('get')->with('request')->will($this->returnValue($request));

        $voter = new ReflexeSecurityVoter($containerInterface, $mockRepo);

        $token = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $token->expects($this->any())->method('getRoles')->will($this->returnValue([
                    new Role('ROLE_USER'),
                    new Role('ROLE_DEMO'),
                    new Role('ROLE_WELCOME'),
                    new Role('ROLE_INDEX')
                ]));

        $this->assertEquals(1,$voter->vote($token, null, []));
    }

    public function testVoteForActionNotGrantedRoles()
    {
        $mockRepoBuilder = $this->getMockBuilder('Reflexe\Bundle\SecurityBundle\Entity\ExternalRolesManager', ['findAllByRoute']);
        $mockRepoBuilder->disableOriginalConstructor();
        $mockRepo = $mockRepoBuilder->getMock();
        $mockRepo->expects($this->once())->method('findAllByRoute')->will($this->returnValue($this->getActionRoles()));

        $request = $this->createMockedRequestWithControllerAttribute('Acme\Bundle\DemoBundle\Controller\WelcomeController::indexAction');

        $containerInterface = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $containerInterface->expects($this->any())->method('get')->with('request')->will($this->returnValue($request));

        $voter = new ReflexeSecurityVoter($containerInterface, $mockRepo);

        $token = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $token->expects($this->any())->method('getRoles')->will($this->returnValue([]));

        $this->assertEquals(-1,$voter->vote($token, null, []));
    }

    public function testVoteWithoutRolesExpected()
    {
        $mockRepoBuilder = $this->getMockBuilder('Reflexe\Bundle\SecurityBundle\Entity\ExternalRolesManager', ['findAllByRoute']);
        $mockRepoBuilder->disableOriginalConstructor();
        $mockRepo = $mockRepoBuilder->getMock();
        $mockRepo->expects($this->once())->method('findAllByRoute')->will($this->returnValue([]));

        $request = $this->createMockedRequestWithControllerAttribute('Acme\Bundle\DemoBundle\Controller\WelcomeController::indexAction');

        $containerInterface = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $containerInterface->expects($this->any())->method('get')->with('request')->will($this->returnValue($request));

        $voter = new ReflexeSecurityVoter($containerInterface, $mockRepo);

        $token = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $token->expects($this->any())->method('getRoles')->will($this->returnValue([]));

        $this->assertEquals(0,$voter->vote($token, null, []));
    }

    public function testVoteForControllerGrantedRoles()
    {
        $mockRepoBuilder = $this->getMockBuilder('Reflexe\Bundle\SecurityBundle\Entity\ExternalRolesManager', ['findAllByRoute']);
        $mockRepoBuilder->disableOriginalConstructor();
        $mockRepo = $mockRepoBuilder->getMock();
        $mockRepo->expects($this->once())->method('findAllByRoute')->will($this->returnValue($this->getControllerRoles()));

        $request = $this->createMockedRequestWithControllerAttribute('Acme\Bundle\DemoBundle\Controller\WelcomeController::OtherAction');

        $containerInterface = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $containerInterface->expects($this->any())->method('get')->with('request')->will($this->returnValue($request));

        $voter = new ReflexeSecurityVoter($containerInterface, $mockRepo);

        $token = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $token->expects($this->any())->method('getRoles')->will($this->returnValue([
                    new Role('ROLE_USER'),
                    new Role('ROLE_DEMO'),
                    new Role('ROLE_WELCOME')
                ]));

        $this->assertEquals(1,$voter->vote($token, null, []));
    }

    public function testVoteForControllerNotGrantedRoles()
    {
        $mockRepoBuilder = $this->getMockBuilder('Reflexe\Bundle\SecurityBundle\Entity\ExternalRolesManager', ['findAllByRoute']);
        $mockRepoBuilder->disableOriginalConstructor();
        $mockRepo = $mockRepoBuilder->getMock();
        $mockRepo->expects($this->once())->method('findAllByRoute')->will($this->returnValue($this->getControllerRoles()));

        $request = $this->createMockedRequestWithControllerAttribute('Acme\Bundle\DemoBundle\Controller\WelcomeController::OtherAction');

        $containerInterface = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $containerInterface->expects($this->any())->method('get')->with('request')->will($this->returnValue($request));

        $voter = new ReflexeSecurityVoter($containerInterface, $mockRepo);

        $token = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $token->expects($this->any())->method('getRoles')->will($this->returnValue([]));

        $this->assertEquals(-1,$voter->vote($token, null, []));
    }

    public function testVoteForBundleGrantedRoles()
    {
        $mockRepoBuilder = $this->getMockBuilder('Reflexe\Bundle\SecurityBundle\Entity\ExternalRolesManager', ['findAllByRoute']);
        $mockRepoBuilder->disableOriginalConstructor();
        $mockRepo = $mockRepoBuilder->getMock();
        $mockRepo->expects($this->once())->method('findAllByRoute')->will($this->returnValue($this->getBundleRoles()));

        $request = $this->createMockedRequestWithControllerAttribute('Acme\Bundle\DemoBundle\Controller\OtherController::OtherAction');

        $containerInterface = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $containerInterface->expects($this->any())->method('get')->with('request')->will($this->returnValue($request));

        $voter = new ReflexeSecurityVoter($containerInterface, $mockRepo);

        $token = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $token->expects($this->any())->method('getRoles')->will($this->returnValue([
                    new Role('ROLE_USER'),
                    new Role('ROLE_DEMO')
                ]));

        $this->assertEquals(1,$voter->vote($token, null, []));
    }

    public function testVoteForBundleNotGrantedRoles()
    {
        $mockRepoBuilder = $this->getMockBuilder('Reflexe\Bundle\SecurityBundle\Entity\ExternalRolesManager', ['findAllByRoute']);
        $mockRepoBuilder->disableOriginalConstructor();
        $mockRepo = $mockRepoBuilder->getMock();
        $mockRepo->expects($this->once())->method('findAllByRoute')->will($this->returnValue($this->getBundleRoles()));

        $request = $this->createMockedRequestWithControllerAttribute('Acme\Bundle\DemoBundle\Controller\OtherController::OtherAction');

        $containerInterface = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $containerInterface->expects($this->any())->method('get')->with('request')->will($this->returnValue($request));

        $voter = new ReflexeSecurityVoter($containerInterface, $mockRepo);

        $token = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $token->expects($this->any())->method('getRoles')->will($this->returnValue([]));

        $this->assertEquals(-1,$voter->vote($token, null, []));
    }

    public function testVoteForNamespaceGrantedRoles()
    {
        $mockRepoBuilder = $this->getMockBuilder('Reflexe\Bundle\SecurityBundle\Entity\ExternalRolesManager', ['findAllByRoute']);
        $mockRepoBuilder->disableOriginalConstructor();
        $mockRepo = $mockRepoBuilder->getMock();
        $mockRepo->expects($this->once())->method('findAllByRoute')->will($this->returnValue($this->getNamespaceRoles()));

        $request = $this->createMockedRequestWithControllerAttribute('Acme\Bundle\OtherBundle\Controller\OtherController::OtherAction');

        $containerInterface = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $containerInterface->expects($this->any())->method('get')->with('request')->will($this->returnValue($request));

        $voter = new ReflexeSecurityVoter($containerInterface, $mockRepo);

        $token = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $token->expects($this->any())->method('getRoles')->will($this->returnValue([
                    new Role('ROLE_USER'),
                    new Role('ROLE_DEMO')
                ]));

        $this->assertEquals(1,$voter->vote($token, null, []));
    }

    public function testVoteForNamespaceNotGrantedRoles()
    {
        $mockRepoBuilder = $this->getMockBuilder('Reflexe\Bundle\SecurityBundle\Entity\ExternalRolesManager', ['findAllByRoute']);
        $mockRepoBuilder->disableOriginalConstructor();
        $mockRepo = $mockRepoBuilder->getMock();
        $mockRepo->expects($this->once())->method('findAllByRoute')->will($this->returnValue($this->getNamespaceRoles()));

        $request = $this->createMockedRequestWithControllerAttribute('Acme\Bundle\OtherBundle\Controller\OtherController::OtherAction');

        $containerInterface = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $containerInterface->expects($this->any())->method('get')->with('request')->will($this->returnValue($request));

        $voter = new ReflexeSecurityVoter($containerInterface, $mockRepo);

        $token = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $token->expects($this->any())->method('getRoles')->will($this->returnValue([]));

        $this->assertEquals(-1,$voter->vote($token, null, []));
    }


    /**
     * Returns a bunch of roles to get in Action situation, Replace the ExternalRolesManager
     *
     * @return array
     */
    public function getActionRoles()
    {
        return [
            new ExternalRole('ROLE_USER','Acme'),
            new ExternalRole('ROLE_DEMO','Acme', 'Demo'),
            new ExternalRole('ROLE_WELCOME','Acme', 'Demo', 'Welcome'),
            new ExternalRole('ROLE_INDEX','Acme', 'Demo', 'Welcome', 'index')
        ];
    }

    /**
     * Returns a bunch of roles to get in Controller situation, Replace the ExternalRolesManager
     *
     * @return array
     */
    public function getControllerRoles()
    {
        return [
            new ExternalRole('ROLE_USER','Acme'),
            new ExternalRole('ROLE_DEMO','Acme', 'Demo'),
            new ExternalRole('ROLE_WELCOME','Acme', 'Demo', 'Welcome'),
        ];
    }

    /**
     * Returns a bunch of roles to get in Bundle situation, Replace the ExternalRolesManager
     *
     * @return array
     */
    public function getBundleRoles()
    {
        return [
            new ExternalRole('ROLE_USER','Acme'),
            new ExternalRole('ROLE_DEMO','Acme', 'Demo'),
        ];
    }

    /**
     * Returns a bunch of roles to get in Namespace situation, Replace the ExternalRolesManager
     *
     * @return array
     */
    public function getNamespaceRoles()
    {
        return [
            new ExternalRole('ROLE_USER','Acme'),
        ];
    }

    /**
     * Returns a mocked request for AN attributes
     *
     * @param $controllerAttributeReturnValue
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function createMockedRequestWithControllerAttribute($controllerAttributeReturnValue)
    {
        $parameterBag = $this->getMock('Symfony\Component\HttpFoundation\ParameterBag');
        $parameterBag->expects($this->any())
            ->method('get')
            ->with('_controller')
            ->will($this->returnValue($controllerAttributeReturnValue));

        $requestBuilder = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request');
        $requestBuilder->disableOriginalConstructor();
        $request = $requestBuilder->getMock();
        $request->attributes = $parameterBag;

        return $request;
    }

}