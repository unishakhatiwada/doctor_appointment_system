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
            ->filter(function ($query) {
                if (request()->has('search.value')) {
                    $searchValue = request('search.value');
                    // Enable searching by doctor name
                    $query->where(function ($query) use ($searchValue) {
                        $query->where('doctors.name', 'like', "%{$searchValue}%")
                            ->orWhere('schedules.day_of_week', 'like', "%{$searchValue}%");  // You can add more fields to search here
                    });
                }
            })
            ->addColumn('doctor_name', function (Schedule $schedule) {
                return $schedule->doctor->name; // Display doctor's name
            })
            ->addColumn('is_active', function (Schedule $schedule) {
                // Convert 0/1 to Yes/No
                return $schedule->is_active ? 'Yes' : 'No';
            })
            ->addColumn('action', function ($data) {
                $url = '/admin/schedules/';
                $buttons['edit'] = true;
                $buttons['delete'] = true;

                return view('components.action-button', compact('data', 'url', 'buttons'))->render();
            })
            ->setRowId('id')
            ->rawColumns(['is_active', 'action']);
    }

    public function query(): QueryBuilder
    {
        // Add select for doctor_name and allow the search for doctor_name
        return Schedule::query()
            ->select('schedules.*', 'doctors.name as doctor_name')  // Select doctor's name
            ->join('doctors', 'schedules.doctor_id', '=', 'doctors.id');  // Join with doctors table
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('schedules-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('schedules.index'))
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
                ->width(10)
                ->searchable(true),
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
