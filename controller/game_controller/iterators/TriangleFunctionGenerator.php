<?php
namespace controller\game_controller\iterators;
#To Do: Documentation
#To Do: Write an trait for this basic iterators
class TriangleFunctionGenerator  extends NDimSquareFunctionGenerator
{
    /** To Do: Only Change phpDoc in child class?
     * TriangleFunctionGenerator constructor.
     * /\/\/\/\/\/\/\/\/\/\/\/\/\/\/\
     * @param array ...$input as many arrays in the form of [$upper_limit, $lower_limit, int $wavelength, int $phase]
     */

    # # # # # # # # # # #
    # Public Generators #
    # # # # # # # # # # #

    /** generate Cycle()
     * generates one Cycle of values, afterward false
     * @return array(phase=>value)|bool
     */

    /** generateWave()
     * generates values as long as asked for
     * @return array(phase=>value)
     */

    /** getStateAtPhase()
     * calculates value at given phase
     * @param int $phase XOR none, which results in current
     * @return array(phase=>value)
     */
    public function getStateAtPhase($input_phase = 'current'): array
    {
        $return_array = parent::getStateAtPhase($input_phase);
        $return_value = \controller\Math\VectorMath::add2ndLevel($return_array);
        $input_phase = $input_phase == 'current' ? $this->phase : $input_phase;
        return array($input_phase => $return_value);
    }

    # # # # # # # # # # # # # # #
    # protected actual iterator #
    # # # # # # # # # # # # # # #

    #Will call parent or self?
}