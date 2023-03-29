<?php

namespace App\Http\Controllers;

use Elastica\Client;
use Elastica\Query;
use Elastica\Search;
use Illuminate\Http\Request;

class ElasticsearchController extends Controller
{
    protected $elasticaClient;

    public function __construct(Client $elasticaClient)
    {
        $this->elasticaClient = $elasticaClient;
    }

    public function getData(Request $request, $indexName)
    {
        $index = $this->elasticaClient->getIndex($indexName);
        $search = new Search($this->elasticaClient);
        $query = new Query\MatchAll();
        $search->addIndex($index)->setQuery($query);
        $results = $search->search();
        $data = $results->getResults();
        return response()->json($data);
    }
}
