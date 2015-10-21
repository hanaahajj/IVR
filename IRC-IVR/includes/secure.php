<?php 

// escaping and slashing all POST and GET variables. you may add $_COOKIE and $_REQUEST if you want them sanitized. 
array_walk_recursive($_REQUEST, 'sanitizeText'); 
array_walk_recursive($_POST, 'sanitizeVariables'); 
array_walk_recursive($_GET, 'sanitizeVariables'); 

// sanitization 
function sanitizeVariables(&$item, $key) 
{ 
    if (!is_array($item)) 
    {
        // undoing 'magic_quotes_gpc = On' directive 
        if (get_magic_quotes_gpc()) 
            $item = stripcslashes($item); 
        
        $item = sanitizeText($item); 
    } 
}

// does the actual 'html' and 'sql' sanitization. customize if you want. 
function sanitizeText($text) 
{
    $text = str_replace("<", "&lt;", $text); 
    $text = str_replace(">", "&gt;", $text); 
    if (substr($text,0, 1)!="{" and substr($text,0, 1)!="[")
    {
        // $text = str_replace('"', "&quot;", $text); 
        // $text = str_replace('\'', "&#039;", $text); 
        // $text = str_replace("·", "&#039;", $text); 
        // $text = str_replace("´", "&#039;", $text); 
        // $text = str_replace("‘", "&#039;", $text); 
        // $text = str_replace("'", "&#039;", $text); 
        // $text = str_replace("’", "&#039;", $text); 
        // $text = str_replace("'", "&#039;", $text); 
        // $text = str_replace("“", "&quot;", $text); 
        // $text = str_replace("”", "&quot;", $text); 
    }
    // it is recommended to replace 'addslashes' with 'mysql_real_escape_string' or whatever db specific fucntion used for escaping. However 'mysql_real_escape_string' is slower because it has to connect to mysql. 
    $text = DB_escape_string($text); 
    //echo $text;
    return $text; 
}
?>