<html>
<form method="GET">
Root website to crawl:<input type="text" name="site" placeholder="root website" <?php if ($_GET['site']) { echo 'value="'.$_GET['site'].'"' ;}   ?>/><br>
Depth to crawl (min=0; max=1):<input type="number" name="pages" placeholder="number" value="1"/><br>
Url of pages to be crawled must contain this string:<input type="text" name="filter" <?php if($_GET['filter']){ echo 'value="'.$_GET['filter'].'" ';}  ?>  placeholder="domain filter for pages to crawl" />
<input type="submit"/>
</form>

<?php
$site = $_GET['site'];
$pages = $_GET['pages'];
$filter = $_GET['filter'];
if ($pages > 1) { $pages = 1;}
exec('python scrape.py '.$site.' '.$pages.' '.$filter,$array);
foreach ($array as $item){
	echo '<li>'.$item.'</li>';
}
?>
</html>
