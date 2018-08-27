<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Model_product_test extends TestCase
{
    public function setUp()
    {
        $this->obj = $this->newModel('Model_product');
    }

    public function test_get_category_list()
    {
        $expected = [
            1 => 'Book',
            2 => 'CD',
            3 => 'DVD',
        ];
        $list = $this->obj->get_category_list();
        foreach ($list as $category) {
            $this->assertEquals($expected[$category->id], $category->name);
        }
    }

    public function test_get_category_name()
    {
        $actual = $this->obj->get_category_name(1);
        $expected = 'Book';
        $this->assertEquals($expected, $actual);
    }
}