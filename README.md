#Documentation

IN PROGRESS

This is where you will find the documentation for Scaffold, we recommend that you use the latest version of PHP when using this framework!

##Installation

To allow scaffold to work correctly we suggest that you set-up a vhost that points it's document root to ```scaffold/html``` here is an example:

```
Listen 1337
<VirtualHost *:1337>
    DocumentRoot "dir_of_http_server/scaffold/html/"
    <directory "dir_of_http_server/scaffold">
        Options Indexes FollowSymLinks
        AllowOverride all
        Order Allow,Deny
        Allow from all
    </directory>
</VirtualHost>
```

Also ensure that you have ```mod_rewrite``` enabled otherwise the ```.htaccess``` file will cause a ```500``` error.


##Contributions
We are open for contributions on this project, any requests or suggestions are welcome. 
