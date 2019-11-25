<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TestRoomsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TestRoomsTable Test Case
 */
class TestRoomsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TestRoomsTable
     */
    public $TestRooms;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TestRooms',
        'app.Tests'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TestRooms') ? [] : ['className' => TestRoomsTable::class];
        $this->TestRooms = TableRegistry::getTableLocator()->get('TestRooms', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TestRooms);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
