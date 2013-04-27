<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline-Plugin
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class ExpansionTest extends NeatlinePlugin_TestCase
{


    /**
     * Fields added by exhibit expansion tables should be settable and
     * accessible on exhibit objects.
     */
    public function testExhibitExpansion()
    {

        $exhibit = $this->__exhibit();

        $exhibit->field1 = 1;
        $exhibit->field2 = 2;
        $exhibit->field3 = 3;
        $exhibit->save();

        $exhibit = $this->reload($exhibit);

        $this->assertEquals($exhibit->field1, 1);
        $this->assertEquals($exhibit->field2, 2);
        $this->assertEquals($exhibit->field3, 3);

    }


    /**
     * Fields added by record expansion tables should be settable and
     * accessible on record objects.
     */
    public function testRecordExpansion()
    {

        $record = $this->__record();

        $record->field4 = 4;
        $record->field5 = 5;
        $record->field6 = 6;
        $record->save();

        $record = $this->reload($record);

        $this->assertEquals($record->field4, 4);
        $this->assertEquals($record->field5, 5);
        $this->assertEquals($record->field6, 6);

    }


}
