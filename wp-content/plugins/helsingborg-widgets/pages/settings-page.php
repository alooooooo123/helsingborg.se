<?php

// Check that the user is allowed to update options
if (!current_user_can('read_private_pages')) {
  wp_die('Du har inte behörighet att editera dessa inställningar. Var god kontakta administratören.');
}

// Check if postback
if (isset($_POST["update_settings"])) {

  // Do the saving
  $color_code = esc_attr($_POST["color_code"]);
  update_option('helsingborg_color_code', $color_code);

  $event_form_id = esc_attr($_POST["event_form_id"]);
  update_option('helsingborg_event_form_id', $event_form_id);

  $big_disturbance_root = esc_attr($_POST["big_disturbance_root"]);
  update_option('helsingborg_big_disturbance_root', $big_disturbance_root);

  $big_information_root = esc_attr($_POST["big_information_root"]);
  update_option('helsingborg_big_information_root', $big_information_root);

  // Custom header image
  $header_image_title = esc_attr($_POST['header_image_title']);
  update_option('helsingborg_header_image_title', $header_image_title);

  $header_image_imageurl = esc_attr($_POST['header_image_imageurl']);
  update_option('helsingborg_header_image_imageurl', $header_image_imageurl);

  $header_image_alt = esc_attr($_POST['header_image_alt']);
  update_option('helsingborg_header_image_alt', $header_image_alt);

  $header_image_item_force_width = esc_attr($_POST['header_image_item_force_width']);
  update_option('helsingborg_header_image_item_force_width', $header_image_item_force_width);

  $header_image_item_force_margin = esc_attr($_POST['header_image_item_force_margin']);
  update_option('helsingborg_header_image_item_force_margin', $header_image_item_force_margin);

  $header_image_item_force_margin_value = esc_attr($_POST['header_image_item_force_margin_value']);
  update_option('helsingborg_header_image_item_force_margin_value', $header_image_item_force_margin_value);

  echo('<div id="message" class="updated">Dina inställningar är sparade!</div>');
}

// Make sure we can use media selector for header
wp_enqueue_media();

// Get all the values
$color_code           = get_option('helsingborg_color_code');
$event_form_id        = get_option('helsingborg_event_form_id');
$big_disturbance_root = get_option('helsingborg_big_disturbance_root');
$big_information_root = get_option('helsingborg_big_information_root');

// Values for upper header image
$header_image_title                   = get_option('helsingborg_header_image_title');
$header_image_imageurl                = get_option('helsingborg_header_image_imageurl');
$header_image_alt                     = get_option('helsingborg_header_image_alt');
$header_image_item_force_width        = get_option('helsingborg_header_image_item_force_width');
$header_image_item_force_margin       = get_option('helsingborg_header_image_item_force_margin');
$header_image_item_force_margin_value = get_option('helsingborg_header_image_item_force_margin_value');

$fw = $header_image_item_force_width  == 'on' ? 'checked' : '';
$fm = $header_image_item_force_margin == 'on' ? 'checked' : '';

?>
<div class="wrap">
  <h2>Inställningar</h2>
  Här finns inställningar specifikt för denna domän.

  <form method="POST" action="">
    <table class="form-table">
      <tr valign="top">
        <th scope="row">
          <label for="color_code">
            Färgkod för domän:
          </label>
        </th>
        <td>
          <input type="text" name="color_code" value="<?php echo $color_code; ?>" />
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
          <label for="event_form_id">
            Formulär-id för evenemang:
          </label>
        </th>
        <td>
          <input type="number" name="event_form_id" value="<?php echo $event_form_id; ?>" />
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
          <label for="big_disturbance_root">
            Storstörningar hämtas från:
          </label>
        </th>
        <td>
            <?php wp_dropdown_pages(array(
              'show_option_none' => 'Ingen sida vald',
              'child_of' => 0,
              'depth' => 1,
              'post_status'  => 'publish,private',
              'selected' => $big_disturbance_root,
              'id' => 'big_disturbance_root',
              'name' => 'big_disturbance_root'
            )); ?>
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
          <label for="big_information_root">
            Storinformation hämtas från:
          </label>
        </th>
        <td>
          <?php wp_dropdown_pages(array(
            'show_option_none' => 'Ingen sida vald',
            'child_of' => 0,
            'depth' => 1,
            'post_status'  => 'publish,private',
            'selected' => $big_information_root,
            'id' => 'big_information_root',
            'name' => 'big_information_root'
          )); ?>
        </td>
      </tr>

      <tr valign="top">
        <th scope="row">
          <label for="big_information_root">
            Använd egen headerbild:
          </label>
        </th>
        <td>
          <div class="hbgllw-edit-item" style="max-width: 50%;padding: 10px;display: block;border: 1px solid grey;">

            <div class="uploader" style="display: table;margin: auto;">
              <br>
              <div id="header_image_preview" style="display: table;margin:auto;">
                <img id="header_image_preview_img" src="<?php echo $header_image_imageurl; ?>" style="max-width: 80%;display: table;margin:auto;"/>
              </div>
              <br>
              <input type="submit" class="button" style="display: table; margin: auto;" name="header_image_uploader_button" id="header_image_uploader_button" value="Välj bild" onclick="helsingborgMediaSelector.create('header_image_', 'header_image_', '' ); return false;" />
              <input type="hidden" id="header_image_title" name="header_image_title" value="<?php echo $header_image_title; ?>" />
              <input type="hidden" id="header_image_imageurl" name="header_image_imageurl" value="<?php echo $header_image_imageurl; ?>" />
              <input type="hidden" id="header_image_alt" name="header_image_alt" value="<?php echo esc_attr(strip_tags($header_image_alt)); ?>" />

            </div>
            <br clear="all" />

            <ul class="hbgllw-instructions">
              <li><?php echo __("<b>Bildinställningar</b>"); ?></li>
            </ul>

            <input type="checkbox" <?php echo $fw; ?> name="header_image_item_force_width" id="header_image_item_force_width"  /> <label for="header_image_item_force_width"><?php echo __("Tvinga bilden att anpassa i bredd"); ?></label>
            <br>
            <input type="checkbox" <?php echo $fm; ?> name="header_image_item_force_margin" id="header_image_item_force_margin" /> <label for="header_image_item_force_margin"><?php echo __("Tvinga förskjutning i Y-led med "); ?></label>
            <input maxlength="4" size="4" id="header_image_item_force_margin_value" name="header_image_item_force_margin_value" type="text" value="<?php echo $header_image_item_force_margin_value; ?>" /> <label for="header_image_item_force_margin_value"><?php echo __(" pixlar."); ?></label>
            <br>
            <input type="button" class="small button" value="Rensa" onclick="clearHeader()" />
          </div>
        </td>
      </tr>
    </table>

    <input type="hidden" name="update_settings" value="Y" />
    <p>
      <input type="submit" value="Spara" class="button-primary"/>
    </p>
  </form>
</div>

<script>
function clearHeader() {
  document.getElementById('header_image_preview_img').src = '';
  document.getElementById('header_image_item_force_margin_value').value = '';
  document.getElementById('header_image_title').value = '';
  document.getElementById('header_image_imageurl').value = '';
  document.getElementById('header_image_alt').value = '';
  document.getElementById('header_image_item_force_width').checked = false;
  document.getElementById('header_image_item_force_margin').checked = false;
}
</script>