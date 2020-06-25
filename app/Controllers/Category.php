<?php namespace App\Controllers;

use \App\Models\CategoriesModel;


class Category extends BaseController
{
	/**
	 *  return main view for Application with Base Categories
	 *
	 *
	 * @return view
	*/
	public function index()
	{
		$category =  new CategoriesModel();
		$data['categories'] = $category->getCategoriesForLevel(0);
		echo view('templates/header', $data);
		echo view('categories/index');
		return view('templates/footer');
	}

	/**
	 *  return the Subcategories for selected category
	 *
	 *@param $level the id of selected categery
	 * @return Json list with Subcategories
	*/
	public function getSubCategories($level)
	{
		$category =  new CategoriesModel();
		return  $this->response->setJSON($category->getCategoriesForLevel($level));
	}


	/**
	 *  return create view for Application with ALl Categories
	 *
	 *
	 * @return view
	*/
	public function create(){
		// init session 
		$session = \Config\Services::session();
		$category =  new CategoriesModel();
		$categories = $category->categoriesTrees();
		$data["categories"]= $this->createOptions($categories);
		echo view('templates/header', $data);
		echo view('categories/create');
		return view('templates/footer');
	}
	
	/**
	 *  return options as html for view by recursive 
	 *
	 *
	 * @return view
	*/
	public function createOptions($arrayCetogries, $prefix=''){
		$option = '';
		foreach ($arrayCetogries as $key => $category) {
			$option .= "<option value='$category->id'> $prefix $category->title</option>";
			$option .= $this->createOptions($category->child,  $prefix.'-');
		}
		return $option;
	}

	/**
	 *  Create new category Model
	 *
	 *
	 * @return view
	*/
	public function store(){
		// include form helper for validation
		helper('form');
		// check if is post request and the validations 
        if(isset($_POST) && $this->validate([
			'title' => 'required|max_length[255]|min_length[5]',
			'parent_id' => 'required|greater_than[0]'
        ])){// validation is true
			$title =  $this->request->getVar('title');
			$parent_id =  $this->request->getVar('parent_id');
			$model = new CategoriesModel();
			// check if there is an cat with the same category
			if(!empty($model->findCategoryByTitle($title)["title"])){
				return redirect()->back()->withInput()->with('error', 'Found  category with same title in DB');
			}
            $model->save([
                'title' => $title, 
                'parent_id' => $parent_id,
			]);
			return redirect()->route('/',)
			  ->with('success_post', 'Category Created Success');
        }else{
			$this->create();
        }
    }
	
	//--------------------------------------------------------------------

}
