<?php
//The article reading quantity statistics
function kratos_set_post_views(){
    if(is_singular()){
      global $post;
      $post_ID = $post->ID;
      if($post_ID){
          $post_views = (int)get_post_meta($post_ID,'views',true);
          if(!update_post_meta($post_ID,'views',($post_views+1))) add_post_meta($post_ID,'views',1,true);
      }
    }
}
add_action('wp_head','kratos_set_post_views');
function num2tring($num){
    if($num>=1000) $num = round($num/1000*100)/100 .'k';
    return $num;
}
function kratos_get_post_views($before='',$after='',$echo=1){
  global $post;
  $post_ID = $post->ID;
  $views = (int)get_post_meta($post_ID,'views',true);
  return num2tring($views);
}
//Appreciate the article
function kratos_love(){
    global $wpdb,$post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if($action=='love'){
        $raters = get_post_meta($id,'love',true);
        $expire = time()+99999999;
        $domain = ($_SERVER['HTTP_HOST']!='localhost')?$_SERVER['HTTP_HOST']:false;
        setcookie('love_'.$id,$id,$expire,'/',$domain,false);
        if(!$raters||!is_numeric($raters)){
            update_post_meta($id,'love',1);
        }else{
            update_post_meta($id,'love',($raters+1));
        }
        echo get_post_meta($id,'love',true);
    }
    die;
}
add_action('wp_ajax_nopriv_love','kratos_love');
add_action('wp_ajax_love','kratos_love');
//Post title optimization
add_filter('private_title_format','kratos_private_title_format' );
add_filter('protected_title_format','kratos_private_title_format' );
function kratos_private_title_format($format){return '%s';}
//Password protection articles
add_filter('the_password_form','custom_password_form');
function custom_password_form(){
    $url = wp_login_url();
    global $post;$label='pwbox-'.(empty($post->ID)?rand():$post->ID);$o='
    <form class="protected-post-form" action="'.$url.'?action=postpass" method="post">
        <div class="panel panel-pwd">
            <div class="panel-body text-center">
                <img class="post-pwd" src="'.get_template_directory_uri().'/static/images/fingerprint.png"><br />
                <h4>'.__('这是一篇受保护的文章，请输入阅读密码！','moedog').'</h4>
                <div class="input-group" id="respond">
                    <div class="input-group-addon"><i class="fa fa-key"></i></div>
                    <p><input class="form-control" placeholder="'.__('输入阅读密码','moedog').'" name="post_password" id="'.$label.'" type="password" size="20"></p>
                </div>
                <div class="comment-form" style="margin-top:15px;"><button id="generate" class="btn btn-primary btn-pwd" name="Submit" type="submit">'.__('确认','moedog').'</button></div>
            </div>
        </div>
    </form>';
return $o;
}
//Comments face
add_filter('smilies_src','custom_smilies_src',1,10);
function custom_smilies_src($img_src,$img,$siteurl){
    if(kratos_option('owo_out')) $owodir = 'https://cdn.jsdelivr.net/gh/xb2016/kratos-pjax@'.KRATOS_VERSION; else $owodir = get_bloginfo('template_directory');
    // return $owodir.'/static/images/smilies/'.$img;
    return 'https://gaoice.ba7jcm.live/wp-content/themes/kratos-pjax-master/static/images/smilies/'.$img;
}
function smilies_reset(){
    global $wpsmiliestrans,$wp_smiliessearch,$wp_version;
    if(!get_option('use_smilies')||$wp_version<4.2) return;
    $wpsmiliestrans = array(
     ':hehe:' => 'hehe.png',
     ':haha:' => 'haha.png',
    ':tushe:' => 'tushe.png',
        ':a:' => 'a.png',
       ':ku:' => 'ku.png',
       ':nu:' => 'nu.png',
   ':kaixin:' => 'kaixin.png',
      ':han:' => 'han.png',
      ':lei:' => 'lei.png',
  ':heixian:' => 'heixian.png',
    ':bishi:' => 'bishi.png',
':bugaoxing:' => 'bugaoxing.png',
 ':zhenbang:' => 'zhenbang.png',
     ':qian:' => 'qian.png',
    ':yiwen:' => 'yiwen.png',
  ':yinxian:' => 'yinxian.png',
       ':tu:' => 'tu.png',
       ':yi:' => 'yi.png',
    ':weiqv:' => 'weiqv.png',
   ':huaxin:' => 'huaxin.png',
       ':hu:' => 'hu.png',
  ':xiaoyan:' => 'xiaoyan.png',
     ':leng:' => 'leng.png',
':taikaixin:' => 'taikaixin.png',
     ':meng:' => 'meng.png',
    ':huaji:' => 'huaji.png',
   ':huaji2:' => 'huaji2.png',
   ':huaji3:' => 'huaji3.gif',
   ':huaji4:' => 'huaji4.png',
   ':huaji5:' => 'huaji5.gif',
   ':huaji6:' => 'huaji6.png',
   ':huaji7:' => 'huaji7.png',
   ':huaji8:' => 'huaji8.png',
   ':huaji9:' => 'huaji9.png',
  ':huaji10:' => 'huaji10.png',
  ':huaji11:' => 'huaji11.png',
  ':huaji12:' => 'huaji12.png',
  ':huaji13:' => 'huaji13.png',
  ':huaji14:' => 'huaji14.png',
  ':huaji15:' => 'huaji15.png',
  ':huaji16:' => 'huaji16.gif',
  ':huaji17:' => 'huaji17.png',
  ':huaji18:' => 'huaji18.png',
  ':huaji19:' => 'huaji19.png',
  ':huaji20:' => 'huaji20.gif',
  ':huaji21:' => 'huaji21.gif',
  ':huaji22:' => 'huaji22.png',
  ':huaji23:' => 'huaji23.png',
':mianqiang:' => 'mianqiang.png',
 ':kuanghan:' => 'kuanghan.png',
     ':guai:' => 'guai.png',
 ':shuijiao:' => 'shuijiao.png',
   ':jingku:' => 'jingku.png',
  ':shengqi:' => 'shengqi.png',
   ':jingya:' => 'jingya.png',
      ':pen:' => 'pen.png',
    ':aixin:' => 'aixin.png',
   ':xinsui:' => 'xinsui.png',
   ':meigui:' => 'meigui.png',
     ':liwu:' => 'liwu.png',
  ':caihong:' => 'caihong.png',
     ':xxyl:' => 'xxyl.png',
      ':sun:' => 'sun.png',
    ':money:' => 'money.png',
     ':bulb:' => 'bulb.png',
      ':cup:' => 'cup.png',
     ':cake:' => 'cake.png',
    ':music:' => 'music.png',
    ':haha2:' => 'haha2.png',
      ':win:' => 'win.png',
     ':good:' => 'good.png',
      ':bad:' => 'bad.png',
       ':ok:' => 'ok.png',
     ':stop:' => 'stop.png',
   ':hahaha:' => 'hahaha.png',
   ':coolapk1:' => 'coolapk1.png',
   ':coolapk2:' => 'coolapk2.png',
   ':coolapk3:' => 'coolapk3.png',
   ':coolapk4:' => 'coolapk4.png',
   ':coolapk5:' => 'coolapk5.png',
   ':coolapk6:' => 'coolapk6.png',
   ':coolapk7:' => 'coolapk7.png',
   ':coolapk8:' => 'coolapk8.png',
   ':coolapk9:' => 'coolapk9.png',
   ':coolapk10:' => 'coolapk10.png',
   ':coolapk11:' => 'coolapk11.png',
   ':coolapk12:' => 'coolapk12.png',
   ':coolapk13:' => 'coolapk13.png',
   ':coolapk14:' => 'coolapk14.png',
   ':coolapk15:' => 'coolapk15.png',
   ':coolapk16:' => 'coolapk16.png',
   ':coolapk17:' => 'coolapk17.png',
   ':coolapk18:' => 'coolapk18.png',
   ':coolapk19:' => 'coolapk19.png',
   ':coolapk20:' => 'coolapk20.png',
   ':coolapk21:' => 'coolapk21.png',
   ':coolapk22:' => 'coolapk22.png',
   ':coolapk23:' => 'coolapk23.png',
   ':coolapk24:' => 'coolapk24.png',
   ':coolapk25:' => 'coolapk25.png',
   ':coolapk26:' => 'coolapk26.png',
   ':coolapk27:' => 'coolapk27.png',
   ':coolapk28:' => 'coolapk28.png',
   ':coolapk29:' => 'coolapk29.png',
   ':coolapk30:' => 'coolapk30.png',
   ':coolapk31:' => 'coolapk31.png',
   ':coolapk32:' => 'coolapk32.png',
   ':coolapk33:' => 'coolapk33.png',
   ':coolapk34:' => 'coolapk34.png',
   ':coolapk35:' => 'coolapk35.png',
   ':coolapk36:' => 'coolapk36.png',
   ':coolapk37:' => 'coolapk37.png',
   ':coolapk38:' => 'coolapk38.png',
   ':coolapk39:' => 'coolapk39.png',
   ':coolapk40:' => 'coolapk40.png',
   ':coolapk41:' => 'coolapk41.png',
   ':coolapk42:' => 'coolapk42.png',
   ':coolapk43:' => 'coolapk43.png',
   ':coolapk44:' => 'coolapk44.png',
   ':coolapk45:' => 'coolapk45.png',
   ':coolapk46:' => 'coolapk46.png',
   ':coolapk47:' => 'coolapk47.png',
   ':coolapk48:' => 'coolapk48.png',
   ':coolapk49:' => 'coolapk49.png',
   ':coolapk50:' => 'coolapk50.png',
   ':coolapk51:' => 'coolapk51.png',
   ':coolapk52:' => 'coolapk52.png',
   ':coolapk53:' => 'coolapk53.png',
   ':coolapk54:' => 'coolapk54.png',
   ':coolapk55:' => 'coolapk55.png',
   ':coolapk56:' => 'coolapk56.png',
   ':coolapk57:' => 'coolapk57.png',
   ':coolapk58:' => 'coolapk58.png',
   ':coolapk59:' => 'coolapk59.png',
   ':coolapk60:' => 'coolapk60.png',
   ':coolapk61:' => 'coolapk61.png',
   ':coolapk62:' => 'coolapk62.png',
   ':coolapk63:' => 'coolapk63.png',
   ':coolapk64:' => 'coolapk64.png',
   ':coolapk65:' => 'coolapk65.png',
   ':coolapk66:' => 'coolapk66.png',
   ':coolapk67:' => 'coolapk67.png',
   ':coolapk68:' => 'coolapk68.png',
   ':coolapk69:' => 'coolapk69.png',
   ':coolapk70:' => 'coolapk70.png',
   ':coolapk71:' => 'coolapk71.png',
   ':coolapk72:' => 'coolapk72.png',
   ':coolapk73:' => 'coolapk73.png',
   ':coolapk74:' => 'coolapk74.png',
   ':coolapk75:' => 'coolapk75.png',
   ':coolapk76:' => 'coolapk76.png',
   ':coolapk77:' => 'coolapk77.png',
   ':coolapk78:' => 'coolapk78.png',
   ':coolapk79:' => 'coolapk79.png',
   ':coolapk80:' => 'coolapk80.png',
   ':coolapk81:' => 'coolapk81.png',
   ':coolapk82:' => 'coolapk82.png',
   ':coolapk83:' => 'coolapk83.png',
   ':coolapk84:' => 'coolapk84.png',
   ':coolapk85:' => 'coolapk85.png',
   ':coolapk86:' => 'coolapk86.png',
   ':coolapk87:' => 'coolapk87.png',
   ':coolapk88:' => 'coolapk88.png',
   ':coolapk89:' => 'coolapk89.png',
   ':coolapk90:' => 'coolapk90.png',
   ':coolapk91:' => 'coolapk91.png',
   ':coolapk92:' => 'coolapk92.png',
   ':coolapk93:' => 'coolapk93.png',
   ':coolapk94:' => 'coolapk94.png',
   ':coolapk95:' => 'coolapk95.png',
   ':coolapk96:' => 'coolapk96.png',
   ':coolapk97:' => 'coolapk97.png',
   ':coolapk98:' => 'coolapk98.png',
   ':coolapk99:' => 'coolapk99.png',
   ':coolapk100:' => 'coolapk100.png',
   ':coolapk101:' => 'coolapk101.png',
   ':coolapk102:' => 'coolapk102.png',
   ':coolapk103:' => 'coolapk103.png',
   ':coolapk104:' => 'coolapk104.png',
   ':coolapk105:' => 'coolapk105.png',
   ':coolapk106:' => 'coolapk106.png',
   ':coolapk107:' => 'coolapk107.png',
   ':coolapk108:' => 'coolapk108.png',
   ':coolapk109:' => 'coolapk109.png',
   ':coolapk110:' => 'coolapk110.png',
   ':coolapk111:' => 'coolapk111.png',
   ':coolapk112:' => 'coolapk112.png',
   ':coolapk113:' => 'coolapk113.png',
   ':coolapk114:' => 'coolapk114.png',
   ':coolapk115:' => 'coolapk115.png',
   ':coolapk116:' => 'coolapk116.png',
   ':coolapk117:' => 'coolapk117.png',
   ':coolapk118:' => 'coolapk118.png',
   ':coolapk119:' => 'coolapk119.png',
   ':coolapk120:' => 'coolapk120.png',
   ':coolapk121:' => 'coolapk121.png',
   ':coolapk122:' => 'coolapk122.png',
   ':coolapk123:' => 'coolapk123.png',
   ':coolapk124:' => 'coolapk124.png',
   ':coolapk125:' => 'coolapk125.png',
   ':coolapk126:' => 'coolapk126.png',
   ':coolapk127:' => 'coolapk127.png',
   ':coolapk128:' => 'coolapk128.png',
   ':coolapk129:' => 'coolapk129.png',
   ':coolapk130:' => 'coolapk130.png',
   ':coolapk131:' => 'coolapk131.png',
   ':coolapk132:' => 'coolapk132.png',
   ':coolapk133:' => 'coolapk133.png',
   ':coolapk134:' => 'coolapk134.png',
   ':coolapk135:' => 'coolapk135.png',
   ':coolapk136:' => 'coolapk136.png',
   ':coolapk137:' => 'coolapk137.png',
   ':coolapk138:' => 'coolapk138.png',
   ':coolapk139:' => 'coolapk139.png',
   ':coolapk140:' => 'coolapk140.png',
   ':coolapk141:' => 'coolapk141.png',
   ':coolapk142:' => 'coolapk142.png',
   ':coolapk143:' => 'coolapk143.png',
   ':coolapk144:' => 'coolapk144.png',
   ':coolapk145:' => 'coolapk145.png',
   ':coolapk146:' => 'coolapk146.png',
   ':coolapk147:' => 'coolapk147.png',
   ':coolapk148:' => 'coolapk148.png',
   ':coolapk149:' => 'coolapk149.png',
   ':coolapk150:' => 'coolapk150.png',
   ':coolapk151:' => 'coolapk151.png',
    );
}
smilies_reset();
//Paging
function kratos_pages($range=5){
    global $paged,$wp_query,$max_page;
    if(!$max_page){$max_page=$wp_query->max_num_pages;}
    if($max_page>1){if(!$paged){$paged=1;}
    echo "<div class='text-center' id='page-footer'><ul class='pagination'>";
        if($paged != 1) echo '<li><a href="'.get_pagenum_link(1).'" class="extend" title="'.__('首页','moedog').'">&laquo;</a></li>';
        if($paged>1) echo '<li><a href="'.get_pagenum_link($paged-1).'" class="prev" title="'.__('上一页','moedog').'">&lt;</a></li>';
        if($max_page>$range){
            if($paged<$range){
                for($i=1;$i<=($range+1);$i++){
                    echo "<li";
                    if($i==$paged) echo " class='active'";
                    echo "><a href='".get_pagenum_link($i)."'>$i</a></li>";
                }
            }
            elseif($paged>=($max_page-ceil(($range/2)))){
                for($i=$max_page-$range;$i<=$max_page;$i++){
                    echo "<li";
                    if($i==$paged) echo " class='active'";echo "><a href='".get_pagenum_link($i)."'>$i</a></li>";
                }
            }
            elseif($paged>=$range&&$paged<($max_page-ceil(($range/2)))){
                for($i=($paged-ceil($range/2));$i<=($paged+ceil(($range/2)));$i++){
                    echo "<li";
                    if($i==$paged) echo " class='active'";
                    echo "><a href='".get_pagenum_link($i)."'>$i</a></li>";
                }
            }
        }else{
            for($i=1;$i<=$max_page;$i++){
                echo "<li";
                if($i==$paged) echo " class='active'";
                echo "><a href='".get_pagenum_link($i)."'>$i</a></li>";
            }
        }
        if($paged<$max_page) echo '<li><a href="'.get_pagenum_link($paged+1).'" class="next" title="'.__('下一页','moedog').'">&gt;</a></li>';
        if($paged!=$max_page) echo '<li><a href="'.get_pagenum_link($max_page).'" class="extend" title="'.__('尾页','moedog').'">&raquo;</a></li>';
        echo "</ul></div>";
    }
}