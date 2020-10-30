<?php require_once '.\includes\header.php'; ?>

<?php


class Pagination {

    function __construct(){ 

        Url::generate();
        global $url_final;
        global $results;
        $results = Query::queryES();
        $this->paginate();
    }


public static function paginate() {

    global $url_final;
    global $results;
    global $q;
    global $noOfPages;
    global $currentPage;
                
if ( isset($_GET['q']) ) {
    // Number of search results
    $total = $results['hits']['total'];

    // Number of results pages
    $noOfPages = ceil($total / 20);
}               
        
// Number of the actual page    
if ( isset($_GET['p']) ) {
    $currentPage = $_GET['p'];
} else {
    $currentPage = 1;
}

// Searched data
if ( isset($_GET['q']) ) {
    $q = $_GET['q'];
}
   
$division = floor($currentPage / 10);
   
// Obter último digito para quando se clicar no botão da última página surgirem botões das páginas até à penúltima dezena
$last_number = substr($currentPage, -1);
    
// Para secção de páginas com n.º de páginas inferior a 10
echo '<ul class="pager">';

// Number of pages: greater than 1 and lesser ou equal to 10
if ($noOfPages > 1 && $noOfPages <= 10) {
    if ( $currentPage != $noOfPages ) {
       // If the actual page is greater than 1, show previous page button
        if ($currentPage > 1) {
            static::previousPage();
        }
        for ($pg = 1; $pg < $currentPage; $pg++) {
            echo '<li><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&p=' . $pg . '">' . $pg . '</a></li>';
        }
        if ( ($currentPage >= 1) && ($currentPage < $noOfPages) ) {
            static::currentPage();
        } 
        for ($cpg = $currentPage; $cpg < $noOfPages; $cpg++) {
            echo '<li><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&p=' . ($cpg + 1) . '">' . ($cpg + 1) . '</a></li>';
        }
        if ( $currentPage < $noOfPages ) {
            static::nextPage();
        }
    } else {
        static::previousPage();
    
        // Go to the penultimate 10 records
        for ($pgin = 1; $pgin < $currentPage; $pgin++) {
            echo '<li><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&p=' . $pgin . '">' . $pgin . '</a></li>';
        }

        static::currentPage(); 
    }          
        
// Number of pages greater than 10
} else if ( $noOfPages > 10 ) {

    // Number of pages greater than 10 and actual page number lesser than the number of pages
    if ( ($noOfPages > 10) && ($currentPage < $noOfPages) ) {
    // Number of pages greater than 1 and lesser or equal to 10
        if ( ($currentPage > 1) && ($currentPage < 10) ) {
                static::previousPage();
                for ($pag = $division; $pag < ($currentPage - 1); $pag++) {
                    echo '<li><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&p=' . ($pag + 1) . '">' . ($pag + 1) . '</a></li>';
               }
            
    // Actual page greater or equal to 10 and lesser than 20
        } else if ($currentPage >= 10 && $currentPage < 20 ) {
            static::firstPage();
            static::previousPage();
    // Actual page equal to 10
            if ($currentPage == 10) {
                for ($pag = ($currentPage - 9); $pag < 10; $pag++) {
                    echo '<li><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&p=' . $pag . '">' . $pag . '</a></li>';
                }
    // Actaul page greater than 10 and lesser than 20
            } else if ($currentPage > 10 && $currentPage < 20 ) {    
                for ($pag = ($currentPage - 11); $pag < ($currentPage - 1); $pag++) {
                    echo '<li><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&p=' . ($pag + 1) . '">' . ($pag + 1) . '</a></li>';
                }
            }
    // Actual page greater than 20 and lesser than the last page
        } else if ($currentPage >= 20 && $currentPage < $noOfPages ) {
            static::firstPage();
            static::previousPage();
    
            for ($pag = ($currentPage - 11); $pag < ($currentPage - 1); $pag++) {
                echo '<li><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&p=' . ($pag + 1) . '">' . ($pag + 1) . '</a></li>';
            }
        }   
    
    // Actual page lesser than the number of pages
        if ( ($currentPage < $noOfPages) ) {
            static::currentPage();
    
        }
    
    // Actual page lesser than the number of pages minus 10
        if ( $currentPage > ($noOfPages - 10 ) ) {
            for ($p = $currentPage; $p < $noOfPages; $p++) {
                if ( $currentPage == $noOfPages) {
                    static::currentPage();    
                } else {
                    echo '<li><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&p=' . ($p + 1) . '">' . ($p + 1) . '</a></li>';
                }
            }       
       
        } else {
            for ($pagi = $currentPage; $pagi < ($currentPage + 10); $pagi++) {
                echo '<li><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&p=' . ($pagi + 1) . '">' . ($pagi + 1) . '</a></li>';
            }
        }
        if ( ( $currentPage < $noOfPages ) && ($currentPage < $noOfPages) ){
            static::nextPage();
        }
        static::lastPage();
        }

    // Last page equals number of pages
        // If only one results page, then do not show the pagination
        if ( ( $currentPage > 1 ) && ( $currentPage == $noOfPages ) ) {
                static::firstPage();
                static::previousPage();

                // Go to the penultimate 10 records
                for ($pagin = ($currentPage - 10 - $last_number); $pagin < ($currentPage - 1); $pagin++) {
                    echo '<li><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&p=' . ($pagin + 1) . '">' . ($pagin + 1) . '</a></li>';
                }
                static::currentPage(); 
            }    
    }
    echo '</ul>';
}
    
        
        
    private static function firstPage() {

        global $url_final;
        echo '<li><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&p=1">First</a></li>';
    }


    private static function currentPage() {

        global $url_final;
        global $currentPage;

        echo '<li class="current-page"><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&p=' . $currentPage . '">' . $currentPage . '</a></li>';
    }


    private static function previousPage() {
        
        global $url_final;
        global $currentPage;
        
        $previousPage = ($currentPage - 1);
        
        echo '<li><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&p=' . $previousPage . '">« Previous</a></li>';
    }
        

    private static function nextPage() {
        
        global $url_final;
        global $currentPage;
        
        $nextPage = ($currentPage + 1);
        
        echo '<li><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&p=' . $nextPage . '">Next »</a></li>';
    }
    

    private static function lastPage() {

        global $url_final;
        global $noOfPages;

        echo '<li><a href="' . SEARCH_PAGE . '?q=' . $url_final . '&p=' . $noOfPages . '">Last</a></li>';
    }

}

?>