<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

use DB;
use ZipArchive;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DatabaseController extends Controller
{
    public function backup(Request $request){
        $datetime = date("Y-m-d_H-i-s");

        // Backup the MySQL database
        $backupFileName = "dali_backup_$datetime.sql";
        $process = new Process(['mysqldump', '-u', env('DB_USERNAME'), '-p'.env("DB_PASSWORD"), env("DB_DATABASE")]);
        $process->run();

        // Check if the backup process was successful
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Store the backup file
        Storage::put($backupFileName, $process->getOutput());

        // Download the backup file
        return Storage::download($backupFileName);
    }

    public function restore(Request $request) 
    {
        // Validate the uploaded file
        $request->validate([
            'sql_file' => 'required|file', // Adjust max file size if needed
        ]);

        // Get the uploaded file
        $sqlFile = $request->file('sql_file');

        // Get the contents of the uploaded file
        $sqlContent = file_get_contents($sqlFile->path());

        // Execute the SQL queries to restore the database
        \DB::unprepared($sqlContent);

        // Redirect back with success message
        return back()->with('success', 'Database restored successfully.');
    }
}
