<?php require_once('.\includes\header.php'); ?>


<?php 

// Novo objecto apenas se se tiver sido efetuada uma pesquisa
if ( isset($_GET['q']) ) {
    $show_results = new Results;
}

?>


<div class="container-fluid">
    <div class="col-lg-12">
        <div class="col-lg-3">
        </div>
            <div class="col-lg-8">
                <div class="search">
                    <form class="form-inline" action="pesquisa.php?q=<?php echo $q; ?>" method="get" enctype="multipart/form-data">
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="search" class="sr-only">Pesquisar</label>
                        <input class='form-control form-control-lg searchbox' type="text" name='q' id='search' placeholder='Search' value='<?php echo (isset($_GET['q'])) ? Filters::getQuery() : ''; ?>'>
                    </div>
                    <button type="submit" class="btn btn-default mb-2" value="pesquisar">Search</button>
                    </form>
                </div>
            </div>
    </div>

    <div class="col-lg-12 results-area">
                        <div class="container-fluid">
                            <div class="row">
                            <div class="col-lg-3">
                                <div class="container-fluid">
                                    <div class="row">                            
                                    </div>                
                                </div>                
                            </div>
                            <div class="col-lg-8">
                                <div class="container-fluid">
                                    <div class="row"> 
                                        <div class="paginacao">

<?php

Pagination::paginate();

?>

                                        </div>
                                    </div>
                                </div>
                            </div>                                        
                                    </div>
                                </div>
                            </div>


    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-3 filters">
                        <div class="lists">
<?php
    // To handle the authors links 
    if ( isset($_GET['q']) ) {
        $total_pages = Results::total_pages();
        $total = $total_pages[0];
        
        if ( $total != 0 ) {
            Filters::getFilters();
        } else {
            echo '';
        } 
    }

?>  
                       
<br /> <br />
                        
                            <ul class="list"> 
                            </ul>     
                        </div>                       
                    </div>
                        <div class="col-lg-8">
                            <div class="container-fluid">
                                <div class="row"> 

                                    <table class="table table-hover results">
                                        <thead>
                                        </thead>
                                            <tbody>
                                        </td>
<?php 
    if (isset($_GET['q'])) {
        $show_results->showData();
    }            
?>
                                            </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 results-area">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-3">
                                </div>
                                    <div class="col-lg-8 results-area">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="paginacao">
<?php

    Pagination::paginate();

?>
                                            </div>              
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

<script>


// Para esconder o botão "0" da navegação
$(document).ready(function() {

// Botão para ir para o cimo da página nos resultados de pesquisas
$(".cimo").click(function() {
    $('html, body').animate({scrollTop: 0}, 0);

});

// Botão para alargar a secção de autores dos filtros 
var defaultHeight = 315;
var text = $(".read-more");
var textHeight = /*text[0].scrollHeight;*/4310;
var button = $(".text");
text.css({"max-height": defaultHeight, "overflow": "hidden"});

button.on("click", function(){
  var newHeight = 0;
  if (text.hasClass("active")) {
    newHeight = defaultHeight;
    text.removeClass("active");
  } else {
    newHeight = textHeight;
    text.addClass("active");
  }
  text.animate({
    "max-height": newHeight
  }, 200);
});

document.getElementById("submeter").onclick = redirect;
    
function redirect(){
    var dt_begin = $("#dt_begin").val();
    var dt_end = $("#dt_end").val();
    var parameters = "&dt_begin=" + dt_begin + "&dt_end=" + dt_end;

    window.location.href = window.location + parameters;
    return false;
}


});

</script>