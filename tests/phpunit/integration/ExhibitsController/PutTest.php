<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline-Plugin
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class ExhibitsControllerTest_Put extends NeatlinePlugin_TestCase
{


    /**
     * PUT should update expansion fields.
     */
    public function testUpdateExhibit()
    {

        $exhibit = $this->__exhibit();

        $exhibit->setArray(array(

            'public'        => 0,
            'query'         => '1',
            'base_layers'   => '2',
            'base_layer'    => '3',
            'widgets'       => '4',
            'title'         => '5',
            'slug'          => '6',
            'description'   => '7',
            'styles'        => '8',
            'map_focus'     => '9',
            'map_zoom'      => 10,

            'field1'        => 11,
            'field2'        => 12,
            'field3'        => 13

        ));

        $exhibit->save();

        $this->writePut(array(

            'public'        => '1',
            'query'         => '2',
            'base_layers'   => '3',
            'base_layer'    => '4',
            'widgets'       => '5',
            'title'         => '6',
            'slug'          => '7',
            'description'   => '8',
            'styles'        => '9',
            'map_focus'     => '10',
            'map_zoom'      => '11',

            'field1'        => '12',
            'field2'        => '13',
            'field3'        => '14'

        ));

        $this->dispatch('neatline/exhibits/'.$exhibit->id);
        $exhibit = $this->reload($exhibit);

        $this->assertEquals($exhibit->public,       1);
        $this->assertEquals($exhibit->query,        '2');
        $this->assertEquals($exhibit->base_layers,  '3');
        $this->assertEquals($exhibit->base_layer,   '4');
        $this->assertEquals($exhibit->widgets,      '5');
        $this->assertEquals($exhibit->title,        '6');
        $this->assertEquals($exhibit->slug,         '7');
        $this->assertEquals($exhibit->description,  '8');
        $this->assertEquals($exhibit->styles,       '9');
        $this->assertEquals($exhibit->map_focus,    '10');
        $this->assertEquals($exhibit->map_zoom,     11);

        $this->assertEquals($exhibit->field1,       12);
        $this->assertEquals($exhibit->field2,       13);
        $this->assertEquals($exhibit->field3,       14);

    }


}
