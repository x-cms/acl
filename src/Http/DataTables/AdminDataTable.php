<?php namespace Xcms\Acl\Http\DataTables;

use Xcms\Acl\Models\Admin;
use Xcms\Base\Http\DataTables\AbstractDataTables;
use Yajra\Datatables\Engines\CollectionEngine;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Engines\QueryBuilderEngine;

class AdminDataTable extends AbstractDataTables
{
    protected $model;

    public function __construct()
    {
        $this->model = Admin::select(['id', 'username', 'created_at']);
    }

    public function headings()
    {
        return [
            'id' => [
                'title' => 'ID',
                'width' => '5%',
            ],
            'username' => [
                'title' => 'Username',
                'width' => '20%',
            ],
            'created_at' => [
                'title' => 'Created at',
                'width' => '50%',
            ],
            'actions' => [
                'title' => '操作',
                'width' => '30%',
            ],
        ];
    }

    public function columns()
    {
        return [
            ['data' => 'id', 'name' => 'id', 'searchable' => false, 'orderable' => false],
            ['data' => 'username', 'name' => 'title'],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ];
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->setAjaxUrl(route('users.ajax'), 'POST');

        $this
            ->addFilter(1, form()->text('title', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('webed-core::datatables.search') . '...',
            ]));

        $this->withGroupActions([
            '' => trans('webed-core::datatables.select') . '...',
            'deleted' => trans('webed-core::datatables.delete_these_items'),
            'activated' => trans('webed-core::datatables.active_these_items'),
            'disabled' => trans('webed-core::datatables.disable_these_items'),
        ]);

        return $this->view();
    }

    /**
     * @return CollectionEngine|EloquentEngine|QueryBuilderEngine|mixed
     */
    protected function fetchDataForAjax()
    {
        return datatable()->of($this->model)
            ->rawColumns(['actions'])
            ->editColumn('id', function ($item) {
                return form()->customCheckbox([['id[]', $item->id]]);
            })
            ->editColumn('status', function ($item) {
                return html()->label(trans('webed-core::base.status.' . $item->status), $item->status);
            })
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $activeLink = route('users.update-status', ['id' => $item->id, 'status' => 'activated']);
                $disableLink = route('users.update-status', ['id' => $item->id, 'status' => 'disabled']);
                $deleteLink = route('users.destroy', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to(route('users.edit', ['id' => $item->id]), '编辑', ['class' => 'btn btn-sm btn-outline green']);
                $activeBtn = ($item->status != 'activated') ? form()->button('允许', [
                    'title' => '允许',
                    'data-ajax' => $activeLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline blue btn-sm ajax-link',
                    'type' => 'button',
                ]) : '';
                $disableBtn = ($item->status != 'disabled') ? form()->button('禁止', [
                    'title' => '禁止',
                    'data-ajax' => $disableLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline yellow-lemon btn-sm ajax-link',
                    'type' => 'button',
                ]) : '';
                $deleteBtn = form()->button('删除', [
                    'title' => '批量删除',
                    'data-ajax' => $deleteLink,
                    'data-method' => 'DELETE',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                    'type' => 'button',
                ]);

                return $editBtn . $activeBtn . $disableBtn . $deleteBtn;
            });
    }
}
