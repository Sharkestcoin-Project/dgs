<?php

namespace Database\Seeders;

use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $media = [
            ['url' => '/uploads/1/22/06/62b9a1556bad42706221656332629.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a1556bad42706221656332629.png","uploads\\/1\\/22\\/06\\/62b9a1556bad42706221656332629small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a155aad2b2706221656332629.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a155aad2b2706221656332629.png","uploads\\/1\\/22\\/06\\/62b9a155aad2b2706221656332629small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a16d76b8e2706221656332653.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a16d76b8e2706221656332653.png","uploads\\/1\\/22\\/06\\/62b9a16d76b8e2706221656332653small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a16da352d2706221656332653.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a16da352d2706221656332653.png","uploads\\/1\\/22\\/06\\/62b9a16da352d2706221656332653small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a16e047322706221656332654.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a16e047322706221656332654.png","uploads\\/1\\/22\\/06\\/62b9a16e047322706221656332654small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a16e4242e2706221656332654.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a16e4242e2706221656332654.png","uploads\\/1\\/22\\/06\\/62b9a16e4242e2706221656332654small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a16e9d7332706221656332654.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a16e9d7332706221656332654.png","uploads\\/1\\/22\\/06\\/62b9a16e9d7332706221656332654small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a16f13fa42706221656332655.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a16f13fa42706221656332655.png","uploads\\/1\\/22\\/06\\/62b9a16f13fa42706221656332655small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a16f6491a2706221656332655.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a16f6491a2706221656332655.png","uploads\\/1\\/22\\/06\\/62b9a16f6491a2706221656332655small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a16fcaaa52706221656332655.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a16fcaaa52706221656332655.png","uploads\\/1\\/22\\/06\\/62b9a16fcaaa52706221656332655small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a17023be62706221656332656.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a17023be62706221656332656.png","uploads\\/1\\/22\\/06\\/62b9a17023be62706221656332656small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a17065e5d2706221656332656.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a17065e5d2706221656332656.png","uploads\\/1\\/22\\/06\\/62b9a17065e5d2706221656332656small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a170dcc882706221656332656.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a170dcc882706221656332656.png","uploads\\/1\\/22\\/06\\/62b9a170dcc882706221656332656small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a17125f6c2706221656332657.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a17125f6c2706221656332657.png","uploads\\/1\\/22\\/06\\/62b9a17125f6c2706221656332657small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a17d7523f2706221656332669.jpg','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a17d7523f2706221656332669.jpg","uploads\\/1\\/22\\/06\\/62b9a17d7523f2706221656332669small.jpg"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a17dd4a802706221656332669.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a17dd4a802706221656332669.png","uploads\\/1\\/22\\/06\\/62b9a17dd4a802706221656332669small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a17e39a2d2706221656332670.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a17e39a2d2706221656332670.png","uploads\\/1\\/22\\/06\\/62b9a17e39a2d2706221656332670small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a17e9e1652706221656332670.jpg','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a17e9e1652706221656332670.jpg","uploads\\/1\\/22\\/06\\/62b9a17e9e1652706221656332670small.jpg"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a17ef277f2706221656332670.jpg','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a17ef277f2706221656332670.jpg","uploads\\/1\\/22\\/06\\/62b9a17ef277f2706221656332670small.jpg"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a17f47ac22706221656332671.jpg','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a17f47ac22706221656332671.jpg","uploads\\/1\\/22\\/06\\/62b9a17f47ac22706221656332671small.jpg"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a17fa8cb52706221656332671.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a17fa8cb52706221656332671.png","uploads\\/1\\/22\\/06\\/62b9a17fa8cb52706221656332671small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a180161e82706221656332672.jpg','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a180161e82706221656332672.jpg","uploads\\/1\\/22\\/06\\/62b9a180161e82706221656332672small.jpg"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a1808268e2706221656332672.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a1808268e2706221656332672.png","uploads\\/1\\/22\\/06\\/62b9a1808268e2706221656332672small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a18110bd32706221656332673.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a18110bd32706221656332673.png","uploads\\/1\\/22\\/06\\/62b9a18110bd32706221656332673small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a1816c0752706221656332673.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a1816c0752706221656332673.png","uploads\\/1\\/22\\/06\\/62b9a1816c0752706221656332673small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a181cc3302706221656332673.png','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a181cc3302706221656332673.png","uploads\\/1\\/22\\/06\\/62b9a181cc3302706221656332673small.png"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a1822782f2706221656332674.jpg','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a1822782f2706221656332674.jpg","uploads\\/1\\/22\\/06\\/62b9a1822782f2706221656332674small.jpg"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a182884d52706221656332674.jpg','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a182884d52706221656332674.jpg","uploads\\/1\\/22\\/06\\/62b9a182884d52706221656332674small.jpg"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a182e4da02706221656332674.jpg','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a182e4da02706221656332674.jpg","uploads\\/1\\/22\\/06\\/62b9a182e4da02706221656332674small.jpg"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()],
            ['url' => '/uploads/1/22/06/62b9a18376ddb2706221656332675.jpg','driver' => 'local','files' => '["uploads\\/1\\/22\\/06\\/62b9a18376ddb2706221656332675.jpg","uploads\\/1\\/22\\/06\\/62b9a18376ddb2706221656332675small.jpg"]','user_id' => NULL,'is_optimized' => '0','created_at' => now(),'updated_at' => now()]
        ];

        Media::insert($media);
    }
}
