<?php

namespace App\Services;

use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class FileUpload
{
    public static function upload($request, $input, $collection, $model): string
    {
        if($request->hasFile($input) && $request->file($input)?->isValid()) {
            try {
                $model->clearMediaCollection();
                $model->addMediaFromRequest($input)->toMediaCollection($collection);

                return ' File uploaded successfully!';
            } catch (FileDoesNotExist|FileIsTooBig) {
                return ' File cannot be uploaded!';
            }
        }

        return '';
    }

    public static function multipleUpload($request, $input, $collection, $model): string
    {
        if($request->hasFile($input)) {
            try {
                $model->addMultipleMediaFromRequest([$input])
                    ->each(function ($fileAdder) use ($collection) {
                        $fileAdder->toMediaCollection($collection);
                    });

                return ' Files uploaded successfully!';
            } catch (FileDoesNotExist|FileIsTooBig) {
                return ' File cannot be uploaded!';
            }
        }

        return  '';
    }
}
