<?php
namespace model\game\chess\parser;
class VectorStringTranslation
{
    static public function vectorToString(array $vector)
    {
        return implode('-', $vector);
    }

    static public function stringToVector(str $string)
    {
        return explode('-', $string);
    }
}