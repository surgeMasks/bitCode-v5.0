<?php

namespace App\Traits;
use Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

trait FileTrait
{
    /**
     * Save file to the storage
     *
     * @param string $driver
     * @param \Illuminate\Http\UploadedFile $file
     * @param int $userId
     */
    public static function saveFile($driver, $file, $userId)
    {
        $name = $userId . '_' . date('Y-m-d_H-i-s') . '.' . $file->extension();
        $path = $file->storeAs('', $name, $driver);
        return $path;
    }

    public static function updateFile($driver, $file, $path, $userId)
    {
        Storage::disk($driver)->delete($path);
        $path = self::saveFile($driver, $file, $userId);
        return $path;
    }

    public static function createAddressPdf($purchase_tutes)
    {
        if($purchase_tutes->count() == 1){
            $purchase_tutes->push($purchase_tutes->first());
        }
        $pdf = PDF::loadView('pdf', ['purchases' => $purchase_tutes]);
        $fileName = Auth::user()->id . '_' . date('Y-m-d_H-i-s') . '.pdf';
        $filePath = Storage::disk('address')->path($fileName);
        $pdf->save($filePath);
        $path = Storage::disk('address')->url($fileName);
        return $path;
    }
}
