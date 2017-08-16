<?php
namespace model\chess\arrays;

class NDimArrays
{
    # # # # # # # # # #
    # Basic Variables #
    # # # # # # # # # #

    protected $vector;          #The shape of the nested array. For exmple (2,1) -> [[Null], [Null]] and (1,1,1) -> [[[Null]]] - used for multiplication
    protected $pos_vector;      #vector -1 � for indexing
    protected $n_dim;           #The dimensionality of the $vector/it's lenght
    protected $skeleton;        #The empty array
    public $nested_array;    #the nested array with data or references in it
    protected $indexes;         #returns the indexes as array [index 0, index 1, ... , index n]

    # # # # # # # # # #
    #      Init       #
    # # # # # # # # # #


    /**
     * A convenience wrapper for n-dimensional nested arrays
     * @param string $method default 'empty' creates n * m * ... nested array, soon to come 'data' (from existing arrays)
     * @param array $data ignored when method not 'data', else used to construct nested_array
     * @param int[] $vector max number (MAX_DIM) defined at www/conf/conf.php: const MAX_DIM: Usually 16, defined at www/conf/conf.php: const MAX_V. No int can be 0 or less
     * @return object
     */
    public function __construct(int ...$vector)
    {

        $this->vector = $vector; #create the vector
        $this->pos_vector = $this->vector;
        array_walk($this->pos_vector, array('\\controller\\Math\\VectorMath', 'addScalar'), -1); #create the positional vector
        $this->testMaxV($this->vector); #test MAX_V

        $this->n_dim = sizeof($this->vector); #create number of dimensions
        $this->testNDim($this->n_dim); #test MAX_DIM

        #create the skeleton & the nested_array � in this case the same
        $this->skeleton = $this->emptyArray($this->vector);
        $this->nested_array = $this->skeleton;

        #create indexes #To Do: necessary?
        $n_dim_counter = 0;
        $this->indexes = array();
        foreach ($this->vector as $v) {
            $this->indexes[$n_dim_counter] = range(0, $v);
            $n_dim_counter += 1;
        };
    }

    # # # # # # # # # # # #
    # Protected functions #
    # # # # # # # # # # # #

    #For 'inner use' only, that is mostly __construct()
    /**
     * returns empty array of size x0 * x1 * ... * xn (in use for __construct)
     * @param array $vector
     * @return array (or False when error � now type hinting is ignored)
     */
    protected function emptyArray(array $vector)#: array
    {
        $inner_array = array_fill(0, array_shift($vector), NULL);
        foreach ($vector as $v) {
            $inner_array = array_fill(0, $v, $inner_array);
        }
        return $inner_array;
    }


    ###testing

    protected function testMaxV($vector)
    {
        foreach ($vector as $v) {
            if ($v > MAX_V) {
                trigger_error(...\errors\ErrorMessage::maxV($v));
                return false; #if dev environment
            }
            if ($v < 1) {
                trigger_error(...\errors\ErrorMessage::zeroOrLess($v));
                return false; #if dev environment
            }
        }
        return true;
    }

    protected function testNDim($n_dim)
    {
        if ($n_dim > MAX_DIM) {
            trigger_error(...\errors\ErrorMessage::maxDim($this->n_dim));
            return false; #if dev environment
        }
        return true;
    }

    # # # # # # # # # # #
    # Return Variables  #
    # # # # # # # # # # #

    /**
     * get_vector_value
     * @return array
     */
    public function getVector(): array
    {
        return $this->vector;
    }
    /**
     * get_pos_vector
     * @return array
     */
    public function getPosVector(): array
    {
        return $this->pos_vector;
    }

    /**
     * get_n_dim
     * @return integer the number of dimensions of the nested array as int
     */
    public function getNDim(): int
    {
        return $this->n_dim;
    }

    /**
     * get_skeleton
     * @return array empty array
     */
    public function getSkeleton(): array
    {
        return $this->skeleton;
    }
    /**
     * get_nested_array
     * @return array
     */
    public function getNestedArray(): array
    {
        return $this->nested_array;
    }


    # # # # # #
    # Select  #
    # # # # # #

    protected function &protected_select(array $position, $nested_array)
    {

    while (true) {
        if (count($position)<2) {
            return $nested_array[$position[0]];
            break;
        }
        $nested_array = $nested_array[array_pop($position)];
        $this->protected_select($position, $nested_array);
    }

    }

    public function &select(array $position, $method = 'skeleton')
    {
        switch ($method) {
            case 'skeleton':
                $nested_array = $this->skeleton;
                break;
            case 'nested_array':
                $nested_array = $this->nested_array;
                break;
            default:
                trigger_error(...\errors\ErrorMessage::unknownMethod($method, ERROR_BAD));
        }
       $this->testNDim(count($position));
       return $this->protected_select($position, $nested_array);

   }
}