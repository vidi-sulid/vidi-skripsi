<?php

namespace App\DataTables;

use App\Models\Transaksi\Journal;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request as HttpRequest;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class JournalDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'journal_delete_action')
            ->addColumn('date', function ($data) {
                return date("d-m-Y", strtotime($data->date));
            })->addColumn('rekening', function ($data) {
                return $data->rekening . "-" . $data->account->name;
            })->addColumn('debit', function ($data) {
                return number_format($data->debit);
            })->addColumn('credit', function ($data) {
                return number_format($data->credit);
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Journal $model, HttpRequest $request): QueryBuilder
    {
        $startDate = $request->dateStart ? $request->dateStart : date('Y-m-d');
        $endDate = $request->dateEnd ? $request->dateEnd : date('Y-m-d');

        $result = $model->newQuery()->whereBetween('date', [$startDate, $endDate])->with(['account'])->orderBy('id');
        $request->session()->put('data', $result->get());

        return $result;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('journal-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->orderBy(2, 'asc')
            ->orderBy(4)
            ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('invoice'),
            Column::make('date')->title("Tanggal"),
            Column::make('rekening'),
            Column::make('description')->title("Keterangan"),
            Column::make('debit'),
            Column::make('credit'),
            Column::make('created_by')->title("Username"),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Journal_' . date('YmdHis');
    }
}