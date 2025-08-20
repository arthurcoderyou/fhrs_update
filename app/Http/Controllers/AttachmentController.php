<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuneralAttachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function ftpDownload($id)
    {

        if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule download attachments') ){
            $attachment = FuneralAttachments::findOrFail($id);

            $folder = $attachment->funeral_schedule->folder;

            if (empty($folder)) {
                abort(404, 'File not found on FTP.');
            }
 

            $ftpPath = 'uploads/funeral_attachments/'.$folder.'/' . $attachment->attachment;
            $fileName = $attachment->attachment;

            if (!Storage::disk('ftp')->exists($ftpPath)) {
                abort(404, 'File not found on FTP.');
            }

            $fileContents = Storage::disk('ftp')->get($ftpPath);

            return response($fileContents)
                ->header('Content-Type', 'application/octet-stream')
                ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
        }else{

            
            // For error message
            session()->flash('alert.error', 'You do not have permission to download this file');
            return redirect()->back();

        }


        
    }
}
