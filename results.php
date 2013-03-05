<?php
require_once("utils.php");
require_once("private/db.php");

//createTables();

if ( array_key_exists('ib', $_GET) && array_key_exists('id', $_GET) &&
	 array_key_exists('sb', $_GET) && array_key_exists('sd', $_GET) &&
	 array_key_exists('tb', $_GET) && array_key_exists('tc', $_GET) &&
	 array_key_exists('url', $_GET) ) {
	$ib = $_GET['ib'];
	$id = $_GET['id']; // this is the # of images sprited MINUS the number of sprites created
	$sb = $_GET['sb'];
	$sd = $_GET['sd'];
	$tb = $_GET['tb'];
	$tc = $_GET['tc'];
	// The # of bg images when we're done is the number of original images minus the number of images sprited (already offset by the number of sprite images created).
	$ia = $ib - $id;
	// The total size of bg images when we're done is the original size plus the change in size. (Technically, this includes bg images that weren't considered for spriting.)
	$sa = $sb + $sd;

	$url = substr($_GET['url'], 0, 253);

	$now = time();

	$testnameid = 0;
	if ( array_key_exists('testname', $_COOKIE) && strlen($_COOKIE['testname']) > 0 ) {
		$testname = substr($_COOKIE['testname'], 0, 253);
		$command = "insert into spritemetestnames set createdate=$now, testname='$testname';";
		doSimpleCommand($command);
		$query = "select testnameid from spritemetestnames where testname='$testname';";
		$testnameid = doSimpleQuery($query);
	}

	// strip off all querystrings for privacy
	if ( ereg("(http.*)\?", $url, $regs) ) {
		$url = $regs[1];
	}

	$command = "insert into spritemesavings set createdate=$now, url='$url', ib=$ib, ia=$ia, id=$id, sb=$sb, sa=$sa, sd=$sd, tb=$tb, tc=$tc" . 
		( $testnameid ? ", testnameid=$testnameid" : "" ) . ";";
	doSimpleCommand($command);

	header("HTTP/1.0 204 No Content");
	header("Expires: Sun, 11 Dec 2016 00:08:03 GMT");

	return;
}
else if ( array_key_exists('id', $_GET) && array_key_exists('sd', $_GET) && array_key_exists('url', $_GET) ) {
	$now = time();
	$id = $_GET['id'];
	$sd = $_GET['sd'];
	$url = substr($_GET['url'], 0, 253);

	$testnameid = 0;
	if ( array_key_exists('testname', $_COOKIE) && strlen($_COOKIE['testname']) > 0 ) {
		$testname = substr($_COOKIE['testname'], 0, 253);
		$command = "insert into spritemetestnames set createdate=$now, testname='$testname';";
		doSimpleCommand($command);
		$query = "select testnameid from spritemetestnames where testname='$testname';";
		$testnameid = doSimpleQuery($query);
	}

	// strip off all querystrings for privacy
	if ( ereg("(http.*)\?", $url, $regs) ) {
		$url = $regs[1];
	}

	$command = "insert into spritemesavings set createdate=$now, url='$url', id=$id, sd=$sd" .
		( $testnameid ? ", testnameid=$testnameid" : "" ) . ";";
	doSimpleCommand($command);

	header("HTTP/1.0 204 No Content");
	header("Expires: Sun, 11 Dec 2016 00:08:03 GMT");

	return;
}
else if ( array_key_exists('format', $_GET) ) {
	$format = $_GET['format'];
	if ( "html" == $format ) {
		$sHtml = getSavings();
		echo <<<OUTPUT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>SpriteMe Savings</title>
</head>
<body>
$sHtml
</body>
</html>
OUTPUT;
	}
	return;
}
else if ( false === strpos($_SERVER["REQUEST_URI"], "results.php") ) {
	return;
}


function getSummarySavings() {
	$query = "select AVG(id) as iavg, AVG(sd) as savg from spritemesavings;";
	$result = doQuery($query);
	$row = mysql_fetch_assoc($result);
	$iavg = $row['iavg'];
	$savg = $row['savg'];
	mysql_free_result($result);

	$query = "select count(*) from spritemesavings;";
	$count = doSimpleQuery($query);

	return "SpriteMe users have shared <span style='font-weight: bold; color: #000;'>$count results</span> with an average savings of <span style='font-weight: bold; color: #000;'>" . myround($iavg) . " HTTP requests</span> and <span style='font-weight: bold; color: #000;'>" . myround($savg/1000) . "K of data</span>.";
}


function getSavings($bCss = true, $limit = 10, $bTop = false) {
	global $gaUrls;

	$query = "select createdate, url, ib, ia, id, sb, sd, tb, tc from spritemesavings order by createdate desc limit $limit;";
	if ( $bTop ) {
		$hugeRegx .= "";
		for ( $i = 0; $i < count($gaUrls); $i++ ) {
			$url = $gaUrls[$i];
			$url = str_replace("http://", "", $url);
			$query = "select savingsid from spritemesavings, spritemetestnames where spritemesavings.testnameid = spritemetestnames.testnameid and testname = 'top100us' and url regexp '$url' order by spritemesavings.createdate desc limit 1;";
			$savingsid = doSimpleQuery($query);
			if ( $savingsid ) {
				$hugeRegex .= ( $hugeRegex ? " or " : "" ) . "savingsid = $savingsid";
			}
			else {
				error_log("no data: $url");
			}
		}
		$query = "select url, ib, ia, id, sb, sd, tb, tc from spritemesavings where ($hugeRegex) order by (500*id + sd) desc;";
	}
	$result = doQuery($query);

	$sHtml = "";

	if ( $bCss ) {
		$sHtml .= <<<OUTPUT
<style>
.savingstable TH { padding: 2px 8px; color: #333; backgmyround: #CCC; font-weight: bold; }
.savingstable TD { padding: 2px 0; color: #333; backgmyround: #FFF; }
TD.sdate { padding: 2px 8px; }
TD.surl { padding: 2px 16px; }
TD.sreqs { text-align: right; padding: 0; font-weight: bold; }
TD.snum { text-align: right; }
TD.ssize { text-align: right; }
TD.ssizedelta { text-align: right; padding-left: 8px; }
TD.stext { font-size: 0.8em; padding-left: 4px; padding-right: 4px; color: #888; }
TD.sborder { border-left: 0px solid #CCC; padding-left: 16px; }
TD.avg { backgmyround: #FFF; font-weight: bold; text-decoration: none; border-bottom: 1px solid; }
A.asize { text-decoration: none; }
.selrow { background: #F0F0F0; }
</style>
OUTPUT;
	}

	$sHeadersRow = 
		"<tr> <th>&nbsp;</th> " .
		//"<th>&nbsp;</th> " .
		"<th>existing<br>sprites</th> <th>images<br>sprited</th> <th>sprites<br>created</th> <th colspan=2>change<br>in size</th> </tr>\n";

	$sHtml .= "<table border=0 class=savingstable cellspacing=0 cellpadding=0>\n" . $sHeadersRow;

	$avgcntr = $rowcntr = 0;
	$totalImages = $totalDelta = $totalExistingSprites = $totalSpritesCreated = 0;
	$sRows = "";
	while ($row = mysql_fetch_assoc($result)) {
		$url = $row['url'];
		$ib = $row['ib'];
		$id = $row['id'];
		$sb = $row['sb'];
		$sd = $row['sd'];
		$tb = $row['tb'];
		$tc = $row['tc'];

		$iText = "";
		$avgcntr++;
		$rowcntr++;
		$sRow = "<tr" . ( 0 == ($rowcntr % 2) ? "" : " class=selrow" ) . ">" .
			"<td class=sdate>" . date("D h:i a", $row['createdate']) . "</td>" .
			//"<td class=surl><a class=ahover href='$url' target='_blank'>" . shortenUrl($url) . "</a></td>" .
			"<td class=snum style='text-align: center;'>$tb</td>";
		if ( 1 >= $ib || 0 == $tc ) {
			// No background images exist in the page - exclude this site from overall stats.
			$id = "-";
			if ( 1 >= $ib ) {
				$avgcntr--; // doesn't count!
			}

			$sRow .= 
				"<td class='stext' colspan=8 style='text-align: left;'>" . 
				( 1 == $ib ? "only 1 background image" : ( 0 == $ib ? "no background images" : "$ib images, but no sprites found" ) ) . "</td>" .
				"</tr>\n";
		}
		else {
			$totalExistingSprites += $row['tb'];
			$totalSpritesCreated += $row['tc'];
			$totalImages += $row['id'] + $row['tc'];
			$totalDelta += ($row['sd']);

			$sSize = "";
			if ( 0 <= $sd ) {
				// Good - size got smaller!
				$sSize = "<td class=snum style='padding-right: 10px;'><a href='javascript:function(){}' class=asize style='color: #060;' title='" .
					myround(100*$sd/($sd+$sb)) . "% (" . myround($sd/1000) . "K/" . myround(($sb+$sd)/1000) . "K)'>" . ( 0 == myround($sd/1000) ? "" : "-" ) . myround($sd/1000) . "K</a></td>";
			}
			else {
				// Bad - size got bigger
				$sSize = "<td class=snum style='padding-right: 10px;'><a href='javascript:function(){}' class=asize style='color: #C00;' title='" .
					myround(-100*$sd/($sd+$sb)) . "% (" . myround((-1*$sd)/1000) . "K/" . myround(($sb-$sd)/1000) . "K)'>+" . myround((-1*$sd)/1000) . "K</a></td>";
			}

			$sRow .= 
				"<td class=snum style='padding-right: 20px;'>" . ($id+$tc) . "</td>" .
				"<td class=snum style='text-align: center; padding-right: 0;'>$tc</td>" .
				$sSize .
				"</tr>\n";
		}

		$sRows .= $sRow;
	}
	mysql_free_result($result);

	if ( $avgcntr ) {
		$totalDelta = -1*$totalDelta; // a positive delta is really a reduction (minus) in size
		$sHtml .= "" .
			"<tr>" .
			"<td class=avg></td>" .
			//"<td class=avg style='text-align: right; padding-right: 20px;'>AVERAGE</td>" .
			"<td class='snum avg' style='text-align: center; padding-right: 0;'>" . myround($totalExistingSprites/$avgcntr) . "</td>" .
			"<td class='snum avg' style='padding-right: 20px;'>" . myround($totalImages/$avgcntr) . "</td>" .
			"<td class='snum avg' style='text-align: center; padding-right: 0;'>" . myround($totalSpritesCreated/$avgcntr) . "</td>" .
			"<td class='snum avg' style='padding-right: 10px; color: " .
			( $totalDelta > 0 ? "#C00" : "#0A0" ) . ";'>" . ( $totalDelta > 0 ? "+" : "" ) . myround($totalDelta/($avgcntr*1000)) . "K</td>" .
			"</tr>\n" .
			$sRows .
			$sHeadersRow .
			"";

	}

	$sHtml .= "</table>\n";

	return $sHtml;
}


function getSavingsDiff($bCss, $start1, $end1, $start2, $end2) {
	$query1 = "select createdate, url, id, sd from spritemesavings where savingsid >= $start1 and savingsid <= $end1 group by url order by createdate desc;";
	$result1 = doQuery($query1);
	$sHtml = "";

	if ( $bCss ) {
		$sHtml .= <<<OUTPUT
<style>
.savingstable TH { padding: 0; color: #333; backgmyround: #CCC; font-weight: bold; }
.savingstable TD { padding: 2px 8px 2px 8px; color: #333; backgmyround: #FFF; }
TD.surl { padding-right: 0; }
TD.sreqs { text-align: right; padding-right: 16px; padding-left: 0; }
TD.ssize { text-align: right; padding-right: 8px; }
TH.ssize { padding-left: 8px; padding-right: 8px; }
TD.avg { backgmyround: #FFF; font-weight: bold; text-decoration: none; border-bottom: 1px solid; }
</style>
OUTPUT;
	}

	$sHtml .= "<table class=savingstable border=0 cellspacing=0 cellpadding=0>\n" .
		"<tr> <th></th> <th></th> <th class=sreqs>requests<br>eliminated</th> <th class=ssize>bytes<br>saved</th> <th class=sreqs>requests<br>eliminated</th> <th class=ssize>bytes<br>saved</th> </tr>\n";

	$cntr = 0;
	$totalImages1 = 0;
	$totalDelta1 = 0;
	$totalImages2 = 0;
	$totalDelta2 = 0;
	$sRows = "";
	while ($row1 = mysql_fetch_assoc($result1)) {
		$url = $row1['url'];
		$id1 = $row1['id'];
		$sd1 = $row1['sd'];

		$query2 = "select createdate, url, id, sd from spritemesavings where savingsid >= $start2 and savingsid <= $end2 and url = '$url' limit 1;";
		$result2 = doQuery($query2);
		$url2 = "";
		$id2 = $sd2 = 0;
		while ($row2 = mysql_fetch_assoc($result2)) {
			$url2 = $row2['url']; // use this as a flag
			$id2 = $row2['id'];
			$sd2 = $row2['sd'];
			break;
		}
		mysql_free_result($result2);

		if ( $url2 ) {
			$sRows .= "<tr>" .
				"<td class=sdate>" . date("H:i", $row1['createdate']) . "</td>" .
				"<td class=surl><a class=ahover href='" . $row1['url'] . "' target='_blank'>" . shortenUrl($url) . "</a></td>" .
				"<td class=sreqs>$id1</td>" .
				"<td class=ssize>" . myround($sd1/1000) . " K</td>" .
				"<td class=sreqs style='" . ( $id2 > $id1 ? "color: #0A0" : ( $id2 < $id1 ? "color: #C00" : "" ) ) . "'>$id2</td>" .
				"<td class=ssize style='" . ( $sd2 > $sd1 ? "color: #0A0" : ( $sd2 < $sd1 ? "color: #C00" : "" ) ) . "'>" . myround($sd2/1000) . " K</td>" .
				"</tr>\n";
			$cntr++;
			$totalImages1 += $id1;
			$totalDelta1 += $sd1;
			$totalImages2 += $id2;
			$totalDelta2 += $sd2;
		}
	}
	mysql_free_result($result1);

	if ( $cntr ) {
		$sHtml .= "<tr>" .
			"<td class=avg></td>" .
			"<td class=avg style='text-align: right;'>AVERAGE SAVINGS</td>" .
			"<td class='sreqs avg'>" . intval( ($totalImages1/$cntr) + 0.5 ) . "</td>" .
			"<td class='ssize avg'>" . intval( ($totalDelta1/($cntr*1000)) + 0.5 ) . " K</td>" .
			"<td class='sreqs avg'>" . intval( ($totalImages2/$cntr) + 0.5 ) . "</td>" .
			"<td class='ssize avg'>" . intval( ($totalDelta2/($cntr*1000)) + 0.5 ) . " K</td>" .
			"</tr>\n" .
			$sRows .
			"<tr> <th></th> <th></th> <th class=sreqs>requests<br>eliminated</th> <th class=ssize>bytes<br>saved</th> <th class=sreqs>requests<br>eliminated</th> <th class=ssize>bytes<br>saved</th> </tr>\n";

	}

	$sHtml .= "</table>\n";

	return $sHtml;
}


function getSavingsDiffTestnames($bCss, $testname1, $testname2) {
	$query = "select testnameid from spritemetestnames where testname = '$testname1';";
	$testnameid1 = doSimpleQuery($query);
	$query = "select testnameid from spritemetestnames where testname = '$testname2';";
	$testnameid2 = doSimpleQuery($query);
	if ( !testnameid1 || !$testnameid2 ) {
		return;
	}

	$query1 = "select createdate, url, id, sd from spritemesavings where testnameid=$testnameid1 group by url;";
	$result1 = doQuery($query1);
	$sHtml = "";

	if ( $bCss ) {
		$sHtml .= <<<OUTPUT
<style>
.savingstable TH { padding: 0; color: #333; backgmyround: #CCC; font-weight: bold; }
.savingstable TD { padding: 2px 8px 2px 8px; color: #333; backgmyround: #FFF; }
TD.surl { padding-right: 0; }
TD.sreqs { text-align: right; padding-right: 16px; padding-left: 0; }
TD.ssize { text-align: right; padding-right: 8px; }
TH.ssize { padding-left: 8px; padding-right: 8px; }
TD.avg { backgmyround: #FFF; font-weight: bold; text-decoration: none; border-bottom: 1px solid; }
</style>
OUTPUT;
	}

	$sHtml .= "<table class=savingstable border=0 cellspacing=0 cellpadding=0>\n" .
		"<tr> <th></th> <th></th> <th class=sreqs>requests<br>eliminated</th> <th class=ssize>bytes<br>saved</th> <th class=sreqs>requests<br>eliminated</th> <th class=ssize>bytes<br>saved</th> </tr>\n";

	$cntr = 0;
	$totalImages1 = 0;
	$totalDelta1 = 0;
	$totalImages2 = 0;
	$totalDelta2 = 0;
	$sRows = "";
	while ($row1 = mysql_fetch_assoc($result1)) {
		$url = $row1['url'];
		$id1 = $row1['id'];
		$sd1 = $row1['sd'];

		$query2 = "select createdate, url, id, sd from spritemesavings where testnameid=$testnameid2 and url='$url' limit 1;";
		$result2 = doQuery($query2);
		$url2 = "";
		$id2 = $sd2 = 0;
		while ($row2 = mysql_fetch_assoc($result2)) {
			$url2 = $row2['url']; // use this as a flag
			$id2 = $row2['id'];
			$sd2 = $row2['sd'];
			break;
		}
		mysql_free_result($result2);

		if ( $url2 ) {
			$sRows .= "<tr>" .
				"<td class=sdate>" . date("H:i", $row1['createdate']) . "</td>" .
				"<td class=surl><a class=ahover href='" . $row1['url'] . "' target='_blank'>" . shortenUrl($url) . "</a></td>" .
				"<td class=sreqs>$id1</td>" .
				"<td class=ssize>" . myround($sd1/1000) . " K</td>" .
				"<td class=sreqs style='" . ( $id2 > $id1 ? "color: #0A0" : ( $id2 < $id1 ? "color: #C00" : "" ) ) . "'>$id2</td>" .
				"<td class=ssize style='" . ( $sd2 > $sd1 ? "color: #0A0" : ( $sd2 < $sd1 ? "color: #C00" : "" ) ) . "'>" . myround($sd2/1000) . " K</td>" .
				"</tr>\n";
			$cntr++;
			$totalImages1 += $id1;
			$totalDelta1 += $sd1;
			$totalImages2 += $id2;
			$totalDelta2 += $sd2;
		}
	}
	mysql_free_result($result1);

	if ( $cntr ) {
		$sHtml .= "<tr>" .
			"<td class=avg></td>" .
			"<td class=avg style='text-align: right;'>AVERAGE SAVINGS</td>" .
			"<td class='sreqs avg'>" . intval( ($totalImages1/$cntr) + 0.5 ) . "</td>" .
			"<td class='ssize avg'>" . intval( ($totalDelta1/($cntr*1000)) + 0.5 ) . " K</td>" .
			"<td class='sreqs avg'>" . intval( ($totalImages2/$cntr) + 0.5 ) . "</td>" .
			"<td class='ssize avg'>" . intval( ($totalDelta2/($cntr*1000)) + 0.5 ) . " K</td>" .
			"</tr>\n" .
			$sRows .
			"<tr> <th></th> <th></th> <th class=sreqs>requests<br>eliminated</th> <th class=ssize>bytes<br>saved</th> <th class=sreqs>requests<br>eliminated</th> <th class=ssize>bytes<br>saved</th> </tr>\n";

	}

	$sHtml .= "</table>\n";

	return $sHtml;
}


function myround($num1) {
	return intval($num1 + ( 0 < $num1 ? 0.5 : -0.5 ));
}


function shortenUrl($url, $max = 50) {
	//if ( ereg("(http[^\/]*\/\/[^\/]*\/[^\/]*\/).*(\/[^\/]*)$", $url, $regs) ) {

	if ( $max < strlen($url) ) {
		$iSlash = strpos($url, "/", 10);
		$base = substr($url, 0, $iSlash);

		$lastSlash = strrpos($url, "/");
		$filename = substr($url, $lastSlash);

		if ( $iSlash != $lastSlash ) {
			$best = $base . "/..." . $filename;
			if ( strlen($best) < $max ) {
				$iSlash = strpos($url, "/", $iSlash+1);
				$base = substr($url, 0, $iSlash);
				if ( $iSlash != $lastSlash && (strlen($base) + strlen($filename) + strlen("/...")) < $max ) {
					$best = $base . "/..." . $filename;
				}
			}

			$url = $best;
		}
	}

	if ( $max < strlen($url) ) {
		$url = substr($url, 0, $max);
	}

	return $url;
};


function doSimpleCommand($query) {
	global $gsAuth1, $gsAuth2;

	$value = NULL;
	$link = mysql_connect("examples.stevesouders.com", $gsAuth1, $gsAuth2);
	if ( mysql_select_db("perfprofile") ) {
		//error_log("doSimpleCommand: $query");
		mysql_query($query, $link);
	}
}


function doQuery($query) {
	global $gsAuth1, $gsAuth2;

	$value = NULL;
	$link = mysql_connect("examples.stevesouders.com", $gsAuth1, $gsAuth2);
	if ( mysql_select_db("perfprofile") ) {
		//error_log("doQuery: $query");
		$result = mysql_query($query, $link);
		return $result;
	}

	return null;
}


function doSimpleQuery($query) {
	global $gsAuth1, $gsAuth2;

	$value = NULL;
	$link = mysql_connect("examples.stevesouders.com", $gsAuth1, $gsAuth2);
	if ( mysql_select_db("perfprofile") ) {
		//error_log("doSimpleQuery: $query");
		$result = mysql_query($query, $link);
		$row = mysql_fetch_assoc($result);
		if ( $row ) {
			$aKeys = array_keys($row);
			$value = $row[$aKeys[0]];
		}
		mysql_free_result($result);
	}

	return $value;
}


function createTables() {
	if ( 1 == 1 ) {
		$command = "create table spritemesavings (" .
			"savingsid int unsigned not null auto_increment" .
			", createdate int(10) unsigned not null" .
			", url varchar (255) not null" .
			", ib int(4)" .
			", ia int(4)" .
			", id int(4)" .
			", sb int" .
			", sa int" .
			", sd int" .
			", tb int(4)" .
			", tc int(4)" .
			", testnameid int unsigned" .
			", primary key (savingsid)" .
			");";

		doSimpleCommand($command);

		$command = "create table spritemetestnames (" .
			"testnameid int unsigned not null auto_increment" .
			", createdate int(10) unsigned not null" .
			", testname varchar (255) not null" .
			", savingsidstart int" .
			", primary key (testnameid)" .
			", unique key (testname)" .
			");";

		doSimpleCommand($command);
	}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>SpriteMe Savings</title>

<link rel="icon" href="images/favicon.ico" type="image/x-icon">

<style>
<?php
echo spritemeStyle();
?>

</style>

</head>
<body>

<?php 
echo spritemeHeader("savings");
?>


<div id=contents class=contents>

<?php 
echo spritemeNav("sav");
?>

<br>

<p style="margin-top: 40px;">
<?php 
echo ( array_key_exists('top', $_GET) ? "Here are the results for the Alexa U.S. Top 100. " : "Here are some recent results from SpriteMe users. " );
?>
You can record your results by clicking the "share your results" link after running SpriteMe.
See the <a href="faq.php#share">FAQ</a> for more information.
</p>

<?php
if ( array_key_exists('diff', $_GET) ) {
	//echo getSavingsDiff(true, 0, 101, 102, 9999);
	if ( array_key_exists('testname1', $_GET) && array_key_exists('testname2', $_GET) ) {
		echo getSavingsDiffTestnames(true, $_GET['testname1'], $_GET['testname2']);
	}
}
else if ( array_key_exists('top', $_GET) ) {
	echo getSavings(true, 50, true);
}
else {
	echo getSavings(true, 50);
}
?>

<?php
echo spritemeFooter();
?>


</div> <!-- contents -->

</body>

</html>
