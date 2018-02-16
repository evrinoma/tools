<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 2/9/18
 * Time: 5:45 PM
 */

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Http\HttpUtils;

/**
 * Class AuthenticatorGuard
 *
 * @package App\Security
 */
class AuthenticatorGuard extends AbstractGuardAuthenticator
{

//region SECTION: Fields
    private const         HOMEPAGE    = 'core_display';
    private const         LOGIN_CHECK = 'login_check';
    private const         LOGIN       = 'login';
    /**
     * @var HttpUtils
     */
    private $httpUtils;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var Ldap
     */
    private $ldap;
    /**
     * @var CsrfTokenManagerInterface
     */
    private $csrfTokenManager;

//endregion Fields

//region SECTION: Constructor
    /**
     * @param HttpUtils                 $httpUtils
     * @param Ldap                      $ldap
     * @param TokenStorageInterface     $tokenStorage
     * @param CsrfTokenManagerInterface $csrfTokenManager
     */
    public function __construct(httpUtils $httpUtils, Ldap $ldap, TokenStorageInterface $tokenStorage, CsrfTokenManagerInterface $csrfTokenManager)    {
        $this->httpUtils         = $httpUtils;
        $this->ldap              = $ldap;
        $this->tokenStorage      = $tokenStorage;
        $this->csrfTokenManager  = $csrfTokenManager;

    }
//endregion Constructor


//region SECTION: Public

    /**
     * Returns a response that directs the user to authenticate.
     *
     * This is called when an anonymous request accesses a resource that
     * requires authentication. The job of this method is to return some
     * response that "helps" the user start into the authentication process.
     *
     * Examples:
     *  A) For a form login, you might redirect to the login page
     *      return new RedirectResponse('/login');
     *  B) For an API token authentication system, you return a 401 response
     *      return new Response('Auth header required', 401);
     *
     * @param Request                 $request       The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return $this->httpUtils->createRedirectResponse($request, self::LOGIN);
    }

    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function supports(Request $request)
    {
        return true;
    }

    /**
     * Returns true if the credentials are valid.
     *
     * If any value other than true is returned, authentication will
     * fail. You may also throw an AuthenticationException if you wish
     * to cause authentication to fail.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * @param mixed         $credentials
     * @param UserInterface $user
     *
     * @return bool
     *
     * @throws AuthenticationException
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        if ($user && $this->noNeedLdapAuthorize($user)) {
            return false;
        }

        if (($user && $credentials->isAuthorized()) || ($user && $credentials->isTestUser()) || ($user && $this->ldap->checkUser($credentials->getUserName(), $credentials->getPassword()))) {
            $credentials->authorizeUser();

            return true;
        } else {
            throw new BadCredentialsException("Нет доступа!!!");
        }
    }

    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the login page or a 403 response.
     *
     * If you return null, the request will continue, but the user will
     * not be authenticated. This is probably not what you want to do.
     *
     * @param Request                 $request
     * @param AuthenticationException $exception
     *
     * @return Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return null;
    }

    /**
     * Called when authentication executed and was successful!
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the last page they visited.
     *
     * If you return null, the current request will continue, and the user
     * will be authenticated. This makes sense, for example, with an API.
     *
     * @param Request        $request
     * @param TokenInterface $token
     * @param string         $providerKey The provider (i.e. firewall) key
     *
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return ($this->httpUtils->checkRequestPath($request, '/'.self::LOGIN_CHECK)) ? $this->httpUtils->createRedirectResponse($request, self::HOMEPAGE) : null;
    }

    /**
     * Does this method support remember me cookies?
     *
     * Remember me cookie will be set if *all* of the following are met:
     *  A) This method returns true
     *  B) The remember_me key under your firewall is configured
     *  C) The "remember me" functionality is activated. This is usually
     *      done by having a _remember_me checkbox in your form, but
     *      can be configured by the "always_remember_me" and "remember_me_parameter"
     *      parameters under the "remember_me" firewall key
     *  D) The onAuthenticationSuccess method returns a Response object
     *
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }
//endregion Public

//region SECTION: Private
    /**
     * @param UserInterface $user
     *
     * @return mixed
     */
    private function noNeedLdapAuthorize($user)
    {
        return $user->hasRole('ROLE_NO_LDAP');
    }
//endregion Private

//region SECTION: Getters/Setters
    /**
     * Get the authentication credentials from the request and return them
     * as any type (e.g. an associate array).
     *
     * Whatever value you return here will be passed to getUser() and checkCredentials()
     *
     * For example, for a form login, you might:
     *
     *      return array(
     *          'username' => $request->request->get('_username'),
     *          'password' => $request->request->get('_password'),
     *      );
     *
     * Or for an API token that's on a header, you might use:
     *
     *      return array('api_key' => $request->headers->get('X-API-TOKEN'));
     *
     * @param Request $request
     *
     * @return mixed Any non-null value
     *
     * @throws \UnexpectedValueException If null is returned
     */
    public function getCredentials(Request $request)
    {
        $credentials = new class
        {
            const TEST_USER_NAME = "test";
            const TEST_PASSWORD  = "test";
            private $username   = null;
            private $password   = null;
            private $csrfToken  = null;
            private $authorized = false;

            public function getUserName()
            {
                return $this->username;
            }

            public function getPassword()
            {
                return $this->password;
            }

            public function getCsrfToken()
            {
                return $this->csrfToken;
            }

            public function setUserName($username)
            {
                $this->username = $username;

                return $this;
            }

            public function setPassword($password)
            {
                $this->password = $password;

                return $this;
            }

            public function setCsrfToken($csrfToken)
            {
                $this->csrfToken = $csrfToken;

                return $this;
            }

            public function isAuthorized()
            {
                return $this->authorized;
            }

            public function authorizeUser()
            {
                $this->authorized = true;

                return $this;
            }

            public function isTestUser()
            {
                return (self::TEST_USER_NAME === $this->username && self::TEST_PASSWORD === $this->password);
            }
        };

        if ($request->request->has('_username')) {
            $credentials->setUserName(trim($request->request->get('_username')));
        }
        if ($request->request->has('_password')) {
            $credentials->setPassword($request->request->get('_password'));
        }
        if ($request->request->has('_csrf_token')) {
            $credentials->setCsrfToken($request->request->get('_csrf_token'));
            if (false === $this->csrfTokenManager->isTokenValid(new CsrfToken('authenticate', $credentials->getCsrfToken()))) {
                throw new InvalidCsrfTokenException('Invalid CSRF token.');
            }

        }

        if ($this->tokenStorage->getToken()) {
            $credentials->setUserName($this->tokenStorage->getToken()->getUser()->getUserName());
            $credentials->authorizeUser();
        }


        return $credentials;
    }

    /**
     * Return a UserInterface object based on the credentials.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * You may throw an AuthenticationException if you wish. If you return
     * null, then a UsernameNotFoundException is thrown for you.
     *
     * @param mixed                 $credentials
     * @param UserProviderInterface $userProvider
     *
     * @throws AuthenticationException
     *
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials->getUserName());
    }
//endregion Getters/Setters
}