#!/bin/bash

# Comprehensive fix for ShuttleFour FormCController hardcoded [0] indices
FILE="/home/muhammad-faiz-abdullah/Documents/Development/Artanis-ekbk/app/Http/Controllers/ShuttleFour/FormCController.php"

echo "Starting comprehensive fix for ShuttleFour FormCController..."

# Fix line 595 - KKS update method
sed -i '595s/total_kayu_dibawa_bulan_hadapan\[0\]/total_kayu_dibawa_bulan_hadapan[$keySpecies]/' "$FILE"

# Fix line 855 - KKR create method  
sed -i '855s/total_kayu_dibawa_bulan_hadapan\[0\]/total_kayu_dibawa_bulan_hadapan[$keySpecies]/' "$FILE"

# Fix line 882 - KKR update method
sed -i '882s/total_kayu_dibawa_bulan_hadapan\[0\]/total_kayu_dibawa_bulan_hadapan[$keySpecies]/' "$FILE"

# Fix line 1142 - Kayu Lembut create method
sed -i '1142s/total_kayu_dibawa_bulan_hadapan\[0\]/total_kayu_dibawa_bulan_hadapan[$keySpecies]/' "$FILE"

# Fix line 1169 - Kayu Lembut update method
sed -i '1169s/total_kayu_dibawa_bulan_hadapan\[0\]/total_kayu_dibawa_bulan_hadapan[$keySpecies]/' "$FILE"

# Fix line 1541 - Kayu Lain-lain create method
sed -i '1541s/total_kayu_dibawa_bulan_hadapan\[0\]/total_kayu_dibawa_bulan_hadapan[$keySpecies]/' "$FILE"

# Fix line 1571 - Kayu Lain-lain update method
sed -i '1571s/total_kayu_dibawa_bulan_hadapan\[0\]/total_kayu_dibawa_bulan_hadapan[$keySpecies]/' "$FILE"

echo "Fixes applied to 7 remaining locations in ShuttleFour FormCController"

# Verify the changes
echo "Verifying changes..."
grep -n "total_kayu_dibawa_bulan_hadapan\[0\]" "$FILE" | wc -l
remaining=$(grep -n "total_kayu_dibawa_bulan_hadapan\[0\]" "$FILE" | wc -l)

if [ "$remaining" -eq 1 ]; then
    echo "✓ Successfully fixed 7 out of 8 instances. 1 instance remaining (line 1356 - calculation only, not assignment)"
else
    echo "❌ $remaining instances still remain"
    grep -n "total_kayu_dibawa_bulan_hadapan\[0\]" "$FILE"
fi

echo "ShuttleFour FormCController fix completed!"