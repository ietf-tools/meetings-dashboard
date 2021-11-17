<?php

namespace App\DataTables\Admin;

use App\Models\User;
use Illuminate\Support\Collection;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\CollectionDataTable;


use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class AdminUserDataTable extends DataTable
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
              return view('pages.admin._action-menu', compact('id'));
            })
            ->editColumn('username', function (Collection $model) {
                $fname = $model->get('first');
                $lname = $model->get('last');
                $name = "$fname $lname";
                return $name;
            })
            ->editColumn('admin', function (Collection $model) {
                if($model->get('admin') == 1){
                    return 'Admin';
                }else{
                    return 'User';
                };
            })
            ->rawColumns(['action']);

    }

    public function query(User $model)
    {
        //return User::all();
        $data = collect();

        $data = $model->get()->merge($data);

        $data = $data->map(function ($a) {
            return (collect($a))->only(['id', 'name', 'first', 'last', 'email', 'admin']);
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
            ->setTableId('admin-user-table')
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
            Column::make('admin')->title('Role')->width(50),
            Column::computed('action')->width(150)
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

}
