<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<?php
$wpNyarukoOption = get_option('wpNyaruko_options');
if(@$wpNyarukoOption['wpNyarukoPHPDebug']!='') {
    echo "<!-- wpNyaruko DEBUG MODE -->";
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_once("KagurazakaYashi.php"); ?>
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<meta name="remote_ip" content="<?php echo $_SERVER['REMOTE_ADDR']; ?>"/>
<meta name="forwarded_ip" content="<?php echo $_SERVER['HTTP_X_FORWARDED_FOR']; ?>"/>
<meta name="template" content="wpNyaruko-F" />
<?php echo @$wpNyarukoOption['wpNyarukoHeader']; ?>
<title><?php if ( is_home() ) {
    bloginfo('name'); echo " - "; bloginfo('description');
} elseif ( is_category() ) {
    single_cat_title(); echo " - "; bloginfo('name');
} elseif (is_single() || is_page() ) {
    single_post_title(); echo " - "; bloginfo('name');
} elseif (is_search() ) {
    echo "搜索结果"; echo " - "; bloginfo('name');
} elseif (is_404() ) {
    echo '页面未找到!';
} else {
    wp_title('',true);
} ?></title>
<!-- Stylesheets -->
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<?php include_once("style.php");
wpNyarukoGCSS($wpNyarukoOption); ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php if(@$wpNyarukoOption['wpNyarukoRSSArticle']!='') { ?>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有文章" href="<?php echo get_bloginfo('rss2_url'); ?>" />
<?php } if(@$wpNyarukoOption['wpNyarukoRSSComment']!='') { ?>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有评论" href="<?php bloginfo('comments_rss2_url'); ?>" />
<?php } ?>
<script type="text/javascript" src="<?php echo @$wpNyarukoOption['wpNyarukoJQ']; ?>"></script>
<script type="text/javascript" src="<?php bloginfo("template_url"); ?>/script.js"></script>
<?php
$description = '';
$keywords = '';

if (is_home() || is_page()) {
   $description = get_bloginfo('description');
   $keywords = $wpNyarukoOption['wpNyarukoIndexKeywords'];
}
elseif (is_single()) {
   $description1 = get_post_meta($post->ID, "description", true);
   $description2 = str_replace("\n","",mb_strimwidth(strip_tags($post->post_content), 0, 200, "…", 'utf-8'));
   // 填写自定义字段description时显示自定义字段的内容，否则使用文章内容前?字作为描述
   $description = $description1 ? $description1 : $description2;
   // 填写自定义字段keywords时显示自定义字段的内容，否则使用文章tags作为关键词
   $keywords = get_post_meta($post->ID, "_keywords_value", true);
   if($keywords == '') {
      $tags = wp_get_post_tags($post->ID);
      foreach ($tags as $tag ) {
         $keywords = $keywords . $tag->name . ", ";
      }
      $keywords = rtrim($keywords, ', ');
   }
}
elseif (is_category()) {
   $description = category_description();
   $keywords = single_cat_title('', false);
}
elseif (is_tag()){
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
    <div id="bodyhidden"></div>
  <?php
  $wpuploaddirs = wp_upload_dir();
  $wallpapers = scandir($wpuploaddirs["basedir"]."/".$wpNyarukoOption['wpNyarukoPicDir']."/");
  $wallpaperid = rand(0,count($wallpapers)-3)+2;
  echo '<style>.bannerimgs {background-image: url('.$wpuploaddirs['baseurl'].'/'.$wpNyarukoOption['wpNyarukoPicDir'].'/'.$wallpapers[$wallpaperid].');}</style>';
$sentences = "";
$nowsentence = "";
if ($wpNyarukoOption['wpNyarukoQRtype'] && $wpNyarukoOption['wpNyarukoQRtype'] != "" &&
$wpNyarukoOption['wpNyarukoQRecorrection'] && $wpNyarukoOption['wpNyarukoQRecorrection'] != "" &&
$wpNyarukoOption['wpNyarukoQRmode'] && $wpNyarukoOption['wpNyarukoQRmode'] != "" &&
$wpNyarukoOption['wpNyarukoQRecode'] && $wpNyarukoOption['wpNyarukoQRecode'] != "" &&
$wpNyarukoOption['wpNyarukoQRimgtype'] && $wpNyarukoOption['wpNyarukoQRimgtype'] != ""
) {
    echo '<script type="text/javascript">var qrdef = [';
    echo $wpNyarukoOption['wpNyarukoQRtype'].',';
    echo '"'.$wpNyarukoOption['wpNyarukoQRecorrection'].'",';
    echo '"'.$wpNyarukoOption['wpNyarukoQRmode'].'",';
    echo '"'.$wpNyarukoOption['wpNyarukoQRecode'].'",';
    echo '"'.$wpNyarukoOption['wpNyarukoQRimgtype'].'"];</script>';
} else {
    echo '<script type="text/javascript">var qrdef = [];</script>';
}
if ($wpNyarukoOption['wpNyarukoTextTable'] && $wpNyarukoOption['wpNyarukoTextTable'] != "") {
    $sentences = $wpdb->get_results("select * from ".$wpNyarukoOption['wpNyarukoTextTable']." order by rand() limit 1;")[0];
    if ($sentences && $sentences != null) {
        $nowsentence = $sentences->text;
        if (isset($wpNyarukoOption['wpNyarukoSearchURL']) && $wpNyarukoOption['wpNyarukoSearchURL'] != "" && isset($wpNyarukoOption['wpNyarukoSearchName']) && $wpNyarukoOption['wpNyarukoSearchName'] != "" && $sentences->from != "") {
            $nowsentence .= '</br><a href="'.$wpNyarukoOption['wpNyarukoSearchURL'].$sentences->from.'" target="_blank" title="点击这里可以在《'.$wpNyarukoOption['wpNyarukoSearchName'].'》中搜索「'.$sentences->from.'」词条。可以刷新网页来看看其他句子。" >——'.$sentences->from.'</a>';
        } else if ($sentences->from != "") {
            $nowsentence .= '</br>——'.$sentences->from;
        }
    }
}
  ?>
  <div id="rightbottommenubox" value="0">
      <div id="rightbottommenuboxf">
        <div id="mainmenuwpbox2">
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
        </div>
        <div class="hidden" id="mainmenuwpbox2b">
          <?php wp_nav_menu(array(
              'container_id' => 'rightbottommenuboxff',
              'theme_location' => 'primary2',
              'header-menu' => 'header-menu',
              'menu_id' => 'header-menu',
              'echo' => true,
              'before' => '',
              'after' => '',
              'link_before' => '',
              'link_after' => '',
              'depth' => 1
              ));?>
        </div>
          <span id="rightbottommenuswitch">
              <span id="rightbottommenuswitch1"></span>
              <span id="rightbottommenuswitch2"></span>
          </span>
      </div>
  </div>
  <div id="bannerimg" class="bannerimgs">
      <div id="bannertw"></div>
      <div id="bannerdw"></div>
      <a title="返回<?php bloginfo('name'); ?>主页" href="<?php echo get_option('home'); ?>/">
      <img id="title" src="<?php echo @$wpNyarukoOption['wpNyarukoLogo']; ?>" alt=<?php bloginfo('name'); ?> name=<?php bloginfo('name'); ?> />
      </a>
      <div id="sentence"><?=$nowsentence?></div>
      <div id="mainmenubox">
      <div id="mainmenuwpbox1">
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
      </div>
      <div class="hidden" id="mainmenuwpbox1b">
          <?php wp_nav_menu(array(
              'container_id' => 'rightbottommenuboxff',
              'theme_location' => 'primary2',
              'header-menu' => 'header-menu',
              'menu_id' => 'header-menu',
              'echo' => true,
              'before' => '',
              'after' => '',
              'link_before' => '',
              'link_after' => '',
              'depth' => 1
              ));?>
        </div>
          <div id="searchbox">
              <?php get_search_form(); ?>
          </div>
      </div>
  </div>
  <div id="wrapper" class="page">