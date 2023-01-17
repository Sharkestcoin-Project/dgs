<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = array(
            array('id' => '1','name' => 'Navbar','position' => 'header','data' => '[{"text":"Home","icon":"","href":"/","target":"_self","title":""},{"text":"Products","icon":"","href":"/products","target":"_self","title":""},{"text":"Users","icon":"","href":"/users","target":"_self","title":""},{"text":"Pages","icon":"empty","href":"javascript:void(0)","target":"_self","title":"","children":[{"text":"About","icon":"empty","href":"/about","target":"_self","title":""},{"text":"Pricing","icon":"empty","href":"/pricing","target":"_self","title":""},{"text":"Contact","icon":"empty","href":"/contact","target":"_self","title":""}]},{"text":"Blog","icon":"empty","href":"/blog","target":"_self","title":""},{"text":"Pricing","icon":"empty","href":"/pricing","target":"_self","title":""}]','lang' => 'en','status' => '1','created_at' => '2022-06-28 16:50:24','updated_at' => '2022-06-28 16:50:28'),
            array('id' => '2','name' => 'Quick Links','position' => 'footer_left_menu','data' => '[{"text":"Login","icon":"","href":"/login","target":"_self","title":""},{"text":"Registration","icon":"empty","href":"/register","target":"_self","title":""},{"text":"Pricing","icon":"empty","href":"/pricing","target":"_self","title":""},{"text":"Dashboard","icon":"empty","href":"/user/dashboard","target":"_self","title":""},{"text":"Terms and condition","icon":"empty","href":"/terms-and-conditions","target":"_self","title":""}]','lang' => 'en','status' => '1','created_at' => '2022-06-28 16:50:31','updated_at' => '2022-06-28 16:50:34'),

            array('id' => '3','name' => 'HELP','position' => 'footer','data' => '[{"text":"Support","icon":"","href":"/contact","target":"_self","title":""},{"text":"Email Support","icon":"empty","href":"/contact","target":"_self","title":""},{"text":"Platform Status","icon":"empty","href":"/contact","target":"_self","title":""},{"text":"Price","icon":"empty","href":"/pricing","target":"_self","title":""},{"text":"Merchants","icon":"empty","href":"/users","target":"_self","title":""}]','lang' => 'en','status' => '1','created_at' => '2022-06-28 16:50:36','updated_at' => '2022-06-28 16:50:39'),
            array('id' => '4','name' => 'COMPANY','position' => 'footer_right_menu','data' => '[{"text":"About","icon":"","href":"/about","target":"_self","title":""},{"text":"@sellgood","icon":"empty","href":"/","target":"_self","title":""},{"text":"Products","icon":"empty","href":"/products","target":"_self","title":""},{"text":"Blog","icon":"empty","href":"/blog","target":"_self","title":""},{"text":"Contact","icon":"empty","href":"/contact","target":"_self","title":""}]','lang' => 'en','status' => '1','created_at' => '2022-06-28 16:50:42','updated_at' => '2022-06-28 16:50:44')
        );

        Menu::insert($menus);
    }
}
