<?php

namespace App\DataTables;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SchedulesDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('doctor_name', function (Schedule $schedule) {
                return $schedule->doctor->name; // Access doctor's name through the relationship
            })
            ->addColumn('action', function ($data) {
                $url = '/admin/schedules/';
                $buttons['view'] = true;
                $buttons['edit'] = true;
                $buttons['delete'] = true;

                return view('components.action-button', compact('data', 'url', 'buttons'))->render();
            })
            ->setRowId('id');
    }

    public function query(): QueryBuilder
    {
        return Schedule::query()
            ->select('schedules.*', 'doctors.name as doctor_name')
            ->join('doctors', 'schedules.doctor_id', '=', 'doctors.id');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('schedules-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('schedules.index')) // Ensure this is correct
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('add')->text('Create Doctor Schedule'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('doctor_name')
                ->title('Doctor Name')
                ->width(10),
            Column::make('day_of_week')->width(10),
            Column::make('start_time')->width(10),
            Column::make('end_time')->width(10),
            Column::make('appointment_duration')->width(10),
            Column::make('is_active')->width(10),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Schedules_'.date('YmdHis');
    }
}
