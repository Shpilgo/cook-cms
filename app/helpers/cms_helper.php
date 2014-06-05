<?php

function btn_edit($uri) {
	return '<a class="button-edit" href="/'.$uri.'"><i class="glyphicon glyphicon-edit"></i></a>';
}

function btn_delete($uri) {
	return '<a class="button-delete" href="/'.$uri.'"><i class="glyphicon glyphicon-remove"></i></a>';
}

function btn_add($uri, $text) {
	return '<a class="btn btn-primary" href="/'.$uri.'"><i class="glyphicon glyphicon-plus"></i> '.$text.'</a>';
}

function btn_cancel($uri, $text) {
	return '<a class="btn btn-default" href="/'.$uri.'">'.$text.'</a>';
}

function status_buttons($c_name, $status, $id) {
	$status_buttons = '<div class="btn-group btn-group-sm">';
	if ($status) {
		$status_buttons.= '<button type="button" class="btn btn-default '.$c_name.'-not-active click-'.$c_name.'-not-active" data-id="'.$id.'"><i class="glyphicon glyphicon-remove"></i></button>
							<button type="button" class="btn btn-success '.$c_name.'-active disabled" data-id="'.$id.'"><i class="glyphicon glyphicon-ok"></i></button>';
	} else {
		$status_buttons.= '<button type="button" class="btn btn-danger '.$c_name.'-not-active disabled" data-id="'.$id.'"><i class="glyphicon glyphicon-remove"></i></button>
							<button type="button" class="btn btn-default '.$c_name.'-active click-'.$c_name.'-active" data-id="'.$id.'"><i class="glyphicon glyphicon-ok"></i></button>';
	}
	$status_buttons.= '</div>';
	return $status_buttons;
}

function add_meta_title($string) {
	$CI =& get_instance();
	$CI->data['meta_title'] = $string.' - '.$CI->data['meta_title'];
}

/**
 * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
 * @author Joost van Veen
 * @version 1.0
 */
if (!function_exists('dump')) {
    function dump ($var, $label = 'Dump', $echo = TRUE)
    {
        // Store dump in variable 
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        
        // Add formatting
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';
        
        // Output
        if ($echo == TRUE) {
            echo $output;
        }
        else {
            return $output;
        }
    }
}

if (!function_exists('dump_exit')) {
    function dump_exit($var, $label = 'Dump', $echo = TRUE) {
        dump ($var, $label, $echo);
        exit;
    }
}

if (!function_exists('menu_active')) {
    function menu_active($el_name, $uri_segment) {
        $active = '';
		// $this->uri->uri_string();
		if ($el_name == $uri_segment) {
			$active = 'active';
		}
		return $active;
    }
}

if (!function_exists('e')) {
	function e ($string) {
		return htmlentities($string);
	}
}

if (!function_exists('get_menu')) {
	function get_menu ($array, $child = FALSE, $parent_array = array()) {
		$CI =& get_instance();
		// dump($CI->uri->segment_array());
		$str = '';
		if (count($array)) {
			$str .= $child == FALSE ? '<ul class="nav navbar-nav">'.PHP_EOL : '<ul class="dropdown-menu">'.PHP_EOL;
			if ($child) {
				$item = $parent_array;
				$active = $CI->uri->segment(1) == $item['slug'] ? 'active' : '';
				$str .= '<li class="'.$active.'">';
				$str .= '<a href="'.site_url(e($item['slug'])).'">';
				$str .= $item['title'];
				$str .= '</a>'.PHP_EOL;
			}
			foreach ($array as $item) {
				$active = $CI->uri->segment(1) == $item['slug'] ? 'active' : '';
				$active = ($item['slug'] == '/' && !$CI->uri->segment(1)) ? 'active' : $active;
				// dump($CI->uri->segment(1).' '.$item['slug'].' '.$active);
				if (isset($item['children']) && count($item['children'])) {
					$str .= '<li class="'.$active.'">';
					$str .= '<a href="'.site_url(e($item['slug'])).'" class="dropdown-toggle" data-toggle="dropdown">';
					$str .= $item['title'];
					$str .= ' <i class="caret"></i></a>'.PHP_EOL;
					$str .= get_menu($item['children'], TRUE, $item);
				} else {
					$str .= '<li class="'.$active.'">';
					$str .= '<a href="'.site_url(e($item['slug'])).'">';
					$str .= $item['title'];
					$str .= '</a>'.PHP_EOL;
				}
				$str .= '</li>'.PHP_EOL;
			}
			$str .= '</ul>'.PHP_EOL;
		}
		return $str;
	}
}

if (!function_exists('get_admin_menu')) {
	function get_admin_menu ($array, $child = FALSE, $parent_array = array()) {
		$CI =& get_instance();
		$CI->lang->load('admin_menu');
		$str = '';
		if (count($array)) {
			$str .= $child == FALSE ? '<ul class="nav navbar-nav">'.PHP_EOL : '<ul class="dropdown-menu">'.PHP_EOL;
			if ($child) {
				$item = $parent_array;
				$active = $CI->uri->uri_string() == 'admin/'.$item['link'] ? 'active' : '';
				$str .= '<li class="'.$active.'">';
				$str .= '<a href="'.site_url('admin/'.e($item['link'])).'">';
				$str .= (lang($item['name']) != '') ? lang($item['name']) : $item['name'];
				$str .= '</a>'.PHP_EOL;
			} else {
				$active = ($CI->uri->uri_string() == 'admin/home' || $CI->uri->uri_string() == 'admin') ? 'active' : '';
				$str .= '<li class="'.$active.'">';
				$str .= '<a href="'.site_url('admin/home').'">';
				$str .= lang('home');
				$str .= '</a>'.PHP_EOL;
				$str .= '</li>'.PHP_EOL;
			}
			foreach ($array as $item) {
				if (isset($item['children']) && count($item['children'])) {
					$active = '';
					foreach ($item['children'] as $child) {
						if ($CI->uri->uri_string() == 'admin/'.$child['link'] || $CI->uri->uri_string() == 'admin/'.$item['link']) {
							$active = 'active';
						}
					}
					$str .= '<li class="'.$active.' dropdown">';
					$str .= '<a href="'.site_url('admin/'.e($item['link'])).'" class="dropdown-toggle" data-toggle="dropdown">';
					$str .= (lang($item['name']) != '') ? lang($item['name']) : $item['name'];
					$str .= ' <i class="caret"></i></a>'.PHP_EOL;
					$str .= get_admin_menu($item['children'], TRUE, $item);
				} else {
					$active = $CI->uri->uri_string() == 'admin/'.$item['link'] ? 'active' : '';
					$str .= '<li class="'.$active.'">';
					$str .= '<a href="'.site_url('admin/'.e($item['link'])).'">';
					$str .= (lang($item['name']) != '') ? lang($item['name']) : $item['name'];
					$str .= '</a>'.PHP_EOL;
				}
				$str .= '</li>'.PHP_EOL;
			}
			$str .= '</ul>'.PHP_EOL;
		}
		return $str;
	}
}

if (!function_exists('get_excerpt')) {
	function get_excerpt ($article, $numwords = 50) {
		$string = '';
		$url = 'article/'.intval($article->id).'/'.e($article->slug);
		$string .= '<h2>'.anchor($url, e($article->title)).'</h2>';
		$string .= '<p class="pubdate">'.e($article->pubdate).'</p>';
		$string .= '<p>'.e(limit_to_numwords(strip_tags($article->body), $numwords)).'</p>';
		$string .= '<p>'.anchor($url, 'Read more >', array('title' => e($article->title))).'</p>';
		return $string;
	}
}

if (!function_exists('limit_to_numwords')) {
	function limit_to_numwords ($string, $numwords) {
		$excerpt = explode(' ', $string, $numwords + 1);
		if (count($excerpt) >= $numwords) {
			array_pop($excerpt);
		}
		$excerpt = implode(' ', $excerpt);
		return $excerpt;
	}
}

if (!function_exists('article_link')) {
	function article_link ($article) {
		return 'article/'.intval($article->id).'/'.e($article->slug);
	}
}

if (!function_exists('article_links')) {
	function article_links ($articles) {
		$string = '<ul>';
		foreach ($articles as $article) {
			$url = article_link($article);
			$string .= '<li style="list-style: none;">';
			$string .= '<h3>'.anchor($url, e($article->title)).'</h3>';
			$string .= '<p class="pubdate">'.e($article->pubdate).'</p>';
			$string .= '</li>';
		}
		$string .= '</ul>';
		return $string;
	}
}

if (!function_exists('get_templates_list')) {
	function get_templates_list() {
		$CI =& get_instance();
		$CI->load->helper('directory');
		$templates_directory = $_SERVER['DOCUMENT_ROOT'].'/'.APPPATH.'views/tpl/';
		$directory_files_list = directory_map($templates_directory, 1, TRUE);
		foreach ($directory_files_list as $filename) {
			$withoutExt = preg_replace("/\\.[^.\\s]{3,4}$/", "", $filename);
			$templates_list[$withoutExt] = $withoutExt;
		}
		return $templates_list;
	}
}

if (!function_exists('str_class')) {
	function str_class($str) {
		return strtolower(get_class($str));
	}
}

if (!function_exists('set_message')) {
	function set_message($message, $type = 'info') {
		$CI =& get_instance();
		$userdata = array(
			'text' => $message,
			'type' => 'alert-'.$type
		);
		$CI->session->set_flashdata('mess', $userdata);
	}
}

if (!function_exists('create_message')) {
	function create_message($message, $type = 'info') {
		return '<div class="alert alert-'.$type.'">'.$message.'</div>';
	}
}

if (!function_exists('create_message_session')) {
	function create_message_session() {
		$CI =& get_instance();
		$message = $CI->session->userdata('message');
		$CI->session->unset_userdata('message');
		if ($CI->session->userdata('message_type')) {
			$type = $CI->session->userdata('message_type');
			$CI->session->unset_userdata('message_type');
		} else {
			$type = 'info';
		}
		return create_message($message, $type);
	}
}

if (!function_exists('array_to_object')) {
	function array_to_object($array = array()) {
		$object = new stdClass();
		if (count($array)) {
			foreach ($array as $key => $value) {
				$object->$key = $value;
			}
		}
		return $object;
	}
}

if (!function_exists('rules_lang')) {
	function rules_lang($rules = array()) {
		if (count($rules)) {
			$CI =& get_instance();
			foreach ($rules as $key => $value) {
				$rules[$key]['label'] = $CI->lang->line($key);
			}
		}
		return $rules;
	}
}

if (!function_exists('get_admin_breadcrumb')) {
	function get_admin_breadcrumb($page) {
		$CI =& get_instance();
		$CI->lang->load('admin_menu');
		$breadcrumb = '<ol class="breadcrumb">';
		if (count($page)) {
			$breadcrumb.= '<li><a href="/admin/home">'.lang('home').'</a></li>';
			if ($page->parent_name != null) {
				$parent_name = (lang($page->parent_name) != '') ? lang($page->parent_name) : $page->parent_name;
				$breadcrumb.= '<li><a href="/admin/'.$page->parent_link.'">'.$parent_name.'</a></li>';
			}
			$page_name = (lang($page->name) != '') ? lang($page->name) : $page->name;
			$link = $CI->uri->uri_string();
			$link_parts = explode('/', $link);
			if (array_search('edit', $link_parts)) {
				$breadcrumb.= '<li><a href="/admin/'.$page->link.'">'.$page_name.'</a></li>';
				$breadcrumb.= '<li class="active">'.lang('edit').'</li>';
			} else {
				$breadcrumb.= '<li class="active">'.$page_name.'</li>';
			}
		} else {
			$breadcrumb.= '<li class="active">'.lang('home').'</li>';
		}
		$breadcrumb.= '</ol>';
		return $breadcrumb;
	}
}