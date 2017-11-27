<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/27/17
 * Time: 8:28 AM
 */

namespace eminent\Excel;

use Maatwebsite\Excel\Facades\Excel;

trait Excels
{
    public static function generateMultiExcelFromViewAndStore($data, $name, $views)
    {
        Excel::create($name, function($excel) use($data, $views) {

            if(!is_array($views))
            {
                foreach($data as $key => $value)
                {
                    $excel->sheet(Excels::trimText($key, 30, false), function($sheet) use($value, $views) {

                        $sheet->loadView($views, ['values' => $value]);

                    });
                }
            }
            else
            {
                $index = 0;

                foreach($data as $key => $value)
                {
                    $view = $views[$index];

                    $excel->sheet(Excels::trimText($key, 30, false), function($sheet) use($value, $view) {

                        $sheet->loadView($view, ['values' => $value]);
                    });

                    $index++;
                }
            }

        })->store('xlsx', storage_path('excels'));
    }

    public static function generateSingleExcelFromViewAndStore($data, $name, $views)
    {
        return Excel::create($name, function($excel) use($data, $views, $name) {

            if(!is_array($views))
            {
                $excel->sheet(Excels::trimText($name, 30, false), function($sheet) use($data, $views) {

                    $sheet->loadView($views, ['values' => $data]);

                });
            }
            else
            {
                $index = 0;

                $view = $views[$index];

                $excel->sheet(Excels::trimText($name, 30, false), function($sheet) use($data, $view) {

                    $sheet->loadView($view, ['values' => $data]);
                });

                $index++;
            }

        })->store('xlsx', storage_path('excels'), true);
    }


    private static function trimText($input, $length, $ellipses = true)
    {
        if (strlen($input) <= $length) {
            return $input;
        }

        $last_space = strrpos(substr($input, 0, $length), ' ');

        $trimmed_text = substr($input, 0, $last_space);

        if ($ellipses) {
            $trimmed_text .= '...';
        }

        return $trimmed_text;
    }
}