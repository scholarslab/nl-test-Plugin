<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline-Plugin
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class RecordsControllerTest_Get extends NeatlinePlugin_TestCase
{


    /**
     * GET should emit expansion fields.
     */
    public function testGet()
    {

        $exhibit    = $this->__exhibit();
        $item       = $this->__item();
        $record     = new NeatlineRecord($exhibit, $item);

        $record->setArray(array(
            'field4' => 1,
            'field5' => 2,
            'field6' => 3
        ));

        $record->save();

        $this->dispatch('neatline/records/'.$record->id);
        $response = $this->getResponseArray();

        $this->assertEquals($response->id, $record->id);
        $this->assertEquals($response->field4, 1);
        $this->assertEquals($response->field5, 2);
        $this->assertEquals($response->field6, 3);

    }


}
