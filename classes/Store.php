<?php
/*
* 2007-2011 PrestaShop 
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 6844 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class StoreCore extends ObjectModel
{
	/** @var integer Country id */
	public		$id_country;

	/** @var integer State id */
	public		$id_state;
	
	/** @var string Store name */
	public 		$name;
	
	/** @var string Address first line */
	public 		$address1;

	/** @var string Address second line (optional) */
	public 		$address2;

	/** @var string Postal code */
	public 		$postcode;

	/** @var string City */
	public 		$city;
	
	/** @var float Latitude */
	public 		$latitude;
	
	/** @var float Longitude */
	public 		$longitude;
	
	/** @var string Store hours (PHP serialized) */
	public 		$hours;
	
	/** @var string Phone number */
	public 		$phone;
	
	/** @var string Fax number */
	public 		$fax;
	
	/** @var string Note */
	public		$note;
	
	/** @var string e-mail */
	public 		$email;
	
	/** @var string Object creation date */
	public 		$date_add;

	/** @var string Object last modification date */
	public 		$date_upd;
	
	/** @var boolean Store status */
	public 		$active = true;
	
 	
 	
 	

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'store',
		'primary' => 'id_store',
		'fields' => array(
			'id_country' => array('type' => 'FILL_ME', 'validate' => 'isUnsignedId', 'required' => true),
			'id_state' => array('type' => 'FILL_ME', 'validate' => 'isNullOrUnsignedId'),
			'name' => array('type' => 'FILL_ME', 'validate' => 'isGenericName', 'required' => true, 'size' => 128),
			'address1' => array('type' => 'FILL_ME', 'validate' => 'isAddress', 'required' => true, 'size' => 128),
			'address2' => array('type' => 'FILL_ME', 'validate' => 'isAddress', 'size' => 128),
			'city' => array('type' => 'FILL_ME', 'validate' => 'isCityName', 'required' => true, 'size' => 64),
			'latitude' => array('type' => 'FILL_ME', 'validate' => 'isCoordinate', 'size' => 12),
			'longitude' => array('type' => 'FILL_ME', 'validate' => 'isCoordinate', 'size' => 12),
			'hours' => array('type' => 'FILL_ME', 'validate' => 'isSerializedArray', 'size' => 254),
			'phone' => array('type' => 'FILL_ME', 'validate' => 'isPhoneNumber', 'size' => 16),
			'fax' => array('type' => 'FILL_ME', 'validate' => 'isPhoneNumber', 'size' => 16),
			'note' => array('type' => 'FILL_ME', 'validate' => 'isCleanHtml', 'size' => 65000),
			'email' => array('type' => 'FILL_ME', 'validate' => 'isEmail', 'size' => 128),
			'active' => array('type' => 'FILL_ME', 'validate' => 'isBool', 'required' => true),
			'postcode' => array('type' => 'FILL_ME', 'size' => 12),
		),
	);

	
	protected	$webserviceParameters = array(
		'fields' => array(
			'id_country' => array('xlink_resource'=> 'countries'),
			'id_state' => array('xlink_resource'=> 'states'),
			'hours' => array('getter' => 'getWsHours', 'setter' => 'setWsHours'),
		),
	);

	public function getFields()
	{
		$this->validateFields();
		
		$fields['id_country'] = (int)$this->id_country;
		$fields['id_state'] = (int)$this->id_state;
		$fields['name'] = pSQL($this->name);
		$fields['address1'] = pSQL($this->address1);
		$fields['address2'] = pSQL($this->address2);
		$fields['postcode'] = pSQL($this->postcode);
		$fields['city'] = pSQL($this->city);
		$fields['latitude'] = (float)$this->latitude;
		$fields['longitude'] = (float)$this->longitude;
		$fields['hours'] = pSQL($this->hours);
		$fields['phone'] = pSQL($this->phone);
		$fields['fax'] = pSQL($this->fax);
		$fields['note'] = pSQL($this->note);
		$fields['email'] = pSQL($this->email);
		$fields['date_add'] = pSQL($this->date_add);
		$fields['date_upd'] = pSQL($this->date_upd);
		$fields['active'] = (int)$this->active;
		
		return $fields;
	}
	
	public function __construct($id_store = NULL, $id_lang = NULL)
	{
		parent::__construct($id_store, $id_lang);
		$this->id_image = ($this->id AND file_exists(_PS_STORE_IMG_DIR_.(int)$this->id.'.jpg')) ? (int)$this->id : false;
		$this->image_dir = _PS_STORE_IMG_DIR_;
	}
	
	public function getWsHours()
	{
		return implode(';', unserialize($this->hours));
	}
	
	public function setWsHours($hours)
	{
		$this->hours = serialize(explode(';', $hours));
		return true;
	}
}


