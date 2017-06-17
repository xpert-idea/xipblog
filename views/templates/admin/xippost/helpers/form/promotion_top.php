<?php
$url = $_GET['url'];
$val = rand(1,2);
if($val == 1){
	$src = $url."promo_top.png";
	$href = "https://themeforest.net/item/jakiro-fashion-shop-prestashop-theme/14100073?ref=xpert-idea";
}elseif($val == 2){
	$src = $url."promo_top_1.png";
	$href = "https://themeforest.net/item/great-store-ecommerce-prestashop-theme/18303739?ref=xpert-idea";
}else{
	$src= $url."promo_top.png";
	$href= "https://themeforest.net/item/jakiro-fashion-shop-prestashop-theme/14100073?ref=xpert-idea";
}
echo "<div class='".$val." col-lg-12' style='margin-top:5px;margin-bottom:5px;'><a target='_blank' title='Click Here To Get This' href='".$href."'><img style='max-width:100%;height:auto;' src='".$src."' alt='promotional banner'></a></div>";

?>