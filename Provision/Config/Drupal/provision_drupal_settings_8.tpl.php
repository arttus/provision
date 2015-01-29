<?php
/**
 * @file
 * Template file for a settings.php.
 */
print '<?php' ?>

/**
 * @file Drupal's settings.php file
 *
 * This file was automatically generated by Aegir <?php print $this->version; ?>

 * on <?php print date('r'); ?>.
 *
 * If it is still managed by Aegir, changes to this file may be
 * lost. If it is not managed by aegir, you should remove this header
 * to avoid further confusion.
 */

<?php if ($subdirs_support_enabled): ?>
/**
 * Detecting subdirectory mode
 */
if (isset($_SERVER['SITE_SUBDIR']) && isset($_SERVER['RAW_HOST'])) {
  $base_url = 'http://' . $_SERVER['RAW_HOST'] . '/' . $_SERVER['SITE_SUBDIR'];
}
<?php endif; ?>

<?php if ($this->cloaked): ?>
if (isset($_SERVER['db_name'])) {
  /**
   * The database credentials are stored in the Apache or Nginx vhost config
   * of the associated site with SetEnv (fastcgi_param in Nginx) parameters.
   * They are called here with $_SERVER environment variables to
   * prevent sensitive data from leaking to site administrators
   * with PHP access, that potentially might be of other sites in
   * Drupal's multisite set-up.
   * This is a security measure implemented by the Aegir project.
   */
  $databases['default']['default'] = array(
    'driver' => $_SERVER['db_type'],
    'database' => $_SERVER['db_name'],
    'username' => $_SERVER['db_user'],
    'password' => $_SERVER['db_passwd'],
    'host' => $_SERVER['db_host'],
    /* Drupal interprets $databases['db_port'] as a string, whereas Drush sees
     * it as an integer. To maintain consistency, we cast it to a string. This
     * should probably be fixed in Drush.
     */
    'port' => (string) $_SERVER['db_port'],
  );
  $db_url['default'] = $_SERVER['db_type'] . '://' . $_SERVER['db_user'] . ':' . $_SERVER['db_passwd'] . '@' . $_SERVER['db_host'] . ':' . $_SERVER['db_port'] . '/' . $_SERVER['db_name'];
}

  /**
   * Now that we used the credentials from the apache environment, we
   * don't need them anymore. Clear them from apache and the _SERVER
   * array, otherwise they show up in phpinfo() and other friendly
   * places.
   */
  if (function_exists('apache_setenv')) {
    apache_setenv('db_type', null);
    apache_setenv('db_user', null);
    apache_setenv('db_passwd', null);
    apache_setenv('db_host', null);
    apache_setenv('db_port', null);
    apache_setenv('db_name', null);
    // no idea why they are also in REDIRECT_foo, but they are
    apache_setenv('REDIRECT_db_type', null);
    apache_setenv('REDIRECT_db_user', null);
    apache_setenv('REDIRECT_db_passwd', null);
    apache_setenv('REDIRECT_db_host', null);
    apache_setenv('REDIRECT_db_port', null);
    apache_setenv('REDIRECT_db_name', null);
  }
  unset($_SERVER['db_type']);
  unset($_SERVER['db_user']);
  unset($_SERVER['db_passwd']);
  unset($_SERVER['db_host']);
  unset($_SERVER['db_port']);
  unset($_SERVER['db_name']);
  unset($_SERVER['REDIRECT_db_type']);
  unset($_SERVER['REDIRECT_db_user']);
  unset($_SERVER['REDIRECT_db_passwd']);
  unset($_SERVER['REDIRECT_db_host']);
  unset($_SERVER['REDIRECT_db_port']);
  unset($_SERVER['REDIRECT_db_name']);

<?php else: ?>

  $databases['default']['default'] = array(
    'driver' => "<?php print $this->creds['db_type']; ?>",
    'database' => "<?php print $this->creds['db_name']; ?>",
    'username' => "<?php print $this->creds['db_user']; ?>",
    'password' => "<?php print $this->creds['db_passwd']; ?>",
    'host' => "<?php print $this->creds['db_host']; ?>",
    'port' => "<?php print $this->creds['db_port']; ?>",
   );
  $db_url['default'] = "<?php print strtr("%db_type://%db_user:%db_passwd@%db_host:%db_port/%db_name", array(
    '%db_type' => $this->creds['db_type'],
    '%db_user' => $this->creds['db_user'],
    '%db_passwd' => $this->creds['db_passwd'],
    '%db_host' => $this->creds['db_host'],
    '%db_port' => $this->creds['db_port'],
    '%db_name' => $this->creds['db_name'])); ?>";

<?php endif; ?>

  $profile = "<?php print $this->profile ?>";
  $install_profile = "<?php print $this->profile ?>";

  /**
  * PHP settings:
  *
  * To see what PHP settings are possible, including whether they can
  * be set at runtime (ie., when ini_set() occurs), read the PHP
  * documentation at http://www.php.net/manual/en/ini.php#ini.list
  * and take a look at the .htaccess file to see which non-runtime
  * settings are used there. Settings defined here should not be
  * duplicated there so as to avoid conflict issues.
  */
  @ini_set('arg_separator.output',     '&amp;');
  @ini_set('magic_quotes_runtime',     0);
  @ini_set('magic_quotes_sybase',      0);
  @ini_set('session.cache_expire',     200000);
  @ini_set('session.cache_limiter',    'none');
  @ini_set('session.cookie_lifetime',  0);
  @ini_set('session.gc_maxlifetime',   200000);
  @ini_set('session.save_handler',     'user');
  @ini_set('session.use_only_cookies', 1);
  @ini_set('session.use_trans_sid',    0);
  @ini_set('url_rewriter.tags',        '');

  /**
  * Set the umask so that new directories created by Drupal have the correct permissions
  */
  umask(0002);


  $settings['install_profile'] = '<?php print $this->profile ?>';
  $settings['<?php print $file_directory_path_var ?>'] = 'sites/<?php print $this->uri ?>/files';
  $settings['<?php print $file_directory_temp_var ?>'] = 'sites/<?php print $this->uri ?>/private/temp';
<?php if (isset($file_directory_private_var)): ?>
  $settings['<?php print $file_directory_private_var ?>'] = 'sites/<?php print $this->uri ?>/private/files';
<?php endif; ?>
<?php if (isset($drupal_hash_salt_var)): ?>
  $settings['hash_salt'] = '<?php print $drupal_hash_salt_var ?>';
<?php endif; ?>
<?php if (isset($config_directories_active_var)): ?>
  $config_directories['active'] = 'sites/<?php print $this->uri ?>/private/config/active';
<?php endif; ?>
<?php if (isset($config_directories_staging_var)): ?>
  $config_directories['staging'] = 'sites/<?php print $this->uri ?>/private/config/staging';
<?php endif; ?>
  $settings['clean_url'] = 1;
  $settings['aegir_api'] = <?php print !$this->backup_in_progress ? $this->api_version : 0 ?>;

  $settings['allow_authorize_operations'] = FALSE;

<?php if (!$this->site_enabled) : ?>
    // And this is for Drupal 8 and above.
    $settings['maintenance_mode'] = 1;
<?php endif ?>

  /**
   * Load services definition file.
   */
  $settings['container_yamls'][] = __DIR__ . '/services.yml';

<?php print $extra_config; ?>

  # Additional host wide configuration settings. Useful for safely specifying configuration settings.
  if (is_readable('<?php print $this->platform->server->include_path  ?>/global.inc')) {
    include_once('<?php print $this->platform->server->include_path  ?>/global.inc');
  }

  # Additional site configuration settings.
  if (is_readable('<?php print $this->site_path  ?>/local.settings.php')) {
    include_once('<?php print $this->site_path  ?>/local.settings.php');
  }
