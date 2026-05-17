<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Chạy tất cả seeder theo thứ tự đúng
     * (Phải tạo User và Category trước, sau đó mới tạo Post)
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,      // 1. Tạo user trước
            CategorySeeder::class,  // 2. Tạo danh mục
            PostSeeder::class,      // 3. Tạo bài viết (cần user_id và category_id)
        ]);
    }
}
