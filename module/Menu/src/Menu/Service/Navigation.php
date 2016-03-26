<?php
namespace Menu\Service;
 
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;
 
class Navigation extends DefaultNavigationFactory
{
    
    protected $nav;
    public function __construct($menu)
    {
        $this->nav =$menu;
    }
    protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
        if (null === $this->pages) {
            
            //FETCH data from table menu :
            $fetchMenu = $serviceLocator->get('Menu\model\MenuTable')->getMenuForNavigation($this->nav);
           
             if(count($fetchMenu)>0)
             {
                     foreach($fetchMenu as $key=>$row)
                     {
                       
                        $configuration['navigation'][$this->getName()][$row['name']] = array(
                             'label'  =>  $row['label'],
                             'route'  =>  $row['route'],
                             'action' =>  $row['action'],
                             'params'  => array('alias'=>$row['link']) 
                        );
                
                       /** 'pages'=>array(
                            'Login' =>array(
                                     'label' => 'Sign In',
                                     'route' => 'user',
                                     'action' => 'login',
                                    ),
                       **/
                    }
             }else{
                   $configuration['navigation'][$this->getName()]['home'] = array(
                             'label' => 'Home',
                             'route' => 'home',
                            
                   );
             }
         
           
            if (!isset($configuration['navigation'])) {
                throw new Exception\InvalidArgumentException('Could not find navigation configuration key');
            }
            if (!isset($configuration['navigation'][$this->getName()])) {
                throw new Exception\InvalidArgumentException(sprintf(
                    'Failed to find a navigation container by the name "%s"',
                    $this->getName()
                ));
            }
 
            $application = $serviceLocator->get('Application');
            $routeMatch  = $application->getMvcEvent()->getRouteMatch();
            $router      = $application->getMvcEvent()->getRouter();
            $pages       = $this->getPagesFromConfig($configuration['navigation'][$this->getName()]);
           
            $this->pages = $this->injectComponents($pages, $routeMatch, $router);
        }
        return $this->pages;
    }
   
}

