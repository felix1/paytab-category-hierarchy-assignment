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
		$category =  new CategoriesModel();
		$data['categories'] = $category->categoriesTrees(0);
		echo view('templates/header', $data);
		echo view('categories/create');
		return view('templates/footer');
	}

	public function store(){
		$session = \Config\Services::session();
        helper('form');
        if(isset($_POST) && $this->validate([
            'body' => 'required',
            'title' => 'required|max_length[255]|min_length[5]'
        ])){
			$title =  $this->request->getVar('title');
			$slug =  url_title($title, '-', true);
			$model = new PostsModel();
			if(!empty($model->get($slug)["title"])){
				// $session->setFlashdata('error', 'Found Same Title In DB');
				// echo view('templates/header');
			    // echo view('posts/create');
				// echo view('templates/footer');
				// return false;
				return redirect()->back()->withInput()->with('error', 'Found Same Title In DB');
			}
            $model->save([
                'title' => $this->request->getVar('title'), 
                'body' => $this->request->getVar('body'),
                'slug' => url_title($this->request->getVar('title'), '-', true)
			]);
			return redirect()->route('show_post',
			  [ url_title($this->request->getVar('title'), '-', true)])
			  ->with('success_post', 'Post Created Success');
        }else{
			echo view('templates/header');
			echo view('posts/create');
			echo view('templates/footer');
        }
    }
	
	//--------------------------------------------------------------------

}
