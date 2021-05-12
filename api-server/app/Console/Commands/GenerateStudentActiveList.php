<?php


namespace App\Console\Commands;


use App\Services\HarmonogramService;
use Illuminate\Console\Command;

class GenerateStudentActiveList extends Command {

    protected $signature = 'generate:studentActiveList';
    protected $description = 'Insert student active list';
    private $harmonogramService;

    public function __construct (HarmonogramService $harmonogramService) {
        parent::__construct();

        $this->harmonogramService = $harmonogramService;
    }

    public function handle (  ) {

        $this->harmonogramService->initStudentActivityToCheck(date('Y-m-d'), date('H:i'));

        return 0;
    }
}
