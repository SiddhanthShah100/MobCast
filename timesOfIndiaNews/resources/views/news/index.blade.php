@extends('layouts.app')

@section('styles')
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9ecef;
            color: #212529;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #007bff;
        }

        .news-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .news-table th, .news-table td {
            padding: 15px;
            text-align: left;
            vertical-align: middle;
            border-bottom: 1px solid #dee2e6;
        }

        .news-table th {
            background-color: #007bff;
            color: #fff;
            font-weight: 600;
        }

        .news-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .news-table a {
            color: #007bff;
            text-decoration: none;
        }

        .news-table a:hover {
            text-decoration: underline;
        }

        .news-table img {
            max-width: 200px;
            height: auto;
            border-radius: 5px;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pagination-links {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .pagination-links li {
            display: inline-block;
            margin-right: 8px;
        }

        .pagination-links li a {
            color: #007bff;
            text-decoration: none;
            border: 1px solid #007bff;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        .pagination-links li a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .pagination-links .active a {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
            cursor: default;
        }

        .search-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .search-container input[type=text] {
            padding: 8px;
            margin-right: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .filter-select {
            padding: 8px;
            margin-right: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .highlight {
            background-color: yellow;
            font-weight: bold;
        }


        @media (max-width: 768px) {
            .news-table th, .news-table td {
            text-align: left;
            vertical-align: middle;
            border-bottom: 1px solid #dee2e6;
            border: 2px solid;
            font-size: xx-small;
            }

        .container{
            background-color: #fff;
            /* width: fit-content; */
            padding: 0;
            margin-top: 0;
            box-shadow: none;
        }

        .news-table img {
            max-width: 150px;
            height: auto;
            border-radius: 5px;
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #007bff;
        }  

        .search-container{
            padding: 10px;
        }

        }

    </style>
@endsection

@section('content')
<div class="container">
    <h1 class="mt-5">Times Of India</h1>
    
    <div class="search-container">
        <form method="GET" action="{{ route('news.index') }}">
            <input type="text" name="search" id="searchInput" placeholder="Search..." value="{{ request('search') }}">
            <select name="sortBy" id="sortBy" class="filter-select">
                <option value="title" {{ request('sortBy') == 'title' ? 'selected' : '' }}>Sort by Title</option>
                <option value="pubDate" {{ request('sortBy') == 'pubDate' ? 'selected' : '' }}>Sort by Published Date</option>
            </select>
            <button type="submit" class="btn btn-primary">Apply</button>
        </form>
    </div>
    
    <table id="newsTable" class="news-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Link</th>
                <th>Published Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($news as $item)
            <tr>
                <td data-label="Title">{{ $item['title'] }}</td>
                <td data-label="Description">{!! $item['description'] !!}</td>
                <td data-label="Link"><a href="{{ $item['link'] }}" target="_blank">Read more</a></td>
                <td data-label="Published Date">{{ \Carbon\Carbon::parse($item['pubDate'])->format('d M Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="pagination">
        <ul class="pagination-links">
            @if ($news->onFirstPage())
                <li class="disabled"><span>&laquo; Previous</span></li>
            @else
                <li><a href="{{ $news->previousPageUrl() }}" rel="prev">&laquo; Previous</a></li>
            @endif

            @for ($i = 1; $i <= $news->lastPage(); $i++)
                <li class="{{ ($news->currentPage() == $i) ? 'active' : '' }}">
                    <a href="{{ $news->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            @if ($news->hasMorePages())
                <li><a href="{{ $news->nextPageUrl() }}" rel="next">Next &raquo;</a></li>
            @else
                <li class="disabled"><span>Next &raquo;</span></li>
            @endif
        </ul>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        function highlight(text, query) {
            var regex = new RegExp('('+ query +')', 'gi');
            return text.replace(regex, '<span class="highlight">$1</span>');
        }

        var searchQuery = '{{ request('search') }}'.toLowerCase();
        if (searchQuery) {
            $('#newsTable tbody tr').each(function() {
                var row = $(this);
                row.find('td').each(function() {
                    var cell = $(this);
                    var cellText = cell.text();
                    var cellHtml = cell.html();
                    cell.html(cellHtml.replace(/<span class="highlight">(.*?)<\/span>/gi, '$1'));
                    if (cellText.toLowerCase().indexOf(searchQuery) > -1) {
                        cell.html(highlight(cellText, searchQuery));
                    }
                });
            });
        }
    });
</script>
@endsection
