<?php

namespace App\DataTables;

use App\Models\Transaksi\Aset;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class  AsetDataTable extends DataTable
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
                return view('transaksi.aset_action', compact('data'));
            })
            ->addColumn('price', function ($data) {
                $data->price = format_currency($data->price);
                return $data->price;
            })
            ->addColumn('residual_value', function ($data) {
                // $data->residual_value = format_currency($data->residual_value);
                return $data->residual_value;
            })
            ->addColumn('product_asset_id', function ($data) {
                // $data->residual_value = format_currency($data->residual_value);
                return $data->product->name;
            })
            ->rawColumns(["name", "action"])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Aset $model): QueryBuilder
    {
        return $model->newQuery()->with(['product']);
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
            ->orderBy([1, 'desc'])
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
            Column::make('purchase_date')->title("Tanggal Pembelian"),
            Column::make('name')->title("Nama"),
            Column::make('inventory_number')->title("No Iventaris"),
            Column::make('price')->title("Harga Perolehan")->addClass("align-right"),
            Column::make('residual_value')->title("Residu")->addClass("align-right"),
            Column::make('depreciation_period')->title("Lama Penyusustan"),
            Column::make('product_asset_id')->title("Golongan Aset"),
            Column::make('username')->title("Username"),

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
