<?php

namespace App\DataTables\Admin;

use App\Models\MeetingInfo;
use Illuminate\Support\Collection;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\CollectionDataTable;


use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class MeetingInfoDataTable extends DataTable
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
            ->addColumn('action', function (Collection $model) {
                $id = $model->get('id');
              return view('pages.admin._meeting_info_action-menu', compact('id'));
            })
            ->editColumn('startDate', function(Collection $model){
                $d = $model->get('startDate');
                $rd = date("F jS, Y", strtotime($d));
                return $rd;
            })
            ->editColumn('hackStartDate', function(Collection $model){
                $d = $model->get('hackStartDate');
                $rd = date("F jS, Y", strtotime($d));
                return $rd;
            })
            ->editColumn('meetingCountry', function(Collection $model){
                $mc = $model->get('meetingCountry');
                $c = \App\Core\Data::getCountriesList();
                return $c[$mc]['name'];
            })
            ->editColumn('active', function (Collection $model) {
                if($model->get('active') == 1){
                    return 'Current';
                }else{
                    return 'Not-Active';
                };
            })
            ->rawColumns(['action']);

    }

    public function query(MeetingInfo $model)
    {
        //return User::all();
        $data = collect();

        $data = $model->get()->merge($data);

        $data = $data->map(function ($a) {
            return (collect($a))->only(['id', 'meetingNumber', 'meetingCity', 'meetingCountry', 'startDate', 'hackStartDate', 'active']);
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
            ->setTableId('meeting-info-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->stateSave(true)
            ->orderBy(0, 'desc')
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
            Column::make('meetingNumber')->title('Meeting #')->width(20),
            Column::make('meetingCity')->title('City')->width(50),
            Column::make('meetingCountry')->title('Country')->width(50),
            Column::make('startDate')->title('Start Date')->width(50),
            Column::make('hackStartDate')->title('Hackathon Start')->width(50),
            Column::make('active')->title('Current')->width(50),
            Column::computed('action')->width(190)
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

}
