<?php 


$app->get('(:index)', function() {
	echo 'hello';
});

$app->not_found(function() {
	echo 'aw, no!';
});