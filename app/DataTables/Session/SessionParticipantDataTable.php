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

class SessionParticipantDataTable extends DataTable
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
        return datatables();

    }

    public function query($id)
    {
        $model = Session::where('id', $id);
        $data = collect();

        $data = $model->get()->merge($data);

        $data = $data->map(function ($a) {
            return (collect($a))->only(['id', 'username', 'email', 'city', 'state', 'country']);
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
            ->setTableId('session-participant-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->stateSave(true)
            ->orderBy(2)
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
            Column::make('username')->title('User Name')->width(90),
            Column::make('email')->title('Email')->width(125),
            Column::make('city')->title('City')->width(50),
            Column::make('state')->title('State')->width(50),
            Column::make('country')->title('Country')->width(50),
        ];
    }

}
