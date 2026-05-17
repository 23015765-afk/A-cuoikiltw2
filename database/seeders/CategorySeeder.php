<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Kinh nghiệm du lịch',
                'slug'        => 'kinh-nghiem-du-lich',
                'description' => 'Những kinh nghiệm quý báu từ các chuyến đi thực tế',
                'icon'        => 'bi-lightbulb',
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Ẩm thực',
                'slug'        => 'am-thuc',
                'description' => 'Khám phá ẩm thực địa phương đặc sắc',
                'icon'        => 'bi-cup-hot',
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Khách sạn & Lưu trú',
                'slug'        => 'khach-san-luu-tru',
                'description' => 'Đánh giá và gợi ý chỗ nghỉ ngơi tốt nhất',
                'icon'        => 'bi-building',
                'sort_order'  => 3,
            ],
            [
                'name'        => 'Địa điểm đẹp',
                'slug'        => 'dia-diem-dep',
                'description' => 'Những điểm đến không thể bỏ qua',
                'icon'        => 'bi-geo-alt',
                'sort_order'  => 4,
            ],
            [
                'name'        => 'Phượt',
                'slug'        => 'phuot',
                'description' => 'Hành trình khám phá bằng xe máy, xe đạp',
                'icon'        => 'bi-bicycle',
                'sort_order'  => 5,
            ],
            [
                'name'        => 'Mua sắm',
                'slug'        => 'mua-sam',
                'description' => 'Đặc sản và quà lưu niệm từ các vùng đất',
                'icon'        => 'bi-bag',
                'sort_order'  => 6,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
