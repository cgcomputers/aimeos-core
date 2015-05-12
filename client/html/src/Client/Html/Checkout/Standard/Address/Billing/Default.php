<?php

/**
 * @copyright Copyright (c) Metaways Infosystems GmbH, 2013
 * @license LGPLv3, http://www.arcavias.com/en/license
 * @package Client
 * @subpackage Html
 */


/**
 * Default implementation of checkout billing address HTML client.
 *
 * @package Client
 * @subpackage Html
 */
class Client_Html_Checkout_Standard_Address_Billing_Default
	extends Client_Html_Abstract
{
	/** client/html/checkout/standard/address/billing/default/subparts
	 * List of HTML sub-clients rendered within the checkout standard address billing section
	 *
	 * The output of the frontend is composed of the code generated by the HTML
	 * clients. Each HTML client can consist of serveral (or none) sub-clients
	 * that are responsible for rendering certain sub-parts of the output. The
	 * sub-clients can contain HTML clients themselves and therefore a
	 * hierarchical tree of HTML clients is composed. Each HTML client creates
	 * the output that is placed inside the container of its parent.
	 *
	 * At first, always the HTML code generated by the parent is printed, then
	 * the HTML code of its sub-clients. The order of the HTML sub-clients
	 * determines the order of the output of these sub-clients inside the parent
	 * container. If the configured list of clients is
	 *
	 *  array( "subclient1", "subclient2" )
	 *
	 * you can easily change the order of the output by reordering the subparts:
	 *
	 *  client/html/<clients>/subparts = array( "subclient1", "subclient2" )
	 *
	 * You can also remove one or more parts if they shouldn't be rendered:
	 *
	 *  client/html/<clients>/subparts = array( "subclient1" )
	 *
	 * As the clients only generates structural HTML, the layout defined via CSS
	 * should support adding, removing or reordering content by a fluid like
	 * design.
	 *
	 * @param array List of sub-client names
	 * @since 2014.03
	 * @category Developer
	 */
	private $_subPartPath = 'client/html/checkout/standard/address/billing/default/subparts';
	private $_subPartNames = array();
	private $_cache;

	private $_mandatory = array(
		'order.base.address.salutation',
		'order.base.address.firstname',
		'order.base.address.lastname',
		'order.base.address.address1',
		'order.base.address.postal',
		'order.base.address.city',
		'order.base.address.languageid',
		'order.base.address.email'
	);

	private $_optional = array(
		'order.base.address.company',
		'order.base.address.vatid',
		'order.base.address.address2',
		'order.base.address.countryid',
		'order.base.address.state',
	);


	/**
	 * Returns the HTML code for insertion into the body.
	 *
	 * @param string $uid Unique identifier for the output if the content is placed more than once on the same page
	 * @param array &$tags Result array for the list of tags that are associated to the output
	 * @param string|null &$expire Result variable for the expiration date of the output (null for no expiry)
	 * @return string HTML code
	 */
	public function getBody( $uid = '', array &$tags = array(), &$expire = null )
	{
		$view = $this->_setViewParams( $this->getView(), $tags, $expire );

		$html = '';
		foreach( $this->_getSubClients() as $subclient ) {
			$html .= $subclient->setView( $view )->getBody( $uid, $tags, $expire );
		}
		$view->billingBody = $html;

		/** client/html/checkout/standard/address/billing/default/template-body
		 * Relative path to the HTML body template of the checkout standard address billing client.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the result shown in the body of the frontend. The
		 * configuration string is the path to the template file relative
		 * to the layouts directory (usually in client/html/layouts).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "default" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "default"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating code for the HTML page body
		 * @since 2014.03
		 * @category Developer
		 * @see client/html/checkout/standard/address/billing/default/template-header
		 */
		$tplconf = 'client/html/checkout/standard/address/billing/default/template-body';
		$default = 'checkout/standard/address-billing-body-default.html';

		return $view->render( $this->_getTemplate( $tplconf, $default ) );
	}


	/**
	 * Returns the HTML string for insertion into the header.
	 *
	 * @param string $uid Unique identifier for the output if the content is placed more than once on the same page
	 * @param array &$tags Result array for the list of tags that are associated to the output
	 * @param string|null &$expire Result variable for the expiration date of the output (null for no expiry)
	 * @return string String including HTML tags for the header
	 */
	public function getHeader( $uid = '', array &$tags = array(), &$expire = null )
	{
		$view = $this->_setViewParams( $this->getView(), $tags, $expire );

		$html = '';
		foreach( $this->_getSubClients() as $subclient ) {
			$html .= $subclient->setView( $view )->getHeader( $uid, $tags, $expire );
		}
		$view->billingHeader = $html;

		/** client/html/checkout/standard/address/billing/default/template-header
		 * Relative path to the HTML header template of the checkout standard address billing client.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the HTML code that is inserted into the HTML page header
		 * of the rendered page in the frontend. The configuration string is the
		 * path to the template file relative to the layouts directory (usually
		 * in client/html/layouts).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "default" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "default"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating code for the HTML page head
		 * @since 2014.03
		 * @category Developer
		 * @see client/html/checkout/standard/address/billing/default/template-body
		 */
		$tplconf = 'client/html/checkout/standard/address/billing/default/template-header';
		$default = 'checkout/standard/address-billing-header-default.html';

		return $view->render( $this->_getTemplate( $tplconf, $default ) );
	}


	/**
	 * Returns the sub-client given by its name.
	 *
	 * @param string $type Name of the client type
	 * @param string|null $name Name of the sub-client (Default if null)
	 * @return Client_Html_Interface Sub-client object
	 */
	public function getSubClient( $type, $name = null )
	{
		return $this->_createSubClient( 'checkout/standard/address/billing/' . $type, $name );
	}


	/**
	 * Stores the given or fetched billing address in the basket.
	 */
	public function process()
	{
		$view = $this->getView();

		try
		{
			// only start if there's something to do
			if( $view->param( 'ca_billingoption', null ) === null ) {
				return;
			}

			$context = $this->_getContext();
			$basketCtrl = Controller_Frontend_Factory::createController( $context, 'basket' );


			/** client/html/checkout/standard/address/billing/disable-new
			 * Disables the option to enter a new billing address for an order
			 *
			 * Besides the main billing address, customers can usually enter a new
			 * billing address as well. To suppress displaying the form fields for
			 * a billing address, you can set this configuration option to "1".
			 *
			 * Until 2015-02, the configuration option was available as
			 * "client/html/common/address/billing/disable-new" starting from 2014-03.
			 *
			 * @param boolean A value of "1" to disable, "0" enables the billing address form
			 * @since 2015.02
			 * @category User
			 * @category Developer
			 * @see client/html/checkout/standard/address/billing/salutations
			 * @see client/html/checkout/standard/address/billing/mandatory
			 * @see client/html/checkout/standard/address/billing/optional
			 * @see client/html/checkout/standard/address/billing/hidden
			 */
			$disable = $view->config( 'client/html/checkout/standard/address/billing/disable-new', false );
			$type = MShop_Order_Item_Base_Address_Abstract::TYPE_PAYMENT;

			if( ( $option = $view->param( 'ca_billingoption', 'null' ) ) === 'null' && $disable === false ) // new address
			{
				$params = $view->param( 'ca_billing', array() );
				$invalid = $this->_checkFields( $params );

				if( count( $invalid ) > 0 )
				{
					$view->billingError = $invalid;
					throw new Client_Html_Exception( sprintf( 'At least one billing address part is missing or invalid' ) );
				}

				$basketCtrl->setAddress( $type, $params );
			}
			else // existing address
			{
				$customerManager = MShop_Factory::createManager( $context, 'customer' );

				$search = $customerManager->createSearch( true );
				$expr = array(
					$search->compare( '==', 'customer.id', $option ),
					$search->getConditions(),
				);
				$search->setConditions( $search->combine( '&&', $expr ) );

				$items = $customerManager->searchItems( $search );

				if( ( $item = reset( $items ) ) === false || $option != $context->getUserId() ) {
					throw new Client_Html_Exception( sprintf( 'Customer with ID "%1$s" not found', $option ) );
				}

				$invalid = array();
				$addr = $item->getPaymentAddress();
				$params = $view->param( 'ca_billing_' . $option, array() );

				if( !empty( $params ) )
				{
					$list = array();
					$invalid = $this->_checkFields( $params );

					foreach( $params as $key => $value ) {
						$list[ str_replace( 'order.base', 'customer', $key ) ] = $value;
					}

					$addr->fromArray( $list );
					$item->setPaymentAddress( $addr );

					$customerManager->saveItem( $item );
				}

				if( count( $invalid ) > 0 )
				{
					$view->billingError = $invalid;
					throw new Client_Html_Exception( sprintf( 'At least one billing address part is missing or invalid' ) );
				}

				$basketCtrl->setAddress( $type, $addr );
			}

			parent::process();
		}
		catch( Controller_Frontend_Exception $e )
		{
			$view->billingError = $e->getErrorList();
			throw $e;
		}
	}


	/**
	 * Checks the address fields for missing data and sanitizes the given parameter list.
	 *
	 * @param array &$params Associative list of address keys (order.base.address.* or customer.address.*) and their values
	 * @return array List of missing field names
	 */
	protected function _checkFields( array &$params )
	{
		$view = $this->getView();

		/** client/html/checkout/standard/address/billing/mandatory
		 * List of billing address input fields that are required
		 *
		 * You can configure the list of billing address fields that are
		 * necessary and must be filled by the customer before he can
		 * continue the checkout process. Available field keys are:
		 * * order.base.address.company
		 * * order.base.address.vatid
		 * * order.base.address.salutation
		 * * order.base.address.firstname
		 * * order.base.address.lastname
		 * * order.base.address.address1
		 * * order.base.address.address2
		 * * order.base.address.address3
		 * * order.base.address.postal
		 * * order.base.address.city
		 * * order.base.address.state
		 * * order.base.address.languageid
		 * * order.base.address.countryid
		 * * order.base.address.telephone
		 * * order.base.address.telefax
		 * * order.base.address.email
		 * * order.base.address.website
		 *
		 * Until 2015-02, the configuration option was available as
		 * "client/html/common/address/billing/mandatory" starting from 2014-03.
		 *
		 * @param array List of field keys
		 * @since 2015.02
		 * @category User
		 * @category Developer
		 * @see client/html/checkout/standard/address/billing/disable-new
		 * @see client/html/checkout/standard/address/billing/salutations
		 * @see client/html/checkout/standard/address/billing/optional
		 * @see client/html/checkout/standard/address/billing/hidden
		 * @see client/html/checkout/standard/address/countries
		 * @see client/html/checkout/standard/address/validate
		 */
		$mandatory = $view->config( 'client/html/checkout/standard/address/billing/mandatory', $this->_mandatory );

		/** client/html/checkout/standard/address/billing/optional
		 * List of billing address input fields that are optional
		 *
		 * You can configure the list of billing address fields that
		 * customers can fill but don't have to before they can
		 * continue the checkout process. Available field keys are:
		 * * order.base.address.company
		 * * order.base.address.vatid
		 * * order.base.address.salutation
		 * * order.base.address.firstname
		 * * order.base.address.lastname
		 * * order.base.address.address1
		 * * order.base.address.address2
		 * * order.base.address.address3
		 * * order.base.address.postal
		 * * order.base.address.city
		 * * order.base.address.state
		 * * order.base.address.languageid
		 * * order.base.address.countryid
		 * * order.base.address.telephone
		 * * order.base.address.telefax
		 * * order.base.address.email
		 * * order.base.address.website
		 *
		 * Until 2015-02, the configuration option was available as
		 * "client/html/common/address/billing/optional" starting from 2014-03.
		 *
		 * @param array List of field keys
		 * @since 2015.02
		 * @category User
		 * @category Developer
		 * @see client/html/checkout/standard/address/billing/disable-new
		 * @see client/html/checkout/standard/address/billing/salutations
		 * @see client/html/checkout/standard/address/billing/mandatory
		 * @see client/html/checkout/standard/address/billing/hidden
		 * @see client/html/checkout/standard/address/countries
		 * @see client/html/checkout/standard/address/validate
		 */
		$optional = $view->config( 'client/html/checkout/standard/address/billing/optional', $this->_optional );

		/** client/html/checkout/standard/address/validate
		 * List of regular expressions to validate the data of the address fields
		 *
		 * To validate the address input data of the customer, an individual
		 * {@link http://php.net/manual/en/pcre.pattern.php Perl compatible regular expression}
		 * can be applied to each field. Available fields are:
		 * * company
		 * * vatid
		 * * salutation
		 * * firstname
		 * * lastname
		 * * address1
		 * * address2
		 * * address3
		 * * postal
		 * * city
		 * * state
		 * * languageid
		 * * countryid
		 * * telephone
		 * * telefax
		 * * email
		 * * website
		 *
		 * Some fields are validated automatically because they are not
		 * dependent on a country specific rule. These fields are:
		 * * salutation
		 * * email
		 * * website
		 *
		 * To validate e.g the postal/zip code, you can define a regular
		 * expression like this if you want to allow only digits:
		 *
		 *  client/html/checkout/standard/address/validate/postal = '^[0-9]+$'
		 *
		 * Several regular expressions can be defined line this:
		 *
		 *  client/html/checkout/standard/address/validate = array(
		 *      'postal' = '^[0-9]+$',
		 *      'vatid' = '^[A-Z]{2}[0-9]{8}$',
		 *  )
		 *
		 * Don't add any delimiting characters like slashes (/) to the beginning
		 * or the end of the regular expression. They will be added automatically.
		 * Any slashes inside the expression must be escaped by backlashes,
		 * i.e. "\/".
		 *
		 * Until 2015-02, the configuration option was available as
		 * "client/html/common/address/billing/validate" starting from 2014-09.
		 *
		 * @param array Associative list of field names and regular expressions
		 * @since 2014.09
		 * @category Developer
		 * @see client/html/checkout/standard/address/billing/mandatory
		 * @see client/html/checkout/standard/address/billing/optional
		 */
		$regex = $view->config( 'client/html/checkout/standard/address/validate', array() );

		$invalid = array();
		$allFields = array_flip( array_merge( $mandatory, $optional ) );

		foreach( $params as $key => $value )
		{
			if( isset( $allFields[$key] ) )
			{
				$name = substr( $key, 19 );

				if( isset( $regex[$name] ) && preg_match( '/'.$regex[$name].'/', $value ) !== 1 )
				{
					$msg = $view->translate( 'client/html', 'Billing address part "%1$s" is invalid' );
					$invalid[$key] = sprintf( $msg, $name );
					unset( $params[$key] );
				}
			}
			else
			{
				unset( $params[$key] );
			}
		}


		if( isset( $params['order.base.address.salutation'] )
			&& $params['order.base.address.salutation'] === MShop_Common_Item_Address_Abstract::SALUTATION_COMPANY
			&& in_array( 'order.base.address.company', $mandatory ) === false
		) {
			$mandatory[] = 'order.base.address.company';
		} else {
			$params['order.base.address.company'] = $params['order.base.address.vatid'] = '';
		}

		foreach( $mandatory as $key )
		{
			if( !isset( $params[$key] ) || $params[$key] == '' )
			{
				$msg = $view->translate( 'client/html', 'Billing address part "%1$s" is missing' );
				$invalid[$key] = sprintf( $msg, substr( $key, 19 ) );
				unset( $params[$key] );
			}
		}

		return $invalid;
	}


	/**
	 * Returns the list of sub-client names configured for the client.
	 *
	 * @return array List of HTML client names
	 */
	protected function _getSubClientNames()
	{
		return $this->_getContext()->getConfig()->get( $this->_subPartPath, $this->_subPartNames );
	}


	/**
	 * Sets the necessary parameter values in the view.
	 *
	 * @param MW_View_Interface $view The view object which generates the HTML output
	 * @param array &$tags Result array for the list of tags that are associated to the output
	 * @param string|null &$expire Result variable for the expiration date of the output (null for no expiry)
	 * @return MW_View_Interface Modified view object
	 */
	protected function _setViewParams( MW_View_Interface $view, array &$tags = array(), &$expire = null )
	{
		if( !isset( $this->_cache ) )
		{
			$context = $this->_getContext();
			$basketCntl = Controller_Frontend_Factory::createController( $context, 'basket' );

			try {
				$langid = $basketCntl->get()->getAddress( 'payment' )->getLanguageId();
			} catch( Exception $e ) {
				$langid = $view->param( 'ca_billing/order.base.address.languageid', $context->getLocale()->getLanguageId() );
			}
			$view->billingLanguage = $langid;

			/** client/html/checkout/standard/address/billing/hidden
			 * List of billing address input fields that are optional and should be hidden
			 *
			 * You can configure the list of billing address fields that
			 * are hidden when a customer enters his new billing address.
			 * Available field keys are:
			 * * order.base.address.company
			 * * order.base.address.vatid
			 * * order.base.address.salutation
			 * * order.base.address.firstname
			 * * order.base.address.lastname
			 * * order.base.address.address1
			 * * order.base.address.address2
			 * * order.base.address.address3
			 * * order.base.address.postal
			 * * order.base.address.city
			 * * order.base.address.state
			 * * order.base.address.languageid
			 * * order.base.address.countryid
			 * * order.base.address.telephone
			 * * order.base.address.telefax
			 * * order.base.address.email
			 * * order.base.address.website
			 *
			 * Caution: Only hide fields that don't require any input
			 *
			 * Until 2015-02, the configuration option was available as
			 * "client/html/common/address/billing/hidden" starting from 2014-03.
			 *
			 * @param array List of field keys
			 * @since 2015.02
			 * @category User
			 * @category Developer
			 * @see client/html/checkout/standard/address/billing/disable-new
			 * @see client/html/checkout/standard/address/billing/salutations
			 * @see client/html/checkout/standard/address/billing/mandatory
			 * @see client/html/checkout/standard/address/billing/optional
			 * @see client/html/checkout/standard/address/countries
			 */
			$hidden = $view->config( 'client/html/checkout/standard/address/billing/hidden', array() );

			if( count( $view->get( 'addressLanguages', array() ) ) === 1 ) {
				$hidden[] = 'order.base.address.languageid';
			}

			$salutations = array( 'company', 'mr', 'mrs' );

			/** client/html/checkout/standard/address/billing/salutations
			 * List of salutions the customer can select from for the billing address
			 *
			 * The following salutations are available:
			 * * empty string for "unknown"
			 * * company
			 * * mr
			 * * mrs
			 * * miss
			 *
			 * You can modify the list of salutation codes and remove the ones
			 * which shouldn't be used. Adding new salutations is a little bit
			 * more difficult because you have to adapt a few areas in the source
			 * code.
			 *
			 * Until 2015-02, the configuration option was available as
			 * "client/html/common/address/billing/salutations" starting from 2014-03.
			 *
			 * @param array List of available salutation codes
			 * @since 2015.02
			 * @category User
			 * @category Developer
			 * @see client/html/checkout/standard/address/billing/disable-new
			 * @see client/html/checkout/standard/address/billing/mandatory
			 * @see client/html/checkout/standard/address/billing/optional
			 * @see client/html/checkout/standard/address/billing/hidden
			 * @see client/html/checkout/standard/address/countries
			 */
			$view->billingSalutations = $view->config( 'client/html/checkout/standard/address/billing/salutations', $salutations );

			$view->billingMandatory = $view->config( 'client/html/checkout/standard/address/billing/mandatory', $this->_mandatory );
			$view->billingOptional = $view->config( 'client/html/checkout/standard/address/billing/optional', $this->_optional );
			$view->billingHidden = $hidden;

			$this->_cache = $view;
		}

		return $this->_cache;
	}
}