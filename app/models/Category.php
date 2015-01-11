<?php

class Category extends Eloquent{

	protected $table 		= 'categories';
	protected $primaryKey 	= 'id';
	protected $hidden 		= array(
									'created_at'
									,'updated_at'
								);

	public function getCategories(){
		$category_list = Category::selectRaw('id,name')
						->where('is_active',1)
						->orderBy('name','ASC')
						->get();
	}

	public function getMainCategories(){
		return Category::MainCategory()->orderBy('name','ASC')->get();
	}

	public function getSubCategories($id){
		return Category::selectRaw('id,name')
						->where('parent_id',$id)
						->where('is_active',1)
						->orderBy('name','ASC')
						->get();
	}

	public function getCategoryDetails($id){
		return Category::find($id);	
	}

	/*====================================================================================================================================
	| RELATIONSHIPS
	/*====================================================================================================================================*/
	public function brands(){
		return $this->belongsToMany('Brand','brand_categories');
	}
	/*====================================================================================================================================
	| QUERY SCOPES
	/*====================================================================================================================================*/
	public function scopeMainCategory($query){
		return $query->where('parent_id',null)->where('is_active',1);
	}
}
