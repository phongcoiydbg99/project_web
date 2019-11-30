<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Test Entity
 *
 * @property int $id
 * @property int $subject_id
 * @property int $test_room_id
 * @property \Cake\I18n\FrozenTime $start_time
 * @property \Cake\I18n\FrozenTime $last_time
 * @property int $computer_registered
 *
 * @property \App\Model\Entity\UsersTest[] $users_tests
 * @property \App\Model\Entity\Subject $subject
 * @property \App\Model\Entity\TestRoom $test_room
 * @property \App\Model\Entity\User[] $users
 */
class Test extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'subject_id' => true,
        'test_room_id' => true,
        'start_time' => true,
        'last_time' => true,
        'computer_registered' => true,
        'users_tests' => true,
        'subject' => true,
        'test_room' => true,
        'users' => true
    ];
}
