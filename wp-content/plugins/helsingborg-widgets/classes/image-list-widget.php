<?php
if (!class_exists('Image_List')) {
  class Image_List
  {
    /**
     * Constructor
     */
    public function __construct()
    {
      add_action( 'widgets_init', array( $this, 'add_widgets' ) );
    }

    /**
     * Add widget
     */
    public function add_widgets()
    {
      register_widget( 'Image_List_Widget' );
    }
  }
}

if (!class_exists('Image_List_Widget')) {
  class Image_List_Widget extends WP_Widget {

    /** constructor */
    function Image_List_Widget() {
      parent::WP_Widget(false, '* Bildlistor', array('description' => 'Lägg till de bilder du vill rendera ut.'));
    }

    public function widget( $args, $instance ) {
      extract($args);

      // Get all the data saved
      $title = apply_filters('widget_title', empty($instance['title']) ? __('List') : $instance['title']);
      $rss_link = empty($instance['rss_link']) ? '#' : $instance['rss_link']; // TODO: Proper default ?
      $show_rss = empty($instance['show_rss']) ? 'rss_no' : $instance['show_rss'];
      $show_placement = empty($instance['show_placement']) ? 'show_in_sidebar' : $instance['show_placement'];
      $show_dates = isset($instance['show_dates']) ? $instance['show_dates'] : false;
      $amount = empty($instance['amount']) ? 1 : $instance['amount'];

      // Retrieved all links
      for ($i = 1; $i <= $amount; $i++) {
        $items[$i-1] = $instance['item'.$i];
        $item_links[$i-1] = $instance['item_link'.$i];
        $item_targets[$i-1] = isset($instance['item_target'.$i]) ? $instance['item_target'.$i] : false;
        $item_ids[$i-1] = $instance['item_id'.$i];

        $item_attachement_id[$i-1] = $instance['attachment_id'.$i];
        $item_imageurl[$i-1] = $instance['imageurl'.$i];
      }

      $grid_size = (count($item_imageurl) >= 3) ? "3" : "2";

      if ($show_placement == 'show_in_sidebar') :
        // Show in sidebar
        echo('<div class="push-links-widget widget large-12 columns">');
          echo('<ul class="push-links-list">');
          foreach ($items as $num => $item) :
            echo('<li class="item-' . ($num + 1) . '">');
              echo('<a href="' . $items_links[$num] . '"><img src="' . $item_imageurl[$num] . '" /></a>');
            echo('</li>');
          endforeach;
          echo('</ul>');
        echo('</div><!-- /.widget -->');
      else :
        // Show under content
        echo('<section class="large-8 columns">');
          echo('<ul class="block-list news-block large-block-grid-'.$grid_size.' medium-block-grid-'.$grid_size.' small-block-grid-2">');
          foreach ($items as $num => $item) :
            echo('<li>');
              echo('<a href="' . $items_links[$num] . '"><img src="' . $item_imageurl[$num] . '" /></a>');
            echo('</li>');
          endforeach;
          echo('</ul>');
        echo('</section>');
      endif;
      
      echo $after_widget;
    }

    public function update( $new_instance, $old_instance) {
      // Save the data
      $instance['title'] = strip_tags($new_instance['title']);
      $instance['rss_link'] = strip_tags($new_instance['rss_link']);
      $amount = $new_instance['amount'];
      $new_item = empty($new_instance['new_item']) ? false : strip_tags($new_instance['new_item']);

      if ( isset($new_instance['position1'])) {
        for($i=1; $i<= $new_instance['amount']; $i++){
          if($new_instance['position'.$i] != -1){
            $position[$i] = $new_instance['position'.$i];
          }else{
            $amount--;
          }
        }
        if($position){
          asort($position);
          $order = array_keys($position);
          if(strip_tags($new_instance['new_item'])){
            $amount++;
            array_push($order, $amount);
          }
        }

      }else{
        $order = explode(',',$new_instance['order']);
        foreach($order as $key => $order_str){
          $num = strrpos($order_str,'-');
          if($num !== false){
            $order[$key] = substr($order_str,$num+1);
          }
        }
      }

      if($order){
        foreach ($order as $i => $item_num) {
          $instance['item'.($i+1)]          = empty($new_instance['item'.$item_num])          ? '' : strip_tags($new_instance['item'.$item_num]);
          $instance['item_link'.($i+1)]     = empty($new_instance['item_link'.$item_num])     ? '' : strip_tags($new_instance['item_link'.$item_num]);
          $instance['item_class'.($i+1)]    = empty($new_instance['item_class'.$item_num])    ? '' : strip_tags($new_instance['item_class'.$item_num]);
          $instance['item_id'.($i+1)]       = empty($new_instance['item_id'.$item_num])       ? '' : strip_tags($new_instance['item_id'.$item_num]);
          $instance['attachment_id'.($i+1)] = empty($new_instance['attachment_id'.$item_num]) ? '' : strip_tags($new_instance['attachment_id'.$item_num]);
          $instance['imageurl'.($i+1)]      = empty($new_instance['imageurl'.$item_num])      ? '' : strip_tags($new_instance['imageurl'.$item_num]);
        }
      }

      $instance['amount'] = $amount;
      $instance['show_rss'] = strip_tags($new_instance['show_rss']);
      $instance['show_placement'] = strip_tags($new_instance['show_placement']);

      return $instance;
    }

    public function form( $instance ) {
      $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'title_link' => '' ) );
      $amount = empty($instance['amount']) ? 1 : $instance['amount'];

      for ($i = 1; $i <= $amount; $i++) {
        $items[$i]                = empty($instance['item'.$i])           ? '' : $instance['item'.$i];
        $item_links[$i]           = empty($instance['item_link'.$i])      ? '' : $instance['item_link'.$i];
        $item_targets[$i]         = empty($instance['item_target'.$i])    ? '' : $instance['item_target'.$i];
        $item_ids[$i]             = empty($instance['item_id'.$i])        ? '' : $instance['item_id'.$i];
        $item_imageurl[$i]        = empty($instance['imageurl'.$i])       ? '' : $instance['imageurl'.$i];
        $item_attachement_id[$i]  = empty($instance['attachment_id'.$i])  ? '' : $instance['attachment_id'.$i];
      }

      $show_placement = empty($instance['show_placement']) ? 'show_in_sidebar' : $instance['show_placement'];
  ?>
      <div class="sllw-row">
        <label><b>OBS! Vart ska denna visas?  </b></label><br>
        <label for="<?php echo $this->get_field_id('show_in_content'); ?>"><input type="radio" name="<?php echo $this->get_field_name('show_placement'); ?>" value="show_in_content" id="<?php echo $this->get_field_id('show_in_content'); ?>" <?php checked($show_placement, "show_in_content"); ?> />  <?php echo __("Under innehållet"); ?></label>
        <label for="<?php echo $this->get_field_id('show_in_sidebar'); ?>"><input type="radio" name="<?php echo $this->get_field_name('show_placement'); ?>" value="show_in_sidebar" id="<?php echo $this->get_field_id('show_in_sidebar'); ?>" <?php checked($show_placement, "show_in_sidebar"); ?> /> <?php echo __("I sidokolumn"); ?></label>
      </div>

      <ul class="sllw-instructions">
        <li><?php echo __("Notera att <b>minst</b> två bilder måste användas om denna widget ska befinna sig under innehållet!"); ?></li>
      </ul>

      <div class="simple-link-list">
      <?php foreach ($items as $num => $item) :
        $item           = esc_attr($item);
        $item_link      = esc_attr($item_links[$num]);
        $checked        = checked($item_targets[$num], 'on', false);
        $item_id        = esc_attr($item_ids[$num]);
        $image_url      = esc_attr($item_imageurl[$num]);
        $attachement_id = esc_attr($item_attachement_id[$num]);
        $click_event    = "helsingborgImageWidget.uploader('" . $this->get_field_id($num) . "', '" . $this->get_field_id('') . "', '" . $num . "' ); return false;";
        ?>

        <div id="<?php echo $this->get_field_id($num); ?>" class="list-item">
          <h5 class="moving-handle"><span class="number"><?php echo $num; ?></span>. <span class="item-title"><?php echo $image_url; ?></span><a class="sllw-action hide-if-no-js"></a></h5>
          <div class="sllw-edit-item" style="display: table;margin: auto;">

            <div class="uploader" style="display: table;margin: auto;">
              <br>
              <div class="widefat" id="<?php echo $this->get_field_id('preview'.$num); ?>">
                <img src="<?php echo $image_url; ?>" />
              </div>
              <br>
              <input type="submit" class="button" style="display: table; margin: auto;" name="<?php echo $this->get_field_name('uploader_button'.$num); ?>" id="<?php echo $this->get_field_id('uploader_button'.$num); ?>" value="Välj bild" onclick="<?php echo $click_event; ?>" />
              <input type="hidden" id="<?php echo $this->get_field_id('attachment_id'.$num); ?>" name="<?php echo $this->get_field_name('attachment_id'.$num); ?>" value="<?php echo abs($instance['attachment_id'.$num]); ?>" />
              <input type="hidden" id="<?php echo $this->get_field_id('imageurl'.$num); ?>" name="<?php echo $this->get_field_name('imageurl'.$num); ?>" value="<?php echo $instance['imageurl'.$num]; ?>" />
            </div>
            <br clear="all" />

            <label for="<?php echo $this->get_field_id('item_link'.$num); ?>"><?php echo __("Länk:"); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('item_link'.$num); ?>" name="<?php echo $this->get_field_name('item_link'.$num); ?>" type="text" value="<?php echo $item_link; ?>" />

            <input type="checkbox" name="<?php echo $this->get_field_name('item_target'.$num); ?>" id="<?php echo $this->get_field_id('item_target'.$num); ?>" <?php echo $checked; ?> /> <label for="<?php echo $this->get_field_id('item_target'.$num); ?>"><?php echo __("Öppna i nytt fönster"); ?></label>
            <a class="sllw-delete hide-if-no-js"><img src="<?php echo plugins_url('../images/delete.png', __FILE__ ); ?>" /> <?php echo __("Remove"); ?></a>
          </div>
        </div>

      <?php endforeach;

      if ( isset($_GET['editwidget']) && $_GET['editwidget'] ) : ?>
        <table class='widefat'>
          <thead><tr><th><?php echo __("Item"); ?></th><th><?php echo __("Position/Action"); ?></th></tr></thead>
          <tbody>
            <?php foreach ($items as $num => $item) : ?>
            <tr>
              <td><?php echo esc_attr($item); ?></td>
              <td>
                <select id="<?php echo $this->get_field_id('position'.$num); ?>" name="<?php echo $this->get_field_name('position'.$num); ?>">
                  <option><?php echo __('&mdash; Select &mdash;'); ?></option>
                  <?php for($i=1; $i<=count($items); $i++) {
                    if($i==$num){
                      echo "<option value='$i' selected>$i</option>";
                    }else{
                      echo "<option value='$i'>$i</option>";
                    }
                  } ?>
                  <option value="-1"><?php echo __("Delete"); ?></option>
                </select>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <div class="sllw-row">
          <input type="checkbox" name="<?php echo $this->get_field_name('new_item'); ?>" id="<?php echo $this->get_field_id('new_item'); ?>" /> <label for="<?php echo $this->get_field_id('new_item'); ?>"><?php echo __("Add New Item"); ?></label>
        </div>
      <?php endif; ?>

      </div>
      <div class="sllw-row hide-if-no-js">
        <a class="sllw-add button-secondary"><img src="<?php echo plugins_url('../images/add.png', __FILE__ )?>" /> <?php echo __("Lägg till bild"); ?></a>
      </div>

      <input type="hidden" id="<?php echo $this->get_field_id('amount'); ?>" class="amount" name="<?php echo $this->get_field_name('amount'); ?>" value="<?php echo $amount ?>" />
      <input type="hidden" id="<?php echo $this->get_field_id('order'); ?>" class="order" name="<?php echo $this->get_field_name('order'); ?>" value="<?php echo implode(',',range(1,$amount)); ?>" />

<?php
    }
  }
}
