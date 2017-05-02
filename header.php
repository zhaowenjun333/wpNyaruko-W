<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>
<?php if ( is_home() ) {
        bloginfo('name'); echo " - "; bloginfo('description');
    } elseif ( is_category() ) {
        single_cat_title(); echo " - "; bloginfo('name');
    } elseif (is_single() || is_page() ) {
        single_post_title();
    } elseif (is_search() ) {
        echo "搜索结果"; echo " - "; bloginfo('name');
    } elseif (is_404() ) {
        echo '页面未找到!';
    } else {
        wp_title('',true);
    } ?>
</title>
<!-- Stylesheets -->
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有文章" href="<?php echo get_bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有评论" href="<?php bloginfo('comments_rss2_url'); ?>" />
<script type="text/javascript" src="<?php bloginfo("template_url"); ?>/jquery.min.js"></script>
<script type="text/javascript" src="<?php bloginfo("template_url"); ?>/script.js"></script>
<?php
$description = '';
$keywords = '';

if (is_home() || is_page()) {
   // 将以下引号中的内容改成你的主页description
   $description = get_bloginfo('description');

   // 将以下引号中的内容改成你的主页keywords
   $keywords = "";
}
elseif (is_single()) {
   $description1 = get_post_meta($post->ID, "description", true);
   $description2 = str_replace("\n","",mb_strimwidth(strip_tags($post->post_content), 0, 200, "…", 'utf-8'));

   // 填写自定义字段description时显示自定义字段的内容，否则使用文章内容前200字作为描述
   $description = $description1 ? $description1 : $description2;

   // 填写自定义字段keywords时显示自定义字段的内容，否则使用文章tags作为关键词
   $keywords = get_post_meta($post->ID, "keywords", true);
   if($keywords == '') {
      $tags = wp_get_post_tags($post->ID);
      foreach ($tags as $tag ) {
         $keywords = $keywords . $tag->name . ", ";
      }
      $keywords = rtrim($keywords, ', ');
   }
}
elseif (is_category()) {
   // 分类的description可以到后台 - 文章 -分类目录，修改分类的描述
   $description = category_description();
   $keywords = single_cat_title('', false);
}
elseif (is_tag()){
   // 标签的description可以到后台 - 文章 - 标签，修改标签的描述
   $description = tag_description();
   $keywords = single_tag_title('', false);
}
$description = trim(strip_tags($description));
$keywords = trim(strip_tags($keywords));
?>
<meta name="description" content="<?php echo $description; ?>" />
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php wp_head(); ?>

</head>
<?php flush(); ?>
<body>
  <?php
  $wallpapers = scandir("./wallpaper/");
  $sentences = scandir("./sentence/");
  $wallpaperid = rand(0,count($wallpapers)-3)+2;
  $sentenceid = rand(0,count($sentences)-3)+2;
  echo '<style>.bannerimgs {background-image: url(wallpaper/'.$wallpapers[$wallpaperid].');}</style>';
  $nowsentence = "./sentence/".$sentences[$sentenceid];
  if(file_exists($nowsentence)){
      $nowsentence = file_get_contents($nowsentence);
      $nowsentence = str_replace("\n","<br />",$nowsentence);
  } else {
      $nowsentence = "ERROR";
  }
  ?>
  <div id="rightbottommenubox" value="0">
      <div id="rightbottommenuboxf">
          <?php wp_nav_menu(array(
              'container_id' => 'rightbottommenuboxff',
              'theme_location' => 'primary',
              'header-menu' => 'header-menu',
              'menu_id' => 'header-menu',
              'echo' => true,
              'before' => '',
              'after' => '',
              'link_before' => '',
              'link_after' => '',
              'depth' => 1
              ));?>
          <span id="rightbottommenuswitch">
              <span id="rightbottommenuswitch1"></span>
              <span id="rightbottommenuswitch2"></span>
          </span>
      </div>
  </div>
  <div id="bannerimg" class="bannerimgs">
      <div id="bannertw"></div>
      <div id="bannerdw"></div>
      <a href="<?php echo get_option('home'); ?>/"><img id="title" src="resources/title3.gif" alt=<?php bloginfo('name'); ?> name=<?php bloginfo('name'); ?> /></a>
      <div id="sentence"><?=$nowsentence?></div>
      <div id="mainmenubox">
          <?php wp_nav_menu(array(
              'container_id' => 'rightbottommenuboxff',
              'theme_location' => 'primary',
              'header-menu' => 'header-menu',
              'menu_id' => 'header-menu',
              'echo' => true,
              'before' => '',
              'after' => '',
              'link_before' => '',
              'link_after' => '',
              'depth' => 1
              ));?>
          <div id="searchbox">
              <?php get_search_form(); ?>
          </div>
      </div>
      <!--<input type="text" name="keyword" id="keyword" onkeydown="entersearch()"/>-->
  </div>
  <div id="wrapper" class="page">
  <!--<div id="wrapper2" class="page2">-->
<!-- <?php bloginfo('description'); ?> -->
