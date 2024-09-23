<?php

namespace App\DataTables;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DoctorsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($data) {
                $url = '/admin/doctors/';
                $buttons['view'] = true;
                $buttons['edit'] = true;
                $buttons['delete'] = true;

                return view('components.action-button', compact('data', 'url', 'buttons'))->render();
            })
            ->setRowId('id');
    }

    public function query(Doctor $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('doctors-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('add'),
                Button::make('export'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('name')
                ->width(10),
            Column::make('address')
                ->width(10),
            Column::make('phone')
                ->width(10),
            Column::make('email')
                ->width(10),
            Column::make('status')
                ->width(10),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Doctors_'.date('YmdHis');
    }
}
