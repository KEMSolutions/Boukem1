<?php

/**
 * CartForm class.
 * CartForm is the data structure for calculating shipping cost and taxes for a specified country, province and postalcode.
 * It is used by the 'index' action of 'CartController'.
 */
class CartForm extends CFormModel
{
	public $order_id;
	public $country;
	public $province;
	public $postcode;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('country, order_id', 'required'),
		);
	}

}