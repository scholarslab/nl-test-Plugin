<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=80; */

/**
 * @package     omeka
 * @subpackage  neatline-Plugin
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class ExhibitsControllerTest_Get extends NeatlinePlugin_Case_Default
{


    /**
     * GET should include expansion fields.
     */
    public function testGet()
    {

        $exhibit = $this->_exhibit();

        $exhibit->setArray(array(
            'field1' => 1,
            'field2' => 2,
            'field3' => 3
        ));

        $exhibit->save();

        $this->dispatch('neatline/exhibits/'.$exhibit->id);
        $response = $this->_getResponseArray();

        $this->assertEquals($exhibit->id, $response->id);
        $this->assertEquals(1, $response->field1);
        $this->assertEquals(2, $response->field2);
        $this->assertEquals(3, $response->field3);

    }


}
