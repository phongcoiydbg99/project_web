<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\SubjectsTable&\Cake\ORM\Association\BelongsToMany $Subjects
 * @property \App\Model\Table\TestTimesTable&\Cake\ORM\Association\BelongsToMany $TestTimes
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        
        $this->belongsToMany('Subjects', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'subject_id',
            'joinTable' => 'users_subjects'
        ]);
        
        $this->belongsToMany('Tests', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'test_id',
            'joinTable' => 'users_tests'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationLogin(Validator $validator)
    {
        $validator
            ->allowEmptyString('id', null, 'create');

        $validator
            ->notEmptyString('username','Bạn chưa điền đầy đủ thông tin');

        $validator
            ->notEmptyString('password','Bạn chưa điền đầy đủ thông tin');

        return $validator;
    }
    public function validationAdd(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('username')
            ->requirePresence('username', 'create')
            ->notEmptyString('username','Bạn chưa điền đầy đủ thông tin')
            ->add('username','vaildFormat',['rule' => array('custom', '/^[a-zA-Z0-9_-]{3,16}$/'),
                'message' => 'Tên đăng nhập phải có 3-16 ký tự,không chứa ký tự đặc biệt']);

        $validator
            ->scalar('password')
            ->maxLength('password', 60)
            ->requirePresence('password', 'create')
            ->notEmptyString('password','Bạn chưa điền đầy đủ thông tin') 
            ->add('password','vaildFormat',['rule' => array('custom', '/^[a-zA-Z0-9_-]{6,18}$/'),
                'message' => 'Mật khẩu phải từ 6-18 ký tự, không chứa ký tự đặc biệt']);

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 100)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name','Bạn chưa điền đầy đủ thông tin');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 100)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name','Bạn chưa điền đầy đủ thông tin');

        $validator
            ->date('date_birth')
            ->requirePresence('date_birth', 'create')
            ->notEmptyDate('date_birth','Bạn chưa điền đầy đủ thông tin');

        $validator
            ->scalar('class')
            ->maxLength('class', 60)
            ->requirePresence('class', 'create')
            ->notEmptyString('class','Bạn chưa điền đầy đủ thông tin');

        return $validator;
    }

    public function validationProfile(Validator $validator)
    {

        $validator
            ->scalar('username')
            ->requirePresence('username', 'create')
            ->notEmptyString('username','Bạn chưa điền đầy đủ thông tin')
            ->add('username','vaildFormat',['rule' => array('custom', '/^[a-zA-Z0-9_-]{3,16}$/'),
                'message' => 'Tên đăng nhập phải có 3-16 ký tự,không chứa ký tự đặc biệt']);

        $validator
            ->scalar('password')
            ->maxLength('password', 60)
            ->requirePresence('password', 'create')
            ->notEmptyString('password','Bạn chưa điền đầy đủ thông tin') 
            ->add('password','vaildFormat',['rule' => array('custom', '/^[a-zA-Z0-9_-]{6,18}$/'),
                'message' => 'Mật khẩu phải từ 6-18 ký tự, không chứa ký tự đặc biệt']);

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 100)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name','Bạn chưa điền đầy đủ thông tin');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 100)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name','Bạn chưa điền đầy đủ thông tin');

        $validator
            ->date('date_birth')
            ->requirePresence('date_birth', 'create')
            ->notEmptyDate('date_birth','Bạn chưa điền đầy đủ thông tin');

        $validator
            ->scalar('class')
            ->maxLength('class', 60)
            ->requirePresence('class', 'create')
            ->notEmptyString('class','Bạn chưa điền đầy đủ thông tin');

        $validator
            ->email('email')
            ->notEmptyString('email','Bạn chưa điền đầy đủ thông tin')
            ->add('email','vaildFormat',['rule' => array('custom', '/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/'),
                'message' => 'Định dạng email chưa đúng']);
        return $validator;
    }

    public function validationFirstLogin(Validator $validator){
        $validator
            ->scalar('password')
            ->notEmptyString('password','Bạn chưa điền đầy đủ thông tin')
            ->add('password','vaildFormat',['rule' => array('custom', '/^[a-zA-Z0-9_-]{6,18}$/'),
                'message' => 'Mật khẩu phải từ 6-18 ký tự, không chứa ký tự đặc biệt']);
        $validator
            ->email('email')
            ->notEmptyString('email','Bạn chưa điền đầy đủ thông tin')
            ->add('email','vaildFormat',['rule' => array('custom', '/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/'),
                'message' => 'Định dạng email chưa đúng']);
        return $validator;
    }

    public function validationChangePassword(Validator $validator){
        $validator
            ->scalar('password')
            ->notEmptyString('password','Bạn chưa điền đầy đủ thông tin')
            ->add('password','vaildFormat',['rule' => array('custom', '/^[a-zA-Z0-9_-]{6,18}$/'),
                'message' => 'Mật khẩu phải từ 6-18 ký tự, không chứa ký tự đặc biệt']);
        $validator
            ->scalar('password1')
            ->notEmptyString('password1','Bạn chưa điền đầy đủ thông tin')
            ->add('password1','vaildFormat',['rule' => array('custom', '/^[a-zA-Z0-9_-]{6,18}$/'),
                'message' => 'Mật khẩu phải từ 6-18 ký tự, không chứa ký tự đặc biệt']);
        $validator
            ->scalar('password2')
            ->notEmptyString('password2','Bạn chưa điền đầy đủ thông tin')
            ->add('password2','vaildFormat',['rule' => array('custom', '/^[a-zA-Z0-9_-]{6,18}$/'),
                'message' => 'Mật khẩu phải từ 6-18 ký tự, không chứa ký tự đặc biệt']);
        return $validator;
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('username')
            ->maxLength('username', 60)
            ->requirePresence('username', 'create')
            ->notEmptyString('username','Bạn chưa điền đầy đủ thông tin');
            
        $validator
            ->scalar('password')
            ->maxLength('password', 60)
            ->requirePresence('password', 'create')
            ->notEmptyString('password','Bạn chưa điền đầy đủ thông tin');
            

        $validator
            ->scalar('role')
            ->maxLength('role', 10)
            ->requirePresence('role', 'create')
            ->notEmptyString('role','Bạn chưa điền đầy đủ thông tin');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 100)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name','Bạn chưa điền đầy đủ thông tin');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 100)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name','Bạn chưa điền đầy đủ thông tin');

        $validator
            ->date('date_birth')
            ->requirePresence('date_birth', 'create')
            ->notEmptyDate('date_birth','Bạn chưa điền đầy đủ thông tin');

        $validator
            ->scalar('class')
            ->maxLength('class', 60)
            ->requirePresence('class', 'create')
            ->notEmptyString('class','Bạn chưa điền đầy đủ thông tin');

        $validator
            ->email('email')
            ->maxLength('email', 60)
            ->requirePresence('email', 'create')
            ->notEmptyString('email','Bạn chưa điền đầy đủ thông tin');

        $validator
            ->scalar('token')
            ->maxLength('token', 100)
            ->allowEmptyString('token','Bạn chưa điền đầy đủ thông tin');

        return $validator;
    }

    
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username'],'Tên đăng nhập đã có người sử dụng'));
        $rules->add($rules->isUnique(['email'],'Email đã có người sử dụng'));

        return $rules;
    }
}
