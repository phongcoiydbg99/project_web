<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TestRooms Model
 *
 * @property \App\Model\Table\TestsTable&\Cake\ORM\Association\HasMany $Tests
 *
 * @method \App\Model\Entity\TestRoom get($primaryKey, $options = [])
 * @method \App\Model\Entity\TestRoom newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TestRoom[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TestRoom|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TestRoom saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TestRoom patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TestRoom[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TestRoom findOrCreate($search, callable $callback = null, $options = [])
 */
class TestRoomsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('test_rooms');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Tests', [
            'foreignKey' => 'test_room_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 60)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('total_computer')
            ->requirePresence('total_computer', 'create')
            ->notEmptyString('total_computer');

        return $validator;
    }
}
