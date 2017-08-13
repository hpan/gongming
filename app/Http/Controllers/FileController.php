<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Log;
use Storage;

class FileController extends Controller
{
    //

    public function show($filename)
    {
        $contents = Storage::get($filename);
//        Log::info("contents=$contents");
    }

    public function upload(Request $request)
    {

        if ($request->isMethod('post')) {

            $file = $request->file('iptImage');

            // 文件是否上传成功
            if ($file->isValid()) {
                // 获取文件相关信息
                $originalName = $file->getClientOriginalName(); // 文件原名
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                $type = $file->getClientMimeType();     // image/jpeg

                // 上传文件
                $fileCachePath = date('Y'). "/" . date('m'). "/" . date('d'). "/";
                $fileCacheName = date('H-i-s') . '-' . uniqid() . '.' . $ext;
                $filename = $fileCachePath . $fileCacheName;
//                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                // 使用我们新建的uploads本地存储空间（目录）
                Log::info("filename=$filename, realPath = $realPath");
                $bool = Storage::disk('local')->put($filename, file_get_contents($realPath));
                $path =  storage_path($filename);

                $destinationPath = 'uploads/' . $fileCachePath;
                $file->move($destinationPath, $path);
                Log::info("path=$path");
//                var_dump($bool);
                return "/uploads/" . $filename;
            }else{
                Log::info("file is not valid.");
                return "";
            }

        }
    }
}
