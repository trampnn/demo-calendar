@extends('voyager::master')

@section('page_title','Errorlogs')

@section('css')
<style>

    .pagination {
        margin: 0;
    }

    .pagination > li > a,
    .pagination > li > span {
        padding: 4px 10px;
    }

    .table-condensed > tbody > tr > td.stack,
    .table-condensed > tfoot > tr > td.stack,
    .table-condensed > thead > tr > td.stack {
        padding: 0;
        border-top: none;
    }

    .stack-content {
        padding: 8px;
        background-color: #F6F6F6;
        border-top: 1px solid #D1D1D1;
        color: #AE0E0E;
        font-family: consolas,sans-serif;
        font-size: 12px;
    }

    .info-box.level {
        display: block;
        padding: 0;
        margin-bottom: 15px;
        min-height: 70px;
        background: #fff;
        width: 100%;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        border-radius: 2px;
    }

    .info-box.level .info-box-text,
    .info-box.level .info-box-number,
    .info-box.level .info-box-icon > i {
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
    }

    .info-box.level .info-box-text {
        display: block;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .info-box.level .info-box-content {
        padding: 5px 10px;
        margin-left: 70px;
    }

    .info-box.level .info-box-number {
        display: block;
        font-weight: bold;
        font-size: 18px;
    }

    .info-box.level .info-box-icon {
        border-radius: 2px 0 0 2px;
        display: block;
        float: left;
        height: 70px; width: 70px;
        text-align: center;
        font-size: 40px;
        line-height: 70px;
        background: rgba(0,0,0,0.2);
    }

    .info-box.level .progress {
        background: rgba(0,0,0,0.2);
        margin: 5px -10px 5px -10px;
        height: 2px;
    }

    .info-box.level .progress .progress-bar {
        background: #fff;
    }

    .info-box.level-empty {
        opacity: .6;
        -webkit-filter: grayscale(1);
           -moz-filter: grayscale(1);
            -ms-filter: grayscale(1);
                filter: grayscale(1);
        -webkit-transition: all 0.2s ease-in-out;
           -moz-transition: all 0.2s ease-in-out;
             -o-transition: all 0.2s ease-in-out;
                transition: all 0.2s ease-in-out;
        -webkit-transition-property: -webkit-filter, opacity;
           -moz-transition-property: -moz-filter, opacity;
             -o-transition-property: filter, opacity;
                transition-property: -webkit-filter, -moz-filter, -o-filter, filter, opacity;
    }

    .info-box.level-empty:hover {
        opacity: 1;
        -webkit-filter: grayscale(0);
           -moz-filter: grayscale(0);
            -ms-filter: grayscale(0);
                filter: grayscale(0);
    }

    .level {
        padding: 2px 6px;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
        border-radius: 2px;
        font-size: .9em;
        font-weight: 600;
    }

    .badge.level-all,
    .badge.level-emergency,
    .badge.level-alert,
    .badge.level-critical,
    .badge.level-error,
    .badge.level-warning,
    .badge.level-notice,
    .badge.level-info,
    .badge.level-debug,
    .level, .level i,
    .info-box.level-all,
    .info-box.level-emergency,
    .info-box.level-alert,
    .info-box.level-critical,
    .info-box.level-error,
    .info-box.level-warning,
    .info-box.level-notice,
    .info-box.level-info,
    .info-box.level-debug {
        color: #FFF;
    }

    .label-env {
        font-size: .85em;
    }

    .badge.level-all, .level.level-all, .info-box.level-all {
        background-color: {{ log_styler()->color('all') }};
    }

    .badge.level-emergency, .level.level-emergency, .info-box.level-emergency {
        background-color: {{ log_styler()->color('emergency') }};
    }

    .badge.level-alert, .level.level-alert, .info-box.level-alert  {
        background-color: {{ log_styler()->color('alert') }};
    }

    .badge.level-critical, .level.level-critical, .info-box.level-critical {
        background-color: {{ log_styler()->color('critical') }};
    }

    .badge.level-error, .level.level-error, .info-box.level-error {
        background-color: {{ log_styler()->color('error') }};
    }

    .badge.level-warning, .level.level-warning, .info-box.level-warning {
        background-color: {{ log_styler()->color('warning') }};
    }

    .badge.level-notice, .level.level-notice, .info-box.level-notice {
        background-color: {{ log_styler()->color('notice') }};
    }

    .badge.level-info, .level.level-info, .info-box.level-info {
        background-color: {{ log_styler()->color('info') }};
    }

    .badge.level-debug, .level.level-debug, .info-box.level-debug {
        background-color: {{ log_styler()->color('debug') }};
    }

    .badge.level-empty, .level.level-empty {
        background-color: {{ log_styler()->color('empty') }};
    }

    .badge.label-env, .label.label-env {
        background-color: #6A1B9A;
    }
</style>
@stop

@section('content')
    <div class="page-content container-fluid">
        <h1 class="page-header">Logs</h1>

        {!! $rows->render() !!}

        <div class="table-responsive">
            <table class="table table-condensed table-hover table-stats">
                <thead>
                    <tr>
                        @foreach($headers as $key => $header)
                        <th class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                            @if ($key == 'date')
                                <span class="label label-info">{{ $header }}</span>
                            @else
                                <span class="level level-{{ $key }}">
                                    {!! log_styler()->icon($key) . ' ' . $header !!}
                                </span>
                            @endif
                        </th>
                        @endforeach
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($rows->count() > 0)
                        @foreach($rows as $date => $row)
                        <tr>
                            @foreach($row as $key => $value)
                                <td class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                    @if ($key == 'date')
                                        <span class="label label-primary">{{ $value }}</span>
                                    @elseif ($value == 0)
                                        <span class="level level-empty">{{ $value }}</span>
                                    @else
                                        <a href="{{ route('voyager.logs.filter', [$date, $key]) }}">
                                            <span class="level level-{{ $key }}">{{ $value }}</span>
                                        </a>
                                    @endif
                                </td>
                            @endforeach
                            <td class="text-right">
                                <a href="{{ route('voyager.logs.show', [$date]) }}" class="btn btn-xs btn-info">
                                    <i class="fa fa-search"></i>
                                </a>
                                <a href="{{ route('voyager.logs.download', [$date]) }}" class="btn btn-xs btn-success">
                                    <i class="fa fa-download"></i>
                                </a>
                                <a href="#delete-log-modal" class="btn btn-xs btn-danger" data-log-date="{{ $date }}">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="11" class="text-center">
                                <span class="label label-default">{{ trans('log-viewer::general.empty-logs') }}</span>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {!! $rows->render() !!}
    </div>
@endsection

@section('modals')
    {{-- DELETE MODAL --}}
    <div id="delete-log-modal" class="modal fade">
        <div class="modal-dialog">
            <form id="delete-log-form" action="{{ route('voyager.logs.delete') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="date" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">DELETE LOG FILE</h4>
                    </div>
                    <div class="modal-body">
                        <p></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-danger" data-loading-text="Loading&hellip;">DELETE FILE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(function () {
            var deleteLogModal = $('div#delete-log-modal'),
                deleteLogForm  = $('form#delete-log-form'),
                submitBtn      = deleteLogForm.find('button[type=submit]');

            $("a[href=#delete-log-modal]").on('click', function(event) {
                event.preventDefault();
                var date = $(this).data('log-date');
                deleteLogForm.find('input[name=date]').val(date);
                deleteLogModal.find('.modal-body p').html(
                    'Are you sure you want to <span class="label label-danger">DELETE</span> this log file <span class="label label-primary">' + date + '</span> ?'
                );

                deleteLogModal.modal('show');
            });

            deleteLogForm.on('submit', function(event) {
                event.preventDefault();
                submitBtn.button('loading');

                $.ajax({
                    url:      $(this).attr('action'),
                    type:     $(this).attr('method'),
                    dataType: 'json',
                    data:     { date : $("a[href=#delete-log-modal]").data('log-date') , '_token': $('input[name=_token]').val()},
                    success: function(data) {
                        submitBtn.button('reset');
                        if (data.result === 'success') {
                            deleteLogModal.modal('hide');
                            location.reload();
                        }
                        else {
                            alert('AJAX ERROR ! Check the console !');
                            console.error(data);
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        alert('AJAX ERROR ! Check the console !');
                        console.error(errorThrown);
                        submitBtn.button('reset');
                    }
                });

                return false;
            });

            deleteLogModal.on('hidden.bs.modal', function() {
                deleteLogForm.find('input[name=date]').val('');
                deleteLogModal.find('.modal-body p').html('');
            });
        });
    </script>
@endsection
