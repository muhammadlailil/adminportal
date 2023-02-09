<?php
namespace Laililmahfud\Adminportal\Helpers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportExcel implements FromView
{
    protected $view;
    protected $data;
    public function __construct($args){
        $this->view = $args['view'];
        $this->data = $args['data'];
    }

    public function view(): View
    {
        return view($this->view, [
            'data' => $this->data,
            'type' => 'excel'
        ]);
    }
}
