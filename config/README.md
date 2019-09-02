#about


#installation


#notes:
###################################################################################################################################
--> Because the version of mysql is low, we need to change the "mysql" settings in  /config/database.php to dont get specified key too long error.

'charset' => 'utf8mb4'             .....................> 'charset' => 'utf8'
'collation' => 'utf8mb4_unicode_ci', ...................>'collation' => 'utf8_unicode_ci'

###################################################################################################################################

#relations
user() ( 1 - M ) questions()