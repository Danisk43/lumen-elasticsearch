<?php

namespace App\Http\Controllers;

use Elastica\Client;
use Elastica\Query;
use Elastica\Search;
use Elastica\Index;
use Elastica\MatchAll;
use Elastica;



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
        $index1 = $this->elasticaClient->getIndex($indexName);
        $search = new Search($this->elasticaClient);
        $query = new Query\MatchAll();
        // print_r($query) ;
        $search->addIndex($index1)->setQuery($query);
        $results = $search->search();
        $data = $results->getResults();
        // print_r($data);
        $result=array();
        $result = array_map(function($d) {
            return $d->getData();
        }, $data);

        $json = json_encode($result);

        return $json;
        // return response()->json($data);

        // $index = new Index($index1, 'test');
        // $type = new Type($index, 'doc');
        // $query_match = new MatchAll();
        // $query = new ConstantScore();
        // $query->setQuery($query_match);
        // $expectedArray = array('doc' => array('query' => $query_match->toArray()));
        // $this->assertEquals($expectedArray, $query->toArray());
        // $resultSet = $type->search($query);
        // $results = $resultSet->getResults();
        // echo $results;

        // $ids = '01';
        // $ids_filter = new Elastica\Query\Ids();
        // $ids_filter->setIds($ids);
        // $query = new Elastica\Query();
        // $query->setQuery($ids_filter);
        // $query->setFrom(0);
        // $query->setSize(100);
        // $query->setSource(array('id'));
        // $search = new Elastica\Search(app('elastic'));
        // $result = $search->addIndex('supply')->addType('supply')->search($query);
        // $ids = array();
        // foreach ($result as $item) {
        // array_push($ids, $item->getId());
        // }
        // echo $result;
        }
}
