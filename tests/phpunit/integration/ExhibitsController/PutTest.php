<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline-Plugin
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class ExhibitsControllerTest_Put extends NeatlinePlugin_Case_Default
{


    /**
     * PUT should update expansion fields.
     */
    public function testUpdateExhibit()
    {

        $exhibit = $this->_exhibit();

        $exhibit->setArray(array(
            'field1' => 1,
            'field2' => 2,
            'field3' => 3
        ));

        $exhibit->save();

        $this->_setPut(array(
            'field1' => '2',
            'field2' => '3',
            'field3' => '4'
        ));

        $this->dispatch('neatline/exhibits/'.$exhibit->id);
        $exhibit = $this->_reload($exhibit);

        $this->assertEquals($exhibit->field1, 2);
        $this->assertEquals($exhibit->field2, 3);
        $this->assertEquals($exhibit->field3, 4);

    }


}
