<?php

function get_page_html($url, $use_cash = true) {
	$url_hash = hash('sha512', $url);
	$cash_file_name = 'cache/'.$url_hash.'.html';
	if (!file_exists('cache')) {
		umask(0000);
		mkdir('cache');
	}
	if (file_exists($cash_file_name) && $use_cash) {
		$cash_file = file_get_contents($cash_file_name);
	} else {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_REFERER, '');
		$page_html = curl_exec($ch);
		curl_close($ch);
		$cash_file = $page_html;
		$handle = fopen($cash_file_name, 'w');
		fwrite($handle, $page_html);
		fclose($handle);
	}
	return $cash_file;
}

function getElementsByClassName(DOMDocument $DOMDocument, $ClassName, $TagName = "*") {
    $Elements = $DOMDocument -> getElementsByTagName($TagName);
    $Matched = array();

    foreach($Elements as $node) {
        if( ! $node -> hasAttributes())
            continue;

        $classAttribute = $node -> attributes -> getNamedItem('class');

        if( ! $classAttribute)
            continue;

        $classes = explode(' ', $classAttribute -> nodeValue);

        if(in_array($ClassName, $classes))
            $Matched[] = $node;
    }

    return $Matched;
}

function XMLPrint_r($d_DomNode) {
	print $d_DomNode->nodeName." ".$d_DomNode->nodeValue."<br>";
    if ($d_DomNode->hasChildNodes()) {
		foreach($d_DomNode->childNodes as $d_ChildNode) {
			print "<br>";
			XMLPrint_r($d_ChildNode);
		}
	}
}

class JsParserException extends Exception {}
function parse_jsobj($str, &$data) {
    $str = trim($str);
    if(strlen($str) < 1) return;

    if($str{0} != '{') {
    	throw new JsParserException('The given string is not a JS object');
    }
    $str = substr($str, 1);

    /* While we have data, and it's not the end of this dict (the comma is needed for nested dicts) */
    while(strlen($str) && $str{0} != '}' && $str{0} != ',') { 
    	/* find the key */
    	if($str{0} == "'" || $str{0} == '"') {
    		/* quoted key */
    		list($str, $key) = parse_jsdata($str, ':');
    	} else {
    		$match = null;
    		/* unquoted key */
    		if(!preg_match('/^\s*[a-zA-z_][a-zA-Z_\d]*\s*:/', $str, $match)) {
    		throw new JsParserException('Invalid key ("'.$str.'")');
    		}	
    		$key = $match[0];
    		$str = substr($str, strlen($key));
    		$key = trim(substr($key, 0, -1)); /* discard the ':' */
    	}

    	list($str, $data[$key]) = parse_jsdata($str, '}');
    }
    "Finshed dict. Str: '$str'\n";
    return substr($str, 1);
}

function comma_or_term_pos($str, $term) {
    $cpos = strpos($str, ',');
    $tpos = strpos($str, $term);
    if($cpos === false && $tpos === false) {
    	throw new JsParserException('unterminated dict or array');
    } else if($cpos === false) {
    	return $tpos;
    } else if($tpos === false) {
    	return $cpos;
    }
    return min($tpos, $cpos);
}

function parse_jsdata($str, $term="}") {
    $str = trim($str);


    if(is_numeric($str{0}."0")) {
    	/* a number (int or float) */
    	$newpos = comma_or_term_pos($str, $term);
    	$num = trim(substr($str, 0, $newpos));
    	$str = substr($str, $newpos+1); /* discard num and comma */
    	if(!is_numeric($num)) {
    		throw new JsParserException('OOPSIE while parsing number: "'.$num.'"');
    	}
    	return array(trim($str), $num+0);
    } else if($str{0} == '"' || $str{0} == "'") {
    	/* string */
    	$q = $str{0};
    	$offset = 1;
    	do {
    		$pos = strpos($str, $q, $offset);
    		$offset = $pos;
    	} while($str{$pos-1} == '\\'); /* find un-escaped quote */
    	$data = substr($str, 1, $pos-1);
    	$str = substr($str, $pos);
    	$pos = comma_or_term_pos($str, $term);
    	$str = substr($str, $pos+1);		
    	return array(trim($str), $data);
    } else if($str{0} == '{') {
    	/* dict */
    	$data = array();
    	$str = parse_jsobj($str, $data);
    	return array($str, $data);
    } else if($str{0} == '[') {
    	/* array */
    	$arr = array();
    	$str = substr($str, 1);
    	while(strlen($str) && $str{0} != $term && $str{0} != ',') {
    		$val = null;
    		list($str, $val) = parse_jsdata($str, ']');
    		$arr[] = $val;
    		$str = trim($str);
    	}
    	$str = trim(substr($str, 1));
    	return array($str, $arr);
    } else if(stripos($str, 'true') === 0) {
    	/* true */
    	$pos = comma_or_term_pos($str, $term);
    	$str = substr($str, $pos+1); /* discard terminator */
    	return array(trim($str), true);
    } else if(stripos($str, 'false') === 0) {
    	/* false */
    	$pos = comma_or_term_pos($str, $term);
    	$str = substr($str, $pos+1); /* discard terminator */
    	return array(trim($str), false);
    } else if(stripos($str, 'null') === 0) {
    	/* null */
    	$pos = comma_or_term_pos($str, $term);
    	$str = substr($str, $pos+1); /* discard terminator */
    	return array(trim($str), null);
    } else if(strpos($str, 'undefined') === 0) {
    	/* null */
    	$pos = comma_or_term_pos($str, $term);
    	$str = substr($str, $pos+1); /* discard terminator */
    	return array(trim($str), null);
    } else {
    	throw new JsParserException('Cannot figure out how to parse "'.$str.'" (term is '.$term.')');
    }
}