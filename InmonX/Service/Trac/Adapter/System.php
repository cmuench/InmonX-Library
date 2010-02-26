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
 * @package    InmonX_Service
 * @copyright  Copyright (c) 2008 INMON GmbH (http://www.inmon.de)
 * @license    http://www.inmon.de/licences/new-bsd     New BSD License
 * @version    $Id$
 */

require_once 'InmonX/Service/Trac/Adapter/Abstract.php';

class InmonX_Service_Trac_Adapter_System extends InmonX_Service_Trac_Adapter_Abstract
{
	/**
	 * API Version
	 * 
	 * @return string
	 */
	public function getAPIVersion()
	{
		return implode('.', $this->_xmlRpcClient->call('system.getAPIVersion'));
	}
	
	/**
	 * Returns the supported methods
	 * 
	 * @return array
	 */
	public function listMethods()
	{
		return $this->_xmlRpcClient->call('system.listMethods');	
	}
}