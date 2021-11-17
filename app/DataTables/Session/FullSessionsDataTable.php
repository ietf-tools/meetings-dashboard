<?php

namespace App\DataTables\Session;

use App\Models\Session;
use Illuminate\Support\Collection;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\CollectionDataTable;


use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class FullSessionsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query  Results from query() method.
     *
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->collection($query)
            ->editColumn('parent', function (Collection $model) {
                $id = $model->get('id');
                $title = $model->get('parent');
                return '<a href="../sessions/'.$id.'/index">'.strtoupper($title).'</a>';
            })
            ->addColumn('action', function (Collection $model) {
                $id = $model->get('id');
              return view('pages.sessions._action-menu', compact('id'));
            })
            ->rawColumns(['action', 'parent']);

    }

    public function query(Session $model)
    {

        $data = collect();

        $data = $model->sessionParentList()->merge($data);

        $data = $data->map(function ($a) {
            return (collect($a))->only(['id', 'parent', 'description']);
        });

        return $data;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('full-sessions-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->stateSave(true)
            ->orderBy(0)
            ->responsive()
            ->autoWidth(false)
            ->parameters(['scrollX' => true])
            ->addTableClass('align-middle table-row-dashed fs-6 gy-5');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('parent')->title('Session Name')->width(90),
            Column::make('description')->title('Description')->width(100),
            Column::computed('action')->width(150)
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

}
