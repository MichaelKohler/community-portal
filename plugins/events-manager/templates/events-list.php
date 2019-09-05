<?php
    /*
     * Default Events List Template
     * This page displays a list of events, called during the em_content() if this is an events list page.
     * You can override the default display settings pages by copying this file to yourthemefolder/plugins/events-manager/templates/ and modifying it however you need.
     * You can display events however you wish, there are a few variables made available to you:
     *
     * $args - the args passed onto EM_Events::output()
     *
     */
    ?>
    <?php
    $args = apply_filters('em_content_events_args', $args);
    $view = get_query_var( 'view', $default = '');
    if ($view === 'past') {
      $args['scope'] = $view;
    }  else {
      $args['scope'] = 'future';
    }


    $events = EM_Events::get($args);
    $months = array(
      '01' => 'Jan',
      '02' => 'Feb',
      '03' => 'Mar',
      '04' => 'Apr',
      '05' => 'May',
      '06' => 'Jun',
      '07' => 'Jul',
      '08' => 'Aug',
      '09' => 'Sep',
      '10' => 'Oct',
      '11' => 'Nov',
      '12' => 'Dec',
    );

    ?>
    <div class="row">
    <ul class="col-md-12 center-md">
      <li><a href="<?php echo add_query_arg('view', 'future', get_site_url('', 'events')) ?>">Upcoming Events</a></li>
      <li><a href="<?php  echo add_query_arg('view', 'attending', get_site_url('','events')) ?>">Events I'm attending</a></li>
      <li><a href="<?php echo add_query_arg('view', 'organized', get_site_url('','events')) ?>">Events I've organized</a></li>
      <li><a href="<?php echo add_query_arg('view', 'past', get_site_url('','events'))?>">Past events</a></li>
      <li><a href="<?php echo add_query_arg(array('view' => 'organized', 'action' => 'edit'), get_site_url('','events')) ?>">Create an event</a></li>
    </ul>
    <?php

    if ($view === 'attending') {
      bp_em_attending_content();
    } elseif ($view === 'organized'){
      em_locate_template('buddypress/my-events.php', true);
    } else {
      for ($i = 0; $i < count($events); $i = $i + 1) {
        $location = em_get_location($events[$i]->location_id);
        ?>
          <div class="card">
          <!-- <a href="<?php echo get_site_url('', $events[$i]->slug)?>"> -->
          <?php 
              $imgUrl = wp_get_attachment_url( get_post_thumbnail_id($events[$i]->post_id));
              if ($imgUrl) {
                ?>
                <img src="<?php echo $imgUrl ?>" alt="">
                <?php
              }
            ?>
            <?php 
              $month = substr($events[$i]->start_date, 5, 2);
              $date = substr($events[$i]->start_date, 8, 2);
              $year = substr($events[$i]->start_date, 0, 4);
            ?>
            <p><span><?php echo $months[$month] ?> </span><span><?php echo $date ?></span></p>
            <h2><?php echo $events[$i]->event_name; ?></h2>
            <p><?php echo $months[$month].' '.$date.', '.$year.' @ '.substr($events[$i]->event_start_time, 0, 5).' - '.substr($events[$i]->event_end_time, 0, 5).' '.$events[$i]->event_timezone; ?></p>
            <p><?php
              if ($location->address) {
                echo $location->address.' - '; 
              }
              if ($location->town) {
                echo $location->town;
                if ($location->country) {
                  echo ', '.$location->country;
                }
              } else {
                echo $location->country;
              }
            ?></p>
            <?php 
              $tags = get_the_terms($events[$i]->post_id, EM_TAXONOMY_CATEGORY);
              if ($tags) {
                ?>
                <ul>
                  <?php
                    for ($j=0; $j < count($tags); $j = $j + 1) {
                      ?>
                      <li><?php echo $tags[$j]->name ?></li>
                      <?php
                    }
                  ?>
                  </ul>
                <?php
              }
            ?>
            <!-- </a> -->
          </div>
        <?php
      }
    }
    ?>
    </div>