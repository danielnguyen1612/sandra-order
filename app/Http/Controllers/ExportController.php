<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Mpdf\Output\Destination;
use Illuminate\Support\Facades\Log;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $data = [
            'items' => $request->post('items'),
            'date'  => date('Y/m/d'),
        ];

        $date = date('Y-m-d');

        try {
            $mpdf = new Mpdf();
            $mpdf->debug = true;
            $view = view('pdf-view', $data)->render();
            $mpdf->WriteHTML($view);
            $fileName = implode('', ['order_', $date, '-', time(), '.pdf']);
            $mpdf->Output(
                public_path("orders/$fileName"),
                Destination::FILE
            );

            return response()->json([
                'success' => true,
                'file' => $fileName
            ]);
        } catch (MpdfException $e) {
            Log::error("Failed to generate PDF", [
                'exception' => $e,
            ]);
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
