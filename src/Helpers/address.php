<?php

function formatAddress(array $addr): string
{
    $parts = [];

    if (!empty($addr['full_name'])) {
        $parts[] = $addr['full_name'];
    }

    if (!empty($addr['address_line1'])) {
        $parts[] = $addr['address_line1'];
    }

    if (!empty($addr['address_line2'])) {
        $parts[] = $addr['address_line2'];
    }

    if (!empty($addr['city'])) {
        $parts[] = $addr['city'];
    }

    if (!empty($addr['county'])) {
        $parts[] = $addr['county'];
    }

    if (!empty($addr['postcode'])) {
        $parts[] = $addr['postcode'];
    }

    if (!empty($addr['country'])) {
        $parts[] = $addr['country'];
    }

    return implode("\n", $parts);
}


?>