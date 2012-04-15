<?php
/**
 * The weather service
 * @author Carey Sizer <careysizer@gmail.com>
 */
class Magex_Weather_Model_Service extends Varien_Object
{
	/**
	 * Constant for temperature
	 * @var string
	 */
	const TEMPERATURE = 'temperature';
	
	/**
	 * Constant for weather
	 * @var string 
	 */
	const WEATHER = 'weather';
	
	/**
	 * XML Path to the config option for celcius
	 * @var string
	 */
	const XML_PATH_USE_CELCIUS = 'magex_weather/settings/use_celcius';

	/**
	 * Load the weather data into the address
	 * @param Mage_Customer_Model_Address $address
	 * @param type $attribute
	 * @return Mage_Customer_Model_Address
	 */
	public function loadData(Mage_Sales_Model_Quote_Address $address, $attribute)
	{
		switch($attribute) {
			case self::WEATHER:
				$data = $this->_getWeather($address);
				break;
			case self::TEMPERATURE:
				$data = $this->_getTemperature($address);
				break;
		}
		$address->setData($attribute, $data);
		return $address;
	}

	/**
	 * Get the weather contitions for the current customer
	 * @param Mage_Sales_Model_Quote_Address $address
	 * @return string | boolean
	 */
	protected function _getWeather(Mage_Sales_Model_Quote_Address $address)
	{
		$forecast = false;
		if($this->_getQueryString($address)) {
			try {
				$xml = simplexml_load_file('http://www.google.com/ig/api?weather=' . $this->_getQueryString($address));
				$forecast = (string) $xml->weather->current_conditions->condition['data'];
			} catch(Exception $ex) {

			}
		}
		return $forecast;
	}

	/**
	 * Get the temperature for the current customer
	 * @param Mage_Sales_Model_Quote_Address $address
	 * @return int | boolean if error
	 */
	protected function _getTemperature(Mage_Sales_Model_Quote_Address $address)
	{
		$temp = false;
		if($this->_getQueryString($address)) {
			try {
				$xml = simplexml_load_file('http://www.google.com/ig/api?weather=' . $this->_getQueryString($address));
				if($this->_useCelcius()) {
					$temp = (int) $xml->weather->current_conditions->temp_c['data'];
				} else {
					$temp = (int) $xml->weather->current_conditions->temp_f['data'];
				}
			} catch(Exception $ex) {

			}
		}
		return $temp;
	}

	/**
	 * Generate the string needed by the API based on the address
	 * @param Mage_Sales_Model_Quote_Address $address
	 * @return string
	 */
	protected function _getQueryString(Mage_Sales_Model_Quote_Address $address)
	{
		$address = $address->exportCustomerAddress();
		$fields = array(
            'region', 'postcode', 'country'
            );
            $string = "";
            foreach($fields as $field) {
            	if($address->getData($field)) {
            		$string .= $address->getData($field) . "+";
            	}
            }
            $string = trim($string, "+");
            return $string;
	}

	/**
	 * Check if celcius has been selected as unit to use
	 * @return boolean
	 */
	protected function _useCelcius()
	{
		return Mage::getStoreConfig(self::XML_PATH_USE_CELCIUS);
	}

}