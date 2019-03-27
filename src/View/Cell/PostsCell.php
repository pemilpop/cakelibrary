<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Posts cell
 */
class PostsCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize()
    {
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
        $this->loadModel('Books');
        $total_posts = $this->Books->find()->count();
        $recent_posts = $this->Books->find()
                                    ->select('title')
                                    ->order(['created' => 'DESC'])
                                    ->limit(3)
                                    ->toArray();
 
        $this->set(['total_posts' => $total_posts, 'recent_posts' => $recent_posts]);
    }
}
