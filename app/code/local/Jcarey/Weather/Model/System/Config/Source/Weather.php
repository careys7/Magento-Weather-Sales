<?php
/**
 * Provides dropdown options for the rule builder in backend
 * @author Carey Sizer <careysizer@gmail.com>
 */
class Jcarey_Weather_Model_System_Config_Source_Weather
{
	/**
	 * The options for the dropdown
	 * @var array | null
	 */
    protected $_options;

    /**
     * Get the options for the dropdown
     * @param boolean $isMultiselect
     * @return array
     */
    public function toOptionArray($isMultiselect=false)
    {
        $this->_options = array(
            array('value'=>'Clear','label'=>'Clear'),
            array('value'=>'Cloudy','label'=>'Cloudy'),
            array('value'=>'Fog','label'=>'Fog'),
            array('value'=>'Haze','label'=>'Haze'),
            array('value'=>'Light Rain','label'=>'Light Rain'),
            array('value'=>'Mostly Cloudy','label'=>'Mostly Cloudy'),
            array('value'=>'Overcast','label'=>'Overcast'),
            array('value'=>'Partly Cloudy','label'=>'Partly Cloudy'),
            array('value'=>'Rain','label'=>'Rain'),
            array('value'=>'Rain Showers','label'=>'Rain Showers'),
            array('value'=>'Showers','label'=>'Showers'),
            array('value'=>'Thunderstorm','label'=>'Thunderstorm'),
            array('value'=>'Chance of Showers','label'=>'Chance of Showers'),
            array('value'=>'Chance of Snow','label'=>'Chance of Snow'),
            array('value'=>'Chance of Storm','label'=>'Chance of Storm'),
            array('value'=>'Mostly Sunny','label'=>'Mostly Sunny'),
            array('value'=>'Partly Sunny','label'=>'Partly Sunny'),
            array('value'=>'Scattered Showers','label'=>'Scattered Showers'),
            array('value'=>'Sunny','label'=>'Sunny')
            );

        return $this->_options;
    }
}