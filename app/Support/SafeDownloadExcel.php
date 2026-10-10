<?php

namespace App\Support;

use Maatwebsite\Excel\Excel;

/**
 * On this Windows/IIS host the temp .xlsx is often still locked (e.g. by AV scan)
 * when Symfony's BinaryFileResponse unlinks it after streaming. The resulting
 * "unlink(): Permission denied" error page was appended to the download,
 * corrupting the Excel file. Buffer the file instead and delete it best-effort.
 */
class SafeDownloadExcel extends Excel
{
    public function download($export, string $fileName, string $writerType = null, array $headers = [])
    {
        $temporaryFile = $this->export($export, $fileName, $writerType);
        $contents = $temporaryFile->contents();

        try {
            $temporaryFile->delete();
        } catch (\Throwable $e) {
            // locked file is left behind for later cleanup; never break the download
        }

        $disposition = 'attachment; filename="' . str_replace('"', '', $fileName) . '"';

        return response($contents, 200, array_merge([
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => $disposition,
            'Content-Length'      => strlen($contents),
            'Cache-Control'       => 'max-age=0',
        ], $headers));
    }
}
