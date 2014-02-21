<?php // content="text/plain; charset=utf-8"
include ("jpgraph/src/jpgraph.php");
include ("jpgraph/src/jpgraph_bar.php");


//$datan   = $_GET['_u'];//array(19,12,4,7,3,12,3);
//$days    = $_GET['_d'];  

$daystu = array_combine($_GET['_d'],$_GET['_u']);
$i=($_GET['_d'][0]-1)%7;
$datax = array();
$datay = array();
$j = 0;
while(($u = current($daystu)) && $j<7){
	$key = key($daystu)%7;
	while ((abs($key - $i))%7 != 1 && $j<6){
		array_push($datay,0);	
		$i = ($i + 1) % 7;
		$j = $j + 1;	
		array_push($datax,$i);			

	}
	array_push($datay,$u);	
	array_push($datax,$key);
	$i = $key;
	next($daystu);
	$j = $j + 1;			
}
       
/*$datay=array(12,26,9,17,31);*/
$datax_str=array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
$datax = array_merge($datax_str,$datax);

// Create the graph. 
// One minute timeout for the cached image
// INLINE_NO means don't stream it back to the browser.
$graph = new Graph(310,250,'auto');
$graph->SetScale("textlin");
$graph->img->SetMargin(60,30,20,40);
$graph->yaxis->SetTitleMargin(45);
$graph->yaxis->scale->SetGrace(5);
$graph->SetShadow();

// Turn the tickmarks
$graph->xaxis->SetTickSide(SIDE_DOWN);
$graph->yaxis->SetTickSide(SIDE_LEFT);

// Create a bar pot
$bplot = new BarPlot($datay);

// Create targets for the image maps. One for each column
//$targ=array("bar_clsmex1.php#aa","bar_clsmex1.php#ss","bar_clsmex1.php#3","bar_clsmex1.php#4","bar_clsmex1.php#5","bar_clsmex1.php#6");
//$alts=array("val=%s","val=%s","val=%d","val=%d","val=%d","val=%d");
//$bplot->SetCSIMTargets($targ,$alts);
$bplot->SetFillColor("orange");

// Use a shadow on the bar graphs (just use the default settings)
$bplot->SetShadow();
$bplot->value->SetFormat(" $ %2.1f",70);
$bplot->value->SetFont(FF_ARIAL,FS_NORMAL,9);
$bplot->value->SetColor("blue");
$bplot->value->Show();

$graph->Add($bplot);

//$graph->title->Set("Image maps barex1");
//$graph->xaxis->title->Set("X-title");
$graph->yaxis->title->Set("visitors");

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetTickLabels($datax);

// Send back the HTML page which will call this script again
// to retrieve the image.
//$graph->StrokeCSIM();
$graph->Stroke();

?>



