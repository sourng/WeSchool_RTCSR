<?php
if ( ! function_exists('dropdown_navigation_menu')){
	function dropdown_navigation_menu($menu_name, $object="", $currentParent=0, $currLevel = 0, $prevLevel = 0){
		$menu_id = get_navigation_id($menu_name);
		
		$object = DB::table('site_navigation_items')
				  ->where('navigation_id',$menu_id)
				  ->orderBy("menu_order","asc")->get();

		foreach ($object as $menu) {
			if ($currentParent == $menu->parent_id) {
				if ($currLevel > $prevLevel) echo '<ul class="dropdown-menu">'; 
				
				if ($currLevel == $prevLevel) echo "</li>";
				
				//echo '<li><label class="menu_label" for='.$menu->id.'><a href="'.action($url, $menu->id).'">'.$menu->menu_label.'</a></label>';
				
				$link = $menu->page_id =="" ?  str_replace("login_link",route('login'),$menu->link) : url('/site/'.get_page_slug($menu->page_id));

				echo '<li><a href="'.$link.'" id="'.$menu->css_id.'" data-toggle="dropdown" class="dropdown-toggle '.$menu->css_class.'">'.$menu->menu_label.'</a>';
				
					if ($currLevel > $prevLevel) { 
					   $prevLevel = $currLevel; 
					}
				$currLevel++; 
				dropdown_navigation_menu($menu_name, $object, $menu->id, $currLevel, $prevLevel);
				$currLevel--;   
			}
		 }
		if ($currLevel == $prevLevel) echo "</li> </ul>";
	}
}

if ( ! function_exists('categoryTree')){
	
    function categoryTree($object, $currentParent, $url, $currLevel = 0, $prevLevel = -1) {
		 foreach ($object as $category) {
			if ($currentParent == $category->parent_id) {
				if ($currLevel > $prevLevel){
					echo "<ul class='menutree'>"; 
					echo '<li> <label class="menu_label" for='.$category->id.'><a href="'.url('category').'">'._lang('Uncategorized').'</a></label></li>';
				}	
				if ($currLevel == $prevLevel) echo "</li>";
				echo '<li> <label class="menu_label" for='.$category->id.'><a href="'.url('category/'.$category->id).'">'.$category->category.'</a></label>';
					if ($currLevel > $prevLevel) { 
					   $prevLevel = $currLevel; 
					}
				$currLevel++; 
				categoryTree ($object, $category->id, $url, $currLevel, $prevLevel);
				$currLevel--;   
			}
		 }
		if ($currLevel == $prevLevel) echo "</li> </ul>";
	 }
}
