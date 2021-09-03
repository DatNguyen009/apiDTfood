<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\ncc;
use App\Models\qtvnccs;
use App\Models\tests;


class nccsendtoqtv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qtvncc:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'nha cung cap chuyen du lieu qua cho qtv';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $timeTomorrow = explode(" ",  Carbon::tomorrow());
        $ncc =  ncc::whereDate('NCC_dateCreated', $timeTomorrow[0])->get();
        if ($ncc->count() > 0) {
            for ($i=0; $i <count($ncc) ; $i++) { 
                qtvnccs::insert(["materials_name" => $ncc[$i]["materials_name"], "materials_amount" => $ncc[$i]["materials_amount"],"materials_price" => $ncc[$i]["materials_price"] ,"materials_unit" => $ncc[$i]["materials_unit"], "NCC_dateCreated" => $ncc[$i]["NCC_dateCreated"] ]);
            }
        } 
    }
}
