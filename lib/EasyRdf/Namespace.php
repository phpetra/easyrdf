<?php

/**
  * A namespace registry and manipulation class.
  */
class EasyRdf_Namespace
{
    private static $_namespaces = array(
      'dc' => 'http://purl.org/dc/elements/1.1/',
      'foaf' => 'http://xmlns.com/foaf/0.1/',
      'rdfs' => 'http://www.w3.org/2000/01/rdf-schema#',
      'xsd' => 'http://www.w3.org/2001/XMLSchema#'
    );

    /**
      * Return a namespace given its prefix.
      *
      * @param string $short The namespace prefix (eg 'foaf')
      * @return string The namespace URI (eg 'http://xmlns.com/foaf/0.1/')
      */
    public static function get($short)
    {
        return self::$_namespaces[$short];
    }

    /**
      * Register a new namespace.
      *
      * @param string $short The namespace prefix (eg 'foaf')
      * @param string $long The namespace URI (eg 'http://xmlns.com/foaf/0.1/')
      */
    public static function add($short, $long)
    {
        self::$_namespaces[$short] = $long;
    }

    /**
      * Shorten a URI by substituting in the namespace prefix.
      *
      * @param string $uri The full URI (eg 'http://xmlns.com/foaf/0.1/name')
      * @return string The shortened URI (eg 'foaf_name')
      */
    public static function shorten($uri)
    {
        foreach (self::$_namespaces as $short => $long) {
            if (strpos($uri, $long) === 0) {
                return $short . '_' . substr($uri, strlen($long));
            }
        }
        return NULL;
    }

    /**
      * Expand a shorterned URI back into a full URI.
      *
      * @param string $short_uri The short URI (eg 'foaf_name')
      * @return string The full URI (eg 'http://xmlns.com/foaf/0.1/name')
      */
    public static function expand($short_uri)
    {
        if (preg_match("/^(\w+?)_(.+)$/", $short_uri, $matches)) {
            $long = self::get($matches[1]);
            if ($long) {
                return $long . $matches[2];
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }
    }
}