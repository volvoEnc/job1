<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name', 'path', 'message_id'
    ];

    static public function addAttachments ($request, Message $message)
    {
        if (!empty($request->hasFile('attachments'))) {
            $files = $request->file('attachments');
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $path = $file->store('/', 'public');
                File::create([
                    'message_id' => $message->id,
                    'name' => $name,
                    'path' => $path
                ]);
            }
        }
    }
}
