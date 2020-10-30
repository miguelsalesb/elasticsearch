<?php require_once('.\includes\header.php'); ?>

<?php

class Filters {

    function __construct(){ 

        if (isset($_GET['q'])) {
            global $results;
            $results = Query::queryES();
        }
    
    }


public static function getQuery() {

    // Handle authors links and authors filters
    if (!empty($_GET['q'])) {

        $_SESSION['sessions'] = array();
        array_push($_SESSION['sessions'], $_GET['q']);
    } 
    $session_string = implode($_SESSION['sessions']);

    if ( substr($session_string, 0, strpos($session_string, "&") ) ) {
        $session_value = substr($session_string, 0, strpos($session_string, "&"));
    } else {
        $session_value = $session_string;
    }

    $value = $session_value;
    return $value;
}


public static function getFilters() {

    if (isset($_GET['q'])) {

        // Results from query to elasticsearch
        global $results;

        // Complete query from url
        global $url_final;

        $session_value = self::getQuery();
        
        $array_sch = [];
        $array_search = Query::indexes($array_sch);

        // Get query data
        $query_search_array = $array_search[0];

        // Get authors
        $authors_search_array_implode = implode("+",$array_search[2]);
        $authors_search_array = explode("+",$authors_search_array_implode);

        // Get mattype data
        $mattype_search_array = $array_search[4];
        

        // Get access data
        $access_search_array = $array_search[6];
        
        // Local variables
        // Authors
        $authors_global = [];
        $field700_global = [];
        $field701_global = [];
        $field702_global = [];

        $authors = [];
        $field700 = [];
        $field701 = [];
        $field702 = [];

        // Materials type
        $mattypes_global = [];
        $mattypes = [];

        // Type of access
        $accesses_global = [];        
        $accesses = [];

        // Dates
        if (!empty($_GET['dt_begin'])) {
            $dt_begin = $_GET['dt_begin'];
        } else {
            $dt_begin = null;
        }

        if (!empty($_GET['dt_end'])) {
            $dt_end = $_GET['dt_end'];
        } else {
            $dt_end = null;
        }

        $authorNameA = '';
        $authorNameB = '';
            
        // Get page number from url
        if(isset($_GET['p'])) {
            $pag = $_GET['p'];
        } else {
            $pag = '1';
        }

        // Get all authors and material type        

            for ($r_global = 0; $r_global < count($results['hits']['hits']); $r_global++) {
                if(isset($results['hits']['hits'][$r_global]['_source']['966'])) {
                    $field966_global = $results['hits']['hits'][$r_global]['_source']['966'];
                }
                if (isset($results['hits']['hits'][$r_global]['_source']['authors700'])) {
                    $field700_global = $results['hits']['hits'][$r_global]['_source']['authors700'];    
                }
                if (isset($results['hits']['hits'][$r_global]['_source']['authors701'])) {
                    $field701_global = $results['hits']['hits'][$r_global]['_source']['authors701'];
                }
                if (isset($results['hits']['hits'][$r_global]['_source']['authors702'])) {
                    $field702_global = $results['hits']['hits'][$r_global]['_source']['authors702'];
                }
                if (isset($results['hits']['hits'][$r_global]['_source']['mattype'])) {
                    $mattype_global = $results['hits']['hits'][$r_global]['_source']['mattype'];    
                }            
                if (isset($results['hits']['hits'][$r_global]['_source']['access'])) {
                    $access_global = $results['hits']['hits'][$r_global]['_source']['access'];    
                } 
                if (isset($results['hits']['hits'][$r_global]['_source']['dt_begin'])) {
                    $date_begin_global = $results['hits']['hits'][$r_global]['_source']['dt_begin'];    
                }             
                if (isset($results['hits']['hits'][$r_global]['_source']['dt_end'])) {
                    $date_end_global = $results['hits']['hits'][$r_global]['_source']['dt_end'];    
                }             
                // Get authors from field 700    
                if (isset($results['hits']['hits'][$r_global]['_source']['authors700']) && !empty($results['hits']['hits'][$r_global]['_source']['authors700'])) {
                    for ($_700sub_global = 0; $_700sub_global < count($field700_global); $_700sub_global++) {
                        if (isset($field700_global[$_700sub_global])) {
                        array_push($authors_global, $field700_global[$_700sub_global]); 
                        }
                    }
                }      
                if (isset($results['hits']['hits'][$r_global]['_source']['authors701']) && !empty($results['hits']['hits'][$r_global]['_source']['authors701'])) {
                    for ($_701sub_global = 0; $_701sub_global < count($field701_global); $_701sub_global++) {
                        if (isset($field701_global[$_701sub_global])) {
                        array_push($authors_global, $field701_global[$_701sub_global]); 
                        }
                    }
                }  
                if (isset($results['hits']['hits'][$r_global]['_source']['authors702']) && !empty($results['hits']['hits'][$r_global]['_source']['authors702'])) {
                    for ($_702sub_global = 0; $_702sub_global < count($field702_global); $_702sub_global++) {
                        if (isset($field702_global[$_702sub_global])) {
                            array_push($authors_global, $field702_global[$_702sub_global]); 
                        }
                    }
                }      
                if (isset($results['hits']['hits'][$r_global]['_source']['authors710']) && !empty($results['hits']['hits'][$r_global]['_source']['authors710'])) {
                    for ($_710sub_global = 0; $_710sub_global < count($field710_global); $_710sub_global++) {
                        if (isset($field710_global[$_710sub_global])) {
                            array_push($authors_global, $field710_global[$_710sub_global]); 
                        }
                    }
                } 
                if (isset($results['hits']['hits'][$r_global]['_source']['authors711']) && !empty($results['hits']['hits'][$r_global]['_source']['authors711'])) {
                    for ($_711sub_global = 0; $_711sub_global < count($field711_global); $_711sub_global++) {
                        if (isset($field711_global[$_711sub_global])) {
                            array_push($authors_global, $field711_global[$_711sub_global]); 
                        }
                    }
                } 
                if (isset($results['hits']['hits'][$r_global]['_source']['authors712']) && !empty($results['hits']['hits'][$r_global]['_source']['authors712'])) {
                    for ($_712sub_global = 0; $_712sub_global < count($field712_global); $_712sub_global++) {
                        if (isset($field712_global[$_712sub_global])) {
                            array_push($authors_global, $field712_global[$_712sub_global]); 
                        }
                    }
                } 
                if (isset($results['hits']['hits'][$r_global]['_source']['mattype']) && !empty($results['hits']['hits'][$r_global]['_source']['mattype'])) {
                    if ( isset($mattype_global) && $mattype_global == 'km' ) {
                        $mat_type_global = 'Iconographic material';
                    } else if ( isset($mattype_global) && $mattype_global == 'em' ) {
                        $mat_type_global = 'Cartographic material';
                    } else if ( isset($mattype_global) && $mattype_global == 'as' ) {
                        $mat_type_global = 'Periodical';
                    } else if ( isset($mattype_global) && ( $mattype_global == 'am' || $mattype_global == 'ac' ) ) {
                        $mat_type_global = 'Book';
                    } else if ( isset($mattype_global) && $mattype_global == 'bm' ) {
                        $mat_type_global = 'Manuscript';
                    
                    } else if ( isset($mattype_global) && $mattype_global == 'cm' ) {
                        $mat_type_global = 'Sheet music';
                    
                    } else if ( isset($field966_global ) ){
                        for ($mat_global = 0; $mat_global < count($field966_global); $mat_global++) {
                            if ($field966_global[$mat_global] == 'Esp.') {
                                $mat_type_global = 'Booty';
                            }
                        }
                    } else {
                        $mat_type_global = 'Undefined material';
                    }
                    
                    array_push($mattypes_global, $mat_type_global); 
                }
                if (isset($results['hits']['hits'][$r_global]['_source']['access']) && !empty($results['hits']['hits'][$r_global]['_source']['access'])) {
                    if ( isset($access_global) && $access_global == 'Livre' ) {
                    array_push($accesses_global, 'Free'); 
                    } else if ( isset($access_global) && $access_global == 'Interno' ) {
                    array_push($accesses_global, 'Internal'); 
                    }
                }
                if (isset($results['hits']['hits'][$r_global]['_source']['dt_begin']) && !empty($results['hits']['hits'][$r_global]['_source']['dt_begin'])) {
                    if ( isset($date_begin_global) && !empty($date_begin_global) ) {
                        array_push($dt_begin_array , $date_begin_global); 
                    } 
                }     
                if (isset($results['hits']['hits'][$r_global]['_source']['dt_end']) && !empty($results['hits']['hits'][$r_global]['_source']['dt_end'])) {
                    if ( isset($date_end_global) && !empty($date_end_global) ) {
                        array_push($dt_end_array , $date_end_global); 
                    } 
                }            
            }

            // Get authors and material type from the page
            
            for ($r = ($pag - 1) * 20; $r < ($pag - 1) * 20 + 20; $r++) {    
                if(isset($results['hits']['hits'][$r]['_source']['966'])) {
                    $field966 = $results['hits']['hits'][$r]['_source']['966'];
                }
                if (isset($results['hits']['hits'][$r]['_source']['authors700'])) {
                    $field700 = $results['hits']['hits'][$r]['_source']['authors700'];    
                }
                if (isset($results['hits']['hits'][$r]['_source']['authors701'])) {
                    $field701 = $results['hits']['hits'][$r]['_source']['authors701'];
                }
                if (isset($results['hits']['hits'][$r]['_source']['authors702'])) {
                    $field702 = $results['hits']['hits'][$r]['_source']['authors702'];
                }
                if (isset($results['hits']['hits'][$r]['_source']['mattype'])) {
                    $mattype = $results['hits']['hits'][$r]['_source']['mattype'];    
                }            
                if (isset($results['hits']['hits'][$r]['_source']['access'])) {
                    $access = $results['hits']['hits'][$r]['_source']['access'];    
                } 
                if (isset($results['hits']['hits'][$r]['_source']['dt_begin'])) {
                    $dt_begin = $results['hits']['hits'][$r]['_source']['dt_begin'];    
                } 
                if (isset($results['hits']['hits'][$r]['_source']['dt_end'])) {
                    $dt_end = $results['hits']['hits'][$r]['_source']['dt_end'];    
                }             
                // Get authors from field 700    
                if (isset($results['hits']['hits'][$r]['_source']['authors700']) && !empty($results['hits']['hits'][$r]['_source']['authors700'])) {
                    for ($_700sub = 0; $_700sub < count($field700); $_700sub++) {
                        if (isset($field700[$_700sub])) {
                            array_push($authors, $field700[$_700sub]); 
                        }
                    
                    }
                }      
                if (isset($results['hits']['hits'][$r]['_source']['authors701']) && !empty($results['hits']['hits'][$r]['_source']['authors701'])) {
                    for ($_701sub = 0; $_701sub < count($field701); $_701sub++) {
                        if (isset($field701[$_701sub])) {
                            array_push($authors, $field701[$_701sub]); 
                        }
                    }
                }  
                if (isset($results['hits']['hits'][$r]['_source']['authors702']) && !empty($results['hits']['hits'][$r]['_source']['authors702'])) {
                    for ($_702sub = 0; $_702sub < count($field702); $_702sub++) {
                        if (isset($field702[$_702sub])) {
                            array_push($authors, $field702[$_702sub]); 
                        }
                    }
                }        
                if (isset($results['hits']['hits'][$r]['_source']['mattype']) && !empty($results['hits']['hits'][$r]['_source']['mattype'])) {
                    if ( isset($mattype) && $mattype == 'km' ) {
                        $mat_type = 'Iconographic material';
                    } else if ( isset($mattype) && $mattype == 'em' ) {
                        $mat_type = 'Cartographic material';
                    } else if ( isset($mattype) && $mattype == 'as' ) {
                        $mat_type = 'Periodical';
                    } else if ( isset($mattype) && ( $mattype == 'am' || $mattype == 'ac' ) ) {
                        $mat_type = 'Book';
                    } else if ( isset($mattype) && $mattype == 'bm' ) {
                        $mat_type = 'Manuscript';
                    } else if ( isset($mattype) && $mattype == 'cm' ) {
                        $mat_type = 'Sheet Music';
                    } else if ( isset($field966 ) ){
                        for ($mat = 0; $mat < count($field966); $mat++) {
                            if ($field966[$mat] == 'Esp.') {
                                $mat_type = 'Booty';
                            }
                        }
                    } else {
                        $mat_type = 'Undefined material type';
                    }
                    array_push($mattypes, $mat_type); 
                }
            
            if (isset($results['hits']['hits'][$r]['_source']['access']) && !empty($results['hits']['hits'][$r]['_source']['access'])) {
                if ( isset($access) && $access == 'Livre' ) {
                    array_push($accesses, 'Free'); 
                } else if ( isset($access) && $access == 'Interno' ) {
                    array_push($accesses, 'Internal'); 
                }
            }

            if (isset($results['hits']['hits'][$r_global]['_source']['dt_begin']) && !empty($results['hits']['hits'][$r_global]['_source']['dt_begin'])) {
                if ( isset($date_begin) && !empty($date_begin) ) {
                    array_push($dt_begin_array , $date_begin); 
                } 
            }     
            if (isset($results['hits']['hits'][$r_global]['_source']['dt_end']) && !empty($results['hits']['hits'][$r_global]['_source']['dt_end'])) {
                if ( isset($date_end) && !empty($date_end) ) {
                    array_push($dt_end_array , $date_end); 
                } 
            }     
        }


        // AUTHORS GLOBAL

        $authors_final_global = [];

        $counter = 0;

        for ($au_g = 0; $au_g < count($authors_global); $au_g++) {
            array_push($authors_final_global, $authors_global[$au_g]);
        }

        // Counts the number of authors
        $authorsCount_global = array_count_values($authors_final_global);

        // Authors without duplicates
        $uniqueAuthors_global = array_unique($authors_final_global, SORT_REGULAR);


        // Order by value (n.º of ocurrences)
        uasort($authorsCount_global, function($a, $b) {
            return $b <=> $a;
        });


        $authorsClicked_global = [];
        $arrayClickedAuts_global = [];
        $uniqueClickedAuthors_global = [];
        $authorsClicked_global = array_count_values($authors_search_array);
            
        //$uniqueClickedAuthors = array_unique($authorsClicked , SORT_REGULAR);
        ksort($authorsClicked_global);


        // MATTYPES

        $mattypes_final_global = [];

        foreach($mattypes_global as $mattype_global) {
            foreach($mattypes as $mattype) {
                if($mattype_global == $mattype) {
                    array_push($mattypes_final_global, trim($mattype_global));
                }
            }
        }


        // Counts the number of material types
        $mattypesCount_global = array_count_values($mattypes_global);

        // Material types without duplicates
        $uniqueMattypes_global = array_unique($mattypes_global, SORT_REGULAR);


        // Order by material type key
        ksort($mattypesCount_global);

        $mattypesClicked_global = [];
        $arrayClickedMts_global = [];
        $uniqueClickedMattypes_global = [];
        $mattypesClicked_global = array_count_values($mattype_search_array);
                    
        ksort($mattypesClicked_global);


        // ACCESS
        $accesses_final_global = [];
        foreach($accesses_global as $access_global) {
            foreach($accesses as $mattype) {
                if($mattype_global == $mattype) {
                    array_push($accesses_final_global, trim($access_global));
                }
            }
        }


        // Counts the number of accesses
        $accessesCount_global = array_count_values($accesses_global);

        // Accesses without duplicates
        $uniqueAccesses_global = array_unique($accesses_global, SORT_REGULAR);


        // Order by accesses key
        ksort($accessesCount_global);

        $accessesClicked_global = [];
        $arrayClickedAcc_global = [];
        $uniqueClickedAccessess_global = [];
        $accessesClicked_global = array_count_values($access_search_array);
                    
        ksort($accessesClicked_global);

    
        // Display mattypes filters   
        echo '<h4>Refine your search</h4>';
        if ( ( !isset($_GET['mt']) && !isset($_GET['remove_mt']) ) || ( !isset($_GET['mt']) && !isset($_GET['remove_mt']) && isset($_GET['au']) ) ) {
            echo '<div class="mattype-list"><p class="filter mattype">Material types</p><ul class="list">';
            foreach($mattypesCount_global as $material_type => $number) {
                echo '<li class="mattype_list"><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&mt=' . $material_type . '&p=1">' . $material_type . '</a><span class="parentheses"> (' . $number . ')</span>'. '</li>';
            }
                echo '</ul></div>';
        } else if ( ( isset($_GET['mt']) && !isset($_GET['remove_mt']) ) || ( isset($_GET['mt']) && !isset($_GET['remove_mt']) && isset($_GET['au']) ) ) {
                echo '<div class="mattype-list"><p class="filter">Material types</p><ul class="list">';
                echo '<li class="mattype_list"><a class="clicked">' . $mattypes[0] . '</a><a class="glyphicon glyphicon-remove-sign remover" href="' . SEARCH_PAGE . '?q=' . $url_final . '&remove_mt=' . $mattypes[0] . '&p=1" title="Remover ' .  $mattypes[0] . '"></a></li>';
                echo '</ul></div>';
        } else if ( ( isset($_GET['mt']) && isset($_GET['remove_mt']) ) || ( ( isset($_GET['mt']) && isset($_GET['remove_mt']) ) && isset($_GET['au']) ) ) {
            echo '<div class="mattype-list"><p class="filter">Material types</p><ul class="list">';
            foreach($mattypesCount_global as $material_type => $number) {
                echo '<li class="mattype_list"><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&mt=' . $material_type . '&p=1">' . $material_type . '</a><span class="parentheses"> (' . $number . ')</span>'. '</li>';
            }
            echo '</ul></div>';

        } else if ( isset($_GET['mt']) && isset($_GET['au']) )  {
            echo '<div class="mattype-list"><p class="filter">Material types</p><ul class="list">';
            echo '<li class="mattype_list"><a class="clicked">' . $mattypes[0] . '</a><a class="glyphicon glyphicon-remove-sign remover" href="' . SEARCH_PAGE . '?q=' . $url_final . '&remove_mt=' . $mattypes[0] . '&p=1" title="Remover ' .  $mattypes[0] . '"></a></li>';
            echo '</ul></div>';
        }


        // Display accesses filters   
        if ( ( !isset($_GET['ac']) && !isset($_GET['remove_ac']) ) || ( !isset($_GET['ac']) && !isset($_GET['remove_ac']) && isset($_GET['ac']) ) ) {
            echo '<div class="access-list"><p class="filter">Access types</p><ul class="list">';
            foreach($accessesCount_global as $access_type => $number) {
                echo '<li class="access_list"><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&ac=' . $access_type . '&p=1">' . $access_type . '</a><span class="parentheses"> (' . $number . ')</span>'. '</li>';
            }
                echo '</ul></div>';
        } else if ( ( isset($_GET['ac']) && !isset($_GET['remove_ac']) ) || ( isset($_GET['ac']) && !isset($_GET['remove_ac']) && isset($_GET['au']) ) ) {
                echo '<div class="access-list"><p class="filter">Access types</p><ul class="list">';
                echo '<li class="access_list"><a class="clicked">' . $accesses[0] . '</a><a class="glyphicon glyphicon-remove-sign remover" href="' . SEARCH_PAGE . '?q=' . $url_final . '&remove_ac=' . $accesses[0] . '&p=1" title="Remover ' .  $accesses[0] . '"></a></li>';
                echo '</ul></div>';
        } else if ( ( isset($_GET['ac']) && isset($_GET['remove_ac']) ) || ( ( isset($_GET['ac']) && isset($_GET['remove_ac']) ) && isset($_GET['au']) ) ) {
            echo '<div class="access-list"><p class="filter">Access types</p><ul class="list">';
            foreach($accessesCount_global as $access_type => $number) {
                echo '<li class="access_list"><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&ac=' . $access_type . '&p=1">' . $access_type . '</a><span class="parentheses"> (' . $number . ')</span>'. '</li>';
            }
                echo '</ul></div>';
        } else if ( isset($_GET['ac']) && isset($_GET['au']) )  {
            echo '<div class="access-list"><p class="filter">Access types</p><ul class="list">';
            echo '<li class="access_list"><a class="clicked">' . $accesses[0] . '</a><a class="glyphicon glyphicon-remove-sign remover" href="' . SEARCH_PAGE . '?q=' . $url_final . '&remove_ac=' . $accesses[0] . '&p=1" title="Remover ' .  $accesses[0] . '"></a></li>';
            echo '</ul></div>';
        }

// display dates filters   

echo '<div class="dates-list"><p class="filter">Dates</p><div class="form-filter-dates">';

echo '<div class="form-group form-dates-filter"><div class="form-check"><form action="./pesquisa.php" method="post"><div>
<label for="dt_begin">Between </label> <input type="text" class="form-check-input" id="dt_begin" name="dt_begin" />
<label for="dt_end"> and </label> <input type="text" class="form-check-input" id="dt_end" name="dt_end" />
<input id="submeter" type="submit" value="Filter" /></div></form></div></div></div>
';

if ( !empty($_GET['dt_begin']) && !isset($_GET['remove_dt']) ) {

    // Remove dates from $url_final
    $date_b = $_GET['dt_begin'];
    $date_e = $_GET['dt_end'];

    $url_f = str_replace("&dt_begin=" . $date_b, "", $url_final);
    $url_f = str_replace("&dt_end=" . $date_e, "", $url_f);
    $url_f = str_replace("&remove_dt", "", $url_f);


    echo '<table class="list-dates"><tr><td><a class="clicked">Between ' . $dt_begin . ' and ' . $dt_end . '</a></td><td><a class="glyphicon glyphicon-remove-sign remover" href="' . SEARCH_PAGE . '?q=' . $url_f . '" title="Remover"></a></td></tr></table></div>';

} else {
    echo '</div>';
}


        // Display authors filters   
                
        if(!isset($_GET['au'])) {
            echo '<div class="authors-list"><p class="filter">Authors</p><button type="button" class="btn btn-default text glyphicon glyphicon-plus">Show More</button><ul class="list read-more">';
            foreach($authorsCount_global as $author => $number) {
                echo '<li class="authors_list"><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&au=' . $author . '&p=1">' . $author . '</a><span class="parentheses"> (' . $number . ')</span>'. '</li>';
            }
            echo '</ul></div>';
        }

        if(isset($_GET['au']) ) {

            $array = [];
            $clicked = 'clicked';
            $non = 'non';  
            $authors_left = array_diff_key($authorsCount_global, $authorsClicked_global);

            foreach($authorsClicked_global as $cauthor => $cnumber) {
                    array_push($array, array('clicked' => 'yes', 'author' => $cauthor, 'number' => $cnumber) );        
            }

            foreach($authors_left as $author => $number) {
                array_push($array, array('clicked' => 'no', 'author' => $author, 'number' => $number));
            }

        // Handle the authors filters - change url when only one author missing
            if ( !empty($authorsClicked_global) ) {
                if ( count($authorsClicked_global) == 1) {
                    $session_val = $session_value;
                } else {
                    $session_val = '';
                }
            }

            uasort($array, function($a, $b) {
                return $b['author'] <=> $a['author'];
            });

            echo '<div class="authors-list"><p class="filter">Authors</p><button type="button" class="btn btn-default text glyphicon glyphicon-plus">Show More</button><ul class="list read-more">';

            for($x = 0; $x < count($array); $x++) {
                if($array[$x]['clicked'] == 'no' && !isset($_GET['remove_au']) && !empty($_GET['q']) ) {
                    echo '<li class="authors_list"><a href="' . SEARCH_PAGE . '?q=' . $url_final . '+au=' . $array[$x]['author'] . '&p=1">' . $array[$x]['author'] . '</a><span class="parentheses"> (' . $array[$x]['number'] . ')</span>'. '</li>';
                } else if ( ($array[$x]['clicked'] == 'no') && isset($_GET['remove_au']) && !empty($_GET['q']) ) {
                    echo '<li class="authors_list"><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&au=' . $array[$x]['author'] . '&p=1">' . $array[$x]['author'] . '</a><span class="parentheses"> (' . $array[$x]['number'] . ')</span>'. '</li>';
                } else if ( ($array[$x]['clicked'] == 'yes') && ( isset($array[$x]['author']) && $array[$x]['author'] <> '' ) && !empty($_GET['q']) ) {
                    echo '<li class="authors_list"><a class="clicked">' . $array[$x]['author'] . '</a><a class="glyphicon glyphicon-remove-sign remover" href="' . SEARCH_PAGE . '?q=' . $url_final . '&remove_au=' . $array[$x]['author'] . '&p=1" title="Remover ' .  $array[$x]['author'] . '"></a></li>';
                }

                if ($array[$x]['clicked'] == 'no' && empty($_GET['q']) ) {
                    echo '<li class="authors_list"><a href="' . SEARCH_PAGE . '?q=' . $url_final .  '+au=' . $array[$x]['author'] . '&p=1">' . $array[$x]['author'] . '</a><span class="parentheses"> (' . $array[$x]['number'] . ')</span>'. '</li>';
                } else if ($array[$x]['clicked'] == 'yes' && empty($_GET['q']) ) {
                    echo '<li class="authors_list"><a class="clicked">' . $array[$x]['author'] . '</a><a class="glyphicon glyphicon-remove-sign remover" href="' . SEARCH_PAGE . '?q=' . $session_val . $url_final . '&remove_au=' . $array[$x]['author'] . '&p=1" title="Remover ' .  $array[$x]['author'] . '"></a></li>';
                }
            }
            echo '</ul></div>';
        }       

        }
    } 
        


    public static function filter() {    

        if (isset($_GET['au'])) {
            $au = $_GET['au'];
        }

        if (isset($_GET['remove_au'])) {
            $remove_au = $_GET['remove_au'];
        }

        if(isset($_GET['mt'])) {
            $mt = $_GET['mt'];
        }

        if(isset($_GET['remove_mt'])) {
            $remove_mt = $_GET['remove_mt'];
        }

        if(isset($_GET['rg'])) {
            $rg = $_GET['rg'];
        }

        if(isset($_GET['remove_rg'])) {
            $remove_rg = $_GET['remove_rg'];
        }

        if (isset($_GET['dt'])) {
            $dt = $_GET['dt'];
        }

        if(isset($_GET['remove_dt'])) {
            $remove_dt = $_GET['remove_dt'];
        }
    }
}

?>

