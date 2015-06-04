<?php
    
$factiva_key = getenv( 'FACTIVA_KEY' );
$articleRefs = fetchArticleList();
$articles = [];
foreach ($articleRefs as $index => $article) {
    cleanArticle( fetchArticle( $article['ref'] ) );
    array_push( $articles, $article );
}
echo json_encode( $articles );


function fetchArticleList(){
	global $factiva_key;
	$arefs = [];
	$days = '1';
	$search = 'sc%3Awsjo';

	$url = "http://api.dowjones.com/api/public/2.0/content/headlines/json?EncryptedToken=$factiva_key&DaysRange=$days&SearchString=$search";

	$l = json_decode( file_get_contents( $url ), TRUE );
	$chunks = ceil ( $l["TotalRecords"] / 100 );
	$i = $chunks;

	//handle article list > 100
	while ($i > 0) {
	 	$offset = (string)($chunks - $i) * 100;
	 	$url_new = $url . "&Offset=$offset";
	 	$a = json_decode( file_get_contents( $url_new ), TRUE );
		foreach( $a["Headlines"] as $v) {
		array_push( $arefs, $v["ArticleRef"] );
	    }
	 	$i -= 1; 
	}

	return $arefs; 
    
}

function cleanArticle($article){
    
}

function fetchArticle($ref){
    
}

?>