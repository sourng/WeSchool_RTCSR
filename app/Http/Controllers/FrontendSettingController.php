<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendSettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	private $order = 1; 
    public function __construct()
    {
        
    }
	
	public function menu_sorting(Request $request)
    {
		$array = json_decode($request->sortable_menu);
        
		foreach($array as $menu_item){
			$navigationitem = \App\NavigationItem::find($menu_item->id);
			$navigationitem->menu_order = $this->order;
			$navigationitem->parent_id = 0;
			$navigationitem->save();
			$this->order++;
			
			$this->check_child($menu_item);
		}
		
		return redirect()->back()->with('success', _lang('Saved Sucessfully'));
    }
	
	private function check_child($object){
		if(isset($object->children)){
			foreach($object->children as $child_menu){
				$navigationitem = \App\NavigationItem::find($child_menu->id);
				$navigationitem->menu_order = $this->order;
				$navigationitem->parent_id = $object->id;
				$navigationitem->save();
				$this->order++;
				$this->check_child($child_menu);
			}
		}
	}
	
	public function theme_option(){
		return view(theme().'.theme_option.index');
	}
	
   
}
