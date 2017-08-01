<?php
namespace errors;

#To Do chanhe error to extend Error and throw ,,,



class ErrorMessage {

    # # # # # # # # # # # #
    # Forbidden by config #
    # # # # # # # # # # # #

    # See /models/chess/arrays/NDimArrays
    /*
     * returns list: "Dimension of size $v is greater than the defi..." and error_level: bad
     *@v string!
     */
    public static function maxV($v){
        return ["Dimension of size $v is greater than the defined max dimension lenght at www/conf/conf.php: const MAX_V = " . MAX_V, ERROR_BAD];
    }

    # See /models/chess/arrays/NDimArrays
    /*
     * returns list: "$n_dim is greater than the defined max dimension ..." and error_level: bad
     *@n_dim string!
     */
    public static function maxDim($n_dim){
        return ["$n_dim is greater than the defined max dimension size at www/conf/conf.php: const max_n_dim = " . MAX_DIM , ERROR_BAD];
    }

    # # # # # # # # # # # #
    #        <=0          #
    # # # # # # # # # # # #

    # See /models/chess/arrays/NDimArrays
    /*
     * return ["Int: $v is zero or less", ERROR_BAD];
     *@v string or int or float
     */
    public static function zeroOrLess($v){
        return ["Int: $v is zero or less", ERROR_BAD];
    }


    # # # # # # # # # # # #
    #    Unkonwn Method   #
    # # # # # # # # # # # #

    # See /models/chess/arrays/NDimArrays
    /*
     * return ["Unknown Method. Method has to be ", error bad]
     *@method args of strings, floats, or ints
     */
    public static function unknownMethod(...$method) {
        return ["Unknown Method. Method has to be " . implode(', ', $method), ERROR_BAD];
    }

    # # # # # # # # # # # # # # # #
    # Method not yet implemented  #
    # # # # # # # # # # # # # # # #

    /**
     * @return array ["Method $method not yet implemented. Coming soon", ERROR_BAD];
     * @param string!
     */
    public static function methodNotYetImplemented($method) {
        return ["Method $method not yet implemented. Coming soon", ERROR_BAD];
    }

    # # # # # # # # # # #
    # Type declaration  #
    # # # # # # # # # # #

       /**
        * Summary of wrong_type
     * @param string|integer|float $right_type
     * @param string|integer|float $wrong_type
        * @return array
        */
    public static function wrongType($right_type, $wrong_type) {
           return ["$wrong_type is not suported. Please use $right_type", ERROR_BAD];
       }

    # # # # # # # # # # # #
    #        Dim          #
    # # # # # # # # # # # #
    /**
     * Summary of dim_not_matching
     * @param string|integer|float $right_dim
     * @param string|integer|float $wrong_dim
     * @return array
     */
    public static function dimNotMatching($right_dim, $wrong_dim) {
        return ["input is wring dim: $wrong_dim. Has to be excactly $right_dim", ERROR_BAD];
    }
}
