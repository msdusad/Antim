<?php
namespace ScnSocialAuth\Controller;

use Hybrid_Auth;
use Zend\Session\Container;
use ScnSocialAuth\Mapper\Exception as MapperException;
use ScnSocialAuth\Mapper\UserProviderInterface;
use ScnSocialAuth\Options\ModuleOptions;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ModelInterface;
use Zend\View\Model\ViewModel;
use Zend\Loader\StandardAutoloader;

class UserController extends AbstractActionController
{
    /**
     * @var UserProviderInterface
     */
    protected $mapper;

    /**
     * @var Hybrid_Auth
     */
    protected $hybridAuth;

    /**
     * @var ModuleOptions
     */
    protected $options;

    /*
     * @todo Make this dynamic / translation-friendly
     * @var string
     */
    protected $failedAddProviderMessage = 'Add provider failed. Please try again.';

    public function addProviderAction()
    {
        // Make sure the provider is enabled, else 404
        $provider = $this->params('provider');
        if (!in_array($provider, $this->getOptions()->getEnabledProviders())) {
            return $this->notFoundAction();
        }

        $authService = $this->zfcUserAuthentication()->getAuthService();

        // If user is not logged in, redirect to login page
        if (!$authService->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser/login');
        }

        $hybridAuth = $this->getHybridAuth();
        //$adapter = $hybridAuth->authenticate($provider);

        if (!$adapter->isUserConnected()) {
            $this->flashMessenger()->setNamespace('zfcuser-index')->addMessage($this->failedAddProviderMessage);

            return $this->redirect()->toRoute('zfcuser');
        }

        $localUser = $authService->getIdentity();
        $userProfile = $adapter->getUserProfile();
        $accessToken = $adapter->getAccessToken();
        $redirect = $this->params()->fromQuery('redirect', false);

        try {
            $this->getMapper()->linkUserToProvider($localUser, $userProfile, $provider, $accessToken);
        } catch (MapperException\ExceptionInterface $e) {
            $this->flashMessenger()->setNamespace('zfcuser-index')->addMessage($e->getMessage());
        }

        if ($this->getServiceLocator()->get('zfcuser_module_options')->getUseRedirectParameterIfPresent() && $redirect) {
            return $this->redirect()->toUrl($redirect);
        }

        return $this->redirect()->toRoute(
            $this->getServiceLocator()->get('zfcuser_module_options')->getLoginRedirectRoute()
        );
    }

    public function providerLoginAction()
    {
          
        $provider = $this->getEvent()->getRouteMatch()->getParam('provider');
        if (!in_array($provider, $this->getOptions()->getEnabledProviders())) {
            return $this->notFoundAction();
        }
        $hybridAuth = $this->getHybridAuth();

        $query = array('provider' => $provider);
        if ($this->getServiceLocator()->get('zfcuser_module_options')->getUseRedirectParameterIfPresent() && $this->getRequest()->getQuery()->get('redirect')) {
            $query = array_merge($query, array('redirect' => $this->getRequest()->getQuery()->get('redirect')));
        }
        $redirectUrl = $this->url()->fromRoute('scn-social-auth-user/authenticate', array(), array('query' => $query));
       
        $session = new Container('base');
        $session->offsetSet('provider', $provider);
        
        
//        $hybridAuth->authenticate(
//            $provider,
//            array(
//                'hauth_return_to' => $redirectUrl,
//            )
//        );

        return $this->redirect()->toUrl($redirectUrl);
    }

    public function loginAction()
    {
       if(isset($_COOKIE["PHPSESSID"]))
       {
       if(isset($_SESSION['base']) && isset($_SESSION['base']['provider']) && $_SESSION['base']['provider']!=''){$_SESSION['base']['provider']='';}
        }
        $zfcUserLogin = $this->forward()->dispatch('zfcuser', array('action' => 'login'));
        if (!$zfcUserLogin instanceof ModelInterface) {
            
            return $zfcUserLogin;
        } 
     
        $viewModel = new ViewModel();
        $viewModel->addChild($zfcUserLogin, 'zfcUserLogin');
        $viewModel->setVariable('options', $this->getOptions());

        $redirect = false;
        if ($this->getServiceLocator()->get('zfcuser_module_options')->getUseRedirectParameterIfPresent() && $this->getRequest()->getQuery()->get('redirect')) {
            $redirect = $this->getRequest()->getQuery()->get('redirect');
        }
      
        $viewModel->setVariable('redirect', $redirect);
         $viewModel->setVariable('widget', false);
        

        return $viewModel;
    }

    public function logoutAction()
    {
        $loader = new StandardAutoloader(array('autoregister_zf' => true));
       
        $loader->registerNamespace('Hybrid', APPLICATION_PATH . '/vendor/hybridauth/hybridauth/Hybrid');

        // Register the "Scapi" vendor prefix:
        $loader->registerPrefix('Hybrid', APPLICATION_PATH . '/vendor/hybridauth/hybridauth/Hybrid');

        // Optionally, specify the autoloader as a "fallback" autoloader;
        // this is not recommended.
        $loader->setFallbackAutoloader(true);

        // Register with spl_autoload:
        $loader->register();
                
        
       // Hybrid_Auth::logoutAllProviders();
        
        session_destroy();
       
        return $this->forward()->dispatch('zfcuser', array('action' => 'logout'));
    }

    public function registerAction()
    {
        $zfcUserRegister = $this->forward()->dispatch('zfcuser', array('action' => 'register'));
        if (!$zfcUserRegister instanceof ModelInterface) {
            return $zfcUserRegister;
        }
        $viewModel = new ViewModel();
        $viewModel->addChild($zfcUserRegister, 'zfcUserLogin');
        $viewModel->setVariable('options', $this->getOptions());

        $redirect = false;
        if ($this->getServiceLocator()->get('zfcuser_module_options')->getUseRedirectParameterIfPresent() && $this->getRequest()->getQuery()->get('redirect')) {
            $redirect = $this->getRequest()->getQuery()->get('redirect');
        }
        $viewModel->setVariable('redirect', $redirect);

        return $viewModel;
    }

    /**
     * set mapper
     *
     * @param  UserProviderInterface $mapper
     * @return HybridAuth
     */
    public function setMapper(UserProviderInterface $mapper)
    {
        $this->mapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return UserProviderInterface
     */
    public function getMapper()
    {
        if (!$this->mapper instanceof UserProviderInterface) {
            $this->setMapper($this->getServiceLocator()->get('ScnSocialAuth-UserProviderMapper'));
        }

        return $this->mapper;
    }

    /**
     * Get the Hybrid_Auth object
     *
     * @return Hybrid_Auth
     */
    public function getHybridAuth()
    {
        if (!$this->hybridAuth) {
            $this->hybridAuth = $this->getServiceLocator()->get('HybridAuth');
        }

        return $this->hybridAuth;
    }

    /**
     * Set the Hybrid_Auth object
     *
     * @param  Hybrid_Auth    $hybridAuth
     * @return UserController
     */
    public function setHybridAuth(Hybrid_Auth $hybridAuth)
    {
        $this->hybridAuth = $hybridAuth;

        return $this;
    }

    /**
     * set options
     *
     * @param  ModuleOptions  $options
     * @return UserController
     */
    public function setOptions(ModuleOptions $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * get options
     *
     * @return ModuleOptions
     */
    public function getOptions()
    {
        if (!$this->options instanceof ModuleOptions) {
            $this->setOptions($this->getServiceLocator()->get('ScnSocialAuth-ModuleOptions'));
        }

        return $this->options;
    }
}
