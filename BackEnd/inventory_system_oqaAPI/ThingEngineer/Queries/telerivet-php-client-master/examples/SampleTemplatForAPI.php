
<?php
require_once 'telerivet-php-client-master/telerivet.php';

$api_key = "PzCAV_ObmTLDWiPFdon9jOgIeHu517WPX3ym"; // see https://telerivet.com/dashboard/api
$project_id = "PJdc5e87ae774d0944";

$tr = new Telerivet_API($api_key);
$project = $tr->initProjectById($project_id);


$sent_msg = $project->sendMessage(array(
    'content' => "hello world", 
    'to_number' => "+16505550123"
));
?>