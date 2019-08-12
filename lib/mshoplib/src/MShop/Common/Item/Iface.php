<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MShop
 * @subpackage Common
 */


namespace Aimeos\MShop\Common\Item;


/**
 * Generic interface for all items.
 *
 * @package MShop
 * @subpackage Common
 */
interface Iface
{
	/**
	 * Returns the item property for the given name
	 *
	 * @param string $name Name of the property
	 * @return mixed Property value or null if property is unknown
	 */
	public function __get( $name );

	/**
	 * Tests if the item property for the given name is available
	 *
	 * @param string $name Name of the property
	 * @return boolean True if the property exists, false if not
	 */
	public function __isset( $name );


	/**
	 * Sets the new item property for the given name
	 *
	 * @param string $name Name of the property
	 * @param mixed $value New property value
	 */
	public function __set( $name, $value );

	/**
	 * Returns the item property for the given name
	 *
	 * @param string $name Name of the property
	 * @param mixed $default Default value if property is unknown
	 * @return mixed|null Property value or default value if property is unknown
	 */
	public function get( $name, $default = null );

	/**
	 * Sets the new item property for the given name
	 *
	 * @param string $name Name of the property
	 * @param mixed $value New property value
	 * @return \Aimeos\MShop\Order\Item\Base\Iface Order base item for method chaining
	 */
	public function set( $name, $value );

	/**
	 * Returns the unique ID of the item.
	 *
	 * @return string|null ID of the item
	 */
	public function getId();

	/**
	 * Sets the unique ID of the item.
	 *
	 * @param string|null $id Unique ID of the item
	 * @return \Aimeos\MShop\Common\Item\Iface Item for chaining method calls
	 */
	public function setId( $id );

	/**
	 * Returns the ID of the site the item is stored
	 *
	 * @return string|null Site ID (or null if not available)
	 */
	public function getSiteId();

	/**
	 * Returns the create date of the item.
	 *
	 * @return string|null ISO date in YYYY-MM-DD hh:mm:ss format
	 */
	public function getTimeCreated();

	/**
	 * Returns the time of last modification.
	 *
	 * @return string|null ISO date in YYYY-MM-DD hh:mm:ss format
	 */
	public function getTimeModified();

	/**
	 * Returns the user code of user who created/modified the item at last.
	 *
	 * @return string|null User code of user who created/modified the item at last
	 */
	public function getEditor();

	/**
	 * Returns the item type
	 *
	 * @return string Item type, subtypes are separated by slashes
	 */
	public function getResourceType();

	/**
	 * Tests if the item is available based on status, time, language and currency
	 *
	 * @return boolean True if available, false if not
	 */
	public function isAvailable();

	/**
	 * Sets the general availability of the item
	 *
	 * @return boolean $value True if available, false if not
	 */
	public function setAvailable( $value );

	/**
	 * Tests if the item was modified.
	 *
	 * @return boolean True if modified, false if not
	 */
	public function isModified();

	/**
	 * Sets the item values from the given array and removes that entries from the list
	 *
	 * @param array $list Associative list of item keys and their values
	 * @param boolean True to set private properties too, false for public only
	 * @return \Aimeos\MShop\Common\Item\Iface Item for chaining method calls
	 */
	public function fromArray( array &$list, $private = false );

	/**
	 * Returns an associative list of item properties.
	 *
	 * @param boolean True to return private properties, false for public only
	 * @return array List of item properties
	 */
	public function toArray( $private = false );
}
