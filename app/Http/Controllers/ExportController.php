<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Mpdf\MpdfException;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $data = [
            'items' => $request->post('items'),
            'date'  => date('Y/m/d'),
        ];

        try {
            $mpdf = new Mpdf();
            $mpdf->debug = true;
            $view = view('pdf-view', $data)->render();
            $mpdf->WriteHTML($view);
            $mpdf->Output();
        } catch (MpdfException $e) {
            dd($e);
        }
    }
}
