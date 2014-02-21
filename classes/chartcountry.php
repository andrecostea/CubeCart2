<?php 
// content="text/plain; charset=utf-8"

 function getAlphaNum($str){
	$an = preg_replace('~[\W - ]~', '', $str);
	if ($an !== '') return $an;
	else $str;
}
include ("jpgraph/src/jpgraph.php");
include ("jpgraph/src/jpgraph_pie.php");


// Some data and the labels
//whitelist space - and alpha characters
$datan      = $_GET['_u'];//array(19,12,4,7,3,12,3);
$countries  = $_GET['_c'];  
$data       = array();
foreach($datan as $d)
	array_push($data,(int)$d);
$labels     = array();
foreach($countries as $c)
	array_push($labels,getAlphaNum($c)."\n(%.1f%%)");

// Create the Pie Graph.
$graph = new PieGraph(300,300);
$graph->SetShadow();

// Set A title for the plot
//$graph->title->Set('String labels with values');
$graph->title->SetFont(FF_VERDANA,FS_BOLD,12);
$graph->title->SetColor('black');

// Create pie plot
$p1 = new PiePlot($data);
$p1->SetCenter(0.5,0.5);
$p1->SetSize(0.3);

// Setup the labels to be displayed
$p1->SetLabels($labels);

// This method adjust the position of the labels. This is given as fractions
// of the radius of the Pie. A value < 1 will put the center of the label
// inside the Pie and a value >= 1 will pout the center of the label outside the
// Pie. By default the label is positioned at 0.5, in the middle of each slice.
$p1->SetLabelPos(1);

// Setup the label formats and what value we want to be shown (The absolute)
// or the percentage.
$p1->SetLabelType(PIE_VALUE_PER);
$p1->value->Show();
$p1->value->SetFont(FF_ARIAL,FS_NORMAL,9);
$p1->value->SetColor('darkgray');

// Add and stroke
$graph->Add($p1);
$graph->Stroke();

?>


