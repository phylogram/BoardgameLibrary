<?php
namespace controller\game_controller\arrays;

class PutFieldsOnArray
{
    /**
     * Summary of excecute
     * puts field with position vectors on each field
     * works on the array itself
     * wrapper for actual recursive method
     * @param \model\game\arrays\NDimArrays $array_object 
     */
    public static function execute(\model\game\arrays\NDimArrays &$array_object)
    {
    #To Do: Check if is instance of NDimArrays
        $n_dim = $array_object->getNDim();
        $pos_vector = $array_object->getPosVector();

        $position = array_fill(0,$n_dim, 0); #start at the beginning
        self::recursiveExecute($pos_vector, $n_dim-1, $array_object->nested_array, $position);
    }

    protected static function recursiveExecute(array $max_pos_vector, int $dim_pointer, array &$nested_array, array $position)
    {
        # Outer Loop

        if ($dim_pointer != 0) {
            while (true) {
                #go one level deeper
                self::recursiveExecute($max_pos_vector, $dim_pointer-1, $nested_array[$position[$dim_pointer]], $position);

               #update position
               $position[$dim_pointer] ++;

               #carry
               if ($position[$dim_pointer] > $max_pos_vector[$dim_pointer]) {
                   foreach(range($dim_pointer, 0, -1) as $dim) {
                       $position[$dim] = 0;
                   }
                   break;
               }
            }
        } elseif ($dim_pointer == 0) {

            # Inner Loop
            #To Do: Inner Loop does not work if len of inner array = 1

            while (true) {

                $nested_array[$position[0]] = new \model\game\fields\GameField($position); #put a field in me

                #carry
                if ($position[0] == $max_pos_vector[0]) {
                    break;
                }

                #update $position
                $position[0] ++;
            }
        }
        return $nested_array;
    }
}