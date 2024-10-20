<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function handlePdfUpload($data, $no = null, $model = null)
    {
        // Check if a PDF file exists in the 'content' key
        if (isset($data['content']) && $data['content']->isValid()) {
            // Generate a unique file name using the current date and original file name
            $fileName = date('YmdHi') . '_' . $data['content']->getClientOriginalName();

            // Store the uploaded PDF file in the 'certificates' directory under 'public' disk
            $data['content']->storeAs('/certificates', $fileName, 'public');

            // Update the content path to include the stored file location
            $data['content'] = '/storage/certificates/' . $fileName;
        }

        // Optional: Delete the old file if $no == 1 and a model is provided
        if ($no == 1 && $model) {
            $trimmedPath = trim(str_replace("/storage/", "", $model->content));

            if (Storage::disk('public')->exists($trimmedPath)) {
                Storage::disk('public')->delete($trimmedPath);
            }
        }

        return $data['content'];
    }
}
