@extends('layouts.app.app')

@section('content')
<div class="row">
    <div class="col-sm-12 d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">{{ __('messages.blog_news_list') }}</h3>
        <span class="badge bg-primary float-end" style="padding: 8px 12px; font-style: italic;">
            {{ __('messages.blog_news_desc') }}
        </span>
    </div>

    <div class="col-sm-12">
        <div class="card shadow-sm border-0">
            <div class="card-header card-border d-flex justify-content-between align-items-center bg-white py-3">
                <div>
                    <a href="{{ route('blog.new') }}">
                        <button type="button" class="btn btn-success min-btn me-2"><i class="bi bi-plus-circle me-1"></i>{{ __('messages.add_new') }}</button>
                    </a>
                    <button type="button" class="btn btn-primary min-btn editBlogBtn me-2"><i class="bi bi-pencil me-1"></i>{{ __('messages.edit') }}</button>
                    <button type="button" class="btn btn-danger min-btn delBlogBtn"><i class="bi bi-trash me-1"></i>{{ __('messages.delete') }}</button>
                </div>
                
                <div class="d-flex align-items-center">
                    <label for="filterStatus" class=" me-2 mb-0 fw-semibold text-secondary" style="white-space: nowrap;">{{ __('messages.status') }}</label>
                    <select id="filterStatus" class="form-select list-cmb status-cmb bg-light border-1" style="width: 200px;">
                        <option value="1" selected>{{ __('messages.active') }}</option>
                        <option value="0">{{ __('messages.passive') }}</option>
                    </select>
                </div>
                <div class="d-flex align-items-center">
                    <label for="filterType" class="me-2 mb-0 fw-semibold text-secondary" style="white-space: nowrap;">{{ __('messages.type') }}</label>
                    <select id="filterType" class="form-select list-cmb type-cmb bg-light border-1" style="width: 200px;">
                        <option value="0" selected>{{ __('messages.all') }}</option>
                        <option value="1">{{ __('messages.blog') }}</option>
                        <option value="2">{{ __('messages.news') }}</option>
                    </select>
                </div>
                
            </div>

            <div class="card-body">
                <table class="table table-striped table-bordered w-100" id="blogTable">
                    <thead>
                        <tr>
                            <th>{{ __('messages.title') }}</th>
                            <th>{{ __('messages.description') }}</th>
                            <th>{{ __('messages.type') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th width="250px">{{ __('messages.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
  <script type="text/javascript">
        var checkInterval = setInterval(function () {
            if (app.loader !== undefined && app.loader !== null) {
                app.loader.setModule("Blog");
                clearInterval(checkInterval);
            }
        }, 500);
    </script>
@endsection