<?php 
namespace App\Models;

use CodeIgniter\Model;

/**
 * Class CategoriesModel
 *
 * The CategoriesModel class provides a number of convenient features that
 * makes working with a database table less painful.
 *
 * It will:
 *      - retrive All Categories as Levels
 *      - retrive First Level of Category
 */
class CategoriesModel extends Model{

    /**
	 * Name of database table
	 *
	 * @var string
	 */
    protected $table = 'categories_hierarchy';
    
    /**
	 * An array of field names that are allowed
	 * to be set by the user in inserts/updates.
	 *
	 * @var array
	 */
    protected $allowedFields = ['title', 'parent_id'];
    /**
	 *  return Categories for this level.
	 *
	 * @param integer $level
	 * - 0 main the main Categores
	 * @return array
	 */
    public function getCategoriesForLevel($level = 0){

        return  $this->select('id, title, parent_id')
                ->where('parent_id', $level)
                ->orderBy('id','asc')
                ->get()
                ->getResult();
    }
    /**
	 *  return categoriesTrees results of categories as Levels for select box.
	 *
	 * @param integer $limit
	 * @param integer $offset
	 *
	 * @return array
	 */
    public function categoriesTrees($level = 0){

        $rows = $this->getCategoriesForLevel($level);
        $category = [];
        // var_dump($rows);
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                // $category [] = $row;
                // Append subcategories
                $row->child = $this->categoriesTrees($row->id);
                $category [] = $row;
            }
        }
        return $category;
    }

     /**
	 *  return category with this title
	 *
	 * @param integer $title
	 *
	 * @return array
	 */
    public function findCategoryByTitle($title = false){
        if(!$title)
            return null;
        
        return $this->where(['title' => $title])->first();

    }
    
}