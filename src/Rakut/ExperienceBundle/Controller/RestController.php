<?php
namespace Rakut\ExperienceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * RestController
 */
class RestController extends Controller
{
    /**
     * @param  mixed                                                         $condition
     * @param  string                                                        $message
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return void
     */
    public function forward404Unless($condition, $message = 'Not Found')
    {
        if (false == $condition) {
            throw $this->createNotFoundException($message);
        }
    }

    /**
     * @param  mixed                                                             $condition
     * @param  string                                                            $message
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     * @return void
     */
    public function forward403Unless($condition, $message = 'Access Denied')
    {
        if (false == $condition) {
            throw $this->createAccessDeniedException($message);
        }
    }

    /**
     * @throws \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException
     */
    public function forward401UnlessAuthenticatedUser()
    {
        if (false == $this->getSecurityContext()->isGranted('IS_AUTHENTICATED_FULLY', $this->getUser())) {
            throw $this->createUnauthorizedException();
        }
    }

    /**
     * {@inheritdoc}
     *
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function createNotFoundException($message = 'Not Found', \Exception $previous = null)
    {
        return new NotFoundHttpException($message, $previous);
    }

    /**
     * {@inheritdoc}
     *
     * @return \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function createAccessDeniedException($message = 'Access Denied', \Exception $previous = null)
    {
        return new AccessDeniedHttpException($message, $previous);
    }

    /**
     * @param  string                    $challenge
     * @param  string                    $message
     * @param  \Exception                $previous
     * @return UnauthorizedHttpException
     */
    public function createUnauthorizedException($challenge = 'Authentication required', $message = 'Authentication required', \Exception $previous = null)
    {
        return new UnauthorizedHttpException($challenge, $message, $previous);
    }

    /**
     * @return \Symfony\Component\Security\Core\SecurityContext
     */
    protected function getSecurityContext()
    {
        return $this->get('security.context');
    }
}
