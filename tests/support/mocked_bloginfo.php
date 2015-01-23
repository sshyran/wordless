<?php

# mocking WP bloginfo
function get_bloginfo($key) {
  if ($key == "template_url")
    return "http://mocked.url/wp-content/themes/mocked_theme";

  if ($key == "url")
    return "http://mocked.url";

  return "mocked_" . $key;
}
