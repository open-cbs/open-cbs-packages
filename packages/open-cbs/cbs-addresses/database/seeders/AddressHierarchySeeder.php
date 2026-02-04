<?php

namespace OpenCbs\CbsAddresses\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AddressHierarchySeeder extends Seeder
{
    public function run()
    {
        $this->seedTable('cbs_addresses.divisions', 'divisions.json', [
            'id',
            'name',
            'bn_name',
            'url'
        ]);

        $this->seedTable('cbs_addresses.districts', 'districts.json', [
            'id',
            'division_id',
            'name',
            'bn_name',
            'lat',
            'lon',
            'url'
        ]);

        $this->seedTable('cbs_addresses.upazilas', 'upazilas.json', [
            'id',
            'district_id',
            'name',
            'bn_name',
            'url'
        ]);

        $this->seedTable('cbs_addresses.unions', 'unions.json', [
            'id',
            'upazila_id' => 'upazilla_id',
            'name',
            'bn_name',
            'url'
        ]);
    }

    private function seedTable(string $table, string $filename, array $columns)
    {
        $path = __DIR__ . '/../data/' . $filename;

        if (!File::exists($path)) {
            $this->command->warn("File not found: $path");
            return;
        }

        $json = File::get($path);

        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error("Error decoding JSON for $table: " . json_last_error_msg());
            return;
        }

        // Handle PHPMyAdmin export format (wrapper object)
        // Check if root is array and first element has 'type' => 'header'
        if (is_array($data) && isset($data[0]['type']) && $data[0]['type'] === 'header') {
            $found = false;
            foreach ($data as $item) {
                if (($item['type'] ?? '') === 'table' && isset($item['data'])) {
                    $data = $item['data'];
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $this->command->warn("Could not find 'data' in PHPMyAdmin export format for $filename. Using root array.");
            }
        }

        $count = is_array($data) ? count($data) : 0;
        $this->command->info("Seeding $table with $count records...");

        if ($count === 0) {
            return;
        }

        $chunks = array_chunk($data, 500);

        foreach ($chunks as $chunk) {
            $insertData = [];
            foreach ($chunk as $item) {
                $row = [];
                foreach ($columns as $dbCol => $jsonKey) {
                    if (is_int($dbCol)) {
                        $dbCol = $jsonKey; // Numeric key means value is both db column and json key
                    }
                    $row[$dbCol] = $item[$jsonKey] ?? null;
                }

                // Validate ID presence (must be truthy, '0' is truthy string but strict empty check handles it?)
                // empty('0') is true. But ID 0 is unlikely for these tables (starts at 1).
                // If ID is missing or null, skip.
                if (empty($row['id'])) {
                    // Start skipping silently to avoid spam if many header-like items persist?
                    // But with logic above, headers should be stripped.
                    // If we see empty ID, it's likely bad data.
                    continue;
                }

                $row['created_at'] = now();
                $row['updated_at'] = now();
                $insertData[] = $row;
            }

            if (empty($insertData)) {
                continue;
            }

            DB::table($table)->upsert($insertData, ['id'], array_keys($row));
        }
    }
}
