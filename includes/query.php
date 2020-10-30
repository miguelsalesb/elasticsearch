<?php ob_start(); ?>

<?php require_once '.\vendor\autoload.php'; ?>


<?php

class Query {

// SEARCH

public static function queryES() {

    // Results from query to elasticsearch
    
    $client = Elasticsearch\ClientBuilder::create()->build();    
    
    $array = [];
    $array_search = static::indexes($array);

    // Get query data
    $query_search_array = $array_search[0];
    $query_search = implode("",$query_search_array);
    $fields_q = $array_search[1];


    // Get authors
    $authors_search_array = $array_search[2];
    $authors_search = implode("",$authors_search_array);

    $fields_authors = $array_search[3];

    if (strpos($authors_search, '+') !== false) {
        $au_type = 'cross_fields';
    } else {
        $au_type = 'phrase';
    }
 
    // Get mattype data
    $mattype_search_array = $array_search[4];
    $mattype_search = implode("",$mattype_search_array);

    $fields_mattype = $array_search[5];

    if(isset($_GET['ac'])) {
    $access_search = implode("",$array_search[6]);
        if ($access_search == "Free") {
            $access_search = "Livre";
        } else if ($access_search == "Internal") {
            $access_search = "Interno";
        }
    } else {
        $access_search = '';
    }
    $fields_access = $array_search[7];

    if (isset($_GET['dt_begin'])) {
        $date_begin = implode($array_search[8]);
    } else {
        $date_begin = null;
    }

    if (isset($_GET['dt_end'])) {
        $date_end = implode($array_search[10]);
    } else {
        $date_end = null;
    }    

    $query = $client->search([
        'index' => 'catalogo',
        'type' => '_doc',
        'from' => 0, 'size' => 10000,
                'body' => [
                    'query' => [
                        
                            "bool" => [
                                'must' => [
                                [ "query_string" => [ "query" => $query_search, "fields" => $fields_q
                                ] ]
                                ]
                                ,
                                 "filter" => [
                                     "bool" => [
                                         "should" => [
                                             "range" => [ 
                                                 "pubdate" => [ "gte" => $date_begin, "lte" => $date_end, "boost" => 2.0 ] ]
                                             ],
    
                                            'must' => [
                                                [ "multi_match" => [ "query" => $mattype_search, "fields" => $fields_mattype ] ]
                                             ]
                                                ,
                                                "filter" => [
                                                    "bool" => [                                            
                                                        'must' => [
                                                            [ "multi_match" => [ 
                                                                "query" => $authors_search, "fields" => $fields_authors
                                                                ,
                                                                'type' => $au_type,
                                                                'operator'=> 'and'
                                                                ] 
                                                            ]
                                                        ]                                         
                                                ,                                        
                                            
                                                'should' => [
                                                [ 
                                                    "multi_match" => [ 
                                                        "query" => $access_search, "fields" => $fields_access 
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
    
    ]);
        return $query;
    }


    public static function indexes($array) {

        // Get url from generate_url.php
        Url::generate();
        global $url_final;
    

        // Results from query to elasticsearch

        // $fields divided by: $fields_authores, $fields_mat_type, $fields_access, $fields_dates
        $fields_query = [];
        $fields_authors = [];
        $fields_mattype = [];
        $fields_access = [];
        $fields_pubdate = [];

        // $urlTerms = [] turns: $authors_search_terms, $mat_type_search_terms, $access_search_terms, $dates_search_terms
        $query_search = [];
        $authors_search = [];
        $mattype_search = [];
        $access_search = [];
        $begindate_search = [];
        $enddate_search = [];

        // Put url data in a array
        $url_explode = explode("&",$url_final);
    
        // Get index data from url
        foreach($url_explode as $index) {
            if (strpos($index, 'q') !== false) {
                $q = str_replace("q=","", $index);
            } else if (strpos($index, 'au') !== false) {
                $authors = str_replace("au=","", $index);
            } else if (strpos($index, 'mt') !== false) {
                $mattype_long = str_replace("mt=","", $index);
            } else if (strpos($index, 'ac') !== false) {
                $access = str_replace("ac=","", $index);
            } else if (strpos($index, 'dt_begin') !== false) {
                $date_begin = str_replace("dt_begin=","", $index);
            } else if (strpos($index, 'dt_end') !== false) {
                $date_end = str_replace("dt_end=","", $index);
            }
        }

        // Convert the mattype code to its description ('am to 'Livro')
        if (isset($mattype_long)) {
            $mattype_long = trim($mattype_long); // to cut the spaces
            if ($mattype_long == 'Iconographic material') {
                $mattype = 'km';
            } else if ($mattype_long == 'Cartographic material') {
                $mattype = 'em';
            } else if ($mattype_long == 'Periodical') {
                $mattype = 'as';
            } else if ($mattype_long == 'Book') {
                $mattype = 'am';
            } else if ($mattype_long == 'Manuscript') {
                $mattype = 'bm';
            } else if ($mattype_long == 'Sheet music') {
                $mattype = 'cm';
            } else if ($mattype_long == 'Booty') {
                $mattype = 'Esp.';
            }
        }

        // Remove stopwords
        $q_exploded = explode(" ",$_GET['q']);
        $stopwords= ['de','a','o','que','e','do','da','em','um','para','é','com','não','uma','os','no','se','na','por','mais','as','dos','como','mas','foi','ao','ele','das','tem','à','seu','sua','ou','ser','quando','muito','há','nos','já','está','eu','também','só','pelo','pela','até','isso','ela','entre','era','depois','sem','mesmo','aos','ter','seus','quem','nas','me','esse','eles','estão','você','tinha','foram','essa','num','nem','suas','meu','às','minha','têm','numa','pelos','elas','havia','seja','qual','será','nós','tenho','lhe','deles','essas','esses','pelas','este','fosse','dele','tu','te','vocês','vos','lhes','meus','minhas','teu','tua','teus','tuas','nosso','nossa','nossos','nossas','dela','delas','esta','estes','estas','aquele','aquela','aqueles','aquelas','isto','aquilo','estou','está','estamos','estão','estive','esteve','estivemos','estiveram','estava','estávamos','estavam','estivera','estivéramos','esteja','estejamos','estejam','estivesse','estivéssemos','estivessem','estiver','estivermos','estiverem','hei','há','havemos','hão','houve','houvemos','houveram','houvera','houvéramos','haja','hajamos','hajam','houvesse','houvéssemos','houvessem','houver','houvermos','houverem','houverei','houverá','houveremos','houverão','houveria','houveríamos','houveriam','sou','somos','são','era','éramos','eram','fui','foi','fomos','foram','fora','fôramos','seja','sejamos','sejam','fosse','fôssemos','fossem','for','formos','forem','serei','será','seremos','serão','seria','seríamos','seriam','tenho','tem','temos','tém','tinha','tínhamos','tinham','tive','teve','tivemos','tiveram','tivera','tivéramos','tenha','tenhamos','tenham','tivesse','tivéssemos','tivessem','tiver','tivermos','tiverem','terei','terá','teremos','terão','teria','teríamos','teriam'];
        $q_array = array_diff($q_exploded, $stopwords);
        $q_get = implode(" ",$q_array);

        if ( empty($_GET['q']) ) {
            $q = '*a*';
        } else if ( !empty($_GET['q']) && $q_get == "") {
            $q = null;
        } else if ( !empty($_GET['q']) && $q_get != "") {
            $q = $q_get;;
        } 
    
        
        $query = str_replace(" ","+",$q);
        array_push($query_search,$query);
        array_push($fields_query, '200.a^4', '200.e^3', '200.f^2', '200.g^2', '300.a^2','304.a^2','306.a^2', '307.a^2', '327.a', '330.a', '461.t', 'authors700','authors701','authors702', 'authors710', 'authors711', 'authors712', '720.a^1');
        
        if ( isset($authors) ) {
            array_push($authors_search, $authors);
            array_push($fields_authors, 'authors700','authors701','authors702');
        } else {
            $authors_search = [];
            $fields_authors = [];
        }

        if ( isset($mattype) ) {
            array_push($mattype_search, $mattype);
            array_push($fields_mattype, 'mattype' );
        } else {
            $mattype_search = [];
            $fields_mattype = [];        
        }
        if ( isset($access) ) {
            array_push($access_search, $access);
            array_push($fields_access, 'access' );
        } else {
            $access_search = [];
            $fields_access = [];        
        }
        if ( isset($date_begin) )  {
            array_push($begindate_search, $date_begin);
            array_push($fields_pubdate, 'pubdate' );
        } else {
            $begindate_search = [];
            $fields_pubdate = [];        
        }
        if ( isset($date_end) )  {
            array_push($enddate_search, $date_end);
            array_push($fields_pubdate, 'pubdate' );
        } else {
            $enddate_search = [];
            $fields_pubdate = [];        
        }

        $array = [$query_search,$fields_query,$authors_search,$fields_authors,$mattype_search,$fields_mattype,$access_search,$fields_access,$begindate_search,$fields_pubdate,$enddate_search,$fields_pubdate];

        return $array;
    }

}




