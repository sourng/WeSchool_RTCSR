<style type="text/css">
#id_card::after{
	content: "";
	width: 100%;
	height: 100%;
	position: absolute;
	opacity: 0.2;
	top:0;
	background-image: url('{{ get_logo() }}') !important;
    background-repeat: no-repeat !important;
	background-size: 100px auto !important;
    background-position: center !important; 
}

.sidebar .sidebar-wrapper {
    background: {{ get_option('sidebar_color') != "" ? get_option('sidebar_color') : '#FFF' }};
}

.sidebar .nav li:not(.active) > a, .sidebar[data-background-color="white"] .nav li:not(.active) > a{
	color: {{ get_option('sidebar_text_color') != "" ? get_option('sidebar_text_color') : '#000' }};
}

.sidebar .logo .simple-text, .sidebar[data-background-color="white"] .logo .simple-text{
	color: {{ get_option('sidebar_text_color') != "" ? get_option('sidebar_text_color') : '#000' }};
}

.metismenu li {
    border-bottom: 1px solid {{ get_option('sidebar_border_color') != "" ? get_option('sidebar_border_color') : '#ddd' }};
}

@php $acb = get_option('active_sidebar_background') @endphp

.sidebar[data-active-color="danger"] .nav li.active > a{
	background: {{ $acb != "" ? $acb : '#e74c3c' }};
}

.nav li.active > ul>li.active > a {
    color: {{ $acb != "" ? $acb : '#e74c3c' }} !important;
}

{!! get_option('custom_backend_css') !!}
</style>