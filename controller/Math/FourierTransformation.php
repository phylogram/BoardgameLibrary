<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 14.08.2017
 * Time: 18:26
 */

namespace controller\Math;


class FourierTransformation
{
// !!! Warning: for reference, not debugged

###################################################################
# PHP_Fourier 0.03
# Original Fortran source by Numerical Recipies
# PHP port by Mathew Binkley (binkleym@nukote.com)
###################################################################

###################################################################
# Fourier($data, $sign) - Performs the FFT on the *complex*
# array $data
#
# Presumes that count($data) is an integer power of two
#
# $data[even] holds the real portion
# $data[odd] hold the imaginary portion
#
# Example: (1 + 2i) -> $data[0] = 1; $data[1] = 2;
#
# $sign = 1 performs the Fourier Transform
# $sign = -1 performs the Inverse Fourier Transform
#
# Use:
# $fourier_array = Fourier($inputarray, 1);
#
###################################################################

public static function Fourier($input, $isign) {

    #####################################################################
    # We need to shift the array up one because this script is a direct
    # port of the fortran program from NR. Should fix in future.
    #####################################################################
    $data[0] = 0;
    for ($i = 0; $i < count($input); $i++) $data[($i+1)] = $input[$i];

    $n = count($input);

    $j = 1;

    for ($i = 1; $i < $n; $i += 2) {
        if ($j > $i) {
            list($data[($j+0)], $data[($i+0)]) = array($data[($i+0)], $data[($j+0)]);
            list($data[($j+1)], $data[($i+1)]) = array($data[($i+1)], $data[($j+1)]);
        }

        $m = $n >> 1;

        while (($m >= 2) && ($j > $m)) {
            $j -= $m;
            $m = $m >> 1;
        }

        $j += $m;

    }

    $mmax = 2;

    while ($n > $mmax) { # Outer loop executed log2(nn) times
        $istep = $mmax << 1;

        $theta = $isign * 2*pi()/$mmax;

        $wtemp = sin(0.5 * $theta);
        $wpr = -2.0*$wtemp*$wtemp;
        $wpi = sin($theta);

        $wr = 1.0;
        $wi = 0.0;
        for ($m = 1; $m < $mmax; $m += 2) { # Here are the two nested inner loops
            for ($i = $m; $i <= $n; $i+= $istep) {

                $j = $i + $mmax;

                $tempr = $wr * $data[$j] - $wi * $data[($j+1)];
                $tempi = $wr * $data[($j+1)] + $wi * $data[$j];

                $data[$j] = $data[$i] - $tempr;
                $data[($j+1)] = $data[($i+1)] - $tempi;

                $data[$i] += $tempr;
                $data[($i+1)] += $tempi;

            }
            $wtemp = $wr;
            $wr = ($wr * $wpr) - ($wi * $wpi) + $wr;
            $wi = ($wi * $wpr) + ($wtemp * $wpi) + $wi;
        }
        $mmax = $istep;
    }

    for ($i = 1; $i < count($data); $i++) {
        $data[$i] *= sqrt(2/$n); # Normalize the data
        if (abs($data[$i]) < 1E-8) $data[$i] = 0; # Let's round small numbers to zero
        $input[($i-1)] = $data[$i]; # We need to shift array back (see beginning)
    }

    return $input;

}


}