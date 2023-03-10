<?php
declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inquiry;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class InquiriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Inquiry::factory()->count(50)->create();

        //1件のデータ
        //  $titles = ["テスト","練習","実践"];

        // foreach($titles as $title){
        //     DB::table('tasks')->insert([
        //         'title' => $title,
        //         'folder_id' => 3,
        //         'due_date'  => Carbon::now(),
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //            ]);
    }


}
