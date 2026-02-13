@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Preview Export File') }}</h5>
        </div>
        <div class="card-body">
            @if (!empty($data) && isset($data[0]))
            <div class="table-responsive"  id="scrollable-table">
                <table class="table  aiz-table mb-0">
                    <thead>
                        <tr>
                            @foreach ($data[0][0] as $header)
                                <th>{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data[0] as $key => $row)
                            @if ($key > 0)
                                <tr>
                                    @foreach ($row as $cell)
                                        <td>{{ $cell }}</td>
                                    @endforeach
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <p>{{ translate('No data available.') }}</p>
            @endif
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tableContainer = document.getElementById('scrollable-table');
            let isDown = false;
            let startX;
            let scrollLeft;

            tableContainer.addEventListener('mousedown', (e) => {
                isDown = true;
                tableContainer.classList.add('active');
                startX = e.pageX - tableContainer.offsetLeft;
                scrollLeft = tableContainer.scrollLeft;
            });

            tableContainer.addEventListener('mouseleave', () => {
                isDown = false;
                tableContainer.classList.remove('active');
            });

            tableContainer.addEventListener('mouseup', () => {
                isDown = false;
                tableContainer.classList.remove('active');
            });

            tableContainer.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - tableContainer.offsetLeft;
                const walk = (x - startX) * 3; //scroll-fast
                tableContainer.scrollLeft = scrollLeft - walk;
            });
        });
    </script>
@endsection
@section('style')
    <style>
        #scrollable-table {
            overflow-x: auto;
            cursor: grab;
        }

        #scrollable-table.active {
            cursor: grabbing;
        }
    </style>
@endsection
