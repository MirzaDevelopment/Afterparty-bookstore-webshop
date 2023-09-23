<?php //Small rss reader for book reviews
$xml= new DOMDocument();
    $xml->load("https://kirkusreviews.com/feeds/rss");


$news=$xml->getElementsByTagName("item");
foreach($news as $article){

    $title= $article->getElementsByTagName("title")->item(0)->nodeValue;
    $link= $article->getElementsByTagName("link")->item(0)->nodeValue;
    $description= $article->getElementsByTagName("description")->item(0)->nodeValue;
    
    echo "<div style='border:1px solid blue; padding:4px;margin:4px;'>";
    echo $title."<br>";
    echo $description."<br>";
    echo "<a href='{$link}'>Read more...</a><br>";
    echo "</div>";

}