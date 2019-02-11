<?php
/**
  Name: Wordpress Video Gallery
  URI: http://www.apptha.com/category/extension/Wordpress/Video-Gallery
  Description: Wordpress Video Gallery Installation file.
  Version: 2.9
  Author: Apptha
  Author URI: http://www.apptha.com
  License: GPL2
 */

/**
 * Function to alter table while upgrade plugin
 * 
 * @param unknown $table
 * @param unknown $column
 * @param string $attributes
 * @return boolean
 */
function add_column_if_not_exists( $table, $column, $attributes = 'INT( 11 ) NOT NULL DEFAULT "0"') {
    global $wpdb;
    /** Varaibale initialization */
    $columnExists = false;
    /**
     * Get columns from plugin tables 
     * and check whether the column is exist in db tables 
     * If not exist then return false 
     */
    $query        = 'SHOW COLUMNS FROM ' . $table;
    if (! $result = $wpdb->query ( $query )) {
      return false;
    }
    /** Check the column is exist with the column list  */
    $columnData   = $wpdb->get_results ( $query );
    foreach ( $columnData as $valueColumn ) {
      /** If column is exist then set true  */
      if ($valueColumn->Field == $column) {
        $columnExists = true;
        break;
      }
    }
    /** Alter table if column not exist in db */ 
    if (! $columnExists) {
      /** Query to alter table for new columns */
      $wpdb->query ( 'ALTER TABLE `' . $table . '` ADD `' . $column . '` ' . $attributes );
      if (! $result = $wpdb->query ( $query )) {
        return false;
      }
    }
    /** Return true if column is added */
    return true;
}

/**
 * Delete Unwanted columns from the table
 * 
 * @param unknown $table
 * @param unknown $column
 * @return boolean
 */
function delete_video_column($table, $column) {
    global $wpdb;
    $columnExists = false;
    /**
     * Check whether the db tables having columns
     * If no columns in db then return false
     */
    $query        = 'SHOW COLUMNS FROM ' . $table;
    if (! $result = $wpdb->query ( $query )) {
      return false;
    }
    /**
     * Check unwanted column is exist
     * If exist then deleted unwanted columns  
     */
    $columnData   = $wpdb->get_results ( $query );
    foreach ( $columnData as $valueColumn ) {
      /** If unwanted column is exist then set true */
      if ($valueColumn->Field == $column) {
        $columnExists = true;
        break;
      }
    }
    /** Delete unwanted column if it is exist */ 
    if ($columnExists) {
      /** Query to delete unwanted column */
      $wpdb->query ( 'ALTER TABLE `' . $table . '` DROP `' . $column . '`;' );
      if (! $result = $wpdb->query ( $query )) {
        return false;
      }
    }
    return true;
}

/**
 * Upgrade post table
 */ 
function upgrade_videos() {
  global $wpdb;
  /** Get slug id from videos table */
  $slugID     = $wpdb->get_results ( 'SELECT slug FROM ' . HDFLVVIDEOSHARE . ' ORDER BY vid DESC LIMIT 1' );
  /** If slug is empty then get video id, name */
  if (empty ( $slugID )) {
      $videoID = $wpdb->get_results ( 'SELECT vid,name FROM ' . HDFLVVIDEOSHARE );
      /** Looping through video details in video table */
      for($i = 0; $i < count ( $videoID ); $i ++) {
          /** Get video seo title from db */
          $slug = sanitize_title ( $videoID [$i]->name );
          /** Get video title from db */
          $name = $videoID [$i]->name;
          /** Get video id from db */
          $vid  = $videoID [$i]->vid;
          /** Get post content from db */
          $post_content = '[hdvideo id=' . $vid . ']';
          /** Insert post details into post table for existing videos */ 
          $wpdb->query ( 'INSERT INTO ' . WVG_POSTS . ' ( `post_author`,`post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count` ) 
              VALUES  
              ( "1","2011-11-15 07:22:39", "2011-11-15 07:22:39", "' . $post_content . '", "' . $name . '", "", "publish", "open", "closed", "", "' . $slug . '", "", "", "2011-11-15 07:22:39", "2011-11-15 07:22:39", "", "0", "", "0","videogallery", "", "0" )' );
          $post_id  = $wpdb->insert_id;
          /** Generate post URL for videos */
          $guid     = home_url () . '/?post_type=video&#038;p=' . $post_id;
          /** Update slug id in plugin's video table  */
          $wpdb->query ( 'UPDATE ' . HDFLVVIDEOSHARE . ' SET slug = ' . $post_id . ' WHERE vid = ' . $vid );
          /** Update guid id in post table */
          $wpdb->query ( 'UPDATE ' . WVG_POSTS . ' SET guid = ' . $guid . ' WHERE ID = ' . $post_id ); 
      }
      /** If old version plugin is used, then get featured video value */
      $featuredID = $wpdb->get_results ( 'SELECT vid FROM ' . HDFLVVIDEOSHARE . ' WHERE featured="ON"' );
      /** Looping through featured video details */
      for($i = 0; $i < count ( $featuredID ); $i++) {
          $vid    = $featuredID [$i]->vid;
          /** Update featured value as 1 from ON */
          $wpdb->query ( 'UPDATE ' . HDFLVVIDEOSHARE . ' SET featured = 1 WHERE vid = ' . $vid );
      }
  }
  /** If old version plugin i used then get skin auto hide from settings  */
  $result = $wpdb->get_results ( "SELECT skin_autohide,player_colors FROM " . WVG_SETTINGS );
  if ($result) {
    /**  Update skin auto hide value as 1 */
    $wpdb->query ( "UPDATE " . WVG_SETTINGS . " SET skin_autohide = 1" );
  }
}

/**
 * Install plugin tables and insert sample videos, playlist
 */
function videogallery_install() {
  global $wpdb;
  /** Function to display instruction while plugin activation */
  update_option ( 'video_gallery_adjustment_instruction', 'adjustment_setting' );
  /** Function to display warning if videogallery folder is not created */
  update_option ( 'video_gallery_folder_instruction', 'folder_setting' );
  /** Initializing variable */
  $wfound = $pfound = $mfound = $rollfound = $tags = $settingsFound = $adsense = false;  
  /** Looping to check whether the videogallery plugin tables are already exist */
  foreach ( $wpdb->get_results ( 'SHOW TABLES;', ARRAY_N ) as $row ) {
    /** Check video main table is exists */
      if ($row [0] == HDFLVVIDEOSHARE) {
          $wfound         = true;
      }
      /** Check video playlsit is exists */
      if ($row [0] == WVG_PLAYLIST) {
          $pfound         = true;
      }
      /** Check video media table is exists */
      if ($row [0] == WVG_MED2PLAY) {
          $mfound         = true;
      }
      /** Check video ads table is exists */
      if ($row [0] == WVG_VGADS) {
          $rollfound      = true;
      }
      /** Check video tags table is exists */
      if ($row [0] == WVG_TAGS) {
          $tags           = true;
      }
      /** Check video settings table is exists */
      if ($row [0] == WVG_SETTINGS) {
          $settingsFound  = true;
      }
      /** Check video google adsense table is exists */
      if ($row [0] == WVG_VGOOGLEADSENSE) {
          $adsense        = true;
      }
  }  
  /** Call function to create plugin tables */
  createTables ($wfound, $pfound, $mfound, $tags );
  /** Call function to create video ads and google adsense table */
  createADsTable($rollfound, $adsense);
  /** Call function to create settings table */
  createSettingsTable ($settingsFound);  
  /** Call function to create video home, video more pages in admin while plugin installation */
  createVGPluginPages();
  /** Call function to create channel tables */
  createChannelTables();
  /** Call function to create playlist tables */
  playlistTables();
  /** Call function to create watch history tables */
  watchHistoryTables();
  /** Call function to create watch later tables */
  watchLaterTables();
  /** Create required page for channel,playlist,watch later,watch history **/
  createPostPages();
  /**
   * Call function to insert sample videos in videos table 
   * and create posts for the videos in posts table 
   */
  insertSampleVideos ();  
  /** Call function to insert sample playlist values and media table values */
  insertSampleCategories ();  
  /** Call function to insert settings data into db */
  insertSettingsTable ();
  /** Update plugin and flush plugin rules */
  flush_rewrite_rules ();
}
/**
 * Function to create channel page on post table
 * It also create playlist page on post table
 * It also create watch later page on post table
 * It also create watch history page on post table
 */
function createPostPages() {
	global $wpdb;
	$site_url = home_url ();
	/** Check whether the channel page is exist in posts table */
	$checkChannelPage          = $wpdb->get_results ( 'SELECT * FROM ' . WVG_POSTS . ' WHERE post_content="[videochannel]"' );
	/** If page is not exist then create the page for channel */
	if (empty ( $checkChannelPage )) {
		$channelPage  = 'INSERT INTO ' . WVG_POSTS . '( `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count` )
        VALUES
        ( 1, NOW(), NOW(), "[videochannel]", "My Channel", "", "publish", "open", "open", "", "video-channel", "", "",
        "2011-01-10 10:42:23", "2011-01-10 10:42:23", "",0, "' . $site_url . '/?page_id=",0, "page", "", 0 )';
		$wpdb->query ( $channelPage );
		
		/** Get last post Id from post table and update guid for videohome page */
		$homeId       = $wpdb->get_var ( 'SELECT ID FROM ' . WVG_POSTS . ' ORDER BY ID DESC LIMIT 0,1' );
		$homeUpd      = 'UPDATE ' . WVG_POSTS. ' SET guid="' . $site_url . '/?page_id=' . $homeId . '" WHERE ID="' . $homeId . '"';
		$wpdb->query ( $homeUpd );
		/** Save video home page id. */
		$sql_more_id  = "INSERT INTO " . $wpdb->prefix . "options (`option_name`,`option_value`,`autoload`) VALUES ('channel_id','" . $homeId . "','yes')";
		$wpdb->query ( $sql_more_id );
		
		
	}
	
	/** Check whether the playlist page is exist in posts table */
	$checkPlaylistPage          = $wpdb->get_results ( 'SELECT * FROM ' . WVG_POSTS . ' WHERE post_content="[showplaylist]"' );
	/** If page is not exist then create the page for playlist */
	if (empty ( $checkPlaylistPage )) {
		$playlistPage  = 'INSERT INTO ' . WVG_POSTS . '( `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count` )
        VALUES
        ( 1, NOW(), NOW(), "[showplaylist]", "My Playlist", "", "publish", "open", "open", "", "show-playlist", "", "",
        "2011-01-10 10:42:23", "2011-01-10 10:42:23", "",0, "' . $site_url . '/?page_id=",0, "page", "", 0 )';
		$wpdb->query ( $playlistPage );
		
		/** Get last post Id from post table and update guid for videohome page */
		$homeId       = $wpdb->get_var ( 'SELECT ID FROM ' . WVG_POSTS . ' ORDER BY ID DESC LIMIT 0,1' );
		$homeUpd      = 'UPDATE ' . WVG_POSTS. ' SET guid="' . $site_url . '/?page_id=' . $homeId . '" WHERE ID="' . $homeId . '"';
		$wpdb->query ( $homeUpd );
		/** Save video home page id. */
		$sql_more_id  = "INSERT INTO " . $wpdb->prefix . "options (`option_name`,`option_value`,`autoload`) VALUES ('playlist_id','" . $homeId . "','yes')";
		$wpdb->query ( $sql_more_id );
		
		
	}
	
	/** Check whether the watch later page is exist in posts table */
	$checkWatchLaterPage          = $wpdb->get_results ( 'SELECT * FROM ' . WVG_POSTS . ' WHERE post_content="[watch_later]"' );
	/** If page is not exist then create the page for watch later */
	if (empty ( $checkWatchLaterPage )) {
		$watchLaterPage  = 'INSERT INTO ' . WVG_POSTS . '( `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count` )
        VALUES
        ( 1, NOW(), NOW(), "[watch_later]", "Watch Later", "", "publish", "open", "open", "", "watch-later", "", "",
        "2011-01-10 10:42:23", "2011-01-10 10:42:23", "",0, "' . $site_url . '/?page_id=",0, "page", "", 0 )';
		$wpdb->query ( $watchLaterPage );
		
		/** Get last post Id from post table and update guid for videohome page */
		$homeId       = $wpdb->get_var ( 'SELECT ID FROM ' . WVG_POSTS . ' ORDER BY ID DESC LIMIT 0,1' );
		$homeUpd      = 'UPDATE ' . WVG_POSTS. ' SET guid="' . $site_url . '/?page_id=' . $homeId . '" WHERE ID="' . $homeId . '"';
		$wpdb->query ( $homeUpd );
		/** Save video home page id. */
		$sql_more_id  = "INSERT INTO " . $wpdb->prefix . "options (`option_name`,`option_value`,`autoload`) VALUES ('watch_later_id','" . $homeId . "','yes')";
		$wpdb->query ( $sql_more_id );
	}
	
	/** Check whether the watch history page is exist in posts table */
	$checkWatchHistoryPage          = $wpdb->get_results ( 'SELECT * FROM ' . WVG_POSTS . ' WHERE post_content="[watch_history]"' );
	/** If page is not exist then create the page for watch history */
	if (empty ( $checkWatchHistoryPage )) {
		$watchHistoryPage  = 'INSERT INTO ' . WVG_POSTS . '( `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count` )
        VALUES
        ( 1, NOW(), NOW(), "[watch_history]", "Watch History", "", "publish", "open", "open", "", "watch-history", "", "",
        "2011-01-10 10:42:23", "2011-01-10 10:42:23", "",0, "' . $site_url . '/?page_id=",0, "page", "", 0 )';
		$wpdb->query ( $watchHistoryPage );
		/** Get last post Id from post table and update guid for videohome page */
		$homeId       = $wpdb->get_var ( 'SELECT ID FROM ' . WVG_POSTS . ' ORDER BY ID DESC LIMIT 0,1' );
		$homeUpd      = 'UPDATE ' . WVG_POSTS. ' SET guid="' . $site_url . '/?page_id=' . $homeId . '" WHERE ID="' . $homeId . '"';
		$wpdb->query ( $homeUpd );
		/** Save video home page id. */
		$sql_more_id  = "INSERT INTO " . $wpdb->prefix . "options (`option_name`,`option_value`,`autoload`) VALUES ('watch_history','" . $homeId . "','yes')";
		$wpdb->query ( $sql_more_id );
	}
}
/**
 * Function to create hdflvvideoshare / playlist / tags / med2play tables 
 * 
 * @param unknown $wfound
 * @param unknown $pfound
 * @param unknown $mfound
 * @param unknown $tags
 */
function createTables ($wfound, $pfound, $mfound, $tags ) {
  global $wpdb;
  /** Create wp_hdflvvideoshare table */
  /** Check main table is not exist */
  if (! $wfound) {
    $sql = 'CREATE TABLE ' . HDFLVVIDEOSHARE . ' ( vid MEDIUMINT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY, name MEDIUMTEXT NULL,
        description MEDIUMTEXT NOT NULL, embedcode LONGTEXT NOT NULL, file MEDIUMTEXT NULL, streamer_path MEDIUMTEXT NULL,
        hdfile MEDIUMTEXT NULL, slug TEXT NULL, file_type TINYINT( 25 ) NOT NULL, duration varchar( 255 ) NOT NULL, srtfile1 varchar( 255 ) NOT NULL,
        srtfile2 varchar( 255 ) NOT NULL, subtitle_lang1 MEDIUMTEXT NOT NULL, subtitle_lang2 MEDIUMTEXT NOT NULL, image MEDIUMTEXT NULL,
        opimage MEDIUMTEXT NULL, download varchar( 10 ) NOT NULL, link MEDIUMTEXT NULL, featured varchar( 25 ) NOT NULL, hitcount int( 25 ) NOT NULL DEFAULT "0",
        ratecount int( 25 ) NOT NULL DEFAULT "0", rate int( 25 ) NOT NULL DEFAULT "0", post_date datetime NOT NULL, postrollads VARCHAR( 25 ) NULL,
        prerollads VARCHAR( 25 ) NULL, midrollads INT NULL DEFAULT "0", imaad INT NULL DEFAULT "0", publish INT NOT NULL,
        islive INT NOT NULL, member_id INT( 3 ) NOT NULL, google_adsense INT( 3 ) NULL, google_adsense_value INT( 11 ) NULL,
        ordering INT NOT NULL DEFAULT "0", amazon_buckets INT NOT NULL DEFAULT "0" ) ' . WVG_CHARSET_COLLATE . ';';
    $wpdb->query ( $sql );
  }  
  /** Create wp_hdflvvideoshare_playlist table */
  /** Check playlist table is not exist */
  if (! $pfound) {
    $sql = 'CREATE TABLE ' . WVG_PLAYLIST . ' ( pid BIGINT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY , playlist_name VARCHAR( 200 ) NOT NULL , 
        playlist_slugname TEXT NOT NULL , playlist_desc LONGTEXT NULL, is_publish INT NOT NULL, playlist_order INT NOT NULL ) ' . WVG_CHARSET_COLLATE . ';';
    $wpdb->query ( $sql );
  }  
  /** Create wp_hdflvvideoshare_med2play table */
  /** Check meida table is not exist */
  if (! $mfound) {
    $sql = 'CREATE TABLE ' . WVG_MED2PLAY . ' ( rel_id BIGINT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
        media_id BIGINT( 10 ) NOT NULL DEFAULT "0", playlist_id BIGINT( 10 ) NOT NULL DEFAULT "0", 
        porder MEDIUMINT( 10 ) NOT NULL DEFAULT "0", sorder INT( 3 ) NOT NULL DEFAULT "0") ' . WVG_CHARSET_COLLATE . ';';
    $wpdb->query ( $sql );
  }
  /** Create wp_hdflvvideoshare_tags table */
  /** Check tags table is not exist */
  if (! $tags) {
    $sqlTags = 'CREATE TABLE IF NOT EXISTS ' . WVG_TAGS . ' ( `vtag_id` int( 25 ) NOT NULL AUTO_INCREMENT,  `tags_name` MEDIUMTEXT NOT NULL,
        `seo_name` MEDIUMTEXT NOT NULL, `media_id` varchar( 50 ) NOT NULL, PRIMARY KEY ( `vtag_id` ) ) ' . WVG_CHARSET_COLLATE . ';';
    $wpdb->query ( $sqlTags );
  }  
}

/**
 * Fucntion to create video ads / google adsense table
 * 
 * @param unknown $rollfound
 * @param unknown $adsense
 */
function createADsTable($rollfound, $adsense) {
  global $wpdb;
  /** Create wp_hdflvvideoshare_vgads table */
  /** Check ads table is not exist */
  if (! $rollfound) {
    $sqlRoll = 'CREATE TABLE IF NOT EXISTS ' . WVG_VGADS . ' (  `ads_id` bigint( 10 ) NOT NULL AUTO_INCREMENT, `file_path` varchar( 200 ) NULL,
        `title` varchar( 200 ) NULL, `description` text NOT NULL,  `targeturl` text NOT NULL, `clickurl` text NULL,
        `adtype` text NOT NULL, `admethod` text NOT NULL, `imaadwidth` INT( 11 ) NULL, `imaadheight` INT( 11 ) NULL, `imaadpath` text NULL,
        `publisherId` text NOT NULL, `contentId` text NOT NULL, `imaadType` INT(  11  ) NULL, `channels` varchar( 200 ) NOT NULL,
        `impressionurl` text NULL, `publish` INT(  10  ) NOT NULL, PRIMARY KEY ( `ads_id` ) ) ' . WVG_CHARSET_COLLATE . ';';
    $wpdb->query ( $sqlRoll );
  }
  /** Create wp_hdflvvideoshare_googleadsense table */
  /** Check google adsense is not exist */
  if (! $adsense) {
    $sqladsense = 'CREATE TABLE IF NOT EXISTS ' . WVG_VGOOGLEADSENSE . ' ( `id` int( 10 ) NOT NULL AUTO_INCREMENT,
        `googleadsense_details` text NOT NULL, PRIMARY KEY ( `id` ) )' . WVG_CHARSET_COLLATE . ';';
    $wpdb->query ( $sqladsense );
  }
}

function createChannelTables() {
	global $wpdb;
	$channel = 'CREATE TABLE IF NOT EXISTS '.WVG_CHANNEL.' (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `user_name` varchar(100) CHARACTER SET utf8 NOT NULL,
    `user_key` varchar(100) CHARACTER SET utf8 NOT NULL,
    `user_content` longtext CHARACTER SET utf8 NOT NULL,
    `channel_name` varchar(100) CHARACTER SET utf8 NOT NULL,
    PRIMARY KEY (`id`)
    )' . WVG_CHARSET_COLLATE . ';';
	$wpdb->query ( $channel );
	$channelNotification = 'CREATE TABLE IF NOT EXISTS '.WVG_CHANNEL_NOTIFICATION.' (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `sub_id` longtext CHARACTER SET utf8 NOT NULL,
    PRIMARY KEY (`id`)
    )' . WVG_CHARSET_COLLATE . ';';
	$wpdb->query ( $channelNotification );
	$channelSubscriber = 'CREATE TABLE IF NOT EXISTS '.WVG_CHANNEL_SUBSCRIBER.' (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `sub_id` longtext CHARACTER SET utf8 NOT NULL,
    PRIMARY KEY (`id`)
    )' . WVG_CHARSET_COLLATE . ';';
	$wpdb->query ( $channelSubscriber );
}

function playlistTables() {
	global $wpdb;
	$userPlaylist = 'CREATE TABLE IF NOT EXISTS '.WVG_USER_PLAYLIST.' (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `userid` bigint(20) NOT NULL,
    `playlist_name` text CHARACTER SET utf8 NOT NULL,
    PRIMARY KEY (`id`)
    )' . WVG_CHARSET_COLLATE . ';';
	$wpdb->query ( $userPlaylist );
	$userPlaylistDetails = 'CREATE TABLE IF NOT EXISTS '.WVG_USER_PLAYLIST_DETAILS.' (
    `id` int(20) NOT NULL AUTO_INCREMENT,
    `userid` bigint(20) NOT NULL,
    `vid` bigint(20) NOT NULL,
    `pid` bigint(20) NOT NULL,
    PRIMARY KEY (`id`)
    )' . WVG_CHARSET_COLLATE . ';';
	$wpdb->query ( $userPlaylistDetails );
}

function watchHistoryTables() {
	global $wpdb;
	$watchHitoryDetails = 'CREATE TABLE IF NOT EXISTS '.WVG_WATCH_HISTORY_DETAILS.' (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `userid` bigint(20) NOT NULL,
    `vid` bigint(20) NOT NULL,
    `date` datetime NOT NULL,
    PRIMARY KEY (`id`)
    )' . WVG_CHARSET_COLLATE . ';';
	$wpdb->query ( $watchHitoryDetails );
	$watchHitoryUser = 'CREATE TABLE IF NOT EXISTS '.WVG_WATCH_HISTORY_USERS.' (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `userid` bigint(20) NOT NULL,
    `watch` int(11) NOT NULL,
    PRIMARY KEY (`id`)
    )' . WVG_CHARSET_COLLATE . ';';
	$wpdb->query ( $watchHitoryUser );
}

function watchLaterTables() {
	global $wpdb;
	$watchLater = 'CREATE TABLE IF NOT EXISTS '.WVG_WATCH_LATER.' (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `userid` bigint(20) NOT NULL,
    `vid` bigint(20) NOT NULL,
    `date` datetime NOT NULL,
    `status` int(11) NOT NULL,
    PRIMARY KEY (`id`)
    )' . WVG_CHARSET_COLLATE . ';';
	$wpdb->query ( $watchLater );
}

/**
 * Fucntion to create settings table
 * 
 * @param unknown $settingsFound
 */
function createSettingsTable ($settingsFound) {
  global $wpdb;
  /** Create wp_hdflvvideoshare_settings table */
  /** Check settings table is not exist */
  if (! $settingsFound) {
    $sql = 'CREATE TABLE ' . WVG_SETTINGS . ' ( settings_id BIGINT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY , autoplay BIGINT( 10 ) NOT NULL DEFAULT "0",
        playlist BIGINT( 10 ) NOT NULL DEFAULT "0", playlistauto BIGINT( 10 ) NOT NULL DEFAULT "0", buffer MEDIUMINT( 10 ) NOT NULL DEFAULT "0",
        normalscale INT( 3 ) NOT NULL DEFAULT "0", fullscreenscale INT( 3 ) NOT NULL DEFAULT "0", logopath VARCHAR( 200 ) NOT NULL DEFAULT "0",
        logo_target VARCHAR( 200 ) NOT NULL, volume INT( 3 ) NOT NULL DEFAULT "0", logoalign VARCHAR( 10 ) NOT NULL DEFAULT "0", hdflvplayer_ads INT( 3 ) NOT NULL DEFAULT "0",
        HD_default INT( 3 ) NOT NULL DEFAULT "0", download INT( 3 ) NOT NULL DEFAULT "0", logoalpha  INT( 3 ) NOT NULL DEFAULT "100", skin_autohide INT( 3 ) NOT NULL DEFAULT "0",
        stagecolor VARCHAR( 45 ) NOT NULL, embed_visible INT( 3 ) NOT NULL DEFAULT "0", view_visible INT( 3 ) NOT NULL DEFAULT "0", ratingscontrol INT( 3 ) NOT NULL DEFAULT "0",
        tagdisplay INT( 3 ) NOT NULL DEFAULT "0", categorydisplay INT( 3 ) NOT NULL DEFAULT "0", shareURL VARCHAR( 200 ) NOT NULL, playlistXML VARCHAR( 200 ) NOT NULL,
        debug INT( 3 ) NOT NULL DEFAULT "0", timer INT( 3 ) NOT NULL DEFAULT "0", zoom INT( 3 ) NOT NULL DEFAULT "0", email INT( 3 ) NOT NULL DEFAULT "0",
        fullscreen INT( 3 ) NOT NULL DEFAULT "0", width INT( 5 ) NOT NULL DEFAULT "0", height INT( 5 ) NOT NULL DEFAULT "0", display_logo INT( 3 ) NOT NULL DEFAULT "0",
        configXML VARCHAR( 200 ) NOT NULL, uploads varchar( 200 ) NOT NULL, license varchar( 200 ) NOT NULL, keyApps varchar( 50 ) NOT NULL,
        keydisqusApps varchar( 50 ) NOT NULL, preroll varchar( 10 ) NOT NULL, postroll varchar( 10 ) NOT NULL, feature varchar( 25 ) NOT NULL,
        rowsFea varchar( 25 ) NOT NULL, colFea varchar( 25 ) NOT NULL, recent varchar( 25 ) NOT NULL, rowsRec varchar( 25 ) NOT NULL,
        colRec varchar( 25 ) NOT NULL, popular varchar( 25 ) NOT NULL, rowsPop varchar( 25 ) NOT NULL, colPop varchar( 25 ) NOT NULL,
        page varchar( 25 ) NOT NULL, category_page varchar( 25 ) NOT NULL, ffmpeg_path varchar( 255 ) NOT NULL, stylesheet varchar( 50 ) NOT NULL,
        comment_option TINYINT( 1 ) NOT NULL, rowCat varchar( 25 ) NOT NULL, colCat varchar( 25 ) NOT NULL, rowMore varchar( 25 ) NOT NULL,
        colMore varchar( 25 ) NOT NULL, homecategory varchar( 25 ) NOT NULL, bannercategory varchar( 25 ) NOT NULL, banner_categorylist INT( 3 ) NOT NULL DEFAULT "1",
        hbannercategory varchar( 25 ) NOT NULL, hbanner_categorylist INT( 3 ) NOT NULL DEFAULT "1", vbannercategory varchar( 25 ) NOT NULL,
        vbanner_categorylist INT( 3 ) NOT NULL DEFAULT "1", bannerw varchar( 25 ) NOT NULL, playerw varchar( 25 ) NOT NULL, numvideos varchar( 25 ) NOT NULL,
        gutterspace INT( 3 ) NOT NULL, default_player INT( 11 ) NOT NULL, player_colors LONGTEXT  NOT NULL, playlist_open INT( 3 ) NOT NULL,
        showPlaylist INT( 3 ) NOT NULL, midroll_ads INT( 3 ) NULL, adsSkip INT( 3 ) NOT NULL, adsSkipDuration VARCHAR( 45 ) NOT NULL, relatedVideoView VARCHAR( 45 ) NOT NULL,
        imaAds INT( 3 ) NULL, trackCode TEXT NOT NULL, showTag INT( 3 ) NOT NULL, shareIcon INT( 3 ) NOT NULL, volumecontrol INT( 3 ) NOT NULL, 
        playlist_auto INT( 3 ) NOT NULL, progressControl INT( 3 ) NOT NULL, imageDefault INT( 3 ) NOT NULL ) ' . WVG_CHARSET_COLLATE . ';';
    $wpdb->query ( $sql );
  }
}

/**
 * Fcuntion to create video more, video home page in WordPress admin
 */
function createVGPluginPages() {
  global $wpdb;
  /** Get site URL to create pages */
  $site_url = home_url ();
  /** Check whether the videomore page is exist in posts table */
  $postM          = $wpdb->get_results ( 'SELECT * FROM ' . WVG_POSTS . ' WHERE post_content="[videomore]"' );
  /** If page is not exist then create the page for videomore */
  if (empty ( $postM )) {
    $contus_more  = 'INSERT INTO ' . WVG_POSTS . '( `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count` )
        VALUES
        ( 1, NOW(), NOW(), "[videomore]", "Video Categories", "", "publish", "open", "open", "", "video-more", "", "",
        "2011-01-10 10:42:23", "2011-01-10 10:42:23", "",0, "' . $site_url . '/?page_id=",0, "page", "", 0 )';  
    $wpdb->query ( $contus_more );
    /** Get last ID from post table */ 
    $moreId       = $wpdb->get_var ( 'SELECT ID FROM ' . WVG_POSTS . ' ORDER BY ID DESC LIMIT 0,1' );
    /** Update guid for videomore page */
    $moreUpd      = 'UPDATE ' . WVG_POSTS . ' SET guid="' . $site_url . '/?page_id=' . $moreId . '" WHERE ID="' . $moreId . '"';
    $wpdb->query ( $moreUpd );
  
    /** If video more and home page id is missing in options table then insert*/
    $sql_more_id  = "INSERT INTO " . $wpdb->prefix . "options (`option_name`,`option_value`,`autoload`) VALUES ('video_more_id','" . $moreId . "','yes')";
    $wpdb->query ( $sql_more_id );
  }
  
  /** Check whether the videohome page is exist in posts table */
  $postH          = $wpdb->get_results ( 'SELECT * FROM ' . WVG_POSTS . ' WHERE post_content="[videohome]"' );
  /** If not then create videohome page */
  if (empty ( $postH )) {
    $contus_home  = 'INSERT INTO ' . WVG_POSTS . '( `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count` )
        VALUES
        ( 1, NOW(), NOW(), "[videohome]", "Videos", "", "publish", "open", "open", "", "video-home", "", "",
        "2011-01-10 10:42:06", "2011-01-10 10:42:06", "",0, "' . $site_url . '/?page_id=",0, "page", "", 0 )';
    $wpdb->query ( $contus_home );
    /** Get last post Id from post table and update guid for videohome page */
    $homeId       = $wpdb->get_var ( 'SELECT ID FROM ' . WVG_POSTS . ' ORDER BY ID DESC LIMIT 0,1' );
    $homeUpd      = 'UPDATE ' . WVG_POSTS. ' SET guid="' . $site_url . '/?page_id=' . $homeId . '" WHERE ID="' . $homeId . '"';
    $wpdb->query ( $homeUpd );  
    /** Save video home page id. */
    $sql_more_id  = "INSERT INTO " . $wpdb->prefix . "options (`option_name`,`option_value`,`autoload`) VALUES ('video_more_id','" . $homeId . "','yes')";
    $wpdb->query ( $sql_more_id );
  }
} 

/**
 * Fucntion to insert smaple videos and their posts in posts table
 */
function insertSampleVideos() {
  global $wpdb;
  /** Get last Id from post table */
  $post_id          = $wpdb->get_var ( 'SELECT ID FROM ' . WVG_POSTS . ' ORDER BY ID DESC' );
  $postid           = array ();
  /** Generatee post id for 17 sample videos */
  for($i = 0; $i < 17; $i ++) {
    $postid [$i]    = $post_id + 1;
    $post_id ++;
  }
  /** Fetch videos from plugin video table */
  $videoCategories  = $wpdb->get_results ( 'SELECT * FROM ' . HDFLVVIDEOSHARE );  
  /** If video details are empty then insert sample data */
  if (empty ( $videoCategories )) {
    /** Get current user object */  
    $current_user   = wp_get_current_user ();
    /** Get current user id from currentuser object*/
    $member_id      = $current_user->ID;  
    /** Insert sample videos into hdflvvideoshare table */
    $wpdb->query ( 'INSERT INTO ' . HDFLVVIDEOSHARE . ' ( `member_id`,`slug`, `name`, `description`, `embedcode`, `file`, `hdfile`, `file_type`, `duration`, `image`, `opimage`, `download`, `link`, `featured`, `hitcount`, `post_date`, `postrollads`, `prerollads`, `publish`,`ordering`,`streamer_path`,`islive`, `ratecount`, `rate` ) VALUES
        ( ' . $member_id . ',' . $postid [0] . ',"Pacific Rim Official Wondercon Trailer ( 2013 ) - Guillermo del Toro Movie HD", "","", "http://www.youtube.com/watch?v=Ef6vQBGqLW8", "", 1, "2:38", "http://i3.ytimg.com/vi/Ef6vQBGqLW8/mqdefault.jpg", "http://i3.ytimg.com/vi/Ef6vQBGqLW8/maxresdefault.jpg", "", "http://www.youtube.com/watch?v=Ef6vQBGqLW8", "1", 1, "2013-08-06 13:54:39", "0", "0", "1","0","","0","0","0" ),
        ( ' . $member_id . ',' . $postid [1] . ',"GI JOE 2 Retaliation Trailer 2 - 2013 Movie - Official [HD]", "G I Joe Retaliation Trailer 2 - 2013 movie - official movie trailer in HD - sequel of the 2009 \'s GI Joe film - starring Channing Tatum, Adrianne Palicki, Dwayne Johnson, Bruce Willis - directed by Jon Chu.", "","http://www.youtube.com/watch?v=mKNpy-tGwxE", "", 1, "2:31", "http://i3.ytimg.com/vi/mKNpy-tGwxE/mqdefault.jpg", "http://i3.ytimg.com/vi/mKNpy-tGwxE/maxresdefault.jpg", "", "http://www.youtube.com/watch?v=mKNpy-tGwxE", "1", 2, "2013-08-06 13:46:43", "0", "0", "1","1","","0","0","0" ),
        ( ' . $member_id . ',' . $postid [2] . ',"2012 - Full HD trailer - At UK Cinemas November 13", "Never before has a date in history been so significant to so many cultures, so many religions, scientists, and governments.  2012 is an epic adventure about a global cataclysm that brings an end to the world and tells of the heroic struggle of the survivo","", "http://www.youtube.com/watch?v=rvI66Xaj9-o", "", 1, "2:22", "http://i3.ytimg.com/vi/rvI66Xaj9-o/mqdefault.jpg", "http://i3.ytimg.com/vi/rvI66Xaj9-o/maxresdefault.jpg", "", "http://www.youtube.com/watch?v=rvI66Xaj9-o", "1", 1, "2013-08-06 13:47:15", "0", "0", "1","2","","0","0","0" ),
        ( ' . $member_id . ',' . $postid [3] . ',"Iron Man - Trailer [HD]", "Paramount Pictures and Marvel Studios\' big screen adaptation of Marvel\'s legendary Super Hero Iron Man will launch into theaters on May 2, 2008. Oscar nominee Robert Downey Jr. stars as Tony Stark/Iron Man in the story of a billionaire industrialist and","", "http://www.youtube.com/watch?v=8hYlB38asDY", "", 1, "2:30", "http://i3.ytimg.com/vi/8hYlB38asDY/mqdefault.jpg", "http://i3.ytimg.com/vi/8hYlB38asDY/maxresdefault.jpg", "", "http://www.youtube.com/watch?v=8hYlB38asDY", "1", 1, "2013-08-06 13:50:52", "0", "0", "1","3","","0","0","0" ),
        ( ' . $member_id . ',' . $postid [4] . ',"THE AVENGERS Trailer 2012 Movie - Official [HD]", "The Avengers Trailer 2012 - Official movie teaser trailer in HD - starring Robert Downey Jr., Chris Evans, Mark Ruffalo, Chris Hemsworth, Scarlett Johansson.Joss Whedon brings together the ultimate team of superheroes in the first official trailer for","", "http://www.youtube.com/watch?v=orfMJJEd0wk", "", 1, "1:47", "http://i3.ytimg.com/vi/orfMJJEd0wk/mqdefault.jpg", "http://i3.ytimg.com/vi/orfMJJEd0wk/maxresdefault.jpg", "", "http://www.youtube.com/watch?v=orfMJJEd0wk", "1", 1, "2013-08-06 13:53:12", "0", "0", "1","4","","0","0","0" ),
        ( ' . $member_id . ',' . $postid [5] . ',"Cronicles of Narnia :Prince Caspian Trailer HD 720p", "Cronicles of Narnia :Prince Caspian Trailer High Definition 720p","", "http://www.youtube.com/watch?v=yfX1S-ifI3E", "", 1, "2:31", "http://i3.ytimg.com/vi/yfX1S-ifI3E/mqdefault.jpg", "http://i3.ytimg.com/vi/yfX1S-ifI3E/maxresdefault.jpg", "", "http://www.youtube.com/watch?v=yfX1S-ifI3E", "1", 1, "2013-08-06 13:53:58", "0", "0", "1","5","","0","0","0" ),
        ( ' . $member_id . ',' . $postid [6] . ',"The Hobbit: The Desolation of Smaug International Trailer ( 2013 ) - Lord of the Rings Movie HD", "","", "http://www.youtube.com/watch?v=TeGb5XGk2U0", "", 1, "1:57", "http://i3.ytimg.com/vi/TeGb5XGk2U0/mqdefault.jpg", "http://i3.ytimg.com/vi/TeGb5XGk2U0/maxresdefault.jpg", "", "http://www.youtube.com/watch?v=TeGb5XGk2U0", "1", 4, "2013-08-06 14:00:39", "0", "0", "1","6","","0","0","0" ),
        ( ' . $member_id . ',' . $postid [7] . ',"Pirates of the Caribbean: On Stranger Tides Trailer HD", "","", "http://www.youtube.com/watch?v=egoQRNKeYxw", "", 1, "2:29", "http://i3.ytimg.com/vi/egoQRNKeYxw/mqdefault.jpg", "http://i3.ytimg.com/vi/egoQRNKeYxw/maxresdefault.jpg", "", "http://www.youtube.com/watch?v=egoQRNKeYxw", "1", 3, "2013-08-06 14:01:58", "0", "0", "1","7","","0","0","0" ),
        ( ' . $member_id . ',' . $postid [8] . ',"Fast & Furious 6 - Official Trailer [HD]", "Since Dom ( Diesel ) and Brians ( Walker ) Rio heist toppled a kingpins empire and left their crew with $100 million, our heroes have scattered across the globe. But their inability to return home and living forever on the lam have left their lives incomplete","", "http://www.youtube.com/watch?v=PP7pH4pqC5A", "", 1, "2:35", "http://i3.ytimg.com/vi/PP7pH4pqC5A/mqdefault.jpg", "http://i3.ytimg.com/vi/PP7pH4pqC5A/maxresdefault.jpg", "0", "http://www.youtube.com/watch?v=PP7pH4pqC5A", "1", 2, "2013-08-06 14:04:38", "0", "0", "1","8","","0","0","0" ),
        ( ' . $member_id . ',' . $postid [9] . ',"Samsung Demo HD - Blu-Ray Sound 7.1 ch", "En el video se muestra el audio 7.1 de Samsung en sus equipos Blu-Ray como el HT-BD2 y el BD-P3600, este ultimo con salida de 8 canales discretos","", "http://www.youtube.com/watch?v=UJ1MOWg15Ec", "", 1, "1:40", "http://i3.ytimg.com/vi/UJ1MOWg15Ec/mqdefault.jpg", "http://i3.ytimg.com/vi/UJ1MOWg15Ec/maxresdefault.jpg", "", "http://www.youtube.com/watch?v=UJ1MOWg15Ec", "1", 3, "2013-08-06 14:04:52", "0", "0", "1","9","","0","0","0" ),
        ( ' . $member_id . ',' . $postid [10] . ',"White House Down Trailer #2 2013 Jamie Foxx Movie - Official [HD]", "White House Down Trailer #2 2013 - Official movie trailer 2 in HD - starring Channing Tatum, Jamie Foxx, Maggie Gyllenhaal - directed by Roland Emmerich - a Washington, D.C. police officer is on a tour of the presidential mansion when a heavily armed grou","", "http://www.youtube.com/watch?v=Kkoor7Z6aeE", "", 1, "2:35", "http://i3.ytimg.com/vi/Kkoor7Z6aeE/mqdefault.jpg", "http://i3.ytimg.com/vi/Kkoor7Z6aeE/maxresdefault.jpg", "", "http://www.youtube.com/watch?v=Kkoor7Z6aeE", "1", 3, "2013-08-06 14:08:59", "0", "0", "1","10","","0","0","0" ),
        ( ' . $member_id . ',' . $postid [11] . ',"Landscapes: Volume 2", "","", "http://www.youtube.com/watch?v=DaYx4XmWEoI", "", 1, "3:31", "http://i3.ytimg.com/vi/DaYx4XmWEoI/mqdefault.jpg", "http://i3.ytimg.com/vi/DaYx4XmWEoI/maxresdefault.jpg", "", "http://www.youtube.com/watch?v=DaYx4XmWEoI", "1", 1, "2013-08-06 14:09:48", "0", "0", "1","11","","0","0","0" ),
        ( ' . $member_id . ',' . $postid [12] . ',"Krrish 3 - Official Theatrical Trailer ( Exclusive )", "Watch the Exclusive Official Theatrical Trailer of Krrish 3, the most awaited movie of the year starring Hrithik Roshan, Priyanka Chopra, Kangna Ranaut, Vivek Oberoi & Shaurya Chauhan. Releasing this Diwali...!Directed & Produced by - Rakesh Roshan","", "http://www.youtube.com/watch?v=MCCVVgtI5xU", "", 1, "2:16", "http://i3.ytimg.com/vi/MCCVVgtI5xU/mqdefault.jpg", "http://i3.ytimg.com/vi/MCCVVgtI5xU/maxresdefault.jpg", "", "http://www.youtube.com/watch?v=MCCVVgtI5xU", "1", 2, "2013-08-06 14:10:54", "0", "0", "1","12","","0","0","0" ),
        ( ' . $member_id . ',' . $postid [13] . ',"THE TWILIGHT SAGA: BREAKING DAWN PART 2 - TV Spot Generation", "","", "http://www.youtube.com/watch?v=ey0aA3YY0Mo", "", 1, "0:32", "http://i3.ytimg.com/vi/ey0aA3YY0Mo/mqdefault.jpg", "http://i3.ytimg.com/vi/ey0aA3YY0Mo/maxresdefault.jpg", "", "http://www.youtube.com/watch?v=ey0aA3YY0Mo", "1", 3,"2013-08-06 14:12:07","", "0", "1","13","","0","0","0" ),
        ( ' . $member_id . ',' . $postid [14] . ',"Journey To The Center Of The Earth HD Trailer", "","", "http://www.youtube.com/watch?v=iJkspWwwZLM", "", 1, "2:30", "http://i3.ytimg.com/vi/iJkspWwwZLM/mqdefault.jpg", "http://i3.ytimg.com/vi/iJkspWwwZLM/maxresdefault.jpg", "", "http://www.youtube.com/watch?v=iJkspWwwZLM", "1", 2, "2013-08-06 14:12:07", "0", "0", "1","14","","0","0","0" ),
        ( ' . $member_id . ',' . $postid [15] . ',"ICE AGE 4 Trailer 2012 Movie - Continental Drift - Official [HD]", "Ice Age 4: Continental Drift Trailer 2012 Movie - Official Ice Age 4 trailer in [HD] - Scrat accidentally triggers the breakup of Pangea and thus the splitting of the continents.","", "http://www.youtube.com/watch?v=ja-qjGeDBZQ", "", 1, "2:33", "http://i3.ytimg.com/vi/ja-qjGeDBZQ/mqdefault.jpg", "http://i3.ytimg.com/vi/ja-qjGeDBZQ/maxresdefault.jpg", "", "http://www.youtube.com/watch?v=ja-qjGeDBZQ", "1", 3, "2013-08-06 13:47:15", "0", "0", "1","15","","0","0","0" ),
        ( ' . $member_id . ',' . $postid [16] . ',"Big Buck Bunny", "Big Buck Bunny was the first project in the Blender Institute Amsterdam. This 10 minute movie has been made inspired by the best cartoon tradition.","", "http://www.youtube.com/watch?v=Vpg9yizPP_g", "", 1, "1:47", "http://i3.ytimg.com/vi/Vpg9yizPP_g/mqdefault.jpg", "http://i3.ytimg.com/vi/Vpg9yizPP_g/maxresdefault.jpg", "", "http://www.youtube.com/watch?v=Vpg9yizPP_g", "1", 3, "2013-08-06 13:53:12", "0", "0", "1","16","","0","0","0" )' );
    /** Video title array */
    $videoName = array ( 0 => 'Pacific Rim Official Wondercon Trailer ( 2013 ) - Guillermo del Toro Movie HD',
      1 => 'GI JOE 2 Retaliation Trailer 2 - 2013 Movie - Official [HD]', 2 => '2012 - Full HD trailer - At UK Cinemas November 13',
      3 => 'Iron Man - Trailer [HD]',  4 => 'THE AVENGERS Trailer 2012 Movie - Official [HD]',
      5 => 'Cronicles of Narnia :Prince Caspian Trailer HD 720p',
      6 => 'The Hobbit: The Desolation of Smaug International Trailer ( 2013 ) - Lord of the Rings Movie HD',
      7 => 'Pirates of the Caribbean: On Stranger Tides Trailer HD',  8 => 'Fast & Furious 6 - Official Trailer [HD]',
      9 => 'Samsung Demo HD - Blu-Ray Sound 7.1 ch', 10 => 'White House Down Trailer #2 2013 Jamie Foxx Movie - Official [HD]',
      11 => 'Landscapes: Volume 2', 12 => 'Krrish 3 - Official Theatrical Trailer ( Exclusive )',
      13 => 'THE TWILIGHT SAGA: BREAKING DAWN PART 2 - TV Spot Generation', 14 => 'Journey To The Center Of The Earth HD Trailer',
      15 => 'ICE AGE 4 Trailer 2012 Movie - Continental Drift - Official [HD]', 16 => 'Big Buck Bunny' );
    /** Insert posts for all sample video into post table */
    for($i = 1; $i <= 17; $i ++) {
      $j            = $i - 1;
      /** Set seo title for smaple videos */
      $slug         = sanitize_title ( $videoName [$j] );
      /** Set post content for smaple videos */
      $post_content = '[hdvideo id=' . $i . ']';
      $postID       = $postid [$j];
      /** Set post URL for smaple videos */
      $guid         = home_url () . '/?post_type=videogallery&#038;p=' . $postID;
      /** Insert new posts into post table for smaple vidoes */
      $wpdb->query ( 'INSERT INTO ' . WVG_POSTS . ' ( `post_author`,`post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count` )
          VALUES ( "1","2011-11-15 07:22:39", "2011-11-15 07:22:39", "' . $post_content . '", "' . $videoName [$j] . '", "", "publish", "open",
          "closed", "", "' . $slug . '", "", "", "2011-11-15 07:22:39", "2011-11-15 07:22:39", "", 0, "' . $guid . '", "0","videogallery", "", "0" )' );
    }
  }
} 

/**
 * Fucntion to create sample categories and media table values
 */
function insertSampleCategories () {
  global $wpdb;
  /** Get playlist from database  */
  $movieTrailer     = $wpdb->get_results ( 'SELECT * FROM ' . WVG_PLAYLIST );
  /** If empty then add sample playlist */
  if (empty ( $movieTrailer )) {  
    $wpdb->query ( 'INSERT INTO ' . WVG_PLAYLIST . '( `pid`, `playlist_name`,`playlist_slugname`, `playlist_desc`, `playlist_order`, `is_publish` )
        VALUES
        ( 1, "Movie Trailer","movie-trailer", "", "1","1" ), ( 2, "Animation","animation", "", "2","1" ), ( 3, "Animals","animals", "", "3","1" ), 
        ( 4, "Cricket","cricket", "", "4","1" ), ( 5, "Video Game","video-game", "", "5","1" )' );
  }
  /** Fetch values from med2play table */
  $media2Play   = $wpdb->get_results ( 'SELECT * FROM ' . WVG_MED2PLAY );
  /** If details are empty then update video and category details in med2play table */
  if (empty ( $media2Play )) {
    $wpdb->query ( 'INSERT INTO ' . WVG_MED2PLAY .' ( `rel_id`, `media_id`, `playlist_id`, `porder`, `sorder` )
        VALUES
        ( 6, 27, 3, 0, 0 ), ( 7, 1, 2, 0, 0 ), ( 8, 2, 2, 0, 0 ), ( 9, 3, 2, 0, 0 ), ( 10, 4, 2, 0, 0 ), ( 11, 5, 2, 0, 0 ),
        ( 12, 6, 2, 0, 0 ), ( 13, 7, 3, 0, 0 ), ( 14, 8, 3, 0, 0 ), ( 15, 9, 3, 0, 0 ), ( 16, 10, 3, 0, 0 ), ( 17, 12, 4, 0, 0 ),
        ( 18, 13, 4, 0, 0 ), ( 19, 14, 5, 0, 0 ), ( 20, 15, 5, 0, 0 ), ( 21, 16, 2, 0, 0 ), ( 22, 17, 2, 0, 0 ), ( 23, 11, 4, 0, 0 )' );
  }
}

/**
 * Function to insert sample settings data into settings table
 */
function insertSettingsTable () {
  global $wpdb;
  /** Fetch seetings from database */
  $videoSettings    = $wpdb->get_results ( 'SELECT * FROM ' . WVG_SETTINGS );
  /** If details are empty then insert sample settings value */
  if (empty ( $videoSettings )) {
    $wpdb->query ( 'INSERT INTO ' . WVG_SETTINGS . '( `default_player`,`settings_id`, `autoplay`, `playlist`,`playlistauto`,
        `buffer`, `normalscale`, `fullscreenscale`, `logopath`, `logo_target`, `volume`, `logoalign`, `hdflvplayer_ads`, `HD_default`,
        `download`, `logoalpha`,`skin_autohide`, `stagecolor`, `embed_visible`, `ratingscontrol`, `shareURL`,`playlistXML`,`debug`,
        `timer`, `zoom`, `email`,`fullscreen`, `width`, `height`, `display_logo`, `configXML`,`uploads`, `license`, `keyApps`,
        `keydisqusApps`, `preroll`,`postroll`,`feature`, `rowsFea`, `colFea`, `recent`,`rowsRec`, `colRec`, `popular`, `rowsPop`,
        `colPop`,`page`, `category_page`, `ffmpeg_path`, `stylesheet`, `comment_option`,`rowCat`, `colCat`,`homecategory`,
        `bannercategory`, `banner_categorylist`,`hbannercategory`,`hbanner_categorylist`,`vbannercategory`,`vbanner_categorylist`,
        `bannerw`,`playerw`,`numvideos`,`gutterspace`,`colMore`, `rowMore`,`player_colors`,`playlist_open`,`showPlaylist`,
        `midroll_ads`, `adsSkip`,`adsSkipDuration`,`relatedVideoView`,`imaAds`,`trackCode`, `showTag`,`shareIcon`,`volumecontrol`,
        `playlist_auto`,`progressControl`, `imageDefault`,`view_visible`)
        VALUES 
        ( 0, 1, 1, 1, 1, 3, 2, 2, " ", " " , 50, "BL", 0, 1, 1, 100, 1, " ", 1, 1, " ", " ", 0, 1, 1, 1, 1, 620, 350, 0,
        "0" ,"wp-content/uploads/videogallery", "", "", " ", "0", "0", "1", "2", "4", "1", "2", "4", "1", "2",
        "4", "20", "4", " ", " ", "1", "2", "4", "off",  "popular", "1", "hpopular", "1", "vpopular", "1", "650", "450", "5", "20", "4",
        "2", " ", "1", "1", "0", "1", "5", "center", "0", "", "1", "1", "1", "1","1", "1", "1")' );
    /** Set player color array */
    $player_color_data = array ( 'sharepanel_up_BgColor' => '', 'sharepanel_down_BgColor' => '', 'sharepaneltextColor' => '', 'sendButtonColor' => '', 
      'sendButtonTextColor' => '', 'textColor' => '', 'skinBgColor' => '', 'seek_barColor' => '', 'buffer_barColor' => '', 'skinIconColor' => '', 
      'playButtonColor' => '', 'playButtonBgColor' => '', 'playerButtonColor' => '', 'playerButtonBgColor' => '', 'relatedVideoBgColor' => '', 
      'scroll_barColor' => '', 'scroll_BgColor' => '', 'skinVisible' => '1', 'skin_opacity' => '', 'subTitleColor' => '', 'subTitleBgColor' => '', 
      'subTitleFontFamily' => '', 'subTitleFontSize' => '', 'show_social_icon' => '1', 'show_posted_by' => '1', 'recentvideo_order' => '', 
      'related_video_count' => '100','playlist_count' => '5', 'report_visible' => '', 'amazon_bucket_access_secretkey' => '', 'amazon_bucket_access_key' => '', 
      'amazonbuckets_link' => '', 'amazonbuckets_name' => '', 'amazonbuckets_enable' => '', 'iframe_visible' => '', 'googleadsense_visible' => '', 
      'user_allowed_method' => 'y', 'show_added_on' => '1', 'member_upload_enable' => '1', 'show_rss_icon' => '1' );
    /** Serialize player color array values */
    $player_color = serialize ( $player_color_data );
    /** Add player color data into settings data aray */
    $settingData  = array ( 'player_colors' => $player_color );
    /** Update settings data into db */
    $wpdb->update ( WVG_SETTINGS, $settingData, array ( 'settings_id' => '1'), '%s' );
  }
}
?>