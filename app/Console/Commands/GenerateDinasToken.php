<?php

namespace App\Console\Commands;

use App\Models\Profil;
use Illuminate\Console\Command;

class GenerateDinasToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:dinas-token {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API token for a specific dinas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');
        $dinas = Profil::find($id);

        if (!$dinas) {
            $this->error("Dinas not found.");
            return;
        }

        // Generate token using Sanctum
        $token = $dinas->createToken('Dinas Token')->plainTextToken;

        // Save token to the 'token' column in 'profil' table
        $dinas->token = $token;
        $dinas->save();

        $this->info("Token for {$dinas->name} has been generated and saved.");
        $this->line($token);
    }
}
