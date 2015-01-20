<?php
/**
 * This module provides methods for accesing theme URL path.
 *
 * @ingroup helperclass
 */
class UrlHelper {

  /**
   * Returns URL arguments
   *
   * @param int $index (optional)
   *   The number (counting from zero) of the argument in the list. If is not
   *   specified  all arguments will be returned as an array.
   * @return array|mixed
   *   If $index was specified returns the relative URL argument, elsewhere
   *   returns an array with all available URL arguments.
   *
   * @ingroup helperfunc
   */
  function arg($index = NULL) {
    $args = array_values(array_filter(explode('/', $_SERVER['REQUEST_URI'])));

    if (isset($index))
      return $args[$index];

    return $args;
  }

  /**
   * Returns the URL path to the spcified folder in the assets directory.
   *
   * @param string $path
   *   The path inside the @e {theme}/assets/ folder.
   * @return string
   *   The complete URL path to the specified folder.
   *
   * @ingroup helperfunc
   */
  function asset_url($path) {
    return get_bloginfo('stylesheet_directory') . "/assets/$path";
  }

  /**
   * Returns the URL path to the spcified path in the bower_components
   * directory.
   *
   * @param string $path
   *   The path inside the bower_components folder.
   * @return string
   *   The complete URL path to the specified folder.
   *
   * @ingroup helperfunc
   */
  function bower_asset_url($path) {
    return get_bloginfo('url') . "/$path";
  }

  /**
   * Returns the URL path to the specified folder in the images directory.
   *
   * @param string $path
   *   The path inside the @e {theme}/assets/images/ folder.
   * @return string
   *   The complete URL path to the specified folder.
   *
   * @ingroup helperfunc
   */
  function image_url($path) {
    return asset_url("images/$path");
  }

  /**
   * Returns the URL path to the specified folder in the stylesheet directory.
   *
   * @param string $path
   *   The path inside the @e {theme}/assets/stylesheet/ folder.
   * @return string
   *   The complete URL path to the specified folder.
   *
   * @ingroup helperfunc
   */
  function stylesheet_url($path) {
    if (!preg_match("/\.css$/", $path)) $path .= ".css";
    return asset_url("stylesheets/$path");
  }

  /**
   * Returns the URL path to the specified folder in the javascript directory.
   *
   * @param string $path
   *   The path inside the @e {theme}/assets/javascript/ folder.
   * @return string
   *   The complete URL path to the specified folder.
   *
   * @ingroup helperfunc
   */
  function javascript_url($path) {
    if (!preg_match("/\.js$/", $path)) $path .= ".js";
    return asset_url("javascripts/$path");
  }


  /**
   * Searches and returns the requested JS assets from inside
   * bower_components directory
   * @param  string $path Asset name w/ or w/o js extension
   * @return string       URL of the asset
   */
  function bower_javascript_url($path) {
    require_once('wp-admin/includes/file.php');

    if (!preg_match("/\.js$/", $path)) $path .= ".js";
    $bower_asset = Wordless::recursive_glob(get_home_path() . 'bower_components', $path)[0];
    $bower_asset = str_replace(get_home_path(), '', $bower_asset);

    return bower_asset_url($bower_asset);
  }

  /**
   * Searches and returns the requested CSS assets from inside
   * bower_components directory
   * @param  string $path Asset name w/ or w/o js extension
   * @return string       URL of the asset
   */
  function bower_stylesheet_url($path) {
    require_once('wp-admin/includes/file.php');

    if (!preg_match("/\.js$/", $path)) $path .= ".css";
    $bower_asset = Wordless::recursive_glob(get_home_path() . 'bower_components', $path)[0];
    $bower_asset = str_replace(get_home_path(), '', $bower_asset);

    return bower_asset_url($bower_asset);
  }

  /**
   * Check if an URL is absolute or not
   * URL are considered absolute if they begin with a protocol specification
   * (https|https in this case) or with the double slash (//) to take advantage
   * of the protocol relative URL (http://paulirish.com/2010/the-protocol-relative-url/)
   *
   * @param string $url
   *   The url to check.
   * @return boolean
   *   Either true if the URL is absolute or false if it is not.
   *
   * @ingroup helperfunc
   */

  function is_absolute_url($url) {
    return(preg_match("/^((https?:)?\/\/|data:)/", $url) === 1);
  }


  /**
   * Check if an URL is root relative
   * URL are considered root relative if they are not absolute but begin with a /
   *
   * @param string $url
   *   The url to check.
   * @return boolean
   *   Either true if the URL is root relative or false if it is not.
   *
   * @ingroup helperfunc
   */

  function is_root_relative_url($url) {
    return(!is_absolute_url($url) && preg_match("/^\//", $url) === 1);
  }

  /**
   * Check if an URL is relative
   * URL are considered relative if they are not absolute and don't begin with a /
   *
   * @param string $url
   *   The url to check.
   * @return boolean
   *   Either true if the URL is relative or false if it is not.
   *
   * @ingroup helperfunc
   */

  function is_relative_url($url) {
    return(!(is_absolute_url($url) || is_root_relative_url($url)));
  }

}

Wordless::register_helper("UrlHelper");
