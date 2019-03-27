<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use Cake\ORM\TableRegistry;

use Cake\Datasource\ConnectionManager;
use DateTime;

/**
 * Books Model
 *
 * @property \App\Model\Table\AuthorsTable|\Cake\ORM\Association\BelongsTo $Authors
 *
 * @method \App\Model\Entity\Book get($primaryKey, $options = [])
 * @method \App\Model\Entity\Book newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Book[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Book|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Book|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Book patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Book[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Book findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BooksTable extends Table
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

        $this->setTable('books');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addAssociations([
           'belongsTo' => [
               'Authors' => ['foreignKey' => 'author_id'], 
               'Users' => ['foreignKey' => 'user_id', 'joinType' => 'INNER'] 
           ]
        ]);
    }
	
	public function beforeSave($event, $entity, $options)
	{
		
		if ($entity->author_name) {
			
			$query = $this->Authors->findByName($entity->author_name);
			foreach ($query as $row) {
				$entity->author_id = $row->id;
			}
			
			if(!$entity->author_id) {
				$connection = ConnectionManager::get('default');
				$connection->insert('authors', [
					'name' => $entity->author_name,
                    'user_id' => $_SESSION['Auth']['User']['id'],
					'created' => new DateTime('now'),
					'modified' => new DateTime('now') ] ,
				    ['created' => 'datetime', 'modified' => 'datetime']);
				$query = $this->Authors->findByName($entity->author_name);
				foreach ($query as $row) {
				$entity->author_id = $row->id;
				} 
			}
			
		}
		
		if ($entity->isNew() && !$entity->slug) {
			$sluggedTitle = Text::slug($entity->title);
			// trim slug to maximum length defined in schema
			$entity->slug = substr($sluggedTitle, 0, 190);
		}
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
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->allowEmptyString('title', false);
			
        $validator
            ->integer('published')
            ->add('published', 'custom', [
                'rule' => function ($value, $context) {
                    if ($value > 2019) {
                        return 'Published year could not be greater 2019';
                    }
                    return true;
                }
            ])
            ->allowEmptyString('published');


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
        $rules->add($rules->isUnique(['slug']));
        $rules->add($rules->existsIn(['author_id'], 'Authors'));

        return $rules;
    }
}
