<?php require_once('.\includes\header.php'); ?>


<?php

class Results {

    function __construct(){ 
        global $results;
        $results = Query::queryES();
    }

    public static function getQueryValue() {

        global $query_value;

        if (!empty($_GET['q'])) {
            array_push($query_value, $_GET['q']);
        }
    }



    public function showData() {
   
        global $results;

        Url::generate();
        global $url_final;

        
        // Get page number from url
        if(isset($_GET['p'])) {
            $pag = $_GET['p'];
        } else {
            $pag = '1';
        }
        

        // Get total number of records
        $total_pages = static::total_pages();
        $total = $total_pages[0];
        $noOfPages = $total_pages[1];
        $interval = 20; 
        $increment = 20;

    //  TABLE WITH RESULTS
    echo '<table class="table results">';

    if ( isset($_GET['q']) && ( isset($_GET['ac']) || ( isset($_GET['au']) || isset($_GET['mt']))) ) {
        $ac_text = " and access type: ";
    } else {
        $ac_text = "Access type: ";
    }

    if ( (empty($_GET['q']) && isset($_GET['au']) ) && ( !isset($_GET['ac']) || !isset($_GET['mt'])) ) {
        $au_text = "Autores: ";
    } else if ( ( isset($_GET['q']) && isset($_GET['au']) ) || ( isset($_GET['ac']) || isset($_GET['mt'])) ) {
        $au_text = " and authors: ";
    } else {
        $au_text = "Authors: ";
    }

    if ( isset($_GET['q']) && ( isset($_GET['mt']) || ( isset($_GET['au']) || isset($_GET['ac']))) ) {
        $mt_text = " and material type: ";
    } else {
        $mt_text = "Material type: ";
    }

    $url_final_find = ["&au=", "+au=", "&mt=", "&ac="];
    $url_final_replace   = [$au_text, ", ", $mt_text, $ac_text];
    $url_replaced_terms = str_replace($url_final_find, $url_final_replace, $url_final);

    if ( isset($_GET['dt_begin']) && !isset($_GET['remove_dt']) ) {
        $url_replaced_terms = str_replace("&dt_begin=", " and dates between: ", $url_replaced_terms);
        $url_replaced_terms = str_replace("&dt_end=", " and: ", $url_replaced_terms);
    }
    
    echo '<h5 class="searchterm">You searched for: <em>' . $url_replaced_terms  . '</em></h5>';


    if($total > 5000) {
    $total = '5000';
    echo '<p class="results-found"><em>' . $total . ' results found</em></p';
    } else {
    echo '<p class="results-found"><em>' . $total . ' results found</em></p>';
    }

    if ($total < 20) {
    $interval = $total;
    $increment = $total;
    }   

    if ($results >=1 ) {
        for ($r = ($pag - 1) * $interval; $r < ($pag -1) * $interval + $increment; $r++) {    
            // fields
    if ($r >= $total) {
        break;
    }
    if (isset($results['hits']['hits'][$r]['_source']['mattype'])) {
        $mattype = $results['hits']['hits'][$r]['_source']['mattype'];    
    }
    if (isset($results['hits']['hits'][$r]['_source']['200'])) {
        $field200 = $results['hits']['hits'][$r]['_source']['200'];
    }
    if(isset($results['hits']['hits'][$r]['_source']['205'])) {
        $field205 = $results['hits']['hits'][$r]['_source']['205'];
    }
    if(isset($results['hits']['hits'][$r]['_source']['210'])) {
        $field210 = $results['hits']['hits'][$r]['_source']['210'];
    }
    if(isset($results['hits']['hits'][$r]['_source']['authors700'])) {
        $authors700 = $results['hits']['hits'][$r]['_source']['authors700'];
    }
    if(isset($results['hits']['hits'][$r]['_source']['authors701'])) {
        $authors701 = $results['hits']['hits'][$r]['_source']['authors701'];
    }
    if(isset($results['hits']['hits'][$r]['_source']['authors702'])) {
        $authors702 = $results['hits']['hits'][$r]['_source']['authors702'];
    }
    if(isset($results['hits']['hits'][$r]['_source']['authors710'])) {
        $authors710 = $results['hits']['hits'][$r]['_source']['authors710'];
    }
    if(isset($results['hits']['hits'][$r]['_source']['authors711'])) {
        $authors711 = $results['hits']['hits'][$r]['_source']['authors711'];
    }
    if(isset($results['hits']['hits'][$r]['_source']['authors712'])) {
        $authors712 = $results['hits']['hits'][$r]['_source']['authors712'];
    }
    if (isset($results['hits']['hits'][$r]['_source']['856'])) {
        $field856 = $results['hits']['hits'][$r]['_source']['856'];    
    }
    if (isset($results['hits']['hits'][$r]['_source']['966'])) {
        $field966 = $results['hits']['hits'][$r]['_source']['966'];
    }
    if(isset($results['hits']['hits'][$r]['_source']['access'])) {
        $access = $results['hits']['hits'][$r]['_source']['access'];
    }

    // Get cover
    echo '<tr class="result">';
        if(isset($field856)) {
            for ($co = 0; $co < count($field856); $co++) {
                if (isset($field856[$co]['u']) && strpos($field856[$co]['u'], 'purl') != false) {
                    $purl = $field856[$co]['u'];
                    if ($purl) {
                        echo '<td class="cover"><p class="number">' . ($r + 1) . '. </p>' . '<a class="title" target="_blank" href="' . $purl . '"><img src="' . $purl . '/service/media/cover/low"></a></td>';
                        break;
                    }
                }
            }
        }

    // Get title data and authors data
    if (isset($field200)) {
        echo '<td class="data"><div class="isbd">';

    $array200a = [];
    $mat_type;

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
    $mat_type = 'Sheet music';
    } else if ( isset($field966 ) ){
    for ($mat = 0; $mat < count($field966); $mat++) {
        if ($field966[$mat] == 'Esp.') {
            $mat_type = 'Booty';
        }
    }
    } else {
        $mat_type = 'Undefined material type';
    }

    if ( isset($mat_type) ) {
        echo '<p class="mat_type livro"><img class="mat_type" src="images/' . $mat_type  . '.png" alt="icone do ' . $mat_type . '"/ >' . $mat_type . '</p>';
    } else {
        echo '<p class="mat_type livro">Undefined material type</p>';
    }
    echo '<p class="isbd">';
            
    for ($t = 0; $t < count($field200); $t++) {
        if (isset($field200[$t]['a'])) {
            echo '<a class="title" target="_blank" href="' . $purl . '">' . $field200[0]['a'] . '</a>'; 
            array_push($array200a, self::regex($field200[$t]['a']));    
        }    
    }
    $no_200a = count($array200a);

    if($no_200a < 1) {
        for($ti_a = 1; $ti_a < $no_200a; $ti_a++) {
            echo ' ; <a class="title" target="_blank" href="' . $purl . '">' . $field200[$ti_a]['a'] . '</a>';    
        }
    }
        
    for ($ti = 0; $ti < count($results['hits']['hits'][$r]['_source']['200']); $ti++) {
        if (isset($field200[$ti]['c'])) {
            echo ' = ' . $field200[$ti]['c'];
        }                                    
        if (isset($field200[$ti]['d'])) {
            echo ' = ' . $field200[$ti]['d'];
        }
        if (isset($field200[$ti]['e'])) {
            echo ' : ' . $field200[$ti]['e'];
        }  
        if (isset($field200[$ti]['f']) && !isset($field200[$ti]['g'])) {
            echo ' / ' . $field200[$ti]['f'];
        } 
        elseif (isset($field200[$ti]['g'])) {
            echo ' ; ' . $field200[$ti]['g'];
        }
    }    

    }

    if (isset($field205)) {
        $array205a = [];
        for ($era = 0; $era < count($field205); $era++) {
            if (isset($field205[$era]['a'])) {
                array_push($array205a, self::regex($field205[$era]['a']));    
            } else {    
                array_push($array205a, ''); 
            }
            $no_205a = count($array205a);
            if ($no_205a < 0) {
                echo '';
            } else if ($no_205a == 0) {   
                echo '. -  ' . $field205[0]['a']; 
            } else if ($no_205a > 0) {
                for($era_a = 1; $era_a < $no_205a; $era_a++) {
                    if(isset($field205[$era_a]['a'])) {
                        echo $field205[$era_a]['a'];
                    } else {
                        echo '';
                    }
                }
            }

            // Get editor data
            for ($er = 0; $er < count($field205); $er++) {
                if (isset($field205)) {
                    for ($er = 0; $er < count($field205); $er++) {
                        if(isset($field205[$er]['a'])) {
                            echo '. -  ' . $field205[$er]['a'];
                        }
                        elseif (isset($field205[$er]['b'])) {
                            echo ' : ' . $field205[$er]['b'] . '] ';
                        }
                        elseif (isset($field205[$er]['d'])) {
                            echo ', ' . $field205[$er]['d'];
                        }

                        if (isset($field205[$er]['f']) && !isset($field205[$er]['g'])) {
                            echo ' / ' . $field205[$er]['f'];
                        } 
                        elseif (isset($field205[$er]['g'])) {
                            echo ' ; ' . $field205[$er]['g'];
                        }                             
                    }
                }    
            }
        }
    }
        // Get editior data

        if (isset($field210)) {
            $array210a = [];
            for ($eda = 0; $eda < count($field210); $eda++) {
                if (isset($field210[$eda]['a'])) {
                    array_push($array210a, self::regex($field210[$eda]['a']));    
                } else {
                    array_push($array210a, '');    
                }
            }

            $no_210a = count($array210a);

            if ($no_210a < 0) {
                echo '';
            } else if ($no_210a == 0) {       
                echo '. -  ' . $field210[0]['a'];    
            } else if ($no_210a > 0) {
                for($eda_a = 1; $eda_a < $no_210a; $eda_a++) {
                    if(isset($field210[$eda_a]['a'])) {
                        echo $field210[$eda_a]['a'];
                    } else {
                        echo '';
                    }
                }
            }

            for ($ed = 0; $ed < count($field210); $ed++) {
                if(isset($field210[$ed]['a'])) {
                    echo '. -  ' . $field210[$ed]['a'];
                }
                elseif (isset($field210[$ed]['c'])) {
                    echo ' : ' . $field210[$ed]['c'];
                }
                elseif (isset($field210[$ed]['d'])) {
                    echo ', ' . $field210[$ed]['d'];
                }
                elseif (isset($field210[$ed]['e'])) {
                    echo ' (' . $field210[$ed]['e'];
                }
                elseif (isset($field210[$ed]['f'])) {
                    echo ' (' . $field210[$ed]['f'];
                }            
                elseif (isset($field210[$ed]['g'])) {
                    echo ' : ' . $field210[$ed]['g'];
                }
                elseif (isset($field210[$ed]['h'])) {
                    echo ', ' . $field210[$ed]['h'] . ')';
                }
            }

        }
    
        if ( (isset($authors700) && $authors700 != null) || (isset($authors702) && $authors702 != null) ){
            echo '<div class="autores">';
            if (isset($authors700) && $authors700 != null) {
                echo '<a href="' . SEARCH_PAGE . '?q=&au=' . $authors700[0] . '&p=1">' . $authors700[0] . '</a>';
            } 
            // CONFIRMAR DE QUE SÓ HÁ 701 QUANDO HÁ TAMBÉM 700
            if ( (isset($authors701) && $authors701 != null) ) { 
                for ($au701 = 0; $au701 < count($authors701); $au701++) {
                    echo ', <a href="' . SEARCH_PAGE . '?q=&au=' . $authors701[$au701] . '&p=1" onclick="">' . $authors701[$au701] . '</a>';
                }
            }    
            if ( (isset($authors702) && $authors702 != null) && ( !isset($authors700) || ($authors700 == null) && (!isset($authors701) || ($authors701 == null) ) ) ) { 
                echo '<a href="' . SEARCH_PAGE . '?q=&au=' . $authors702[0] . '&p=1" onclick="">' . $authors702[0] . '</a>';
                if(count($authors702) > 1) {
                    for ($au702 = 1; $au702 < count($authors702); $au702++) {
                        echo '; <a href="' . SEARCH_PAGE . '?q=&au=' . $authors702[$au702] . '&p=1" onclick="">' . $authors702[$au702] . '</a>';
                    }
                }
            } else if ( (isset($authors702) && $authors702 != null) && ( ($authors700 != null) || ($authors701 != null) ) ) { 
                for ($au702 = 0; $au702 < count($authors702); $au702++) {
                    echo ' ; <a href="' . SEARCH_PAGE . '?q=&au=' . $authors702[$au702] . '&p=1" onclick="">' . $authors702[$au702] . '</a>';
                }
            }             

            // 710, 711 and 712
            if ( (isset($authors710) && $authors710 != null) || (isset($authors712) && $authors712 != null) ){
                echo '<div class="autores">';
                if (isset($authors710) && $authors710 != null) {
                    echo '<a href="' . SEARCH_PAGE . '?q=&au=' . $authors710[0] . '&p=1">' . $authors710[0] . '</a>';
                } 

                // CONFIRMAR DE QUE SÓ HÁ 701 QUANDO HÁ TAMBÉM 700
                if ( (isset($authors711) && $authors711 != null) ) { 
                    for ($au711 = 0; $au711 < count($authors711); $au711++) {
                        echo ', <a href="' . SEARCH_PAGE . '?q=&au=' . $authors711[$au711] . '&p=1" onclick="">' . $authors711[$au711] . '</a>';
                    }
                }    
                if ( (isset($authors712) && $authors712 != null) && ( !isset($authors710) || ($authors710 == null) && (!isset($authors711) || ($authors711 == null) ) ) ) { 
                    echo '<a href="' . SEARCH_PAGE . '?q=&au=' . $authors712[0] . '&p=1" onclick="">' . $authors712[0] . '</a>';
                    if(count($authors712) > 1) {
                        for ($au712 = 1; $au712 < count($authors712); $au712++) {
                            echo '; <a href="' . SEARCH_PAGE . '?q=&au=' . $authors712[$au712] . '&p=1" onclick="">' . $authors712[$au712] . '</a>';
                        }
                    }
                } else if ( (isset($authors712) && $authors712 != null) && ( ($authors710 != null) || ($authors711 != null) ) ) { 
                    for ($au712 = 0; $au712 < count($authors712); $au712++) {
                        echo ' ; <a href="' . SEARCH_PAGE . '?q=&au=' . $authors712[$au712] . '&p=1" onclick="">' . $authors712[$au712] . '</a>';
                    }
                }   
            }
            echo '</div>';
        }
        
        echo '</p>';
        
        if(isset($field856)) {
            for ($li = 0; $li < count($field856); $li++) {
                if (isset($field856[$li]['u']) && strpos($field856[$li]['u'], 'purl') != false) {
                    $permalink = $field856[$li]['u'];
                    if ($permalink) {
                        echo '</div><div class="plink-access"><p class="glyphicon glyphicon-link permalink"><a class="title" target="_blank" href="' . $permalink . '">'. $permalink . '</a></p>';
                    break;
                }
            }
        }
        
    }
    

    if(isset($access)) {
        $access = explode(" ",$access);
        for ($ac = 0; $ac < count($access); $ac++) {
            if (isset($access[$ac])) {
                $rightsInfo = $access[$ac];
                if ($rightsInfo == 'Interno') {
                    echo '<p class="rights"><span class="glyphicon glyphicon glyphicon glyphicon-chevron-left interno" aria-hidden="true"></span><span class="interno">Internal Access</span></p></td>';
                } else {
                    echo '<p class="rights"><span class="glyphicon glyphicon-chevron-right livre" aria-hidden="true"></span><span class="livre">Free Access</span></p></td>';
                }
                echo '</div></div>';
            }
        }
    }

    }
    

    echo '</tr>';    


    }

    echo '</table>';

    if ($total > 10) {
        echo '<button class="glyphicon glyphicon-arrow-up cimo" title="Topo da página"> </button>';
    }
    echo '<script>

    $(document).ready(function() { 
        $(".interno").closest("tr").addClass("red"); 
        $(".livre").closest("tr").addClass("green"); 
    });

    </script>';

    }


    public static function regex($str) {
                                    
        $pattern = '/[.,;]/';
        $replace = '';
                                
        $remove = array(',', ';', '.í', '[', ']');
        $put = array('', '', '', '', '');
                                                    
        $clean = strtr($str, array_combine($remove, $put));
        $clean = trim($clean, '-');
        return $clean;
    }



    public static function changeChar($terms) {
                                    
        $remove = array(' ', '%20');
        $put = array('%20',' ');

        $clean = strtr($terms, array_combine($remove, $put));
        
        return $clean;
    }



    public static function total_pages() {
        
        global $results;

    if ( isset($_GET['q']) ) {
        // Fornece o total de registos recuperados
        $total = $results['hits']['total'];

        // Fornece o n.º de páginas
        $noOfPages = ceil($total / 20);

        return [$total, $noOfPages];
    }

        
    } 

// final classe
}


