<?php


namespace App\Http\Controllers\API;

use App\Helper\File;
use App\Helper\Sort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    private $_sort_helper;
    private $_file_helper;

    public function __construct(Sort $sortHelper, File $fileHelper) {
        $this->_sort_helper = $sortHelper;
        $this->_file_helper = $fileHelper;
    }

    public function validate_files(Request $request) {
        if($request->file_types_accepted) {
            $validator = Validator::make(
                $request->all(), [
                'files.*' => 'mimes:' . $request->file_types_accepted . '|max:20000'
            ],[
                    'files.*.mimes'     => 'Only ' . $request->file_types_accepted . ' file types are allowed',
                    'files.*.max'       => 'Maximum file size for upload is 20MB',
                ]
            );
        } else {
            $validator = Validator::make(
                $request->all(), [
                'files.*' => 'mimes:doc,docx,gif,jpg,jpeg,pdf,png|max:20000'
            ],[
                    'files.*.mimes'     => 'Only doc,docx,gif,jpg,jpeg,pdf and png file types are allowed',
                    'files.*.max'       => 'Maximum file size for upload is 20MB',
                ]
            );
        }

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'    =>  $validator->errors()
            ], 201);
        }

        return response()->json([
            'status'    => 'success'
        ], 201);
    }

    public function files_list($folder_name, $item_id) {
        $file_directory_path = $folder_name.'/'.$item_id.'/files';

        $directories = Storage::directories($folder_name.'/'.$item_id. '/files');

        $formatted_directories = array();

        foreach($directories as $directory) {
            $dir_array = explode('/', $directory);
            $dirs = $this->_sort_helper->removePrecedingArrayElements($dir_array, 'files');
            $formatted_directories[] = $this->_file_helper->nestArray($dirs, $file_directory_path);
        }

        $files = Storage::files($file_directory_path);

        if(!empty($files)) {
            foreach($files as &$file) {
                $file_array = explode('/', $file);
                $file_name = end($file_array);
                $file_ext_array = explode('.', $file_name);
                $file_ext = end($file_ext_array);

                $file = array(
                    'name'              =>  $file_name,
                    'path'              =>  Storage::url($file),
                    'file_ext'          =>  $file_ext,
                    'last_modified'     =>  date('d/m/Y', Storage::lastModified($file))
                );
            }

            $formatted_directories[] = array(
                'name'      =>  'Uncategorised',
                'type'      =>  'folder',
                'files'     =>  $files,
                'children'  =>  array()
            );
        }

        return response()->json($formatted_directories);
    }

    public function add_directory(Request $request, $folder_name, $item_id) {
        $file_directory_path = $folder_name.'/'.$item_id.'/files';

        $dir_name = $request->directory_name;

        Storage::makeDirectory($file_directory_path .'/'. $dir_name);

        return response()->json([
            'status'    => 'success',
            'message'   => 'Directory successfully added to project'
        ], 201);
    }

    public function add_file(Request $request,$folder_name, $item_id) {
        $file_directory_path = $folder_name.'/'.$item_id.'/files';

        if($request->hasFile('files')) {
            foreach($request->file('files') as $file) {
                if($request->category) {
                    $file->storeAs($file_directory_path . '/' . $request->category,$file->getClientOriginalName());
                } else {
                    $file->storeAs($file_directory_path . '/',$file->getClientOriginalName());
                }
            }
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'File(s) successfully added to project'
        ], 201);
    }

    public function assign_file(Request $request, $folder_name, $item_id) {
        $file_directory_path = $folder_name.'/'.$item_id.'/files';

        $folder_to_assign_to = $request->folder;
        $existing_file_path = $request->existing_file_path;

        $file_array = explode('/', $existing_file_path);
        $file_name = end($file_array);
        $file_array =  array_slice($file_array, 4);
        $existing_file_path = implode('/',$file_array);
        $new_file_path = $file_directory_path . '/' . $folder_to_assign_to . '/' . $file_name;

        Storage::move($existing_file_path, $new_file_path);

        return response()->json([
            'status'    => 'success',
            'message'   => 'File successfully assigned to directory'
        ], 201);
    }
}
