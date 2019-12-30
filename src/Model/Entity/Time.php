<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Time Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $start_time
 * @property \Cake\I18n\FrozenTime $last_time
 *
 * @property \App\Model\Entity\Test[] $tests
 */
class Time extends Entity
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
        'session_id' => true,
        'name' => true,
        'start_time' => true,
        'last_time' => true,
        'test_day' => true,
        'tests' => true,
    ];
}
