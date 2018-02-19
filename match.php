<?
$title = "Match dump ";
require_once "_common.php";
require_once "_prolog.php"; 

$mid = $_GET['id'];
$match = new Match($mid);


if ($match->is_good() ) 
   Diag::dump($match);
else 
   Diag::abort("No, match dont exists");

echo 'Tour:'. $match->get_tour_id();

?>

