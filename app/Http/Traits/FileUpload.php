<?php
namespace App\Http\Traits;
use Illuminate\Support\Facades\Storage;

trait FileUpload
{
    public static function upload($request,$folderName,$type):string
    {
        if ($file = $request->file($type)) {
        $ext = $file->getClientOriginalExtension();
         $file_name = md5(rand(1000, 10000));
         $file_fullname = $file_name . '.' . $ext;
        $path=$file->storeAs($folderName,$file_fullname,'user');
        $url=Storage::disk('user')->url($path);
        return $url;
        }
    }
    public function deleteFile(string $filePath, string $disk = 'public'): bool
    {
        return Storage::disk($disk)->delete($filePath);
    }
}

