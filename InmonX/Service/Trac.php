<?php
/**
 * InmonX Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.inmon.de/licences/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   InmonX
 * @package    Inmon_Service
 * @copyright  Copyright (c) 2008 INMON GmbH (http://www.inmon.de)
 * @license    http://www.inmon.de/licences/new-bsd     New BSD License
 * @version    $Id$
 */

require_once 'Zend/Loader/PluginLoader.php';
require_once 'Zend/Uri.php';

class Inmon_Service_Trac
{
	const SERVICE_SYSTEM = 'system';
	const SERVICE_TICKET = 'ticket';
	
	/**
	 * Service loader
	 *
	 * @var Zend_Loader_PluginLoader
	 */
	protected $_serviceLoader;
	
	/**
	 * @var string
	 */
	protected $_serverAddress;
	
	/**
	 * @var array
	 */
	protected $_httpAuth = null;
	
	/**
     * Creates service
     *
     * @param string $tracRootUrl
     * @param string $username
     * @param string $password
     */
	public function __construct($tracRootUrl, $username, $password)
	{
		$this->_serviceLoader = new Zend_Loader_PluginLoader();
		$this->_serviceLoader->addPrefixPath('Inmon_Service_Trac_Adapter', 'Inmon/Service/Trac/Adapter');
		
		$uri = new Zend_Uri_Http($tracRootUrl);
		$uri->setUsername($username);
		$uri->setPassword($password);
		$uri->setPath(str_replace('//', '/', $uri->getPath() .'/login/xmlrpc'));
		$this->_serverAddress = $uri->getUri();
	}
	
	/**
	 * HTTP Authentification 
	 * 
	 * @param strign $username
	 * @param strinv $password
	 * @param string $type
	 * @return void
	 */
	public function setHttpAuth($username, $password, $type = 'basic')
	{
		$this->_httpAuth = array('username' => $username,
		                         'password' => $password,
		                         'type' => $type);
	}
	
	/**
	 * Returns the service loader
	 *
	 * @return Zend_Loader_PluginLoader
	 */
	public function getServiceLoader()
	{
		return $this->_serviceLoader;
	}
	
	/**
	 * Set service loader
	 *
	 * @param Zend_Loader_PluginLoader $loader
	 * @return void
	 */
	public function setServiceLoader(Zend_Loader_PluginLoader $loader)
	{
		$this->_serviceLoader = $loader;
	}
	
	/**
	 * Creates system service
	 * 
	 * @return Inmon_Service_Trac_Adapter_Service
	 */
	public function system()
	{
		return $this->_serviceFactory(self::SERVICE_SYSTEM);
	}
	
	/**
	 * Creates ticket service
	 * 
	 * @return Inmon_Service_Trac_Adapter_Service
	 */
	public function ticket()
	{
		return $this->_serviceFactory(self::SERVICE_TICKET);
	}
	
	/**
	 * Creates a new service object
	 *
	 * @param string $service
	 * @return Inmon_Service_Trac_Adapter_Abstract|boolean
	 */
	protected function _serviceFactory($service)
	{
		try {
			$serviceClass = $this->_serviceLoader->load($service);
			$service = new $serviceClass($this->_serverAddress);
			if ($this->_httpAuth !== null) {
				$service->getXmlRpcClient()->getHttpClient()->setAuth(
					$this->_httpAuth['username'],
				    $this->_httpAuth['password'],
				    $this->_httpAuth['type']
				);
			}
			return $service;
		} catch (Zend_Loader_PluginLoader_Exception $e) {
			require_once 'InmonX/Service/Trac/Exception.php';
			throw new Inmon_Service_Trac_Exception(sprintf('Service "%s" could not be loaded. Reason: %s', $service, $e->getMessage()));
		}
		return false;
	}
}