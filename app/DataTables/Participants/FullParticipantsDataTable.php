<?php

namespace App\DataTables\Participants;

use App\Models\Participant;
use App\Core\Data;
use Collator;
use Illuminate\Support\Collection;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\CollectionDataTable;


use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class FullParticipantsDataTable extends DataTable
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
            ->editColumn('username', function (Collection $model) {
                $id = $model->get('id');
                $username = $model->get('username');
                return '<a href="../participants/'.$id.'/index">'.strtoupper($username).'</a>';
            })
            ->editColumn('country', function (Collection $model){
                $g = $model->get('geoCode');
                if($g == 'Unknown GeoCode'){
                    $d = '? ? ?';
                    $flag = '???';
                    $country = 'UNK';
                }elseif($g == 'Unknown Country'){
                    $d = '? ? ?';
                    $flag = '???';
                    $country = 'UNK';
                }else{
                    $d = Data::getCountriesList();
                    $flag = $d[$g]['flag'];
                    $country = $d[$g]['name'];
                }

                return '<img class="w-15px h-15px rounded-1 ms-2" src="/media/'.$flag.'" alt="'.$country.'"/>  '.' '.$country;
            })
            ->editColumn('city', function (Collection $model){
                $c = $model->get('city');
                if($c == 'Washington'){
                    return 'Washington D.C.';
                }else{
                    return $c;
                }
            })
            ->addColumn('action', function (Collection $model) {
                $id = $model->get('id');
              return view('pages.participants._action-menu', compact('id'));
            })
            ->editColumn('status', function (Collection $model) {
                if($model->get('status') == 1){
                    return 'Online';
                }else{
                    return 'Offline';
                };
            })
            ->rawColumns(['action', 'username','country']);

    }

    public function query(Participant $model)
    {
        //return User::all();
        $data = collect();

        $data = $model->currentParticipants()->merge($data);

        $data = $data->map(function ($a) {
            return (collect($a))->only(['id', 'username', 'email', 'status', 'city', 'country', 'geoCode']);
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
            ->setTableId('full-participants-table')
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
            Column::make('city')->title('City')->width(75),
            Column::make('country')->title('Country')->width(75),
            Column::make('status')->title('Status')->width(50),
            Column::computed('action')->width(150)
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

}
