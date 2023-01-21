<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NullHypothesisDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('null_hypothesis_data')->insert([
            'id' => 1,
            'null_hypothesis' => 'CAR Does not Granger Cause NPF',
            'group_id' => 1,
            'obs' => 135,
            'fStatic' => 0.60072,
            'prob' => NULL,
            'jenis' => 'b',
            'id_negara' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('null_hypothesis_data')->insert([
            'id' => 2,
            'null_hypothesis' => 'NPF Does not Granger Cause CAR',
            'group_id' => 1,
            'obs' => NULL,
            'fStatic' => 143.734,
            'prob' => NULL,
            'jenis' => 'b',
            'id_negara' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('null_hypothesis_data')->insert([
            'id' => 3,
            'null_hypothesis' => 'IPR Does not Granger Cause NPF',
            'group_id' => 2,
            'obs' => 135,
            'fStatic' => 0.87309,
            'prob' => NULL,
            'jenis' => 'b',
            'id_negara' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('null_hypothesis_data')->insert([
            'id' => 4,
            'null_hypothesis' => 'NPF Does not Granger Cause IPR',
            'group_id' => 2,
            'obs' => NULL,
            'fStatic' => 0.55142,
            'prob' => NULL,
            'jenis' => 'b',
            'id_negara' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('null_hypothesis_data')->insert([
            'id' => 5,
            'null_hypothesis' => 'FDR Does not Granger Cause NPF',
            'group_id' => 3,
            'obs' => 135,
            'fStatic' => 249.73,
            'prob' => NULL,
            'jenis' => 'b',
            'id_negara' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('null_hypothesis_data')->insert([
            'id' => 6,
            'null_hypothesis' => 'FDR Does not Granger Cause NPF',
            'group_id' => 3,
            'obs' => NULL,
            'fStatic' => 249.73,
            'prob' => NULL,
            'jenis' => 'b',
            'id_negara' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('null_hypothesis_data')->insert([
            'id' => 7,
            'null_hypothesis' => 'IPR Does not Granger Cause CAR',
            'group_id' => 4,
            'obs' => 135,
            'fStatic' => 314366,
            'prob' => NULL,
            'jenis' => 'b',
            'id_negara' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('null_hypothesis_data')->insert([
            'id' => 8,
            'null_hypothesis' => 'CAR Does not Granger Cause IPR',
            'group_id' => 4,
            'obs' => NULL,
            'fStatic' => 123.709,
            'prob' => NULL,
            'jenis' => 'b',
            'id_negara' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('null_hypothesis_data')->insert([
            'id' => 9,
            'null_hypothesis' => 'FDR Does not Granger Cause CAR',
            'group_id' => 5,
            'obs' => 135,
            'fStatic' => 331.48,
            'prob' => NULL,
            'jenis' => 'b',
            'id_negara' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('null_hypothesis_data')->insert([
            'id' => 10,
            'null_hypothesis' => 'CAR Does not Granger Cause FDR',
            'group_id' => 5,
            'obs' => NULL,
            'fStatic' => 0.56854,
            'prob' => NULL,
            'jenis' => 'b',
            'id_negara' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('null_hypothesis_data')->insert([
            'id' => 11,
            'null_hypothesis' => 'FDR Does not Granger Cause IPR',
            'group_id' => 6,
            'obs' => 135,
            'fStatic' => 157.375,
            'prob' => NULL,
            'jenis' => 'b',
            'id_negara' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('null_hypothesis_data')->insert([
            'id' => 12,
            'null_hypothesis' => 'IPR Does not Granger Cause FDR',
            'group_id' => 6,
            'obs' => NULL,
            'fStatic' => 204.928,
            'prob' => NULL,
            'jenis' => 'b',
            'id_negara' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
