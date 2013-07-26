<?php
namespace Reflexe\Bundle\SecurityBundle\Security\Authorization\Voter;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 *
 * Bring dynamic role security from namespace to action through Bundle and controller
 *
 * @package Reflexe\Bundle\SecurityBundle\Security\Authorization\Voter
 * @author Grégoire Hébert <gregoirehebert@reflexece.com>
 */
class ReflexeSecurityVoter implements VoterInterface
{

    /*
     * {@inherit}
     *
     * @param ContainerInterface $request
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(ContainerInterface $container,EntityRepository $externalRoleManager)
    {
        $this->request     = $container->get('request');
        $this->externalRoleManager = $externalRoleManager;
    }

    /**
     * {@inherit}
     *
     * @param string $attribute
     * @return bool
     */
    public function supportsAttribute($attribute)
    {
        return true;
    }

    /**
     * {@inherit}
     *
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return true;
    }

    /**
     * {@inherit}
     *
     * @param TokenInterface $token
     * @param object $object
     * @param array $attributes
     * @return int
     * @throws AuthenticationCredentialsNotFoundException
     */
    function vote(TokenInterface $token, $object, array $attributes)
    {
        $requestedController = $this->request->attributes->get('_controller');

        //The controller is not a valid "a:b:c" controller string.
        if (3 != count($parts = explode(':', $requestedController))) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        $externalAttributes = $this->externalRoleManager->findAllByRoute($requestedController);
        $roles = $this->extractRoles($token);

        $result = VoterInterface::ACCESS_ABSTAIN;
        if (!empty($externalAttributes)) {
            foreach ($externalAttributes as $externalAttribute) {
                if (!$this->supportsAttribute($externalAttribute) || !$this->supportsClass($object)) {
                    continue;
                }

                $result = VoterInterface::ACCESS_GRANTED;
                // for each roles possessed
                $hasAttribute = false;
                foreach ($roles as $role) {
                    if ($externalAttribute->getRole() === $role->getRole()) {
                        $hasAttribute = true;
                        break;
                    }
                }

                if (!$hasAttribute) {
                    return VoterInterface::ACCESS_DENIED;
                }
            }
        }

        return $result;
    }

    protected function extractRoles(TokenInterface $token)
    {
        return $token->getRoles();
    }
}