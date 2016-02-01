# romanempire
> Autobuilder script for roman empire game (android game).

# Introduction
> This is a PHP project made by me(jbauson) to login and play the game while I am away. This can do things like login, scout, add scouted to favorites, upgrade buildings and techs, etc. 

# Login Class
```php
include("class_Common.php");
include("class_Login.php");
$user = newLogin("userName","PassWord");
$userInfo = $user->login();
```
> This will login the user and create a new template name "userName-index.php"


# Scout Class
```php
include("class_Common.php");
include("class_PlayerInfo.php");
include("class_Scout.php");

$var = new Scout($server,$key,$playerInfo);
$var->scoutBarb(2,10); // This will scout 2 Star Barbs with with attack quota not less than 10.
```

# Modified Date
01/23/2016