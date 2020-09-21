<?php

if ( ! function_exists('_lang')){
	function _lang($string=''){
		//Get Target language
		// $target_lang = get_option('language');
		$target_lang=app()->getLocale();
		
		if($target_lang == ""){
			$target_lang = "language";
		}
		
		if(file_exists(resource_path() . "/language/$target_lang.php")){
			include(resource_path() . "/language/$target_lang.php"); 
		}else{
			include(resource_path() . "/language/language.php"); 
		}
		
		if (array_key_exists($string,$language)){
			return $language[$string];
		}else{
			return $string;
		}
	}
}


if ( ! function_exists('startsWith')){
	function startsWith($haystack, $needle)
	{
		 $length = strlen($needle);
		 return (substr($haystack, 0, $length) === $needle);
	}
}


if ( ! function_exists('create_option')){
	function create_option($table,$value,$display,$selected="",$where=NULL){
		$options = "";
		$condition = "";
		if($where != NULL){
			$condition .= "WHERE ";
			foreach( $where as $key => $v ){
				$condition.=$key."'".$v."' ";
			}
		}

		$query = DB::select("SELECT $value, $display FROM $table $condition");
		foreach($query as $d){
			if( $selected!="" && $selected == $d->$value ){   
				$options.="<option value='".$d->$value."' selected='true'>".$d->$display."</option>";
			}else{
				$options.="<option value='".$d->$value."'>".$d->$display."</option>";
			} 
		}
		
		echo $options;
	}
}

if (! function_exists('create_option2')) {
	function create_option2($table = '',$value = '',$show = '',$selected = '', $where = null) {
		if($where != null){
			$results = DB::table($table)->where($where)->orderBy('id','DESC')->get();
		}else{
			$results = DB::table($table)->orderBy('id','DESC')->get();
		}
		$option = '';
		foreach ($results as $data) {
			if($data->$value == $selected){
				$option .= '<option value="' . $data->$value . '" selected>' . $data->$show . '</option>';
			}else{
				$option .= '<option value="' . $data->$value . '">' . $data->$show . '</option>';
			}
		}
		echo $option;
	}
}

if (! function_exists('create_leave_option')) {
	function create_leave_option($selected = '', $where = null, $order = 'DESC') {
		if($where !=null){
			$results = App\LeaveType::where($where)->orderBy('id', $order)->get();
		}else{
			$results = App\LeaveType::orderBy('id', $order)->get();
		}
		$option = '';
		foreach ($results as $data) {
			if($data->id == $selected){
				$option.='<option value="' . $data->id . '" selected>' . $data->title . ' (' . $data->off_type . ')</option>';
			}else{
				$option.='<option value="' . $data->id . '">' . $data->title . ' (' . $data->off_type . ')</option>';
			}
		}
		echo $option;
	}
}

if (! function_exists('create_employee_option')) {
	function create_employee_option($selected = '', $where = null, $order = 'DESC') {
		if($where != null){
			$results = App\Employee::select('*')
									->join('users', 'users.id', '=', 'user_id')
									->where($where)
									->orderBy('employees.id', $order)
									->get();
		}else{
			$results = App\Employee::select('*')
									->join('users', 'users.id', '=', 'user_id')
									->orderBy('employees.id', $order)
									->get();
		}
		$option = '';
		foreach ($results as $data) {
			if($data->user_id == $selected){
				$option.='<option value="' . $data->user_id . '" selected>' . $data->name . ' (' . $data->employee_id . ')</option>';
			}else{
				$option.='<option value="' . $data->user_id . '">' . $data->name . ' (' . $data->employee_id . ')</option>';
			}
		}
		echo $option;
	}
}

if ( ! function_exists('get_table')){
	function get_table($table,$where=NULL) 
	{
		$condition = "";
		if($where != NULL){
			$condition .= "WHERE ";
			foreach( $where as $key => $v ){
				$condition.=$key."'".$v."' ";
			}
		}
		$query = DB::select("SELECT * FROM $table $condition");
		return $query;
	}
}
if ( ! function_exists('get_table2')){
	function get_table2($table, $where = null , $order = 'DESC') 
	{
		if($where != null){
			$results = DB::table($table)->where($where)->orderBy('id', $order)->get();
		}else{
			$results = DB::table($table)->orderBy('id', $order)->get();
		}
		return $results;
	}
}

if ( ! function_exists('get_pages')){
	function get_pages() 
	{
		$pages = \App\Page::where("page_status","publish")->get();
	    return $pages;
	}
}

if ( ! function_exists('get_posts')){
	function get_posts($limit=5, $post_type="post") 
	{
		$posts = \App\Post::where("post_status","publish")
		                  ->where("post_type",$post_type)
						  ->orderBy("id","desc")
						  ->limit($limit)
						  ->get();
	    return $posts;
	}
}

if ( ! function_exists('get_notices')){
	function get_notices($user_type="Website", $limit=5) 
	{
		$notices = \App\Notice::join("user_notices","notices.id","user_notices.notice_id")
		                  ->select('notices.*')
						  ->where("user_notices.user_type",$user_type)
						  ->orderBy("notices.id","desc")
						  ->limit($limit)
						  ->get();
	    return $notices;
	}
}

if ( ! function_exists('get_events')){
	function get_events($limit=5) 
	{
		$events = \App\Event::limit($limit)
						->orderBy("id","desc")->get();
	    return $events;
	}
}

if ( ! function_exists('user_count')){
	function user_count($user_type) 
	{
		$count = \App\User::where("user_type",$user_type)
						->selectRaw("COUNT(id) as total")
						->first()->total;
	    return $count;
	}
}

if ( ! function_exists('post_parmalink')){
	function post_parmalink($post) 
	{
		return url('post/'.$post->slug);
	}
}

if ( ! function_exists('get_logo')){
	function get_logo() 
	{
		$logo = get_option("logo");
		if($logo ==""){
			return asset("public/uploads/logo.png");
		}
		return asset("public/uploads/$logo"); 
	}
}

if ( ! function_exists('sql_escape')){
	function sql_escape($unsafe_str) 
	{
		if (get_magic_quotes_gpc())
		{
			$unsafe_str = stripslashes($unsafe_str);
		}
		return $escaped_str = str_replace("'", "", $unsafe_str);
	}
}

if ( ! function_exists('get_option')){
	function get_option($name, $optional = '') 
	{
		$setting = DB::table('settings')->where('name', $name)->get();
	    if ( ! $setting->isEmpty() ) {
		   return $setting[0]->value;
		}
		return $optional;

	}
}

if ( ! function_exists('month_number_to_name')){
	function month_number_to_name($month_number) 
	{
		$month_name = date("F", mktime(0, 0, 0, $month_number, 10));
		return $month_name; 
	}
}

if ( ! function_exists('has_permission')){
	function has_permission($name,$role_id) 
	{
		$permission = DB::table('permissions')
		          ->where('permission', $name)
		          ->where('role_id', $role_id)
				  ->get();
	    if ( ! $permission->isEmpty() ) {
		   return true;
		}
		return false;
	}
}

if ( ! function_exists('get_academic_year')){
	function get_academic_year($id = "") 
	{
		if($id == ""){
			$id = get_option("academic_year");
		}
		$query = DB::table('academic_years')->where('id', $id)->get();
	    if ( ! $query->isEmpty() ) {
		   return $query[0]->year;
		}
		return "";

	}
}

if ( ! function_exists('get_class_name')){
	function get_class_name($id) 
	{
		$class = DB::table('classes')->where('id', $id)->get();
	    if ( ! $class->isEmpty() ) {
		   return $class[0]->class_name;
		}
		return "";

	}
}

if ( ! function_exists('get_grade')){
	function get_grade($mark) 
	{
		$mark = sql_escape($mark);
		$grade = DB::select("SELECT grade_name FROM grades WHERE $mark BETWEEN marks_from AND marks_to");
	    if ( count($grade) >0 ) {
		   return $grade[0]->grade_name;
		}
		return "N/A";

	}
}

if ( ! function_exists('get_point')){
	function get_point($mark) 
	{
		$mark = sql_escape($mark);
		$grade = DB::select("SELECT point FROM grades WHERE $mark BETWEEN marks_from AND marks_to");
	    if ( count($grade) >0 ) {
		   return $grade[0]->point;
		}
		return "N/A";

	}
}

if ( ! function_exists('get_final_grade')){
	function get_final_grade($point) 
	{
		$point = sql_escape($point);
		$grade = DB::select("SELECT grade_name FROM grades WHERE $point>point OR $point=point limit 1");
	    if ( count($grade) >0 ) {
		   return $grade[0]->grade_name;
		}
		return "N/A";

	}
}

if ( ! function_exists('get_section_name')){
	function get_section_name($id) 
	{
		$class = DB::table('sections')->where('id', $id)->get();
	    if ( ! $class->isEmpty() ) {
		   return $class[0]->section_name;
		}
		return "";

	}
}

if ( ! function_exists('get_subject_name')){
	function get_subject_name($id) 
	{
		$class = DB::table('subjects')->where('id', $id)->get();
	    if ( ! $class->isEmpty() ) {
		   return $class[0]->subject_name;
		}
		return "";

	}
}


if ( ! function_exists('get_exam')){
	function get_exam($id) 
	{
		$class = DB::table('exams')->where('id', $id)->get();
	    if ( ! $class->isEmpty() ) {
		   return $class[0]->name;
		}
		return "";

	}
}

if ( ! function_exists('timezone_list'))
{

 function timezone_list() {
  $zones_array = array();
  $timestamp = time();
  foreach(timezone_identifiers_list() as $key => $zone) {
    date_default_timezone_set($zone);
    $zones_array[$key]['ZONE'] = $zone;
    $zones_array[$key]['GMT'] = 'UTC/GMT ' . date('P', $timestamp);
  }
  return $zones_array;
}

}

if ( ! function_exists('create_timezone_option'))
{

 function create_timezone_option($old="") {
  $option = "";
  $timestamp = time();
  foreach(timezone_identifiers_list() as $key => $zone) {
    date_default_timezone_set($zone);
	$selected = $old == $zone ? "selected" : "";
	$option .= '<option value="'. $zone .'"'.$selected.'>'. 'GMT ' . date('P', $timestamp) .' '.$zone.'</option>';
  }
  echo $option;
}

}


if ( ! function_exists( 'get_country_list' ))
{
    function get_country_list( $old_data='' ) {
		if( $old_data == "" ){
			echo file_get_contents( app_path().'/Helpers/country.txt' );
		}else{
			$pattern='<option value="'.$old_data.'">';
			$replace='<option value="'.$old_data.'" selected="selected">';
			$country_list=file_get_contents( app_path().'/Helpers/country.txt' );
			$country_list=str_replace($pattern,$replace,$country_list);
			echo $country_list;
		}
    }	
}

if ( ! function_exists('decimalPlace'))
{

 function decimalPlace($number){
  return number_format((float)$number, 2);
 }

}

if ( ! function_exists('get_fee_select'))
{

 function get_fee_selectbox($class="",$fee_id=""){
	$select = "<select name='fee_type[]' class='form-control $class'>";
	$select .="<option value=''>"._lang('Select One')."</option>";

	foreach(get_table("fee_types") as $fee_type){
		$selected = $fee_id==$fee_type->id ? "selected" : "";
		$select .="<option value='".$fee_type->id."' $selected>".$fee_type->fee_type."</option>";
	}
	$select .="</select>";
	return $select;
 }

}

if(! function_exists('get_children')){
	function get_children($menu_name, $link, $icon){
		$parent_id = App\ParentModel::where('user_id', Auth::User()->id)->first()->id;
		$students = App\Student::where('parent_id',$parent_id)->get();
		$student = App\Student::where('parent_id',$parent_id)->first();
		if(count($students) == 1){
			$active = '';
			if(Request::is($link.'/*')){
				$active = 'class="active"';
			}
			return "<li ".$active.">
						<a href='".URL::to('/').'/'.$link.'/'.$student->id."'>
							<i class='".$icon."'></i>
							".$menu_name."
						</a>
					</li>";
		}else{
			$return = '<li><a href="#"><i class="'.$icon.'"></i>'.$menu_name.'</a><ul>';
			foreach ($students AS $student){
				$active = '';
				if(Request::is($link.'/'.$student->id)){
					$active = 'class="active"';
				}
				$return .= "<li ".$active.">
								<a href='".URL::to('/').'/'.$link.'/'.$student->id."'>
									".$student->first_name." ".$student->last_name."
								</a>
							</li>";
			}
			$return .='</ul><li>';

			return $return;
		}
		return '';
	}
}

if ( ! function_exists('count_inbox')){
	function count_inbox() 
	{
		$user_id = \Auth::user()->id;
		$inbox = DB::select("SELECT COUNT(id) as c FROM user_messages 
		WHERE receiver_id='$user_id' AND user_messages.read='n'");
		return $inbox[0]->c;

	}
}

if ( ! function_exists('inbox_items')){
	function inbox_items($limit = 5) 
	{
		$messages = \App\Message::join("user_messages","messages.id","=","user_messages.message_id")
                     ->join("users","messages.sender_id","=","users.id")
					 ->select('messages.*','users.name as sender','user_messages.read')
					 ->where("receiver_id",\Auth::user()->id)
					 ->where("read","n")
					 ->limit($limit)
		             ->orderBy("messages.id","DESC")->get();
					 
		 return $messages;
	}
}

if ( ! function_exists('get_student_id')){
	function get_student_id() 
	{
		$user_id = \Auth::user()->id;
		$student = DB::select("SELECT id FROM students 
		WHERE user_id='$user_id'");
		return $student[0]->id;

	}
}

if ( ! function_exists('get_student_name')){
	function get_student_name($student_id) 
	{
		$student = DB::select("SELECT first_name,last_name FROM students 
		WHERE id='$student_id'");
		return $student[0]->first_name." ".$student[0]->last_name;
	}
}

if ( ! function_exists('get_teacher_id')){
	function get_teacher_id() 
	{
		$user_id = \Auth::user()->id;
		$teacher = DB::select("SELECT id FROM teachers 
		WHERE user_id='$user_id'");
		return $teacher[0]->id;
	}
}

if ( ! function_exists('get_parent_id')){
	function get_parent_id() 
	{
		$user_id = \Auth::user()->id;
		$parent = DB::select("SELECT id FROM parents 
		WHERE user_id='$user_id'");
		return $parent[0]->id;
	}
}

if ( ! function_exists('object_to_string')){
	function object_to_string($object,$col,$quote = false) 
	{
		$string = "";
		foreach($object as $data){
			if($quote == true){
				$string .="'".$data->$col."', ";
			}else{
				$string .=$data->$col.", ";
			}
		}
		$string = substr_replace($string, "", -2);
		return $string;
	}
}

if ( ! function_exists('buildTree')){
	
    function buildTree($object, $currentParent, $url, $currLevel = 0, $prevLevel = -1) {
		 foreach ($object as $category) {
			if ($currentParent == $category->parent_id) {
				if ($currLevel > $prevLevel) echo "<ol id='menutree'>"; 
				if ($currLevel == $prevLevel) echo "</li>";
				echo '<li> <label class="menu_label" for='.$category->id.'><a href="'.action($url, $category->id).'">'.$category->category.'</a></label>';
					if ($currLevel > $prevLevel) { 
					   $prevLevel = $currLevel; 
					}
				$currLevel++; 
				buildTree ($object, $category->id, $url, $currLevel, $prevLevel);
				$currLevel--;   
			}
		 }
		if ($currLevel == $prevLevel) echo "</li> </ol>";
	 }
}


if ( ! function_exists('buildOptionTree')){
	
    function buildOptionTree($table, $currentParent, $currLevel = 0, $prevLevel = -1) {

		 $array = DB::table($table)->get();
		 foreach ($array as $category) {
			if ($currentParent == $category->parent_id) {

				$level ="";
				for($i=0; $i<$currLevel; $i++){
					$level .="-";
				}
				echo '<option value='.$category->id.'>'.$level." ".$category->category.'</option>';
					if ($currLevel > $prevLevel) { 
					   $prevLevel = $currLevel; 
					}
				$currLevel++; 
				buildOptionTree ($table, $category->id, $currLevel, $prevLevel);
				$currLevel--;   
			}
		 }
	
	 }
}

if ( ! function_exists('navigationTree')){
	
    function navigationTree($object, $currentParent, $url, $currLevel = 0, $prevLevel = -1) {
		 foreach ($object as $menu) {
			if ($currentParent == $menu->parent_id) {
				if ($currLevel > $prevLevel) echo "<ol id='menutree' class='dd-list'>"; 
				if ($currLevel == $prevLevel) echo "</li>";
				//echo '<li class="dd-item" data-id="'.$menu->id.'"> <label class="menu_label" for='.$menu->id.'><a href="'.action($url, $menu->id).'">'.$menu->menu_label.'</a></label>';
				echo '<li class="dd-item" data-id="'.$menu->id.'"><div class="dd-handle">'.$menu->menu_label.'</div><a class="edit_menu" href="'.action($url, $menu->id).'">'._lang('Edit Menu').'</a>';
					if ($currLevel > $prevLevel) { 
					   $prevLevel = $currLevel; 
					}
				$currLevel++; 
				navigationTree($object, $menu->id, $url, $currLevel, $prevLevel);
				$currLevel--;   
			}
		 }
		if ($currLevel == $prevLevel) echo "</li> </ol>";
	 }
}


if ( ! function_exists('navigationOptionTree')){
	
    function navigationOptionTree($table, $navigation_id, $currentParent, $currLevel = 0, $prevLevel = -1) {

		 $array = DB::table($table)
		          ->where("navigation_id",$navigation_id)->get();
		 foreach ($array as $category) {
			if ($currentParent == $category->parent_id) {

				$level ="";
				for($i=0; $i<$currLevel; $i++){
					$level .="-";
				}
				echo '<option value='.$category->id.'>'.$level." ".$category->menu_label.'</option>';
					if ($currLevel > $prevLevel) { 
					   $prevLevel = $currLevel; 
					}
				$currLevel++; 
				navigationOptionTree ($table, $navigation_id, $category->id, $currLevel, $prevLevel);
				$currLevel--;   
			}
		 }
	
	 }
}


if ( ! function_exists('get_s')){
	function get_s($serialized,$lang) 
	{
		if(!empty($serialized)){
			$array = unserialize($serialized);
			return $array[$lang];
		}
		return "";
	}
}

if ( ! function_exists('theme')){
	function theme() 
	{
		$theme = get_option('active_theme');
		if($theme == ""){
			return "theme/default";
		}
		return "theme/".$theme;
	}
}

if ( ! function_exists('theme_asset_url()')){
	function theme_asset_url($file) 
	{
		$theme = get_option('active_theme');
		if($theme == ""){
			return asset("public/theme/default/$file");
		}
		return asset("public/theme/$theme/$file");
	}
}

if( !function_exists('load_custom_template') ){
	function load_custom_template(){
		$path = resource_path() . "/views/".theme()."/templates";
		if( is_dir($path) ){
			$files = scandir($path);
			$options="";
			foreach($files as $file){
			   $name=pathinfo($file, PATHINFO_FILENAME);
			   if (strpos($name, 'template-') === 0) {   
				   $name = str_replace(".blade","",substr($name,9));
				   $options .= "<option value='$name'>".ucwords($name)."</option>";
			   }			        
			}
			echo $options;
		}
	}
}


if( !function_exists('load_theme') ){
	function load_theme($active=''){
		$path = resource_path() . "/views/theme";
		$files = scandir($path);
		$options="";
		
		foreach($files as $file){
		    $name = pathinfo($file, PATHINFO_FILENAME);
			if($name == "." || $name == ""){
				continue;
			}
			
			$selected = "";
			if($active == $name){
				$selected = "selected";
			}else{
				$selected = "";
			}
			
			$options .= "<option value='$name' $selected>".ucwords($name)."</option>";
		        
		}
		echo $options;
	}
}

if( !function_exists('load_language') ){
	function load_language($active=''){
		$path = resource_path() . "/language";
		$files = scandir($path);
		$options="";
		
		foreach($files as $file){
		    $name = pathinfo($file, PATHINFO_FILENAME);
			if($name == "." || $name == "" || $name == "language"){
				continue;
			}
			
			$selected = "";
			if($active == $name){
				$selected = "selected";
			}else{
				$selected = "";
			}
			
			$options .= "<option value='$name' $selected>".ucwords($name)."</option>";
		        
		}
		echo $options;
	}
}

if( !function_exists('get_language_list') ){
	function get_language_list(){
		$path = resource_path() . "/language";
		$files = scandir($path);
		$array = array();
		
		foreach($files as $file){
		    $name = pathinfo($file, PATHINFO_FILENAME);
			if($name == "." || $name == "" || $name == "language"){
				continue;
			}
	
			$array[] = $name;
		        
		}
		return $array;
	}
}

if ( ! function_exists('get_navigation_id')){
	function get_navigation_id($menu) 
	{
		$nav = DB::table('site_navigations')->where('menu_name', $menu)->get();
	    if ( ! $nav->isEmpty() ) {
		   return $nav[0]->id;
		}
		return 0;

	}
}

if ( ! function_exists('get_page_slug')){
	function get_page_slug($page_id) 
	{
		$page = DB::table('pages')->where('id', $page_id)->get();
	    if ( ! $page->isEmpty() ) {
		   return $page[0]->slug;
		}
		return "/";

	}
}

$shortcodes = array();

if( !function_exists('create_shortcode') ){
	function create_shortcode($shortcode,$callback){
		global $shortcodes;
		$shortcodes[$shortcode] = $callback;
	}
}

if( !function_exists('do_shortcode') ){
	function do_shortcode($shortcode){
		global $shortcodes;
		call_user_func($shortcodes[$shortcode],$atts);
	}
}