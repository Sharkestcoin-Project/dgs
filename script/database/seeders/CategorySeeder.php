<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['key' => 'trusted_partner','value' => '{"image": "/frontend/img/icons/2.png", "title": "Aribnb", "website_link": "https://www.airbnb.com/"}','lang' => 'en','status' => '1','created_at' => '2022-06-25 10:57:25','updated_at' => '2022-06-25 10:57:25'],
            ['key' => 'trusted_partner','value' => '{"image": "/frontend/img/icons/3.png", "title": "Paypal", "website_link": "https://www.paypal.com/"}','lang' => 'en','status' => '1','created_at' => '2022-06-25 10:57:25','updated_at' => '2022-06-25 10:57:25'],
            ['key' => 'trusted_partner','value' => '{"image": "/frontend/img/icons/4.png", "title": "Amazon", "website_link": "https://www.amazon.com/"}','lang' => 'en','status' => '1','created_at' => '2022-06-25 10:57:25','updated_at' => '2022-06-25 10:57:25'],
            ['key' => 'trusted_partner','value' => '{"image": "/frontend/img/icons/5.png", "title": "Slack", "website_link": "https://www.slack.com/"}','lang' => 'en','status' => '1','created_at' => '2022-06-25 10:57:25','updated_at' => '2022-06-25 10:57:25'],
            ['key' => 'trusted_partner','value' => '{"image": "/frontend/img/icons/6.png", "title": "Microsoft", "website_link": "https://www.microsoft.com/"}','lang' => 'en','status' => '1','created_at' => '2022-06-25 10:57:25','updated_at' => '2022-06-25 10:57:25'],
            ['key' => 'trusted_partner','value' => '{"image": "/frontend/img/icons/7.png", "title": "Github", "website_link": "https://www.github.com/"}','lang' => 'en','status' => '1','created_at' => '2022-06-25 10:57:25','updated_at' => '2022-06-25 10:57:25'],
            ['key' => 'faq','value' => '{"answer": "Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt eiusmod.", "question": "How can I purchased The Sell?"}','lang' => 'en','status' => '1','created_at' => '2022-06-28 08:41:57','updated_at' => '2022-06-28 08:41:57'],
            ['key' => 'faq','value' => '{"answer": "How can I purchased The Sell?", "question": "What are the minimum requirements?"}','lang' => 'en','status' => '1','created_at' => '2022-06-28 08:42:06','updated_at' => '2022-06-28 08:42:24'],
            ['key' => 'faq','value' => '{"answer": "Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt eiusmod.", "question": "What is the regular license?"}','lang' => 'en','status' => '1','created_at' => '2022-06-28 08:42:46','updated_at' => '2022-06-28 08:42:46'],
            ['key' => 'reviews','value' => '{"name": "Jhone Doe", "image": "/uploads/1/22/06/62b9a182e4da02706221656332674.jpg", "rating": "1", "comment": "Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto cupiditate molestias sunt,\\r\\n                                ea id veritatis fugit quam blanditiis rerum reprehenderit maxime expedita odit,\\r\\n                                laboriosam voluptatibus? Iure corporis nulla eveniet quam.", "position": "Developer"}','lang' => 'en','status' => '1','created_at' => '2022-06-28 08:55:05','updated_at' => '2022-06-28 08:55:05'],
            ['key' => 'reviews','value' => '{"name": "Jane Doe", "image": "/uploads/1/22/06/62b9a182884d52706221656332674.jpg", "rating": "4", "comment": "Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto cupiditate molestias sunt,\\r\\n                                ea id veritatis fugit quam blanditiis rerum reprehenderit maxime expedita odit,\\r\\n                                laboriosam voluptatibus? Iure corporis nulla eveniet quam.", "position": "Developer"}','lang' => 'en','status' => '1','created_at' => '2022-06-28 08:57:59','updated_at' => '2022-06-28 08:58:41'],
            ['key' => 'reviews','value' => '{"name": "Jhone Doe", "image": "/uploads/1/22/06/62b9a182e4da02706221656332674.jpg", "rating": "1", "comment": "Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto cupiditate molestias sunt,\\r\\n                                ea id veritatis fugit quam blanditiis rerum reprehenderit maxime expedita odit,\\r\\n                                laboriosam voluptatibus? Iure corporis nulla eveniet quam.", "position": "Developer"}','lang' => 'en','status' => '1','created_at' => '2022-06-28 08:55:05','updated_at' => '2022-06-28 08:55:05'],
            ['key' => 'reviews','value' => '{"name": "Jane Doe", "image": "/uploads/1/22/06/62b9a182884d52706221656332674.jpg", "rating": "4", "comment": "Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto cupiditate molestias sunt,\\r\\n                                ea id veritatis fugit quam blanditiis rerum reprehenderit maxime expedita odit,\\r\\n                                laboriosam voluptatibus? Iure corporis nulla eveniet quam.", "position": "Developer"}','lang' => 'en','status' => '1','created_at' => '2022-06-28 08:57:59','updated_at' => '2022-06-28 08:58:41'],
            ['key' => 'reviews','value' => '{"name": "Jhone Doe", "image": "/uploads/1/22/06/62b9a182e4da02706221656332674.jpg", "rating": "1", "comment": "Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto cupiditate molestias sunt,\\r\\n                                ea id veritatis fugit quam blanditiis rerum reprehenderit maxime expedita odit,\\r\\n                                laboriosam voluptatibus? Iure corporis nulla eveniet quam.", "position": "Developer"}','lang' => 'en','status' => '1','created_at' => '2022-06-28 08:55:05','updated_at' => '2022-06-28 08:55:05'],
            ['key' => 'reviews','value' => '{"name": "Jane Doe", "image": "/uploads/1/22/06/62b9a182884d52706221656332674.jpg", "rating": "4", "comment": "Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto cupiditate molestias sunt,\\r\\n                                ea id veritatis fugit quam blanditiis rerum reprehenderit maxime expedita odit,\\r\\n                                laboriosam voluptatibus? Iure corporis nulla eveniet quam.", "position": "Developer"}','lang' => 'en','status' => '1','created_at' => '2022-06-28 08:57:59','updated_at' => '2022-06-28 08:58:41'],
            ['key' => 'our_services','value' => '{"icon": "fas fa-tags", "title": "Coupons & Discounts", "description": "Create unique discount codes for sales, promotions, or affiliates."}','lang' => 'en','status' => '1','created_at' => '2022-06-28 16:09:53','updated_at' => '2022-06-28 16:14:11'],
            ['key' => 'our_services','value' => '{"icon": "far fa-file-archive", "title": "File Protection", "description": "Create unique discount codes for sales, promotions, or affiliates."}','lang' => 'en','status' => '1','created_at' => '2022-06-28 16:10:10','updated_at' => '2022-06-28 16:10:10'],
            ['key' => 'our_services','value' => '{"icon": "fab fa-simplybuilt", "title": "Simple Analytics", "description": "Create unique discount codes for sales, promotions, or affiliates."}','lang' => 'en','status' => '1','created_at' => '2022-06-28 16:11:23','updated_at' => '2022-06-28 16:11:23'],
            ['key' => 'our_services','value' => '{"icon": "fas fa-car-side", "title": "Automatic Delivery", "description": "Create unique discount codes for sales, promotions, or affiliates."}','lang' => 'en','status' => '1','created_at' => '2022-06-28 16:11:23','updated_at' => '2022-06-28 16:11:23'],
            ['key' => 'our_services','value' => '{"icon": "fas fa-map-marked-alt", "title": "Integrations", "description": "Create unique discount codes for sales, promotions, or affiliates."}','lang' => 'en','status' => '1','created_at' => '2022-06-28 16:10:29','updated_at' => '2022-06-28 16:10:29'],
            ['key' => 'our_services','value' => '{"icon": "fab fa-aws", "title": "No Website Needed", "description": "Create unique discount codes for sales, promotions, or affiliates."}','lang' => 'en','status' => '1','created_at' => '2022-06-28 16:10:49','updated_at' => '2022-06-28 16:10:49'],
            ['key' => 'our_services','value' => '{"icon": "fas fa-file-csv", "title": "Customer CSV Export", "description": "Create unique discount codes for sales, promotions, or affiliates."}','lang' => 'en','status' => '1','created_at' => '2022-06-28 16:11:14','updated_at' => '2022-06-28 16:11:14'],
            ['key' => 'our_services','value' => '{"icon": "fas fa-fill-drip", "title": "Custom Colors", "description": "Create unique discount codes for sales, promotions, or affiliates."}','lang' => 'en','status' => '1','created_at' => '2022-06-28 16:11:23','updated_at' => '2022-06-28 16:11:23'],
        ];


        Category::insert($categories);
    }
}
