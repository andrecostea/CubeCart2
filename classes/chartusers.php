<?php // content="text/plain; charset=utf-8"
include ("jpgraph/src/jpgraph.php");
include ("jpgraph/src/jpgraph_bar.php");


//$datan   = $_GET['_u'];
//$days    = $_GET['_d'];  
	
	$days = array ();
	//foreach (array_reverse($_GET['_d']) as $d)
	foreach ($_GET['_d'] as $d)
		array_push($days,filter_var(($d%7), FILTER_SANITIZE_NUMBER_FLOAT));

	$users = array ();
	//foreach (array_reverse($_GET['_u']) as $u)
	foreach ($_GET['_u'] as $u)
		array_push($users,filter_var($u, FILTER_SANITIZE_NUMBER_FLOAT));
	reset($days);
	$daystu = array();
	foreach($days as $key=>$d){
		array_push($daystu, array('day' => $d, 'users' => $users[$key]) );
		next($days);
	}	

	//$daystu = array_combine($days,$users);
	$i = ($daystu[0]['day'] + 1);// % 7;
	$datax = array();
	$datay = array();
	$j = 0;
	reset($daystu);
	while(($u = current($daystu)) && $j<7){
		while (((abs($u['day'] - $i))%7 != 1 && (abs($u['day'] - $i))%7 != 6) && $j<6){	
			$i = ($i - 1);// % 7;
			$j = $j + 1;	
			array_push($datay,0);
			array_push($datax,$i);			
		}
		array_push($datay,$u['users']);	
		array_push($datax,$u['day']);
		$i = $u['day'];
		next($daystu);
		$j = $j + 1;			
	}
	$datax = array_reverse($datax);
	$datay = array_reverse($datay);	       	       
	/*$datay=array(12,26,9,17,31);*/
	$datax_str=array("Sat","Sun","Mon","Tue","Wed","Thu","Fri");
	$datax_final = array();
	reset($datax);
	foreach($datax as $d)
		array_push($datax_final, $datax_str[$d]);
	$datax = $datax_final;

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

	$bplot->SetFillColor("orange");

	// Use a shadow on the bar graphs (just use the default settings)
	$bplot->SetShadow();
	$bplot->value->SetFormat(" $ %2.1f",70);
	$bplot->value->SetFont(FF_ARIAL,FS_NORMAL,9);
	$bplot->value->SetColor("blue");
	$bplot->value->Show();

	$graph->Add($bplot);

	//$graph->xaxis->title->Set("X-title");
	$graph->yaxis->title->Set("no. of visitors".(count($daystu))." ".$k);

	$graph->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->xaxis->SetTickLabels($datax);

	$graph->Stroke();

?>



