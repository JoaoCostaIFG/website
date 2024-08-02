<?php

namespace App\Http\Controllers;

class IdenticonsController extends Controller
{
    public function show(string $input, int $quality = 6)
    {
        $img = $this->genIdenticon($input, $quality, 20);

        return response($img)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'max-age=86400')
            ->header('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
    }

    private function genIdenticon(string $input, int $quality, int $size)
    {
        $hashed = str_split(hash('sha512', $input, true)); // output in binary format
        $hashed = array_map(fn ($hex): int => ord($hex), $hashed); // convert binary to decimal (integer)

        // create a blank image
        $img_size = $quality * $size;
        $img = imagecreatetruecolor($img_size, $img_size);
        $bg_color = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);
        imagefill($img, 0, 0, $bg_color);

        // color to fill
        $color = imagecolorallocate($img, $hashed[0], $hashed[1], $hashed[2]);
        $hashed = array_slice($hashed, 3); // skip rgb bytes of the hash

        // we only consider half of the cells and then mirror the image => better symmetry
        $modulos = intdiv(pow($quality, 2), 2);

        foreach ($hashed as $index => $hex) {
            $idx1 = $index % $modulos;
            // idx2 is idx1 mirrored vertically (in the x-axis)
            $row = intdiv($idx1, $quality);
            $idx2 = $idx1 + ($quality - 1 - (2 * $row)) * $quality;
            // if the hash byte is even => erase the cell. Otherwise, fill the cell.
            $c = ($hex % 2 == 0) ? $bg_color : $color;
            foreach ([$idx1, $idx2] as $idx) {
                $x = intdiv($idx, $quality) * $size;
                $y = ($idx % $quality) * $size;
                imagefilledrectangle($img, $x, $y, $x + $size - 1, $y + $size - 1, $c);
            }
        }

        // return image and free mem
        imagepng($img);
        $ret = ob_get_contents();
        ob_end_clean();
        imagedestroy($img);

        return $ret;
    }
}
