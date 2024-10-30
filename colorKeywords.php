<?php

/*

Plugin Name: Color Keywords

Plugin URI: http://seoarsivi.com/plugins/color-keywords.seo

Description: With this plug-in you can change words font attributes easily. You only need to write correct CSS codes for font colors, font faces and font sizes..

Author: Özcan BAYĞUŞ

Version: 1.0

Author URI: http://seoarsivi.com/

*/



$wpdb->colorKeywords = $wpdb->prefix . 'colorKeywords';

function colorKeywords_kurulum() 

{

	 global $wpdb;

    	$db_sql="CREATE TABLE IF NOT EXISTS `$wpdb->colorKeywords` (

  `id` int(11) NOT NULL AUTO_INCREMENT,

  `kelime` varchar(40) NOT NULL,

  `kalin` tinyint(1) NOT NULL,

  `italik` tinyint(1) NOT NULL,

  `cizgili` tinyint(1) NOT NULL,

  `renk` varchar(8) NOT NULL,

  `size` varchar(5) NOT NULL,

  `font` varchar(30) NOT NULL,

  PRIMARY KEY (`id`),

  UNIQUE KEY `kelime` (`kelime`)

) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

    $wpdb->query($db_sql);

echo ' <div id="message" class="updated fade"><p>Database Success! </p></div>';

    add_option('colorKeywords_yazida', 'hayir');

}

if (isset($_GET['activate']) && $_GET['activate'] == 'true') {


    add_action('init', 'colorKeywords_kurulum');

}


add_action('admin_menu', 'yonetime_ekle');

function yonetime_ekle() {

    add_submenu_page('options-general.php', 'colorKeywords', 'Color Keywords', 10, __FILE__, 'colorKeywords_menu');

}


    add_action('wp_head', 'colorKeywords_style');


function colorKeywords_style() {

		?>

<style type="text/css">

<?php 

global $wpdb;

    $sorgu = "SELECT * FROM $wpdb->colorKeywords order by id";

    $sonuclar = $wpdb->get_results($sorgu);

	if ($sonuclar) {

		    

	        foreach ($sonuclar as $sonuc) {

				$css='';

            $kelime=stripslashes($sonuc->kelime);

			$renk=stripslashes($sonuc->renk);

			if(!empty($renk))

			$css.=' color:'.$renk.'; ';

			$font=stripslashes($sonuc->font);

			if(!empty($font))

			$css.=' font-family:'.$font.'; ';

			$size=stripslashes($sonuc->size);

			if(!empty($size))

			$css.=' font-size:'.$size.'; ';

			echo '.colorKeywords'.$sonuc->id.'{'.$css.'}';

        }

	}

?>

</style>

		<?php

	}

function colorKeywords_menu() {

    global $wpdb;

    echo '<div class="wrap">';

    if ($_POST['islem']== 'ekle') { colorKeywords_ekle (); }

    if ($_GET['islem']== 'sil') { colorKeywords_sil (); }

    if ($_POST['islem']== 'duzenle') { colorKeywords_duzenle (); }

    if ($_POST['islem']== 'yazidagoster') { colorKeywords_goster (); }

    $sorgu = "SELECT * FROM $wpdb->colorKeywords order by kelime asc";

    $sonuclar = $wpdb->get_results($sorgu);

     if ($sonuclar) {

        echo '<table width="100%">

  <tr>

    <td width="13%"></td>

    <td width="32%">Keyword</td>

    <td width="5%">Bold</td>

    <td width="5%">Italic</td>

    <td width="9%">Underline</td>

    <td width="10%">Color</td>

    <td width="10%">Font</td>

    <td width="10%">Size</td>

  </tr>';

        foreach ($sonuclar as $sonuc) {

            $kelime=stripslashes($sonuc->kelime);

			$renk=stripslashes($sonuc->renk);

			$font=stripslashes($sonuc->font);

			$size=stripslashes($sonuc->size);

			$kalin=stripslashes($sonuc->kalin);

			if($kalin==1)

			$kalin='checked="checked"';

			$italik=stripslashes($sonuc->italik);

			if($italik==1)

			$italik='checked="checked"';

			$cizgili=stripslashes($sonuc->cizgili);

			if($cizgili==1)

			$cizgili='checked="checked"';

			

			echo '

  <tr>

    <td width="13%">[<a href="'.$_SERVER[PHP_SELF].'?page=color-keywords/colorKeywords.php&islem=sil&silno='.$sonuc->id.'">Del</a>]-[<a href="'.$_SERVER[PHP_SELF].'?page=color-keywords/colorKeywords.php&degistir='.$sonuc->id.'">Edit</a>]</td>

	    <td>

     <input type="text" name="kelime" id="kelime" value="'.$kelime.'" size="40" />

    </td>

    <td>

      <input type="checkbox" name="kalin" id="kalin" '.$kalin.'/>

    </td>

        <td>

      <input type="checkbox" name="italik" id="italik" '.$italik.'/>

    </td>

        <td>

      <input type="checkbox" name="cizgili" id="cizgili" '.$cizgili.'/>

    </td>

    <td><input type="text" name="renk" id="renk" value="'.$renk.'" /></td>

    <td><input type="text" name="font" id="font" value="'.$font.'" /></td>

    <td><input type="text" name="size" id="size" value="'.$size.'" /></td>

  </tr>';

        }

        echo "</table>  <hr />";

    } else { echo "Color Keywords not found  <hr />"; }

// Eğer düzenleme işlemi yapılmak istenmemişse boş bir metin kutusu oluşturuyoruz.

    if (!isset($_GET['degistir'])) {

?> 

<form action="<?php $_SERVER['PHP_SELF'] ?>?page=color-keywords/colorKeywords.php" method="post">

        <fieldset>

        <table width="100%">

  <tr>

    <td width="13%"></td>

    <td width="32%">Keyword</td>

    <td width="5%">Bold</td>

    <td width="5%">Italic</td>

    <td width="9%">Underline</td>

    <td width="10%">Color</td>

    <td width="10%">Font</td>

    <td width="10%">Size</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td>

     <input type="text" name="kelime" id="kelime" size="40" />

    </td>

    <td>

      <input type="checkbox" name="kalin" id="kalin"  value="1"/>

    </td>

        <td>

      <input type="checkbox" name="italik" id="italik"  value="1"/>

    </td>

        <td>

      <input type="checkbox" name="cizgili" id="cizgili"  value="1"/>

    </td>

    <td><input type="text" name="renk" id="renk" /></td>

    <td><input type="text" name="font" id="font" /></td>

    <td><input type="text" name="size" id="size" /></td>

  </tr>

  <tr><td colspan="8" align="right"><INPUT TYPE="hidden" name="islem" value="ekle"><input type="submit" name="submit" value="Color Keyword Add" class="button" tabindex="5" /></td></tr>

</table>

            <INPUT TYPE="hidden" name="islem" value="ekle"></p>

        </fieldset>

    </form>

<?php

    }

    else

    {

      $sql = "SELECT * FROM $wpdb->colorKeywords where id=".$_GET['degistir'];

      $sonuclartekipucu = $wpdb->get_results($sql);

      if ($sonuclartekipucu) {

    foreach ($sonuclartekipucu as $sonuctekipucu) {

?>

              <form action="<?php $_SERVER['PHP_SELF'] ?>?page=color-keywords/colorKeywords.php" method="post">

        <fieldset>
       

              <table width="100%">

  <tr>

    <td width="13%"></td>

    <td width="32%">Keyword</td>

    <td width="5%">Bold</td>

    <td width="5%">Italic</td>

    <td width="9%">Underline</td>

    <td width="10%">Color</td>

    <td width="10%">Font</td>

    <td width="10%">Size</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td>

     <input type="text" name="kelime" id="kelime" value="<?php echo $sonuctekipucu->kelime; ?>" size="40" />

    </td>

    <td>

      <input type="checkbox" name="kalin" id="kalin" <?php if($sonuctekipucu->kalin==1) echo 'checked="checked"'; ?> value="1"/>

    </td>

        <td>

      <input type="checkbox" name="italik" id="italik"  <?php if($sonuctekipucu->italik==1) echo 'checked="checked"'; ?>value="1"/>

    </td>

        <td>

      <input type="checkbox" name="cizgili" id="cizgili" <?php if($sonuctekipucu->cizgili==1) echo 'checked="checked"'; ?> value="1"/>

    </td>

    <td><input type="text" name="renk" id="renk" value="<?php echo $sonuctekipucu->renk; ?>"/></td>

    <td><input type="text" name="font" id="font" value="<?php echo $sonuctekipucu->font; ?>"/></td>

    <td><input type="text" name="size" id="size" value="<?php echo $sonuctekipucu->size; ?>"/></td>

  </tr>

  <tr><td colspan="8" align="right"><input type="submit" name="submit" value="Color Keywords Save" class="button" tabindex="5" /></td></tr>

</table>

            <INPUT TYPE="hidden" name="islem" value="duzenle">

            <INPUT TYPE="hidden" name="id" value="<?php echo $sonuctekipucu->id; ?>">

        </fieldset>

    </form>

<?php

 

} } }

        echo "</div>";

}

function colorKeywords_ekle (){

    global $wpdb ;

    $kelime=$wpdb->escape($_POST['kelime']);

	$kalin=$wpdb->escape($_POST['kalin']);

	$italik=$wpdb->escape($_POST['italik']);

	$cizgili=$wpdb->escape($_POST['cizgili']);

	$renk=$wpdb->escape($_POST['renk']);

	$font=$wpdb->escape($_POST['font']);

	$size=$wpdb->escape($_POST['size']);

	if(!empty($kelime))

	{

    $sql= "INSERT INTO ".$wpdb->colorKeywords." VALUES (NULL,'".$kelime."','".$kalin."','".$italik."','".$cizgili."','".$renk."','".$size."','".$font."')";

    $wpdb->query($sql);

?>

    <div id="message" class="updated fade"><p>Added Color Keywords! </p></div>

<?php

	}

	else

	{

?>

    <div id="message" class="updated fade"><p>Invalid Color Keywords!</p>
    </div>

<?php	

	}

}

//Yeni - New



//Sil-Delete

function colorKeywords_sil () {

     global $wpdb ;

     $sql="DELETE FROM ".$wpdb->colorKeywords." WHERE id='".(int) $_GET['silno']."'";

     $sonuc=$wpdb->query($sql);?>

    <div id="message" class="updated fade">
      <p>Deleted Color Keywords!</p>
    </div>

<?php

}

//Edit - Düzenle

function colorKeywords_duzenle () {

   global $wpdb ;

    $kelime=$wpdb->escape($_POST['kelime']);

	$kalin=$wpdb->escape($_POST['kalin']);

	$italik=$wpdb->escape($_POST['italik']);

	$cizgili=$wpdb->escape($_POST['cizgili']);

	$renk=$wpdb->escape($_POST['renk']);

	$font=$wpdb->escape($_POST['font']);

	$size=$wpdb->escape($_POST['size']);

	if(!empty($kelime))

	{

   $sql="UPDATE ".$wpdb->colorKeywords." SET kelime='".$kelime."' ,kalin='".$kalin."' ,italik='".$italik."' , cizgili='".$cizgili."' , renk='".$renk."' , font='".$font."' , size='".$size."' where id='". (int) $_POST['id']."' ";

   $wpdb->query($sql);

   

   ?>

   <div id="message" class="updated fade">
     <p><strong>Edit Color Keywords!</strong> </p></div>

<?php

	}

	else

	{

	   ?>

   <div id="message" class="updated fade"><p><strong>Invalid Color Keywords!</strong> </p></div>

<?php	

	}

}
 
add_filter('the_content', 'colorKeywords_Content');

function colorKeywords_Content($content) {

    global $wpdb;

    $sorgu = "SELECT * FROM $wpdb->colorKeywords order by id";

    $sonuclar = $wpdb->get_results($sorgu);

	if ($sonuclar) {

		foreach($sonuclar as $k) {

			$kelime=stripslashes($k->kelime);

			$id=stripslashes($k->id);

			$kelime = trim($kelime);

			$content = preg_replace('~\b' . preg_quote($kelime, '~') . '\b(?![^<]*?>)~i', '<span class="colorKeywords'.$id.'">'.$kelime.'</span>', $content);
			
			$kalin=stripslashes($k->kalin);
			if($kalin==1)
			$content = preg_replace('~\b' . preg_quote($kelime, '~') . '\b(?![^<]*?>)~i', '<strong>'.$kelime.'</strong>', $content);
			
			$italik=stripslashes($k->italik);
			if($italik==1)
			$content = preg_replace('~\b' . preg_quote($kelime, '~') . '\b(?![^<]*?>)~i', '<em>'.$kelime.'</em>', $content);
			
			$cizgili=stripslashes($k->cizgili);
			if($cizgili==1)
			$content = preg_replace('~\b' . preg_quote($kelime, '~') . '\b(?![^<]*?>)~i', '<u>'.$kelime.'</u>', $content);

		}

	 }

	return $content;

}



?>