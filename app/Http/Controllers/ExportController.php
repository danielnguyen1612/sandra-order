<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use PDF;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $data = [
            'items' => $request->post('items'),
            'date'  => date('Y/m/d'),
        ];
        $pdf = PDF::loadView('pdf-view', $data);
        $date = date('Ymd');
        return $pdf->download("order_$date.pdf");
    }
}
