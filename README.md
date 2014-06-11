# Friends Only Filter

Additional rules to bypass the "Friends Only" plugin

## Usage

1. Install the plugin
2. Activate the plugin
3. Have WPE support add the following rule to the `nginx-before-in-location` field:

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

Note that you **MUST** update the `HASH` value with the correct value. This is the MD5 hash of the `siteurl` field found in the `wp_options` table in the database.
