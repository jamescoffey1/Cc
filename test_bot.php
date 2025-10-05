<?php
include "config.php";
include "Commands/user.php";
include "Commands/admin.php";

// Test with a simple message
$test_chat_id = 999999;
$test_name = "TestUser";
$test_user_id = 999999;

echo "Testing start_command function...\n";
$result = start_command($test_chat_id, $test_name, $test_user_id);
var_dump($result);
