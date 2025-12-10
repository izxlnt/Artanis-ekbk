#!/bin/bash

# Comprehensive fix for unsafe array access in Excel reports
FILE="/home/muhammad-faiz-abdullah/Documents/Development/Artanis-ekbk/app/Http/Controllers/Laporan/ExcelController.php"

echo "Creating backup..."
cp "$FILE" "${FILE}.backup"

echo "Applying comprehensive fixes for unsafe array access..."

# Create a temporary Python script to handle complex replacements
cat > fix_reports.py << 'EOF'
import re
import sys

def fix_unsafe_array_access(content):
    # Pattern 1: Fix DB::select queries with [0] access
    pattern1 = r'(\$data_[^=]+)\s*=\s*DB::select\((.*?)\"\)\[0\];'
    
    def replace_func1(match):
        var_assignment = match.group(1)
        query_content = match.group(2)
        return f'$query_result = DB::select({query_content}");\n        {var_assignment} = $this->getFirstResult($query_result);'
    
    content = re.sub(pattern1, replace_func1, content, flags=re.DOTALL)
    
    # Pattern 2: Fix other [0] access patterns
    pattern2 = r'(\$[^=\[]+)\s*=\s*([^;]+\]\[0\]);'
    
    def replace_func2(match):
        var_name = match.group(1)
        array_access = match.group(2)
        safe_access = array_access.replace('[0]', '')
        return f'$temp_result = {safe_access};\n        {var_name} = !empty($temp_result) ? $temp_result[0] : null;'
    
    content = re.sub(pattern2, replace_func2, content)
    
    return content

if __name__ == "__main__":
    file_path = sys.argv[1]
    
    with open(file_path, 'r') as f:
        content = f.read()
    
    fixed_content = fix_unsafe_array_access(content)
    
    with open(file_path, 'w') as f:
        f.write(fixed_content)
    
    print("Fixed unsafe array access patterns")

EOF

python3 fix_reports.py "$FILE"

echo "Report fixes applied successfully"
echo "Backup saved as: ${FILE}.backup"