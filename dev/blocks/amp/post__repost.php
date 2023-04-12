<?php

$description = urlencode($article->meta_description);
$url = urlencode($article->url);
$title = urlencode($article->name);
$image = urlencode($article->cover_l);

$description = preg_replace('/\'/', '%27', $description);
$title = preg_replace('/\'/', '%27', $title);

$vkImage = '';
if ($image && $image != '') 
{
	$vkImage = '&image=' . $image;
}
?>

<div class="postRepost post__repost"
    data-url = "<?php echo $article->url ?>"
    data-title = "<?php echo $article->name ?>"
    data-image = "<?php echo $article->cover_l ?>"
    data-description = "<?php echo $article->meta_description ?>"
>

    <a class="btn postRepost__item postRepost__item--fb" target="_blank" href="//www.facebook.com/sharer/sharer.php?u=<?=$url?>"><i class="icon icon--bigFb"></i></a>
    
    <a class="btn postRepost__item postRepost__item--vk" target="_blank" href="//vk.com/share.php?url=<?=$url?>&title=<?=$title?>&image=<?=$vkImage?>&description=<?=$description?>"><i class="icon icon--bigVk"></i></a>
    
    <a class="btn postRepost__item postRepost__item--twitter" target="_blank" href="//twitter.com/intent/tweet?text=<?=$title?>&url=<?=$url?>"><i class="icon icon--bigTwitter"></i></a>
    
    <a class="btn postRepost__item postRepost__item--odnoklassniki" target="_blank" href="//ok.ru/dk?st.cmd=addShare&st._surl=<?=$url?>&title=<?=$title?>"><i class="icon icon--bigOdnoklassniki"></i></a>
    
    <a class="btn postRepost__item postRepost__item--pinterest" target="_blank" href="//pinterest.com/pin/create/button/?url=<?=$url?>&media=<?=$image?>&description=<?=$title?>"><i class="icon icon--bigPinterest"></i></a>
</div>
