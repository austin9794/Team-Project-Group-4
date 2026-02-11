<?php

function formatAddress(array $a): string {
  $lines = [
    $a['full_name'],
    $a['address_line1']
  ];

  if (!empty($a['address_line2'])) $lines[] = $a['address_line2'];
  $lines[] = $a['city'];
  if (!empty($a['county'])) $lines[] = $a['county'];
  $lines[] = $a['postcode'];
  $lines[] = $a['country'];

  return implode("\n", $lines);
}

?>