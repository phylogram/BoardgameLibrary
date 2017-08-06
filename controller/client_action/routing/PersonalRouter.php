<?php
namespace controller\client_action\routing;
require('site_structure.php');
class PersonalRouter
{


    public static function find()
    {
        $nodes = explode('/', $_SERVER['REQUEST_URI']);
        if (count($nodes) > max_uri_depth) {
            return false; #To do: 404er einbauen
        }

        $current_element = site_structure;
        foreach ($nodes as $node) {
            if (is_array($current_element)) {
                if (array_key_exists($node, $current_element)) {
                    $current_element = $current_element[$node];
                } else {
                    return false; #To do: 404er einbauen
                }
            } elseif (is_string($current_element)) {
                require($current_element);
            }
        }
    }
}