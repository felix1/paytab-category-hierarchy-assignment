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
	 *  return
	 *
	 *
	 * @return view
	*/
	public function getSubCategories()
	{
		$category =  new CategoriesModel();
		$data['categories'] = $category->getCategoriesForLevel(0);
		echo view('templates/header', $data);
		echo view('categories/index');
		return view('templates/footer');
	}

	
	//--------------------------------------------------------------------

}
