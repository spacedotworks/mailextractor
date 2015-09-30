<html>
<form method="GET">
Root website to crawl:<br><input type="text" name="site" placeholder="root website" <?php if ($_GET['site']) { echo 'value="'.$_GET['site'].'"' ;}   ?>/><br>
Depth to crawl (min=0; max=1):<br><input type="number" name="limit" placeholder="number" value="1"/><br>
Max pages to crawl (in the case of websites with very high numbers of links per page (min=1; max=20):<br><input type="number" name="pages" placeholder="number" value="10"/><br>
Url of pages to be crawled must contain this string:<br><input type="text" name="filter" <?php if($_GET['filter']){ echo 'value="'.$_GET['filter'].'" ';}  ?>  placeholder="domain filter for pages to crawl" />
<input type="submit"/>
</form>

<?php
$site = $_GET['site'];
$pages = $_GET['pages'];
$limit = $_GET['limit'];
$filter = $_GET['filter'];
if ($pages > 20) { $pages = 20;}
if ($limit > 1) { $limit = 1;}
exec('python scrape.py '.$site.' '.$pages.' '.$limit.' '.$filter,$array);
foreach ($array as $item){
	echo '<li>'.$item.'</li>';
}
?>
</html>
