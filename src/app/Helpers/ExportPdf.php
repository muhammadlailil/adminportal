<?php
namespace Laililmahfud\Adminportal\Helpers;

use Barryvdh\DomPDF\Facade\Pdf;

class ExportPdf
{
    private static $papersize = 'Letter';
    private static $paperOrientation = 'portrait';
    private static $viewFile;
    private static $dataView;

    public static function paperSize($size='Letter'){
        self::$papersize = $size;
        return new static();
    }
    
    public static function paperOrientation($orientation='portrait'){
        self::$paperOrientation = $orientation;
        return new static();
    }

    public static function view($viewFile){
        self::$viewFile = $viewFile;
        return new static();
    }

    public static function data($data = []){
        self::$dataView = $data;
        return new static();
    }

    public static function download($filename)
    {
        $pdf = Pdf::loadView(self::$viewFile, [
            'data' => self::$dataView,
            'type' => 'pdf'
        ]);
        $pdf->setPaper(self::$papersize, self::$paperOrientation);
        return $pdf->download("{$filename}.pdf");
    }
}
