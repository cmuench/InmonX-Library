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
require_once 'InmonX/Service/Trac/Entity/Ticket.php';

class InmonX_Service_Trac_Adapter_Ticket extends InmonX_Service_Trac_Adapter_Abstract
{
	public function query($query = 'status!=closed')
	{
		return $this->_xmlRpcClient->call('ticket.query', array($query));
	}
	
	/**
	 * @param integer $ticketId
	 * @return InmonX_Service_Trac_Entity_Ticket 
	 */
	public function get($ticketId)
	{
		$data = $this->_xmlRpcClient->call('ticket.get', array($ticketId));
		return new InmonX_Service_Trac_Entity_Ticket($data[0], $data[1], $data[2], $data[3]);
	}
	
	/**
	 * Creates a new ticket and returns the new ticket ID. 
	 * 
	 * @param string $ticket
	 * @param boolean $notify
	 * @return integer
	 */
	public function create(InmonX_Service_Trac_Entity_Ticket $ticket, $notify = false)
	{
		if ($ticket->getSummary() === null) {
			throw new InmonX_Service_Trac_Exception('Summary must be set. Cannot create ticket.');
		}
		if ($ticket->getDescription() === null) {
			throw new InmonX_Service_Trac_Exception('Description must be set. Cannot create ticket.');
		}
		return $this->_xmlRpcClient->call('ticket.create', array($ticket->getSummary(), 
		                                                         $ticket->getDescription(), 
		                                                         $ticket->getAttributes(), 
		                                                         $notify));
	}
	
	/**
	 * Deletes a ticket with the given id.
	 * Returns true if deletion was successful.
	 * 
	 * @param integer $id
	 * @return boolean
	 */
	public function delete($id)
	{
		return $this->_xmlRpcClient->call('ticket.delete', array($id)) == 0;
	}
}