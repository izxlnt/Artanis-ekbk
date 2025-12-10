#!/bin/bash

# Fix unsafe array access in Excel report controller
FILE="/home/muhammad-faiz-abdullah/Documents/Development/Artanis-ekbk/app/Http/Controllers/Laporan/ExcelController.php"

echo "Creating backup..."
cp "$FILE" "$FILE.backup"

echo "Fixing unsafe DB query array access patterns..."

# Method 1: Replace direct [0] access with safe helper function calls
sed -i 's/\$data_form_b_s\[\$data_shuttle->id\] = DB::select(/\$query_result = DB::select(/g' "$FILE"
sed -i 's/\$data_kemasukan_bahans\[\$data_shuttle->id\] = DB::select(/\$query_result = DB::select(/g' "$FILE"
sed -i 's/\$data_form_d_s\[\$data_shuttle->id\] = DB::select(/\$query_result = DB::select(/g' "$FILE"

# Replace ")[0]; with safe access pattern
sed -i 's/")[0];/");\n        $query_result = $this->getFirstResult($query_result);/g' "$FILE"

# Add proper variable assignments after the safe access
sed -i 's/\$query_result = $this->getFirstResult($query_result);/if (!empty($query_result)) {\n            $data_form_b_s[$data_shuttle->id] = $query_result[0];\n        } else {\n            $data_form_b_s[$data_shuttle->id] = null;\n        }/g' "$FILE"

echo "Fixed unsafe array access patterns in report controller"
echo "Backup saved as: $FILE.backup"