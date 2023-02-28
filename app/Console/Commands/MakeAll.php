<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:all {name} {--col=} {--namespace=} {--blade} {--controller} {--model} {--blade} {--datatable} {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model = $this->argument('name');
        $name = strtolower($this->argument('name'));
        $cols = explode(',', $this->option('col'));
        $namespace = (!empty($this->option('namespace'))) ? 'namespace App\Http\Controller\Admin\\' . $this->option('namespace') . ';' : 'namespace App\Http\Controller\Admin;';


        if (!empty($this->option('model'))) {
            Artisan::call('make:model ' . $model . '-m');
        }

        $datatableFile = "<?php

        namespace App\Datatable;

        use App\Models\\.$model;
        use Yajra\DataTable\Html\Button;
        use Yajra\DataTable\Html\Column;
        use Yajra\DataTable\Html\Editor\Editor;
        use Yajra\DataTable\Html\Editor\Fields;
        use Yajra\DataTable\Services\DataTable;

        class " . $model . "DataTable extends DataTable
        {
            /**
            * Build DataTable class.
            *
            * @param mixed \$query Results from query() method.
            * @return \Yajra\DataTables\DataTableAbstract
            */

            public function dataTable(\$query)
            {
                return datatables()
                    ->eloquent(\$query)
                    ->addColumn('action', function(\$value){
                        \$edit_route = route('admin." . $name . "s.edit', $\value->id);
                        \$edit_callback = 'setValue';
                        \$modal = '#edit-$name-modal';
                        \$delete_route = route('admin." . $name . "s.destroy',\$value->id);
                        return view('content.table-component.action',compact('edit_route', 'edit_callback','modal','delete_route'));
                    })
                    ->editColumn('created_at', function(\$data){
                        return '<span class=\"badge badge-light-primary\">'.date(\"M jS, Y h:i A\",strtotime(\$data->created_at)).'</span>';
                    })";

                        if (in_array('image', $cols)) {
                         $datatableFile .= "->editColumn('image',function(\$data){
                            \$image = \$data->image ?? 'images/avatar/1-small.png';
                            return view('content.table-component.avatar', compact('image'));
                        })";
                            }

                        $datatableFile .= "->addColumn('status',function(\$data){
                        \$route = route('admin." . $name . "s.status');
                        return view('content.table-component.switch',compact('data','route'));
                    })
                    ->escapeColumns('created_at','action');
                }

                /**
                 * Get query source of dataTable.
                 *
                 * @param \App\Models\\$model \$model
                 * @return \Illuminate\Database\Eloquent\Builder
                 */

                 public function query($model \$model)
                 {
                    return \$model->newQuery();
                 }

                 /**
                * Optional method if you want to use html builder.
                *
                * @return \Yajra\DataTables\Html\Builder
                */

                public function html()
                {
                    return \$this->builder()
                        ->setTableId('$name-table')
                        ->columns(\$this->getColumns())
                        ->minifiedAjax()
                        ->dom('Bfrtip')
                        ->orderBy(0)
                        ->searchDelay(1000)
                        ->parameters([
                            'scrollX' => true , 'paging' => true,
                            'searchDelay => 350,
                            'lengthMenu' => [
                                [10,25,50,-1],
                                ['10 rows','25 rows','50 rows','Show all']
                            ],
                        ])
                        ->buttons(
                            Button::make('csv),
                            Button::make('excel'),
                            Button::make('print'),
                            Button::make('pageLength'),
                        );
                }
                /**
                 * Get columns.
                 *
                 * @return array
                 */
                protected function getColumns()
                {
                    return [
                        Column::make('id')";
        foreach ($cols as $key => $c) {
            $datatableFile .= "Column::make('$c')";
        }

        $datatableFile .= "
                        Column::make('created_at'),
                        Column::computed('action')
                                ->exportable(false)
                                ->printable(false)
                                ->width(60),
                                ->addClass('text-center),
                        Column::computed('status')
                                ->exportable(false)
                                ->printable(false)
                                ->width(60)
                                ->addClass('text-center')
                    ];
                }
                /**
                * Get filename for export.
                *
                * @return string
                */

                public function filename()
                {
                    return '" . $model . "._' .date('YmdHis');
                }
        }";

        $controller = "<?php
        $namespace
        use Hash;
        use App\Models\\".$model . ";
        use Illuminate\Http\Request;
        use App\DataTable\\".$model ."DataTable;
        use App\Http\Controllers\Controller;

        class  
    }
}
