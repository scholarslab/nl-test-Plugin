<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=80; */

/**
 * @package     omeka
 * @subpackage  neatline-Plugin
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class RecordsControllerTest_List extends NeatlinePlugin_Case_Default
{


    /**
     * Create exhibit, set parameter on request.
     */
    public function setUp()
    {

        parent::setUp();
        $this->_mockTheme();

        // Create exhibit.
        $this->exhibit = $this->_exhibit();

        // Set GET parameter.
        $this->request->setQuery(array(
          'exhibit_id' => $this->exhibit->id
        ));

    }


    /**
     * LIST should emit expansion fields.
     */
    public function testList()
    {

        $item1      = $this->_item();
        $item2      = $this->_item();
        $record1    = new NeatlineRecord($this->exhibit, $item1);
        $record2    = new NeatlineRecord($this->exhibit, $item2);

        $record1->setArray(array(
            'added'  => '2001-01-01',
            'field4' => 1,
            'field5' => 2,
            'field6' => 3
        ));

        $record2->setArray(array(
            'added'  => '2002-01-01',
            'field4' => 4,
            'field5' => 5,
            'field6' => 6
        ));

        $record1->save();
        $record2->save();

        $this->dispatch('neatline/records');
        $records = $this->_getResponseArray()['records'];

        // Record 2:
        $this->assertEquals($record2->id,   $records[0]['id']);
        $this->assertEquals(4,              $records[0]['field4']);
        $this->assertEquals(5,              $records[0]['field5']);
        $this->assertEquals(6,              $records[0]['field6']);

        // Record 1:
        $this->assertEquals($record1->id,   $records[1]['id']);
        $this->assertEquals(1,              $records[1]['field4']);
        $this->assertEquals(2,              $records[1]['field5']);
        $this->assertEquals(3,              $records[1]['field6']);

    }


}
