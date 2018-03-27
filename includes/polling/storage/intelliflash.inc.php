<?php
if (!is_array($storage_cache1['intelliflash'])) {
    $storage_cache1['intelliflash'] = snmpwalk_cache_oid($device, 'poolEntry', null, 'TEGILE-MIB');
    #d_echo($storage_cache1);
}
if (!is_array($storage_cache2['intelliflash'])) {
    $storage_cache2['intelliflash'] = snmpwalk_cache_oid($device, 'projectEntry', null, 'TEGILE-MIB');
    #d_echo($storage_cache2);
}
$iind = 0;
$storage_cache10 = array();
$storage_cache20 = array();

d_echo($storage);
foreach ($storage_cache1['intelliflash'] as $index => $poentry) {
    if (!array_key_exists('poolName', $poentry)) {
        continue;
    }
    if (is_int($index)) {
        $iind = $index;
    } else {
        $arrindex = explode(".", $index);
        $iind = (int)(end($arrindex))+0;
    }
    if (is_int($iind)) {
        $storage_cache10[$iind] = $poentry;
    }
}
$entry1 = $storage_cache10[$storage[storage_index]];

$storage['units1'] = 1;
//Tegile uses a high 32bit counter and a low 32bit counter to make a 64bit counter. Storage units are in bytes.
$storage['size'] = (($entry1['poolSizeHigh'] << 32 ) + $entry1['poolSizeLow']) * $storage['units1'];
$storage['used'] = (($entry1['poolUsedSizeHigh'] << 32 ) + $entry1['poolUsedSizeLow']) * $storage['units1'];
$storage['free'] = ($storage['size'] - $storage['used']);

/**
d_echo($storage_cache10);

foreach ($storage_cache2['intelliflash'] as $index => $prentry) {
    if (!array_key_exists('projectName', $prentry)) {
        continue;
    }
    if (is_int($index)) {
        $iind = $index;
    } else {
        $arrindex = explode(".", $index);
        $iind = (int)(end($arrindex))+0;
    }
    if (is_int($iind)) {
        $storage_cache20[$iind] = $prentry;
    }
}
d_echo($storage_cache20);

$entry2 = $storage_cache20[$storage[storage_index]];
//Tegile uses a high 32bit counter and a low 32bit counter to make a 64bit counter. Storage units are in bytes.
$storage['size'] = 100000000;
$storage['used'] = 50000000;
$storage['free'] = ($storage['size'] - $storage['used']);
