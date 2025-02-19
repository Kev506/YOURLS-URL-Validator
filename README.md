# YOURLS-URL-Validator
A YOURLS plugin that checks submitted URL's for validity and reachability.

- If a submitted URL does not meet [RFC 2396](http://www.faqs.org/rfcs/rfc2396.html) standards, it is rejected
- If a submitted URL is unreachable and times out after 5 seconds, it is rejected

### Requirements
- A working [YOURLS](https://github.com/YOURLS/YOURLS) installation
- php-curl installed and activated

### INSTALLATION

1. Place the url_validator folder in YOURLS/user/plugins/
2. Activate in the Admin interface under Manage Plugins

