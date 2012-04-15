<?php
/**
 * Adds weather checking functionality into the Magento shopping cart rules
 * @author Carey Sizer <careysizer@gmail.com>
 */
class Magex_Weather_Model_Rule_Condition_Address extends Mage_SalesRule_Model_Rule_Condition_Address
{
    /**
     * Add in the weather attribute options
     * @return Magex_Weather_Model_Rule_Condition_Address 
     */
    public function loadAttributeOptions()
    {
        parent::loadAttributeOptions();
        $oldAttributes = $this->getAttributeOption();
        $weatherAttributes = array(
            Magex_Weather_Model_Service::WEATHER => Mage::helper('salesrule')->__('Weather'),
            Magex_Weather_Model_Service::TEMPERATURE => Mage::helper('salesrule')->__('Temperature'),
        );
        $this->setAttributeOption(array_merge($oldAttributes, $weatherAttributes));
        return $this;
    }

    public function getInputType()
    {
        $inputType = parent::getInputType();
        switch ($this->getAttribute()) {
            case Magex_Weather_Model_Service::TEMPERATURE:
                $inputType = 'numeric';
                break;
            case Magex_Weather_Model_Service::WEATHER:
                $inputType = 'multiselect';
                break;
        }
        return $inputType;
        
    }
    
    /**
     * Get the select options
     * @return array
     */
    public function getValueSelectOptions()
    {
        $options = parent::getValueSelectOptions();
        switch ($this->getAttribute()) {
                	case Magex_Weather_Model_Service::WEATHER:
                    $options = Mage::getModel('weather/system_config_source_weather')
                        ->toOptionArray();
            }
            $this->setData('value_select_options', $options);
        return $this->getData('value_select_options');
    }
    
    /**
     * Add in weather and temperature options
     * @return string
     */
    public function getValueElementType()
    {
        $type = parent::getValueElementType();
        switch ($this->getAttribute()) {
            case Magex_Weather_Model_Service::WEATHER:
                $type = 'multiselect';
                break;
            case Magex_Weather_Model_Service::TEMPERATURE:
                $type = 'text';
                break;
        }
        return $type;
    }

    /**
     * Validate Address Rule Condition
     * Adds in the weather validation if needed
     *
     * @param Varien_Object $object
     * @return bool
     */
    public function validate(Varien_Object $object)
    {
        $address = $object;
        if (!$address instanceof Mage_Sales_Model_Quote_Address) {
            if ($object->getQuote()->isVirtual()) {
                $address = $object->getQuote()->getBillingAddress();
            }
            else {
                $address = $object->getQuote()->getShippingAddress();
            }
        }

       switch($this->getAttribute()) {
           case Magex_Weather_Model_Service::WEATHER:
               $address = Mage::getModel('weather/service')->loadData($address, $this->getAttribute());
               break;
           case Magex_Weather_Model_Service::TEMPERATURE:
               $address = Mage::getModel('weather/service')->loadData($address, $this->getAttribute());
               break;
       }
       $valid = parent::validate($address);
       return $valid;
    }
    
}