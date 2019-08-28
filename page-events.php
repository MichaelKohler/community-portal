<?php get_header(); ?>
  <header class="events__hero">
    <?php 
      $pagename = get_query_var('pagename');  
    ?>
    <div class="events__container">
      <h1><?php echo ucfirst($pagename) ?></h1>
      <p>A short paragraph about why events are great and why people should look for some near them.</p>
    </div>
  </header>
  <div class="content events__container">
    <form action="POST">
      <fieldset>
        <input class="input" type="search" placeholder="Search events">
        <button class="button button--small" type="submit">Search</button>
      </fieldset> 
      <fieldset>
        <label class="label label--inline" for="location">Location</label>
        <input class="input" type="text" id="location">
        <label for="tags">Tags</label>
        <ul class="checkbox-container">
          <li>
            <input class="checkbox-check" type="checkbox" value="localization" id="localization">
            <label for="localization">Localization</label>
          </li>
        
        </ul>
      </fieldset>
    </form>
    <?php 
      $events = new WP_Query(array(
        'post_type' => 'event',
      ));
      if ($events->have_posts()) {
        while($events->the_post());
      }
    ?>
    <ul>
      <li><a href="#">Upcoming Events</a></li>
      <li><a href="#">Events I'm Attending</a></li>
      <li><a href="#">Events I've Organized</a></li>
      <li><a href="#">Past Events</a></li>
    </ul>
    <button class="button button--smaller">Create an event</button>
    <div class="card">
      <?php $month = substr(get_the_date('F'),0,3) ?>
      <p><?php echo $month?>
        <span>
          <?php echo get_the_date( 'd' ); ?>
        </span>
      </p>
      <h2><?php the_title() ?></h2>
      <p><?php echo $month.' '.get_the_date('d, Y').' @ '.get_the_time('H:i').' '.get_the_time('T')?></p>
    </div>
  </div>
<?php get_footer(); ?>