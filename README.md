# Friends Only Filter

Additional rules to bypass the "Friends Only" plugin

## Usage

1. Download the plugin ([click here for latest release](https://github.com/PrysPlugins/friends-only-filter/releases/latest))
2. Upload the Plugin to your WordPress site.
3. Activate the plugin
4. Have WPE support add the following rule to the `nginx-before-in-location` field:

```nginx
### Custom Cache groups by cookie

		set $cache_group '';
		set $cookie_present 0;

		# HASH should be replaced with the MD5 hash of the siteurl field in the wp_options table	
		if ( $http_cookie ~ "HASH" ) {
			set $cookie_present 1;
			set $cache_group 'cookie';
		}

		# Set the headers
		proxy_set_header X-WPE-FO-Cookie $cookie_present;
		proxy_set_header X-WPE-Cache-Group $cache_group;

		if ( $cache_group = '' ) {
			add_header X-Type "nocache:nocookie";
			proxy_pass http://localhost:6776;
			break;
		}
```

Note that you **MUST** update the `HASH` value with the correct value. This is the MD5 hash of the `siteurl` field found in the `wp_options` table in the database. You can determine the MD5 using PHP at the command line. Here's the code snippet to use (replace `http://jeremypry.com` with the value from the site DB):

```bash
php -r 'echo md5( "http://jeremypry.com" ) . "\n";'
```
