<?php require_once('.\includes\header.php'); ?>

<?php

class Url {

    public static function generate() {

        global $url_final;

        if (isset($_GET['q'])) {
            $q_get = $_GET['q'];
        }

        global $dates;

        // Get the dates from url after being passed by the post method

        $url = $_GET;

        // Author from url
        if(isset($_GET['au'])) {
            $au_get = $_GET['au'];
            $au_exploded = explode("au=",$au_get);
        }

        // Material type from url
        if( isset($_GET['mt']) && !isset($_GET['remove_mt']) ) {
            $mt_array = [];
            $mt_get = $_GET['mt'];
            $pos_author = strpos($mt_get, 'au');
            $pos_access = strpos($mt_get, 'ac');
            $pos_dt_begin = strpos($mt_get, 'dt_begin');
            $pos_dt_end = strpos($mt_get, 'dt_end');    

            // Get the position of authors or type of access inside $_GET['mt']
            if($pos_author != '') {
                $pos_au = strpos($mt_get, 'au');
            } else {
                $pos_au = 0;
            }

            if($pos_access != '') {
                $pos_ac = strpos($mt_get, 'ac');
            } else {
                $pos_ac = 0;
            }

            if($pos_dt_begin != '') {
                $pos_dt_begin = strpos($mt_get, 'dt_begin');
            } else {
                $pos_dt_begin = 0;
            }

            if($pos_dt_end != '') {
                $pos_dt_end = strpos($mt_get, 'dt_end');
            } else {
                $pos_dt_end = 0;
            }    

            $mt_array['au'] = $pos_au;
            $mt_array['ac'] = $pos_ac;
            $mt_array['dt_begin'] = $pos_dt_begin;
            $mt_array['dt_end'] = $pos_dt_end;

            ksort($mt_array);

            $mt_array_count = count($mt_array);

            // Find out which key is first and make a substring from the mt variable data until that key 
            if ( $mt_array_count > 0) {
                foreach($mt_array as $key => $value) {
                    if ($value > 0) {
                        $mt_key = $key;
                        $subst_mt = substr($mt_get, 0, strpos($mt_get, $mt_key));
                    } else {
                        $subst_mt = $mt_get;
                    }
                } 
            }

        } else if ( isset($_GET['mt']) && isset($_GET['remove_mt']) ) {
            $subst_mt = '';
        }

        // Type of access from url
        if( isset($_GET['ac']) && !isset($_GET['remove_ac']) ) {
            $ac_array = [];
            $ac_get = $_GET['ac'];
            $pos_author = strpos($ac_get, 'au');
            $pos_mattype = strpos($ac_get, 'mt');
            $pos_dt_begin = strpos($ac_get, 'dt_begin');
            $pos_dt_end = strpos($ac_get, 'dt_end');

            // Get the position of authors or type of access inside $_GET['mt']
            if($pos_author != '') {
                $pos_au = strpos($ac_get, 'au');
            } else {
                $pos_au = 0;
            }

            if($pos_mattype != '') {
                $pos_mt = strpos($ac_get, 'mt');
            } else {
                $pos_mt = 0;
            }

            if($pos_dt_begin != '') {
                $pos_dt_begin = strpos($ac_get, 'dt_begin');
            } else {
                $pos_dt_begin = 0;
            }

            if($pos_dt_end != '') {
                $pos_dt_end = strpos($ac_get, 'dt_end');
            } else {
                $pos_dt_end = 0;
            }

            $ac_array['au'] = $pos_au;
            $ac_array['mt'] = $pos_mt;
            $ac_array['dt_begin'] = $pos_dt_begin;
            $ac_array['dt_end'] = $pos_dt_end;

            ksort($ac_array);

            $ac_array_count = count($ac_array);

            // Find out which key is first and make a substring from the mt variable data until that key 
            if ( $ac_array_count > 0) {
                foreach($ac_array as $key => $value) {
                    if ($value > 0) {
                        $ac_key = $key;
                        $subst_ac = substr($ac_get, 0, strpos($ac_get, $ac_key));
                    } else {
                        $subst_ac = $ac_get;
                    }
                } 
            }
        } else if ( isset($_GET['ac']) && isset($_GET['remove_ac']) ) {
            $subst_ac = '';
        }    

        // Type of date_begin from url
        if( isset($_GET['dt_begin']) && !isset($_GET['remove_dt']) ) {
            $dt_begin_array = [];
            $dt_begin_get = $_GET['dt_begin'];
            $pos_author = strpos($dt_begin_get, 'au');
            $pos_mattype = strpos($dt_begin_get, 'mt');
            $pos_dt_end = strpos($dt_begin_get, 'dt_end');

            // Get the position of authors or type of access inside $_GET['mt']
            if($pos_author != '') {
                $pos_au = strpos($dt_begin_get, 'au');
            } else {
                $pos_au = 0;
            }

            if($pos_mattype != '') {
                $pos_mt = strpos($dt_begin_get, 'mt');
            } else {
                $pos_mt = 0;
            }

            if($pos_dt_end != '') {
                $pos_dt_end = strpos($dt_begin_get, 'dt_end');
            } else {
                $pos_dt_end = 0;
            }

            $dt_begin_array['au'] = $pos_au;
            $dt_begin_array['mt'] = $pos_mt;
            $dt_begin_array['dt_end'] = $pos_dt_end;

            ksort($dt_begin_array);

            $dt_begin_array_count = count($dt_begin_array);

            // Find out which key is first and make a substring from the mt variable data until that key 
            if ( $dt_begin_array_count > 0) {
                foreach($dt_begin_array as $key => $value) {
                    if ($value > 0) {
                        $dt_begin_key = $key;
                        $subst_dt_begin = substr($dt_begin_get, 0, strpos($dt_begin_get, $dt_begin_key));
                    } else {
                        $subst_dt_begin = $dt_begin_get;
                    }
                } 
            }
        } else if ( isset($_GET['dt_begin']) && isset($_GET['remove_dt']) ) {
            $subst_dt_begin = '';
        }

        // Type of date_end from url
        if( isset($_GET['dt_end']) && !isset($_GET['remove_dt']) ) {
            $dt_end_array = [];
            $dt_end_get = $_GET['dt_end'];
            $pos_author = strpos($dt_end_get, 'au');
            $pos_mattype = strpos($dt_end_get, 'mt');
            $pos_dt_begin = strpos($dt_end_get, 'dt_begin');

            // Get the position of authors or type of access inside $_GET['mt']
            if($pos_author != '') {
                $pos_au = strpos($dt_begin_get, 'au');
            } else {
                $pos_au = 0;
            }

            if($pos_mattype != '') {
                $pos_mt = strpos($dt_begin_get, 'mt');
            } else {
                $pos_mt = 0;
            }

            if($pos_dt_begin != '') {
                $pos_end = strpos($dt_begin_get, 'dt_end');
            } else {
                $pos_end = 0;
            }

            $dt_end_array['au'] = $pos_au;
            $dt_end_array['mt'] = $pos_mt;
            $dt_end_array['dt_end'] = $pos_end;

            ksort($dt_end_array);

            $dt_end_array_count = count($dt_end_array);

            // Find out which key is first and make a substring from the mt variable data until that key 
            
            if ( $dt_end_array_count > 0) {
                foreach($dt_end_array as $key => $value) {
                    if ($value > 0) {
                        $dt_end_key = $key;
                        $subst_dt_end = substr($dt_end_get, 0, strpos($dt_end_get, $dt_end_key));
                    } else {
                        $subst_dt_end = $dt_end_get;
                    }
                } 
            }
        } else if ( isset($_GET['dt_end']) && isset($_GET['remove_dt']) ) {
            $subst_dt_end = '';
        }


        // Authors without author to remove
        $authors_remove = [];

        // Authors without author to remove and index prefix added
        $authors = [];


        // Remove
        if ( isset($_GET['remove_au']) ) {
            $remove_au = $_GET['remove_au'];
        }

        if ( isset($_GET['remove_mt']) ) {
            $remove_mt = $_GET['remove_mt'];
        }

        if ( isset($_GET['remove_ac']) ) {
            $remove_ac = $_GET['remove_ac'];
        }

        if ( isset($_GET['remove_dt']) ) {
            $remove_dt = $_GET['remove_dt'];
        }


        // Put index data in arrays

        // Author
        $au = [];

        // Materil type
        $mt = [];

        // Type of access
        $ac = [];

        // Dates
        $dt_begin = [];

        $dt_end = [];

        $urlArray = [];

        $url_imploded = implode($url);



        // Check if there is any index started only with '+'
        $au_pos = strpos($url_imploded, 'au');
        $au_arr = array_search('au', array_keys($url));
        $mt_arr = array_search('mt', array_keys($url));
        $ac_arr = array_search('ac', array_keys($url));
        $dt_begin_arr = array_search('dt_begin', array_keys($url));
        $dt_end_arr = array_search('dt_end', array_keys($url));


        // Get the position of the indexes
        $indexes_order = [];

        if ( isset($au_arr) ) {
            // Find au in array
            $au_p = array_search('au', array_keys($url));
            $indexes_order[$au_p] = 'au';
        } else if ( !isset($au_arr) && isset($au_pos) ) {
            // Find 'au in string
            $au_p = strpos($url_imploded, 'au');
            $indexes_order[$au_p] = 'au';
        }

        if ( isset($mt_arr) && !empty($mt_arr) ) {
            // Find au in array
            $mt_p = array_search('mt', array_keys($url));
            $indexes_order[$mt_p] = 'mt';
        } 

        if ( isset($ac_arr) && !empty($ac_arr) ) {
            // Find au in array
            $ac_p = array_search('ac', array_keys($url));
            $indexes_order[$ac_p] = 'ac';
        } 

        if ( isset($dt_begin_arr) && !empty($dt_begin_arr) ) {
            // Find au in array
            $dt_begin_p = array_search('dt_begin', array_keys($url));
            $indexes_order[$dt_begin_p] = 'dt_begin';
        } 

        if ( isset($dt_end_arr) && !empty($dt_end_arr) ) {
            // find au in array
            $dt_end_p = array_search('dt_end', array_keys($url));
            $indexes_order[$dt_end_p] = 'dt_end';
        } 


        // Sort $indexes_order by key and put values in an array
        ksort($indexes_order);

        $ordered_indexes = [];

        foreach ($indexes_order as $key => $val) {
            array_push($ordered_indexes, $val);
        }


        // Put author data in a array
        if (isset($_GET['au'])) {
            foreach ($url as $index => $term) {
                $subst_au = substr($term, strpos($term, 'au=') + 3 );
                $au_string_replaced = str_replace(' au=','+au=',$term);
                if ( $index == 'au' ) {
                    array_push($au, trim($au_exploded[0]));
                    for ($a = 1 ; $a < count($au_exploded); $a++ ) {
                        array_push($au, trim($au_exploded[$a]) );
                    }    
                } else if ( ( $index == 'au'  && !(strpos($term, 'au=') ) ) ) {
                    array_push($au, trim($subst_au) );
                } else if ( !($index == 'au')  && trim(strpos($term, 'au='))  ) {
                    array_push($au, $subst_au);
                }
            } 
        }


        if ( isset($_GET['au']) && isset($_GET['remove_au']) ) {
            // Authors without author to remove
            foreach ($au as $author) {
                if ( $author <> $remove_au ) {
                    array_push($authors_remove, $author);
                } 
            }
            // Authors with the index to search prefix
            if ( count($authors_remove) == 0) {
                array_push($authors, '');
            } 
            else  if ( count($authors_remove) >= 1) {
                array_push($authors, '&au=' . $authors_remove[0]);
                for ($a = 1; $a < count($authors_remove); $a++) {
                    array_push($authors, '+au=' . $authors_remove[$a]);
                }
            } 
        } else if ( isset($_GET['au']) && !isset($_GET['remove_au']) ) {
            array_push($authors, '&au=' . $au[0]);
            for ($a = 1; $a < count($au); $a++) {
                array_push($authors, '+au=' . $au[$a]);
            }   
        }


        // Put material type data in a array
        if ( isset($_GET['mt']) && !(isset($_GET['remove_mt'])) ) {
            array_push($mt,'&mt=' . $subst_mt);
        } else if (isset($_GET['mt']) && isset($_GET['remove_mt'])) {
            array_push($mt,'');
        }


        // Put type of access data in a array
        if ( isset($_GET['ac']) && !(isset($_GET['remove_ac'])) ) {
            array_push($ac,'&ac=' . $ac_get);
        } else if (isset($_GET['ac']) && isset($_GET['remove_ac'])) {
            array_push($ac,'');
        }


        // Put dates data in a array
        if ( isset($_GET['dt_begin']) && !(isset($_GET['remove_dt'])) ) {
            array_push($dt_begin,'&dt_begin=' . $subst_dt_begin);
        } else if ( isset($_POST['dt_begin']) && isset($_GET['remove_dt']) ) {
            array_push($dt_begin,'');
        }

        if ( isset($_GET['dt_end']) && !(isset($_GET['remove_dt'])) ) {
            array_push($dt_end,'&dt_end=' . $subst_dt_end);
        } else if (isset($_POST['dt_end']) && isset($_GET['remove_dt'])) {
            array_push($dt_end,'');
        }

        if(isset($_GET['q'])) {
            array_push($urlArray, $q_get );
        }


        foreach ($ordered_indexes as $key => $value) {
            if ($value == 'au') {
                array_push($urlArray, implode("",$authors) );
            }
            if ($value == 'mt') {
                array_push($urlArray, implode("",$mt) );
            }    
            if ($value == 'ac') {
                array_push($urlArray, implode("",$ac) );
            }
            if ($value == 'dt_begin') {
                array_push($urlArray, implode("",$dt_begin) );
            }    
            if ($value == 'dt_end') {
                array_push($urlArray, implode("",$dt_end) );
            }        
        }
        $url_final = implode("",$urlArray);
    }
}


?>