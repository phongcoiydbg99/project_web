<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Times Model
 *
 * @property \App\Model\Table\TestsTable&\Cake\ORM\Association\HasMany $Tests
 *
 * @method \App\Model\Entity\Time get($primaryKey, $options = [])
 * @method \App\Model\Entity\Time newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Time[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Time|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Time saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Time patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Time[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Time findOrCreate($search, callable $callback = null, $options = [])
 */
class TimesTable extends Table
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

        $this->setTable('times');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Sessions', [
            'foreignKey' => 'session_id',
            'joinType' => 'INNER',
        ]);
        
        $this->hasMany('Tests', [
            'foreignKey' => 'time_id',
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
            ->date('test_day')
            ->requirePresence('test_day', 'create')
            ->notEmptyDate('test_day');
            
        $validator
            ->time('start_time','Không đúng định dạng thời gian')
            ->requirePresence('start_time', 'create')
            ->notEmptyTime('start_time');

        $validator
            ->time('last_time','Không đúng định dạng thời gian')
            ->requirePresence('last_time', 'create')
            ->notEmptyTime('last_time');

        return $validator;
    }
}
