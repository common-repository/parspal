<?php
/**
 * Parspal
 *
 * Parspal getway class
 *
 * @copyright	(c) 2012 Mostafa Soufi
 * @author		Mostafa Soufi <mst404[at]gmail[dot]com>
 * @license		http://www.opensource.org/licenses/gpl-3.0.html
 * @version		1.0
 */
Class Parspal {
	/**
	 * Parspal Wsdl link
	 *
	 * @var string
	 */
	private $WSDL = "http://merchant.parspal.com/WebService.asmx?wsdl";

	/**
	 * Soap Client
	 */
	private $client;

	/**
	 * Parpal MerchantID
	 *
	 * @var integer
	 */
	public $MerchantID;

	/**
	 * Parspal getway password
	 *
	 * @var integer
	 */
	public $Password;

	/**
	 * Parspal price payment
	 *
	 * @var integer
	 */
	public $Price;

	/**
	 * Return URL in from Parspal
	 *
	 * @var string
	 */
	public $ReturnPath;

	/**
	 * Receipt Number
	 *
	 * @var integer
	 */
	public $ResNumber;

	/**
	 * Tracking Number
	 *
	 * @var integer
	 */
	public $RefNumber;

	/**
	 * Description for payment operations
	 *
	 * @var string
	 */
	public $Description;

	/**
	 * Payer name
	 *
	 * @var string
	 */
	public $Paymenter;

	/**
	 * Email payer
	 *
	 * @var string
	 */
	public $Email;

	/**
	 * Mobile payer
	 *
	 * @var integer
	 */
	public $Mobile;

	/**
	 * Payment price
	 *
	 * @var integer
	 */
	public $PayPrice;

	/**
	 * Constructors
	 */
	public function __construct() {
		$this->client = new SoapClient($this->WSDL);
	}

	/**
	 * Request for payment transactions
	 *
	 * @param  Not param
	 * @return Status request
	 */
	public function Request() {

		$res = $this->client->RequestPayment(array(
			"MerchantID" => $this->MerchantID,
			"Password" => $this->Password,
			"Price" => $this->Price,
			"ReturnPath" => $this->ReturnPath,
			"ResNumber" => $this->ResNumber,
			"Description" => $this->Description,
			"Paymenter" => $this->Paymenter,
			"Email" => $this->Email,
			"Mobile" => $this->Mobile
		));

		$PayPath = $res->RequestPaymentResult->PaymentPath;
		$Status = $res->RequestPaymentResult->ResultStatus;

		if($Status == 'Succeed') {
			//header("Location: $PayPath");
			echo "<meta http-equiv='Refresh' content='0;URL=$PayPath'>";
		} else {
			return $Status; 
		}

	}

	/**
	 * Verify Payment
	 *
	 * @param  Not param
	 * @return Status verify
	 */
	public function Verify() {

		if(isset($_POST['status']) && $_POST['status'] == 100) {

			$Status = $_POST['status'];
			$this->RefNumber = $_POST['refnumber'];
			$this->ResNumber = $_POST['resnumber'];

			$res = $this->client->VerifyPayment(array(
				"MerchantID" => $this->MerchantID,
				"Password" => $this->Password,
				"Price" => $this->Price,
				"RefNum" => $this->RefNumber
			));

			$Status = $res->verifyPaymentResult->ResultStatus;
			$this->PayPrice = $res->verifyPaymentResult->PayementedPrice;

			return $Status;

		}
	}
}