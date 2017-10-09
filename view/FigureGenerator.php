<?php
/**
 * Created by PhpStorm.
 * User: Philip Röggla
 * Date: 26.08.2017
 * Time: 15:16
 */

namespace view;


class FigureGenerator
{
    protected $black_color = '#000';
    protected $white_color = '#fff';
    protected $current_color;

    protected $white_border_width = '2px';
    protected $black_border_width = '0px';
    protected $current_width;

    protected $height;

    public function __construct($height)
    {
        $this->height = $height;
    }

    public function get($name, string $type, int $color)
    {
        $this->current_color = $color === 0 ? $this->white_color : $this->black_color;
        $this->current_width = $color === 1 ? $this->white_border_width : $this->black_border_width;
        $color = $color === 0 ? 'white' : 'black';
        switch ($type) {
            case 'king':
                return $this->king($name, $color);
                break;

            case 'queen':
                return $this->queen($name, $color);
                break;

            case 'rook':
                return $this->rook($name, $color);
                break;

            case 'knight':
                return $this->knight($name, $color);
                break;
            case 'bishop':
                return $this->bishop($name, $color);
                break;

            case 'pawn':
                return $this->pawn($name, $color);
                break;
        }
    }

    public function header($name, $color)
    {
        $combined_name = $name;

        $output_svg = <<<SVG
<svg style="height: {$this->height}px;" id="$combined_name" class="cls-1 $color" data-name="$combined_name" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.12 75.57">
    <title> $combined_name</title>

SVG;
        return $output_svg;

    }
    public function king($name, $color)
    {

        $header = $this->header($name, $color);

        $output_svg = <<<SVG
        $header
    <polygon class="cls-1 $color"  points="33.61 10.29 31.4 26.22 7.72 26.22 5.51 10.29 17.55 10.29 17.55 6.66 14.25 6.66 14.25 2.64 17.55 2.64 17.55 0 21.57 0 21.57 2.64 24.87 2.64 24.87 6.66 21.57 6.66 21.57 10.29 33.61 10.29"/>
    <path  class="cls-1 $color" d="M701,534.48v3.62H662.22v-3.62c6.29-5,10.6-12.32,9-24-.26-1.86-.85-7.58-1.15-9.7l11.54.09,11.69-.2c-.3,2.12-1.06,8-1.31,9.81C690.39,522.16,694.69,529.48,701,534.48Z" transform="translate(-662.04 -472.43)"/>
    <rect class="cls-1 $color"  y="67.92" width="39.12" height="7.65"/>

</svg>
SVG;
        return $output_svg;

    }

    public function queen($name, $color)
    {
        $header = $this->header($name, $color);

        $output_svg = <<<SVG
        $header
    <path class="cls-1 $color"  d="M698.9,533.48v3.62H663.11v-3.62c5.81-5,9.78-12.32,8.31-24-.24-1.86-.79-7.58-1.06-9.7l10.66.09,10.8-.2c-.28,2.12-1,8-1.21,9.81C689.13,521.16,693.1,528.48,698.9,533.48Z" transform="translate(-662.95 -474.07)"/>
    <rect class="cls-1 $color"  y="65.28" width="36.12" height="7.65"/>
    <polygon class="cls-1 $color"  points="31.03 13.65 28.99 23.58 7.13 23.58 5.08 13.65 16.2 4.02 16.2 0 19.91 0 19.91 4.02 31.03 13.65"/>
</svg>
SVG;
        return $output_svg;
    }

    public function rook($name, $color)
    {
        $header = $this->header($name, $color);

        $output_svg = <<<SVG
        $header
            <rect class="cls-1 $color"   y="53.47" width="37.6" height="6.53"/>
            <path class="cls-1 $color"  d="M659.18,529.43v4.12H621.92v-4.12c6.05-5.69,10.19-14,8.65-27.35-.25-2.11-2.3-8.64-2.59-11l12.58.1,12.57-.1c-.29,2.41-2.35,8.93-2.59,11C649,515.4,653.14,523.74,659.18,529.43Z" transform="translate(-621.75 -482)"/>
            <rect class="cls-1 $color"  x="6.16" width="5.14" height="7.03"/>
            <rect class="cls-1 $color"  x="12.87" width="5.14" height="7.03"/>
            <rect class="cls-1 $color"  x="19.59" width="5.14" height="7.03"/>
            <rect class="cls-1 $color"  x="26.3" width="5.14" height="7.03"/>
        </svg>
SVG;
        return $output_svg;

    }
    public function knight($name, $color)
    {
        $header = $this->header($name, $color);

        $output_svg = <<<SVG
        $header
            <rect class="cls-1 $color"  x="2.31" y="51.31" width="36.51" height="7.22"/>
            <path class="cls-1 $color"  d="M686.81,485.92c-1-.58-2.33-4.45-2.33-4.45l-3.19,5.14-2.53-4.74a24.17,24.17,0,0,0-2.94,5.78,31.69,31.69,0,0,1-2.76,2.56c-1.29,1.07-9.7,9.42-11.12,13.29-.7,1.91,3.2,5.38,4.75,5.22,2.87-.29,10.61-3.36,11.16-4.59.08-.18.33.17.18.3-9,7.74-13.82,25.41-13.82,25.41l36.51-.26c0-4.14-.11-8-.18-12.19-.08-5.44-.49-14.23-2.79-20.64C695.73,491,692.82,488.72,686.81,485.92Z" transform="translate(-661.86 -481.47)"/>
</svg>
SVG;
        return $output_svg;
    }

    public function bishop($name, $color)
    {
        $header = $this->header($name, $color);

        $output_svg = <<<SVG
        $header
            <rect class="cls-1 $color" y="63.71" width="29.43" height="5.53"/>
            <path class="cls-1 $color" d="M640.24,477.76c-1.14,0-2.78,1.09-4.42,3a.34.34,0,0,0-.08.23l.37,12.25c0,.39-1,.64-1.11.25l-.89-9.52a.27.27,0,0,0-.51-.12,24.69,24.69,0,0,0-3.5,12.47,32.61,32.61,0,0,0,.58,6.2l0,2.09c0,.17,19,.17,19,0l0-2.09a32.55,32.55,0,0,0,.58-6.21C650.38,486.05,643.18,477.76,640.24,477.76Z" transform="translate(-625.53 -477.76)"/>
            <path class="cls-1 $color" d="M648.09,514.28c.16-1.39,1.26-5.14,1.79-7.53H630.6c.53,2.39,1.63,6.14,1.79,7.53,1.2,10.73-2,17.46-6.8,22v3.32h29.31v-3.32C650.14,531.74,646.89,525,648.09,514.28Z" transform="translate(-625.53 -477.76)"/>
        </svg>
SVG;
        return $output_svg;
    }
    public function pawn($name, $color)
    {
        $header = $this->header($name, $color);

        $output_svg = <<<SVG
        $header
        <rect class="cls-1 $color" y="43.68" width="38.36" height="6.57"/>
        <path class="cls-1 $color" d="M642.47,487.76c3.78,2.77,10.63,8,10.41,9.63-2,13.83,0,17.31,6.18,25.42v5.87H621V522.8c6.18-8.1,8.16-11.59,6.19-25.42-.23-1.59,6.63-6.86,10.42-9.63" transform="translate(-620.86 -487.75)"/>
</svg>
SVG;
        return $output_svg;

    }


}