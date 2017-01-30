<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 30/01/2017
 * Time: 11:01
 */

namespace AppBundle\Utility;

use AppBundle\Utility\DB;

class DBTest extends \PHPUnit_Framework_TestCase
{
    private $db;

    protected function setUp()
    {
        $this->db = DB::getInstance();
    }

    public function testConnect()
    {
        $this->assertNotNull($this->db->connect());
    }
}
