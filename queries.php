<?php

$verifyUsernamePasswordSQL = <<<SELECT
Select user_name, password From nishanth.USER_DETAIL where user_name= '\$username' and password = '\$password'
SELECT;
?>