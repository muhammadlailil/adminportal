<?php
namespace Laililmahfud\Adminportal\Helpers;

use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Laililmahfud\Adminportal\Models\CmsImportLog;

class ImportExcel implements OnEachRow, WithHeadingRow, WithChunkReading, WithEvents
{
    protected $sessionId;
    protected $importStatus;
    protected $chunkSize = 100;

    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
        $this->importStatus = "success";
        $this->__init();
    }

    public function __init()
    {
    }

    public function onRow(Row  $row)
    {
        $index = $row->getIndex();

        $row = $row->toArray();
        $this->handle($row);
        $row['import_status'] = $this->importStatus;

        $this->putCollection($row);
        $this->progres($index);
    }

    public function handle(array  $row)
    {

    }

    public function chunkSize(): int
    {
        return $this->chunkSize;
    }

    /**
     * Import excel with progressbar : https://stackoverflow.com/questions/57927757/laravel-excel-upload-and-progressbar
     */
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $this->beforeImport();
                $totalRows = $event->getReader()->getTotalRows();
                if (filled($totalRows)) {
                    $totalRows = array_values($totalRows)[0];
                    $totalRows = $totalRows - 1;
                    cache()->forever("total_data_{$this->sessionId}", $totalRows);

                    CmsImportLog::whereId($this->sessionId)->update(['row_count' => $totalRows]);
                }
            },
            AfterImport::class => function (AfterImport $event) {
                $this->afterImport();
                $collection = cache("import_rows_{$this->sessionId}");

                CmsImportLog::whereId($this->sessionId)->update([
                    'complete_at' => date('Y-m-d H:i:s'),
                    'progres' => 100,
                    'data' => $collection
                ]);
                cache()->forget("import_rows_{$this->sessionId}");
                cache()->forget("total_data_{$this->sessionId}");
            },
        ];
    }

    public function beforeImport(){
    }
    public function afterImport(){
    }
    protected function putCollection($row)
    {
        $lastCollection = cache("import_rows_{$this->sessionId}") ?? [];
        $lastCollection[] = (object) $row;
        cache()->forever("import_rows_{$this->sessionId}", $lastCollection);
    }

    protected function progres($index){
        $totalData = cache("total_data_{$this->sessionId}");
        $progres = round($index / $totalData * 100);
        CmsImportLog::whereId($this->sessionId)->update([
            'progres' => $progres,
        ]);
    }
}
