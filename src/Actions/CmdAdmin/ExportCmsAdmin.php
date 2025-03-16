<?php
namespace Laililmahfud\Adminportal\Actions\CmdAdmin;

use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Models\CmsAdmin;


class ExportCmsAdmin
{
     public function handle(Request $request)
     {

          $items = CmsAdmin::with(['permission:id,name'])->get();
        
          $filePath = storage_path('app/public/temp/cms-admin.csv');

          // Open output stream for CSV
          $output = fopen($filePath, 'w');
          fputcsv($output, [
               'Name',
               'Email',
               'Privilege',
               'Status'
          ], ";");

          // Write the data to CSV
          foreach ($items as $row) {
               fputcsv($output, [
                    $row->name,
                    $row->email,
                    $row->permission?->name,
                    $row->status->label()
               ], ";");
          }

          // Close the output stream
          fclose($output);

          // Return the response with headers
          return response()->download($filePath)->deleteFileAfterSend(true);
     }
}