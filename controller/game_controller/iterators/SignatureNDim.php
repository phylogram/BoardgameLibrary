<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 17.08.2017
 * Time: 16:51
 */

namespace controller\game_controller\iterators;


class SignatureNDim
{
    public $signatures = array();

    protected $dim;
    protected $phase;
    protected $wavelength;
    protected $half_wavelength;

    protected $sub_dimensions;
    protected $upperLimit;
    protected $lowerLimit;

    public function __construct(array $signatures, int $dim)
    {
        foreach ($signatures as $signature) {
            if (is_a($signature, '\controller\game_controller\iterators\Signature1Dim')) {
                $this->signatures[$signature->dim] = $signature;
            }
        }

        $this->dim = $dim;
        $this->phase = $signatures[0]->phase;

        $this->sub_dimensions = count($this->signatures);

        $this->upper_limit = \controller\Math\VectorMath::columnSum($signatures, 0); #To Do: This is in some cases wrong, for example wavelength 2 and phase 0/1
        $this->lower_limit = \controller\Math\VectorMath::columnSum($signatures, 1); #To Do: See upper limit

        $this->wavelength = \controller\Math\VectorMath::leastCommonMultipleOfArray(array_column($this->signatures, 2));
        $this->half_wavelength = intdiv($this->half_wavelength, 2);
    }

    /**
     * @return int
     */
    public function getDim(): int
    {
        return $this->dim;
    }

    /**
     * @return mixed
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * @return array
     */
    public function getSignatures(): array
    {
        return $this->signatures;
    }

    /**
     * @return int
     */
    public function getLowerLimit(): int
    {
        return $this->lower_limit;
    }

    /**
     * @return int
     */
    public function getUpperLimit(): int
    {
        return $this->upper_limit;
    }

    /**
     * @return int
     */
    public function getSubDimensions(): int
    {
        return $this->sub_dimensions;
    }

    /**
     * @return int
     */
    public function getWavelength(): int
    {
        return $this->wavelength;
    }

    /**
     * @return int
     */
    public function getHalfWavelength(): int
    {
        return $this->half_wavelength;
    }
}