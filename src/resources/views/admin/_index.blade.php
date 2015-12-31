<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <a href="{{ route('admin.' . $module . '.create') }}" class="btn-add"><i class="fa fa-plus-circle"></i><span class="sr-only">New</span></a>
    <h1>
        <span>@{{ models.length }} @choice('news::global.news', 2)</span>
    </h1>

    @include('core::admin._tabs-lang-list')

    <div class="table-responsive">

        <table st-persist="newsTable" st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th st-sort="status" class="status st-sort">Status</th>
                    <th st-sort="image" class="image st-sort">Image</th>
                    <th st-sort="date" st-sort-default="reverse" class="date st-sort">Date</th>
                    <th st-sort="title" class="title st-sort">Title</th>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td>
                        <input st-search="title" class="form-control input-sm" placeholder="@lang('global.Search')…" type="text">
                    </td>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td typi-btn-delete action="delete(model)"></td>
                    <td>
                        @include('core::admin._button-edit')
                    </td>
                    <td typi-btn-status action="toggleStatus(model)" model="model"></td>
                    <td>
                        <img ng-src="@{{ model.thumb }}" alt="">
                    </td>
                    <td>@{{ model.date | dateFromMySQL:'dd/MM/yyyy' }}</td>
                    <td>@{{ model.title }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" typi-pagination></td>
                </tr>
            </tfoot>
        </table>

    </div>

</div>
