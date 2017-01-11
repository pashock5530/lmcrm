@extends('layouts.app')
{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>icon</th>
                        <th>date</th>
                        <th>name</th>
                        <th>phone</th>
                        <th>email</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                        <tr class="table-item" data-name="{!! $lead->name !!}" data-url="{!! route('agent.profile.data') !!}">
                            <td></td>
                            <td>{!! $lead->date !!}</td>
                            <td>{!! $lead->name !!}</td>
                            <td>{!! $lead->customer->phone !!}</td>
                            <td>{!! $lead->email !!}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">empty</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div id="response"></div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.table-item').click(function () {
                var item = $(this);
                var data = {
                    'name': item.data('name')
                };
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: item.data('url'),
                    type: 'post',
                    data: data,
                    dataType: 'html',
                    success: function (data) {
                        $('#response').html(data);
                    },
                    error: function (data) {

                    }
                });
            });
        });
    </script>
@endsection