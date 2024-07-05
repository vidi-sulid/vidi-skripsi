<?php

namespace App\DataTables;

use App\Models\Master\ProductAset;
use App\Models\Master\ProductSaving;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class   ProductSavingDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($data) {
                return view('master.saving_product_action', compact('data'));
            })
            ->addColumn('type', function ($data) {
                // $data->type = $data->type == "W" ? "Wajib" : "Detail";
                return $data->type;
            })
            ->addColumn('principal_deposit', function ($data) {
                return format_currency($data->principal_deposit);
            })
            ->addColumn('mandatory_deposit', function ($data) {
                return format_currency($data->mandatory_deposit);
            })
            ->rawColumns(["name", "action"])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductSaving $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('formdatatable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy([1, 'asc'])
            ->parameters([
                'responsive' => true,

            ])
            ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->addClass('align-middle'),
            Column::make('code')->title("Kode"),
            Column::make('name')->title("Nama"),
            Column::make('account_saving')->title("Rekening Simpanan"),
            Column::make('account_income_administration')->title("Rekening Pendapatan Administrasi"),
            Column::make('account_cost')->title("Rekening Biaya"),
            Column::make('type')->title("Jenis Simpanan"),
            Column::make('principal_deposit')->title("Simpanan Pokok"),
            Column::make('mandatory_deposit')->title("Simpanan Wajib"),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
