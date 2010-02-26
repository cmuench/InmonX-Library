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

require_once 'Zend/Date.php';

class InmonX_Service_Trac_Entity_Ticket
{
	/**
	 * @var integer
	 */
	protected $_id = null;
	
	/**
	 * @var Zend_Date
	 */
	protected $_timeCreated = null;
	
	/**
	 * @var Zend_Date
	 */
	protected $_timeChanged = null;
	
	/**
	 * @var array
	 */
	protected $_attributes = array();
	
	public function __construct($id = null, $timeCreated = null, $timeChanged = null, $attributes = array())
	{
		$this->_id = $id;
		if ($timeCreated !== null) {
			$this->_timeCreated = $this->_parseDate($timeCreated); 
		}
		if ($timeChanged !== null) {
			$this->_timeChanged = $this->_parseDate($timeChanged);
		}
		$this->_attributes = $attributes;
	}

	protected function _parseDate($dateString)
	{
		$matches = array();	
		if (preg_match('/^(\d{4})(\d{2})(\d{2})T(\d{2}:\d{2}:\d{2})$/', $dateString, $matches)) {
			$date = new Zend_Date();
			$date->setYear($matches[1]);
			$date->setMonth($matches[2]);
			$date->setDay($matches[3]);
			$date->setTime($matches[4]);
			return $date;
		}
		return null;
	}
	
	public function setId($id)
	{
		$this->_id = $id;		
	}
	
	public function getId()
	{
		return $this->_id;
	}
	
	/**
	 * @return Zend_Date
	 */
	public function getTimeCreated()
	{
		return $this->_timeCreated;
	}
	
	/**
	 * @return Zend_Date
	 */
	public function getTimeChanged()
	{
		return $this->_timeChanged;
	}
	
	/**
	 * Set data
	 * 
	 * @param array $data
	 * @return void
	 */
	public function setAttributes(array $data)
	{
		$this->_attributes = $data;
	}
	
	/**
	 * Returns the attributs
	 * 
	 * @return array
	 */
	public function getAttributes()
	{
		return $this->_attributes;
	}
	
	public function setStatus($status)
	{
		$this->_attributes['status'] = $status;		
	}
	
	public function getStatus()
	{
		return $this->_attributes['status'];
	}
	
	public function setDescription($description)
	{
		$this->_attributes['description'] = $description;
	}
	
	public function getDescription()
	{
		return $this->_attributes['description'];
	}
	
	public function setReporter($reporter)
	{
		$this->_attributes['reporter'] = $reporter;	
	}
	
	public function getReporter()
	{
		return $this->_attributes['reporter'];
	}
	
	public function setCc($cc)
	{
		$this->_attributes['cc'] = $cc;
	}
	
	public function getCc()
	{
		return $this->_attributes['cc'];
	}
	
	public function setSummary($summary)
	{
		$this->_attributes['summary'] = $summary;	
	}
	
	public function getSummary()
	{
		return $this->_attributes['summary'];
	}
	
	public function setPriority($priority)
	{
		$this->_attributes['priority'] = $priority;
	}
	
	public function getPriority()
	{
		return $this->_attributes['priority'];
	}
	
	public function setKeywords($keywords)
	{
		$this->_attributes['keywords'] = $keywords;
	}
	
	public function getKeywords()
	{
		return $this->_attributes['keywords'];
	}
	
	public function setMilestone($milestone)
	{
		$this->_attributes['milestone'] = $milestone;
	}
	
	public function getMilestone()
	{
		return $this->_attributes['milestone'];
	}
	
	public function setOwner($owner)
	{
		$this->_attributes['owner'] = $owner;
	}
	
	public function getOwner()
	{
		return $this->_attributes['owner'];
	}
	
	public function setType($type)
	{
		$this->_attributes['type'] = $type;
	}
	
	public function getType()
	{
		return $this->_attributes['type'];
	}
}