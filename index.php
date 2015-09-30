
<form method="GET">
Root website to crawl:<input type="text" name="site" placeholder="root website" <?php if ($_GET['site']) { echo 'value="'.$_GET['site'].'"' ;}   ?>/><br>
Number of pages to crawl (max 100):<input type="number" name="pages" placeholder="number" value="10"/><br>
Pages must contain this string in url:<input type="text" name="filter" <?php if($_GET['filter']){ echo 'value="'.$_GET['filter'].'" ';}  ?>  placeholder="domain filter for pages to crawl" />
<input type="submit"/>
</form>

<?php
$date = new DateTime();
$output = $date->getTimestamp();
$site = $_GET['site'];
$pages = $_GET['pages'];
$filter = $_GET['filter'];
if ($pages > 100) { $pages = 100;}
exec('python scrape.py '.$site.' '.$pages.' '.$filter,$array);
foreach ($array as $item){
	echo '<li>'.$item.'</li>';
}


