<?php 
require 'helpers.php';


// test with this example page
$url    = 'https://crpgaddict.blogspot.com/2021/05/orb-quest-part-1-search-for-seven-wards.html';
$ch     = curl_init($url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

// extract the dom
$dom = new DOMDocument;
libxml_use_internal_errors($result);
$dom->loadHTML($result);

//Zend_Dom_Query makes it easier, but needs to be installed
$xPath      = new DomXPath($dom);
$date       = getElementsByClass($dom, $xPath, "date-header", ['returnContent'=>1]);
$title      = getElementsByClass($dom, $xPath, "post-title", ['returnContent'=>1]);
$bodyItem   = getElementsByClass($dom, $xPath, "post-body", ['returnHTML'=>0]);
$body       = getElementsByClass($dom, $xPath, "post-body", ['returnHTML'=>1]);

// Image management
$images = $bodyItem->getElementsByTagName('img');
foreach($images as $image){
        $src    = $image->getAttribute('src');
        $new_img_path = download_image($src);
        $body   = str_replace($src, $new_img_path, $body);
}

?><html>
    <head>
        <style>
            body {
                font: sans-serif;
            }
            .wrapper {
                text-align: center;
            }
            #intro {
                margin: auto;
                text-align: left;
                padding: 10px 20px; 
                width: 400px;
                max-width: 100%;
                border: 1px solid #444;
                background: #eee;
                border-radius: 5px;
            }
            article {
                
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            article > div {
                max-width: 1000px;
            }
        </style>
    </head>
    <body>
        <div class='wrapper'>
        <div id="intro">
            <p>This is a demo where we scrap and crawl the url <i><?php echo $url; ?></i></p>
            <p> the images are downloaded into the folder `/downloads`</p>
            <p>We would need to fetch the comments as well, and cleanup the content html, but the creation of Wordpress posts should not be difficult</p>
        </div>
        </div>
    </body>
</html>

<article>
    <div class="article-wrapper">
        <h1><?php echo $title; ?></h1>
        <date><?php echo $date; ?></date>
        <div class="post-entry">
            <?php echo $body ; ?>
        </div>
    </div>
</article>

<?php 
// $tags = $dom->getElementsByTagName('img');
// Now from there we should download all the images into a folder
// correct all the <img> tags with the local src of the downloaded images.