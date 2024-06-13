<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->get('https://timesofindia.indiatimes.com/rssfeeds/-2128838597.cms?feedtype=json');

            if ($response->successful()) {
                $data = $response->json();
                $items = $data['channel']['item'];

                $search = $request->input('search', '');
                if ($search) {
                    $items = array_filter($items, function ($item) use ($search) {
                        return stripos($item['title'], $search) !== false || stripos($item['description'], $search) !== false;
                    });
                }

                $sortBy = $request->input('sortBy', 'title');
                usort($items, function ($a, $b) use ($sortBy) {
                    return strcmp($a[$sortBy], $b[$sortBy]);
                });

                // $filterBy = $request->input('filterBy', '');
                // if ($filterBy) {
                //     $items = array_filter($items, function ($item) use ($filterBy) {
                //         return stripos($item['category'] ?? '', $filterBy) !== false;
                //     });
                // }

                $page = $request->input('page', 1);
                $perPage = 8;
                $offset = ($page - 1) * $perPage;
                $currentPageItems = array_slice($items, $offset, $perPage);

                $paginator = new LengthAwarePaginator($currentPageItems, count($items), $perPage, $page, [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]);

                return view('news.index', ['news' => $paginator, 'search' => $search, 'sortBy' => $sortBy]);
            } else {
                return response()->json(['error' => 'Failed to fetch news data'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
