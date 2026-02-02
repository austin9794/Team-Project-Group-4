<?php
// Clear all opcode cache
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo 'Opcode cache cleared\n';
}
if (function_exists('apc_clear_cache')) {
    apc_clear_cache();
    echo 'APC cache cleared\n';
}
echo 'PHP cache reset complete!';
