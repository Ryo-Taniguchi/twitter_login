<?php

$list1 = array(1,2,3,4,5,6);
echo '<pre>';
print_r(getSumByFor($list1));
echo '<br>';

function getSumByFor($list) {
	$length = count($list);
	$sum = 0;

	for ($i = 0; $i < $length; $i++) {
		$sum += $list[$i];
	}

	return $sum;
}

$list2 = array(1,2,3,4,5,6);
print_r(getSumByWhile($list2));
echo '<br>';

function getSumByWhile($list) {
	$sum = 0;
  while (true) {
    if(empty($list)) {
      break;
    }
  }
}
