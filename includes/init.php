<?php 

ob_start();

require_once('.\includes\generate_url.php');
require_once('.\includes\results.php');
require_once('.\includes\filters.php');
require_once('.\includes\query.php');
require_once('.\includes\paginate.php');

session_start();

define('SEARCH_PAGE', '..\phpelasticsearch\pesquisa.php');

?>


