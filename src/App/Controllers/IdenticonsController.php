<?php

namespace App\Controllers;

class IdenticonsController
{
  public static function show($input, $size)
  {
    header('Content-Type: image/png');
    IdenticonsController::genIdenticons($input, $size, 45);
  }

  public static function showDflt($input)
  {
    IdenticonsController::show($input, 6);
  }

  public static function genIdenticons($input_str, $quality, $size)
  {
    $hashed = str_split(hash("sha512", $input_str, true)); // output in binary format
    $hashed = array_map(fn ($hex): int => ord($hex), $hashed); // convert binary to decimal (integer)

    // Create a blank image
    $img_size = $quality * $size;
    $img = imagecreatetruecolor($img_size, $img_size);
    $bg_color = imagecolorallocate($img, 0xff, 0xff, 0xff);
    imagefill($img, 0, 0, $bg_color);

    // color to fill
    $color = imagecolorallocate($img, $hashed[0], $hashed[1], $hashed[2]);
    $hashed = array_slice($hashed, 3); # skip rgb bytes of the hash

    // we only consider half of the cells and then mirror the image => better symmetry
    $modulos = intdiv(pow($quality, 2), 2);

    foreach ($hashed as $index => $hex) {
      $idx1 = $index % $modulos;
      // idx2 is idx1 mirrored vertically (in the x-axis)
      $row = intdiv($idx1, $quality);
      $idx2 = $idx1 + ($quality - 1 - (2 * $row)) * $quality;
      // if the hash byte is even => erase the cell. Otherwise, fill the cell.
      $c = ($hex % 2 == 0) ? $bg_color : $color;
      foreach (array($idx1, $idx2) as $idx) {
        $x = intdiv($idx, $quality) * $size;
        $y = ($idx % $quality) * $size;
        imagefilledrectangle($img, $x, $y, $x + $size - 1, $y + $size - 1, $c);
      }
    }


    // Return image and free mem
    imagepng($img);
    imagedestroy($img);
  }
}
